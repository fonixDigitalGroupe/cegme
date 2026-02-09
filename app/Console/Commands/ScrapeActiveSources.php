<?php

namespace App\Console\Commands;

use App\Models\FilteringRule;
use App\Services\OfferFilteringService;
use App\Services\ScraperHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\AFDScraperService;
use App\Services\AfDBScraperService;
use App\Services\WorldBankScraperService;
use App\Services\DGMarketScraperService;
use App\Services\BDEACScraperService;
use App\Services\IFADScraperService;
use App\Services\IterativeScraperInterface;

class ScrapeActiveSources extends Command
{
    protected $signature = 'app:scrape-active-sources 
                            {--no-truncate : Ne pas vider la table avant le scraping}
                            {--apply-filters : Appliquer le filtrage après le scraping (supprimer les offres non conformes)}
                            {--show-filters : Afficher les détails des filtres appliqués}
                            {--job-id= : ID du job pour le suivi de progression}';
    protected $description = 'Lancer le scraping intelligent pour les sources actives (cible ~50 offres par source)';

    public function handle()
    {
        set_time_limit(0); // Empêche le timeout PHP pour les longs processus
        $this->info('=== SCRAPING INTELLIGENT DES SOURCES ACTIVES ===');
        $this->newLine();

        // Initialiser le suivi de progression
        $progressService = app(\App\Services\ScrapingProgressService::class);
        $jobId = $this->option('job-id') ?? \App\Services\ScrapingProgressService::generateJobId();

        // Récupérer les sources actives
        $activeSources = ScraperHelper::getActiveSources();

        if (empty($activeSources)) {
            $this->warn('⚠ Aucune règle de filtrage active trouvée.');
            $this->info('💡 Scraping de TOUTES les sources par défaut...');
            $activeSources = [
                'AFD',
                'African Development Bank',
                'World Bank',
                'DGMarket',
                'BDEAC',
                'IFAD'
            ];
        }

        // Initialiser la progression si pas déjà fait
        $progressService->initialize($jobId, count($activeSources));

        if ($this->option('show-filters')) {
            $this->displayFilters($activeSources);
            $this->newLine();
        }

        // Vider la table par défaut (sauf si --no-truncate est spécifié)
        if (!$this->option('no-truncate')) {
            $this->info('🗑️  Vidage de la table offres...');
            Log::info('ScrapeActiveSources: Début du vidage de la table offres');
            $progressService->updateSource($jobId, 'Vidage de la base', 0);
            
            try {
                // Utilisation de delete() au lieu de truncate() pour éviter les verrous de table en prod
                DB::table('offres')->delete();
                
                // Reset auto-increment si possible, mais pas critique
                try {
                    DB::statement("ALTER TABLE offres AUTO_INCREMENT = 1");
                } catch (\Exception $e) {
                    // Ignorer si pas supporté ou erreur de droit
                }
                
                $this->info("✓ Table vidée avec succès (DELETE)");
                Log::info('ScrapeActiveSources: Table offres vidée avec succès');
            } catch (\Exception $e) {
                Log::error('ScrapeActiveSources: Erreur lors du vidage de la table: ' . $e->getMessage());
                $this->error("Erreur lors du vidage: " . $e->getMessage());
            }
            $this->newLine();
        } else {
            $this->info('⚠ Mode --no-truncate : conservation des données existantes');
            $this->newLine();
        }

        $this->info('Sources à traiter: ' . implode(', ', $activeSources));
        $this->newLine();

        // Utiliser un pool de processus pour paralléliser
        // On limite à 2 sources simultanées pour préserver la RAM (surtout avec Browsershot)
        $totalFoundGlobal = 0;
        $totalSources = count($activeSources);
        $results = [];

        $this->info("Lancement du scraping parallèle (lots de 2 sources)...");

        $chunks = array_chunk($activeSources, 2);
        $binary = \Illuminate\Console\Application::formatCommandString('invoke-serialized-closure');

        foreach ($chunks as $chunkIndex => $chunk) {
            $this->info("Traitement du lot " . ($chunkIndex + 1) . "/" . count($chunks) . " (" . implode(', ', $chunk) . ")...");
            
            $pool = \Illuminate\Support\Facades\Process::pool(function ($pool) use ($chunk, $jobId, $totalSources, $activeSources, $binary) {
                foreach ($chunk as $source) {
                    $index = array_search($source, $activeSources);
                    $task = static fn() => (new \App\Services\StandaloneScraperRunner())->run($source, $jobId, $index + 1, $totalSources);
                    
                    $pool->as($source)
                        ->path(base_path())
                        ->timeout(600) // 10 minutes par source
                        ->env([
                            'LARAVEL_INVOKABLE_CLOSURE' => base64_encode(serialize(new \Laravel\SerializableClosure\SerializableClosure($task))),
                        ])
                        ->command($binary);
                }
            });

            $responses = $pool->start()->wait();

            foreach ($responses as $source => $response) {
                if ($response->failed()) {
                    $this->error("✗ Erreur sur {$source}: " . ($response->errorOutput() ?: "Timeout ou erreur inconnue"));
                    $results[] = 0;
                    continue;
                }

                $output = json_decode($response->output(), true);
                if ($output && $output['successful']) {
                    $count = unserialize($output['result']);
                    $results[] = (int) $count;
                    $this->info("✓ {$source}: {$count} offres trouvées");
                } else {
                    $errorMsg = $output['message'] ?? 'Erreur inconnue';
                    $this->error("✗ Erreur sur {$source}: {$errorMsg}");
                    $results[] = 0;
                }
            }
        }

        $totalFoundGlobal = array_sum($results);

        // Appliquer les filtres si demandé
        if ($this->option('apply-filters')) {
            $progressService->updateSource($jobId, 'Application des filtres', $totalSources);
            $this->applyFiltering();
        }

        // Marquer comme terminé dans l'UI
        $progressService->complete($jobId);

        $this->info('=== TERMINÉ ===');
        $this->info("Total offres récupérées: {$totalFoundGlobal}");

        return Command::SUCCESS;
    }

