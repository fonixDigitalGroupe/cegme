<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use DOMDocument;
use DOMXPath;
use App\Services\MarketTypeClassifier;

class AfDBScraperService implements IterativeScraperInterface
{
    /**
     * URL de base pour les appels d'offres AfDB (Mise à jour selon demande utilisateur)
     */
    private const BASE_URL = 'https://www.afdb.org/fr/documents/project-related-procurement/procurement-notices/invitation-for-bids';

    /**
     * Nombre maximum de pages à scraper (sécurité pour éviter les boucles infinies)
     */
    private const MAX_PAGES = 200;

    /**
     * ID du job en cours pour le suivi de progression
     * @var string|null
     */
    private $jobId = null;

    /**
     * État du scraper pour le mode itératif
     */
    private $currentPage = 0;        // Page courante
    private $isExhausted = false;    // Plus d'offres disponibles
    private $pendingOffers = [];     // Buffer d'offres en attente de traitement

    /**
     * Définit l'ID du job pour le suivi de progression
     */
    public function setJobId(?string $jobId): void
    {
        $this->jobId = $jobId;
    }

    /**
     * Scrape les appels d'offres depuis le site AfDB
     *
     * @return array ['count' => int, 'stats' => array] Nombre d'appels d'offres récupérés et statistiques
     */
    public function scrape(): array
    {
        // Note: Le vidage de la table est géré par la commande principale (app:scrape-active-sources)
        // Ici on scrappe uniquement les offres African Development Bank

        $totalCount = 0;
        $page = 0;
        $pagesStats = [];

        try {
            // USER REQUEST: Respecter la pagination sur 10 page au maximum
            $maxPages = max(1, min((int) env('AFDB_MAX_PAGES', 10), 10)); // Force 10 max as requested
            while ($page < $maxPages) {
                Log::debug("AfDB Scraper: Fetching page {$page}");

                $result = $this->scrapePage($page);
                $count = $result['count'];
                $totalCount += $count;

                $pagesStats[$page] = $count;

                if ($page % 10 === 0 || $count > 0) {
                    Log::info("AfDB Scraper: Page {$page} traitée", [
                        'offres_trouvees' => $count,
                        'total_accumule' => $totalCount,
                    ]);
                }

                // Arrêter seulement si aucune offre trouvée ET qu'on a déjà essayé plusieurs pages
                // (pour éviter d'arrêter trop tôt si la première page est vide)
                if ($count === 0 && $page > 0) {
                    Log::info("AfDB Scraper: Page {$page} a retourné 0 offres, arrêt.");
                    break;
                }

                // Continuer même si count = 0 sur la première page (peut être une page vide temporairement)

                $page++;
                usleep(200000); // 0.2 seconde entre les pages
            }

        } catch (\Exception $e) {
            Log::error('AfDB Scraper: Exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        $stats = [
            'total_pages_scraped' => $page,
            'total_notices_kept' => $totalCount,
            'offres_par_page' => $pagesStats,
        ];

        Log::info('AfDB Scraper: Résumé du scraping', $stats);

        return ['count' => $totalCount, 'stats' => $stats];
    }

    /**
     * Initialise le scraper pour le mode itératif
     */
    public function initialize(): void
    {
        $this->currentPage = 0;
        $this->isExhausted = false;
        $this->pendingOffers = [];
    }

    /**
     * Réinitialise l'état du scraper
     */
    public function reset(): void
    {
        $this->initialize();
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
        $count = 0; // Nouvelles offres
        $processed = 0; // Total traitées

        // D'abord, traiter les offres en attente dans le buffer
        while (count($this->pendingOffers) > 0 && $processed < $limit) {
            $offerData = array_shift($this->pendingOffers);
            $processed++;

            try {
                $existing = Offre::where('source', 'African Development Bank')
                    ->where(function ($q) use ($offerData) {
                        $q->where('lien_source', $offerData['lien_source'])
                            ->orWhere('titre', $offerData['titre']);
                    })
                    ->first();

                if ($existing) {
                    $existing->update([
                        'pays' => $offerData['pays'] ?? $existing->pays,
                        'date_limite_soumission' => $offerData['date_limite_soumission'] ?? $existing->date_limite_soumission,
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
                Log::error('AfDB Scraper: Error saving offer', [
                    'titre' => $offerData['titre'] ?? 'N/A',
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Si on n'a pas atteint la limite et qu'on n'est pas épuisé, scraper plus
        while ($processed < $limit && !$this->isExhausted) {
            $result = $this->scrapePageForBatch($this->currentPage);

            if ($result['count'] === 0) {
                $this->isExhausted = true;
                break;
            }

            // Note: Les offres sont déjà sauvegardées dans scrapePageForBatch pour un feedback immédiat
            $count += $result['new_count'] ?? 0;
            $processed += $result['count'];
            $findings = array_merge($findings, $result['offers']);
            
            $this->currentPage++;
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
        $newCount = 0;

        try {
            $url = self::BASE_URL;
            if ($page > 0) {
                $url .= '?page=' . ($page + 1);
            }

            Log::debug("AfDB Scraper: Fetching page for batch", ['page' => $page, 'url' => $url]);

            $html = Browsershot::url($url)
                ->setChromePath('/usr/bin/google-chrome')
                ->setNodeBinary('/usr/bin/node')
                ->ignoreHttpsErrors()
                ->waitUntilNetworkIdle()
                ->timeout(60)
                ->setOption('args', [
                    '--no-sandbox',
                    '--disable-setuid-sandbox',
                    '--disable-dev-shm-usage',
                    '--disable-accelerated-2d-canvas',
                    '--disable-gpu',
                    '--ignore-certificate-errors',
                ])
                ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                ->bodyHtml();

            if (empty($html)) {
                return ['count' => 0, 'offers' => []];
            }
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Extraire les notices
            $items = $this->extractProcurementItems($xpath, $dom);

            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);

                    if ($offre && !empty($offre['titre']) && !empty($offre['lien_source'])) {
                        // SAVE IMMEDIATELY (Same as scrapePage)
                        $existing = Offre::where('source', 'African Development Bank')
                            ->where(function ($q) use ($offre) {
                                $q->where('lien_source', $offre['lien_source'])
                                    ->orWhere('titre', $offre['titre']);
                            })
                            ->first();

                        if (!$existing) {
                            Offre::create($offre);
                            $newCount++;
                        } else {
                            $existing->update([
                                'pays' => $offre['pays'] ?? $existing->pays,
                                'date_limite_soumission' => $offre['date_limite_soumission'] ?? $existing->date_limite_soumission,
                                'market_type' => $offre['market_type'] ?? $existing->market_type,
                                'notice_type' => $offre['notice_type'] ?? $existing->notice_type,
                                'updated_at' => now(),
                            ]);
                        }
                        $offers[] = $offre;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

        } catch (\Exception $e) {
            Log::error('AfDB Scraper: Exception in scrapePageForBatch', [
                'page' => $page,
                'error' => $e->getMessage(),
            ]);
        }

        return [
            'count' => count($offers),
            'new_count' => $newCount,
            'offers' => $offers,
        ];
    }

    /**
     * Scrape une page spécifique
     *
     * @param int $page Numéro de la page
     * @return array ['count' => int, 'html' => string] Nombre d'appels d'offres récupérés et HTML de la page
     */
    private function scrapePage(int $page): array
    {
        $count = 0;
        $html = '';
        $findingsBuffer = [];
        $progressService = $this->jobId ? app(\App\Services\ScrapingProgressService::class) : null;

        try {
            // Construire l'URL avec pagination
            $url = self::BASE_URL;
            if ($page > 0) {
                // Essayer différents formats de pagination
                $url .= '?page=' . ($page + 1); // Page 1, 2, 3...
            }

            Log::debug("AfDB Scraper: Fetching page", ['page' => $page, 'url' => $url]);

            // Utiliser Browsershot (navigateur headless) pour contourner la protection anti-bot
            // Browsershot utilise Chrome headless qui ressemble à un vrai navigateur
            try {
                Log::debug('AfDB Scraper: Using Browsershot to fetch page', ['url' => $url]);

                $html = Browsershot::url($url)
                    ->setChromePath('/usr/bin/google-chrome')
                    ->setNodeBinary('/usr/bin/node')
                    ->waitUntilNetworkIdle()
                    ->timeout(90) // Augmenté à 90s pour plus de stabilité
                    ->setOption('args', [
                        '--no-sandbox',
                        '--disable-setuid-sandbox',
                        '--disable-dev-shm-usage',
                        '--disable-accelerated-2d-canvas',
                        '--disable-gpu',
                        '--disable-blink-features=AutomationControlled',
                    ])
                    ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->bodyHtml();

                if (empty($html)) {
                    Log::warning('AfDB Scraper: Browsershot returned empty HTML', ['url' => $url]);
                    return ['count' => 0, 'html' => ''];
                }

                Log::debug('AfDB Scraper: Successfully fetched page with Browsershot', [
                    'url' => $url,
                    'html_length' => strlen($html),
                ]);

            } catch (\Exception $e) {
                Log::error('AfDB Scraper: Browsershot failed, falling back to HTTP', [
                    'error' => $e->getMessage(),
                    'url' => $url,
                ]);

                // Retour à Browsershot car le contenu est chargé via JS
                $html = Browsershot::url($url)
                    ->setChromePath('/usr/bin/google-chrome')
                    ->setNodeBinary('/usr/bin/node')
                    ->ignoreHttpsErrors()
                    ->waitUntilNetworkIdle()
                    ->timeout(60)
                    ->setOption('args', [
                        '--no-sandbox',
                        '--disable-setuid-sandbox',
                        '--disable-dev-shm-usage',
                        '--disable-accelerated-2d-canvas',
                        '--disable-gpu',
                        '--ignore-certificate-errors',
                    ])
                    ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->bodyHtml();

                if (empty($html)) {
                    Log::warning('AfDB Scraper: Browsershot returned empty HTML for list page', ['url' => $url]);
                    return ['count' => 0, 'html' => ''];
                }
            }

            // Parser le HTML
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Extraire les notices de procurement
            $items = $this->extractProcurementItems($xpath, $dom);

            Log::info('AfDB Scraper: Items found', ['page' => $page, 'count' => count($items)]);

            // Si aucun item trouvé, essayer une extraction plus large
            if (count($items) === 0) {
                Log::info('AfDB Scraper: No items with standard selectors, trying broader extraction');

                // Chercher tous les éléments qui pourraient contenir des appels d'offres
                $allDivs = $xpath->query("//div[contains(@class, 'content') or contains(@class, 'item') or contains(@class, 'card') or contains(@class, 'article')]");
                foreach ($allDivs as $div) {
                    $text = trim($div->textContent);
                    $links = $xpath->query(".//a[@href]", $div);
                    // Si l'élément a du texte substantiel et un lien
                    if (strlen($text) > 50 && $links->length > 0) {
                        $items[] = $div;
                    }
                }
                Log::info('AfDB Scraper: Items found with broader extraction', ['count' => count($items)]);
            }

            // Traiter chaque item et collecter les offres valides avec validation stricte
            $validOffres = [];
            $titresVus = []; // Pour détecter les doublons

            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);

                    if (!$offre || empty($offre['titre']) || empty($offre['lien_source'])) {
                        continue;
                    }

                    // VALIDATION: Rejeter seulement les doublons de titres
                    $titreNormalise = $this->normalizeTitle($offre['titre']);
                    if (isset($titresVus[$titreNormalise])) {
                        Log::debug('AfDB Scraper: Titre dupliqué rejeté', ['titre' => $offre['titre']]);
                        continue;
                    }
                    $titresVus[$titreNormalise] = true;

                    // Si le titre et le lien existent, l'offre est valide
                    // (le lien est déjà validé lors de l'extraction)
                    Log::debug('AfDB Scraper: Offre acceptée', [
                        'titre' => $offre['titre'],
                        'lien' => $offre['lien_source'],
                        'pays' => $offre['pays'],
                        'date_pub' => $offre['date_publication'],
                        'html_sample_large' => substr($dom->saveHTML($item), 0, 3000)
                    ]);

                    // Sauvegarder immédiatement l'offre
                    try {
                        $existing = Offre::where('source', 'African Development Bank')
                            ->where(function ($q) use ($offre) {
                                $q->where('lien_source', $offre['lien_source'])
                                    ->orWhere('titre', $offre['titre']);
                            })
                            ->first();

                        if ($existing) {
                            Log::info("AfDB Scraper: Updating existing offer: " . $offre['titre']);
                            $existing->update([
                                'pays' => $offre['pays'] ?? $existing->pays,
                                'date_publication' => $offre['date_publication'] ?? $existing->date_publication,
                                'date_limite_soumission' => $offre['date_limite_soumission'] ?? $existing->date_limite_soumission,
                                'updated_at' => now(),
                            ]);
                        } else {
                            Log::info("AfDB Scraper: Creating new offer: " . $offre['titre']);
                            $offre['created_at'] = now();
                            $offre['updated_at'] = now();
                            $created = Offre::create($offre);
                            Log::info("AfDB Scraper: Offer created with ID: " . $created->id);
                            $count++;
                        }

                        // Ajouter au buffer pour le feedback UI
                        $findingsBuffer[] = $offre;
                        if (count($findingsBuffer) >= 5) { // Réduit à 5 pour feedback plus rapide
                            if ($progressService && $this->jobId) {
                                $progressService->addFindings($this->jobId, $findingsBuffer);
                            }
                            $findingsBuffer = [];
                        }

                    } catch (\Exception $e) {
                        Log::error('AfDB Scraper: Error saving offer', [
                            'titre' => $offre['titre'],
                            'error' => $e->getMessage()
                        ]);
                    }

                } catch (\Exception $e) {
                    Log::debug('AfDB Scraper: Error processing item', [
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }
            }

            // Envoyer le reste du buffer
            if (!empty($findingsBuffer) && $progressService && $this->jobId) {
                $progressService->addFindings($this->jobId, $findingsBuffer);
            }

        } catch (\Exception $e) {
            Log::error('AfDB Scraper: Exception occurred while scraping page', [
                'page' => $page,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return ['count' => $count, 'html' => $html];
    }

    /**
     * Extrait les éléments de procurement depuis le DOM (Stratégie AFD)
     *
     * @param DOMXPath $xpath
     * @param DOMDocument $dom
     * @return array
     */
    private function extractProcurementItems(DOMXPath $xpath, DOMDocument $dom): array
    {
        $items = [];
        $processedHashes = [];

        // Stratégie "Climb-up" (AFD) : Chercher les liens valides et remonter vers le parent
        $linkPatterns = [
            "//a[contains(@href, '/documents/')]",
            "//a[contains(@href, '/procurement/')]",
            "//a[contains(@href, 'procurement-notice')]",
        ];

        foreach ($linkPatterns as $pattern) {
            $links = $xpath->query($pattern);
            foreach ($links as $link) {
                $url = $this->normalizeUrl($link->getAttribute('href'));
                
                // Valider le lien avant de remonter
                if (!$this->isValidLink($url)) {
                    continue;
                }

                // Remonter jusqu'à trouver un conteneur significatif (stratégie AFD)
                $parent = $link;
                for ($i = 0; $i < 10; $i++) { // Augmenté à 10 pour être sûr de choper la date
                    $parent = $parent->parentNode;
                    if (!$parent || $parent->nodeName === 'body') break;
                    
                    if ($parent->nodeType === XML_ELEMENT_NODE) {
                        $hash = spl_object_hash($parent);
                        $text = trim($parent->textContent);
                        $class = $parent->getAttribute('class');
                        $nodeName = strtolower($parent->nodeName);

                        // Rejeter si c'est manifestement une zone de navigation/langues
                        if (stripos($text, 'العربية') !== false || stripos($text, 'English') !== false || stripos($text, 'Português') !== false) {
                            continue;
                        }

                        // Identifier un conteneur de ligne (Row container)
                        $isRow = (
                            stripos($class, 'views-row') !== false || 
                            stripos($class, 'col-lg-') !== false ||
                            stripos($class, 'col-md-') !== false ||
                            $nodeName === 'tr' || 
                            $nodeName === 'li' ||
                            stripos($class, 'item-list') !== false
                        );
                        
                        // Chercher si ce parent contient une date
                        $hasDate = preg_match('/(\d{1,2})[\s\/-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|Janavier|Février|Mars|Avril|Mai|Juin|Juillet|Août|Septembre|Octobre|Novembre|Décembre)[a-z]*\.?[\s\/-](\d{4})/iu', $text);
                        
                        if (($isRow || (strlen($text) > 150 && $hasDate)) && !isset($processedHashes[$hash])) {
                            $items[] = $parent;
                            $processedHashes[$hash] = true;
                            break;
                        }
                    }
                }
            }
        }

        // Si toujours rien, essayer les sélecteurs classiques (fallback)
        if (count($items) < 3) {
            $selectors = [
                "//div[contains(@class, 'views-row')]",
                "//div[contains(@id, 'block-system-main')]//tr",
                "//article",
                "//div[contains(@class, 'card')]"
            ];
            foreach ($selectors as $selector) {
                $nodes = $xpath->query($selector);
                foreach ($nodes as $node) {
                    $hash = spl_object_hash($node);
                    if (!isset($processedHashes[$hash]) && strlen(trim($node->textContent)) > 50) {
                        $items[] = $node;
                        $processedHashes[$hash] = true;
                    }
                }
            }
        }

        return $items;
    }

    /**
     * Extrait les données d'une offre depuis un élément DOM
     * RÈGLE: Le titre EST le lien - utiliser directement le href du lien titre
     *
     * @param \DOMElement $item
     * @param DOMXPath $xpath
     * @return array|null
     */
    private function extractOffreData(\DOMElement $item, DOMXPath $xpath): ?array
    {
        try {
            // RÈGLE MANDATAIRE: Chercher les liens qui sont les titres des notices
            // Chaque notice a un lien <a> dont le texte est le titre et le href est l'URL de détail
            $lien = null;
            $titre = null;

            // Chercher tous les liens dans l'élément
            $linkNodes = $xpath->query(".//a[@href]", $item);

            foreach ($linkNodes as $link) {
                $href = $link->getAttribute('href');
                $linkText = trim($link->textContent);
                
                // DEBUG: Log first few items context (skip garbage)
                static $debugCount = 0;
                $textContent = trim($item->textContent);
                if ($debugCount < 10 && stripos($textContent, 'العربية') === false) {
                    Log::debug('AfDB Scraper Debug: FULL item context', [
                        'text' => $textContent,
                        'link' => $href
                    ]);
                    $debugCount++;
                }

                // Ignorer les liens vers d'autres langues
                if (preg_match('#/(ar|en|pt)/#i', $href) && strpos($href, '/fr/') === false) {
                     continue;
                }

                // Ignorer les liens de navigation évidents
                if (
                    stripos($href, 'javascript:') !== false ||
                    stripos($href, '#') === 0 ||
                    stripos($href, 'mailto:') !== false ||
                    stripos($linkText, 'see more') !== false ||
                    stripos($linkText, 'next') !== false ||
                    stripos($linkText, 'previous') !== false ||
                    strlen($linkText) < 20
                ) {
                    continue;
                }
                if (preg_match('/\.(xml|rss|atom)$/i', $href)) {
                    continue;
                }

                // Ignorer les liens vers la plateforme E-Consultant (mais pas les liens depuis afdb.org)
                if (stripos($href, 'econsultant.afdb.org') !== false) {
                    continue;
                }

                // Ignorer les liens de pagination (avec paramètres page=)
                if (preg_match('/[?&]page=/i', $href)) {
                    continue;
                }

                // Si le lien a un texte substantiel (titre de notice), c'est notre notice
                // Le texte du lien EST le titre, le href EST l'URL de détail
                if (strlen($linkText) > 20 && strlen($linkText) < 500) {
                    // VALIDATION STRICTE DU LIEN AVANT TOUTE ANALYSE LENTE
                    if (!$this->isValidLink($href)) {
                        Log::debug('AfDB Scraper: Link rejected by isValidLink', ['url' => $href]);
                        continue;
                    }

                    // Normaliser l'URL mais garder le href exact
                    $hrefNormalized = $this->normalizeUrl($href);

                    // Vérifier que ce n'est pas une page de liste générique
                    // (mais accepter les liens vers des pages spécifiques même si elles contiennent /procurement)
                    if (
                        stripos($hrefNormalized, '/procurement?') === false &&
                        stripos($hrefNormalized, '/procurement#') === false &&
                        stripos($hrefNormalized, 'econsultant.afdb.org') === false
                    ) {
                        $titre = $linkText;
                        $lien = $hrefNormalized; // Utiliser EXACTEMENT le href fourni (normalisé)
                        break; // Prendre le premier lien valide trouvé
                    }
                }
            }

            // Si aucun lien titre trouvé, rejeter l'item
            if (!$titre || !$lien) {
                return null;
            }

            // VALIDATION DU TITRE (STRICTE - User Request)
            if (!$this->isValidTitle($titre)) {
                 Log::debug('AfDB Scraper: Titre invalidé (trop court ou générique)', ['titre' => $titre]);
                 return null;
            }

            // RÈGLE PRIORITAIRE: Chercher le pays via les acronymes du titre (Ex: AAO - RCA - ...)
            // Cela évite les faux positifs trouvés dans le texte (ex: Egypte mentionné dans le footer)
            $pays = $this->extractCountryFromTitle($titre);

            if (empty($pays)) {
                // Extraire le pays/zone géographique via le texte de l'élément (fallback)
                $pays = $this->extractCountry($item, $xpath);
            }

            // Classification du type de marché (AFD method)
            $marketType = MarketTypeClassifier::classify($titre . ' ' . $item->textContent);

            // Extraire la date de publication
            $datePublication = $this->extractPublicationDate($item, $xpath);

            // FALLBACK: Si des informations essentielles manquent, aller chercher dans la page de détail
            if (empty($pays) || empty($datePublication)) {
                 Log::debug('AfDB Scraper: Missing info, fetching detail page', [
                     'url' => $lien,
                     'missing' => array_keys(array_filter([
                         'pays' => empty($pays),
                         'pub_date' => empty($datePublication)
                     ]))
                 ]);
                 
                 $detailData = $this->fetchDetailData($lien);
                 
                 if (empty($pays) && !empty($detailData['country'])) {
                      Log::debug('AfDB Scraper: Country found in detail page', ['pays' => $detailData['country']]);
                      $pays = $detailData['country'];
                 }
                 if (empty($datePublication) && !empty($detailData['publication_date'])) {
                      Log::debug('AfDB Scraper: Publication date found in detail page', ['date' => $detailData['publication_date']]);
                      $datePublication = $detailData['publication_date'];
                 }
                 if (empty($dateLimite) && !empty($detailData['deadline'])) {
                      Log::debug('AfDB Scraper: Deadline found in detail page', ['date' => $detailData['deadline']]);
                      $dateLimite = $detailData['deadline'];
                 }
            }

            // RÈGLE AFDB: Ne pas sauvegarder les offres sans date de publication (demande utilisateur)
            if (empty($datePublication)) {
                Log::debug('AfDB Scraper: Offre rejetée (pas de date de publication)', [
                    'titre' => $titre,
                    'lien' => $lien
                ]);
                return null;
            }

            // La date limite reste NULL pour AfDB (demande utilisateur)
            $dateLimite = null;

            return [
                'titre' => $this->cleanText($titre),
                'acheteur' => 'African Development Bank',
                'pays' => $pays,
                'date_publication' => $datePublication,
                'date_limite_soumission' => $dateLimite,
                'lien_source' => $lien,
                'source' => 'African Development Bank',
                'notice_type' => 'Procurement Notice',
                'market_type' => $marketType,
            ];

        } catch (\Exception $e) {
            Log::warning('AfDB Scraper: Error extracting data from item', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Extrait le pays/zone géographique depuis un élément
     */
    private function extractCountry(\DOMElement $item, DOMXPath $xpath): ?string
    {
        $text = $item->textContent;

        // Liste des pays africains et zones géographiques
        $countries = [
            'Algeria',
            'Angola',
            'Benin',
            'Botswana',
            'Burkina Faso',
            'Burundi',
            'Cameroon',
            'Cape Verde',
            'Central African Republic',
            'Chad',
            'Comoros',
            'Congo',
            'Côte d\'Ivoire',
            'Djibouti',
            'Egypt',
            'Equatorial Guinea',
            'Eritrea',
            'Eswatini',
            'Ethiopia',
            'Gabon',
            'Gambia',
            'Ghana',
            'Guinea',
            'Guinea-Bissau',
            'Kenya',
            'Lesotho',
            'Liberia',
            'Libya',
            'Madagascar',
            'Malawi',
            'Mali',
            'Mauritania',
            'Mauritius',
            'Morocco',
            'Mozambique',
            'Namibia',
            'Niger',
            'Nigeria',
            'Rwanda',
            'São Tomé and Príncipe',
            'Senegal',
            'Seychelles',
            'Sierra Leone',
            'Somalia',
            'South Africa',
            'South Sudan',
            'Sudan',
            'Tanzania',
            'Togo',
            'Tunisia',
            'Uganda',
            'Zambia',
            'Zimbabwe',
            // Noms en Français
            'Algérie', 'Angola', 'Bénin', 'Botswana', 'Burkina Faso', 'Burundi', 'Cameroun', 'Cap-Vert', 
            'République Centrafricaine', 'Tchad', 'Comores', 'Congo', 'Côte d\'Ivoire', 'Djibouti', 'Égypte', 
            'Guinée Équatoriale', 'Érythrée', 'Eswatini', 'Éthiopie', 'Gabon', 'Gambie', 'Ghana', 'Guinée', 
            'Guinée-Bissau', 'Kenya', 'Lesotho', 'Liberia', 'Libye', 'Madagascar', 'Malawi', 'Mali', 
            'Mauritanie', 'Maurice', 'Maroc', 'Mozambique', 'Namibie', 'Niger', 'Nigeria', 'Rwanda', 
            'São Tomé et Príncipe', 'Sénégal', 'Seychelles', 'Sierra Leone', 'Somalie', 'Afrique du Sud', 
            'Soudan du Sud', 'Soudan', 'Tanzanie', 'Togo', 'Tunisie', 'Ouganda', 'Zambie', 'Zimbabwe',
            'RDC', 'République Démocratique du Congo',
        ];

        $zones = [
            'West Africa',
            'East Africa',
            'Southern Africa',
            'Central Africa',
            'North Africa',
            'Sub-Saharan Africa',
            'Africa',
            'Multinational',
            'Regional',
        ];

        $foundItems = [];

        foreach ($countries as $country) {
            if (stripos($text, $country) !== false) {
                $foundItems[] = $country;
            }
        }

        foreach ($zones as $zone) {
            if (stripos($text, $zone) !== false) {
                $foundItems[] = $zone;
            }
        }

        $unique = array_unique($foundItems);

        // Si on trouve trop de pays (> 3), c'est probablement une liste déroulante ou un footer
        if (count($unique) > 3) {
            return null;
        }

        if (!empty($unique)) {
            return implode(', ', $unique);
        }

        return null;
    }

    /**
     * Extrait la date de publication ou deadline
     */
    private function extractPublicationDate(\DOMElement $item, DOMXPath $xpath): ?string
    {
        $text = $item->textContent;
        
        // Utiliser la méthode centralisée de parsing
        $date = $this->parseDateFromText($text);
        if ($date) {
            return $date;
        }

        // Si pas trouvé dans le texte brut, essayer de nettoyer un peu (enlever les labels)
        $cleanText = preg_replace('/(Date de publication|Published on|Publié le|Date|Publication Date|Deadline)[\s:]+/iu', '', $text);
        $date = $this->parseDateFromText($cleanText);
        if ($date) {
            return $date;
        }

        // Chercher aussi dans les attributs HTML (data-date, datetime, etc.)
        $dateAttributes = ['data-date', 'datetime', 'data-deadline', 'data-closing'];
        foreach ($dateAttributes as $attr) {
            $elements = $xpath->query(".//*[@{$attr}]", $item);
            foreach ($elements as $element) {
                $dateValue = $element->getAttribute($attr);
                if (!empty($dateValue)) {
                    $dateParsed = $this->parseDateFromText($dateValue);
                    if ($dateParsed) {
                        return $dateParsed;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Normalise une URL (relative -> absolue)
     */
    private function normalizeUrl(string $url): string
    {
        if (empty($url)) {
            return '';
        }

        // Si c'est déjà une URL complète
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        // Si c'est une URL relative
        if (str_starts_with($url, '/')) {
            return 'https://www.afdb.org' . $url;
        }

        return 'https://www.afdb.org/' . $url;
    }

    /**
     * Valide si un titre est un vrai appel d'offres (rejette les titres génériques)
     * 
     * @param string $titre
     * @return bool
     */
    private function isValidTitle(string $titre): bool
    {
        $titreLower = strtolower(trim($titre));

        // Titres génériques à REJETER absolument
        $forbiddenTitles = [
            'consultancy services (e-consultant)',
            'consultancy services',
            'procurement notice',
            'rules and procedures for the procurement of goods and works',
            'expression of interest',
            'invitation to bid',
            'request for proposal',
            'request for proposals',
            'general procurement notice',
            'procurement plan',
            'contract award',
            'attribution de contrat',
            'attribution de marché',
            'attribution de marches',
            'resultats de l appel d offres',
            'notification of award',
            'contract award notice',
            'beneficial ownership disclosure form',
            'formulaire de divulgation des bénéficiaires effectifs',
        ];

        // IMPORTANT : On garde les "Plans de passation des marchés" s'ils ont un titre substantiel
        // car ils contiennent souvent des informations sur les futurs projets.
        // Mais on rejette les titres purement génériques.

        // Vérifier si le titre correspond exactement à un titre interdit
        foreach ($forbiddenTitles as $forbidden) {
            if ($titreLower === strtolower($forbidden)) {
                return false;
            }
        }
        
        // Check contains for strong reject patterns
        foreach ($forbiddenTitles as $forbidden) {
            if (stripos($titreLower, $forbidden) !== false) {
                 // Sauf si c'est un plan de passation de marchés (PPM) qui est souvent utile, mais ici on veut strict
                 if (stripos($titreLower, 'plan de passation') !== false || stripos($titreLower, 'procurement plan') !== false) {
                     continue; // On garde les PPM pour l'instant
                 }
                 return false;
            }
        }

        // Rejeter les titres qui commencent par ces patterns sans objet précis
        $genericPatterns = [
            'consultancy services',
            'procurement notice',
            'expression of interest',
        ];

        foreach ($genericPatterns as $pattern) {
            if (stripos($titreLower, $pattern) === 0 && strlen($titre) < 50) {
                // Si le titre commence par un pattern générique et est court, rejeter
                return false;
            }
        }

        // Le titre doit contenir des informations spécifiques (projet, pays, activité)
        // Un vrai appel d'offres a généralement plus de 40 caractères et contient des détails
        if (strlen($titre) < 40) {
            return false;
        }

        // Le titre doit contenir au moins un mot-clé indiquant un objet spécifique
        $specificKeywords = [
            'project',
            'program',
            'programme',
            'study',
            'consultant',
            'service',
            'supply',
            'works',
            'construction',
            'rehabilitation',
            'development',
            'management',
            'training',
            'assessment',
            'evaluation',
            'design',
            'implementation',
            'supervision',
            'projet',
            'programme',
            'étude',
            'consultant',
            'service',
            'fourniture',
            'travaux',
            'construction',
            'réhabilitation',
            'développement',
            'gestion',
            'formation',
            'évaluation',
            'conception',
            'mise en œuvre',
            'supervision',
            'renforcement',
            'résilience',
            'risque',
            'climatique',
            'agricole',
            'secteur',
        ];

        $hasSpecificKeyword = false;
        foreach ($specificKeywords as $keyword) {
            if (stripos($titreLower, $keyword) !== false) {
                $hasSpecificKeyword = true;
                break;
            }
        }

        // Si le titre contient un code de projet (ex: PreRAB, AGPM) ou un pays, c'est probablement valide
        if (!$hasSpecificKeyword) {
            // Vérifier si le titre contient un code de projet (majuscules/lettres-chiffres)
            if (preg_match('/\b[A-Z]{2,}[A-Z0-9]*\b/', $titre)) {
                $hasSpecificKeyword = true;
            }
        }

        return $hasSpecificKeyword;
    }

    /**
     * Valide si un lien est un lien direct vers un avis (rejette plateformes/listes)
     * 
     * @param string $url
     * @return bool
     */
    private function isValidLink(string $url): bool
    {
        $urlLower = strtolower($url);

        // 1. REJET ABSOLU : Patterns d'information, navigation ou réseaux sociaux
        $rejectPatterns = [
            'new-procurement-policy',
            'procurement-policy',
            '/about-us/',
            '/contact-us/',
            '/terms-and-conditions/',
            '/privacy-policy/',
            '/site-map/',
            '/news/',
            '/events/',
            '/multimedia/',
            '/en/projects-and-operations/project-portfolio',
            'consultancy-services-dacon',
            'resources-for-businesses',
            'resources-for-borrowers',
            'tools-reports',
            'frequently-asked-questions',
            'projects-procurements-services-contacts',
            'procurement-notices-workflow',
            'instagram.com',
            'facebook.com',
            'twitter.com',
            'linkedin.com',
            'youtube.com',
            'share=',
            'sharer.php',
            'intent/tweet',
            'econsultant.afdb.org',
            // Catégories à rejeter (Attention: ne pas rejeter les parents)
            '/contract-awards',
            '/corporate-procurement',
            '/general-procurement-notice', 
            '/specific-procurement-notice',
            '/expression-of-interest',
            '/request-for-expression-of-interest',
            '/consultancy-services',
            'beneficial-ownership-disclosure-form',
            'formulaire-de-divulgation-des-beneficiaires-effectifs',
            'attribution-de-contrat',
            'attribution-de-marche',
            'tribunal-administratif', 
            'administrative-tribunal',
            'appeals-board',
            '/board-decisions',
            '/financial-information',
            '/environmental-and-social-assessments',
            '/evaluation-reports',
            '/project-completion-reports',
            '/country-strategy-papers',
        ];

        foreach ($rejectPatterns as $pattern) {
            if (stripos($urlLower, $pattern) !== false) {
                return false;
            }
        }

        // 2. FILTRAGE DES PAGES DE LISTE GÉNÉRIQUES
        // On accepte /procurement/ seulement s'il y a un identifiant spécifique (chiffres ou slug long)
        if (stripos($urlLower, '/procurement') !== false) {
            // Rejeter la page de liste pure
            if (preg_match('/\/procurement\/?(\?.*|#.*)?$/', $urlLower)) {
                return false;
            }
            
            // Rejeter les liens qui ressemblent à des catégories/navigation (pas de chiffres, slug court)
            // Les vrais avis de marché ont souvent soit un ID numérique, soit un slug très spécifique
            $path = parse_url($urlLower, PHP_URL_PATH);
            $segments = explode('/', trim($path, '/'));
            $lastSegment = end($segments);
            
            if (strlen($lastSegment) < 15 && !preg_match('/\d/', $lastSegment)) {
                return false; // Probablement une page de navigation
            }
        }

        // 3. ACCEPTATION : Doit être dans la section procurement ou être un document
        $validPatterns = [
            '/procurement/',
            'procurement-notice',
            '.pdf',
            '.doc',
            '.docx',
            '/en/projects-and-operations/',
            '/en/documents/',
            '/fr/documents/',
            '/fr/projects-and-operations/',
            'invitation-for-bids',
        ];

        foreach ($validPatterns as $pattern) {
            if (stripos($urlLower, $pattern) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Normalise un titre pour détecter les doublons
     * 
     * @param string $titre
     * @return string
     */
    private function normalizeTitle(string $titre): string
    {
        // Normaliser : minuscules, supprimer espaces multiples, ponctuation
        $normalized = strtolower(trim($titre));
        $normalized = preg_replace('/\s+/', ' ', $normalized);
        $normalized = preg_replace('/[^\w\s]/', '', $normalized); // Supprimer ponctuation
        return $normalized;
    }

    /**
     * Valide une URL HTTP (teste si elle est accessible et ne redirige pas vers liste/plateforme)
     * 
     * @param string $url
     * @return bool
     */
    private function validateUrl(string $url): bool
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->withOptions([
                    'allow_redirects' => [
                        'max' => 5,
                        'strict' => true,
                        'referer' => true,
                    ],
                ])
                ->head($url); // Utiliser HEAD pour être plus rapide

            $status = $response->status();
            $finalUrl = $response->effectiveUri() ?? $url;

            // Accepter 200 OK
            if ($status === 200) {
                // Vérifier que l'URL finale n'est pas une plateforme/liste
                return $this->isValidLink($finalUrl);
            }

            // Accepter 301/302 seulement si la redirection mène à un lien valide
            if (in_array($status, [301, 302, 303, 307, 308])) {
                $location = $response->header('Location');
                if ($location) {
                    return $this->isValidLink($location);
                }
                // Si pas de Location header, vérifier l'URL finale
                return $this->isValidLink($finalUrl);
            }

            // Rejeter tous les autres codes
            Log::debug('AfDB Scraper: URL returned invalid status', [
                'url' => $url,
                'status' => $status,
            ]);
            return false;

        } catch (\Exception $e) {
            Log::debug('AfDB Scraper: URL validation failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            // En cas d'erreur, rejeter par sécurité
            return false;
        }
    }

    /**
     * Détermine le type de lien (detail ou document)
     * 
     * @param string $url
     * @return string
     */
    private function determineLinkType(string $url): string
    {
        $urlLower = strtolower($url);

        // Si c'est un document (PDF, DOC, etc.)
        if (preg_match('/\.(pdf|doc|docx)$/i', $urlLower)) {
            return 'document';
        }

        // Sinon c'est une page de détail
        return 'detail';
    }

    /**
     * Extrait la date limite de soumission depuis la page de détail
     * 
     * @param string $url URL de la page de détail
     * @return string|null Date au format Y-m-d ou null si non trouvée
     */
    private function extractDeadlineFromDetailPage(string $url): ?string
    {
        try {
            // Petit délai pour ne pas surcharger le serveur
            usleep(100000); // 0.1 seconde

            $html = '';

            // Essayer d'abord avec Browsershot pour les pages JavaScript
            try {
                Log::debug('AfDB Scraper: Using Browsershot to fetch detail page for deadline', ['url' => $url]);

                $html = Browsershot::url($url)
                    ->setChromePath('/usr/bin/google-chrome')
                    ->setNodeBinary('/usr/bin/node')
                    ->ignoreHttpsErrors()
                    ->waitUntilNetworkIdle()
                    ->timeout(60)
                    ->setOption('args', [
                        '--no-sandbox',
                        '--disable-setuid-sandbox',
                        '--disable-dev-shm-usage',
                        '--disable-accelerated-2d-canvas',
                        '--disable-gpu',
                        '--ignore-certificate-errors',
                    ])
                    ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->bodyHtml();

                if (empty($html)) {
                    Log::debug('AfDB Scraper: Browsershot returned empty HTML, trying HTTP fallback', ['url' => $url]);
                    throw new \Exception('Empty HTML from Browsershot');
                }
            } catch (\Exception $e) {
                // Fallback vers HTTP simple
                Log::debug('AfDB Scraper: Browsershot failed, using HTTP fallback', ['url' => $url, 'error' => $e->getMessage()]);

                $response = Http::withoutVerifying()
                    ->timeout(30)
                    ->retry(2, 1000)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    ])
                    ->get($url);

                if (!$response->successful()) {
                    Log::debug('AfDB Scraper: Failed to fetch detail page for deadline', ['url' => $url, 'status' => $response->status()]);
                    return null;
                }

                $html = $response->body();
            }

            if (empty($html)) {
                return null;
            }

            // Parser le HTML
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Chercher la date limite avec plusieurs stratégies

            // Stratégie 1: Chercher dans les éléments avec icônes de calendrier ou attributs de date
            $dateSelectors = [
                "//*[contains(@class, 'date')]",
                "//*[contains(@class, 'deadline')]",
                "//*[contains(@class, 'calendar')]",
                "//*[@data-date]",
                "//*[@datetime]",
                "//*[contains(@class, 'icon-calendar')]/following-sibling::*",
                "//*[contains(@class, 'fa-calendar')]/parent::*",
                "//*[contains(@class, 'calendar-icon')]/following-sibling::*",
            ];

            foreach ($dateSelectors as $selector) {
                try {
                    $elements = $xpath->query($selector);
                    foreach ($elements as $element) {
                        $text = trim($element->textContent);
                        $date = $this->parseDateFromText($text);
                        if ($date) {
                            Log::debug('AfDB Scraper: Found deadline date via selector', ['url' => $url, 'selector' => $selector, 'date' => $date]);
                            return $date;
                        }
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Stratégie 2: Chercher près des mots-clés de deadline dans le HTML
            $deadlineKeywords = [
                'deadline',
                'closing date',
                'submission deadline',
                'due date',
                'date limite',
                'date de clôture',
                'date limite de soumission',
                'closing',
                'submission date',
                'closing date for submission',
                'deadline for submission',
            ];

            $text = $html; // Garder le HTML original pour la recherche
            $textLower = strtolower($html);
            $textContent = strtolower($dom->textContent ?? '');

            // Patterns de date améliorés (incluant le format DD-MMM-YYYY)
            $datePatterns = [
                // Format DD-MMM-YYYY (19-Dec-2025)
                '/(\d{1,2})[\s-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*[\s-](\d{4})/i',
                // Format DD/MMM/YYYY
                '/(\d{1,2})\/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\/(\d{4})/i',
                // Formats américains complets
                '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})/i',
                '/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\.?\s+(\d{1,2}),?\s+(\d{4})/i',
                // Formats européens
                '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
                '/(\d{1,2})-(\d{1,2})-(\d{4})/',
                // Formats ISO
                '/(\d{4})-(\d{2})-(\d{2})/',
                // Format avec jour de la semaine
                '/(\d{1,2})\s+(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{4})/i',
            ];

            // Chercher près des mots-clés de deadline
            foreach ($deadlineKeywords as $keyword) {
                $keywordPos = stripos($textLower, $keyword);
                if ($keywordPos !== false) {
                    // Extraire 300 caractères autour du mot-clé (plus large pour capturer la date)
                    $context = substr($text, max(0, $keywordPos - 100), 400);
                    $contextLower = strtolower($context);

                    // Chercher une date dans ce contexte
                    foreach ($datePatterns as $pattern) {
                        if (preg_match($pattern, $context, $matches)) {
                            try {
                                $dateStr = $matches[0];
                                // Nettoyer la chaîne de date
                                $dateStr = preg_replace('/^(deadline|closing|due|submission)[\s:]+/i', '', $dateStr);
                                $dateStr = trim($dateStr);

                                $date = \Carbon\Carbon::parse($dateStr);
                                // Vérifier que la date est dans le futur ou pas trop ancienne (max 2 ans)
                                if ($date->isFuture() || $date->gt(now()->subYears(2))) {
                                    Log::debug('AfDB Scraper: Found deadline date near keyword', [
                                        'url' => $url,
                                        'keyword' => $keyword,
                                        'date' => $date->format('Y-m-d'),
                                        'original' => $dateStr
                                    ]);
                                    return $date->format('Y-m-d');
                                }
                            } catch (\Exception $e) {
                                continue;
                            }
                        }
                    }
                }
            }

            // Stratégie 3: Chercher toutes les dates dans la page et prendre la plus récente future
            $allDates = [];
            foreach ($datePatterns as $pattern) {
                if (preg_match_all($pattern, $textContent, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $match) {
                        try {
                            $dateStr = $match[0];
                            $date = \Carbon\Carbon::parse($dateStr);
                            // Garder seulement les dates futures ou récentes (max 2 ans)
                            if ($date->isFuture() || $date->gt(now()->subYears(2))) {
                                $allDates[] = [
                                    'date' => $date,
                                    'str' => $dateStr,
                                    'pos' => stripos($textContent, $dateStr)
                                ];
                            }
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                }
            }

            // Si plusieurs dates trouvées, prendre la plus récente (probablement la deadline)
            if (!empty($allDates)) {
                usort($allDates, function ($a, $b) {
                    return $a['date']->gt($b['date']) ? -1 : 1;
                });

                $bestDate = $allDates[0]['date'];
                Log::debug('AfDB Scraper: Found date in page (most recent)', [
                    'url' => $url,
                    'date' => $bestDate->format('Y-m-d'),
                    'total_dates_found' => count($allDates)
                ]);
                return $bestDate->format('Y-m-d');
            }

            Log::debug('AfDB Scraper: No deadline date found in detail page', ['url' => $url]);
            return null;

        } catch (\Exception $e) {
            Log::debug('AfDB Scraper: Error extracting deadline from detail page', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Parse une date depuis un texte
     * 
     * @param string $text
     * @return string|null Date au format Y-m-d ou null
     */
    private function parseDateFromText(string $text): ?string
    {
        if (empty($text)) {
            return null;
        }

        // Patterns de date (Ordre d'importance)
        $datePatterns = [
            // Format DD-MMM-YYYY (19-Dec-2025 ou 05-fév-2026)
            '/(\d{1,2})[\s\/-](Janvier|Février|Mars|Avril|Mai|Juin|Juillet|Août|Septembre|Octobre|Novembre|Décembre|Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|Janv|Févr|Fév|Mars|Avri|Avr|Mai|Juin|Juil|Août|Sept|Octo|Nove|Déce|Déc)[a-z]*\.?[\s\/-](\d{4})/iu',
            // Formats Français complets (19 Décembre 2025)
            '/(\d{1,2})\s+(Janvier|Février|Mars|Avril|Mai|Juin|Juillet|Août|Septembre|Octobre|Novembre|Décembre)\s+(\d{4})/iu',
            // Format DD-MM-YYYY
            '/(\d{1,2})[.\/-](\d{1,2})[.\/-](\d{4})/',
            // Format YYYY-MM-DD
            '/(\d{4})[.\/-](\d{1,2})[.\/-](\d{1,2})/',
            // Formats Anglais complets (December 19, 2025)
            '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})/i',
        ];

        foreach ($datePatterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                try {
                    $dateStr = $matches[0];
                    
                    // Normalisation des mois pour Carbon
                    $dateStr = str_ireplace(
                        ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                        ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        $dateStr
                    );
                    
                    $dateStr = str_ireplace(
                        ['Janv', 'Févr', 'Fév', 'Avri', 'Avr', 'Juil', 'Août', 'Sept', 'Octo', 'Nove', 'Déce', 'Déc'],
                        ['Jan', 'Feb', 'Feb', 'Apr', 'Apr', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Dec'],
                        $dateStr
                    );

                    $date = \Carbon\Carbon::parse($dateStr);
                    // Vérifier que la date est cohérente
                    if ($date->year > 2000 && $date->year < 2100) {
                        return $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return null;
    }

    /**
     * Extrait le pays depuis le titre en utilisant les acronymes connus
     */
    private function extractCountryFromTitle(string $title): ?string
    {
        $acronyms = [
            'RCA' => 'République Centrafricaine',
            'RDC' => 'République Démocratique du Congo',
            'DRC' => 'Democratic Republic of Congo',
            'CIV' => 'Côte d\'Ivoire',
            'GAB' => 'Gabon',
            'CMR' => 'Cameroun',
            'SEN' => 'Sénégal',
            'MLI' => 'Mali',
            'BFA' => 'Burkina Faso',
            'NER' => 'Niger',
            'TCD' => 'Tchad',
            'GIN' => 'Guinée',
            'GNB' => 'Guinée-Bissau',
            'MRT' => 'Mauritanie',
            'MAR' => 'Maroc',
            'TUN' => 'Tunisie',
            'EGY' => 'Égypte',
            'ALG' => 'Algérie',
            'ZAF' => 'Afrique du Sud',
            'UGA' => 'Ouganda',
            'KEN' => 'Kenya',
            'TZA' => 'Tanzanie',
            'ZMB' => 'Zambie',
            'ZWE' => 'Zimbabwe',
            'AGO' => 'Angola',
            'MOZ' => 'Mozambique',
            'NAM' => 'Namibie',
            'BWA' => 'Botswana',
            'LSO' => 'Lesotho',
            'SWZ' => 'Eswatini',
            'MDG' => 'Madagascar',
            'MUS' => 'Maurice',
            'SYC' => 'Seychelles',
            'DJI' => 'Djibouti',
            'SDN' => 'Soudan',
            'SSD' => 'Soudan du Sud',
            'ETH' => 'Éthiopie',
            'ERI' => 'Érythrée',
            'SOM' => 'Somalie',
        ];

        foreach ($acronyms as $acronym => $countryName) {
            // Chercher l'acronyme entouré d'espaces ou tirets
            if (strpos($title, " $acronym ") !== false || strpos($title, "- $acronym -") !== false) {
                return $countryName;
            }
        }

        return null;
    }

    /**
     * Récupère les données manquantes (Pays, Date Pub) depuis la page de détail
     * 
     * @param string $url
     * @return array ['country' => string|null, 'publication_date' => string|null, 'deadline' => string|null]
     */
    private function fetchDetailData(string $url): array
    {
        $data = [
            'country' => null,
            'publication_date' => null,
            'deadline' => null
        ];
        
        try {
            // Petit délai
            usleep(200000); 

            $html = '';

            // 1. Essayer HTTP simple (rapide)
            try {
                $response = Http::withoutVerifying()
                    ->timeout(20)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    ])
                    ->get($url);

                if ($response->successful()) {
                    $html = $response->body();
                } else {
                    throw new \Exception("HTTP failed with status " . $response->status());
                }
            } catch (\Exception $e) {
                // 2. Fallback avec Browsershot (plus lent mais contourne 403/JS)
                Log::debug('AfDB Scraper: HTTP failed for detail data, trying Browsershot', ['url' => $url, 'error' => $e->getMessage()]);
                
                try {
                    $html = Browsershot::url($url)
                        ->setChromePath('/usr/bin/google-chrome')
                        ->setNodeBinary('/usr/bin/node')
                        ->ignoreHttpsErrors()
                        ->waitUntilNetworkIdle()
                        ->timeout(60)
                        ->setOption('args', [
                            '--no-sandbox',
                            '--disable-setuid-sandbox',
                            '--disable-dev-shm-usage',
                            '--disable-accelerated-2d-canvas',
                            '--disable-gpu',
                            '--ignore-certificate-errors',
                        ])
                        ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                        ->bodyHtml();
                } catch (\Exception $ex) {
                    Log::warning('AfDB Scraper: Browsershot also failed for detail data', ['url' => $url, 'error' => $ex->getMessage()]);
                    return $data;
                }
            }

            if (empty($html)) {
                return $data;
            }

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // --- Extraction Pays ---
            // Stratégie 1: Chercher des liens vers des pages pays (/countries/..., /pays/...)
            $countryLinks = $xpath->query("//a[contains(@href, '/countries/') or contains(@href, '/pays/')]");
            foreach ($countryLinks as $link) {
                $text = trim($link->textContent);
                if (empty($text) || stripos($text, 'All countries') !== false || stripos($text, 'Tous les pays') !== false) {
                    continue;
                }
                
                $country = $this->extractCountryFromText($text);
                if ($country) {
                    $data['country'] = $country;
                    break; 
                }
            }

            // Stratégie 2: Chercher des labels spécifiques (Country:, Pays:)
            if (empty($data['country'])) {
                $labels = $xpath->query("//*[contains(text(), 'Country') or contains(text(), 'Pays')]/following-sibling::*");
                foreach ($labels as $label) {
                    $country = $this->extractCountryFromText($label->textContent);
                    if ($country) {
                        $data['country'] = $country;
                        break;
                    }
                }
            }

            // Stratégie 3: Chercher dans le texte global
            if (empty($data['country'])) {
                $bodyText = $dom->textContent;
                $data['country'] = $this->extractCountryFromText($bodyText);
            }


            // --- Extraction Dates ---
            $textContent = $dom->textContent;
            
            // Chercher la date de publication
            $pubLabels = $xpath->query("//*[contains(text(), 'Publication') or contains(text(), 'Publié')]/following-sibling::*");
            foreach ($pubLabels as $label) {
                $date = $this->parseDateFromText($label->textContent);
                if ($date) {
                    $data['publication_date'] = $date;
                    break;
                }
            }

            // Chercher la date limite (deadline)
            $deadlineLabels = $xpath->query("//*[contains(text(), 'Deadline') or contains(text(), 'Date limite') or contains(text(), 'Closing')]/following-sibling::*");
            foreach ($deadlineLabels as $label) {
                $date = $this->parseDateFromText($label->textContent);
                if ($date) {
                    $data['deadline'] = $date;
                    break;
                }
            }

            // Fallback: Parser toutes les dates et essayer d'assigner
            if (empty($data['publication_date']) || empty($data['deadline'])) {
                $allDates = $this->extractAllDates($textContent);
                if (!empty($allDates)) {
                    sort($allDates); // Plus ancien au plus récent
                    if (empty($data['publication_date'])) {
                        $data['publication_date'] = $allDates[0];
                    }
                    if (empty($data['deadline'])) {
                        $data['deadline'] = end($allDates);
                    }
                }
            }

            return $data;

        } catch (\Exception $e) {
            Log::warning('AfDB Scraper: Error in fetchDetailData', ['url' => $url, 'error' => $e->getMessage()]);
            return $data;
        }
    }

    /**
     * Nettoie et normalise le texte
     */
    private function cleanText(?string $text): string
    {
        if ($text === null) return '';
        
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        return $text;
    }

    /**
     * Extrait le pays depuis une chaîne de texte
     */
    private function extractCountryFromText(string $text): ?string
    {
        $tempDoc = new DOMDocument();
        $tempEl = $tempDoc->createElement('div', $text);
        return $this->extractCountry($tempEl, new DOMXPath($tempDoc));
    }

    /**
     * Extrait toutes les dates valides d'un texte
     */
    private function extractAllDates(string $text): array
    {
        $dates = [];
        $patterns = [
            '/(\d{1,2})[\s-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*[\s-](\d{4})/i',
            '/(\d{1,2})\/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\/(\d{4})/i',
            '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})/i',
            '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
            '/(\d{4})-(\d{2})-(\d{2})/',
            '/(\d{1,2})\s+(Janvier|Février|Mars|Avril|Mai|Juin|Juillet|Août|Septembre|Octobre|Novembre|Décembre)\s+(\d{4})/iu',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $text, $matches)) {
                foreach ($matches[0] as $dateStr) {
                    $date = $this->parseDateFromText($dateStr);
                    if ($date) {
                        $dates[] = $date;
                    }
                }
            }
        }

        return array_unique($dates);
    }
}

