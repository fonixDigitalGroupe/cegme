<?php

namespace App\Services;

use App\Models\Offre;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\MarketTypeClassifier;

class BDEACScraperService implements IterativeScraperInterface
{
    private const BASE_URL = 'https://www.bdeac.org/jcms/rh_30762/appels-d-offres';
    private const MAX_PAGES = 50;

    private ?string $jobId = null;
    private int $currentPage = 0;
    private bool $isExhausted = false;
    private array $pendingOffers = [];

    public function setJobId(?string $jobId): void
    {
        $this->jobId = $jobId;
    }

    public function initialize(): void
    {
        $this->currentPage = 0;
        $this->isExhausted = false;
        $this->pendingOffers = [];
    }

    public function reset(): void
    {
        $this->initialize();
    }

    /**
     * Scrappe un lot d'offres (mode itératif)
     */
    public function scrapeBatch(int $limit = 10): array
    {
        Log::info("BDEAC Scraper: Début scrapeBatch(limit=$limit)");
        $insertedCount = 0;
        $findings = [];

        // 1. Servir les offres en attente si présentes
        if (!empty($this->pendingOffers)) {
            $batch = array_splice($this->pendingOffers, 0, $limit);
            foreach ($batch as $offre) {
                if ($this->saveOffre($offre)) {
                    $insertedCount++;
                }
                $findings[] = $offre;
            }
            return [
                'count' => $insertedCount,
                'has_more' => !empty($this->pendingOffers) || !$this->isExhausted,
                'findings' => $findings,
            ];
        }

        if ($this->isExhausted) {
            return ['count' => 0, 'has_more' => false, 'findings' => []];
        }

        // 2. Scrapper une nouvelle page tant qu'on n'a pas rempli le batch
        while (count($findings) < $limit && !$this->isExhausted) {
            
            $result = $this->scrapePageForBatch($this->currentPage);
            $offersFound = $result['offers'];

            if (empty($offersFound)) {
                $this->isExhausted = true;
                break;
            }

            // Mettre en attente les offres trouvées
            $this->pendingOffers = array_merge($this->pendingOffers, $offersFound);
            $this->currentPage++;

            // Arrêter si on a atteint le maximum de pages configuré
            $maxPages = max(1, min((int) env('BDEAC_MAX_PAGES', 5), self::MAX_PAGES));
            if ($this->currentPage >= $maxPages) {
                $this->isExhausted = true;
            }
            
            // Servir ce qu'on peut
            $needed = $limit - count($findings);
            if ($needed > 0 && !empty($this->pendingOffers)) {
                $batch = array_splice($this->pendingOffers, 0, $needed);
                foreach ($batch as $offre) {
                    if ($this->saveOffre($offre)) {
                        $insertedCount++;
                    }
                    $findings[] = $offre;
                }
            }
        }

        return [
            'count' => $insertedCount,
            'has_more' => !empty($this->pendingOffers) || !$this->isExhausted,
            'findings' => $findings,
        ];
    }

    private function saveOffre(array $offreData): bool
    {
        try {
            $exists = Offre::where('source', 'BDEAC')
                ->where(function ($query) use ($offreData) {
                    $query->where('lien_source', $offreData['lien_source'])
                        ->orWhere('titre', $offreData['titre']);
                })
                ->exists();

            if (!$exists) {
                $offreData['created_at'] = now();
                $offreData['updated_at'] = now();
                Offre::insert($offreData);
                return true;
            } else {
                // Update existing offer dates if needed
                Offre::where('source', 'BDEAC')
                    ->where('lien_source', $offreData['lien_source'])
                    ->update([
                        'date_limite_soumission' => $offreData['date_limite_soumission'] ?? null,
                        'updated_at' => now()
                    ]);
            }
        } catch (\Exception $e) {
            Log::error('BDEAC Scraper: Error saving offer', ['error' => $e->getMessage()]);
        }
        return false;
    }

    private function scrapePageForBatch(int $page): array
    {
        $offers = [];
        $html = '';

        try {
            // Pagination: BDEAC usually uses "start" parameter. 
            // 0, 10, 20... assuming 10 items per page.
            $url = self::BASE_URL;
            if ($page > 0) {
                 $start = $page * 10; 
                 $url .= '?start=' . $start;
            }

            Log::debug('BDEAC Scraper: Fetching page', ['page' => $page, 'url' => $url]);

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                ])
                ->get($url);

            if (!$response->successful()) {
                Log::error('BDEAC Scraper: Failed to fetch page', ['status' => $response->status()]);
                return ['offers' => [], 'html' => ''];
            }

            $html = $response->body();
            
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            // Hack to handle encoding properly
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Extraction des items
            $items = $xpath->query("//div[contains(@class, 'BDEAC__actus-content') and contains(@class, 'BDEAC__appel-offre')]");
            
