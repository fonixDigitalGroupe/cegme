<?php

namespace App\Services;

use App\Models\Offre;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use App\Services\MarketTypeClassifier;

class IFADScraperService implements IterativeScraperInterface
{
    private const BASE_URL = 'https://www.ifad.org/fr/appels-a-proposition';

    private int $currentPage = 0;
    private array $pendingOffers = [];
    private bool $isExhausted = false;

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

    public function scrapeBatch(int $limit = 10): array
    {
        Log::info("IFAD Scraper: Début scrapeBatch(limit=$limit)");
        $insertedCount = 0;
        $findings = [];
        $maxPages = max(1, min((int) env('IFAD_MAX_PAGES', 10), 10));

        // 1. Servir les offres en attente si présentes
        if (!empty($this->pendingOffers)) {
            Log::info("IFAD Scraper: Serving " . min(count($this->pendingOffers), $limit) . " pending offers.");
            $batch = array_splice($this->pendingOffers, 0, $limit);
            foreach ($batch as $offre) {
                if ($this->saveOffre($offre)) {
                    $insertedCount++;
                }
                $findings[] = $offre;
            }
            return [
                'count' => $insertedCount,
                'has_more' => !empty($this->pendingOffers) || ($this->currentPage < $maxPages && !$this->isExhausted),
                'findings' => $findings,
            ];
        }

        if ($this->isExhausted) {
            return ['count' => 0, 'has_more' => false, 'findings' => []];
        }

        // 2. Scrapper une nouvelle page tant qu'on n'a pas rempli le batch
        // USER REQUEST: parcourie 10 page aux maxe

        while (count($findings) < $limit && $this->currentPage < $maxPages && !$this->isExhausted) {
            
            $url = self::BASE_URL;
            if ($this->currentPage >= 0) {
                $cur = $this->currentPage + 1;
                $url .= (strpos($url, '?') === false ? '?' : '&') . "_com_ifad_portal_portlet_search_results_SearchResultsPortlet_cur={$cur}&_com_ifad_portal_portlet_search_results_SearchResultsPortlet_delta=100";
            }

            Log::info("IFAD Scraper: Fetching Page " . ($this->currentPage + 1) . " - " . $url);

            try {
                // Increase timeout and add wait for dynamic content
                $html = Browsershot::url($url)
                    ->setChromePath('/usr/bin/google-chrome')
                    ->setNodeBinary('/usr/bin/node')
                    ->ignoreHttpsErrors()
                    ->noSandbox()
                    ->waitUntilNetworkIdle()
                    ->waitForSelector('.general-feature-card') 
                    ->timeout(240)
                    ->userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->bodyHtml();

                $dom = new DOMDocument();
                libxml_use_internal_errors(true);
                @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
                libxml_clear_errors();
                $xpath = new DOMXPath($dom);
                
                $rows = $xpath->query("//div[contains(@class, 'general-feature-card')]");
                Log::info("IFAD Scraper: Cards found on Page " . ($this->currentPage + 1) . ": " . $rows->length);

                if ($rows->length === 0) {
                    Log::info("IFAD Scraper: No cards found on page " . ($this->currentPage + 1) . ". Marking as exhausted.");
                    $this->isExhausted = true;
                    break;
                }

                $pageOffers = [];
                foreach ($rows as $row) {
                    $offre = $this->extractOffreData($row, $xpath);
                    if ($offre && !empty($offre['titre']) && !empty($offre['lien_source'])) {
                        $pageOffers[] = $offre;
                    } else {
                        Log::debug("IFAD Scraper: Skipping invalid/empty offer data.");
                    }
                }

                if (empty($pageOffers)) {
                    Log::info("IFAD Scraper: All offers on page " . ($this->currentPage + 1) . " were invalid. Marking as exhausted.");
                    $this->isExhausted = true;
                    break;
                }

                $this->pendingOffers = array_merge($this->pendingOffers, $pageOffers);
                $this->currentPage++;

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

            } catch (\Exception $e) {
                Log::error('IFAD Scraper: Error on page ' . ($this->currentPage + 1), ['error' => $e->getMessage()]);
                $this->isExhausted = true;
                break;
            }
        }

        return [
            'count' => $insertedCount,
            'has_more' => !empty($this->pendingOffers) || ($this->currentPage < $maxPages && !$this->isExhausted),
            'findings' => $findings,
        ];
    }

