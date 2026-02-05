<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use DOMXPath;
use App\Services\MarketTypeClassifier;

class AFDScraperService implements IterativeScraperInterface
{
    /**
     * URL de base pour les appels à projets AFD
     */
    private const BASE_URL = 'https://www.afd.fr/fr/appels-a-projets/liste?status[ongoing]=ongoing&status[soon]=soon&status[closed]=closed';

    /**
     * Nombre maximum de pages à scraper (sécurité pour éviter les boucles infinies)
     */
    private const MAX_PAGES = 50;

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
     * Scrape les appels à projets depuis le site AFD
     *
     * @return array ['count' => int, 'stats' => array] Nombre d'appels d'offres récupérés et statistiques
     */
    public function scrape(): array
    {
        // Note: Le vidage de la table est géré par la commande principale (app:scrape-active-sources)
        // Ici on scrappe uniquement les offres AFD

        $totalCount = 0;
        $page = 0; // Commencer à page=0 (première page)
        $pagesStats = []; // Statistiques par page

        try {
            // Nombre de pages max configurable
            $maxPages = (int) env('AFD_MAX_PAGES', 5);
            $maxPages = max(1, min($maxPages, self::MAX_PAGES));
            // Pagination: commencer à page=0, incrémenter jusqu'à ce qu'une page retourne 0 offres
            while ($page < $maxPages) {
                Log::info("AFD Scraper: Scraping page {$page}");

                $result = $this->scrapePage($page);
                $count = $result['count'];
                $totalCount += $count;

                // Enregistrer les stats de cette page
                $pagesStats[$page] = $count;

                Log::info("AFD Scraper: Page {$page} processed", [
                    'offres_trouvees' => $count,
                    'total_accumule' => $totalCount,
                ]);

                // STOP si la page retourne 0 offres
                if ($count === 0) {
                    Log::info("AFD Scraper: Page {$page} returned 0 offers, stopping pagination");
                    break;
                }

                // Passer à la page suivante
                $page++;
                usleep(300000); // 0.3 seconde entre les pages
            }

        } catch (\Exception $e) {
            Log::error('AFD Scraper: Exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Préparer les statistiques
        $totalPages = count($pagesStats);
        $stats = [
            'total_pages' => $totalPages,
            'total_offres' => $totalCount,
            'offres_par_page' => $pagesStats,
        ];

        Log::info('AFD Scraper: Résumé du scraping', $stats);

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
                $existing = Offre::where('source', 'AFD')
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
                Log::error('AFD Scraper: Error saving offer', [
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
                    $existing = Offre::where('source', 'AFD')
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
                    Log::error('AFD Scraper: Error saving offer', [
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
                $url .= '&page=' . $page;
            }

            Log::debug("AFD Scraper: Fetching page for batch", ['page' => $page, 'url' => $url]);

            $response = Http::withoutVerifying()->timeout(30)->get($url);

            if (!$response->successful()) {
                return ['count' => 0, 'offers' => []];
            }

            $html = $response->body();
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Extraire les items (même logique que scrapePage)
            $links = $xpath->query("//a[contains(@href, 'appels-a-projets')]");
            $items = [];
            foreach ($links as $link) {
                $href = $link->getAttribute('href');
                if (stripos($href, '/liste?') !== false || $href === '/fr/appels-a-projets/liste')
                    continue;
                if (strlen(trim($link->textContent)) < 30)
                    continue;

                $parent = $link;
                for ($i = 0; $i < 5; $i++) {
                    $parent = $parent->parentNode;
                    if (!$parent || $parent->nodeName === 'body')
                        break;
                    if (strlen(trim($parent->textContent)) > 100) {
                        $items[] = $parent;
                        break;
                    }
                }
            }

            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);
                    if ($offre && !empty($offre['titre']) && !empty($offre['lien_source'])) {
                        $offers[] = $offre;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

        } catch (\Exception $e) {
            Log::error('AFD Scraper: Exception in scrapePageForBatch', [
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

        try {
            // Construire l'URL avec le paramètre de pagination
            // page=0 → première page, page=1 → deuxième page, etc.
            $url = self::BASE_URL;
            if ($page > 0) {
                $url .= '&page=' . $page;
            }

            Log::info("AFD Scraper: Fetching page", [
                'page' => $page,
                'url' => $url,
            ]);

            // Récupérer la page HTML
            $response = Http::withoutVerifying() // Désactiver la vérification SSL pour le développement
                ->timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'fr-FR,fr;q=0.9,en;q=0.8',
                ])
                ->get($url);

            if (!$response->successful()) {
                Log::error('AFD Scraper: Failed to fetch page', [
                    'status' => $response->status(),
                    'url' => $url,
                    'page' => $page,
                ]);
                return ['count' => 0, 'html' => ''];
            }

            $html = $response->body();
            // Pas de log pour performance

            // Parser le HTML
            $dom = new DOMDocument();
            libxml_use_internal_errors(true); // Supprimer les warnings HTML malformé
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Extraire les appels à projets
            // D'après la structure AFD visible, les appels sont dans des éléments avec h2/h3
            // Chercher tous les liens vers /appels-a-projets/ d'abord

            $items = [];

            // Stratégie 1: Chercher tous les liens vers les appels à projets (optimisé)
            $links = $xpath->query("//a[contains(@href, 'appels-a-projets')]");

            Log::info('AFD Scraper: Total links found', ['page' => $page, 'count' => $links->length]);

            // Filtrer rapidement les liens valides (exclure navigation et liste)
            $validLinks = [];
            $excludedTexts = ['liste des appels', 'page', 'précédent', 'suivant', 'français', 'english', 'español'];

            foreach ($links as $link) {
                $href = $link->getAttribute('href');
                $text = trim($link->textContent);
                $textLower = strtolower($text);

                // Ignorer les liens vers la liste principale uniquement (pas les appels individuels)
                if (
                    stripos($href, '/appels-a-projets/liste?') !== false ||
                    stripos($href, '/appels-a-projets/liste#') !== false ||
                    $href === '/fr/appels-a-projets/liste' ||
                    $href === '/appels-a-projets/liste'
                ) {
                    continue;
                }

                // Ignorer les liens avec des textes de navigation (mais être plus permissif)
                $isNavigation = false;
                foreach ($excludedTexts as $excluded) {
                    // Seulement exclure si le texte est court ET contient un mot de navigation
                    if (stripos($textLower, $excluded) !== false && strlen($text) < 30) {
                        $isNavigation = true;
                        break;
                    }
                }

                // Ignorer les liens trop courts (probablement navigation) - mais être moins strict
                if (strlen($text) < 15) {
                    continue;
                }

                // Garder les liens vers de vrais appels à projets (être plus permissif)
                // Un lien valide doit contenir 'appels-a-projets' mais ne doit PAS être juste la liste
                if (!$isNavigation && stripos($href, 'appels-a-projets') !== false) {
                    // S'assurer que ce n'est pas juste le lien de la liste
                    if (
                        stripos($href, '/liste?') === false && stripos($href, '/liste#') === false &&
                        $href !== '/fr/appels-a-projets/liste' && $href !== '/appels-a-projets/liste'
                    ) {
                        $validLinks[] = $link;
                    }
                }
            }

            Log::info('AFD Scraper: Valid links after filtering', ['page' => $page, 'count' => count($validLinks)]);

            // Traiter chaque lien rapidement
            foreach ($validLinks as $link) {
                $href = $link->getAttribute('href');

                // Récupérer rapidement le conteneur parent (simplifié pour performance)
                $parent = $link;
                for ($i = 0; $i < 5; $i++) {
                    $parent = $parent->parentNode;
                    if (!$parent || $parent->nodeName === 'body' || $parent->nodeName === 'html')
                        break;

                    // Critère simple : si le parent a assez de texte, c'est bon
                    $parentText = $parent->textContent;
                    if (strlen(trim($parentText)) > 100) {
                        // Vérifier doublon par href
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
                }
            }

            Log::info('AFD Scraper: Items found after link strategy', ['page' => $page, 'count' => count($items)]);

            // Sauvegarder le HTML pour debug (toutes les pages)
            if (config('app.debug')) {
                \Storage::disk('local')->put("debug/afd_page_{$page}.html", $html);
                Log::info("AFD Scraper: HTML saved for page {$page}", [
                    'path' => "debug/afd_page_{$page}.html",
                    'html_length' => strlen($html),
                ]);
            }

            // Stratégie 2: Si pas assez de résultats, chercher par structure de liste
            // Chercher directement les éléments qui contiennent des liens vers appels-a-projets
            $fallbackItems = $xpath->query("//article | //div[contains(@class, 'appel')] | //div[contains(@class, 'project')] | //div[contains(@class, 'card')] | //div[contains(@class, 'item')] | //li[contains(@class, 'appel')] | //div[contains(@class, 'result')] | //div[contains(@class, 'content')]");

            foreach ($fallbackItems as $item) {
                // Vérifier si cet élément contient un lien vers appels-a-projets
                $itemLinks = $xpath->query(".//a[contains(@href, 'appels-a-projets')]", $item);
                if ($itemLinks->length > 0) {
                    // Vérifier que ce n'est pas déjà dans $items
                    $itemHref = $itemLinks->item(0)->getAttribute('href');

                    // Ignorer les liens de navigation
                    if (
                        stripos($itemHref, '/liste?') !== false ||
                        stripos($itemHref, '/liste#') !== false ||
                        $itemHref === '/fr/appels-a-projets/liste' ||
                        $itemHref === '/appels-a-projets/liste'
                    ) {
                        continue;
                    }

                    $found = false;
                    foreach ($items as $existing) {
                        $existingLinks = $xpath->query(".//a[contains(@href, 'appels-a-projets')]", $existing);
                        if ($existingLinks->length > 0 && $existingLinks->item(0)->getAttribute('href') === $itemHref) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $items[] = $item;
                    }
                }
            }

            Log::info('AFD Scraper: Items found after fallback strategies', ['page' => $page, 'count' => count($items)]);

            // Stratégie 3: Si toujours pas assez, chercher tous les div/article/li qui contiennent dates + "appel"
            if (count($items) < 5) {
                $allDivs = $xpath->query("//div | //article | //li");
                foreach ($allDivs as $div) {
                    $text = $div->textContent;
                    // Si contient une date et "appel" ou "projet" et assez de contenu
                    if (
                        preg_match('/\d{1,2}\s+(janvier|février|mars|avril|mai|juin|juillet|août|septembre|octobre|novembre|décembre)/i', $text) &&
                        (stripos($text, 'appel') !== false || stripos($text, 'projet') !== false) &&
                        strlen(trim($text)) > 100
                    ) {

                        // Vérifier qu'il contient un lien
                        $divLinks = $xpath->query(".//a[@href]", $div);
                        if ($divLinks->length > 0) {
                            $found = false;
                            foreach ($items as $existing) {
                                if ($existing->isSameNode($div)) {
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $items[] = $div;
                            }
                        }
                    }
                }
            }

            Log::info('AFD Scraper: Items found after all strategies', [
                'page' => $page,
                'count' => count($items),
                'url' => $url,
            ]);

            // Si $items est un DOMNodeList, convertir en array
            if ($items instanceof \DOMNodeList) {
                $itemsArray = [];
                foreach ($items as $node) {
                    $itemsArray[] = $node;
                }
                $items = $itemsArray;
            }

            // Convertir DOMNodeList en array si nécessaire
            if ($items instanceof \DOMNodeList) {
                $itemsArray = [];
                foreach ($items as $node) {
                    $itemsArray[] = $node;
                }
                $items = $itemsArray;
            }

            // Traiter rapidement

            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);

                    if ($offre && !empty($offre['titre']) && !empty($offre['lien_source'])) {
                        // Plus de filtre - récupérer TOUS les appels sans exception
                        // Normaliser le pays si présent
                        if (isset($offre['pays']) && is_string($offre['pays'])) {
                            $offre['pays'] = trim($offre['pays']);
                        }

                        // Log simplifié pour performance

                        // Vérifier si l'offre existe déjà (par titre ou lien)
                        $existing = Offre::where('lien_source', $offre['lien_source'])
                            ->orWhere('titre', $offre['titre'])
                            ->first();

                        if (!$existing) {
                            Offre::create($offre);
                            $count++;
                        }
                    }
                } catch (\Exception $e) {
                    // Ignorer les erreurs silencieusement pour performance
                    continue;
                }
            }

        } catch (\Exception $e) {
            Log::error('AFD Scraper: Exception occurred while scraping page', [
                'page' => $page,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return ['count' => $count, 'html' => $html];
    }

    /**
     * Vérifie s'il y a une page suivante en analysant le HTML de la page actuelle
     *
     * @param int $currentPage Page actuelle
     * @param string $html HTML de la page actuelle
     * @return bool True s'il y a une page suivante
     */
    private function hasNextPage(int $currentPage, string $html): bool
    {
        if (empty($html)) {
            return false;
        }

        try {
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Stratégie 1: Chercher un lien "Page suivante" ou "Suivant"
            // Recherche dans le texte complet, pas seulement le texte direct
            $nextLinks = $xpath->query("//a[contains(translate(., 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'suivant')] | //a[contains(translate(., 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'next')] | //a[@aria-label='Page suivante'] | //a[@aria-label='Next']");

            if ($nextLinks->length > 0) {
                foreach ($nextLinks as $link) {
                    $class = $link->getAttribute('class');
                    $href = $link->getAttribute('href');
                    $text = trim($link->textContent);

                    // Ignorer les liens vers "Page précédente"
                    if (stripos($text, 'précédent') !== false || stripos($text, 'previous') !== false) {
                        continue;
                    }

                    // Si le lien existe et n'est pas désactivé, il y a une page suivante
                    if (
                        !empty($href) &&
                        strpos($class, 'disabled') === false &&
                        strpos($class, 'inactive') === false &&
                        strpos($href, '#') === false
                    ) {
                        Log::debug('AFD Scraper: Found next page link', ['href' => $href, 'text' => $text]);
                        return true;
                    }
                }
            }

            // Stratégie 2: Chercher les numéros de page dans les liens de pagination
            // Chercher dans les éléments de pagination d'abord
            $paginationContainers = $xpath->query("//nav[contains(@class, 'pagination')] | //ul[contains(@class, 'pagination')] | //div[contains(@class, 'pagination')] | //*[contains(@class, 'pager')]");

            $maxPage = $currentPage;

            if ($paginationContainers->length > 0) {
                // Si on trouve un conteneur de pagination, chercher dedans
                foreach ($paginationContainers as $container) {
                    $pageLinks = $xpath->query(".//a", $container);
                    foreach ($pageLinks as $link) {
                        $href = $link->getAttribute('href');
                        $text = trim($link->textContent);

                        // Extraire le numéro de page de l'URL
                        if (preg_match('/[?&]page=(\d+)/', $href, $matches)) {
                            $pageNum = (int) $matches[1];
                            if ($pageNum > $maxPage) {
                                $maxPage = $pageNum;
                                Log::debug('AFD Scraper: Found page number in URL', ['page' => $pageNum, 'href' => $href]);
                            }
                        }

                        // Chercher dans le texte du lien (si c'est un numéro)
                        if (is_numeric($text) && $text > 0) {
                            $pageNum = (int) $text;
                            if ($pageNum > $maxPage) {
                                $maxPage = $pageNum;
                                Log::debug('AFD Scraper: Found page number in text', ['page' => $pageNum]);
                            }
                        }
                    }
                }
            } else {
                // Si pas de conteneur de pagination, chercher tous les liens avec page=
                $pageLinks = $xpath->query("//a[contains(@href, 'page=')] | //a[contains(@href, '?page=')]");
                foreach ($pageLinks as $link) {
                    $href = $link->getAttribute('href');
                    $text = trim($link->textContent);

                    // Extraire le numéro de page de l'URL
                    if (preg_match('/[?&]page=(\d+)/', $href, $matches)) {
                        $pageNum = (int) $matches[1];
                        if ($pageNum > $maxPage) {
                            $maxPage = $pageNum;
                            Log::debug('AFD Scraper: Found page number in URL (no container)', ['page' => $pageNum]);
                        }
                    }

                    // Chercher dans le texte du lien
                    if (is_numeric($text) && $text > 0) {
                        $pageNum = (int) $text;
                        if ($pageNum > $maxPage) {
                            $maxPage = $pageNum;
                            Log::debug('AFD Scraper: Found page number in text (no container)', ['page' => $pageNum]);
                        }
                    }
                }
            }

            // Si on a trouvé une page plus grande que la page actuelle, il y a une page suivante
            if ($maxPage > $currentPage) {
                Log::info('AFD Scraper: Next page found via page numbers', ['current' => $currentPage, 'max' => $maxPage]);
                return true;
            }

            // Stratégie 3: Chercher directement les numéros de page dans tout le document
            // Parfois les numéros de page sont dans le texte même s'ils ne sont pas des liens
            $allTextNodes = $xpath->query("//text()[normalize-space()]");
            foreach ($allTextNodes as $textNode) {
                $text = trim($textNode->nodeValue);
                // Chercher des patterns comme "Page 2", "2", etc.
                if (preg_match('/\b(\d+)\b/', $text, $matches)) {
                    $possiblePage = (int) $matches[1];
                    // Si c'est un numéro raisonnable (entre 1 et 100) et supérieur à la page actuelle
                    if ($possiblePage > $currentPage && $possiblePage <= 100) {
                        // Vérifier que c'est dans un contexte de pagination
                        $parent = $textNode->parentNode;
                        $parentClass = $parent ? $parent->getAttribute('class') : '';
                        $parentText = $parent ? $parent->textContent : '';
                        if (
                            stripos($parentClass, 'page') !== false ||
                            stripos($parentText, 'page') !== false ||
                            $parent->nodeName === 'a'
                        ) {
                            Log::debug('AFD Scraper: Found page number in text node', ['current' => $currentPage, 'found' => $possiblePage]);
                            return true;
                        }
                    }
                }
            }

            Log::debug('AFD Scraper: No next page found', ['current' => $currentPage]);
            return false;

        } catch (\Exception $e) {
            Log::warning('AFD Scraper: Error checking next page', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Teste si une page existe en tentant de la récupérer
     *
     * @param int $pageNum
     * @return bool
     */
    private function testPageExists(int $pageNum): bool
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ])
                ->get(self::BASE_URL, [
                    'status[ongoing]' => 'ongoing',
                    'status[soon]' => 'soon',
                    'status[closed]' => 'closed',
                    'page' => $pageNum > 1 ? $pageNum : 1,
                ]);

            if ($response->successful()) {
                $html = $response->body();
                // Si la page contient des liens vers appels-a-projets ET a du contenu, elle existe
                $hasAppels = stripos($html, 'appels-a-projets') !== false || stripos($html, 'appel') !== false;
                $hasContent = strlen($html) > 5000; // Au moins 5KB de contenu
                return $hasAppels && $hasContent;
            }

            return false;
        } catch (\Exception $e) {
            Log::debug('AFD Scraper: Error testing page existence', ['page' => $pageNum]);
            return false;
        }
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
            // Extraire le titre (priorité: h2, h3, puis liens, puis autres)
            $titre = null;
            $titreNodes = $xpath->query(".//h2 | .//h3", $item);
            if ($titreNodes->length > 0) {
                $titre = trim($titreNodes->item(0)->textContent);
            }

            // Si pas de titre dans h2/h3, chercher dans les liens
            if (!$titre) {
                $linkNodes = $xpath->query(".//a[contains(@href, '/appels-a-projets/')]", $item);
                if ($linkNodes->length > 0) {
                    $titre = trim($linkNodes->item(0)->textContent);
                }
            }

            // Si toujours pas de titre, chercher tout lien
            if (!$titre) {
                $linkNodes = $xpath->query(".//a[@href]", $item);
                if ($linkNodes->length > 0) {
                    $titre = trim($linkNodes->item(0)->textContent);
                }
            }

            // Extraire le lien (priorité aux liens vers /appels-a-projets/)
            $lien = null;
            $linkNodes = $xpath->query(".//a[contains(@href, '/appels-a-projets/')]", $item);
            if ($linkNodes->length > 0) {
                $href = $linkNodes->item(0)->getAttribute('href');
                $lien = $this->normalizeUrl($href);
            } else {
                // Fallback: premier lien trouvé
                $linkNodes = $xpath->query(".//a[@href]", $item);
                if ($linkNodes->length > 0) {
                    $href = $linkNodes->item(0)->getAttribute('href');
                    if (stripos($href, 'appel') !== false || stripos($href, 'projet') !== false) {
                        $lien = $this->normalizeUrl($href);
                    }
                }
            }

            // Extraire le pays (chercher dans les textes de l'élément)
            $pays = $this->extractCountry($item, $xpath);

            $marketType = MarketTypeClassifier::classify($titre . ' ' . $item->textContent);

            // Extraire la date limite depuis la liste (tentative rapide)
            $dateLimite = $this->extractDeadline($item, $xpath);

            // Si pas trouvée dans la liste, extraire depuis la page de détail
            if (empty($dateLimite) && $lien) {
                $dateLimite = $this->extractDeadlineFromDetailPage($lien);
            }

            // Acheteur est toujours AFD pour ce site
            $acheteur = "Agence Française de Développement (AFD)";

            if (!$titre || !$lien) {
                return null;
            }

            // Ignorer les titres qui sont clairement de la navigation
            $titreLower = strtolower($titre);
            $navigationKeywords = ['voir les', 'page', 'liste des', 'français', 'english', 'español', 'précédent', 'suivant'];
            foreach ($navigationKeywords as $keyword) {
                if (stripos($titreLower, $keyword) !== false && strlen($titre) < 50) {
                    return null; // Ignorer ce lien
                }
            }

            // Ignorer les titres trop courts
            if (strlen(trim($titre)) < 30) {
                return null;
            }

            $marketType = MarketTypeClassifier::classify($titre . ' ' . $item->textContent);

            return [
                'titre' => $titre,
                'acheteur' => $acheteur,
                'pays' => $pays,
                'date_limite_soumission' => $dateLimite,
                'lien_source' => $lien,
                'source' => 'AFD',
                'notice_type' => 'Appel à projets',
                'market_type' => $marketType,
            ];

        } catch (\Exception $e) {
            Log::warning('AFD Scraper: Error extracting data from item', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Extrait TOUS les pays et zones géographiques depuis un élément
     * IMPORTANT: Retourne TOUS les pays/zones trouvés, pas seulement le premier
     */
    private function extractCountry(\DOMElement $item, DOMXPath $xpath): ?string
    {
        // Liste complète des pays AFD (selon le site)
        $countries = [
            // Afrique
            'République centrafricaine',
            'Tchad',
            'Cameroun',
            'Sénégal',
            'Burkina Faso',
            'Mali',
            'Niger',
            'Madagascar',
            'Comores',
            'Maurice',
            'Burundi',
            'Rwanda',
            'Tanzanie',
            'Kenya',
            'Ouganda',
            'Afrique du Sud',
            'Algérie',
            'Angola',
            'Bénin',
            'Cap-Vert',
            'Congo',
            'Côte d\'Ivoire',
            'Djibouti',
            'Égypte',
            'Éthiopie',
            'Gabon',
            'Gambie',
            'Ghana',
            'Guinée-Bissau',
            'Libéria',
            'Malawi',
            'Maroc',
            'Mauritanie',
            'Mozambique',
            'Namibie',
            'Nigéria',
            'République démocratique du Congo',
            'Sao Tomé-et-Principe',
            'Sierra Leone',
            'Soudan',
            'Togo',
            'Tunisie',
            'Zambie',
            'Zimbabwe',
            // Orients
            'Afghanistan',
            'Azerbaïdjan',
            'Arménie',
            'Bangladesh',
            'Birmanie',
            'Cambodge',
            'Chine',
            'Géorgie',
            'Inde',
            'Indonésie',
            'Irak',
            'Jordanie',
            'Kazakhstan',
            'Laos',
            'Liban',
            'Malaisie',
            'Moldavie',
            'Mongolie',
            'Ouzbékistan',
            'Pakistan',
            'Palestine',
            'Philippines',
            'République de Corée',
            'Sri Lanka',
            'Thaïlande',
            'Turquie',
            'Ukraine',
            'Vietnam',
            'Balkans occidentaux',
            // Trois Océans
            'Fidji',
            'Guadeloupe',
            'Guyane',
            'Haïti',
            'La Réunion',
            'Martinique',
            'Mayotte',
            'Nouvelle-Calédonie',
            'Papouasie-Nouvelle-Guinée',
            'Polynésie française',
            'République dominicaine',
            'Suriname',
            'Vanuatu',
            'Wallis-et-Futuna',
            // Amérique latine
            'Argentine',
            'Bolivie',
            'Brésil',
            'Colombie',
            'Costa Rica',
            'Cuba',
            'Équateur',
            'Mexique',
            'Pérou',
            'Uruguay',
            // Europe
            'France',
            'Belgique',
        ];

        // Zones géographiques (à rechercher également)
        $zones = [
            'Afrique',
            'Afrique Centrale',
            'Afrique de l\'Ouest',
            'Afrique de l\'Est',
            'Afrique Australe',
            'Afrique du Nord',
            'Afrique subsaharienne',
            'Sous-région',
            'Région',
            'Zone',
            'Bassin',
            'Espace',
            'Amérique latine',
            'Amérique centrale',
            'Amérique du Sud',
            'Asie',
            'Asie du Sud-Est',
            'Asie centrale',
            'Moyen-Orient',
            'Europe',
            'Méditerranée',
            'Caraïbes',
            'Océan Indien',
            'Pacifique',
            'Mondial',
            'International',
        ];

        $text = $item->textContent;
        $foundItems = [];

        // Rechercher TOUS les pays mentionnés dans le texte
        foreach ($countries as $country) {
            if (stripos($text, $country) !== false) {
                $foundItems[] = $country;
            }
        }

        // Rechercher TOUTES les zones géographiques mentionnées
        foreach ($zones as $zone) {
            if (stripos($text, $zone) !== false) {
                // Éviter les doublons si un pays a déjà été trouvé avec le même nom
                // Ex: "Afrique" ne doit pas être ajouté si "Afrique du Sud" est déjà trouvé
                $isDuplicate = false;
                foreach ($foundItems as $existing) {
                    if (stripos($existing, $zone) !== false || stripos($zone, $existing) !== false) {
                        $isDuplicate = true;
                        break;
                    }
                }
                if (!$isDuplicate) {
                    $foundItems[] = $zone;
                }
            }
        }

        // Retourner tous les pays/zones trouvés, séparés par virgule
        if (!empty($foundItems)) {
            // Trier et dédupliquer tout en préservant l'ordre
            $uniqueItems = [];
            foreach ($foundItems as $item) {
                $itemLower = strtolower(trim($item));
                if (!in_array($itemLower, array_map('strtolower', $uniqueItems))) {
                    $uniqueItems[] = trim($item);
                }
            }
            return implode(', ', $uniqueItems);
        }

        return null;
    }

    /**
     * Extrait la date limite de soumission
     */
    private function extractDeadline(\DOMElement $item, DOMXPath $xpath): ?string
    {
        // Chercher des patterns de date (ex: "6 octobre 2025 - 24 novembre 2025")
        $text = $item->textContent;

        // Pattern pour dates françaises
        $patterns = [
            '/(\d{1,2})\s+(janvier|février|mars|avril|mai|juin|juillet|août|septembre|octobre|novembre|décembre)\s+(\d{4})/i',
            '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
            '/(\d{4})-(\d{2})-(\d{2})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                try {
                    // Si c'est une plage de dates, prendre la deuxième (date limite)
                    if (strpos($text, '-') !== false) {
                        preg_match_all($pattern, $text, $allMatches);
                        if (isset($allMatches[0][1])) {
                            $dateStr = $allMatches[0][1];
                        } else {
                            $dateStr = $matches[0];
                        }
                    } else {
                        $dateStr = $matches[0];
                    }

                    // Convertir en format date
                    $date = \Carbon\Carbon::createFromLocaleFormat('d F Y', 'fr', $dateStr);
                    return $date->format('Y-m-d');
                } catch (\Exception $e) {
                    // Essayer d'autres formats
                    try {
                        $date = \Carbon\Carbon::createFromFormat('d/m/Y', $dateStr);
                        return $date->format('Y-m-d');
                    } catch (\Exception $e2) {
                        continue;
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
            return 'https://www.afd.fr' . $url;
        }

        return 'https://www.afd.fr/' . $url;
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
                $html = \Spatie\Browsershot\Browsershot::url($url)
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
                    throw new \Exception('Empty HTML from Browsershot');
                }
            } catch (\Exception $e) {
                // Fallback vers HTTP simple
                $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                    ->timeout(15)
                    ->retry(1, 500)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    ])
                    ->get($url);

                if (!$response->successful()) {
                    return null;
                }

                $html = $response->body();
            }

            if (empty($html)) {
                return null;
            }

            // Parser le HTML
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new \DOMXPath($dom);

            // Chercher la date limite avec plusieurs stratégies
            $deadlineKeywords = [
                'date limite',
                'date de clôture',
                'clôture',
                'deadline',
                'closing date',
                'échéance',
            ];

            $text = strtolower($html);
            $textContent = strtolower($dom->textContent ?? '');

            // Patterns de date français
            $datePatterns = [
                '/(\d{1,2})\s+(janvier|février|mars|avril|mai|juin|juillet|août|septembre|octobre|novembre|décembre)\s+(\d{4})/i',
                '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
                '/(\d{4})-(\d{2})-(\d{2})/',
            ];

            // Chercher près des mots-clés de deadline
            foreach ($deadlineKeywords as $keyword) {
                $keywordPos = stripos($text, $keyword);
                if ($keywordPos !== false) {
                    // Extraire 300 caractères autour du mot-clé
                    $context = substr($text, max(0, $keywordPos - 100), 400);

                    // Chercher une date dans ce contexte
                    foreach ($datePatterns as $pattern) {
                        if (preg_match($pattern, $context, $matches)) {
                            try {
                                $dateStr = $matches[0];

                                // Essayer de parser la date française
                                try {
                                    $date = \Carbon\Carbon::createFromLocaleFormat('d F Y', 'fr', $dateStr);
                                } catch (\Exception $e) {
                                    // Essayer format d/m/Y
                                    $date = \Carbon\Carbon::createFromFormat('d/m/Y', $dateStr);
                                }

                                // Vérifier que la date est dans le futur ou pas trop ancienne (max 2 ans)
                                if ($date->isFuture() || $date->gt(now()->subYears(2))) {
                                    return $date->format('Y-m-d');
                                }
                            } catch (\Exception $e) {
                                continue;
                            }
                        }
                    }
                }
            }

            // Si pas trouvé près des mots-clés, chercher toutes les dates dans la page
            foreach ($datePatterns as $pattern) {
                if (preg_match_all($pattern, $textContent, $matches, PREG_SET_ORDER)) {
                    // Prendre la dernière date trouvée (souvent la deadline est mentionnée en dernier)
                    foreach (array_reverse($matches) as $match) {
                        try {
                            $dateStr = $match[0];

                            try {
                                $date = \Carbon\Carbon::createFromLocaleFormat('d F Y', 'fr', $dateStr);
                            } catch (\Exception $e) {
                                $date = \Carbon\Carbon::createFromFormat('d/m/Y', $dateStr);
                            }

                            // Vérifier que la date est dans le futur ou pas trop ancienne
                            if ($date->isFuture() || $date->gt(now()->subYears(2))) {
                                return $date->format('Y-m-d');
                            }
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                }
            }

            return null;

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::debug('AFD Scraper: Error extracting deadline from detail page', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}