    private function getScraperForSource(string $source)
    {
        return match ($source) {
            'AFD' => app(AFDScraperService::class),
            'African Development Bank' => app(AfDBScraperService::class),
            'World Bank' => app(WorldBankScraperService::class),
            'DGMarket' => app(DGMarketScraperService::class),
            'BDEAC' => app(BDEACScraperService::class),
            'IFAD' => app(IFADScraperService::class),
            default => null,
        };
    }

    /**
     * Affiche les détails des filtres actifs pour chaque source
     */
    private function displayFilters(array $activeSources): void
    {
        $this->info('=== FILTRES ACTIFS PAR SOURCE ===');
        $this->newLine();

        foreach ($activeSources as $source) {
            $rules = FilteringRule::with(['countries', 'activityPoles.keywords'])
                ->where('source', $source)
                ->where('is_active', true)
                ->get();

            if ($rules->isEmpty()) {
                continue;
            }

            $this->line("📋 <fg=cyan>{$source}</>");

            foreach ($rules as $rule) {
                $this->line("   Règle: <fg=yellow>{$rule->name}</>");

                // Type de marché
                if (!empty($rule->market_type)) {
                    $marketTypeLabel = $rule->market_type === 'bureau_d_etude' ? 'Bureau d\'études' : 'Consultant individuel';
                    $this->line("   • Type de marché: <fg=green>{$marketTypeLabel}</>");
                }

                // Pays
                if ($rule->countries->isNotEmpty()) {
                    $countries = $rule->countries->pluck('country')->toArray();
                    $this->line("   • Pays autorisés: <fg=green>" . implode(', ', $countries) . "</>");
                }

                // Mots-clés des pôles d'activité
                if ($rule->activityPoles->isNotEmpty()) {
                    $keywords = [];
                    foreach ($rule->activityPoles as $activityPole) {
                        $poleKeywords = $activityPole->keywords->pluck('keyword')->toArray();
                        $keywords = array_merge($keywords, $poleKeywords);
                    }
                    if (!empty($keywords)) {
                        $this->line("   • Mots-clés requis: <fg=green>" . implode(', ', array_unique($keywords)) . "</>");
                    }
                }

                // Si aucun filtre spécifique
                if (empty($rule->market_type) && $rule->countries->isEmpty() && $rule->activityPoles->isEmpty()) {
                    $this->line("   • <fg=yellow>Aucun filtre spécifique (toutes les offres acceptées)</>");
                }
            }

            $this->newLine();
        }
    }

    /**
     * Applique le filtrage et supprime les offres non conformes
     */
    private function applyFiltering(): void
    {
        $filteringService = app(OfferFilteringService::class);

        $this->info('Récupération de toutes les offres...');
        $allOffres = \App\Models\Offre::all();
        $countBefore = $allOffres->count();
        $this->info("Total d'offres avant filtrage: {$countBefore}");

        $this->info('Application des filtres...');
        $filteredOffres = $filteringService->filterOffers($allOffres);
        $countAfter = $filteredOffres->count();
        $countRejected = $countBefore - $countAfter;

        $this->info("Offres conformes aux filtres: {$countAfter}");
        $this->info("Offres rejetées: {$countRejected}");

        if ($countRejected > 0) {
            $this->info('Suppression des offres non conformes...');

            // Récupérer les IDs des offres à garder
            $keepIds = $filteredOffres->pluck('id')->toArray();

            // Supprimer les offres qui ne sont pas dans la liste à garder
            $deleted = \App\Models\Offre::whereNotIn('id', $keepIds)->delete();

            $this->info("✓ {$deleted} offres non conformes supprimées");
        } else {
            $this->info('✓ Toutes les offres sont conformes aux filtres');
        }
    }
}


