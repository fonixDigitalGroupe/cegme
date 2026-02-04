<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WorldBankScraperService implements IterativeScraperInterface
{
    private const API_URL = 'https://search.worldbank.org/api/v2/procnotices';
    private const BASE_PROCUREMENT_URL = 'https://projects.worldbank.org/en/projects-operations/procurement';

    private ?string $jobId = null;
    private int $currentOffset = 0;
    private bool $isExhausted = false;
    private array $pendingOffers = [];
    private int $totalNoticesFound = 0;
    private int $totalNoticesKept = 0;
    private int $totalPagesScraped = 0;

    public function setJobId(?string $jobId): void
    {
        $this->jobId = $jobId;
    }

    public function initialize(): void
    {
        $this->currentOffset = 0;
        $this->isExhausted = false;
        $this->pendingOffers = [];
        $this->totalNoticesFound = 0;
        $this->totalNoticesKept = 0;
        $this->totalPagesScraped = 0;
    }

    public function reset(): void
    {
        $this->initialize();
    }

    public function scrapeBatch(int $limit = 10): array
    {
        if ($this->isExhausted) {
            return ['count' => 0, 'has_more' => false, 'findings' => []];
        }

        Log::info('World Bank Scraper: Starting batch', ['offset' => $this->currentOffset, 'limit' => $limit]);

        $findings = [];
        $insertedCount = 0;

        // Serve pending offers first
        if (!empty($this->pendingOffers)) {
            $batch = array_splice($this->pendingOffers, 0, $limit);
            foreach ($batch as $offre) {
                if ($this->saveOffre($offre)) {
                    $insertedCount++;
                    $this->totalNoticesKept++;
                }
                $findings[] = $offre;
            }

            if (count($findings) >= $limit) {
                return [
                    'count' => $insertedCount,
                    'has_more' => !$this->isExhausted || !empty($this->pendingOffers),
                    'findings' => $findings,
                ];
            }
        }

        // Fetch new data from API
        while (count($findings) < $limit && !$this->isExhausted) {
            try {
                $result = $this->fetchApiPage($this->currentOffset, 20);
                $this->totalPagesScraped++;

                if (empty($result['offers'])) {
                    $this->isExhausted = true;
                    break;
                }

                $this->totalNoticesFound += count($result['offers']);

                foreach ($result['offers'] as $offre) {
                    if (count($findings) >= $limit) {
                        $this->pendingOffers[] = $offre;
                    } else {
                        if ($this->saveOffre($offre)) {
                            $insertedCount++;
                            $this->totalNoticesKept++;
                        }
                        $findings[] = $offre;
                    }
                }

                $this->currentOffset += 20;

                if (!$result['has_more']) {
                    $this->isExhausted = true;
                    break;
                }

            } catch (\Exception $e) {
                Log::error('World Bank Scraper: API fetch error', [
                    'offset' => $this->currentOffset,
                    'error' => $e->getMessage()
                ]);
                $this->isExhausted = true;
                break;
            }
        }

        Log::info('World Bank Scraper: Batch finished', [
            'processed' => $insertedCount,
            'new_count' => $insertedCount,
            'findings_count' => count($findings),
            'has_more' => !$this->isExhausted || !empty($this->pendingOffers)
        ]);

        return [
            'count' => $insertedCount,
            'has_more' => !$this->isExhausted || !empty($this->pendingOffers),
            'findings' => $findings,
        ];
    }

    private function fetchApiPage(int $offset, int $rows): array
    {
        $params = [
            'format' => 'json',
            'fct' => 'procurement_group_desc_exact,notice_type_exact,project_ctry_name_exact,regionname_exact',
            'fl' => 'id,bid_description,project_ctry_name,project_name,notice_type,notice_status,submission_date,noticedate,project_id,notice_url,submission_deadline_date',
            'os' => $offset,
            'srt' => 'submission_date desc,id asc',
            'apilang' => 'fr',
            'rows' => $rows,
        ];

        $url = self::API_URL . '?' . http_build_query($params);

        Log::debug('World Bank Scraper: Fetching API page', ['url' => $url, 'offset' => $offset]);

        $response = Http::timeout(30)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept' => 'application/json',
            ])
            ->get($url);

        if (!$response->successful()) {
            Log::error('World Bank Scraper: API request failed', [
                'status' => $response->status(),
                'url' => $url
            ]);
            return ['offers' => [], 'has_more' => false];
        }

        $data = $response->json();

        if (!isset($data['procnotices']) || empty($data['procnotices'])) {
            return ['offers' => [], 'has_more' => false];
        }

        $offers = [];
        foreach ($data['procnotices'] as $doc) {
            $offre = $this->extractOffreFromApiDocument($doc);
            if ($offre) {
                $offers[] = $offre;
            }
        }

        $total = $data['total'] ?? 0;
        $hasMore = ($offset + $rows) < $total;

        return ['offers' => $offers, 'has_more' => $hasMore];
    }

    private function extractOffreFromApiDocument(array $doc): ?array
    {
        try {
            // Extract title components
            $bidDescription = $doc['bid_description'] ?? null;
            $projectName = $doc['project_name'] ?? null;
            $projectId = $doc['project_id'] ?? null;

            if (!$bidDescription || strlen(trim($bidDescription)) < 5) {
                return null;
            }

            // Construct title as "Project Name (Project ID) - Bid Description"
            $titreParts = [];
            if ($projectName) {
                $titreParts[] = $projectName;
            }
            if ($projectId) {
                $titreParts[] = "($projectId)";
            }
            
            $titreBase = implode(' ', $titreParts);
            $titreComplet = $titreBase ? "$titreBase - $bidDescription" : $bidDescription;

            // Extract country
            $pays = null;
            if (isset($doc['project_ctry_name'])) {
                if (is_array($doc['project_ctry_name'])) {
                    $pays = implode(', ', $doc['project_ctry_name']);
                } else {
                    $pays = $doc['project_ctry_name'];
                }
            }

            // Extract dates
            $datePublication = null;
            if (isset($doc['noticedate']) && !empty($doc['noticedate'])) {
                $datePublication = $this->normalizeDateString($doc['noticedate']);
            }

            $dateLimite = null;
            if (isset($doc['submission_deadline_date']) && !empty($doc['submission_deadline_date'])) {
                $dateLimite = $this->normalizeDateString($doc['submission_deadline_date']);
            }

            // Determine link (French portal URL)
            $id = $doc['id'] ?? null;
            if (!$id) {
                return null;
            }

            $lien = "https://projects.banquemondiale.org/fr/projects-operations/procurement-detail/$id";

            return [
                'titre' => $this->cleanTitle($titreComplet),
                'acheteur' => 'World Bank',
                'pays' => $pays ?? 'International',
                'date_limite_soumission' => $dateLimite,
                'lien_source' => $lien,
                'source' => 'World Bank',
                'detail_url' => $lien,
                'link_type' => 'detail',
                'notice_type' => $doc['notice_type'] ?? 'Avis de passation de marchés',
                'project_id' => $projectId,
                'date_publication' => $datePublication,
                'created_at' => now(),
                'updated_at' => now(),
            ];

        } catch (\Exception $e) {
            Log::debug('World Bank Scraper: Failed to extract offer', [
                'error' => $e->getMessage(),
                'doc_id' => $doc['id'] ?? 'unknown'
            ]);
            return null;
        }
    }

    private function normalizeDateString(string $dateStr): ?string
    {
        $dateStr = trim($dateStr);
        if (empty($dateStr)) {
            return null;
        }

        try {
            // API returns dates in format: "2025-01-15T00:00:00Z" or "January 15, 2025"
            $date = \Carbon\Carbon::parse($dateStr);
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            Log::debug('World Bank Scraper: Failed to parse date', [
                'date_str' => $dateStr,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    private function cleanTitle(string $titre): string
    {
        $clean = trim(preg_replace('/\s+/', ' ', $titre));
        if (strlen($clean) > 250) {
            return substr($clean, 0, 247) . '...';
        }
        return $clean;
    }

    private function saveOffre(array $offreData): bool
    {
        try {
            $exists = Offre::where('source', 'World Bank')
                ->where('lien_source', $offreData['lien_source'])
                ->exists();

            if (!$exists) {
                Offre::insert($offreData);
                return true;
            } else {
                Offre::where('source', 'World Bank')
                    ->where('lien_source', $offreData['lien_source'])
                    ->update([
                        'updated_at' => now(),
                        'date_limite_soumission' => $offreData['date_limite_soumission'] ?? null,
                        'date_publication' => $offreData['date_publication'] ?? null,
                    ]);
            }
        } catch (\Exception $e) {
            Log::error('World Bank Scraper: DB Error', ['error' => $e->getMessage()]);
        }
        return false;
    }

    /**
     * Legacy scrape method for compatibility
     */
    public function scrape(): array
    {
        $this->initialize();
        $batch = $this->scrapeBatch(100); // Scrape up to 100 in one full run

        return [
            'count' => $batch['count'],
            'stats' => [
                'total_pages_scraped' => $this->totalPagesScraped,
                'total_notices_found' => $this->totalNoticesFound,
                'total_notices_kept' => $this->totalNoticesKept,
                'total_notices_excluded' => $this->totalNoticesFound - $this->totalNoticesKept,
            ]
        ];
    }
}
