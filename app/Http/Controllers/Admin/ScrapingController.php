<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ScraperHelper;
use App\Services\ScrapingProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScrapingController extends Controller
{
    private $sourceCommands = [
        'AFD' => 'scrape:afd',
        'African Development Bank' => 'app:scrape-afdb',
        'World Bank' => 'app:scrape-world-bank',
        'DGMarket' => 'app:scrape-dgmarket',
        'BDEAC' => 'app:scrape-bdeac',
        'IFAD' => 'app:scrape-ifad',
    ];

    /**
     * Affiche la page de scraping
     */
    public function index()
    {
        $activeSources = ScraperHelper::getActiveSources();

        // Récupérer les règles de filtrage actives avec leurs détails
        $filteringRules = \App\Models\FilteringRule::with(['countries', 'activityPoles.keywords'])
            ->where('is_active', true)
            ->get()
            ->groupBy('source');

        return view('admin.scraping.index', compact('activeSources', 'filteringRules'));
    }

    /**
     * Lance le scraping avec suivi de progression
     */
    public function start(Request $request, ScrapingProgressService $progressService)
    {
        $noTruncate = $request->boolean('no_truncate', false);

        // Récupérer les sources actives
        $activeSources = ScraperHelper::getActiveSources();

        if (empty($activeSources)) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune règle de filtrage active trouvée. Activez au moins une règle dans l\'admin.',
            ], 400);
        }

        // Générer un ID unique pour ce job
        $jobId = ScrapingProgressService::generateJobId();

        // Initialiser la progression
        $progressService->initialize($jobId, count($activeSources));

        // Lancer le scraping en arrière-plan après la réponse
        // Enregistrer la fonction shutdown pour exécuter après la réponse
        register_shutdown_function(function () use ($jobId, $activeSources, $noTruncate) {
            $progressService = app(\App\Services\ScrapingProgressService::class);
            $controller = new self();
            $controller->executeScrapingRoundRobin($jobId, $activeSources, $noTruncate, $progressService);
        });

        return response()->json([
            'success' => true,
            'job_id' => $jobId,
            'total_sources' => count($activeSources),
            'sources' => $activeSources,
        ]);
    }

    /**
     * Récupère la progression du scraping
     */
    public function progress(Request $request, ScrapingProgressService $progressService)
    {
        $jobId = $request->input('job_id');

        if (!$jobId) {
            return response()->json([
                'success' => false,
                'message' => 'Job ID manquant',
            ], 400);
        }

        $progress = $progressService->getProgress($jobId);

        if (!$progress) {
            return response()->json([
                'success' => false,
                'message' => 'Progression non trouvée',
            ], 404);
        }

        // Ajouter le nombre total d'offres scrapées
        $totalOffres = DB::table('offres')->count();
        $progress['total_offres'] = $totalOffres;

        // Ajouter temps écoulé et estimation du temps restant
        if (!empty($progress['started_at'])) {
            try {
                $startedAt = \Carbon\Carbon::parse($progress['started_at']);
                $now = now();
                $elapsed = $now->diffInSeconds($startedAt);
                $progress['elapsed_seconds'] = $elapsed;
                $percentage = max(0, (int) ($progress['percentage'] ?? 0));
                if ($percentage > 0 && $percentage < 100) {
                    // ETA simple: temps total estimé = elapsed / (percentage/100)
                    $totalEstimated = (int) round($elapsed / ($percentage / 100));
                    $remaining = max(0, $totalEstimated - $elapsed);
                    $progress['eta_seconds'] = $remaining;
                } else {
                    $progress['eta_seconds'] = null;
                }
            } catch (\Exception $e) {
                // Ignorer les erreurs de parsing
            }
        }

        return response()->json([
            'success' => true,
            'progress' => $progress,
        ]);
    }

    /**
     * Annule le scraping en cours
     */
    public function cancel(Request $request, ScrapingProgressService $progressService)
    {
        $jobId = $request->input('job_id');

        if (!$jobId) {
            return response()->json([
                'success' => false,
                'message' => 'Job ID manquant',
            ], 400);
        }

        $progress = $progressService->getProgress($jobId);

        if (!$progress) {
            return response()->json([
                'success' => false,
                'message' => 'Progression non trouvée',
            ], 404);
        }

        // Vérifier si le scraping est déjà terminé
        if (in_array($progress['status'], ['completed', 'failed', 'cancelled'])) {
            return response()->json([
                'success' => false,
                'message' => 'Le scraping est déjà terminé',
            ], 400);
        }

        // Marquer comme annulé
        $progressService->cancel($jobId);

        return response()->json([
            'success' => true,
            'message' => 'Scraping annulé avec succès',
        ]);
    }

    /**
     * Vide immédiatement la table offres (utilisé par le bouton dédié)
     */
    public function truncate(Request $request)
    {
        try {
            $countBefore = DB::table('offres')->count();
            // Supprimer via DELETE (multi-DB) puis tenter TRUNCATE MySQL
            DB::table('offres')->delete();
            try {
                DB::connection('mysql')->statement('TRUNCATE TABLE offres');
            } catch (\Exception $e) {
                // Ignorer si non-MySQL ou pas possible
            }
            $message = "Table offres vidée ({$countBefore} lignes supprimées)";
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'deleted' => $countBefore,
                    'message' => $message,
                ]);
            }
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            $errorMessage = 'Erreur lors du vidage: ' . $e->getMessage();
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], 500);
            }
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    /**
     * Exécute le scraping avec stratégie round-robin
     */
    public function executeScrapingRoundRobin(
        string $jobId,
        array $activeSources,
        bool $noTruncate,
        \App\Services\ScrapingProgressService $progressService
    ): void {
        try {
            if (!$noTruncate) {
                $progressService->updateSource($jobId, 'Vidage de la base', 0);

                try {
                    // Essayer plusieurs méthodes pour être sûr
                    \App\Models\Offre::query()->delete();

                    try {
                        DB::table('offres')->truncate();
                    } catch (\Exception $e) {
                        // Truncate peut échouer sur SQLite ou si contraintes, DELETE suffit
                    }

                    Log::info('Table offres vidée au début du scraping');
                } catch (\Exception $e) {
                    Log::error('Erreur lors du vidage de la table offres', ['error' => $e->getMessage()]);
                }
            }

            // Scraping séquentiel : une source après l'autre
            $totalSources = count($activeSources);
            $totalFound = 0;

            foreach ($activeSources as $index => $source) {
                $currentSourceNum = $index + 1;
                $progressService->updateSource($jobId, $source, $currentSourceNum);

                $scraper = $this->createScraper($source);
                if (!$scraper) {
                    Log::warning("Scraper non trouvé pour la source : {$source}");
                    continue;
                }

                $scraper->setJobId($jobId);
                $scraper->initialize();

                $hasMore = true;
                $sourceCount = 0;
                $lotCount = 0;
                $maxLots = 5; // Limite à 50 offres au maximum (5 lots de 10) par source

                while ($hasMore && $lotCount < $maxLots) {
                    // Vérifier si annulé
                    if ($progressService->isCancelled($jobId)) {
                        Log::info("Scraping annulé pour le job {$jobId}");
                        return;
                    }

                    try {
                        // On utilise un timeout large (5 min) pour chaque lot de 10
                        $lotCount++;
                        $result = $scraper->scrapeBatch(10);
                        $hasMore = $result['has_more'];
                        $sourceCount += $result['count'];
                        $totalFound += $result['count'];

                        // Mettre à jour les trouvailles en temps réel dans l'UI
                        if (!empty($result['findings'])) {
                            $progressService->addFindings($jobId, $result['findings']);
                        }

                        // Mettre à jour le message de progression
                        $progressService->updateProgress($jobId, [
                            'message' => "Scraping de {$source}... {$sourceCount} offres trouvées",
                            'source_progress' => $sourceCount
                        ]);

                        Log::info("Séquentiel: {$source} lot {$lotCount} traité", [
                            'count' => $result['count'],
                            'has_more' => $hasMore
                        ]);

                    } catch (\Exception $e) {
                        Log::error("Erreur durant le scraping de {$source}", ['error' => $e->getMessage()]);
                        $progressService->markSourceFailed($jobId, $source, $e->getMessage());
                        $hasMore = false; // Passer à la source suivante en cas d'erreur fatale sur celle-ci
                    }
                }

                $progressService->markSourceCompleted($jobId, $source, $sourceCount);
            }

            $progressService->complete($jobId);

            Log::info('Sequential scraping completed', [
                'total_count' => $totalFound,
                'sources_count' => $totalSources,
            ]);

            // Appliquer les filtres post-scraping
            try {
                $idsToKeep = \App\Services\ScraperHelper::getIdsMatchingActiveFilters();

                if ($idsToKeep->isNotEmpty()) {
                    DB::table('offres')->whereNotIn('id', $idsToKeep->all())->delete();
                } else {
                    // Si aucune source n'est active, on vide tout
                    DB::table('offres')->delete();
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors du filtrage post-scraping', ['error' => $e->getMessage()]);
            }

            // Marquer comme terminé
            $progressService->complete($jobId);
        } catch (\Exception $e) {
            $progressService->fail($jobId, $e->getMessage());
            Log::error('Erreur lors de l\'exécution du scraping round-robin', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Crée une instance de scraper pour une source donnée
     */
    private function createScraper(string $source): ?\App\Services\IterativeScraperInterface
    {
        return match ($source) {
            'World Bank' => app(\App\Services\WorldBankScraperService::class),
            'African Development Bank' => app(\App\Services\AfDBScraperService::class),
            'AFD' => app(\App\Services\AFDScraperService::class),
            'IFAD' => app(\App\Services\IFADScraperService::class),
            'BDEAC' => app(\App\Services\BDEACScraperService::class),
            default => null,
        };
    }

    /**
     * Exécute le scraping avec suivi de progression (ancienne méthode parallèle - conservée pour compatibilité)
     */
    public function executeScraping(
        string $jobId,
        array $activeSources,
        bool $noTruncate,
        ScrapingProgressService $progressService,
        array $sourceCommands = null
    ): void {
        if ($sourceCommands === null) {
            $sourceCommands = $this->sourceCommands;
        }
        try {
            // Vider la table avant le scraping (sauf si --no-truncate)
            if (!$noTruncate) {
                $progressService->updateSource($jobId, 'Vidage de la base', 0);
                $countBefore = DB::table('offres')->count();

                try {
                    DB::statement('DELETE FROM offres');

                    // Si SQLite, réinitialiser le compteur auto
                    $driver = DB::connection()->getDriverName();
                    if ($driver === 'sqlite') {
                        try {
                            DB::statement('DELETE FROM sqlite_sequence WHERE name="offres"');
                        } catch (\Exception $e) {
                            // Ignorer
                        }
                    }

                    // Vider aussi dans MySQL si disponible
                    try {
                        DB::connection('mysql')->statement('TRUNCATE TABLE offres');
                    } catch (\Exception $e) {
                        // Ignorer
                    }
                } catch (\Exception $e) {
                    Log::error('Erreur lors du vidage de la table offres', ['error' => $e->getMessage()]);
                }
            }

            // Exécuter les scrapers en parallèle pour optimiser le temps
            $processes = [];
            $sourceData = [];

            // Préparer les données pour chaque source
            foreach ($activeSources as $index => $source) {
                if (!isset($sourceCommands[$source])) {
                    $progressService->markSourceFailed($jobId, $source, "Aucune commande de scraping trouvée");
                    continue;
                }

                $command = $sourceCommands[$source];
                $offresBefore = DB::table('offres')->where('source', $source)->count();

                // Lancer le processus en arrière-plan
                $processData = $this->startScraperProcess($command, $source, $jobId);

                if ($processData) {
                    $processes[$source] = $processData;
                    $sourceData[$source] = [
                        'offres_before' => $offresBefore,
                        'index' => $index + 1,
                    ];
                    $progressService->updateSource($jobId, $source, $index + 1);
                } else {
                    $progressService->markSourceFailed($jobId, $source, "Impossible de lancer le processus");
                }
            }

            // Attendre que tous les processus se terminent
            $successCount = 0;
            $failCount = 0;

            while (!empty($processes)) {
                // Vérifier si annulé
                if ($progressService->isCancelled($jobId)) {
                    Log::info("Scraping annulé pour le job {$jobId}");
                    // Tuer tous les processus en cours
                    foreach ($processes as $source => $processData) {
                        if (is_resource($processData['process'])) {
                            proc_terminate($processData['process']);
                            if (isset($processData['pipes'][1]))
                                fclose($processData['pipes'][1]);
                            if (isset($processData['pipes'][2]))
                                fclose($processData['pipes'][2]);
                            proc_close($processData['process']);
                        }
                    }
                    break;
                }

                foreach ($processes as $source => $processData) {
                    $process = $processData['process'];
                    $status = proc_get_status($process);

                    if (!$status['running']) {
                        // Le processus est terminé
                        $exitCode = $status['exitcode'];

                        // Lire stdout et stderr
                        $stdout = '';
                        $stderr = '';

                        // Lire stdout
                        if (isset($processData['pipes'][1]) && is_resource($processData['pipes'][1])) {
                            stream_set_blocking($processData['pipes'][1], false);
                            $stdout = stream_get_contents($processData['pipes'][1]);
                            fclose($processData['pipes'][1]);
                        }

                        // Lire stderr
                        if (isset($processData['pipes'][2]) && is_resource($processData['pipes'][2])) {
                            stream_set_blocking($processData['pipes'][2], false);
                            $stderr = stream_get_contents($processData['pipes'][2]);
                            fclose($processData['pipes'][2]);
                        }

                        proc_close($process);
                        unset($processes[$source]);

                        // Compter les offres
                        $offresAfter = DB::table('offres')->where('source', $source)->count();
                        $offresCount = $offresAfter - $sourceData[$source]['offres_before'];

                        if ($exitCode === 0) {
                            $progressService->markSourceCompleted($jobId, $source, $offresCount);
                            $successCount++;
                        } else {
                            // Construire un message d'erreur plus détaillé
                            $errorMessage = "Code de sortie: {$exitCode}";

                            // Chercher des messages d'erreur dans stderr et stdout
                            $errorText = !empty($stderr) ? $stderr : $stdout;

                            if (!empty($errorText)) {
                                // Extraire les lignes d'erreur significatives
                                $errorLines = explode("\n", trim($errorText));
                                $errorMessages = [];

                                foreach ($errorLines as $line) {
                                    $line = trim($line);
                                    // Ignorer les lignes vides, les warnings PHP, et les messages de debug
                                    if (
                                        !empty($line)
                                        && !str_starts_with($line, 'PHP')
                                        && !str_starts_with($line, 'Warning:')
                                        && !str_starts_with($line, 'Notice:')
                                        && !str_contains($line, 'Deprecated')
                                        && strlen($line) > 10
                                    ) {

                                        // Prendre les lignes qui contiennent "Error", "Exception", "Failed", etc.
                                        if (
                                            stripos($line, 'error') !== false
                                            || stripos($line, 'exception') !== false
                                            || stripos($line, 'failed') !== false
                                            || stripos($line, 'not found') !== false
                                            || stripos($line, 'could not') !== false
                                        ) {
                                            $errorMessages[] = substr($line, 0, 150);
                                        }
                                    }
                                }

                                // Si on a trouvé des messages d'erreur, les utiliser
                                if (!empty($errorMessages)) {
                                    $errorMessage = implode(' | ', array_slice($errorMessages, 0, 2)); // Prendre les 2 premiers
                                } elseif (!empty($errorText)) {
                                    // Sinon, prendre la première ligne non vide significative
                                    foreach ($errorLines as $line) {
                                        $line = trim($line);
                                        if (!empty($line) && strlen($line) > 20) {
                                            $errorMessage .= " - " . substr($line, 0, 100);
                                            break;
                                        }
                                    }
                                }
                            }

                            $progressService->markSourceFailed($jobId, $source, $errorMessage);
                            $failCount++;
                            Log::error("Scraping échoué pour {$source}", [
                                'exit_code' => $exitCode,
                                'stdout' => substr($stdout, 0, 500),
                                'stderr' => substr($stderr, 0, 500),
                            ]);
                        }
                    }
                }

                // Attendre un peu avant de vérifier à nouveau
                if (!empty($processes)) {
                    usleep(500000); // 0.5 seconde
                }
            }

            // Appliquer les filtres après le scraping: supprimer les offres non conformes
            try {
                $progressService->updateSource($jobId, 'Application des filtres', count($activeSources));
                $filterService = app(\App\Services\OfferFilteringService::class);
                $allOffres = \App\Models\Offre::all();
                $filtered = $filterService->filterOffers($allOffres);
                $idsToKeep = collect($filtered)->pluck('id');
                // RÈGLE MÉTIER: Ne jamais supprimer les World Bank, même si elles ne matchent pas les règles
                $wbIds = \App\Models\Offre::where('source', 'World Bank')->pluck('id');
                $finalIdsToKeep = $idsToKeep->merge($wbIds)->unique()->values()->all();
                if (!empty($finalIdsToKeep)) {
                    DB::table('offres')->whereNotIn('id', $finalIdsToKeep)->delete();
                } else {
                    // Si aucune ne correspond (cas extrême), ne pas supprimer les World Bank
                    $wbIds = \App\Models\Offre::where('source', 'World Bank')->pluck('id')->all();
                    if (!empty($wbIds)) {
                        DB::table('offres')->whereNotIn('id', $wbIds)->delete();
                    } else {
                        DB::table('offres')->delete();
                    }
                }
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'application des filtres', ['error' => $e->getMessage()]);
            }

            // Marquer comme terminé
            $progressService->complete($jobId);
        } catch (\Exception $e) {
            $progressService->fail($jobId, $e->getMessage());
            Log::error('Erreur lors de l\'exécution du scraping', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Lance un scraper en processus séparé
     *
     * @param string $command Commande Artisan à exécuter
     * @param string $source Nom de la source
     * @param string|null $jobId ID du job pour le suivi de progression
     * @return array|false ['process' => resource, 'pipes' => array] ou false en cas d'échec
     */
    private function startScraperProcess(string $command, string $source, ?string $jobId = null)
    {
        $phpPath = PHP_BINARY;
        $artisanPath = base_path('artisan');

        // Sur Windows, utiliser le chemin complet si nécessaire
        if (PHP_OS_FAMILY === 'Windows') {
            // S'assurer que le chemin PHP est correct
            if (!file_exists($phpPath)) {
                $phpPath = 'php'; // Fallback vers php dans le PATH
            }
        }

        // Construire la commande complète
        $fullCommand = escapeshellarg($phpPath) . ' ' . escapeshellarg($artisanPath) . ' ' . $command . ' --force';

        if ($jobId) {
            $fullCommand .= ' --job-id=' . escapeshellarg($jobId);
        }

        // Déscripteurs pour stdin, stdout, stderr
        $descriptors = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];

        // Options pour le processus
        $options = [];

        // Sur Windows, ne pas utiliser bypass_shell
        if (PHP_OS_FAMILY !== 'Windows') {
            $options['bypass_shell'] = false;
        }

        // Lancer le processus en arrière-plan
        $process = @proc_open($fullCommand, $descriptors, $pipes, base_path(), null, $options);

        if (is_resource($process)) {
            // Fermer stdin immédiatement
            if (isset($pipes[0]))
                fclose($pipes[0]);

            // Garder stdout et stderr ouverts pour lire les erreurs
            Log::info("Processus lancé pour {$source}: {$command}");
            return ['process' => $process, 'pipes' => $pipes, 'source' => $source];
        }

        Log::error("Impossible de lancer le processus pour {$source}: {$command}");
        return false;
    }

    /**
     * Récupère les dernières trouvailles pour un job
     */
    public function getFindings(string $jobId, ScrapingProgressService $progressService)
    {
        $findings = $progressService->getFindings($jobId);
        $progress = $progressService->getProgress($jobId);

        return response()->json([
            'success' => true,
            'findings' => $findings,
            'total_offres' => $progress['total_offres'] ?? 0,
        ]);
    }
}