            Log::info('BDEAC Scraper: Items found in page', ['count' => $items->length, 'page' => $page]);

            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);

                    if (!$offre || empty($offre['titre']) || empty($offre['lien_source']))
                        continue;

                    if (!$this->validateUrl($offre['lien_source']))
                       continue;

                    $offers[] = $offre;
                } catch (\Exception $e) {
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error('BDEAC Scraper: Error in scrapePageForBatch', ['page' => $page, 'error' => $e->getMessage()]);
        }

        return ['offers' => $offers, 'html' => $html];
    }

    /**
     * Lance le scraping de tous les appels d'offres
     */
    public function scrape(): array
    {
        $this->initialize();
        $totalCount = 0;
        $maxPages = max(1, min((int) env('BDEAC_MAX_PAGES', 5), self::MAX_PAGES));

        for ($i = 0; $i < $maxPages; $i++) {
            $batch = $this->scrapeBatch(100);
            $totalCount += $batch['count'];
            if (!$batch['has_more'])
                break;
        }

        return [
            'count' => $totalCount,
            'stats' => ['total_notices_kept' => $totalCount]
        ];
    }

    private function extractOffreData(\DOMElement $item, DOMXPath $xpath): ?array
    {
        try {
            // Titre et Lien
            $titre = null;
            $lien = null;
            
            $titleNode = $xpath->query(".//div[contains(@class, 'BDEAC__actus-title')]//a", $item);
            if ($titleNode->length > 0) {
                $linkElement = $titleNode->item(0);
                $titre = trim($linkElement->textContent);
                $lien = $linkElement->getAttribute('href');
            } else {
                 Log::warning("BDEAC Scraper: No title found for item");
            }

            if (!$titre || !$lien) {
                Log::warning("BDEAC Scraper: Skipping item (missing title/link)", ['titre' => $titre, 'lien' => $lien]);
                return null;
            }

            // Dates
            $datePublication = null;
            $dateLimite = null;

            $dateNodes = $xpath->query(".//div[contains(@class, 'BDEAC__right-side')]//div", $item);
            foreach ($dateNodes as $node) {
                $text = trim($node->textContent);
                if (stripos($text, 'Publié') !== false) {
                    $datePublication = $this->parseDate(str_ireplace(['Publié', ':', 'le'], '', $text));
                }
                if (stripos($text, 'Clôture') !== false) {
                    $dateLimite = $this->parseDate(str_ireplace(['Clôture', ':', 'le'], '', $text));
                }
            }

            return [
                'titre' => $this->cleanTitle($titre),
                'acheteur' => 'BDEAC',
                'pays' => $this->detectCountry($titre),
                'date_limite_soumission' => $dateLimite, 
                'lien_source' => $this->normalizeUrl($lien),
                'source' => 'BDEAC',
                'detail_url' => $this->normalizeUrl($lien),
                'link_type' => 'detail',
                'notice_type' => 'Appel d\'offres', 
                'market_type' => MarketTypeClassifier::classify($titre),
                'updated_at' => now(), 
            ];

        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseDate(string $dateStr): ?string
    {
        $dateStr = trim($dateStr);
        if (empty($dateStr)) return null;

        try {
            // Format: 17 décembre 2025
            $months = [
                'janvier' => '01', 'février' => '02', 'mars' => '03', 'avril' => '04', 
                'mai' => '05', 'juin' => '06', 'juillet' => '07', 'août' => '08', 
                'septembre' => '09', 'octobre' => '10', 'novembre' => '11', 'décembre' => '12',
                'jan' => '01', 'fev' => '02', 'avr' => '04', 'jui' => '06', 'jul' => '07', 
                'aout' => '08', 'sep' => '09', 'oct' => '10', 'nov' => '11', 'dec' => '12',
                'january' => '01', 'february' => '02', 'march' => '03', 'april' => '04', 'may' => '05',
                'june' => '06', 'july' => '07', 'august' => '08', 'september' => '09', 'october' => '10',
                'november' => '11', 'december' => '12'
            ];
            
            $dateStrLower = strtolower($dateStr);
            foreach ($months as $name => $num) {
                if (strpos($dateStrLower, $name) !== false) {
                    // Replace month name with number
                    $dateStrLower = str_replace($name, $num, $dateStrLower);
                    
                    // Cleanup any extra chars (keep digits and spaces/dashes)
                    $clean = preg_replace('/[^\d\s\-\/]/', '', $dateStrLower);
                    $parts = preg_split('/[\s\-\/]+/', trim($clean));
                    
                    if (count($parts) >= 3) {
                         // Likely d m Y
                         $day = str_pad((int)$parts[0], 2, '0', STR_PAD_LEFT);
                         $month = str_pad((int)$parts[1], 2, '0', STR_PAD_LEFT);
                         $year = (int)$parts[2];
                         return "$year-$month-$day";
                    }
                }
            }
            
            // Fallback to Carbon
            return \Carbon\Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function normalizeUrl(string $url): string
    {
        if (empty($url)) return '';
        if (str_starts_with($url, 'http')) return $url;
        
        // Handle relative URLs
        $url = ltrim($url, '/');
        return 'https://www.bdeac.org/' . $url;
    }

    private function cleanTitle(string $titre): string
    {
        // Truncate to avoid database errors if too long, assuming 255 chars limit
        $clean = trim(preg_replace('/\s+/', ' ', $titre));
        if (strlen($clean) > 250) {
            return substr($clean, 0, 247) . '...';
        }
        return $clean;
    }

    private function validateUrl(string $url): bool 
    {
        return !empty($url) && filter_var($url, FILTER_VALIDATE_URL);
    }

    private function detectCountry(string $text): string
    {
        $countries = [
            'Cameroun', 'Congo', 'Gabon', 'Guinée équatoriale', 'Guinée Equatoriale', 'Centrafrique', 'République Centrafricaine', 'Tchad',
            'São Tomé', 'Sao Tome'
        ];
        foreach ($countries as $country) {
            if (stripos($text, $country) !== false) {
                // Normalize names
                if (stripos($country, 'Guinée') !== false) return 'Guinée équatoriale';
                if (stripos($country, 'Centrafrique') !== false) return 'République centrafricaine';
                if (stripos($country, 'Tome') !== false) return 'São Tomé-et-Príncipe';
                return $country;
            }
        }
        return 'Afrique Centrale';
    }
}
