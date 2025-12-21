<?php

namespace App\Services;

use App\Models\AppelOffre;
use App\Models\AppelOffreConfig;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use DOMXPath;

class AppelOffreScraperService
{
    /**
     * Scrape les appels d'offres depuis toutes les configurations
     */
    public function scrapeAll()
    {
        $configs = AppelOffreConfig::whereNotNull('site_officiel')->get();
        $totalScraped = 0;

        foreach ($configs as $config) {
            try {
                $count = $this->scrapeFromConfig($config);
                $totalScraped += $count;
                Log::info("Scraped {$count} appels d'offres from {$config->source_ptf}");
            } catch (\Exception $e) {
                Log::error("Error scraping from {$config->source_ptf}: " . $e->getMessage());
            }
        }

        return $totalScraped;
    }

    /**
     * Scrape les appels d'offres depuis une configuration spécifique
     */
    public function scrapeFromConfig(AppelOffreConfig $config)
    {
        $url = $config->site_officiel;
        if (empty($url)) {
            return 0;
        }

        $totalCount = 0;
        
        // Détecter si le site utilise la pagination et obtenir toutes les pages
        $pages = $this->getAllPages($url);
        
        Log::info("Found " . count($pages) . " pages to scrape from {$config->source_ptf}");

        foreach ($pages as $pageUrl) {
            try {
                $count = $this->scrapePage($pageUrl, $config);
                $totalCount += $count;
                Log::info("Scraped page {$pageUrl}: {$count} new appels d'offres");
                
                // Petite pause entre les pages pour éviter de surcharger le serveur
                usleep(500000); // 0.5 seconde
            } catch (\Exception $e) {
                Log::error("Error scraping page {$pageUrl}: " . $e->getMessage());
                continue;
            }
        }

        Log::info("Successfully created {$totalCount} new appels d'offres from {$config->source_ptf} (all pages)");
        return $totalCount;
    }

    /**
     * Obtenir toutes les pages à scraper
     */
    protected function getAllPages($baseUrl)
    {
        $pages = [$baseUrl]; // Commencer par la première page
        
        try {
            // Récupérer la première page pour détecter la pagination
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'fr-FR,fr;q=0.9,en;q=0.8',
                ])
                ->get($baseUrl);
            
            if (!$response->successful()) {
                return $pages; // Retourner seulement la première page si erreur
            }

