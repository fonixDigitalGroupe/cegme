<?php

namespace App\Services;

use App\Models\Offre;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use GuzzleHttp\Cookie\CookieJar;
use App\Services\MarketTypeClassifier;

class DGMarketScraperService implements IterativeScraperInterface
{
    private $cookieJar;

    public function __construct()
    {
        $this->cookieJar = new CookieJar();
    }

    // URL de base pour les appels d'offres DGMarket (Ciblée sur l'Afrique UNIQUEMENT)
    private const BASE_URL = 'https://appel-d-offre.dgmarket.com';
    private const SCRAPE_URL = 'https://appel-d-offre.dgmarket.com/tenders/list.do?locationISO=_s';
    private const MAX_OFFERS = 50;
    private const MAX_PAGES = 10;
    
    // Liste des pays africains pour le filtrage (Bilingue pour plus de robustesse)
    private const AFRICAN_COUNTRIES = [
        'Algeria', 'Algérie', 'Angola', 'Benin', 'Bénin', 'Botswana', 'Burkina Faso', 'Burundi',
        'Cameroon', 'Cameroun', 'Central African Republic', 'République Centrafricaine', 'Chad', 'Tchad', 'Comoros', 'Comores', 'Congo',
        'Côte d\'Ivoire', 'Djibouti', 'Egypt', 'Égypte', 'Eritrea', 'Érythrée', 'Eswatini',
        'Ethiopia', 'Éthiopie', 'Gabon', 'Gambia', 'Gambie', 'Ghana', 'Guinea', 'Guinée', 'Guinea-Bissau', 'Guinée-Bissau',
        'Kenya', 'Lesotho', 'Liberia', 'Libéria', 'Libya', 'Libye', 'Madagascar', 'Malawi',
        'Mali', 'Mauritania', 'Mauritanie', 'Mauritius', 'Maurice', 'Morocco', 'Maroc', 'Mozambique', 'Namibia', 'Namibie',
        'Niger', 'Nigeria', 'Nigéria', 'Rwanda', 'Senegal', 'Sénégal', 'Seychelles', 'Sierra Leone',
        'Somalia', 'Somalie', 'South Africa', 'Afrique du Sud', 'South Sudan', 'Soudan du Sud', 'Sudan', 'Soudan', 'Tanzania', 'Tanzanie', 'Togo',
        'Tunisia', 'Tunisie', 'Uganda', 'Ouganda', 'Zambia', 'Zambie', 'Zimbabwe',
        'Africa', 'Afrique'
    ];

    // Properties for iterative scraping
    private ?string $jobId = null;
    private int $currentPage = 1;
    private bool $isExhausted = false;
    private array $pendingOffers = [];
    private ?string $paginationParam = null;

    /**
     * Définit l'ID du job pour le suivi de progression
     */
    public function setJobId(?string $jobId): void
    {
        $this->jobId = $jobId;
    }

    /**
     * Initialise le scraper pour le mode itératif
     */
    public function initialize(): void
    {
        $this->currentPage = 1;
        $this->isExhausted = false;
        $this->pendingOffers = [];
    }

    /**
     * Réinitialise l'état du scraper
     */
    public function reset(): void
    {
        $this->currentPage = 1;
        $this->isExhausted = false;
        $this->pendingOffers = [];
    }

