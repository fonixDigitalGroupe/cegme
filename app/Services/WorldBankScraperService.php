<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use DOMXPath;

class WorldBankScraperService
{
    /**
     * URL de l'API pour les appels d'offres de la Banque Mondiale
     */
    private const API_BASE_URL = 'https://search.worldbank.org/api/v2/procnotices';

    /**
     * Nombre maximum de pages à scraper (sécurité pour éviter les boucles infinies)
     */
    private const MAX_PAGES = 200;

    /**
     * Scrape les appels d'offres depuis l'API de la Banque Mondiale
     *
     * @return array ['count' => int, 'stats' => array] Nombre d'appels d'offres récupérés et statistiques
     */
    public function scrape(): array
    {
        // Vider la base de données avant chaque scraping
        $deletedCount = Offre::where('source', 'World Bank')->delete();
        Log::info("World Bank Scraper: Base de données vidée", ['offres_supprimees' => $deletedCount]);
        
        $totalCount = 0;
        $totalNoticesFound = 0;
        $totalExcluded = 0;
        $start = 0; // Offset de départ
        $rows = 100; // Nombre de résultats par page
        $pagesStats = []; // Statistiques par page
        $page = 0;

        try {
            while ($start < 10000) { // Limite de sécurité (10,000 résultats max)
                Log::info("World Bank Scraper: Fetching page {$page} (start={$start})");
                
                $result = $this->fetchApiPage($start, $rows);
                $count = $result['count'];
                $hasMore = $result['has_more'];
                $noticesFound = $result['notices_found'] ?? 0;
                $excluded = $result['excluded'] ?? 0;
                
                $totalCount += $count;
                $totalNoticesFound += $noticesFound;
                $totalExcluded += $excluded;
                
                // Enregistrer les stats de cette page
                $pagesStats[$page] = [
                    'kept' => $count,
                    'found' => $noticesFound,
                    'excluded' => $excluded,
                ];
                
                Log::info("World Bank Scraper: Page {$page} traitée", [
                    'offres_trouvees' => $count,
                    'notices_trouvees' => $noticesFound,
                    'exclues' => $excluded,
                    'total_accumule' => $totalCount,
                    'start' => $start,
                ]);
                
                // Arrêter si aucune offre trouvée ou pas de suite
                if ($count === 0 || !$hasMore) {
                    Log::info("World Bank Scraper: Page {$page} a retourné 0 offres ou fin de pagination, arrêt.");
                    break;
                }
                
                $start += $rows;
                $page++;
                usleep(500000); // 0.5 seconde entre les pages
            }

        } catch (\Exception $e) {
            Log::error('World Bank Scraper: Exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        $stats = [
            'total_pages_scraped' => $page,
            'total_notices_found' => $totalNoticesFound,
            'total_notices_kept' => $totalCount,
            'total_notices_excluded' => $totalExcluded,
            'offres_par_page' => $pagesStats,
        ];
        
        Log::info('World Bank Scraper: Résumé du scraping avec filtrage', $stats);

        return ['count' => $totalCount, 'stats' => $stats];
    }

    /**
     * Récupère une page de résultats depuis l'API
     *
     * @param int $start Offset de départ
     * @param int $rows Nombre de résultats par page
     * @return array ['count' => int, 'has_more' => bool]
     */
    private function fetchApiPage(int $start, int $rows): array
    {
        $count = 0;
        
        try {
            $params = [
                'format' => 'json',
                'fl' => 'id,submission_deadline_date,project_ctry_name,project_id,project_name,notice_type,procurement_type,notice_url',
                'srt' => 'submission_deadline_date',
                'order' => 'desc',
                'apilang' => 'en',
                'srce' => 'both',
                'os' => $start, // Offset
                'rows' => $rows, // Nombre de résultats
            ];
            
            // Note: L'API peut être instable, on essaie sans certains paramètres si nécessaire
            
            // Note: On ne peut pas filtrer par notice_type dans l'API, donc on filtre après récupération
            
            $url = self::API_BASE_URL . '?' . http_build_query($params);
            
            Log::info("World Bank Scraper: Fetching API", ['url' => $url]);
            
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'application/json',
                ])
                ->get($url);

            if (!$response->successful()) {
                Log::error('World Bank Scraper: Failed to fetch API', [
                    'status' => $response->status(),
                    'url' => $url,
                ]);
                return ['count' => 0, 'has_more' => false];
            }

            $data = $response->json();
            
            // L'API retourne 'procnotices' au lieu de 'documents'
            if (!isset($data['procnotices']) || !is_array($data['procnotices'])) {
                Log::warning('World Bank Scraper: Invalid API response structure', ['data_keys' => array_keys($data ?? [])]);
                return ['count' => 0, 'has_more' => false];
            }

            $documents = $data['procnotices'];
            $totalFound = (int)($data['total'] ?? 0);
            $hasMore = ($start + count($documents)) < $totalFound;
            
            $totalNotices = count($documents);
            $excludedCount = 0;
            $exclusionReasons = [];
            $keptCount = 0;
            
            Log::info("World Bank Scraper: API response", [
                'documents_count' => $totalNotices,
                'total_found' => $totalFound,
                'has_more' => $hasMore,
            ]);

            // Traiter chaque document
            foreach ($documents as $doc) {
                try {
                    // Vérifier d'abord si le type de notice est valide
                    $filterResult = $this->shouldKeepNotice($doc);
                    
                    if (!$filterResult['keep']) {
                        $excludedCount++;
                        $reason = $filterResult['reason'] ?? 'Unknown';
                        if (!isset($exclusionReasons[$reason])) {
                            $exclusionReasons[$reason] = 0;
                        }
                        $exclusionReasons[$reason]++;
                        Log::debug("World Bank Scraper: Notice excluded", [
                            'id' => $doc['id'] ?? 'N/A',
                            'notice_type' => $doc['notice_type'] ?? 'N/A',
                            'reason' => $reason,
                        ]);
                        continue;
                    }
                    
                    $offre = $this->extractOffreFromApiDocument($doc);
                    
                    if ($offre && !empty($offre['titre']) && !empty($offre['lien_source'])) {
                        // Vérifier si l'offre existe déjà (par titre ou lien)
                        $existing = Offre::where('lien_source', $offre['lien_source'])
                            ->orWhere(function($q) use ($offre) {
                                $q->where('titre', $offre['titre'])
                                  ->where('source', 'World Bank');
                            })
                            ->first();
                        
                        if (!$existing) {
                            Offre::create($offre);
                            $count++;
                        }
                        $keptCount++;
                    }
                } catch (\Exception $e) {
                    Log::warning('World Bank Scraper: Error processing document', [
                        'error' => $e->getMessage(),
                        'doc' => $doc,
                    ]);
                    continue;
                }
            }
            
            Log::info("World Bank Scraper: Filtering results for page", [
                'page' => $start / $rows,
                'total_notices' => $totalNotices,
                'kept_and_saved' => $count,
                'kept_total' => $keptCount,
                'excluded' => $excludedCount,
                'exclusion_reasons' => $exclusionReasons,
            ]);

        } catch (\Exception $e) {
            Log::error('World Bank Scraper: Exception occurred while fetching API page', [
                'start' => $start,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return [
            'count' => $count,
            'has_more' => $hasMore ?? false,
            'notices_found' => $totalNotices ?? 0,
            'excluded' => $excludedCount ?? 0,
        ];
    }

    /**
     * Vérifie si une notice doit être gardée selon les règles de filtrage
     *
     * @param array $doc Document JSON de l'API
     * @return array ['keep' => bool, 'reason' => string|null]
     */
    private function shouldKeepNotice(array $doc): array
    {
        $noticeType = $doc['notice_type'] ?? '';
        $noticeTypeLower = strtolower($noticeType);
        
        // Types de notices à GARDER (Appels d'Offres réels)
        $keepPatterns = [
            'request for proposal',
            'request for proposals',
            'request for bid',
            'request for bids',
            'invitation for bid',
            'invitation for bids',
            'invitation to bid',
            'consultant service',
            'consultant services',
            'selection of consultant',
            'selection of consultants',
            'firm selection',
            'individual consultant',
            'individual consulting',
            'invitation for prequalification', // Prequalification est un appel d'offres
        ];
        
        // Types de notices à EXCLURE
        $excludePatterns = [
            'general procurement notice',
            'procurement plan',
            'contract award',
            'prior review',
            'information notice',
            'informational notice',
            'archived',
            'archived notice',
            'archive',
        ];
        
        // Vérifier d'abord les patterns d'exclusion
        foreach ($excludePatterns as $pattern) {
            if (stripos($noticeTypeLower, $pattern) !== false) {
                return [
                    'keep' => false,
                    'reason' => "Excluded: {$noticeType}",
                ];
            }
        }
        
        // Vérifier les patterns à garder
        foreach ($keepPatterns as $pattern) {
            if (stripos($noticeTypeLower, $pattern) !== false) {
                return [
                    'keep' => true,
                    'reason' => null,
                ];
            }
        }
        
        // Cas spécial: "Request for Expression of Interest" seul (sans consultant) doit être exclu
        if (stripos($noticeTypeLower, 'expression of interest') !== false) {
            // Vérifier s'il y a des mots-clés de consultant dans le titre du projet
            $projectName = strtolower($doc['project_name'] ?? '');
            $consultantKeywords = ['consultant', 'consulting', 'firm', 'advisory', 'technical assistance'];
            $hasConsultantKeyword = false;
            foreach ($consultantKeywords as $keyword) {
                if (stripos($projectName, $keyword) !== false) {
                    $hasConsultantKeyword = true;
                    break;
                }
            }
            
            if (!$hasConsultantKeyword) {
                return [
                    'keep' => false,
                    'reason' => "Excluded: Expression of Interest without consultant selection",
                ];
            }
        }
        
        // Si aucun pattern ne correspond, exclure par défaut (principe de sécurité)
        return [
            'keep' => false,
            'reason' => "Excluded: Unknown or unclassified notice type: {$noticeType}",
        ];
    }

    /**
     * Extrait les données d'une offre depuis un document API
     *
     * @param array $doc Document JSON de l'API
     * @return array|null
     */
    private function extractOffreFromApiDocument(array $doc): ?array
    {
        try {
            // Titre: utiliser project_name ou notice_type
            $titre = $doc['project_name'] ?? $doc['notice_type'] ?? null;
            
            if (!$titre || strlen(trim($titre)) < 30) {
                return null;
            }
            
            // STRATÉGIE DE LIEN WORLD BANK (MANDATORY)
            // RÈGLE 1: Si project_id existe, utiliser le lien vers la page du projet (STABLE)
            // RÈGLE 2: Sinon, utiliser le lien de recherche contextuelle (FALLBACK)
            // INTERDIT: Ne JAMAIS utiliser /procurement/notice/{id} (404 garanti)
            
            $projectId = $doc['project_id'] ?? null;
            $lien = null;
            $linkType = null;
            
            if ($projectId) {
                // PRIORITÉ 1: Lien vers la page du projet (STABLE)
                $lien = 'https://projects.worldbank.org/en/projects-operations/project-detail/' . $projectId;
                $linkType = 'project_detail';
            } else {
                // PRIORITÉ 2: Lien de recherche contextuelle (FALLBACK)
                $baseUrl = 'https://projects.worldbank.org/en/projects-operations/procurement';
                $params = [];
                
                // searchTerm = titre de la notice (obligatoire)
                $params['searchTerm'] = $titre;
                
                // country = pays si disponible
                if (isset($doc['project_ctry_name']) && !empty($doc['project_ctry_name'])) {
                    $countries = is_array($doc['project_ctry_name'])
                        ? $doc['project_ctry_name']
                        : [$doc['project_ctry_name']];
                    if (!empty($countries[0])) {
                        $params['country'] = $countries[0];
                    }
                }
                
                // notice_type = type de notice si disponible
                if (isset($doc['notice_type']) && !empty($doc['notice_type'])) {
                    $noticeType = strtolower(trim($doc['notice_type']));
                    if (stripos($noticeType, 'invitation for bid') !== false ||
                        stripos($noticeType, 'invitation to bid') !== false) {
                        $params['noticeType'] = 'Invitation for Bids';
                    } elseif (stripos($noticeType, 'request for proposal') !== false) {
                        $params['noticeType'] = 'Request for Proposals';
                    } elseif (stripos($noticeType, 'request for expression') !== false) {
                        $params['noticeType'] = 'Request for Expression of Interest';
                    } elseif (stripos($noticeType, 'prequalification') !== false) {
                        $params['noticeType'] = 'Invitation for Prequalification';
                    }
                }
                
                $lien = $baseUrl . '?' . http_build_query($params);
                $linkType = 'search_context';
            }
            
            if (!$lien) {
                return null;
            }
            
            // Date limite
            $dateLimite = null;
            if (isset($doc['submission_deadline_date']) && !empty($doc['submission_deadline_date'])) {
                try {
                    $dateStr = $doc['submission_deadline_date'];
                    if (preg_match('/^\d{4}-\d{2}-\d{2}/', $dateStr)) {
                        $dateLimite = substr($dateStr, 0, 10);
                    } else {
                        $date = \Carbon\Carbon::parse($dateStr);
                        $dateLimite = $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    Log::debug('World Bank Scraper: Error parsing date', ['date' => $doc['submission_deadline_date'] ?? null]);
                }
            }
            
            // Pays/Zone géographique
            $pays = null;
            if (isset($doc['project_ctry_name']) && is_array($doc['project_ctry_name'])) {
                $pays = implode(', ', array_filter($doc['project_ctry_name']));
            } elseif (isset($doc['project_ctry_name']) && is_string($doc['project_ctry_name'])) {
                $pays = $doc['project_ctry_name'];
            }
            
            // Acheteur
            $acheteur = "World Bank";
            
            $noticeType = $doc['notice_type'] ?? null;

            return [
                'titre' => $titre,
                'acheteur' => $acheteur,
                'pays' => $pays,
                'date_limite_soumission' => $dateLimite,
                'lien_source' => $lien,
                'source' => 'World Bank',
                'project_id' => $projectId,
                'link_type' => $linkType,
                'detail_url' => null, // TOUJOURS NULL pour World Bank
                'notice_type' => $noticeType,
            ];

        } catch (\Exception $e) {
            Log::warning('World Bank Scraper: Error extracting data from API document', [
                'error' => $e->getMessage(),
                'doc' => $doc,
            ]);
            return null;
        }
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
        $url = $this->buildPageUrl($page);
        
        try {
            // Récupérer la page HTML
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9,fr;q=0.8',
                ])
                ->get($url);

            if (!$response->successful()) {
                Log::error('World Bank Scraper: Failed to fetch page', [
                    'status' => $response->status(),
                    'url' => $url,
                    'page' => $page,
                ]);
                return ['count' => 0, 'html' => ''];
            }

            $html = $response->body();
            
            // Sauvegarder le HTML pour debug
            if (config('app.debug')) {
                \Storage::disk('local')->put("debug/worldbank_page_{$page}.html", $html);
                Log::info("World Bank Scraper: HTML saved for page {$page}", [
                    'path' => "debug/worldbank_page_{$page}.html",
                    'html_length' => strlen($html),
                ]);
            }
            
            // Parser le HTML
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Extraire les appels d'offres
            // La structure HTML de World Bank peut varier, utiliser plusieurs stratégies
            $items = [];
            
            // Stratégie 1: Chercher tous les liens (plus permissif)
            // Le site World Bank peut utiliser différents patterns pour les liens
            $allLinks = $xpath->query("//a[@href]");
            
            $validLinks = [];
            $excludedTexts = ['view all', 'see more', 'next', 'previous', 'page', 'home', 'search', 'back to', 'menu', 'skip'];
            
            foreach ($allLinks as $link) {
                $href = $link->getAttribute('href');
                $text = trim($link->textContent);
                $textLower = strtolower($text);
                
                // Ignorer les liens de navigation/liste
                if (stripos($href, '/procurement?') !== false || stripos($href, '/procurement#') !== false) {
                    continue;
                }
                
                // Ignorer les liens vers des pages générales
                if (in_array($href, ['/', '/en/home', '/fr/home', '/es/home'])) {
                    continue;
                }
                
                // Ignorer les liens avec des textes de navigation
                $isNavigation = false;
                foreach ($excludedTexts as $excluded) {
                    if (stripos($textLower, $excluded) !== false && strlen($text) < 50) {
                        $isNavigation = true;
                        break;
                    }
                }
                
                // Garder les liens qui semblent être des appels d'offres/projets
                // Soit ils contiennent 'procurement' ou 'project' dans l'URL, soit ils ont un texte long
                $isValid = false;
                
                // Lien vers procurement ou project
                if (stripos($href, '/procurement/') !== false || stripos($href, '/project/') !== false || 
                    stripos($href, 'procurement') !== false || stripos($href, 'project') !== false) {
                    $isValid = true;
                }
                
                // Ou texte long qui pourrait être un titre d'appel d'offres
                if (!$isValid && strlen($text) > 40 && !$isNavigation) {
                    // Si le texte contient des mots-clés pertinents
                    $keywords = ['procurement', 'consultant', 'firm', 'service', 'goods', 'works', 'rfp', 'rfq', 'tender', 'bid', 'call'];
                    foreach ($keywords as $keyword) {
                        if (stripos($textLower, $keyword) !== false) {
                            $isValid = true;
                            break;
                        }
                    }
                }
                
                if ($isValid && !$isNavigation) {
                    $validLinks[] = $link;
                }
            }
            
            Log::info('World Bank Scraper: Valid links found', ['page' => $page, 'count' => count($validLinks)]);
            
            // Traiter chaque lien pour trouver le conteneur parent
            foreach ($validLinks as $link) {
                $href = $link->getAttribute('href');
                
                // Récupérer le conteneur parent
                $parent = $link;
                for ($i = 0; $i < 10; $i++) {
                    $parent = $parent->parentNode;
                    if (!$parent || $parent->nodeName === 'body' || $parent->nodeName === 'html') break;
                    
                    $parentText = $parent->textContent;
                    if (strlen(trim($parentText)) > 80) {
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
            
            // Stratégie 2: Chercher par structure de liste/carte/tableau (plus permissif)
            $fallbackSelectors = [
                "//article",
                "//div[contains(@class, 'procurement')]",
                "//div[contains(@class, 'project')]",
                "//div[contains(@class, 'card')]",
                "//div[contains(@class, 'item')]",
                "//div[contains(@class, 'result')]",
                "//div[contains(@class, 'row')]",
                "//div[contains(@class, 'col')]",
                "//tr[contains(@class, 'procurement')]",
                "//tbody//tr",
                "//li[contains(@class, 'procurement')]",
                "//li[contains(@class, 'project')]",
                "//div[@data-project-id]",
                "//div[@data-procurement-id]",
            ];

            foreach ($fallbackSelectors as $selector) {
                try {
                    $fallbackNodes = $xpath->query($selector);
                    foreach ($fallbackNodes as $item) {
                        // Vérifier si cet élément contient un lien valide
                        $itemLinks = $xpath->query(".//a[@href]", $item);
                        if ($itemLinks->length > 0) {
                            foreach ($itemLinks as $itemLink) {
                                $itemHref = $itemLink->getAttribute('href');
                                
                                // Ignorer les liens de navigation
                                if (stripos($itemHref, '?') !== false && (stripos($itemHref, 'page=') !== false || stripos($itemHref, 'offset=') !== false)) {
                                    continue;
                                }
                                
                                // Si le lien semble valide
                                if (stripos($itemHref, '/procurement/') !== false || stripos($itemHref, '/project/') !== false ||
                                    stripos($itemHref, 'procurement') !== false || stripos($itemHref, 'project') !== false) {
                                    
                                    // Vérifier que ce n'est pas déjà dans $items
                                    $found = false;
                                    foreach ($items as $existing) {
                                        $existingLinks = $xpath->query(".//a[@href]", $existing);
                                        if ($existingLinks->length > 0 && $existingLinks->item(0)->getAttribute('href') === $itemHref) {
                                            $found = true;
                                            break;
                                        }
                                    }
                                    if (!$found) {
                                        $items[] = $item;
                                        break; // Un seul lien valide par item suffit
                                    }
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            Log::info('World Bank Scraper: Items found after all strategies', ['page' => $page, 'count' => count($items)]);

            // Si $items est un DOMNodeList, convertir en array
            if ($items instanceof \DOMNodeList) {
                $itemsArray = [];
                foreach ($items as $node) {
                    $itemsArray[] = $node;
                }
                $items = $itemsArray;
            }
            
            // Traiter chaque item
            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);
                    
                    if ($offre && !empty($offre['titre']) && !empty($offre['lien_source'])) {
                        // Normaliser le pays si présent
                        if (isset($offre['pays']) && is_string($offre['pays'])) {
                            $offre['pays'] = trim($offre['pays']);
                        }
                        
                        // Vérifier si l'offre existe déjà (par titre ou lien)
                        $existing = Offre::where('lien_source', $offre['lien_source'])
                            ->orWhere(function($q) use ($offre) {
                                $q->where('titre', $offre['titre'])
                                  ->where('source', 'World Bank');
                            })
                            ->first();
                        
                        // Double vérification: ignorer les offres avec des titres suspects
                        $titreLower = strtolower($offre['titre']);
                        $excludedPatterns = ['subscribe', 'email alert', 'sign up', 'newsletter', 'register', 'login'];
                        $isExcluded = false;
                        foreach ($excludedPatterns as $pattern) {
                            if (stripos($titreLower, $pattern) !== false) {
                                $isExcluded = true;
                                break;
                            }
                        }
                        
                        if (!$existing && !$isExcluded) {
                            Offre::create($offre);
                            $count++;
                        }
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

        } catch (\Exception $e) {
            Log::error('World Bank Scraper: Exception occurred while scraping page', [
                'page' => $page,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return ['count' => $count, 'html' => $html];
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
            // Extraire le titre
            $titre = null;
            $titreNodes = $xpath->query(".//h1 | .//h2 | .//h3 | .//h4 | .//h5", $item);
            if ($titreNodes->length > 0) {
                $titre = trim($titreNodes->item(0)->textContent);
            }
            
            // Si pas de titre dans h*, chercher dans les liens
            if (!$titre) {
                $linkNodes = $xpath->query(".//a[contains(@href, '/procurement/') or contains(@href, '/project/')]", $item);
                if ($linkNodes->length > 0) {
                    $titre = trim($linkNodes->item(0)->textContent);
                }
            }
            
            // Si toujours pas de titre, chercher tout lien avec du texte
            if (!$titre) {
                $linkNodes = $xpath->query(".//a[@href]", $item);
                foreach ($linkNodes as $link) {
                    $text = trim($link->textContent);
                    if (strlen($text) > 30) {
                        $titre = $text;
                        break;
                    }
                }
            }

            // Extraire le lien
            $lien = null;
            $linkNodes = $xpath->query(".//a[contains(@href, '/procurement/') or contains(@href, '/project/')]", $item);
            if ($linkNodes->length > 0) {
                $href = $linkNodes->item(0)->getAttribute('href');
                $lien = $this->normalizeUrl($href);
            } else {
                // Fallback: premier lien trouvé
                $linkNodes = $xpath->query(".//a[@href]", $item);
                if ($linkNodes->length > 0) {
                    $href = $linkNodes->item(0)->getAttribute('href');
                    if (stripos($href, 'procurement') !== false || stripos($href, 'project') !== false) {
                        $lien = $this->normalizeUrl($href);
                    }
                }
            }

            // Extraire le pays/zone géographique
            $pays = $this->extractCountry($item, $xpath);

            // Extraire la date limite
            $dateLimite = $this->extractDeadline($item, $xpath);

            // Acheteur est généralement World Bank
            $acheteur = "World Bank";

            if (!$titre || !$lien) {
                return null;
            }
            
            // Ignorer les titres qui sont clairement de la navigation ou des actions
            $titreLower = strtolower($titre);
            $navigationKeywords = [
                'view all', 'see more', 'page', 'next', 'previous', 'home', 'search',
                'subscribe', 'email alert', 'sign up', 'newsletter', 'register', 'login',
                'contact', 'about', 'help', 'support', 'faq', 'terms', 'privacy',
                'copyright', 'all rights reserved', 'follow us', 'share', 'print'
            ];
            foreach ($navigationKeywords as $keyword) {
                if (stripos($titreLower, $keyword) !== false) {
                    return null;
                }
            }
            
            // Ignorer les titres trop courts ou trop longs (probablement navigation)
            if (strlen(trim($titre)) < 40 || strlen(trim($titre)) > 500) {
                return null;
            }
            
            // Vérifier que le titre contient des mots-clés pertinents pour un appel d'offres
            $relevantKeywords = ['procurement', 'consultant', 'firm', 'service', 'goods', 'works', 
                                'rfp', 'rfq', 'tender', 'bid', 'call', 'request', 'project', 
                                'assignment', 'services', 'consulting', 'advisory'];
            $hasRelevantKeyword = false;
            foreach ($relevantKeywords as $keyword) {
                if (stripos($titreLower, $keyword) !== false) {
                    $hasRelevantKeyword = true;
                    break;
                }
            }
            
            // Si pas de mot-clé pertinent, ignorer
            if (!$hasRelevantKeyword) {
                return null;
            }

            return [
                'titre' => $titre,
                'acheteur' => $acheteur,
                'pays' => $pays,
                'date_limite_soumission' => $dateLimite,
                'lien_source' => $lien,
                'source' => 'World Bank',
            ];

        } catch (\Exception $e) {
            Log::warning('World Bank Scraper: Error extracting data from item', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Extrait TOUS les pays et zones géographiques depuis un élément
     */
    private function extractCountry(\DOMElement $item, DOMXPath $xpath): ?string
    {
        // Liste complète des pays (selon la Banque Mondiale)
        $countries = [
            // Afrique
            'Afghanistan', 'Albania', 'Algeria', 'Angola', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaijan',
            'Bangladesh', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi',
            'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Central African Republic', 'Chad', 'Chile', 'China', 'Colombia', 'Comoros', 'Congo', 'Congo, Democratic Republic', 'Costa Rica', 'Côte d\'Ivoire', 'Croatia', 'Cuba', 'Cyprus', 'Czech Republic',
            'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic',
            'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Eswatini', 'Ethiopia',
            'Fiji', 'Finland', 'France',
            'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece', 'Grenada', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana',
            'Haiti', 'Honduras', 'Hungary',
            'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy',
            'Jamaica', 'Japan', 'Jordan',
            'Kazakhstan', 'Kenya', 'Kiribati', 'Korea', 'Kosovo', 'Kuwait', 'Kyrgyz Republic',
            'Lao PDR', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Lithuania', 'Luxembourg',
            'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius', 'Mexico', 'Micronesia', 'Moldova', 'Mongolia', 'Montenegro', 'Morocco', 'Mozambique', 'Myanmar',
            'Namibia', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'North Macedonia', 'Norway',
            'Oman',
            'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal',
            'Qatar',
            'Romania', 'Russian Federation', 'Rwanda',
            'Samoa', 'São Tomé and Príncipe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovak Republic', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Sudan', 'Spain', 'Sri Lanka', 'St. Kitts and Nevis', 'St. Lucia', 'St. Vincent and the Grenadines', 'Sudan', 'Suriname', 'Sweden', 'Switzerland', 'Syrian Arab Republic',
            'Tajikistan', 'Tanzania', 'Thailand', 'Timor-Leste', 'Togo', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Tuvalu',
            'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan',
            'Vanuatu', 'Venezuela', 'Vietnam',
            'Yemen',
            'Zambia', 'Zimbabwe',
        ];

        // Zones géographiques
        $zones = [
            'Africa', 'Sub-Saharan Africa', 'North Africa', 'West Africa', 'East Africa', 'Southern Africa', 'Central Africa',
            'East Asia', 'East Asia and Pacific', 'Southeast Asia', 'South Asia', 'Central Asia',
            'Latin America', 'Latin America and Caribbean', 'Caribbean', 'Central America', 'South America',
            'Middle East', 'Middle East and North Africa', 'MENA',
            'Europe', 'Europe and Central Asia', 'Western Europe', 'Eastern Europe',
            'Pacific', 'Oceania',
            'Global', 'Worldwide', 'International',
        ];

        $text = $item->textContent;
        $foundItems = [];
        
        // Rechercher TOUS les pays mentionnés
        foreach ($countries as $country) {
            if (stripos($text, $country) !== false) {
                $foundItems[] = $country;
            }
        }
        
        // Rechercher TOUTES les zones géographiques mentionnées
        foreach ($zones as $zone) {
            if (stripos($text, $zone) !== false) {
                // Éviter les doublons si un pays a déjà été trouvé
                $isDuplicate = false;
                foreach ($foundItems as $found) {
                    if (stripos($found, $zone) !== false || stripos($zone, $found) !== false) {
                        $isDuplicate = true;
                        break;
                    }
                }
                if (!$isDuplicate) {
                    $foundItems[] = $zone;
                }
            }
        }
        
        if (!empty($foundItems)) {
            return implode(', ', array_unique($foundItems));
        }

        return null;
    }

    /**
     * Extrait la date limite de soumission
     */
    private function extractDeadline(\DOMElement $item, DOMXPath $xpath): ?string
    {
        $text = $item->textContent;
        
        // Patterns de date en anglais
        $patterns = [
            // Format: "January 15, 2025", "Jan 15, 2025"
            '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),\s+(\d{4})/i',
            '/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\.?\s+(\d{1,2}),\s+(\d{4})/i',
            // Format: "15/01/2025", "01-15-2025"
            '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
            '/(\d{1,2})-(\d{1,2})-(\d{4})/',
            // Format: "2025-01-15"
            '/(\d{4})-(\d{2})-(\d{2})/',
        ];

        $months = [
            'january' => 1, 'february' => 2, 'march' => 3, 'april' => 4, 'may' => 5, 'june' => 6,
            'july' => 7, 'august' => 8, 'september' => 9, 'october' => 10, 'november' => 11, 'december' => 12,
            'jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4, 'jun' => 6, 'jul' => 7, 'aug' => 8, 'sep' => 9, 'oct' => 10, 'nov' => 11, 'dec' => 12,
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                try {
                    // Si c'est une plage de dates, prendre la dernière (date limite)
                    if (strpos($text, '-') !== false || stripos($text, 'to') !== false || stripos($text, 'until') !== false) {
                        preg_match_all($pattern, $text, $allMatches);
                        if (isset($allMatches[0]) && count($allMatches[0]) > 1) {
                            $dateStr = end($allMatches[0]);
                        } else {
                            $dateStr = $matches[0];
                        }
                    } else {
                        $dateStr = $matches[0];
                    }

                    // Convertir en format date
                    if (preg_match('/(January|February|March|April|May|June|July|August|September|October|November|December|Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\.?\s+(\d{1,2}),\s+(\d{4})/i', $dateStr, $dateMatches)) {
                        $monthName = strtolower(trim($dateMatches[1], '.'));
                        $day = (int)$dateMatches[2];
                        $year = (int)$dateMatches[3];
                        if (isset($months[$monthName])) {
                            return sprintf('%04d-%02d-%02d', $year, $months[$monthName], $day);
                        }
                    } elseif (preg_match('/(\d{1,2})\/(\d{1,2})\/(\d{4})/', $dateStr, $dateMatches)) {
                        // Format MM/DD/YYYY ou DD/MM/YYYY (essayer les deux)
                        $date = \Carbon\Carbon::createFromFormat('m/d/Y', $dateStr);
                        if ($date) {
                            return $date->format('Y-m-d');
                        }
                    } elseif (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $dateStr, $dateMatches)) {
                        return $dateStr; // Déjà au bon format
                    }
                } catch (\Exception $e) {
                    continue;
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
            return 'https://projects.worldbank.org' . $url;
        }

        return 'https://projects.worldbank.org/' . $url;
    }
}