    private function saveOffre(array $offreData): bool
    {
        try {
            $exists = Offre::where('source', 'IFAD')
                ->where('lien_source', $offreData['lien_source'])
                ->exists();

            if (!$exists) {
                Offre::insert($offreData);
                Log::info("IFAD Scraper: Inserted new offer: " . $offreData['titre']);
                return true;
            } else {
                 Offre::where('source', 'IFAD')
                    ->where('lien_source', $offreData['lien_source'])
                    ->update([
                        'updated_at' => now(),
                        'date_limite_soumission' => $offreData['date_limite_soumission'] ?? null,
                        'date_publication' => $offreData['date_publication'] ?? null,
                    ]);
                 Log::debug("IFAD Scraper: Updated existing offer: " . $offreData['titre']);
            }
        } catch (\Exception $e) {
            Log::error('IFAD Scraper: DB Error', ['error' => $e->getMessage()]);
        }
        return false;
    }

    private function extractOffreData(\DOMNode $row, DOMXPath $xpath): ?array
    {
        // TITRE & LIEN
        // Essayer d'abord la structure "general-feature-card" (Appels à propositions)
        // .article-content .title
        $titre = null;
        $link = null;

        $titleNode = $xpath->query(".//p[contains(@class, 'title')]", $row)->item(0);
        if (!$titleNode) {
            $titleNode = $xpath->query(".//a", $row)->item(0);
        }
        
        if ($titleNode) {
            $titre = trim($titleNode->textContent);
        }

        $linkNode = $xpath->query(".//div[contains(@class, 'article-content')]//a", $row)->item(0);
        if (!$linkNode) {
            $linkNode = $xpath->query(".//a", $row)->item(0);
        }
        
        if ($linkNode) {
            $link = $linkNode->getAttribute('href');
        }

        // Fallback: ancienne structure (si row générique)
        if (!$titre || !$link) {
            $linkNode = $xpath->query(".//a", $row)->item(0);
            if ($linkNode) {
                $link = $linkNode->getAttribute('href');
                if (!$titre) {
                    $titre = trim($linkNode->textContent);
                }
            }
        }

        if (!$link) return null;

        // DATES
        $datePublication = null;
        $dateLimite = null;
        
        $metadataNodes = $xpath->query(".//div[contains(@class, 'article-metadata')]/p", $row);
        foreach ($metadataNodes as $node) {
            $text = trim($node->textContent);
            if (stripos($text, 'Publié le') !== false || stripos($text, 'Posted on') !== false) {
                $datePublication = $this->parseDate(preg_replace('/(Publié le|Posted on|:)/i', '', $text));
            }
            if (stripos($text, 'Date limite') !== false || stripos($text, 'Deadline') !== false || stripos($text, 'Closing date') !== false) {
                $dateLimite = $this->parseDate(preg_replace('/(Date limite|Deadline|Closing date|:)/i', '', $text));
            }
        }

        // Fallback: si une seule date est présente sans label explicite
        if (!$datePublication && !$dateLimite) {
            $dateNode = $xpath->query(".//div[contains(@class, 'article-metadata')]/p[last()]", $row)->item(0);
            if ($dateNode) {
                $dateStr = trim($dateNode->textContent);
                if (preg_match('/\d/', $dateStr)) {
                    $datePublication = $this->parseDate($dateStr);
                }
            }
        }

        return [
            'titre' => $this->cleanTitle($titre ?? 'Sans titre'),
            'acheteur' => 'IFAD',
            'pays' => 'International',
            'date_limite_soumission' => $dateLimite,
            'date_publication' => $datePublication,
            'lien_source' => $link,
            'source' => 'IFAD',
            'detail_url' => $link,
            'link_type' => 'detail',
            'notice_type' => 'Appel à propositions',
            'market_type' => MarketTypeClassifier::classify($this->cleanTitle($titre ?? '')),
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
        // Nettoyage des espaces et sauts de ligne
        $clean = trim(preg_replace('/\s+/', ' ', $titre));
        
        // Conversion explicite en UTF-8 pour éviter les erreurs SQL sur les caractères bizarres
        $clean = mb_convert_encoding($clean, 'UTF-8', 'UTF-8');
        
        // Troncature à 250 caractères
        if (mb_strlen($clean) > 250) {
            return mb_substr($clean, 0, 247) . '...';
        }
        return $clean;
    }

    /**
     * Scrape les détails d'un projet pour trouver la date de fin
     */
    private function scrapeProjectDetails(string $url): array
    {
        try {
            // Petit délai pour éviter de surcharger
            usleep(500000); // 0.5s

            $html = Browsershot::url($url)
                ->setChromePath('/usr/bin/google-chrome')
                ->setNodeBinary('/usr/bin/node')
                ->ignoreHttpsErrors()
                ->noSandbox()
                ->setOption('args', [
                    '--disable-blink-features=AutomationControlled',
                    '--no-sandbox',
                    '--disable-setuid-sandbox',
                ])
                ->setExtraHttpHeaders(['Referer' => self::BASE_URL])
                ->waitUntilNetworkIdle()
                ->timeout(90)
                ->bodyHtml();
            
            // Save debug HTML for the first one
            if (!file_exists(storage_path('logs/debug_ifad_detail.html'))) {
                file_put_contents(storage_path('logs/debug_ifad_detail.html'), $html);
                Log::info('IFAD Detail Scraper: Saved debug HTML');
            }

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            $dateFin = null;

            // Debug log
            Log::info('IFAD Detail Scraper: Visiting ' . $url);

            // Chercher "Duration" ou "Durée"
            // Texte contenant "Duration" ou "Durée"
            $durationNodes = $xpath->query("//*[contains(text(), 'Duration') or contains(text(), 'Durée')]");
            
            if ($durationNodes->length > 0) {
                // Chercher dans le parent ou les frères
                foreach ($durationNodes as $node) {
                    $context = $node->parentNode->textContent;
                    // Format: 2018 - 2025
                    if (preg_match('/(\d{4})\s*-\s*(\d{4})/', $context, $matches)) {
                        $endYear = $matches[2];
                        $dateFin = "$endYear-12-31";
                        Log::info('IFAD Detail Scraper: Found duration end year ' . $endYear);
                        break;
                    }
                }
            }

            // Si pas de Duration, chercher "Approval Date" ou "Date d'approbation"
            if (!$dateFin) {
                // Utilisation de guillemets doubles pour le texte XPath contenant une apostrophe
                $approvalNodes = $xpath->query('//*[contains(text(), "Approval Date") or contains(text(), "Date d\'approbation")]');
                if ($approvalNodes && $approvalNodes->length > 0) {
                     foreach ($approvalNodes as $node) {
                        $context = $node->parentNode->textContent;
                        // Extraire une date... bon c'est un peu complexe sans regex précise
                        // On log juste pour l'instant
                        Log::info('IFAD Detail Scraper: Found Approval Date context - ' . trim(substr($context, 0, 50)));
                     }
                }
            }

            // Si pas de Duration, chercher "Approval Date" + une durée par défaut ? 
            // Pour l'instant on se contente de Duration.

            return [
                'date_fin' => $dateFin
            ];

        } catch (\Exception $e) {
            Log::warning('IFAD Detail Scraper Error', ['url' => $url, 'error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Lance le scraping de tous les appels d'offres
     */
    public function scrape(): array
    {
        $this->initialize();
        $totalCount = 0;
        
        while (true) {
            $batch = $this->scrapeBatch(50);
            $totalCount += $batch['count'];
            if (!$batch['has_more']) break;
        }

        return [
            'count' => $totalCount,
            'stats' => [
                'total_notices_kept' => $totalCount,
                'total_pages_scraped' => $this->currentPage
            ]
        ];
    }
}