            $html = $response->body();
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Détecter la pagination selon le type de site
            if (strpos($baseUrl, 'afd.fr') !== false) {
                $pages = $this->getAFDPages($xpath, $baseUrl);
            } else {
                // Pour les autres sites, essayer de détecter la pagination générique
                $pages = $this->getGenericPages($xpath, $baseUrl);
            }
        } catch (\Exception $e) {
            Log::warning("Error detecting pagination: " . $e->getMessage());
        }

        return $pages;
    }

    /**
     * Obtenir toutes les pages AFD
     */
    protected function getAFDPages(DOMXPath $xpath, $baseUrl)
    {
        $pages = [];
        
        // Chercher tous les liens de pagination
        $paginationLinks = $xpath->query('//a[contains(@class, "fr-pagination__link") and contains(@href, "page=")]');
        
        $pageNumbers = [];
        if ($paginationLinks && $paginationLinks->length > 0) {
            foreach ($paginationLinks as $link) {
                $href = $link->getAttribute('href');
                // Extraire le numéro de page depuis l'URL
                if (preg_match('/[?&]page=(\d+)/', $href, $matches)) {
                    $pageNum = (int)$matches[1];
                    $pageNumbers[] = $pageNum;
                }
            }
        }
        
        // Chercher le lien "Dernière page" qui contient le numéro de la dernière page
        $lastPageLink = $xpath->query('//a[contains(@class, "fr-pagination__link--last")]');
        if ($lastPageLink && $lastPageLink->length > 0) {
            $href = $lastPageLink->item(0)->getAttribute('href');
            if (preg_match('/[?&]page=(\d+)/', $href, $matches)) {
                $lastPageNum = (int)$matches[1];
                $pageNumbers[] = $lastPageNum;
            }
        }
        
        // Chercher aussi dans les spans (page courante)
        $currentPageSpans = $xpath->query('//span[contains(@class, "fr-pagination__link") and @aria-current="page"]');
        if ($currentPageSpans && $currentPageSpans->length > 0) {
            foreach ($currentPageSpans as $span) {
                $title = $span->getAttribute('title');
                if (preg_match('/Page (\d+)/', $title, $matches)) {
                    $currentPageNum = (int)$matches[1];
                    // La page courante est affichée comme "Page 1" mais l'URL utilise page=0 pour la page 2
                    // Donc si on est sur la page 1, il n'y a pas de paramètre page
                    // Page 2 = page=1, Page 3 = page=2, etc.
                    if ($currentPageNum > 1) {
                        $pageNumbers[] = $currentPageNum - 1;
                    }
                }
            }
        }

        $maxPage = !empty($pageNumbers) ? max($pageNumbers) : 0;

        // Construire l'URL de base sans paramètres de page
        $parsedUrl = parse_url($baseUrl);
        $basePath = $parsedUrl['path'] ?? '';
        $queryParams = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }
        
        // Retirer le paramètre 'page' s'il existe
        unset($queryParams['page']);

        // Construire toutes les URLs de pages
        $scheme = $parsedUrl['scheme'] ?? 'https';
        $host = $parsedUrl['host'] ?? '';
        $baseQueryString = http_build_query($queryParams);
        
        // Page 1 (sans paramètre page) - index 0
        $firstPageUrl = $scheme . '://' . $host . $basePath;
        if ($baseQueryString) {
            $firstPageUrl .= '?' . $baseQueryString;
        }
        $pages[] = $firstPageUrl;
        
        // Pages suivantes (AFD utilise page=0, page=1, page=2, etc.)
        // Si maxPage > 0, il y a au moins la page 2 (index 1)
        if ($maxPage >= 0) {
            for ($i = 0; $i <= $maxPage; $i++) {
                $pageQuery = $baseQueryString;
                if ($pageQuery) {
                    $pageQuery .= '&page=' . $i;
                } else {
                    $pageQuery = 'page=' . $i;
                }
                $pageUrl = $scheme . '://' . $host . $basePath . '?' . $pageQuery;
                // Ne pas ajouter la page 0 si c'est déjà la première page
                if ($i > 0 && !in_array($pageUrl, $pages)) {
                    $pages[] = $pageUrl;
                }
            }
        }

        // Si aucune pagination détectée, essayer de scraper jusqu'à trouver une page vide
        // On commencera par scraper les pages détectées, puis on pourra étendre si nécessaire
        if (empty($pages)) {
            $pages = [$baseUrl];
        }

        Log::info("Detected " . count($pages) . " pages for AFD (max page: {$maxPage})");
        return $pages;
    }

    /**
     * Obtenir les pages pour les sites génériques
     */
    protected function getGenericPages(DOMXPath $xpath, $baseUrl)
    {
        $pages = [$baseUrl];
        // Implémentation générique si nécessaire
        return $pages;
    }

    /**
     * Scraper une page spécifique
     */
    protected function scrapePage($url, AppelOffreConfig $config)
    {
        try {
            // Récupérer le contenu HTML
            Log::info("Fetching URL: {$url}");
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'fr-FR,fr;q=0.9,en;q=0.8',
                ])
                ->get($url);
            
            if (!$response->successful()) {
                Log::warning("Failed to fetch {$url}: HTTP {$response->status()}");
                return 0;
            }

            $html = $response->body();
            Log::info("HTML content length: " . strlen($html) . " bytes");
            
            // Parser le HTML
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Détecter le type de site et utiliser le scraper approprié
            $appelsOffres = $this->detectAndExtract($xpath, $config, $url);
            
            Log::info("Found " . count($appelsOffres) . " potential appels d'offres on this page");

            $count = 0;
            foreach ($appelsOffres as $appelOffreData) {
                // Valider les données avant de sauvegarder
                if (empty($appelOffreData['titre']) || empty($appelOffreData['lien_source'])) {
                    Log::debug("Skipping invalid appel d'offres: missing titre or lien");
                    continue;
                }

                // Nettoyer le titre (enlever les espaces multiples, etc.)
                $appelOffreData['titre'] = trim(preg_replace('/\s+/', ' ', $appelOffreData['titre']));
                
                // Vérifier si l'appel d'offres existe déjà (par lien ou titre similaire)
                $existing = AppelOffre::where('lien_source', $appelOffreData['lien_source'])
                    ->orWhere('titre', $appelOffreData['titre'])
                    ->first();

                if (!$existing) {
                    try {
                        AppelOffre::create($appelOffreData);
                        $count++;
                        Log::debug("Created appel d'offres: " . $appelOffreData['titre']);
                    } catch (\Exception $e) {
                        Log::error("Error creating appel d'offres: " . $e->getMessage());
                        continue;
                    }
                } else {
                    Log::debug("Appel d'offres already exists: " . $appelOffreData['titre']);
                }
            }

            return $count;
        } catch (\Exception $e) {
            Log::error("Error scraping page {$url}: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Détecter le type de site et utiliser le scraper approprié
     */
    protected function detectAndExtract(DOMXPath $xpath, AppelOffreConfig $config, $url)
    {
        // Détecter AFD
        if (strpos($url, 'afd.fr') !== false) {
            return $this->extractAppelsOffresAFD($xpath, $config, $url);
        }

        // Détecter Banque Mondiale
        if (strpos($url, 'worldbank.org') !== false || strpos($url, 'procurement-notices') !== false) {
            return $this->extractAppelsOffresWorldBank($xpath, $config, $url);
        }

        // Détecter BAD (AfDB)
        if (strpos($url, 'afdb.org') !== false) {
            return $this->extractAppelsOffresAfDB($xpath, $config, $url);
        }

        // Par défaut, utiliser le scraper générique
        return $this->extractAppelsOffres($xpath, $config);
    }

    /**
     * Scraper spécifique pour le site AFD
     */
    protected function extractAppelsOffresAFD(DOMXPath $xpath, AppelOffreConfig $config, $url)
    {
        $appelsOffres = [];

        Log::info("Starting AFD scraping from: {$url}");

        // Le site AFD utilise des cartes avec la classe fr-card__title
        $appelsOffres = [];
        
        // Méthode 1: Chercher les cartes AFD (structure spécifique)
        $cardPatterns = [
            '//div[contains(@class, "fr-card")]',
            '//article[contains(@class, "fr-card")]',
            '//*[contains(@class, "fr-card__title")]',
        ];
        
        $cards = [];
        foreach ($cardPatterns as $pattern) {
            $found = $xpath->query($pattern);
            if ($found && $found->length > 0) {
                Log::info("Found " . $found->length . " cards with pattern: {$pattern}");
                foreach ($found as $card) {
                    // Vérifier que la carte contient un lien vers un appel à projet
                    $hasLink = $xpath->query('.//a[contains(@href, "/appels-a-projets/")]', $card);
                    if ($hasLink && $hasLink->length > 0) {
                        $cards[] = $card;
                    }
                }
                if (count($cards) > 0) {
                    break;
                }
            }
        }
        
        // Méthode 2: Chercher directement les h3 avec fr-card__title
        if (empty($cards)) {
            $h3Cards = $xpath->query('//h3[contains(@class, "fr-card__title")]');
            if ($h3Cards && $h3Cards->length > 0) {
                Log::info("Found " . $h3Cards->length . " h3 cards");
                foreach ($h3Cards as $h3) {
                    // Remonter au parent pour obtenir la carte complète
                    $parent = $h3->parentNode;
                    $depth = 0;
                    while ($parent && $parent->nodeName !== 'body' && $depth < 5) {
                        $depth++;
                        if ($parent->hasAttribute('class') && 
                            (strpos($parent->getAttribute('class'), 'fr-card') !== false ||
                             strpos($parent->getAttribute('class'), 'card') !== false)) {
                            $cards[] = $parent;
                            break;
                        }
                        $parent = $parent->parentNode;
                    }
                }
            }
        }
        
        // Méthode 3: Chercher les titres h2 ou h3 contenant "Appel"
        $titlePatterns = [
            '//h2[contains(text(), "Appel")]',
            '//h3[contains(text(), "Appel")]',
            '//h2[contains(text(), "appel")]',
            '//h3[contains(text(), "appel")]',
        ];

        $foundTitles = [];
        if (empty($cards)) {
            foreach ($titlePatterns as $pattern) {
                $found = $xpath->query($pattern);
                if ($found && $found->length > 0) {
                    Log::info("Found " . $found->length . " titles with pattern: {$pattern}");
                    foreach ($found as $title) {
                        $foundTitles[] = $title;
                    }
                }
            }
        }
        
        // Utiliser les cartes trouvées comme éléments principaux
        $elements = [];
        foreach ($cards as $card) {
            $cardId = spl_object_hash($card);
            $elements[$cardId] = $card;
        }

        // Méthode 2: Chercher tous les liens vers les appels à projets
        // Le site AFD utilise des URLs comme /fr/appels-a-projets/nom-du-projet
        $linkPatterns = [
            '//a[contains(@href, "/appels-a-projets/")]',
            '//a[contains(@href, "appels-a-projets")]',
            '//a[contains(@href, "/appel")]',
            '//a[contains(@href, "appel-a-projet")]',
            '//a[starts-with(@href, "/fr/appels")]',
            '//a[contains(@href, "/appels")]',
        ];

        $links = null;
        foreach ($linkPatterns as $pattern) {
            $found = $xpath->query($pattern);
            if ($found && $found->length > 0) {
                $links = $found;
                Log::info("Found " . $links->length . " links with pattern: {$pattern}");
                break;
            }
        }

        if (!$links || $links->length === 0) {
            Log::warning("No links found with AFD patterns, trying broader search");
            // Essayer une recherche plus large - tous les liens
            $allLinks = $xpath->query('//a[@href]');
            Log::info("Found " . ($allLinks ? $allLinks->length : 0) . " total links on page");
            
            // Filtrer les liens qui pourraient être des appels à projets
            $links = [];
            if ($allLinks) {
                foreach ($allLinks as $link) {
                    $href = $link->getAttribute('href');
                    $text = trim($link->textContent);
                    // Si le lien ou son texte contient "appel" ou "projet"
                    if (stripos($href, 'appel') !== false || 
                        stripos($href, 'projet') !== false ||
                        stripos($text, 'appel') !== false ||
                        stripos($text, 'projet') !== false) {
                        $links[] = $link;
                    }
                }
                Log::info("Filtered to " . count($links) . " relevant links");
            }
        }

        $processedLinks = [];
        $elements = [];

        // Gérer à la fois DOMNodeList et array
        $linksCount = is_array($links) ? count($links) : ($links ? $links->length : 0);
        
        if ($linksCount > 0) {
            foreach ($links as $link) {
                $href = $link->getAttribute('href');
                if (empty($href) || in_array($href, $processedLinks)) {
                    continue;
                }

                // Filtrer les liens pertinents pour AFD
                // Les liens d'appels à projets contiennent généralement "appels-a-projets" dans l'URL
                $isRelevant = (
                    strpos($href, '/appels-a-projets/') !== false ||
                    strpos($href, 'appel-a-projet') !== false ||
                    (strpos($href, 'appel') !== false && strpos($href, 'projet') !== false)
                );

                // Si on a beaucoup de liens, filtrer plus strictement
                if ($linksCount > 50 && !$isRelevant) {
                    continue;
                }

                $processedLinks[] = $href;

                // Remonter au parent pour obtenir le contexte complet
                $parent = $link->parentNode;
                $maxDepth = 10;
                $depth = 0;
                
                while ($parent && $parent->nodeName !== 'body' && $depth < $maxDepth) {
                    $depth++;
                    // Chercher un conteneur parent approprié
                    if ($parent->nodeName === 'article' || 
                        ($parent->nodeName === 'div' && $parent->hasAttribute('class')) ||
                        ($parent->nodeName === 'li')) {
                        // Vérifier que ce parent n'a pas déjà été ajouté
                        $parentId = spl_object_hash($parent);
                        if (!isset($elements[$parentId])) {
                            $elements[$parentId] = $parent;
                        }
                        break;
                    }
                    $parent = $parent->parentNode;
                }
            }
        }

        // Si aucun lien trouvé, essayer les patterns génériques
        if (empty($elements)) {
            $patterns = [
                '//article',
                '//div[contains(@class, "card")]',
                '//div[contains(@class, "item")]',
                '//li[contains(@class, "item")]',
            ];

            foreach ($patterns as $pattern) {
                $found = $xpath->query($pattern);
                if ($found && $found->length > 0) {
                    foreach ($found as $element) {
                        // Vérifier que l'élément contient un lien vers un appel à projet
                        $hasLink = $xpath->query('.//a[contains(@href, "appel") or contains(@href, "projet")]', $element);
                        if ($hasLink && $hasLink->length > 0) {
                            $elements[spl_object_hash($element)] = $element;
                        }
                    }
                    if (count($elements) > 0) {
                        break;
                    }
                }
            }
        }

        // Traiter aussi les titres trouvés si on n'a pas de cartes
        if (empty($elements) && !empty($foundTitles)) {
            Log::info("Processing " . count($foundTitles) . " titles found");
            foreach ($foundTitles as $title) {
                // Remonter au parent pour obtenir le contexte
                $parent = $title->parentNode;
                $maxDepth = 5;
                $depth = 0;
                
                while ($parent && $parent->nodeName !== 'body' && $depth < $maxDepth) {
                    $depth++;
                    if ($parent->nodeName === 'article' || 
                        ($parent->nodeName === 'div' && $parent->hasAttribute('class')) ||
                        $parent->nodeName === 'li') {
                        $parentId = spl_object_hash($parent);
                        if (!isset($elements[$parentId])) {
                            $elements[$parentId] = $parent;
                        }
                        break;
                    }
                    $parent = $parent->parentNode;
                }
            }
        }

        Log::info("Processing " . count($elements) . " elements");

        foreach ($elements as $element) {
            try {
                $appelOffre = $this->extractAppelOffreAFD($element, $xpath, $config, $url);
                if ($appelOffre && !empty($appelOffre['titre']) && !empty($appelOffre['lien_source'])) {
                    $appelsOffres[] = $appelOffre;
                } else {
                    Log::debug("Skipped element - missing titre or lien: " . ($appelOffre['titre'] ?? 'no titre') . " / " . ($appelOffre['lien_source'] ?? 'no lien'));
                }
            } catch (\Exception $e) {
                Log::debug("Error extracting AFD appel: " . $e->getMessage());
                continue;
            }
        }

        Log::info("Extracted " . count($appelsOffres) . " appels d'offres from AFD");
        return $appelsOffres;
    }

    /**
     * Extraire un appel d'offres spécifique depuis AFD
     */
    protected function extractAppelOffreAFD($element, DOMXPath $xpath, AppelOffreConfig $config, $baseUrl)
    {
        // Extraire le lien d'abord (plus fiable)
        $lien = '';
        
        // D'abord chercher les liens spécifiques AFD (fr-card__link)
        $afdLinkNodes = $xpath->query('.//a[contains(@class, "fr-card__link")]', $element);
        if ($afdLinkNodes && $afdLinkNodes->length > 0) {
            $href = $afdLinkNodes->item(0)->getAttribute('href');
            $lien = $this->resolveUrl($href, $baseUrl);
        }
        
        // Sinon chercher les liens vers appels-a-projets
        if (empty($lien)) {
            $linkNodes = $xpath->query('.//a[contains(@href, "/appels-a-projets/")]', $element);
            if ($linkNodes && $linkNodes->length > 0) {
                $href = $linkNodes->item(0)->getAttribute('href');
                $lien = $this->resolveUrl($href, $baseUrl);
            }
        }
        
        // Sinon chercher n'importe quel lien avec "appel" ou "projet"
        if (empty($lien)) {
            $linkNodes = $xpath->query('.//a[contains(@href, "appel") or contains(@href, "projet")]', $element);
            if ($linkNodes && $linkNodes->length > 0) {
                $href = $linkNodes->item(0)->getAttribute('href');
                $lien = $this->resolveUrl($href, $baseUrl);
            }
        }

        // Si pas de lien trouvé, chercher n'importe quel lien dans l'élément
        if (empty($lien)) {
            $allLinks = $xpath->query('.//a[@href]', $element);
            if ($allLinks && $allLinks->length > 0) {
                // Prendre le premier lien qui semble pertinent
                foreach ($allLinks as $link) {
                    $href = $link->getAttribute('href');
                    $linkText = trim($link->textContent);
                    // Si le lien ou son texte contient "appel" ou "projet", ou si c'est un lien vers une page détaillée
                    if (strpos($href, 'appel') !== false || 
                        strpos($href, 'projet') !== false ||
                        stripos($linkText, 'appel') !== false ||
                        stripos($linkText, 'projet') !== false ||
                        (strpos($href, '/fr/') !== false && strlen($href) > 20)) {
                        $lien = $this->resolveUrl($href, $baseUrl);
                        break;
                    }
                }
                // Si toujours pas de lien, prendre le premier lien non-externe
                if (empty($lien) && $allLinks->length > 0) {
                    $firstHref = $allLinks->item(0)->getAttribute('href');
                    if (strpos($firstHref, 'http') === false || strpos($firstHref, 'afd.fr') !== false) {
                        $lien = $this->resolveUrl($firstHref, $baseUrl);
                    }
                }
            }
        }

        // Si toujours pas de lien, chercher dans les éléments frères ou parents
        if (empty($lien)) {
            $parent = $element->parentNode;
            $depth = 0;
            while ($parent && $parent->nodeName !== 'body' && $depth < 3) {
                $depth++;
                $siblingLinks = $xpath->query('.//a[contains(@href, "appel") or contains(@href, "projet")]', $parent);
                if ($siblingLinks && $siblingLinks->length > 0) {
                    $href = $siblingLinks->item(0)->getAttribute('href');
                    $lien = $this->resolveUrl($href, $baseUrl);
                    break;
                }
                $parent = $parent->parentNode;
            }
        }

        // Extraire le titre - chercher dans h1, h2, h3, ou dans les liens
        $titre = '';
        
        // D'abord chercher dans les titres
        $titreNodes = $xpath->query('.//h1 | .//h2 | .//h3 | .//h4', $element);
        if ($titreNodes && $titreNodes->length > 0) {
            $titre = trim($titreNodes->item(0)->textContent);
        }

        // Si pas de titre dans les h, chercher dans le texte du lien
        if (empty($titre) && $linkNodes && $linkNodes->length > 0) {
            $titre = trim($linkNodes->item(0)->textContent);
        }

        // Si toujours pas de titre, chercher dans les spans ou divs avec classe title
        if (empty($titre)) {
            $titleNodes = $xpath->query('.//span[contains(@class, "title")] | .//div[contains(@class, "title")] | .//*[contains(@class, "heading")]', $element);
            if ($titleNodes && $titleNodes->length > 0) {
                $titre = trim($titleNodes->item(0)->textContent);
            }
        }

        // Dernier recours : prendre le premier texte significatif de l'élément
        if (empty($titre)) {
            $text = trim($element->textContent);
            // Prendre les premiers 100 caractères comme titre
            $titre = substr($text, 0, 100);
            // Nettoyer le titre
            $titre = preg_replace('/\s+/', ' ', $titre);
        }

        // Extraire la date limite - chercher les patterns de date AFD
        $dateLimite = null;
        
        // Récupérer tout le texte de l'élément pour chercher les dates
        $elementText = $element->textContent;
        
        // Chercher le pattern AFD: "DD mois YYYY - DD mois YYYY" (ex: "6 octobre 2025 - 24 novembre 2025")
        if (preg_match('/(\d{1,2})\s+(janvier|février|mars|avril|mai|juin|juillet|août|septembre|octobre|novembre|décembre)\s+(\d{4})\s*-\s*(\d{1,2})\s+(janvier|février|mars|avril|mai|juin|juillet|août|septembre|octobre|novembre|décembre)\s+(\d{4})/i', $elementText, $matches)) {
            // Prendre la date de fin (clôture) - matches[4], matches[5], matches[6]
            $dateLimite = $this->parseDate($matches[4] . ' ' . $matches[5] . ' ' . $matches[6]);
        }
        // Chercher aussi le format avec slash
        elseif (preg_match('/(\d{1,2}\/\d{1,2}\/\d{4})\s*-\s*(\d{1,2}\/\d{1,2}\/\d{4})/', $elementText, $matches)) {
            $dateLimite = $this->parseDate($matches[2]);
        }
        // Chercher une date simple
        elseif (preg_match('/(\d{1,2})\s+(janvier|février|mars|avril|mai|juin|juillet|août|septembre|octobre|novembre|décembre)\s+(\d{4})/i', $elementText, $matches)) {
            $dateLimite = $this->parseDate($matches[1] . ' ' . $matches[2] . ' ' . $matches[3]);
        }
        else {
            // Essayer avec les patterns XPath
            $datePatterns = [
                './/time[@datetime]',
                './/time',
                './/span[contains(@class, "date")]',
                './/div[contains(@class, "date")]',
            ];

            foreach ($datePatterns as $pattern) {
                $dateNodes = $xpath->query($pattern, $element);
                if ($dateNodes && $dateNodes->length > 0) {
                    foreach ($dateNodes as $dateNode) {
                        $dateText = '';
                        if ($dateNode->hasAttribute('datetime')) {
                            $dateText = $dateNode->getAttribute('datetime');
                        } else {
                            $dateText = trim($dateNode->textContent);
                        }
                        $dateLimite = $this->parseDate($dateText);
                        if ($dateLimite) {
                            break;
                        }
                    }
                    if ($dateLimite) {
                        break;
                    }
                }
            }
        }

        // Extraire la description
        $description = '';
        $descNodes = $xpath->query('.//p | .//div[contains(@class, "description")] | .//div[contains(@class, "excerpt")] | .//div[contains(@class, "summary")]', $element);
        if ($descNodes && $descNodes->length > 0) {
            $description = trim($descNodes->item(0)->textContent);
        }

        // Extraire la zone géographique - chercher dans le texte de l'élément
        $zoneGeographique = $config->zone_geographique;
        
        // Chercher les noms de pays/continents dans le texte
        $elementText = $element->textContent;
        $countries = ['Afrique', 'Europe', 'Asie', 'Amérique', 'Tchad', 'Cameroun', 'Sénégal', 'Mali', 'Burkina Faso', 
                     'République centrafricaine', 'RDC', 'Congo', 'Gabon', 'Guinée', 'Madagascar', 'Comores', 'Maurice'];
        
        $foundLocations = [];
        foreach ($countries as $country) {
            if (stripos($elementText, $country) !== false) {
                $foundLocations[] = $country;
            }
        }
        
        if (!empty($foundLocations)) {
            $zoneGeographique = implode(', ', array_unique($foundLocations));
        } else {
            // Chercher avec XPath
            $locationNodes = $xpath->query('.//span[contains(@class, "location")] | .//div[contains(@class, "location")] | .//*[contains(@class, "country")]', $element);
            if ($locationNodes && $locationNodes->length > 0) {
                $locationText = trim($locationNodes->item(0)->textContent);
                if (!empty($locationText) && strlen($locationText) < 200) {
                    $zoneGeographique = $locationText;
                }
            }
        }

        // Extraire le type/thématique - AFD affiche les thématiques comme tags
        $typeMarche = $config->type_marche;
        $typeNodes = $xpath->query('.//span[contains(@class, "category")] | .//div[contains(@class, "category")] | .//span[contains(@class, "tag")] | .//*[contains(@class, "thematic")]', $element);
        if ($typeNodes && $typeNodes->length > 0) {
            $types = [];
            foreach ($typeNodes as $node) {
                $typeText = trim($node->textContent);
                if (!empty($typeText) && strlen($typeText) < 100 && !in_array($typeText, $types)) {
                    $types[] = $typeText;
                }
            }
            if (!empty($types)) {
                $typeMarche = implode(', ', $types);
            }
        }

        if (empty($titre) || empty($lien)) {
            return null;
        }

        return [
            'titre' => $titre,
            'source' => $config->source_ptf,
            'type_marche' => $typeMarche,
            'zone_geographique' => $zoneGeographique,
            'lien_source' => $lien,
            'date_limite' => $dateLimite,
            'description' => $description ?: null,
            'is_actif' => true,
        ];
    }

    /**
     * Scraper spécifique pour la Banque Mondiale (placeholder)
     */
    protected function extractAppelsOffresWorldBank(DOMXPath $xpath, AppelOffreConfig $config, $url)
    {
        // À implémenter selon la structure du site World Bank
        return $this->extractAppelsOffres($xpath, $config);
    }

    /**
     * Scraper spécifique pour la BAD (placeholder)
     */
    protected function extractAppelsOffresAfDB(DOMXPath $xpath, AppelOffreConfig $config, $url)
    {
        // À implémenter selon la structure du site AfDB
        return $this->extractAppelsOffres($xpath, $config);
    }

    /**
     * Extraire les appels d'offres depuis le DOM (méthode générique)
     * Cette méthode doit être adaptée selon la structure de chaque site
     */
    protected function extractAppelsOffres(DOMXPath $xpath, AppelOffreConfig $config)
    {
        $appelsOffres = [];

        // Structure générique pour différents types de sites
        // On cherche des liens, des titres, des dates dans différentes structures communes

        // Chercher les éléments qui pourraient contenir des appels d'offres
        // Patterns communs : articles, divs avec classes spécifiques, listes, etc.
        
        $patterns = [
            '//article',
            '//div[contains(@class, "appel")]',
            '//div[contains(@class, "offre")]',
            '//div[contains(@class, "tender")]',
            '//div[contains(@class, "procurement")]',
            '//li[contains(@class, "appel")]',
            '//tr[contains(@class, "appel")]',
        ];

        $elements = [];
        foreach ($patterns as $pattern) {
            $found = $xpath->query($pattern);
            if ($found && $found->length > 0) {
                foreach ($found as $element) {
                    $elements[] = $element;
                }
                break; // Utiliser le premier pattern qui trouve des résultats
            }
        }

        // Si aucun pattern ne fonctionne, essayer une extraction générique
        if (empty($elements)) {
            $elements = $xpath->query('//a[contains(@href, "appel") or contains(@href, "offre") or contains(@href, "tender") or contains(@href, "procurement")]');
        }

        foreach ($elements as $element) {
            try {
                $appelOffre = $this->extractAppelOffreFromElement($element, $xpath, $config);
                if ($appelOffre) {
                    $appelsOffres[] = $appelOffre;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $appelsOffres;
    }

    /**
     * Extraire les données d'un appel d'offres depuis un élément DOM
     */
    protected function extractAppelOffreFromElement($element, DOMXPath $xpath, AppelOffreConfig $config)
    {
        // Extraire le titre
        $titre = '';
        $titreNodes = $xpath->query('.//h1 | .//h2 | .//h3 | .//a | .//span[contains(@class, "title")] | .//div[contains(@class, "title")]', $element);
        if ($titreNodes && $titreNodes->length > 0) {
            $titre = trim($titreNodes->item(0)->textContent);
        }

        if (empty($titre)) {
            $titre = trim($element->textContent);
        }

        // Extraire le lien
        $lien = '';
        $linkNodes = $xpath->query('.//a[@href]', $element);
        if ($linkNodes && $linkNodes->length > 0) {
            $href = $linkNodes->item(0)->getAttribute('href');
            $lien = $this->resolveUrl($href, $config->site_officiel);
        }

        // Extraire la date limite
        $dateLimite = null;
        $dateNodes = $xpath->query('.//time | .//span[contains(@class, "date")] | .//div[contains(@class, "date")]', $element);
        if ($dateNodes && $dateNodes->length > 0) {
            $dateText = trim($dateNodes->item(0)->textContent);
            $dateLimite = $this->parseDate($dateText);
        }

        // Extraire la description
        $description = '';
        $descNodes = $xpath->query('.//p | .//div[contains(@class, "description")] | .//span[contains(@class, "description")]', $element);
        if ($descNodes && $descNodes->length > 0) {
            $description = trim($descNodes->item(0)->textContent);
        }

        if (empty($titre) || empty($lien)) {
            return null;
        }

        return [
            'titre' => $titre,
            'source' => $config->source_ptf,
            'type_marche' => $config->type_marche,
            'zone_geographique' => $config->zone_geographique,
            'lien_source' => $lien,
            'date_limite' => $dateLimite,
            'description' => $description ?: null,
            'is_actif' => true, // Publier automatiquement
        ];
    }

    /**
     * Résoudre une URL relative en URL absolue
     */
    protected function resolveUrl($url, $baseUrl)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        $parsedBase = parse_url($baseUrl);
        $base = $parsedBase['scheme'] . '://' . $parsedBase['host'];
        
        if (isset($parsedBase['path'])) {
            $base .= dirname($parsedBase['path']);
        }

        if (strpos($url, '/') === 0) {
            return $parsedBase['scheme'] . '://' . $parsedBase['host'] . $url;
        }

        return rtrim($base, '/') . '/' . ltrim($url, '/');
    }

    /**
     * Parser une date depuis un texte
     */
    protected function parseDate($dateText)
    {
        if (empty($dateText)) {
            return null;
        }

        // Nettoyer le texte
        $dateText = trim(preg_replace('/\s+/', ' ', $dateText));
        
        // Formats de date communs (incluant les formats français)
        $formats = [
            'd/m/Y',
            'Y-m-d',
            'd-m-Y',
            'd M Y',
            'd F Y',
            'j F Y', // Format AFD: "6 octobre 2025"
            'd F Y',
            'Y/m/d',
            'd M. Y',
            'j M Y',
        ];

        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $dateText);
            if ($date) {
                return $date->format('Y-m-d');
            }
        }

        // Essayer avec strtotime (gère les dates en français si locale est configurée)
        $timestamp = strtotime($dateText);
        if ($timestamp !== false && $timestamp > 0) {
            return date('Y-m-d', $timestamp);
        }

        // Essayer de parser les dates françaises manuellement
        $frenchMonths = [
            'janvier' => '01', 'février' => '02', 'mars' => '03', 'avril' => '04',
            'mai' => '05', 'juin' => '06', 'juillet' => '07', 'août' => '08',
            'septembre' => '09', 'octobre' => '10', 'novembre' => '11', 'décembre' => '12'
        ];

        foreach ($frenchMonths as $month => $num) {
            if (preg_match('/(\d{1,2})\s+' . $month . '\s+(\d{4})/i', $dateText, $matches)) {
                return sprintf('%04d-%02d-%02d', $matches[2], $num, (int)$matches[1]);
            }
        }

        return null;
    }
}

