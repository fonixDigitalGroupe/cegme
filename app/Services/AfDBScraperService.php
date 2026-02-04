<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use DOMDocument;
use DOMXPath;

class AfDBScraperService implements IterativeScraperInterface
{
    /**
     * URL de base pour les appels d'offres AfDB
     */
    private const BASE_URL = 'https://www.afdb.org/en/projects-and-operations/procurement';

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
            $maxPages = max(1, min((int) env('AFDB_MAX_PAGES', 5), self::MAX_PAGES));
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

            // Ajouter les nouvelles offres au buffer
            $this->pendingOffers = array_merge($this->pendingOffers, $result['offers']);
            $this->currentPage++;

            // Traiter le buffer jusqu'à atteindre la limite
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
            $url = self::BASE_URL;
            if ($page > 0) {
                $url .= '?page=' . ($page + 1);
            }

            Log::debug("AfDB Scraper: Fetching page for batch", ['page' => $page, 'url' => $url]);

            try {
                $html = Browsershot::url($url)
                    ->setChromePath('/usr/bin/google-chrome')
                    ->setNodeBinary('/usr/bin/node')
                    ->setNpmBinary('/usr/bin/npm')
                    ->waitUntilNetworkIdle()
                    ->timeout(90)
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
                    return ['count' => 0, 'offers' => []];
                }

            } catch (\Exception $e) {
                Log::error('AfDB Scraper: Browsershot failed', [
                    'error' => $e->getMessage(),
                    'url' => $url,
                ]);
                return ['count' => 0, 'offers' => []];
            }

            // Parser le HTML
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Extraire les notices
            $items = $this->extractProcurementItems($xpath, $dom);

            // Traiter chaque item
            $titresVus = [];
            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);

                    if (!$offre || empty($offre['titre']) || empty($offre['lien_source'])) {
                        continue;
                    }

                    // Rejeter les doublons
                    $titreNormalise = $this->normalizeTitle($offre['titre']);
                    if (isset($titresVus[$titreNormalise])) {
                        continue;
                    }
                    $titresVus[$titreNormalise] = true;

                    $offers[] = $offre;
                } catch (\Exception $e) {
                    Log::debug('AfDB Scraper: Error processing item', [
                        'error' => $e->getMessage(),
                    ]);
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

                // Fallback vers HTTP simple si Browsershot échoue
                $response = Http::withoutVerifying()
                    ->timeout(60)
                    ->retry(2, 1000)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                        'Accept-Language' => 'en-US,en;q=0.9,fr;q=0.8',
                    ])
                    ->get($url);

                if (!$response->successful()) {
                    $status = $response->status();
                    Log::error('AfDB Scraper: HTTP fallback also failed', [
                        'status' => $status,
                        'url' => $url,
                        'page' => $page,
                    ]);
                    return ['count' => 0, 'html' => ''];
                }

                $html = $response->body();
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
                    ]);

                    $validOffres[] = $offre;
                } catch (\Exception $e) {
                    Log::debug('AfDB Scraper: Error processing item', [
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }
            }

            // Traiter les offres et les sauvegarder immédiatement
            if (!empty($validOffres)) {
                foreach ($validOffres as $offre) {
                    try {
                        $existing = Offre::where('source', 'African Development Bank')
                            ->where(function ($q) use ($offre) {
                                $q->where('lien_source', $offre['lien_source'])
                                    ->orWhere('titre', $offre['titre']);
                            })
                            ->first();

                        if ($existing) {
                            $existing->update([
                                'pays' => $offre['pays'] ?? $existing->pays,
                                'date_limite_soumission' => $offre['date_limite_soumission'] ?? $existing->date_limite_soumission,
                                'updated_at' => now(),
                            ]);
                        } else {
                            $offre['created_at'] = now();
                            $offre['updated_at'] = now();
                            Offre::create($offre);
                            $count++;
                        }

                        // Ajouter au buffer pour le feedback UI
                        $findingsBuffer[] = $offre;
                        if (count($findingsBuffer) >= 10) {
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
     * Extrait les éléments de procurement depuis le DOM
     *
     * @param DOMXPath $xpath
     * @param DOMDocument $dom
     * @return array
     */
    private function extractProcurementItems(DOMXPath $xpath, DOMDocument $dom): array
    {
        $items = [];

        // Stratégies multiples pour trouver les notices de procurement
        // AfDB peut utiliser différentes structures HTML

        // Stratégie 0: Chercher tous les textes qui ressemblent à des titres d'appels d'offres
        // et trouver leurs conteneurs parents
        $allTextNodes = $xpath->query("//text()[string-length(normalize-space(.)) > 50]");
        $processedContainers = [];

        foreach ($allTextNodes as $textNode) {
            $text = trim($textNode->textContent);
            $textLower = strtolower($text);

            // Chercher des textes qui ressemblent à des titres d'appels d'offres
            // (contiennent projet, pays, activité spécifique)
            if (
                strlen($text) > 40 && strlen($text) < 500 &&
                stripos($textLower, 'consultancy services (e-consultant)') === false &&
                stripos($textLower, 'procurement notice') === false &&
                stripos($textLower, 'rules and procedures') === false &&
                (stripos($textLower, 'project') !== false ||
                    stripos($textLower, 'projet') !== false ||
                    stripos($textLower, 'program') !== false ||
                    preg_match('/\b[A-Z]{2,}[A-Z0-9]*\b/', $text))
            ) { // Code de projet

                // Trouver le conteneur parent
                $parent = $textNode->parentNode;
                $maxDepth = 10;
                $depth = 0;

                while ($parent && $depth < $maxDepth) {
                    if ($parent->nodeType === XML_ELEMENT_NODE) {
                        $parentId = spl_object_hash($parent);
                        if (!isset($processedContainers[$parentId])) {
                            $links = $xpath->query(".//a[@href]", $parent);
                            if ($links->length > 0) {
                                $items[] = $parent;
                                $processedContainers[$parentId] = true;
                                break;
                            }
                        }
                    }
                    $parent = $parent->parentNode;
                    $depth++;
                }
            }
        }

        // Stratégie 0.5: Chercher par structure de conteneur (plus fiable)
        // Chercher les éléments qui contiennent à la fois un titre spécifique et un lien
        $containerSelectors = [
            "//div[contains(@class, 'procurement')]",
            "//div[contains(@class, 'notice')]",
            "//div[contains(@class, 'item')]",
            "//article",
            "//li[contains(@class, 'procurement')]",
            "//tr[contains(@class, 'procurement')]",
            "//div[contains(@class, 'card')]",
            "//div[contains(@class, 'row')]//div[contains(@class, 'col')]",
        ];

        foreach ($containerSelectors as $selector) {
            try {
                $containers = $xpath->query($selector);
                foreach ($containers as $container) {
                    $containerId = spl_object_hash($container);
                    if (isset($processedContainers[$containerId])) {
                        continue; // Déjà traité
                    }

                    $text = trim($container->textContent);
                    // Si le conteneur a du texte substantiel et contient un lien
                    if (strlen($text) > 50) {
                        $links = $xpath->query(".//a[@href]", $container);
                        if ($links->length > 0) {
                            $items[] = $container;
                            $processedContainers[$containerId] = true;
                        }
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // Stratégie 1: Chercher les liens vers les pages de procurement
        // Essayer plusieurs patterns de liens possibles
        $linkPatterns = [
            "//a[contains(@href, '/procurement/')]",
            "//a[contains(@href, 'procurement-notice')]",
            "//a[contains(@href, '/en/projects-and-operations/procurement/')]",
            "//a[contains(@href, '/procurement-notices/')]",
            "//a[contains(@href, 'procurement')]",
            "//a[contains(@href, '/en/projects-and-operations/')]", // Plus large
            "//a[contains(@href, '.pdf')]", // PDFs de procurement
        ];

        $allLinks = [];
        foreach ($linkPatterns as $pattern) {
            $links = $xpath->query($pattern);
            foreach ($links as $link) {
                $allLinks[] = $link;
            }
        }

        foreach ($allLinks as $link) {
            $href = $link->getAttribute('href');
            $text = trim($link->textContent);

            // Ignorer les liens de navigation
            if (
                stripos($text, 'view all') !== false ||
                stripos($text, 'see more') !== false ||
                stripos($text, 'next') !== false ||
                stripos($text, 'previous') !== false ||
                strlen($text) < 20
            ) {
                continue;
            }

            // Normaliser l'URL
            $href = $this->normalizeUrl($href);

            // Trouver le conteneur parent qui contient les informations complètes
            $parent = $link->parentNode;
            $maxDepth = 5;
            $depth = 0;

            while ($parent && $depth < $maxDepth) {
                $parentText = trim($parent->textContent);
                if (strlen($parentText) > 50) {
                    // Vérifier si cet élément n'est pas déjà dans la liste
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

        // Stratégie 2: Chercher par structure de liste/carte
        $selectors = [
            "//article[contains(@class, 'procurement')]",
            "//div[contains(@class, 'procurement-notice')]",
            "//div[contains(@class, 'procurement-item')]",
            "//div[contains(@class, 'notice')]",
            "//li[contains(@class, 'procurement')]",
            "//tr[contains(@class, 'procurement')]",
        ];

        foreach ($selectors as $selector) {
            try {
                $nodes = $xpath->query($selector);
                foreach ($nodes as $node) {
                    // Vérifier qu'il contient un lien valide
                    $nodeLinks = $xpath->query(".//a[@href]", $node);
                    if ($nodeLinks->length > 0) {
                        $nodeHref = $nodeLinks->item(0)->getAttribute('href');
                        if (
                            stripos($nodeHref, 'procurement') !== false ||
                            stripos($nodeHref, '/en/projects-and-operations/') !== false
                        ) {
                            // Vérifier doublon
                            $found = false;
                            foreach ($items as $existing) {
                                $existingLinks = $xpath->query(".//a[@href]", $existing);
                                if ($existingLinks->length > 0 && $existingLinks->item(0)->getAttribute('href') === $nodeHref) {
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $items[] = $node;
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                continue;
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

                // Ignorer les liens de navigation évidents
                if (
                    stripos($href, 'javascript:') !== false ||
                    stripos($href, '#') === 0 ||
                    stripos($href, 'mailto:') !== false ||
                    stripos($linkText, 'view all') !== false ||
                    stripos($linkText, 'see more') !== false ||
                    stripos($linkText, 'next') !== false ||
                    stripos($linkText, 'previous') !== false ||
                    strlen($linkText) < 20
                ) {
                    continue;
                }

                // Ignorer les fichiers XML/RSS
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

            // Les titres de navigation ont déjà été filtrés lors de l'extraction du lien
            // Pas besoin de vérifier à nouveau ici

            // Extraire le pays/zone géographique
            $pays = $this->extractCountry($item, $xpath);

            // Extraire la date de publication
            $datePublication = $this->extractPublicationDate($item, $xpath);

            // Date limite - extraire depuis la page de détail pour avoir la vraie date
            $dateLimite = $this->extractDeadlineFromDetailPage($lien);

            // Si pas trouvée dans la page de détail, utiliser la date de publication
            if (empty($dateLimite)) {
                $dateLimite = $datePublication;
            }

            // Acheteur
            $acheteur = "African Development Bank";

            return [
                'titre' => $titre,
                'acheteur' => $acheteur,
                'pays' => $pays,
                'date_limite_soumission' => $dateLimite,
                'lien_source' => $lien, // LIEN OFFICIEL EXACT (href du titre)
                'source' => 'African Development Bank',
                'detail_url' => $lien, // Même lien (href du titre)
                'link_type' => 'detail', // Toujours 'detail' car c'est le lien du titre
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
        ];

        $zones = [
            'West Africa',
            'East Africa',
            'Southern Africa',
            'Central Africa',
            'North Africa',
            'Sub-Saharan Africa',
            'Africa',
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

        if (!empty($foundItems)) {
            return implode(', ', array_unique($foundItems));
        }

        return null;
    }

    /**
     * Extrait la date de publication ou deadline
     */
    private function extractPublicationDate(\DOMElement $item, DOMXPath $xpath): ?string
    {
        $text = $item->textContent;
        $html = $item->ownerDocument->saveHTML($item);

        // Patterns de date plus complets (ajouter plus de variations)
        $patterns = [
            // Formats américains
            '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),\s+(\d{4})/i',
            '/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\.?\s+(\d{1,2}),?\s+(\d{4})/i',
            // Formats européens
            '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
            '/(\d{1,2})-(\d{1,2})-(\d{4})/',
            // Formats ISO
            '/(\d{4})-(\d{2})-(\d{2})/',
            // Formats avec mots-clés (deadline, closing, due date)
            '/(deadline|closing|due|submission)[\s:]+(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})/i',
            '/(deadline|closing|due|submission)[\s:]+(\d{1,2})\/(\d{1,2})\/(\d{4})/i',
        ];

        // Chercher dans le texte brut
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                try {
                    $dateStr = $matches[0];
                    // Nettoyer la chaîne de date
                    $dateStr = preg_replace('/^(deadline|closing|due|submission)[\s:]+/i', '', $dateStr);
                    $dateStr = trim($dateStr);
                    $date = \Carbon\Carbon::parse($dateStr);
                    // Vérifier que la date n'est pas trop ancienne (rejeter les dates > 5 ans)
                    if ($date->isFuture() || $date->gt(now()->subYears(5))) {
                        return $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        // Chercher aussi dans les attributs HTML (data-date, datetime, etc.)
        $dateAttributes = ['data-date', 'datetime', 'data-deadline', 'data-closing'];
        foreach ($dateAttributes as $attr) {
            $elements = $xpath->query(".//*[@{$attr}]", $item);
            foreach ($elements as $element) {
                $dateValue = $element->getAttribute($attr);
                if (!empty($dateValue)) {
                    try {
                        $date = \Carbon\Carbon::parse($dateValue);
                        if ($date->isFuture() || $date->gt(now()->subYears(5))) {
                            return $date->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }
        }

        // Si aucune date trouvée, retourner null (sera géré plus haut)
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
        ];

        // Vérifier si le titre correspond exactement à un titre interdit
        foreach ($forbiddenTitles as $forbidden) {
            if ($titreLower === strtolower($forbidden)) {
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

        // LIENS INTERDITS - Plateformes et listes
        $forbiddenPatterns = [
            'econsultant.afdb.org',
            '/en/projects-and-operations/procurement', // Page de liste (sans ID)
            '/en/documents', // Page de documents générique
        ];

        foreach ($forbiddenPatterns as $pattern) {
            if (stripos($urlLower, $pattern) !== false) {
                // Vérifier si c'est vraiment une page de liste (sans identifiant)
                if (stripos($urlLower, '/procurement') !== false) {
                    // Si l'URL contient un ID ou un chemin spécifique, c'est OK
                    if (preg_match('/\/procurement\/[^\/\?]+/', $urlLower)) {
                        continue; // C'est un lien spécifique, pas une liste
                    }
                }
                return false;
            }
        }

        // Rejeter les URLs avec paramètres de recherche/liste
        if (stripos($urlLower, '/procurement?') !== false || stripos($urlLower, '/procurement#') !== false) {
            return false;
        }

        // Rejeter les fichiers XML/RSS (flux de données, pas des avis)
        if (preg_match('/\.(xml|rss|atom)$/i', $urlLower)) {
            return false;
        }

        // LIENS ACCEPTÉS - Doivent contenir un identifiant ou être un document
        $validPatterns = [
            '/procurement/', // Avec chemin spécifique
            'procurement-notice', // Notice spécifique
            '.pdf', // Document PDF
            '.doc', // Document Word
            '.docx',
            '/en/projects-and-operations/procurement/', // Avec chemin après
        ];

        $hasValidPattern = false;
        foreach ($validPatterns as $pattern) {
            if (stripos($urlLower, $pattern) !== false) {
                $hasValidPattern = true;
                break;
            }
        }

        // Si c'est un lien vers afdb.org mais pas vers une plateforme, accepter
        if (stripos($urlLower, 'afdb.org') !== false && !$hasValidPattern) {
            // Vérifier qu'il y a un chemin spécifique (pas juste le domaine)
            $path = parse_url($url, PHP_URL_PATH);
            if ($path && strlen($path) > 10 && stripos($path, '/procurement') === false) {
                $hasValidPattern = true; // Lien spécifique vers autre page
            }
        }

        return $hasValidPattern;
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
                    ->timeout(30)
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
                    ->timeout(15)
                    ->retry(1, 500)
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

        // Patterns de date
        $datePatterns = [
            // Format DD-MMM-YYYY (19-Dec-2025)
            '/(\d{1,2})[\s-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*[\s-](\d{4})/i',
            // Format DD/MMM/YYYY
            '/(\d{1,2})\/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\/(\d{4})/i',
            // Formats américains
            '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})/i',
            '/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\.?\s+(\d{1,2}),?\s+(\d{4})/i',
            // Formats européens
            '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
            '/(\d{1,2})-(\d{1,2})-(\d{4})/',
            // Formats ISO
            '/(\d{4})-(\d{2})-(\d{2})/',
        ];

        foreach ($datePatterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                try {
                    $dateStr = $matches[0];
                    $date = \Carbon\Carbon::parse($dateStr);
                    // Vérifier que la date est dans le futur ou pas trop ancienne (max 2 ans)
                    if ($date->isFuture() || $date->gt(now()->subYears(2))) {
                        return $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return null;
    }
}

