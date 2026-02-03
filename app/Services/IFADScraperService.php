<?php

namespace App\Services;

use App\Models\Offre;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class IFADScraperService implements IterativeScraperInterface
{
    private const BASE_URL = 'https://www.ifad.org/fr/liste-des-projets';

    private ?string $jobId = null;
    private bool $isExhausted = false;

    public function setJobId(?string $jobId): void
    {
        $this->jobId = $jobId;
    }

    public function initialize(): void
    {
        $this->isExhausted = false;
    }

    public function reset(): void
    {
        $this->isExhausted = false;
    }

    public function scrapeBatch(int $limit = 10): array
    {
        if ($this->isExhausted) {
            return ['count' => 0, 'has_more' => false, 'findings' => []];
        }

        Log::info('IFAD Scraper: Début du scraping via Browsershot');

        $findings = [];
        $insertedCount = 0;

        try {
            // Using Browsershot to bypass Cloudflare and render JS
            $html = Browsershot::url(self::BASE_URL)
                ->setChromePath('/usr/bin/google-chrome')
                ->ignoreHttpsErrors()
                ->noSandbox()
                ->waitUntilNetworkIdle()
                ->timeout(120)
                ->userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                ->bodyHtml();

            // Check if we are blocked
            if (strpos($html, 'Just a moment') !== false || strpos($html, '_cf_chl_opt') !== false) {
                Log::error('IFAD Scraper: Cloudflare challenge detected.');
                $this->isExhausted = true;
                return ['count' => 0, 'has_more' => false, 'findings' => []];
            }

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Target the "Ongoing" tab (En cours) -> tabPanel4-shsf
            // Or just the active tab
            $activeTab = $xpath->query("//div[@role='tabpanel' and @id='tabPanel4-shsf']")->item(0);

            if (!$activeTab) {
                // Fallback: try to find any active tab
                 $activeTab = $xpath->query("//div[@role='tabpanel' and not(contains(@class, 'd-none'))]")->item(0);
            }

            if (!$activeTab) {
                Log::warning('IFAD Scraper: No active tab found.');
                $this->isExhausted = true;
                return ['count' => 0, 'has_more' => false, 'findings' => []];
            }

            // Find rows containing a project link
            // Structure: Row -> Col-6 (Link/Title) + Col-2 (Num) + Col-2 (Country) + Col-2 (Date)
            $rows = $xpath->query(".//div[contains(@class, 'row')][.//a[contains(@href, '/projects/')]]", $activeTab);
            
            Log::info('IFAD Scraper: Rows found', ['count' => $rows->length]);

            foreach ($rows as $row) {
                try {
                    $offre = $this->extractOffreData($row, $xpath);

                    if (!$offre || empty($offre['titre']) || empty($offre['lien_source']))
                        continue;

                    // Ensure unique constraint validation
                    if ($this->saveOffre($offre)) {
                        $insertedCount++;
                    }
                    $findings[] = $offre;

                    if (count($findings) >= $limit) break;

                } catch (\Exception $e) {
                    continue;
                }
            }

            // With Browsershot and no easy pagination URL, we just scrape the first page (top 20)
            // effective for daily updates.
            $this->isExhausted = true;

            return [
                'count' => $insertedCount,
                'has_more' => false, 
                'findings' => $findings,
            ];

        } catch (\Exception $e) {
            Log::error('IFAD Scraper: Exception', ['error' => $e->getMessage()]);
            $this->isExhausted = true;
            return ['count' => 0, 'has_more' => false, 'findings' => []];
        }
    }

    private function saveOffre(array $offreData): bool
    {
        try {
            $exists = Offre::where('source', 'IFAD')
                ->where('lien_source', $offreData['lien_source'])
                ->exists();

            if (!$exists) {
                Offre::insert($offreData);
                return true;
            } else {
                 Offre::where('source', 'IFAD')
                    ->where('lien_source', $offreData['lien_source'])
                    ->update([
                        'updated_at' => now(),
                        // Update date if we found one now and didn't before
                        'date_limite_soumission' => $offreData['date_limite_soumission'] ?? null
                    ]);
            }
        } catch (\Exception $e) {
            Log::error('IFAD Scraper: DB Error', ['error' => $e->getMessage()]);
        }
        return false;
    }

    private function extractOffreData(\DOMNode $row, DOMXPath $xpath): ?array
    {
        // 1. Link and Title (Col-6)
        $linkNode = $xpath->query(".//div[contains(@class, 'col') and contains(@class, 'col-lg-6')]//a", $row)->item(0);
        if (!$linkNode) return null;

        $link = $linkNode->getAttribute('href');
        $titre = trim($linkNode->textContent);

        // 2. Country (Col-2, usually the 3rd column in the layout: Title | Num | Country | Date)
        // Let's verify columns by text content or position
        
        $pays = null;
        $date = null;

        // Get all col-lg-2 strings
        $cols = $xpath->query(".//div[contains(@class, 'col') and contains(@class, 'col-lg-2')]", $row);
        
        // Assuming:
        // Item 0: Project Number (e.g. 2000005031)
        // Item 1: Country (e.g. Inde)
        // Item 2: Date (e.g. 29 décembre 2021)

        if ($cols->length >= 2) {
             $countryNode = $cols->item(1);
             $pays = trim($countryNode->textContent);
        }

        if ($cols->length >= 3) {
             $dateNode = $cols->item(2);
             $dateStr = trim($dateNode->textContent);
             if (!empty($dateStr)) {
                 $date = $this->parseDate($dateStr);
             }
        }

        return [
            'titre' => $this->cleanTitle($titre),
            'acheteur' => 'IFAD',
            'pays' => $pays ?? 'International',
            'date_limite_soumission' => $date, // Using approval date as a reference date
            'lien_source' => $link,
            'source' => 'IFAD',
            'detail_url' => $link,
            'link_type' => 'detail',
            'notice_type' => 'Projet',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function parseDate(string $dateStr): ?string
    {
        $dateStr = trim($dateStr);
        if (empty($dateStr)) return null;

        try {
            // French date mapping
            $months = [
                'janvier' => '01', 'février' => '02', 'mars' => '03', 'avril' => '04', 
                'mai' => '05', 'juin' => '06', 'juillet' => '07', 'août' => '08', 
                'septembre' => '09', 'octobre' => '10', 'novembre' => '11', 'décembre' => '12',
            ];
            
            $dateStrLower = strtolower($dateStr);
            foreach ($months as $fr => $en) {
                if (strpos($dateStrLower, $fr) !== false) {
                    $dateStrLower = str_replace($fr, $en, $dateStrLower);
                    $parts = preg_split('/[\s-]+/', $dateStrLower);
                    if (count($parts) >= 3) {
                         $day = str_pad((int)$parts[0], 2, '0', STR_PAD_LEFT);
                         $month = str_pad((int)$parts[1], 2, '0', STR_PAD_LEFT);
                         $year = (int)$parts[2];
                         return "$year-$month-$day";
                    }
                }
            }
            return \Carbon\Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
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

    /**
     * Lance le scraping de tous les appels d'offres
     */
    public function scrape(): array
    {
        $this->initialize();
        return $this->scrapeBatch(50);
    }
}
