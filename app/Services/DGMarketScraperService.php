<?php

namespace App\Services;

use App\Models\Offre;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DGMarketScraperService
{
    // URL de base pour les appels d'offres DGMarket
    private const BASE_URL = 'https://appel-d-offre.dgmarket.com';
    private const MAX_PAGES = 100;
    
    // Liste des pays africains pour le filtrage
    private const AFRICAN_COUNTRIES = [
        'Algeria', 'Angola', 'Benin', 'Botswana', 'Burkina Faso', 'Burundi',
        'Cameroon', 'Central African Republic', 'Chad', 'Comoros', 'Congo',
        'Côte d\'Ivoire', 'Djibouti', 'Egypt', 'Eritrea', 'Eswatini',
        'Ethiopia', 'Gabon', 'Gambia', 'Ghana', 'Guinea', 'Guinea-Bissau',
        'Kenya', 'Lesotho', 'Liberia', 'Libya', 'Madagascar', 'Malawi',
        'Mali', 'Mauritania', 'Mauritius', 'Morocco', 'Mozambique', 'Namibia',
        'Niger', 'Nigeria', 'Rwanda', 'Senegal', 'Seychelles', 'Sierra Leone',
        'Somalia', 'South Africa', 'South Sudan', 'Sudan', 'Tanzania', 'Togo',
        'Tunisia', 'Uganda', 'Zambia', 'Zimbabwe',
    ];

    /**
     * Lance le scraping de tous les appels d'offres DGMarket concernant l'Afrique
     *
     * @return array
     */
    public function scrape(): array
    {
        Log::info('DGMarket Scraper: Début du scraping');
        
        try {
            $page = 1; // DGMarket commence généralement à page 1
            $totalCount = 0;
            $pagesStats = [];
            
            $maxPages = max(1, min((int) env('DGMARKET_MAX_PAGES', 5), self::MAX_PAGES));
            while ($page <= $maxPages) {
                Log::debug("DGMarket Scraper: Fetching page {$page}");
                
                $result = $this->scrapePage($page);
                $count = $result['count'];
                $totalCount += $count;
                
                $pagesStats[$page] = $count;
                
                if ($page % 10 === 0 || $count > 0) {
                    Log::info("DGMarket Scraper: Page {$page} traitée", [
                        'offres_trouvees' => $count,
                        'total_accumule' => $totalCount,
                    ]);
                }
                
                // Arrêter si aucune offre trouvée
                if ($count === 0 && $page > 1) {
                    Log::info("DGMarket Scraper: Page {$page} a retourné 0 offres, arrêt.");
                    break;
                }
                
                $page++;
                usleep(500000); // 0.5 seconde entre les pages
            }

        } catch (\Exception $e) {
            Log::error('DGMarket Scraper: Exception during scraping', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        $stats = [
            'total_pages_scraped' => count($pagesStats),
            'total_notices_kept' => $totalCount,
            'offres_par_page' => $pagesStats,
        ];

        Log::info('DGMarket Scraper: Résumé du scraping', $stats);

        return [
            'count' => $totalCount,
            'stats' => $stats,
        ];
    }

    /**
     * Scrape une page spécifique
     *
     * @param int $page
     * @return array
     */
    private function scrapePage(int $page): array
    {
        $count = 0;
        $html = '';
        
        try {
            // Construire l'URL avec pagination
            // DGMarket peut utiliser différentes URLs selon la version
            // Essayer plusieurs formats
            if ($page === 1) {
                $url = self::BASE_URL . '/tenders';
            } else {
                $url = self::BASE_URL . '/tenders?page=' . $page;
            }
            
            // Alternative: /search ou /tenders/list
            // Si la première URL ne fonctionne pas, on pourra essayer d'autres formats
            
            Log::debug('DGMarket Scraper: Fetching page', ['page' => $page, 'url' => $url]);
            
            // Requête HTTP simple
            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9,fr;q=0.8',
                ])
                ->get($url);
            
            if (!$response->successful()) {
                Log::warning('DGMarket Scraper: HTTP request failed', [
                    'url' => $url,
                    'status' => $response->status(),
                ]);
                return ['count' => 0, 'html' => ''];
            }
            
            $html = $response->body();
            
            // Parser le HTML
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();
            
            $xpath = new DOMXPath($dom);
            
            // Debug: compter tous les liens sur la page
            $allPageLinks = $xpath->query("//a[@href]");
            $tenderLinks = $xpath->query("//a[contains(@href, '/tender/')]");
            
            Log::info('DGMarket Scraper: Debug links', [
                'total_links' => $allPageLinks->length,
                'tender_links' => $tenderLinks->length,
            ]);
            
            // Extraire les notices de procurement
            $items = $this->extractProcurementItems($xpath, $dom);
            
            Log::info('DGMarket Scraper: Items found', ['page' => $page, 'count' => count($items)]);
            
            // Traiter chaque item
            $validOffres = [];
            $tenderIds = [];
            
            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);
                    
                    if (!$offre || empty($offre['titre']) || empty($offre['lien_source'])) {
                        continue;
                    }
                    
                    // FILTRAGE OBLIGATOIRE: Vérifier que l'offre concerne l'Afrique
                    if (!$this->isAfricanRelated($offre)) {
                        Log::debug('DGMarket Scraper: Offre rejetée (pas concernant l\'Afrique)', [
                            'titre' => $offre['titre'],
                        ]);
                        continue;
                    }
                    
                    // Dédupliquer par tender_id
                    if (isset($offre['tender_id']) && in_array($offre['tender_id'], $tenderIds)) {
                        Log::debug('DGMarket Scraper: Tender dupliqué rejeté', [
                            'tender_id' => $offre['tender_id'],
                        ]);
                        continue;
                    }
                    if (isset($offre['tender_id'])) {
                        $tenderIds[] = $offre['tender_id'];
                    }
                    
                    // VALIDATION: Tester l'URL HTTP (200 OK seulement)
                    if (!$this->validateUrl($offre['lien_source'])) {
                        Log::debug('DGMarket Scraper: URL invalide (pas 200 OK)', [
                            'titre' => $offre['titre'],
                            'lien' => $offre['lien_source'],
                        ]);
                        continue;
                    }
                    
                    Log::info('DGMarket Scraper: Offre acceptée', [
                        'titre' => $offre['titre'],
                        'lien' => $offre['lien_source'],
                        'pays' => $offre['pays'] ?? 'N/A',
                    ]);
                    
                    $validOffres[] = $offre;
                } catch (\Exception $e) {
                    Log::debug('DGMarket Scraper: Error processing item', [
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }
            }
            
            // Vérifier les offres existantes en batch
            if (!empty($validOffres)) {
                $liensSources = array_column($validOffres, 'lien_source');
                $titres = array_column($validOffres, 'titre');
                
                $existingLiens = Offre::where('source', 'DGMarket')
                    ->whereIn('lien_source', $liensSources)
                    ->pluck('lien_source')
                    ->toArray();
                
                $existingTitres = Offre::where('source', 'DGMarket')
                    ->whereIn('titre', $titres)
                    ->pluck('titre')
                    ->toArray();
                
                // Filtrer les offres qui n'existent pas déjà
                $newOffres = [];
                foreach ($validOffres as $offre) {
                    $exists = in_array($offre['lien_source'], $existingLiens) 
                           || in_array($offre['titre'], $existingTitres);
                    
                    if (!$exists) {
                        $newOffres[] = $offre;
                    }
                }
                
                // Insérer en batch
                if (!empty($newOffres)) {
                    $now = now();
                    foreach ($newOffres as &$offre) {
                        $offre['created_at'] = $now;
                        $offre['updated_at'] = $now;
                    }
                    unset($offre);
                    
                    $chunks = array_chunk($newOffres, 50);
                    foreach ($chunks as $chunk) {
                        Offre::insert($chunk);
                        $count += count($chunk);
                    }
                }
            }

        } catch (\Exception $e) {
            Log::error('DGMarket Scraper: Exception occurred while scraping page', [
                'page' => $page,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return ['count' => $count, 'html' => $html];
    }

    /**
     * Extrait les éléments de procurement depuis le DOM
     *
     * @param DOMXPath $xpath
     * @param DOMDocument $dom
     * @return array
     */
    private function extractProcurementItems(DOMXPath $xpath, DOMDocument $dom): array
    {
        $items = [];
        
        // Stratégie 1: Chercher les liens vers les pages /tender/{id}
        $linkPatterns = [
            "//a[contains(@href, '/tender/')]",
            "//a[starts-with(@href, '/tender/')]",
            "//a[contains(@href, 'tender')]",
        ];
        
        $allLinks = [];
        foreach ($linkPatterns as $pattern) {
            try {
                $links = $xpath->query($pattern);
                foreach ($links as $link) {
                    $allLinks[] = $link;
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        
        foreach ($allLinks as $link) {
            $href = $link->getAttribute('href');
            $text = trim($link->textContent);
            
            // Ignorer les liens de navigation
            if (stripos($text, 'next') !== false || 
                stripos($text, 'previous') !== false ||
                stripos($text, 'page') !== false ||
                stripos($text, 'search') !== false ||
                strlen($text) < 20) {
                continue;
            }
            
            // Le lien doit pointer vers une page /tender/{id}
            if (preg_match('/\/tender\/\d+/', $href)) {
                // Trouver le conteneur parent
                $parent = $link->parentNode;
                $maxDepth = 10;
                $depth = 0;
                
                while ($parent && $depth < $maxDepth) {
                    $parentText = trim($parent->textContent);
                    if (strlen($parentText) > 50) {
                        $found = false;
                        foreach ($items as $existing) {
                            $existingLinks = $xpath->query(".//a[@href]", $existing);
                            if ($existingLinks->length > 0 && $existingLinks->item(0)->getAttribute('href') === $href) {
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) {
                            $items[] = $parent;
                        }
                        break;
                    }
                    $parent = $parent->parentNode;
                    $depth++;
                }
            }
        }
        
        // Stratégie 2: Chercher les lignes de tableau avec des liens /tender/
        $tableRows = $xpath->query("//table//tr[.//a[contains(@href, '/tender/')]] | //tbody//tr[.//a[contains(@href, '/tender/')]] | //div[contains(@class, 'tender')] | //div[contains(@class, 'item')]");
        
        foreach ($tableRows as $row) {
            $rowLinks = $xpath->query(".//a[contains(@href, '/tender/')]", $row);
            if ($rowLinks->length > 0) {
                $href = $rowLinks->item(0)->getAttribute('href');
                if (preg_match('/\/tender\/\d+/', $href)) {
                    $found = false;
                    foreach ($items as $existing) {
                        $existingLinks = $xpath->query(".//a[@href]", $existing);
                        if ($existingLinks->length > 0 && $existingLinks->item(0)->getAttribute('href') === $href) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $items[] = $row;
                    }
                }
            }
        }
        
        return $items;
    }

    /**
     * Extrait les données d'une offre depuis un élément DOM
     *
     * @param \DOMElement $item
     * @param DOMXPath $xpath
     * @return array|null
     */
    private function extractOffreData(\DOMElement $item, DOMXPath $xpath): ?array
    {
        try {
            // Extraire le titre et le lien OFFICIEL (format /tender/{id})
            $titre = null;
            $lien = null;
            $tenderId = null;
            
            // Chercher les liens dans l'élément
            $linkNodes = $xpath->query(".//a[@href]", $item);
            
            foreach ($linkNodes as $link) {
                $href = $link->getAttribute('href');
                $linkText = trim($link->textContent);
                
                // Ignorer les liens de navigation
                if (stripos($href, 'javascript:') !== false ||
                    stripos($href, '#') === 0 ||
                    stripos($href, 'mailto:') !== false ||
                    stripos($linkText, 'next') !== false ||
                    stripos($linkText, 'previous') !== false ||
                    strlen($linkText) < 20) {
                    continue;
                }
                
                // Le lien DOIT être au format /tender/{id}
                if (preg_match('/\/tender\/(\d+)/', $href, $matches)) {
                    $tenderId = $matches[1];
                    $hrefNormalized = $this->normalizeUrl($href);
                    
                    // Si le texte du lien est substantiel, c'est notre notice
                    if (strlen($linkText) > 20 && strlen($linkText) < 500) {
                        $titre = $linkText;
                        $lien = $hrefNormalized;
                        break; // Prendre le premier lien /tender/{id} trouvé
                    }
                }
            }
            
            // Si pas de lien /tender/{id} trouvé, rejeter l'item
            if (!$titre || !$lien || !$tenderId) {
                return null;
            }
            
            // Extraire les données depuis la page détail
            $detailData = $this->extractDetailPageData($lien);
            
            // Extraire le type de notice
            $type = $this->extractNoticeType($item, $xpath, $detailData);
            
            // Extraire le pays/zone (depuis l'item ou la page détail)
            $pays = $this->extractCountry($item, $xpath, $detailData);
            
            // Extraire l'acheteur (depuis la page détail)
            $acheteur = $this->extractBuyer($detailData);
            
            // Extraire les dates (depuis la page détail)
            $dateLimite = $this->extractDeadline($detailData);
            
            return [
                'titre' => $titre,
                'acheteur' => $acheteur ?: 'DGMarket',
                'pays' => $pays,
                'date_limite_soumission' => $dateLimite,
                'lien_source' => $lien,
                'source' => 'DGMarket',
                'detail_url' => $lien,
                'link_type' => 'detail',
                'notice_type' => $type,
                'project_id' => $tenderId, // Utiliser project_id pour stocker tender_id
            ];

        } catch (\Exception $e) {
            Log::warning('DGMarket Scraper: Error extracting data from item', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Extrait les données depuis la page détail
     *
     * @param string $url
     * @return array
     */
    private function extractDetailPageData(string $url): array
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ])
                ->get($url);
            
            if (!$response->successful()) {
                return [];
            }
            
            $html = $response->body();
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();
            
            $xpath = new DOMXPath($dom);
            
            return [
                'html' => $html,
                'dom' => $dom,
                'xpath' => $xpath,
            ];
        } catch (\Exception $e) {
            Log::debug('DGMarket Scraper: Error fetching detail page', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }

    /**
     * Extrait le type de notice
     */
    private function extractNoticeType(\DOMElement $item, DOMXPath $xpath, array $detailData): ?string
    {
        $text = strtolower($item->textContent);
        
        // Chercher dans les données de détail si disponibles
        if (!empty($detailData['xpath'])) {
            $detailText = strtolower($detailData['xpath']->evaluate('string(//body)'));
            $text .= ' ' . $detailText;
        }
        
        $types = [
            'works' => 'Works',
            'services' => 'Services',
            'supplies' => 'Supplies',
            'consultancy' => 'Consultancy',
            'travaux' => 'Works',
            'services' => 'Services',
            'fournitures' => 'Supplies',
        ];
        
        foreach ($types as $keyword => $type) {
            if (stripos($text, $keyword) !== false) {
                return $type;
            }
        }
        
        return null;
    }

    /**
     * Extrait le pays/zone géographique
     */
    private function extractCountry(\DOMElement $item, DOMXPath $xpath, array $detailData): ?string
    {
        $text = $item->textContent;
        
        // Chercher dans les données de détail si disponibles
        if (!empty($detailData['xpath'])) {
            $detailText = $detailData['xpath']->evaluate('string(//body)');
            $text .= ' ' . $detailText;
        }
        
        $foundCountries = [];
        
        foreach (self::AFRICAN_COUNTRIES as $country) {
            if (stripos($text, $country) !== false) {
                $foundCountries[] = $country;
            }
        }
        
        // Chercher aussi "Africa" ou "Afrique"
        if (stripos($text, 'Africa') !== false || stripos($text, 'Afrique') !== false) {
            if (empty($foundCountries)) {
                return 'Africa';
            }
        }
        
        if (!empty($foundCountries)) {
            return implode(', ', array_unique($foundCountries));
        }
        
        return null;
    }

    /**
     * Extrait l'acheteur depuis la page détail
     */
    private function extractBuyer(array $detailData): ?string
    {
        if (empty($detailData['xpath'])) {
            return null;
        }
        
        $xpath = $detailData['xpath'];
        
        // Chercher "Buyer", "Contracting authority", "Organisation", etc.
        $patterns = [
            "//*[contains(text(), 'Buyer')]/following-sibling::*[1]",
            "//*[contains(text(), 'Contracting authority')]/following-sibling::*[1]",
            "//*[contains(text(), 'Organisation')]/following-sibling::*[1]",
            "//*[contains(text(), 'Acheteur')]/following-sibling::*[1]",
            "//*[contains(text(), 'Autorité contractante')]/following-sibling::*[1]",
            "//*[contains(@class, 'buyer')]",
            "//*[contains(@class, 'organization')]",
        ];
        
        foreach ($patterns as $pattern) {
            try {
                $nodes = $xpath->query($pattern);
                if ($nodes->length > 0) {
                    $buyer = trim($nodes->item(0)->textContent);
                    if (strlen($buyer) > 5 && strlen($buyer) < 200) {
                        return $buyer;
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        
        return null;
    }

    /**
     * Extrait la date limite depuis la page détail
     */
    private function extractDeadline(array $detailData): ?string
    {
        if (empty($detailData['xpath'])) {
            return null;
        }
        
        $xpath = $detailData['xpath'];
        $text = strtolower($detailData['xpath']->evaluate('string(//body)'));
        
        // Chercher des patterns de date après "deadline", "closing", "échéance"
        $deadlineKeywords = ['deadline', 'closing date', 'date limite', 'échéance', 'submission deadline', 'due date'];
        
        foreach ($deadlineKeywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                $pos = stripos($text, $keyword);
                $substring = substr($text, $pos, 200);
                
                $patterns = [
                    '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
                    '/(\d{4})-(\d{2})-(\d{2})/',
                    '/(\d{1,2})\s+(january|february|march|april|may|june|july|august|september|october|november|december)\s+(\d{4})/i',
                    '/(\d{1,2})\s+(janvier|février|mars|avril|mai|juin|juillet|août|septembre|octobre|novembre|décembre)\s+(\d{4})/i',
                ];
                
                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, $substring, $matches)) {
                        try {
                            $dateStr = $matches[0];
                            $date = \Carbon\Carbon::parse($dateStr);
                            return $date->format('Y-m-d');
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                }
            }
        }
        
        return null;
    }

    /**
     * Vérifie si une offre concerne l'Afrique (FILTRAGE OBLIGATOIRE)
     *
     * @param array $offre
     * @return bool
     */
    private function isAfricanRelated(array $offre): bool
    {
        $textToCheck = strtolower($offre['titre'] . ' ' . ($offre['pays'] ?? '') . ' ' . ($offre['acheteur'] ?? ''));
        
        // Vérifier les pays africains
        foreach (self::AFRICAN_COUNTRIES as $country) {
            if (stripos($textToCheck, strtolower($country)) !== false) {
                return true;
            }
        }
        
        // Vérifier "Africa" ou "Afrique"
        if (stripos($textToCheck, 'africa') !== false || 
            stripos($textToCheck, 'afrique') !== false) {
            return true;
        }
        
        return false;
    }

    /**
     * Normalise une URL (relative -> absolue)
     */
    private function normalizeUrl(string $url): string
    {
        if (empty($url)) {
            return '';
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        if (str_starts_with($url, '/')) {
            return self::BASE_URL . $url;
        }

        return self::BASE_URL . '/' . $url;
    }

    /**
     * Valide une URL HTTP (teste si elle retourne 200 OK)
     * Pour DGMarket, si l'URL est au format /tender/{id}, on l'accepte même si elle retourne 500
     * (les pages peuvent être temporairement indisponibles mais l'URL est valide)
     */
    private function validateUrl(string $url): bool
    {
        // Si l'URL est au format /tender/{id}, elle est considérée comme valide
        if (preg_match('/\/tender\/\d+$/', $url) || preg_match('/\/tender\/\d+/', $url)) {
            // Vérifier quand même avec une requête GET (plus fiable que HEAD)
            try {
                $response = Http::withoutVerifying()
                    ->timeout(10)
                    ->get($url);
                
                $status = $response->status();
                
                // Accepter 200 OK
                if ($status === 200) {
                    return true;
                }
                
                // Accepter aussi 500 si l'URL est au bon format (peut être temporaire)
                if ($status === 500 && preg_match('/\/tender\/\d+/', $url)) {
                    Log::debug('DGMarket Scraper: URL format valide mais retourne 500 (acceptée)', [
                        'url' => $url,
                    ]);
                    return true;
                }
                
                Log::debug('DGMarket Scraper: URL returned invalid status', [
                    'url' => $url,
                    'status' => $status,
                ]);
                return false;
                
            } catch (\Exception $e) {
                // Si l'URL est au format /tender/{id}, l'accepter quand même
                if (preg_match('/\/tender\/\d+/', $url)) {
                    Log::debug('DGMarket Scraper: URL format valide, acceptée malgré erreur', [
                        'url' => $url,
                        'error' => $e->getMessage(),
                    ]);
                    return true;
                }
                
                Log::debug('DGMarket Scraper: URL validation failed', [
                    'url' => $url,
                    'error' => $e->getMessage(),
                ]);
                return false;
            }
        }
        
        // Si l'URL n'est pas au format /tender/{id}, rejeter
        return false;
    }
}

