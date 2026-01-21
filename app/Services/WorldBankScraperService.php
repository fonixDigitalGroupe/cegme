<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use DOMXPath;

class WorldBankScraperService implements IterativeScraperInterface
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
     * Cache local pour les détails de projets durant une session de scraping
     * @var array
     */
    private $projectCache = [];

    /**
     * ID du job en cours pour le suivi de progression
     * @var string|null
     */
    private $jobId = null;

    /**
     * État du scraper pour le mode itératif
     */
    private $currentStart = 0;      // Offset API actuel
    private $currentPage = 0;        // Page courante
    private $isExhausted = false;    // Plus d'offres disponibles
    private $pendingOffers = [];     // Buffer d'offres en attente de traitement

    // Filtres actifs pour l'API
    private $filterKeywords = [];
    private $filterCountries = [];

    /**
     * Définit l'ID du job pour le suivi de progression
     */
    public function setJobId(?string $jobId): void
    {
        $this->jobId = $jobId;
    }

    /**
     * Scrape les appels d'offres depuis l'API de la Banque Mondiale
     *
     * @return array ['count' => int, 'stats' => array] Nombre d'appels d'offres récupérés et statistiques
     */
    public function scrape(): array
    {
        // Note: Le vidage de la table est géré par la commande principale (app:scrape-active-sources)
        // Ici on scrappe uniquement les offres World Bank

        $totalCount = 0;
        $totalNoticesFound = 0;
        $totalExcluded = 0;
        $start = 0; // Offset de départ
        $rows = 100; // Nombre de résultats par page
        $pagesStats = []; // Statistiques par page
        $page = 0;

        try {
            $maxPages = max(1, min((int) env('WORLD_BANK_MAX_PAGES', 5), self::MAX_PAGES));
            while ($page < $maxPages && $start < 10000) { // Limite de sécurité (10,000 résultats max)
                Log::debug("World Bank Scraper: Fetching page {$page} (start={$start})");

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

                // Log seulement toutes les 10 pages pour réduire la charge
                if ($page % 10 === 0 || $count > 0) {
                    Log::info("World Bank Scraper: Page {$page} traitée", [
                        'offres_trouvees' => $count,
                        'notices_trouvees' => $noticesFound,
                        'exclues' => $excluded,
                        'total_accumule' => $totalCount,
                        'start' => $start,
                    ]);
                }




                $updates = $result['updates'] ?? [];
                // Appliquer les mises à jour (pays/date) sur les offres existantes
                if (!empty($updates)) {
                    foreach ($updates as $u) {
                        try {
                            Offre::where('id', $u['id'])->update([
                                'pays' => $u['pays'] ?? null,
                                'date_limite_soumission' => $u['date_limite_soumission'] ?? null,
                                'updated_at' => now(),
                            ]);
                        } catch (\Exception $e) {
                            Log::debug('World Bank Scraper: update skipped', ['id' => $u['id'], 'error' => $e->getMessage()]);
                        }
                    }
                }

                // Arrêter si aucune offre trouvée ou pas de suite
                if ($count === 0 || !$hasMore) {
                    Log::info("World Bank Scraper: Page {$page} a retourné 0 offres ou fin de pagination, arrêt.");
                    break;
                }

                $start += $rows;
                $page++;
                usleep(100000); // Réduit à 0.1 seconde entre les pages
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
     * Initialise le scraper pour le mode itératif
     */
    public function initialize(): void
    {
        $this->currentStart = 0;
        $this->currentPage = 0;
        $this->isExhausted = false;
        $this->pendingOffers = [];
        $this->projectCache = [];

        // Charger les règles de filtrage actives pour la Banque Mondiale
        try {
            $rule = \App\Models\FilteringRule::where('source', 'World Bank')
                ->where('is_active', true)
                ->with(['countries', 'activityPoles.keywords'])
                ->first();

            if ($rule) {
                // Collecter les pays
                $this->filterCountries = $rule->countries->pluck('country_name')->toArray();

                // Collecter les mots-clés des pôles d'activité
                foreach ($rule->activityPoles as $pole) {
                    $this->filterKeywords = array_merge($this->filterKeywords, $pole->keywords->pluck('keyword')->toArray());
                }

                // Ajouter le type de marché comme mot-clé si présent
                if ($rule->market_type === 'bureau_d_etude') {
                    $this->filterKeywords[] = "consulting";
                } elseif ($rule->market_type === 'consultant_individuel') {
                    $this->filterKeywords[] = "individual consultant";
                }

                $this->filterKeywords = array_unique(array_filter($this->filterKeywords));

                Log::info('World Bank Scraper initialized with API filters', [
                    'countries' => $this->filterCountries,
                    'keywords_count' => count($this->filterKeywords)
                ]);
            }
        } catch (\Exception $e) {
            Log::warning('World Bank Scraper: Could not load filtering rules', ['error' => $e->getMessage()]);
        }
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
        $count = 0; // Nouvelles offres (pour info)
        $processed = 0; // Total traitées (nouvelles + existantes)
        $rows = 100;

        // On traite le buffer pendingOffers (qui contient maintenant des documents bruts)
        while (count($this->pendingOffers) > 0 && $processed < $limit) {
            $doc = array_shift($this->pendingOffers);
            $processed++;

            try {
                $offerData = $this->extractOffreFromApiDocument($doc);

                if ($offerData && !empty($offerData['titre']) && !empty($offerData['lien_source'])) {
                    $existing = Offre::where('source', 'World Bank')
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
                        Log::info("World Bank Scraper: Updated existing offer", ['id' => $existing->id, 'titre' => $existing->titre]);
                    } else {
                        $offerData['created_at'] = now();
                        $offerData['updated_at'] = now();
                        Offre::create($offerData);
                        $count++;
                        Log::info("World Bank Scraper: Created NEW offer", ['titre' => $offerData['titre']]);
                    }
                    $findings[] = $offerData;
                } else {
                    Log::warning("World Bank Scraper: extractOffreFromApiDocument returned null or invalid data", ['doc_id' => $doc['id'] ?? 'N/A']);
                }
            } catch (\Exception $e) {
                Log::error('World Bank Scraper: Error processing/saving document', [
                    'doc_id' => $doc['id'] ?? 'N/A',
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Si on n'a pas atteint la limite et qu'on n'est pas épuisé
        while ($processed < $limit && !$this->isExhausted) {
            $result = $this->fetchApiPageForBatch($this->currentStart, $rows);

            if ($result['count'] === 0 && !$result['has_more']) {
                $this->isExhausted = true;
                break;
            }

            $this->pendingOffers = array_merge($this->pendingOffers, $result['documents']);
            $this->currentStart += $rows;
            $this->isExhausted = !$result['has_more'];

            while (count($this->pendingOffers) > 0 && $processed < $limit) {
                $doc = array_shift($this->pendingOffers);
                $processed++;

                try {
                    $offerData = $this->extractOffreFromApiDocument($doc);

                    if ($offerData && !empty($offerData['titre']) && !empty($offerData['lien_source'])) {
                        $existing = Offre::where('source', 'World Bank')
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
                    }
                } catch (\Exception $e) {
                    Log::error('World Bank Scraper: Error processing/saving document', [
                        'doc_id' => $doc['id'] ?? 'N/A',
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $hasMore = !$this->isExhausted || count($this->pendingOffers) > 0;

        Log::info("World Bank Scraper: Batch finished", [
            'processed' => $processed,
            'new_count' => $count,
            'findings_count' => count($findings),
            'has_more' => $hasMore
        ]);

        return [
            'count' => $processed,
            'new_count' => $count,
            'has_more' => $hasMore,
            'findings' => $findings,
        ];
    }

    /**
     * Récupère une page de l'API et retourne les offres (pour mode batch)
     */
    private function fetchApiPageForBatch(int $start, int $rows): array
    {
        $filteredDocuments = [];
        $hasMore = false;

        try {
            $params = [
                'format' => 'json',
                'fl' => 'id,submission_deadline_date,project_ctry_name,project_id,project_name,notice_type,procurement_type,notice_url',
                'srt' => 'submission_deadline_date',
                'order' => 'desc',
                'apilang' => 'en',
                'srce' => 'both',
                'os' => $start,
                'rows' => $rows,
            ];

            // Appliquer les filtres de mots-clés via qterm si disponibles
            if (!empty($this->filterKeywords)) {
                // On prend les 3 premiers mots-clés pour ne pas faire une URL trop longue
                $qterm = implode(' OR ', array_slice($this->filterKeywords, 0, 5));
                $params['qterm'] = $qterm;
            }

            // Note: Le filtrage par pays via l'API WB est complexe car il utilise des codes.
            // On s'appuiera sur shouldKeepNotice pour le filtrage fin des pays reçu.

            $url = self::API_BASE_URL . '?' . http_build_query($params);
            $response = Http::timeout(60)->retry(2, 1000)->get($url);

            if (!$response->successful()) {
                Log::warning('World Bank Scraper: API request failed', [
                    'status' => $response->status(),
                    'start' => $start,
                ]);
                return ['count' => 0, 'has_more' => false, 'documents' => []];
            }

            $data = $response->json();

            if (!isset($data['procnotices']) || !is_array($data['procnotices'])) {
                return ['count' => 0, 'has_more' => false, 'documents' => []];
            }

            $documents = $data['procnotices'];
            $totalFound = (int) ($data['total'] ?? 0);
            $hasMore = ($start + count($documents)) < $totalFound;

            Log::info('World Bank Scraper: API Data', [
                'total_in_api' => $totalFound,
                'received_count' => count($documents),
                'start' => $start,
                'has_more' => $hasMore
            ]);

            // Filtrer sommairement les documents
            foreach ($documents as $doc) {
                try {
                    $filterResult = $this->shouldKeepNotice($doc);
                    if ($filterResult['keep']) {
                        $filteredDocuments[] = $doc;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

        } catch (\Exception $e) {
            Log::error('World Bank Scraper: Exception in fetchApiPageForBatch', [
                'start' => $start,
                'error' => $e->getMessage(),
            ]);
        }

        return [
            'count' => count($filteredDocuments),
            'has_more' => $hasMore,
            'documents' => $filteredDocuments,
        ];
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
        $inserted = 0;

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

            Log::debug("World Bank Scraper: Fetching API", ['url' => $url]);

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
            $totalFound = (int) ($data['total'] ?? 0);
            $hasMore = ($start + count($documents)) < $totalFound;

            $totalNotices = count($documents);
            $excludedCount = 0;
            $exclusionReasons = [];
            $keptCount = 0;
            $passedFilterCount = 0;
            $inserted = 0;
            $updates = [];
            $findingsBuffer = [];
            $progressService = $this->jobId ? app(\App\Services\ScrapingProgressService::class) : null;

            // Traiter chaque document et collecter les offres valides
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
                        continue;
                    }

                    $passedFilterCount++;

                    $offreData = $this->extractOffreFromApiDocument($doc);

                    if ($offreData && !empty($offreData['titre']) && !empty($offreData['lien_source'])) {
                        $keptCount++;

                        // Ajouter au buffer pour le feedback UI
                        $findingsBuffer[] = $offreData;
                        if (count($findingsBuffer) >= 10) {
                            if ($progressService && $this->jobId) {
                                $progressService->addFindings($this->jobId, $findingsBuffer);
                            }
                            $findingsBuffer = [];
                        }

                        // Sauvegarder ou mettre à jour immédiatement pour un feedback en temps réel
                        try {
                            $existing = Offre::where('source', 'World Bank')
                                ->where(function ($q) use ($offreData) {
                                    $q->where('lien_source', $offreData['lien_source'])
                                        ->orWhere('titre', $offreData['titre']);
                                })
                                ->first();

                            if ($existing) {
                                $existing->update([
                                    'pays' => $offreData['pays'] ?? $existing->pays,
                                    'date_limite_soumission' => $offreData['date_limite_soumission'] ?? $existing->date_limite_soumission,
                                    'updated_at' => now(),
                                ]);
                            } else {
                                $offreData['created_at'] = now();
                                $offreData['updated_at'] = now();
                                Offre::create($offreData);
                                $inserted++;
                            }
                        } catch (\Exception $dbEx) {
                            Log::error('World Bank Scraper: Database error for notice ' . ($doc['id'] ?? 'unknown'), [
                                'error' => $dbEx->getMessage(),
                                'doc' => $doc['id'] ?? null
                            ]);
                        }
                    } else {
                        // Log pour debug si l'offre n'est pas valide
                        Log::info('World Bank Scraper: Offre invalide', [
                            'has_offre' => !is_null($offreData),
                            'has_titre' => !empty($offreData['titre'] ?? null),
                            'has_lien' => !empty($offreData['lien_source'] ?? null),
                            'project_name' => $doc['project_name'] ?? 'N/A',
                            'project_id' => $doc['project_id'] ?? 'N/A',
                            'notice_type' => $doc['notice_type'] ?? 'N/A',
                            'titre_length' => strlen(trim($doc['project_name'] ?? $doc['notice_type'] ?? '')),
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::debug('World Bank Scraper: Error processing document', [
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }
            }


            // Log seulement si des offres ont été trouvées ou si c'est la première page
            if ($inserted > 0 || ($start / $rows) === 0) {
                Log::info("World Bank Scraper: Filtering results for page", [
                    'page' => $start / $rows,
                    'total_notices' => $totalNotices,
                    'passed_filter' => $passedFilterCount,
                    'kept_and_saved' => $inserted,
                    'kept_total' => $keptCount,
                    'excluded' => $excludedCount,
                    'exclusion_reasons' => $exclusionReasons,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('World Bank Scraper: Exception occurred while fetching API page', [
                'start' => $start,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Envoyer le reste du buffer
        if (!empty($findingsBuffer) && $progressService && $this->jobId) {
            $progressService->addFindings($this->jobId, $findingsBuffer);
        }

        return [
            'count' => $inserted,
            'has_more' => $hasMore ?? false,
            'notices_found' => $totalNotices ?? 0,
            'excluded' => $excludedCount ?? 0,
            'updates' => $updates ?? [],
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
                Log::debug("World Bank Scraper: Excluding notice", ['reason' => "Expression of Interest without consultant keywords", 'project' => $projectName]);
                return [
                    'keep' => false,
                    'reason' => "Excluded: Expression of Interest without consultant selection",
                ];
            }
        }

        // Si aucun pattern ne correspond, on garde au cas où (plus permissif)
        return [
            'keep' => true,
            'reason' => "Fallback: Keep by default",
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

            if (!$titre || strlen(trim($titre)) < 10) {
                return null;
            }

            // STRATÉGIE DE LIEN WORLD BANK
            // Priorité affichage et extraction date: notice_url (page détail de l'offre)
            // Sinon, fallback: page projet ou page de recherche (affichage uniquement)

            $projectId = $doc['project_id'] ?? null;
            $noticeUrl = $doc['notice_url'] ?? null;
            $lien = null;
            $linkType = null;

            if (empty($noticeUrl)) {
                // Résoudre notice_url via la page de recherche Procurement
                try {
                    $apiCountry = null;
                    if (isset($doc['project_ctry_name']) && is_string($doc['project_ctry_name'])) {
                        $apiCountry = $doc['project_ctry_name'];
                    } elseif (isset($doc['project_ctry_name']) && is_array($doc['project_ctry_name']) && !empty($doc['project_ctry_name'][0])) {
                        $apiCountry = $doc['project_ctry_name'][0];
                    }
                    $resolved = $this->resolveNoticeUrlFromSearch($titre, $apiCountry, $doc['notice_type'] ?? null, $doc['id'] ?? null);
                    if (!empty($resolved)) {
                        $noticeUrl = $resolved;
                    }
                } catch (\Exception $e) {
                    Log::debug('World Bank Scraper: resolveNoticeUrlFromSearch failed', ['error' => $e->getMessage(), 'project_name' => $titre]);
                }
            }

            if (!empty($noticeUrl)) {
                // Priorité: lien détail de l'offre
                $lien = $noticeUrl;
                $linkType = 'notice_detail';
            } elseif ($projectId) {
                // Fallback: page projet (affichage seulement)
                $lien = 'https://projects.worldbank.org/en/projects-operations/project-detail/' . $projectId;
                $linkType = 'project_detail';
            } else {
                // Fallback final: page de recherche contextuelle
                $baseUrl = 'https://projects.worldbank.org/en/projects-operations/procurement';
                $params = [];
                $params['searchTerm'] = $titre;
                if (isset($doc['project_ctry_name']) && !empty($doc['project_ctry_name'])) {
                    $countries = is_array($doc['project_ctry_name']) ? $doc['project_ctry_name'] : [$doc['project_ctry_name']];
                    if (!empty($countries[0])) {
                        $params['country'] = $countries[0];
                    }
                }
                if (isset($doc['notice_type']) && !empty($doc['notice_type'])) {
                    $nt = strtolower(trim($doc['notice_type']));
                    if (str_contains($nt, 'invitation for bid') || str_contains($nt, 'invitation to bid')) {
                        $params['noticeType'] = 'Invitation for Bids';
                    } elseif (str_contains($nt, 'request for proposal')) {
                        $params['noticeType'] = 'Request for Proposals';
                    } elseif (str_contains($nt, 'request for expression')) {
                        $params['noticeType'] = 'Request for Expression of Interest';
                    } elseif (str_contains($nt, 'prequalification')) {
                        $params['noticeType'] = 'Invitation for Prequalification';
                    }
                }
                $lien = $baseUrl . '?' . http_build_query($params);
                $linkType = 'search_context';
            }

            if (!$lien) {
                return null;
            }

            // Récupération de la date limite - PRIORITÉ À LA "CLOSING DATE" DE LA PAGE DU PROJET
            // La "Closing Date" sur la page project-detail est la vraie date limite de soumission
            // Structure trouvée: <label>Closing Date</label><p class="document-info">December 31, 2027</p>
            // Cette date est plus fiable que celle de l'API car elle correspond à la date affichée sur le site
            $submissionDate = null;
            $submissionRaw = null;
            $apiDate = null;
            $projectClosingDate = null;

            // 1. PRIORITÉ: Récupérer la "Closing Date" depuis la page de détail du projet
            // C'est cette date qui est considérée comme la date limite par l'utilisateur
            // DÉSACTIVÉ par défaut pour la performance du scraping séquentiel
            $fetchClosingDate = env('WORLD_BANK_FETCH_CLOSING_DATE', false);

            if ($fetchClosingDate && !empty($projectId)) {
                try {
                    $projectDetail = $this->fetchProjectDetailFields($projectId);
                    if (!empty($projectDetail['closing_date'])) {
                        $projectClosingDate = $projectDetail['closing_date'];
                        $submissionDate = $projectClosingDate;
                        $submissionRaw = $projectDetail['closing_raw'] ?? $projectClosingDate;
                        Log::info('World Bank Scraper: ✅ Date récupérée depuis la page de détail du projet (Closing Date) - PRIORITÉ', [
                            'source' => 'Page Project Detail (Closing Date)',
                            'project_id' => $projectId,
                            'raw_value' => $submissionRaw,
                            'normalized' => $submissionDate,
                            'titre' => $titre,
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::debug('World Bank Scraper: Project detail page parse failed', [
                        'project_id' => $projectId,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            // 2. FALLBACK 1: Utiliser la date de soumission fournie par l'API
            if (empty($submissionDate) && isset($doc['submission_deadline_date']) && !empty($doc['submission_deadline_date'])) {
                try {
                    $apiDateValue = $doc['submission_deadline_date'];
                    // L'API peut retourner la date dans différents formats
                    if (is_numeric($apiDateValue)) {
                        // Timestamp Unix (en millisecondes ou secondes)
                        if ($apiDateValue > 1000000000000) {
                            // Millisecondes
                            $apiDate = date('Y-m-d', $apiDateValue / 1000);
                        } else {
                            // Secondes
                            $apiDate = date('Y-m-d', $apiDateValue);
                        }
                        $submissionRaw = (string) $apiDateValue;
                    } elseif (is_string($apiDateValue)) {
                        // Essayer de parser la date
                        $parsed = $this->normalizeDateString($apiDateValue);
                        if ($parsed) {
                            $apiDate = $parsed;
                            $submissionRaw = $apiDateValue;
                        } else {
                            // Essayer avec Carbon comme fallback
                            try {
                                $carbonDate = \Carbon\Carbon::parse($apiDateValue);
                                $apiDate = $carbonDate->format('Y-m-d');
                                $submissionRaw = $apiDateValue;
                            } catch (\Exception $e) {
                                Log::debug('World Bank Scraper: Failed to parse API date string', [
                                    'date' => $apiDateValue,
                                    'error' => $e->getMessage(),
                                ]);
                            }
                        }
                    }

                    if ($apiDate) {
                        $submissionDate = $apiDate;
                        Log::info('World Bank Scraper: ✅ Date récupérée depuis l\'API (FALLBACK)', [
                            'source' => 'API (submission_deadline_date)',
                            'raw_value' => $submissionRaw,
                            'normalized' => $submissionDate,
                            'project_id' => $doc['project_id'] ?? null,
                            'notice_url' => $noticeUrl,
                            'titre' => $titre,
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::debug('World Bank Scraper: Failed to parse API date', [
                        'date' => $doc['submission_deadline_date'] ?? null,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            // 3. FALLBACK 2: Essayer depuis la page de la notice spécifique
            if (empty($submissionDate) && !empty($noticeUrl)) {
                try {
                    [$noticeDate, $noticeRaw] = $this->fetchSubmissionDeadlineFromNotice($noticeUrl);
                    if ($noticeDate) {
                        $submissionDate = $noticeDate;
                        $submissionRaw = $noticeRaw;
                        Log::info('World Bank Scraper: ✅ Date récupérée depuis la page notice (DERNIER FALLBACK)', [
                            'source' => 'Page Notice HTML',
                            'notice_url' => $noticeUrl,
                            'raw_value' => $noticeRaw,
                            'normalized' => $noticeDate,
                            'titre' => $titre,
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::debug('World Bank Scraper: Notice page parse failed', ['notice_url' => $noticeUrl, 'error' => $e->getMessage()]);
                }
            }

            if (empty($projectId)) {
                Log::info('[WB] project_id MISSING; Closing Date cannot be fetched from Project Detail', [
                    'titre' => $titre,
                    'notice_url' => $doc['notice_url'] ?? null,
                ]);
            }

            // Date limite: depuis l'API, la page Notice, ou la page Project Detail (Closing Date)
            $dateLimite = !empty($submissionDate) ? $submissionDate : null;

            // Pays depuis API
            $apiPays = null;
            if (isset($doc['project_ctry_name']) && is_array($doc['project_ctry_name'])) {
                $apiPays = implode(', ', array_filter($doc['project_ctry_name']));
            } elseif (isset($doc['project_ctry_name']) && is_string($doc['project_ctry_name'])) {
                $apiPays = $doc['project_ctry_name'];
            }

            // Pays: prendre depuis l'API (liste côté notices)
            $pays = $apiPays ?: null;

            // Acheteur
            $acheteur = "World Bank";

            $noticeType = $doc['notice_type'] ?? null;

            // Logs qualité + TRAÇABILITÉ (Submission Deadline) - RÉSUMÉ FINAL
            $sourceType = 'NON TROUVÉE';
            if ($submissionDate) {
                if ($apiDate && $submissionDate === $apiDate) {
                    $sourceType = 'API (submission_deadline_date)';
                } elseif ($projectClosingDate && $submissionDate === $projectClosingDate) {
                    $sourceType = 'Page Project Detail (Closing Date) - FALLBACK';
                } else {
                    $sourceType = 'Page HTML (notice) - DERNIER FALLBACK';
                }
            }

            Log::info('[WB] RÉSUMÉ | Date limite de soumission', [
                'titre' => $titre,
                'notice_url' => $noticeUrl,
                'project_id' => $projectId,
                'source_de_la_date' => $sourceType,
                'api_date' => $apiDate ?? 'N/A',
                'project_closing_date' => $projectClosingDate ?? 'N/A',
                'texte_brut_trouve' => $submissionRaw ?? 'N/A',
                'date_normalisee' => $dateLimite ?? 'NULL',
                'statut' => $dateLimite ? '✅ RÉCUPÉRÉE' : '❌ NON TROUVÉE',
            ]);

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
     * Résout un lien de notice détaillée à partir de la page de recherche Procurement
     * en utilisant le titre (project_name), un pays optionnel, le type de notice et un identifiant OP (si disponible).
     */
    private function resolveNoticeUrlFromSearch(string $title, ?string $country, ?string $noticeType, ?string $opId): ?string
    {
        $baseUrl = 'https://projects.worldbank.org/en/projects-operations/procurement';
        $params = ['searchTerm' => $title];
        if (!empty($country)) {
            $params['country'] = $country;
        }
        if (!empty($noticeType)) {
            $nt = strtolower(trim($noticeType));
            if (str_contains($nt, 'invitation for bid') || str_contains($nt, 'invitation to bid')) {
                $params['noticeType'] = 'Invitation for Bids';
            } elseif (str_contains($nt, 'request for proposal')) {
                $params['noticeType'] = 'Request for Proposals';
            } elseif (str_contains($nt, 'request for expression')) {
                $params['noticeType'] = 'Request for Expression of Interest';
            } elseif (str_contains($nt, 'prequalification')) {
                $params['noticeType'] = 'Invitation for Prequalification';
            }
        }

        $url = $baseUrl . '?' . http_build_query($params);
        try {
            $resp = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9,fr;q=0.8',
                ])->get($url);
            if (!$resp->successful()) {
                Log::debug('WB search page fetch failed', ['status' => $resp->status(), 'url' => $url]);
                return null;
            }
            $html = $resp->body();
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xp = new \DOMXPath($dom);
            $nodes = $xp->query("//a[contains(@href,'/procurement/notice') or contains(@href,'/procurement/notice/')]");
            $candidates = [];
            if ($nodes) {
                foreach ($nodes as $a) {
                    $href = $a->getAttribute('href');
                    if (!$href)
                        continue;
                    if (strpos($href, 'http') !== 0) {
                        if ($href[0] === '/') {
                            $href = 'https://projects.worldbank.org' . $href;
                        } else {
                            $href = 'https://projects.worldbank.org/' . ltrim($href, '/');
                        }
                    }
                    $candidates[] = $href;
                }
            }
            if (empty($candidates)) {
                if (preg_match_all('#href\s*=\s*"(\/procurement\/notice[^"]+)"#i', $html, $m)) {
                    foreach ($m[1] as $h) {
                        $candidates[] = 'https://projects.worldbank.org' . $h;
                    }
                }
            }
            if (empty($candidates))
                return null;
            if (!empty($opId)) {
                foreach ($candidates as $c) {
                    if (stripos($c, $opId) !== false)
                        return $c;
                }
            }
            return $candidates[0];
        } catch (\Exception $e) {
            Log::debug('WB resolveNoticeUrlFromSearch exception', ['error' => $e->getMessage(), 'search_url' => $url]);
            return null;
        }
    }

    /**
     * Récupère la Date de clôture (Closing Date) depuis la page détail du projet
     */
    private function fetchClosingDateFromProject(string $projectId): ?string
    {
        $url = 'https://projects.worldbank.org/en/projects-operations/project-detail/' . $projectId;
        $response = Http::withoutVerifying()
            ->timeout(30)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'fr-FR,fr;q=0.9,en;q=0.8',
            ])
            ->get($url);

        if (!$response->successful()) {
            return null;
        }

        $html = $response->body();
        if (config('app.debug')) {
            try {
                \Storage::disk('local')->put("debug/worldbank_project_detail_{$projectId}.html", $html);
            } catch (\Exception $e) {
                // ignore
            }
        }
        if (config('app.debug')) {
            try {
                \Storage::disk('local')->put("debug/worldbank_project_{$projectId}.html", $html);
            } catch (\Exception $e) {
                // ignore
            }
        }
        // Chercher "Closing Date" ou "Date de clôture" puis une date
        // Extraire un voisinage de texte après l'étiquette
        $pattern = '/(Closing\s*Date|Date\s*de\s*clôture)[^\n\r\<\>]{0,160}?('
            . '\d{1,2}\s+[A-Za-zÀ-ÖØ-öø-ÿ]+\s+\d{4}' // 31 décembre 2028
            . '|[A-Za-zÀ-ÖØ-öø-ÿ]+\s+\d{1,2},\s*\d{4}' // December 31, 2028
            . '|\d{1,2}-[A-Za-z]{3}-\d{4}' // 31-Dec-2028
            . '|\d{1,2}\/\d{1,2}\/\d{4}' // 12/31/2028
            . '|\d{4}-\d{2}-\d{2}' // 2028-12-31
            . ')/iu';
        if (preg_match($pattern, $html, $m)) {
            $rawDate = trim($m[2]);
            $normalized = $this->normalizeDateString($rawDate);
            return $normalized;
        }

        return null;
    }

    /**
     * Récupère Country, Region, Closing Date depuis la page détail du projet
     */
    private function fetchProjectDetailFields(string $projectId): array
    {
        // 1. Vérifier le cache local pour cette session
        if (isset($this->projectCache[$projectId])) {
            Log::debug('World Bank Scraper: Using cached project detail', ['project_id' => $projectId]);
            return $this->projectCache[$projectId];
        }

        $url = 'https://projects.worldbank.org/en/projects-operations/project-detail/' . $projectId;
        $html = '';

        // IMPORTANT: La page World Bank utilise Angular qui charge le contenu dynamiquement
        // Utiliser Browsershot (navigateur headless) pour exécuter JavaScript et récupérer le contenu rendu
        try {
            Log::debug('World Bank Scraper: Using Browsershot to fetch project detail page', [
                'project_id' => $projectId,
                'url' => $url,
            ]);

            $html = \Spatie\Browsershot\Browsershot::url($url)
                ->waitUntilNetworkIdle()
                ->delay(500) // Réduit de 1000ms à 500ms
                ->timeout(60) // Augmenté à 60s pour être sûr de finir
                ->setOption('args', [
                    '--no-sandbox',
                    '--disable-setuid-sandbox',
                    '--disable-dev-shm-usage',
                    '--disable-blink-features=AutomationControlled',
                    '--disable-features=IsolateOrigins,site-per-process',
                    '--disable-gpu',
                    '--disable-software-rasterizer',
                ])
                ->setOption('block', [
                    'image',
                    'media',
                    'font',
                    'stylesheet', // Bloquer le CSS accélère énormément car le texte reste présent dans le DOM
                ])
                ->dismissDialogs()
                ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                ->bodyHtml();

            if (empty($html)) {
                Log::warning('World Bank Scraper: Browsershot returned empty HTML, trying HTTP fallback', [
                    'project_id' => $projectId,
                    'url' => $url,
                ]);
                throw new \Exception('Empty HTML from Browsershot');
            }

            Log::debug('World Bank Scraper: Successfully fetched project detail page with Browsershot', [
                'project_id' => $projectId,
                'html_length' => strlen($html),
            ]);

        } catch (\Exception $e) {
            Log::debug('World Bank Scraper: Browsershot failed, using HTTP fallback', [
                'project_id' => $projectId,
                'url' => $url,
                'error' => $e->getMessage(),
            ]);

            // Fallback vers HTTP simple si Browsershot échoue
            try {
                $response = Http::withoutVerifying()
                    ->timeout(30)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                        'Accept-Language' => 'en-US,en;q=0.9,fr;q=0.8',
                    ])
                    ->get($url);

                if (!$response->successful()) {
                    return [];
                }

                $html = $response->body();
            } catch (\Exception $httpError) {
                Log::error('World Bank Scraper: HTTP fallback also failed', [
                    'project_id' => $projectId,
                    'url' => $url,
                    'error' => $httpError->getMessage(),
                ]);
                return [];
            }
        }

        // Sauvegarder le HTML pour debug si nécessaire
        if (config('app.debug')) {
            try {
                \Storage::disk('local')->put('debug/wb_project_detail_' . $projectId . '.html', $html);
                Log::debug('World Bank Scraper: Project detail HTML saved', [
                    'project_id' => $projectId,
                    'file' => 'debug/wb_project_detail_' . $projectId . '.html',
                ]);
            } catch (\Exception $e) {
                // Ignorer
            }
        }

        // IMPORTANT: La page World Bank utilise Angular qui charge le contenu dynamiquement
        // Le HTML brut ne contient pas le contenu rendu. Il faut chercher dans le JSON embarqué
        // ou utiliser une approche regex pour extraire les données depuis le HTML brut

        // Stratégie 1: Chercher "Closing Date" dans le HTML brut avec regex (pour les données pré-rendues)
        $closingRaw = null;
        if (preg_match('/Closing\s+Date[^<]*<[^>]*>([^<]+(?:December|January|February|March|April|May|June|July|August|September|October|November)\s+\d{1,2},?\s+\d{4})/i', $html, $matches)) {
            $closingRaw = trim($matches[1]);
        } elseif (preg_match('/"Closing\s+Date"[^"]*"([^"]*(?:December|January|February|March|April|May|June|July|August|September|October|November)\s+\d{1,2},?\s+\d{4})/i', $html, $matches)) {
            $closingRaw = trim($matches[1]);
        } elseif (preg_match('/(?:Closing\s+Date|closingDate)[^:]*:\s*["\']?([^"\']*(?:December|January|February|March|April|May|June|July|August|September|October|November)\s+\d{1,2},?\s+\d{4})/i', $html, $matches)) {
            $closingRaw = trim($matches[1]);
        }

        // Parser DOM pour trouver des libellés (fallback si regex ne trouve rien)
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $findByLabels = function (array $labels) use ($xpath): ?string {
            foreach ($labels as $label) {
                // Exact label in table (th->td)
                $q = "//th[normalize-space()='{$label}' or starts-with(normalize-space(), '{$label}:')]/following-sibling::td[1]";
                $nodes = $xpath->query($q);
                if ($nodes && $nodes->length > 0) {
                    $val = trim(preg_replace('/\s+/', ' ', $nodes->item(0)->textContent));
                    if ($val !== '')
                        return $val;
                }
                // Exact label in definition list (dt->dd)
                $q = "//dt[normalize-space()='{$label}' or starts-with(normalize-space(), '{$label}:')]/following-sibling::dd[1]";
                $nodes = $xpath->query($q);
                if ($nodes && $nodes->length > 0) {
                    $val = trim(preg_replace('/\s+/', ' ', $nodes->item(0)->textContent));
                    if ($val !== '')
                        return $val;
                }
                // Label inside span/div then sibling
                $q = "//*[self::span or self::div][normalize-space()='{$label}' or starts-with(normalize-space(), '{$label}:')]/following-sibling::*[1]";
                $nodes = $xpath->query($q);
                if ($nodes && $nodes->length > 0) {
                    $val = trim(preg_replace('/\s+/', ' ', $nodes->item(0)->textContent));
                    if ($val !== '')
                        return $val;
                }
                // Partial/contains match (case-insensitive using translate)
                $lower = mb_strtolower($label, 'UTF-8');
                $q = "//*[self::th or self::dt or self::span or self::div][contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZÀÂÄÇÉÈÊËÎÏÔŒÙÛÜŸ', 'abcdefghijklmnopqrstuvwxyzàâäçéèêëîïôœùûüÿ'), '{$lower}')]/following-sibling::*[1]";
                $nodes = $xpath->query($q);
                if ($nodes && $nodes->length > 0) {
                    $val = trim(preg_replace('/\s+/', ' ', $nodes->item(0)->textContent));
                    if ($val !== '')
                        return $val;
                }
                // Robust fallback: find the label node, then take nearest following non-empty text within a short distance
                $labelNodes = $xpath->query("//*[self::th or self::dt or self::span or self::div][contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZÀÂÄÇÉÈÊËÎÏÔŒÙÛÜŸ', 'abcdefghijklmnopqrstuvwxyzàâäçéèêëîïôœùûüÿ'), '{$lower}')]");
                if ($labelNodes && $labelNodes->length > 0) {
                    $node = $labelNodes->item(0);
                    // Try immediate following siblings and their descendants
                    $candidates = [
                        'following-sibling::*[1]',
                        'following-sibling::*[1]//*[not(self::script or self::style)][1]',
                        'following::*[self::div or self::span or self::td or self::dd][1]',
                        'following::*[self::div or self::span][2]'
                    ];
                    foreach ($candidates as $rel) {
                        $ns = $xpath->query($rel, $node);
                        if ($ns && $ns->length > 0) {
                            $text = trim(preg_replace('/\s+/', ' ', $ns->item(0)->textContent));
                            // reject if looks like another label (ends with ':')
                            if ($text !== '' && !preg_match('/:$/', $text)) {
                                return $text;
                            }
                        }
                    }
                }
            }
            return null;
        };

        $countryLabels = ['Country', 'Pays'];
        $regionLabels = ['Region', 'Région'];
        $closingLabels = [
            'Closing Date',
            'Expected Closing Date',
            'Original Closing Date',
            'Revised Closing Date',
            'Closing Date (Original)',
            'Closing Date (Revised)',
            'Date de clôture',
            'Date de clôture (prévue)',
            'Date de clôture (initiale)',
            'Date de clôture (révisée)'
        ];

        $country = null;
        $region = null;
        // $closingRaw est déjà initialisé par les regex ci-dessus, on le garde tel quel

        // 1) PRIORITÉ: Chercher la "Closing Date" dans la structure spécifique World Bank
        // Structure trouvée: <label>Closing Date</label><p class="document-info">December 31, 2027</p>
        // Cette structure se trouve dans la section "Key Details" > "Project Details"

        // Méthode 1: Chercher directement le pattern label + p avec class="document-info"
        foreach ($closingLabels as $lbl) {
            // Chercher <label>Closing Date</label> suivi de <p class="document-info">
            $query = "//label[normalize-space()='{$lbl}' or contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($lbl) . "')]/following-sibling::p[@class='document-info' or contains(@class, 'document-info')][1]";
            $nodes = $xpath->query($query);
            if ($nodes && $nodes->length > 0) {
                $closingRaw = trim($nodes->item(0)->textContent);
                if (!empty($closingRaw)) {
                    break;
                }
            }

            // Chercher aussi dans un <li> contenant <label>Closing Date</label> puis <p>
            $query = "//li[.//label[normalize-space()='{$lbl}' or contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($lbl) . "')]]//p[@class='document-info' or contains(@class, 'document-info')][1]";
            $nodes = $xpath->query($query);
            if ($nodes && $nodes->length > 0) {
                $closingRaw = trim($nodes->item(0)->textContent);
                if (!empty($closingRaw)) {
                    break;
                }
            }
        }

        // 2) Si pas trouvé, chercher dans la section "Key Details" > "Project Details"
        if ($closingRaw === null) {
            $sectionNodes = $xpath->query(
                "//section[.//h2[contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'key details')]
                | //*[contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'key details')]"
            );

            if ($sectionNodes && $sectionNodes->length > 0) {
                foreach ($sectionNodes as $section) {
                    $sx = new \DOMXPath($dom);

                    // Chercher dans "Project Details" à l'intérieur de "Key Details"
                    $projectDetailsNodes = $sx->query(".//h3[contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'project details')]/following-sibling::*[1]", $section);
                    if ($projectDetailsNodes && $projectDetailsNodes->length > 0) {
                        $projectDetails = $projectDetailsNodes->item(0);

                        // Chercher la Closing Date dans cette section
                        foreach ($closingLabels as $lbl) {
                            // Chercher <label>Closing Date</label> suivi de <p>
                            $n = $sx->query(".//label[normalize-space()='{$lbl}' or contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($lbl) . "')]/following-sibling::p[1]", $projectDetails);
                            if ($n && $n->length > 0) {
                                $closingRaw = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                                if (!empty($closingRaw))
                                    break 2;
                            }

                            // Chercher dans les tableaux (th/td)
                            $n = $sx->query(".//th[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:') or contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($lbl) . "')]/following-sibling::td[1]", $projectDetails);
                            if ($n && $n->length > 0) {
                                $closingRaw = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                                if (!empty($closingRaw))
                                    break 2;
                            }

                            // Chercher dans les listes de définition (dt/dd)
                            $n = $sx->query(".//dt[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:') or contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($lbl) . "')]/following-sibling::dd[1]", $projectDetails);
                            if ($n && $n->length > 0) {
                                $closingRaw = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                                if (!empty($closingRaw))
                                    break 2;
                            }
                        }
                    }
                }
            }
        }

        // 2) Essayer aussi dans la section "Key Details" (ou FR)
        if ($closingRaw === null) {
            $sectionNodes = $xpath->query(
                "//section[.//h2[contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZÀÂÄÇÉÈÊËÎÏÔŒÙÛÜŸ', 'abcdefghijklmnopqrstuvwxyzàâäçéèêëîïôœùûüÿ'), 'key details')
                                  or contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZÀÂÄÇÉÈÊËÎÏÔŒÙÛÜŸ', 'abcdefghijklmnopqrstuvwxyzàâäçéèêëîïôœùûüÿ'), 'détails clés')
                                  or contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZÀÂÄÇÉÈÊËÎÏÔŒÙÛÜŸ', 'abcdefghijklmnopqrstuvwxyzàâäçéèêëîïôœùûüÿ'), 'details cles')]]"
            );
            if ($sectionNodes && $sectionNodes->length > 0) {
                $keyDetails = $sectionNodes->item(0);
                $sx = new \DOMXPath($dom);
                // Country
                foreach ($countryLabels as $lbl) {
                    $n = $sx->query(".//th[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:')]/following-sibling::td[1]", $keyDetails);
                    if ($n && $n->length > 0) {
                        $country = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                        break;
                    }
                    $n = $sx->query(".//dt[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:')]/following-sibling::dd[1]", $keyDetails);
                    if ($n && $n->length > 0) {
                        $country = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                        break;
                    }
                }
                // Region
                foreach ($regionLabels as $lbl) {
                    $n = $sx->query(".//th[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:')]/following-sibling::td[1]", $keyDetails);
                    if ($n && $n->length > 0) {
                        $region = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                        break;
                    }
                    $n = $sx->query(".//dt[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:')]/following-sibling::dd[1]", $keyDetails);
                    if ($n && $n->length > 0) {
                        $region = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                        break;
                    }
                }
                // Closing Date
                foreach ($closingLabels as $lbl) {
                    $n = $sx->query(".//th[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:')]/following-sibling::td[1]", $keyDetails);
                    if ($n && $n->length > 0) {
                        $closingRaw = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                        break;
                    }
                    $n = $sx->query(".//dt[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:')]/following-sibling::dd[1]", $keyDetails);
                    if ($n && $n->length > 0) {
                        $closingRaw = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                        break;
                    }
                }
            }
        }

        // 2) Chercher aussi dans les sections "Procurement" ou "Notices" qui peuvent contenir la Closing Date
        if ($closingRaw === null) {
            // Chercher dans les sections liées aux appels d'offres
            $procurementSections = $xpath->query("//section[contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'procurement') or contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'notice')]");
            if ($procurementSections && $procurementSections->length > 0) {
                foreach ($procurementSections as $section) {
                    $sx = new \DOMXPath($dom);
                    foreach ($closingLabels as $lbl) {
                        $n = $sx->query(".//th[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:')]/following-sibling::td[1]", $section);
                        if ($n && $n->length > 0) {
                            $closingRaw = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                            break 2;
                        }
                        $n = $sx->query(".//dt[normalize-space()='{$lbl}' or starts-with(normalize-space(), '{$lbl}:')]/following-sibling::dd[1]", $section);
                        if ($n && $n->length > 0) {
                            $closingRaw = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                            break 2;
                        }
                        // Chercher aussi dans les div/span
                        $n = $sx->query(".//*[self::div or self::span][contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($lbl) . "')]/following-sibling::*[1]", $section);
                        if ($n && $n->length > 0) {
                            $closingRaw = trim(preg_replace('/\s+/', ' ', $n->item(0)->textContent));
                            if (!empty($closingRaw) && !preg_match('/^[A-Za-z\s]+$/', $closingRaw)) { // Vérifier que ce n'est pas juste du texte
                                break 2;
                            }
                        }
                    }
                }
            }
        }

        // 3) Sinon, chercher globalement dans la page
        if ($country === null) {
            $country = $findByLabels($countryLabels);
        }
        if ($region === null) {
            $region = $findByLabels($regionLabels);
        }
        if ($closingRaw === null) {
            $closingRaw = $findByLabels($closingLabels);
        }

        // Fallback regex pour Closing Date si non trouvé par DOM
        $closing = null;
        if (!empty($closingRaw)) {
            $closing = $this->normalizeDateString($closingRaw);
        }
        if (!$closing) {
            $pattern = '/(Closing\s*Date|Date\s*de\s*clôture)[^\n\r\<\>]{0,200}?('
                . '\d{1,2}\s+[A-Za-zÀ-ÖØ-öø-ÿ]+\s+\d{4}'
                . '|[A-Za-zÀ-ÖØ-öø-ÿ]+\s+\d{1,2},\s*\d{4}'
                . '|\d{1,2}-[A-Za-z]{3}-\d{4}'
                . '|\d{1,2}\/\d{1,2}\/\d{4}'
                . '|\d{4}-\d{2}-\d{2}'
                . ')/iu';
            if (preg_match($pattern, $html, $m)) {
                $closingRaw = $closingRaw ?: trim($m[2]);
                $closing = $this->normalizeDateString(trim($m[2]));
            }
        }

        // Regex fallback for Country/Region if still empty (grab text between label and next tag)
        if (!$country) {
            if (preg_match('/(?:>\s*(Country|Pays)\s*:?)\s*<[^>]*>\s*([^<]{2,120})</iu', $html, $m)) {
                $country = trim(preg_replace('/\s+/', ' ', $m[2]));
            } elseif (preg_match('/(Country|Pays)[^\n\r<>]{0,80}?([^<]{2,120})</iu', $html, $m)) {
                $country = trim(preg_replace('/\s+/', ' ', $m[2]));
            }
        }
        if (!$region) {
            if (preg_match('/(?:>\s*(Region|Région)\s*:?)\s*<[^>]*>\s*([^<]{2,160})</iu', $html, $m)) {
                $region = trim(preg_replace('/\s+/', ' ', $m[2]));
            } elseif (preg_match('/(Region|Région)[^\n\r<>]{0,80}?([^<]{2,160})</iu', $html, $m)) {
                $region = trim(preg_replace('/\s+/', ' ', $m[2]));
            }
        }

        // Plain-text fallback (strip tags) for all three fields
        $plain = trim(preg_replace('/\s+/', ' ', strip_tags($html))); // collapse whitespace

        // Recherche améliorée de "Closing Date" dans le HTML brut (y compris dans "Project Details")
        if (!$closing && $html !== '') {
            // Chercher "Closing Date" suivi d'une date dans un contexte plus large (500 caractères)
            $patterns = [
                // Pattern 1: "Closing Date" suivi d'une date dans les 200 caractères suivants
                '/(Closing\s*Date|Date\s*de\s*clôture)[^<]{0,200}?('
                . '\d{1,2}\s+[A-Za-zÀ-ÖØ-öø-ÿ]+\s+\d{4}'
                . '|[A-Za-zÀ-ÖØ-öø-ÿ]+\s+\d{1,2},\s*\d{4}'
                . '|\d{1,2}-[A-Za-z]{3}-\d{4}'
                . '|\d{1,2}\/\d{1,2}\/\d{4}'
                . '|\d{4}-\d{2}-\d{2}'
                . ')/iu',
                // Pattern 2: Dans une table avec "Closing Date" dans th/td
                '/<th[^>]*>.*?Closing\s*Date.*?<\/th>\s*<td[^>]*>(.*?)<\/td>/is',
                // Pattern 3: Dans un div avec "Closing Date" comme label
                '/<div[^>]*>.*?Closing\s*Date[^<]*<\/div>\s*<div[^>]*>([^<]{5,50})<\/div>/is',
            ];

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $html, $m)) {
                    $dateStr = isset($m[2]) ? trim(strip_tags($m[2])) : (isset($m[1]) ? trim(strip_tags($m[1])) : '');
                    if (!empty($dateStr)) {
                        $closing = $this->normalizeDateString($dateStr);
                        if ($closing) {
                            $closingRaw = $dateStr;
                            Log::debug('World Bank Scraper: Closing Date trouvée via regex HTML brut', [
                                'project_id' => $projectId,
                                'pattern' => $pattern,
                                'raw' => $dateStr,
                                'normalized' => $closing,
                            ]);
                            break;
                        }
                    }
                }
            }
        }

        if (!$closing && $plain !== '') {
            if (
                preg_match('/\b(Closing\s*Date|Date\s*de\s*clôture)\b\s*[:\-]?\s*('
                    . '\d{1,2}\s+[A-Za-zÀ-ÖØ-öø-ÿ]+\s+\d{4}'
                    . '|[A-Za-zÀ-ÖØ-öø-ÿ]+\s+\d{1,2},\s*\d{4}'
                    . '|\d{1,2}-[A-Za-z]{3}-\d{4}'
                    . '|\d{1,2}\/\d{1,2}\/\d{4}'
                    . '|\d{4}-\d{2}-\d{2}'
                    . ')/iu', $plain, $m)
            ) {
                $closingRaw = $closingRaw ?: $m[2];
                $closing = $this->normalizeDateString($m[2]);
            }
        }
        if (!$country && $plain !== '') {
            if (preg_match('/\b(Country|Pays)\b\s*[:\-]?\s*([^|\n\r]{2,120}?)(?:\s{2,}|\bRegion\b|\bRégion\b|\bDisclosure\b|$)/iu', $plain, $m)) {
                $country = trim($m[2]);
            }
        }
        if (!$region && $plain !== '') {
            if (preg_match('/\b(Region|Région)\b\s*[:\-]?\s*([^|\n\r]{2,160}?)(?:\s{2,}|\bFiscal\b|\bEnvironmental\b|\bClosing\b|$)/iu', $plain, $m)) {
                $region = trim($m[2]);
            }
        }

        Log::debug('World Bank Scraper: Raw detail extraction', [
            'project_id' => $projectId,
            'country_raw' => $country,
            'region_raw' => $region,
            'closing_raw' => $closingRaw,
            'closing_norm' => $closing,
        ]);

        $result = [
            'country' => $country ?: null,
            'region' => $region ?: null,
            'closing_date' => $closing ?: null,
            'closing_raw' => $closingRaw ?: null,
        ];

        // Mettre en cache pour les futurs appels durant cette session
        $this->projectCache[$projectId] = $result;

        return $result;
    }

    /**
     * Normalise une date texte FR/EN en format YYYY-MM-DD
     */
    private function normalizeDateString(string $dateStr): ?string
    {
        $dateStr = trim($dateStr);
        // ISO direct
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateStr)) {
            return $dateStr;
        }

        // dd month yyyy (FR/EN)
        $months = [
            // FR
            'janvier' => 1,
            'février' => 2,
            'fevrier' => 2,
            'mars' => 3,
            'avril' => 4,
            'mai' => 5,
            'juin' => 6,
            'juillet' => 7,
            'août' => 8,
            'aout' => 8,
            'septembre' => 9,
            'octobre' => 10,
            'novembre' => 11,
            'décembre' => 12,
            'decembre' => 12,
            // EN
            'january' => 1,
            'february' => 2,
            'march' => 3,
            'april' => 4,
            'may' => 5,
            'june' => 6,
            'july' => 7,
            'august' => 8,
            'september' => 9,
            'october' => 10,
            'november' => 11,
            'december' => 12,
        ];

        if (preg_match('/^(\d{1,2})\s+([A-Za-zÀ-ÖØ-öø-ÿ]+)\s+(\d{4})$/u', mb_strtolower($dateStr, 'UTF-8'), $m)) {
            $d = (int) $m[1];
            $monName = $m[2];
            $y = (int) $m[3];
            $mon = $months[$monName] ?? null;
            if ($mon && $d >= 1 && $d <= 31) {
                return sprintf('%04d-%02d-%02d', $y, $mon, $d);
            }
        }

        // Month dd, yyyy (EN) e.g., December 31, 2028
        if (preg_match('/^([A-Za-zÀ-ÖØ-öø-ÿ]+)\s+(\d{1,2}),\s*(\d{4})$/u', mb_strtolower($dateStr, 'UTF-8'), $m)) {
            $monName = $m[1];
            $d = (int) $m[2];
            $y = (int) $m[3];
            $mon = $months[$monName] ?? null;
            if ($mon && $d >= 1 && $d <= 31) {
                return sprintf('%04d-%02d-%02d', $y, $mon, $d);
            }
        }

        // dd-MMM-yyyy e.g., 31-Dec-2028
        if (preg_match('/^(\d{1,2})-([A-Za-z]{3})-(\d{4})$/', $dateStr, $m)) {
            $d = (int) $m[1];
            $monAbbr = strtolower($m[2]);
            $map = ['jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4, 'may' => 5, 'jun' => 6, 'jul' => 7, 'aug' => 8, 'sep' => 9, 'oct' => 10, 'nov' => 11, 'dec' => 12];
            $mon = $map[$monAbbr] ?? null;
            if ($mon && $d >= 1 && $d <= 31) {
                return sprintf('%04d-%02d-%02d', (int) $m[3], $mon, $d);
            }
        }

        // MM/DD/YYYY or M/D/YYYY
        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $dateStr, $m)) {
            $mon = (int) $m[1];
            $d = (int) $m[2];
            $y = (int) $m[3];
            if ($mon >= 1 && $mon <= 12 && $d >= 1 && $d <= 31) {
                return sprintf('%04d-%02d-%02d', $y, $mon, $d);
            }
        }

        // Dernier recours: Carbon::parse (peut réussir en EN)
        try {
            $c = \Carbon\Carbon::parse($dateStr);
            return $c->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Récupère la date limite de soumission depuis la page de notice World Bank
     *
     * @param string $noticeUrl URL de la page de notice
     * @return array [date_normalized, date_raw] ou [null, null] si non trouvé
     */
    private function fetchSubmissionDeadlineFromNotice(string $noticeUrl): array
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9,fr;q=0.8',
                ])
                ->get($noticeUrl);

            if (!$response->successful()) {
                Log::debug('World Bank Scraper: Failed to fetch notice page', [
                    'status' => $response->status(),
                    'url' => $noticeUrl,
                ]);
                return [null, null];
            }

            $html = $response->body();

            // Sauvegarder pour debug si nécessaire
            if (config('app.debug')) {
                try {
                    \Storage::disk('local')->put('debug/wb_notice_' . md5($noticeUrl) . '.html', $html);
                } catch (\Exception $e) {
                    // Ignorer
                }
            }

            // Parser le HTML
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            // Mots-clés pour trouver la date limite
            // NOTE: "Closing Date" peut être utilisé pour la date limite de soumission sur certaines pages
            $deadlineLabels = [
                'Submission Deadline',
                'Deadline for Submission',
                'Closing Date',  // Important: peut être la date limite de soumission
                'Deadline',
                'Date limite de soumission',
                'Date de clôture',
                'Date limite',
            ];

            // Stratégie 1: Chercher dans les tableaux/listes avec les labels
            foreach ($deadlineLabels as $label) {
                // Chercher dans les tableaux (th/td)
                $query = "//th[contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($label) . "')]/following-sibling::td[1]";
                $nodes = $xpath->query($query);
                if ($nodes && $nodes->length > 0) {
                    $text = trim($nodes->item(0)->textContent);
                    $date = $this->normalizeDateString($text);
                    if ($date) {
                        Log::info('World Bank Scraper: ✅ Date récupérée depuis la page HTML (tableau)', [
                            'source' => 'Page HTML - Tableau avec label',
                            'url' => $noticeUrl,
                            'label_trouve' => $label,
                            'texte_brut' => $text,
                            'date_normalisee' => $date,
                            'methode' => 'XPath: th/td avec label',
                        ]);
                        return [$date, $text];
                    }
                }

                // Chercher dans les listes de définition (dt/dd)
                $query = "//dt[contains(translate(normalize-space(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($label) . "')]/following-sibling::dd[1]";
                $nodes = $xpath->query($query);
                if ($nodes && $nodes->length > 0) {
                    $text = trim($nodes->item(0)->textContent);
                    $date = $this->normalizeDateString($text);
                    if ($date) {
                        Log::info('World Bank Scraper: ✅ Date récupérée depuis la page HTML (liste de définition)', [
                            'source' => 'Page HTML - Liste de définition (dt/dd)',
                            'url' => $noticeUrl,
                            'label_trouve' => $label,
                            'texte_brut' => $text,
                            'date_normalisee' => $date,
                            'methode' => 'XPath: dt/dd avec label',
                        ]);
                        return [$date, $text];
                    }
                }
            }

            // Stratégie 2: Chercher près des mots-clés dans le texte
            $deadlineKeywords = [
                'submission deadline',
                'deadline for submission',
                'closing date',
                'deadline',
                'date limite de soumission',
                'date de clôture',
            ];

            $textLower = strtolower($html);
            foreach ($deadlineKeywords as $keyword) {
                $pos = stripos($textLower, $keyword);
                if ($pos !== false) {
                    // Extraire un contexte autour du mot-clé
                    $context = substr($html, max(0, $pos - 100), 400);

                    // Patterns de date
                    $datePatterns = [
                        // Format complet: "January 15, 2025"
                        '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})/i',
                        // Format abrégé: "Jan 15, 2025"
                        '/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\.?\s+(\d{1,2}),?\s+(\d{4})/i',
                        // Format DD-MMM-YYYY: "15-Jan-2025"
                        '/(\d{1,2})[\s-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*[\s-](\d{4})/i',
                        // Format DD/MM/YYYY ou MM/DD/YYYY
                        '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
                        // Format YYYY-MM-DD
                        '/(\d{4})-(\d{2})-(\d{2})/',
                    ];

                    foreach ($datePatterns as $pattern) {
                        if (preg_match($pattern, $context, $matches)) {
                            $dateStr = trim($matches[0]);
                            $date = $this->normalizeDateString($dateStr);
                            if ($date) {
                                // Extraire un extrait du contexte pour preuve
                                $contextStart = max(0, $pos - 50);
                                $contextEnd = min(strlen($html), $pos + 150);
                                $extrait = substr($html, $contextStart, $contextEnd - $contextStart);
                                $extrait = strip_tags($extrait);
                                $extrait = preg_replace('/\s+/', ' ', $extrait);

                                Log::info('World Bank Scraper: ✅ Date récupérée depuis la page HTML (mot-clé)', [
                                    'source' => 'Page HTML - Recherche par mot-clé',
                                    'url' => $noticeUrl,
                                    'mot_cle_trouve' => $keyword,
                                    'texte_brut' => $dateStr,
                                    'date_normalisee' => $date,
                                    'extrait_html' => substr($extrait, 0, 200), // Extrait pour preuve
                                    'methode' => 'Regex près du mot-clé dans le HTML',
                                ]);
                                return [$date, $dateStr];
                            }
                        }
                    }
                }
            }

            // Stratégie 3: Chercher toutes les dates dans la page et prendre la plus récente future
            $allDates = [];
            $textContent = $dom->textContent ?? '';
            $datePatterns = [
                '/(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})/i',
                '/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\.?\s+(\d{1,2}),?\s+(\d{4})/i',
                '/(\d{1,2})[\s-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*[\s-](\d{4})/i',
                '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
                '/(\d{4})-(\d{2})-(\d{2})/',
            ];

            foreach ($datePatterns as $pattern) {
                if (preg_match_all($pattern, $textContent, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $match) {
                        try {
                            $dateStr = trim($match[0]);
                            $date = $this->normalizeDateString($dateStr);
                            if ($date) {
                                $carbonDate = \Carbon\Carbon::parse($date);
                                // Garder seulement les dates futures ou récentes (max 2 ans dans le passé)
                                if ($carbonDate->isFuture() || $carbonDate->gt(now()->subYears(2))) {
                                    $allDates[] = [
                                        'date' => $carbonDate,
                                        'str' => $dateStr,
                                        'normalized' => $date,
                                    ];
                                }
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

                $bestDate = $allDates[0];
                Log::info('World Bank Scraper: ✅ Date récupérée depuis la page HTML (plus récente)', [
                    'source' => 'Page HTML - Date la plus récente trouvée',
                    'url' => $noticeUrl,
                    'date_normalisee' => $bestDate['normalized'],
                    'texte_brut' => $bestDate['str'],
                    'total_dates_trouvees' => count($allDates),
                    'methode' => 'Extraction de toutes les dates + sélection de la plus récente',
                    'note' => 'Cette méthode est moins précise - vérifier manuellement si possible',
                ]);
                return [$bestDate['normalized'], $bestDate['str']];
            }

            Log::warning('World Bank Scraper: ❌ Aucune date limite trouvée dans la page de notice', [
                'url' => $noticeUrl,
                'raisons_possibles' => [
                    'La page ne contient pas de label "Submission Deadline" ou équivalent',
                    'Le format de date n\'est pas reconnu',
                    'La page est vide ou mal formatée',
                ],
            ]);
            return [null, null];

        } catch (\Exception $e) {
            Log::debug('World Bank Scraper: Error fetching deadline from notice', [
                'url' => $noticeUrl,
                'error' => $e->getMessage(),
            ]);
            return [null, null];
        }
    }

    /**
     * Tente de résoudre le project_id WB (ex: P177004) à partir d'une URL de notice
     * en cherchant un lien vers /project-detail/Pxxxxxx ou des empreintes JSON/HTML.
     */
    private function resolveProjectIdFromNoticeUrl(string $noticeUrl): ?string
    {
        try {
            $resp = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9,fr;q=0.8',
                ])
                ->get($noticeUrl);

            if (!$resp->successful()) {
                Log::debug('WB resolver: notice fetch failed', ['status' => $resp->status(), 'url' => $noticeUrl]);
                return null;
            }

            $html = $resp->body();
            if (config('app.debug')) {
                try {
                    \Storage::disk('local')->put('debug/wb_notice_' . md5($noticeUrl) . '.html', $html);
                } catch (\Exception $e) {
                }
            }

            // 1) Chercher un lien direct vers project-detail/Pxxxxxx
            if (preg_match('#/project-detail/(P[0-9A-Z]+)#i', $html, $m)) {
                return strtoupper($m[1]);
            }

            // 2) Chercher projectId dans JSON inline
            if (preg_match('/\bprojectId\b"?\s*[:=]\s*"?(P[0-9A-Z]+)"?/i', $html, $m)) {
                return strtoupper($m[1]);
            }

            // 3) Attributs data-*
            if (preg_match('/data-Project-Id\s*=\s*"?(P[0-9A-Z]+)"?/i', $html, $m)) {
                return strtoupper($m[1]);
            }

            // 4) Plain text fallback
            $plain = trim(preg_replace('/\s+/', ' ', strip_tags($html)));
            if (preg_match('/\b(P[0-9A-Z]{6,})\b/', $plain, $m)) {
                return strtoupper($m[1]);
            }

            return null;
        } catch (\Exception $e) {
            Log::debug('WB resolver exception', ['url' => $noticeUrl, 'error' => $e->getMessage()]);
            return null;
        }
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

        // Protocol-relative (//example.org/path)
        if (str_starts_with($url, '//')) {
            return 'https:' . $url;
        }

        // Si c'est une URL relative commençant par '/'
        if (str_starts_with($url, '/')) {
            return 'https://projects.worldbank.org' . $url;
        }

        // Autres chemins relatifs (sans slash initial)
        return 'https://projects.worldbank.org/' . ltrim($url, '/');
    }
}
