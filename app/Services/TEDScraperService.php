<?php

namespace App\Services;

use App\Models\Offre;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TEDScraperService
{
    // URL de recherche TED pour tous les appels d'offres
    // TED utilise différentes URLs selon la section
    private const BASE_URL = 'https://ted.europa.eu/TED/browse/browseByMap.do';
    // URL alternative: recherche simple
    private const SEARCH_URL = 'https://ted.europa.eu/TED/browse/browseByMap.do';
    // URL de recherche avancée
    private const ADVANCED_SEARCH_URL = 'https://ted.europa.eu/TED/browse/browseByMap.do';
    private const MAX_PAGES = 50;
    
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
     * Lance le scraping de tous les appels d'offres TED concernant l'Afrique
     *
     * @return array
     */
    public function scrape(): array
    {
        Log::info('TED Scraper: Début du scraping');
        
        try {
            $page = 0;
            $totalCount = 0;
            $pagesStats = [];
            
            while ($page <= self::MAX_PAGES) {
                Log::debug("TED Scraper: Fetching page {$page}");
                
                $result = $this->scrapePage($page);
                $count = $result['count'];
                $totalCount += $count;
                
                $pagesStats[$page] = $count;
                
                if ($page % 10 === 0 || $count > 0) {
                    Log::info("TED Scraper: Page {$page} traitée", [
                        'offres_trouvees' => $count,
                        'total_accumule' => $totalCount,
                    ]);
                }
                
                // Arrêter si aucune offre trouvée
                if ($count === 0 && $page > 0) {
                    Log::info("TED Scraper: Page {$page} a retourné 0 offres, arrêt.");
                    break;
                }
                
                $page++;
                usleep(500000); // 0.5 seconde entre les pages
            }

        } catch (\Exception $e) {
            Log::error('TED Scraper: Exception during scraping', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        $stats = [
            'total_pages_scraped' => count($pagesStats),
            'total_notices_kept' => $totalCount,
            'offres_par_page' => $pagesStats,
        ];

        Log::info('TED Scraper: Résumé du scraping', $stats);

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
            // TED utilise différentes URLs. Essayer la recherche simple d'abord
            // Si ça ne marche pas, on pourra essayer d'autres URLs
            
            // URL de base: page de recherche/browse
            $url = 'https://ted.europa.eu/TED/browse/browseByMap.do';
            
            // Pour la première page, essayer sans paramètres
            // Pour les pages suivantes, essayer différents formats de pagination
            if ($page > 0) {
                // Essayer plusieurs formats de pagination
                $url .= '?currentPage=' . ($page + 1);
            }
            
            Log::debug('TED Scraper: URL construite', ['url' => $url]);
            
            Log::debug('TED Scraper: Fetching page', ['page' => $page, 'url' => $url]);
            
            // Requête HTTP simple (pas de JS headless)
            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9,fr;q=0.8',
                ])
                ->get($url);
            
            if (!$response->successful()) {
                Log::warning('TED Scraper: HTTP request failed', [
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
            $tedLinks = $xpath->query("//a[contains(@href, 'ted.europa.eu')]");
            $detailLinks = $xpath->query("//a[contains(@href, 'browseDetail')]");
            
            Log::info('TED Scraper: Debug links', [
                'total_links' => $allPageLinks->length,
                'ted_links' => $tedLinks->length,
                'detail_links' => $detailLinks->length,
            ]);
            
            // Extraire les notices de procurement
            $items = $this->extractProcurementItems($xpath, $dom);
            
            Log::info('TED Scraper: Items found', ['page' => $page, 'count' => count($items)]);
            
            // Traiter chaque item
            $validOffres = [];
            $noticeIds = [];
            
            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);
                    
                    if (!$offre || empty($offre['titre']) || empty($offre['lien_source'])) {
                        continue;
                    }
                    
                    // FILTRAGE OBLIGATOIRE: Vérifier que l'offre concerne l'Afrique
                    if (!$this->isAfricanRelated($offre)) {
                        Log::info('TED Scraper: Offre rejetée (pas concernant l\'Afrique)', [
                            'titre' => $offre['titre'],
                            'pays' => $offre['pays'] ?? 'N/A',
                        ]);
                        continue;
                    }
                    
                    // Dédupliquer par notice_id TED
                    if (isset($offre['notice_id']) && in_array($offre['notice_id'], $noticeIds)) {
                        Log::debug('TED Scraper: Notice dupliquée rejetée', [
                            'notice_id' => $offre['notice_id'],
                        ]);
                        continue;
                    }
                    if (isset($offre['notice_id'])) {
                        $noticeIds[] = $offre['notice_id'];
                    }
                    
                    // VALIDATION: Tester l'URL HTTP (200 OK seulement)
                    if (!$this->validateUrl($offre['lien_source'])) {
                        Log::info('TED Scraper: URL invalide (pas 200 OK)', [
                            'titre' => $offre['titre'],
                            'lien' => $offre['lien_source'],
                        ]);
                        continue;
                    }
                    
                    Log::info('TED Scraper: Offre acceptée', [
                        'titre' => $offre['titre'],
                        'lien' => $offre['lien_source'],
                        'pays' => $offre['pays'] ?? 'N/A',
                    ]);
                    
                    Log::debug('TED Scraper: Offre acceptée', [
                        'titre' => $offre['titre'],
                        'lien' => $offre['lien_source'],
                    ]);
                    
                    $validOffres[] = $offre;
                } catch (\Exception $e) {
                    Log::debug('TED Scraper: Error processing item', [
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }
            }
            
            // Vérifier les offres existantes en batch
            if (!empty($validOffres)) {
                $liensSources = array_column($validOffres, 'lien_source');
                $titres = array_column($validOffres, 'titre');
                
                $existingLiens = Offre::where('source', 'DG Market (TED)')
                    ->whereIn('lien_source', $liensSources)
                    ->pluck('lien_source')
                    ->toArray();
                
                $existingTitres = Offre::where('source', 'DG Market (TED)')
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
            Log::error('TED Scraper: Exception occurred while scraping page', [
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
        
        // Stratégie 1: Chercher tous les liens TED qui pourraient être des notices
        $linkPatterns = [
            "//a[contains(@href, '/TED/browse/browseDetail.do')]",
            "//a[contains(@href, 'browseDetail.do')]",
            "//a[contains(@href, 'noticeId')]",
            "//a[contains(@href, 'notice')]",
            "//a[contains(@href, 'ted.europa.eu')]",
            "//a[starts-with(@href, '/TED/')]",
            "//table//tr//a[@href]",
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
            
            // Le lien doit pointer vers une notice TED spécifique
            // TED peut utiliser différents formats d'URL
            $isNoticeLink = stripos($href, 'browseDetail.do') !== false ||
                             stripos($href, 'noticeId') !== false ||
                             stripos($href, 'notice') !== false ||
                             (stripos($href, 'ted.europa.eu') !== false && 
                              stripos($href, '/TED/') !== false &&
                              stripos($href, 'browse') === false); // Exclure les pages de navigation
            
            if ($isNoticeLink) {
                
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
        
        // Stratégie 2: Chercher les lignes de tableau
        $tableRows = $xpath->query("//table//tr[.//a[contains(@href, 'browseDetail.do')]] | //tbody//tr[.//a[contains(@href, 'browseDetail.do')]]");
        
        foreach ($tableRows as $row) {
            $rowLinks = $xpath->query(".//a[contains(@href, 'browseDetail.do')]", $row);
            if ($rowLinks->length > 0) {
                $href = $rowLinks->item(0)->getAttribute('href');
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
            // Extraire le titre et le lien OFFICIEL
            $titre = null;
            $lien = null;
            $noticeId = null;
            
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
                
                // Le lien doit pointer vers une notice TED spécifique
                // TED peut utiliser différents formats d'URL
                // Accepter les liens qui semblent être des notices (pas navigation)
                $isNavigation = stripos($href, 'browseByMap') !== false ||
                               stripos($href, 'search') !== false ||
                               stripos($href, 'help') !== false ||
                               stripos($href, 'about') !== false ||
                               stripos($href, 'contact') !== false;
                
                $isNoticeLink = !$isNavigation && 
                               (stripos($href, 'ted.europa.eu') !== false || 
                                stripos($href, '/TED/') !== false ||
                                stripos($href, 'browseDetail') !== false ||
                                stripos($href, 'notice') !== false);
                
                if ($isNoticeLink && strlen($linkText) > 20 && strlen($linkText) < 500) {
                    $hrefNormalized = $this->normalizeUrl($href);
                    
                    // Extraire le notice_id depuis l'URL si possible
                    if (preg_match('/noticeId=(\d+)/', $href, $matches) ||
                        preg_match('/notice[_-]?id[=_](\d+)/i', $href, $matches) ||
                        preg_match('/\/(\d{6,})\//', $href, $matches)) {
                        $noticeId = $matches[1];
                    }
                    
                    // Prendre le premier lien valide trouvé
                    $titre = $linkText;
                    $lien = $hrefNormalized;
                    break;
                }
            }
            
            if (!$titre || !$lien) {
                Log::debug('TED Scraper: Item rejeté (pas de titre ou lien)', [
                    'titre' => $titre,
                    'lien' => $lien,
                ]);
                return null;
            }
            
            Log::debug('TED Scraper: Extraction des données de détail', [
                'titre' => $titre,
                'lien' => $lien,
            ]);
            
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
                'acheteur' => $acheteur ?: 'DG Market (TED)',
                'pays' => $pays,
                'date_limite_soumission' => $dateLimite,
                'lien_source' => $lien,
                'source' => 'DG Market (TED)',
                'detail_url' => $lien,
                'link_type' => 'detail',
                'notice_type' => $type,
                'project_id' => $noticeId, // Utiliser project_id pour stocker notice_id
            ];

        } catch (\Exception $e) {
            Log::warning('TED Scraper: Error extracting data from item', [
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
            Log::debug('TED Scraper: Error fetching detail page', [
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
        
        // Chercher "Contracting authority" ou "Autorité contractante"
        $patterns = [
            "//*[contains(text(), 'Contracting authority')]/following-sibling::*[1]",
            "//*[contains(text(), 'Autorité contractante')]/following-sibling::*[1]",
            "//*[contains(text(), 'Buyer')]/following-sibling::*[1]",
            "//*[contains(text(), 'Acheteur')]/following-sibling::*[1]",
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
        $deadlineKeywords = ['deadline', 'closing date', 'date limite', 'échéance', 'submission deadline'];
        
        foreach ($deadlineKeywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                $pos = stripos($text, $keyword);
                $substring = substr($text, $pos, 200);
                
                $patterns = [
                    '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
                    '/(\d{4})-(\d{2})-(\d{2})/',
                    '/(\d{1,2})\s+(january|february|march|april|may|june|july|august|september|october|november|december)\s+(\d{4})/i',
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
            return 'https://ted.europa.eu' . $url;
        }

        return 'https://ted.europa.eu/' . $url;
    }

    /**
     * Valide une URL HTTP (teste si elle retourne 200 OK)
     */
    private function validateUrl(string $url): bool
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->head($url);
            
            $status = $response->status();
            
            // Accepter seulement 200 OK
            if ($status === 200) {
                return true;
            }
            
            Log::debug('TED Scraper: URL returned invalid status', [
                'url' => $url,
                'status' => $status,
            ]);
            return false;
            
        } catch (\Exception $e) {
            Log::debug('TED Scraper: URL validation failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}