    /**
     * Scrappe un lot d'offres (mode itératif pour round-robin)
     * 
     * @param int $limit Nombre maximum d'offres à scraper
     * @return array ['count' => int, 'has_more' => bool, 'findings' => array]
     */
    public function scrapeBatch(int $limit = 10): array
    {
        $findings = [];
        $count = 0;
        $processed = 0;

        // Traiter les offres en attente dans le buffer
        while (count($this->pendingOffers) > 0 && $processed < $limit) {
            $offerData = array_shift($this->pendingOffers);
            $processed++;

            try {
                $existing = Offre::where('source', 'DGMarket')
                    ->where('lien_source', $offerData['lien_source'])
                    ->first();

                if ($existing) {
                    $existing->update([
                        'pays' => $offerData['pays'] ?? $existing->pays,
                        'date_limite_soumission' => $offerData['date_limite_soumission'] ?? $existing->date_limite_soumission,
                        'date_publication' => $offerData['date_publication'] ?? $existing->date_publication,
                        'updated_at' => now(),
                    ]);
                } else {
                    $offerData['created_at'] = now();
                    $offerData['updated_at'] = now();
                    Offre::create($offerData);
                    $count++;
                }

                $findings[] = $offerData;
            } catch (\Exception $e) {
                Log::error('DGMarket Scraper: Error saving offer', [
                    'titre' => $offerData['titre'] ?? 'N/A',
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Si on n'a pas atteint la limite et qu'on n'est pas épuisé, scraper plus
        while ($processed < $limit && !$this->isExhausted) {
            $result = $this->scrapePageForBatch($this->currentPage);

            // On est épuisé SEULEMENT si aucun item n'a été trouvé sur la page (fin du site)
            if (($result['raw_count'] ?? 0) === 0) {
                $this->isExhausted = true;
                break;
            }

            // Ajouter les nouvelles offres au buffer
            $this->pendingOffers = array_merge($this->pendingOffers, $result['offers']);
            $this->currentPage++;

            // Sécurité: limite de pages pour éviter les boucles infinies
            if ($this->currentPage > self::MAX_PAGES) {
                $this->isExhausted = true;
            }

            // Traiter le buffer jusqu'à atteindre la limite
            while (count($this->pendingOffers) > 0 && $processed < $limit) {
                // Si on a déjà assez d'offres au total pour cette session (50)
                // Note: cette limite est globale pour un "scan", mais ici on est dans un batch itératif
                // On peut laisser scrapeBatch gérer ses propres limites d'itérations
                $offerData = array_shift($this->pendingOffers);
                $processed++;

                try {
                    $existing = Offre::where('source', 'DGMarket')
                        ->where('lien_source', $offerData['lien_source'])
                        ->first();

                    if ($existing) {
                        $existing->update([
                            'pays' => $offerData['pays'] ?? $existing->pays,
                            'date_limite_soumission' => $offerData['date_limite_soumission'] ?? $existing->date_limite_soumission,
                            'date_publication' => $offerData['date_publication'] ?? $existing->date_publication,
                            'updated_at' => now(),
                        ]);
                    } else {
                        $offerData['created_at'] = now();
                        $offerData['updated_at'] = now();
                        Offre::create($offerData);
                        $count++;
                    }

                    $findings[] = $offerData;
                } catch (\Exception $e) {
                    Log::error('DGMarket Scraper: Error saving offer', [
                        'titre' => $offerData['titre'] ?? 'N/A',
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $hasMore = !$this->isExhausted || count($this->pendingOffers) > 0;

        return [
            'count' => $processed,
            'new_count' => $count,
            'has_more' => $hasMore,
            'findings' => $findings,
        ];
    }

    /**
     * Scrape une page spécifique et retourne les offres (pour mode batch)
     */
    private function scrapePageForBatch(int $page): array
    {
        $offers = [];
        
        try {
            // Construire l'URL avec pagination - Essayer plusieurs formats
            // Utiliser l'URL de base ou l'URL de recherche filtrée
            $baseUrl = self::SCRAPE_URL;
            $urlsToTry = [];
            
            if ($page === 1) {
                $urlsToTry[] = $baseUrl;
            } else {
                $separator = str_contains($baseUrl, '?') ? '&' : '?';
                
                // Si on a déjà détecté le paramètre de pagination, l'utiliser en priorité
                if ($this->paginationParam) {
                    $urlsToTry[] = $baseUrl . $separator . $this->paginationParam . '=' . $page;
                }
                
                $urlsToTry[] = $baseUrl . $separator . 'd-446978-p=' . $page;
                $urlsToTry[] = $baseUrl . $separator . 'page=' . $page;
                $urlsToTry[] = $baseUrl . $separator . 'p=' . $page;
            }
            
            $response = null;
            $url = null;
            
            foreach ($urlsToTry as $tryUrl) {
                try {
                    $response = Http::withoutVerifying()
                        ->timeout(30)
                        ->withOptions(['cookies' => $this->cookieJar])
                        ->withHeaders([
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                            'Accept-Language' => 'fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7',
                            'Upgrade-Insecure-Requests' => '1',
                        ])
                        ->get($tryUrl);
                    
                    if ($response->successful()) {
                        $url = $tryUrl;
                        
                        // Détecter le paramètre de pagination sur la première page réussie
                        if (!$this->paginationParam) {
                            $this->detectPaginationParam($response->body());
                        }
                        
                        break;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            if (!$response || !$response->successful()) {
                return ['count' => 0, 'offers' => []];
            }
            
            $html = $response->body();
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);
            
            $items = $this->extractProcurementItems($xpath, $dom);
            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);
                    
                    if ($offre) {
                        // Pas besoin de filtrer localement: l'URL locationISO=_s filtre déjà côté serveur
                        
                        if (!$this->validateUrl($offre['lien_source'])) {
                            continue;
                        }
                        
                        $offers[] = $offre;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error('DGMarket Scraper: Error in scrapePageForBatch', [
                'page' => $page,
                'error' => $e->getMessage(),
            ]);
        }
        
        return [
            'count' => count($offers), 
            'raw_count' => count($items ?? []), // Nombre total d'items avant filtrage Afrique
            'offers' => $offers
        ];
    }

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
            while ($page <= $maxPages && $totalCount < self::MAX_OFFERS) {
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
                
                // Arrêter si on a atteint la limite de 50
                if ($totalCount >= self::MAX_OFFERS) {
                    Log::info("DGMarket Scraper: Limite de " . self::MAX_OFFERS . " offres atteinte, arrêt.");
                    break;
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
            // Construire l'URL avec pagination - Essayer plusieurs formats
            $urlsToTry = [];
            
            // Construire l'URL de la page
            $baseUrl = self::SCRAPE_URL;
            $urlsToTry = [];
            if ($page === 1) {
                $urlsToTry[] = $baseUrl;
            } else {
                $urlsToTry[] = $baseUrl . '&d-446978-p=' . $page;
                $urlsToTry[] = $baseUrl . '&page=' . $page;
                $urlsToTry[] = $baseUrl . '&p=' . $page;
            }
            
            $response = null;
            $url = null;
            
            // Essayer chaque URL jusqu'à en trouver une qui fonctionne
            foreach ($urlsToTry as $tryUrl) {
                Log::debug('DGMarket Scraper: Trying URL', ['page' => $page, 'url' => $tryUrl]);
                
                try {
                    // Requête HTTP avec gestion des cookies/sessions
                    $response = Http::withoutVerifying() // Désactiver SSL pour éviter les erreurs
                        ->timeout(30)
                        ->withHeaders([
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                            'Accept-Language' => 'en-US,en;q=0.9,fr;q=0.8',
                            'Accept-Encoding' => 'gzip, deflate, br',
                            'Connection' => 'keep-alive',
                            'Upgrade-Insecure-Requests' => '1',
                        ])
                        ->get($tryUrl);
                    
                    if ($response->successful()) {
                        $url = $tryUrl;
                        Log::info('DGMarket Scraper: Successfully fetched page', ['url' => $url]);
                        break;
                    }
                } catch (\Exception $e) {
                    Log::debug('DGMarket Scraper: URL failed', [
                        'url' => $tryUrl,
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }
            }
            
            // Si aucune URL n'a fonctionné, retourner 0
            if (!$response || !$response->successful()) {
                Log::warning('DGMarket Scraper: All URLs failed for page', [
                    'page' => $page,
                    'urls_tried' => $urlsToTry,
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
            
            $tenderLinks = $xpath->query("//a[contains(@href, '/tender') or contains(@href, 'noticeId=')]");

            
            Log::info('DGMarket Scraper: Items found', ['page' => $page, 'count' => $tenderLinks->length]);
            
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
                    
                    // Comme on scrape une URL spécifique à l'Afrique, on accepte tout par défaut
                    // (L'utilisateur a demandé 'sans aucun autre filtre')
                    if (!$this->isAfricanRelated($offre)) {
                         Log::debug('DGMarket Scraper: Offre acceptée car sur page Afrique (mais pays non matché par notre liste locale)', [
                             'titre' => $offre['titre'],
                         ]);
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
                
                // Récupérer les offres existantes complètes pour mise à jour
                $existingOffers = Offre::where('source', 'DGMarket')
                    ->where(function ($q) use ($liensSources, $titres) {
                        $q->whereIn('lien_source', $liensSources)
                          ->orWhereIn('titre', $titres);
                    })
                    ->get();
                
                $newOffres = [];
                
                foreach ($validOffres as $offreData) {
                    // Chercher si l'offre existe déjà
                    $existing = $existingOffers->first(function ($item) use ($offreData) {
                        return $item->lien_source === $offreData['lien_source'] || $item->titre === $offreData['titre'];
                    });
                    
                    if ($existing) {
                        // Mise à jour de l'offre existante
                        try {
                            $existing->update([
                                'pays' => $offreData['pays'] ?? $existing->pays,
                                'date_limite_soumission' => $offreData['date_limite_soumission'] ?? $existing->date_limite_soumission,
                                'date_publication' => $offreData['date_publication'] ?? $existing->date_publication,
                                'updated_at' => now(),
                            ]);
                            Log::debug('DGMarket Scraper: Offre mise à jour', ['id' => $existing->id]);
                        } catch (\Exception $e) {
                            Log::warning('DGMarket Scraper: Erreur mise à jour offre', ['id' => $existing->id]);
                        }
                    } else {
                        // Nouvelle offre
                        $newOffres[] = $offreData;
                    }
                }
                
                // Insérer les nouvelles offres en batch
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

    private function extractProcurementItems(DOMXPath $xpath, DOMDocument $dom): array
    {
        $items = [];
        $seenTenderIds = [];
        
        // 1. Trouver tous les liens d'appels d'offres
        $links = $xpath->query("//a[contains(@href, '/tender') or contains(@href, 'noticeId=')]");
        
        Log::info('DGMarket Scraper: extractProcurementItems found links', ['count' => $links->length]);
        
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            
            // Ignorer les liens de navigation ou trop courts
            $text = trim($link->textContent);
            if (stripos($text, 'next') !== false || stripos($text, 'previous') !== false || strlen($text) < 5) {
                continue;
            }

            if (preg_match('/\/tender\/(\d+)/', $href, $matches) || preg_match('/noticeId=(\d+)/', $href, $matches)) {
                $tenderId = $matches[1];
                if (!in_array($tenderId, $seenTenderIds)) {
                    $seenTenderIds[] = $tenderId;
                    
                    // 2. Remonter vers le parent qui contient toutes les infos (table ou tr)
                    $parent = $link->parentNode;
                    $foundContainer = null;
                    $depth = 0;
                    
                    while ($parent && $depth < 12) {
                        if ($parent->nodeType === XML_ELEMENT_NODE) {
                            $class = (string)$parent->getAttribute('class');
                            $tagName = strtolower($parent->nodeName);
                            
                            if (strpos($class, 'list_notice_table') !== false ||
                                strpos($class, 'gridViewTableRow') !== false ||
                                strpos($class, 'eca_notice_list_item') !== false ||
                                $tagName === 'tr') {
                                $foundContainer = $parent;
                                // Si c'est déjà la table spécifique, on s'arrête là
                                if (strpos($class, 'list_notice_table') !== false || strpos($class, 'eca_notice_list_item') !== false) break;
                            }
                        }
                        $parent = $parent->parentNode;
                        $depth++;
                    }
                    
                    if ($foundContainer) {
                        $items[] = $foundContainer;
                    } else {
                        $items[] = $link->parentNode->parentNode ?: $link;
                    }
                } else {
                }
            }
        }
        
        Log::info('DGMarket Scraper: Total items extracted', ['count' => count($items)]);
        
        return $items;
    }

    /**
     * Détecte dynamiquement le paramètre de pagination dans le HTML
     */
    private function detectPaginationParam(string $html): void
    {
        if (preg_match('/(d-\d+-p)=\d+/', $html, $matches)) {
            $this->paginationParam = $matches[1];
            Log::info("DGMarket Scraper: Paramètre de pagination détecté : {$this->paginationParam}");
        }
    }

    private function extractOffreData(\DOMElement $item, DOMXPath $xpath): ?array
    {
        try {
            // 1. Extraire les informations de base
            $titre = null;
            $lien = null;
            $tenderId = null;
            
            // Chercher le lien tenderId
            $linkNode = $xpath->query(".//a[contains(@href, '/tender/') or contains(@href, 'noticeId=')]", $item)->item(0);
            if ($linkNode) {
                $href = $linkNode->getAttribute('href');
                $titre = trim($linkNode->textContent);
                
                if (preg_match('/\/tender\/(\d+)/', $href, $matches)) {
                    $tenderId = $matches[1];
                    $lien = $this->normalizeUrl($href);
                } elseif (preg_match('/noticeId=(\d+)/', $href, $matches)) {
                    $tenderId = $matches[1];
                    $lien = $this->normalizeUrl($href);
                }
            }
            
            // Si le titre est très court, chercher un autre lien dans le même bloc
            if (strlen($titre) < 10) {
                $linkNodes = $xpath->query(".//a[contains(@href, '/tender/')]", $item);
                foreach ($linkNodes as $ln) {
                    if (strlen(trim($ln->textContent)) > strlen($titre)) {
                        $titre = trim($ln->textContent);
                    }
                }
            }

            if (!$titre || !$lien || !$tenderId) {
                return null;
            }
            
            // 2. Extraire les dates (recherche robuste dans tout le bloc)
            $datePublication = null;
            $dateLimite = null;

            // Essayer par classe d'abord (plus permissif avec //*)
            $pubNode = $xpath->query(".//*[contains(@class, 'ln_date')]", $item)->item(0);
            if ($pubNode) $datePublication = $this->parseListDate($pubNode->textContent);

            $deadlineNode = $xpath->query(".//*[contains(@class, 'ln_deadline')]", $item)->item(0);
            if ($deadlineNode) $dateLimite = $this->parseListDate($deadlineNode->textContent);

            // Fallback par texte si toujours pas de dates
            if (!$datePublication) {
                $nodes = $xpath->query(".//*[contains(text(), 'Publié') or contains(text(), 'Published')]/following::*[contains(@class, 'ln_date') or self::div or self::span][1]", $item);
                if ($nodes->length > 0) $datePublication = $this->parseListDate($nodes->item(0)->textContent);
            }
            if (!$dateLimite) {
                $nodes = $xpath->query(".//*[contains(text(), 'Date limite') or contains(text(), 'Deadline') or contains(text(), 'Closing')]/following::*[contains(@class, 'ln_deadline') or self::div or self::span][1]", $item);
                if ($nodes->length > 0) $dateLimite = $this->parseListDate($nodes->item(0)->textContent);
            }

            // Si toujours rien, scanner tous les enfants pour des dates potentielles
            if (!$datePublication || !$dateLimite) {
                $allText = $item->textContent;
                // On pourrait ajouter un scanner regex ici si besoin, 
                // mais parseListDate est déjà assez robuste si on lui donne le bon fragment.
            }

            // 3. Extraire le pays (recherche robuste)
            $pays = 'Africa';
            $countryNodes = $xpath->query(".//span[contains(text(), 'Pays') or contains(text(), 'Location') or contains(text(), 'Country')]/following-sibling::span", $item);
            if ($countryNodes->length > 0) {
                $pays = trim($countryNodes->item(0)->textContent);
            } else {
                // Fallback: scanner tout le texte pour des noms de pays africains
                $text = \App\Services\CountryMatcher::normalize($item->textContent);
                foreach (self::AFRICAN_COUNTRIES as $country) {
                    $normalizedCountry = \App\Services\CountryMatcher::normalize($country);
                    if (str_contains($text, $normalizedCountry)) {
                        $pays = $country;
                        break;
                    }
                }
            }

            // 4. Acheteur (plus rare dans la liste, on met une valeur par défaut)
            $acheteur = 'DGMarket';

            return [
                'titre' => $titre,
                'acheteur' => $acheteur,
                'pays' => $pays,
                'date_limite_soumission' => $dateLimite,
                'date_publication' => $datePublication,
                'lien_source' => $lien,
                'source' => 'DGMarket',
                'detail_url' => $lien,
                'link_type' => 'detail',
                'notice_type' => 'Notice',
                'project_id' => $tenderId,
                'market_type' => MarketTypeClassifier::classify($titre . ' ' . $acheteur),
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

            $response = Http::timeout(5)
                ->withOptions(['cookies' => $this->cookieJar])
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ])
                ->get($url);
            
            if (!$response->successful()) {
                Log::warning('DGMarket Scraper: Failed to fetch detail page', ['url' => $url, 'status' => $response->status()]);
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
        $deadlineKeywords = [
            'deadline', 'closing date', 'submission date', 'due date',
            'date limite', 'date de clôture', 'date de soumission', 'échéance', 'remise des offres'
        ];
        
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
     * Extrait la date de publication depuis la page détail
     */
    private function extractPublicationDate(array $detailData): ?string
    {
        if (empty($detailData['xpath'])) {
            return null;
        }
        
        $xpath = $detailData['xpath'];
        $text = strtolower($detailData['xpath']->evaluate('string(//body)'));
        
        // Chercher des patterns de date après "publication date", "published", "date de publication"
        $pubKeywords = ['publication date', 'published', 'date de publication', 'publié le', 'notice date'];
        
        foreach ($pubKeywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                $pos = stripos($text, $keyword);
                $substring = substr($text, $pos, 200);
                
                $patterns = [
                    // dd/mm/yyyy
                    '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
                    // yyyy-mm-dd
                    '/(\d{4})-(\d{2})-(\d{2})/',
                    // dd Mon yyyy (English)
                    '/(\d{1,2})\s+(january|jan|february|feb|march|mar|april|apr|may|june|jun|july|jul|august|aug|september|sep|sept|october|oct|november|nov|december|dec)[a-z]*\.?\s+(\d{4})/i',
                    // dd Mon yyyy (French)
                    '/(\d{1,2})\s+(janvier|janv|février|fev|mars|avril|avr|mai|juin|juillet|juil|août|aout|septembre|sept|octobre|oct|novembre|nov|décembre|dec)[a-z]*\.?\s+(\d{4})/i',
                    // Mon dd, yyyy
                    '/(january|jan|february|feb|march|mar|april|apr|may|june|jun|july|jul|august|aug|september|sep|sept|october|oct|november|nov|december|dec)[a-z]*\.?\s+(\d{1,2}),?\s+(\d{4})/i',
                ];
                
                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, $substring, $matches)) {
                        try {
                            $dateStr = $matches[0];
                            // Essayer d'abord le format d/m/Y si des shlashs sont présents
                            if (strpos($dateStr, '/') !== false) {
                                return \Carbon\Carbon::createFromFormat('d/m/Y', $dateStr)->format('Y-m-d');
                            }
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
        $textToCheck = \App\Services\CountryMatcher::normalize($offre['titre'] . ' ' . ($offre['pays'] ?? '') . ' ' . ($offre['acheteur'] ?? ''));
        
        // Vérifier les pays africains
        foreach (self::AFRICAN_COUNTRIES as $country) {
            $normalizedCountry = \App\Services\CountryMatcher::normalize($country);
            if (str_contains($textToCheck, $normalizedCountry)) {
                return true;
            }
        }
        
        // Vérifier "Africa" ou "Afrique" (déjà inclus dans la liste mais par sécurité)
        if (str_contains($textToCheck, 'africa') || 
            str_contains($textToCheck, 'afrique')) {
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
        // Si l'URL est au format /tender/{id} ou /tenders/np-notice.do, elle est considérée comme valide
        if (preg_match('/\/tender\/\d+/', $url) || preg_match('/noticeId=\d+/', $url)) {
            // Vérifier quand même avec une requête GET (plus fiable que HEAD)
            try {
                $response = Http::withOptions(['cookies' => $this->cookieJar])
                    ->withoutVerifying()
                    ->timeout(30)
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

    private function parseListDate(string $dateStr): ?string
    {
        // Format typique: Fév 9, 2026 ou Feb 9, 2026 ou Février 9, 2026
        // Nettoyage des espaces insécables et autres caractères bizarres
        $dateStr = str_replace(["\xc2\xa0", "\xa0", "\r", "\n", "\t"], ' ', $dateStr);
        $dateStr = trim($dateStr);
        if (empty($dateStr)) return null;

        $months = [
            'janvier' => 'Jan', 'janv' => 'Jan', 'jan' => 'Jan',
            'février' => 'Feb', 'févr' => 'Feb', 'fév' => 'Feb', 'fevrier' => 'Feb', 'fev' => 'Feb',
            'mars' => 'Mar', 'mar' => 'Mar',
            'avril' => 'Apr', 'avr' => 'Apr', 'apr' => 'Apr',
            'mai' => 'May', 'may' => 'May',
            'juin' => 'Jun', 'jun' => 'Jun',
            'juillet' => 'Jul', 'juil' => 'Jul', 'jul' => 'Jul',
            'août' => 'Aug', 'aout' => 'Aug', 'aug' => 'Aug',
            'septembre' => 'Sep', 'sept' => 'Sep', 'sep' => 'Sep',
            'octobre' => 'Oct', 'oct' => 'Oct',
            'novembre' => 'Nov', 'nov' => 'Nov',
            'décembre' => 'Dec', 'déc' => 'Dec', 'dec' => 'Dec'
        ];

        // Remplacement des mois français par anglais pour Carbon
        $lowerStr = mb_strtolower($dateStr);
        
        // Trier les clés par longueur décroissante pour éviter de remplacer "janv" par "Jan" puis de laisser "v"
        uksort($months, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($months as $fr => $en) {
            if (mb_strpos($lowerStr, $fr) !== false) {
                // Utilisation de regex pour remplacer le mot entier ou l'abréviation suivie d'un point optionnel
                $dateStr = preg_replace('/\b' . preg_quote($fr, '/') . '\.?\b/iu', $en, $dateStr);
                // Si le regex n'a pas marché (parce que pas de word boundary claire), fallback simple
                if (mb_stripos($dateStr, $en) === false) {
                    $dateStr = str_ireplace($fr, $en, $dateStr);
                }
                break; 
            }
        }
        
        try {
            // Nettoyer encore un peu avant le parse
            $dateStr = preg_replace('/\s+/', ' ', $dateStr);
            return \Carbon\Carbon::parse($dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::debug('DGMarket Scraper: Failed to parse date string', ['original' => $dateStr, 'error' => $e->getMessage()]);
            return null;
        }
    }
}
