<?php

namespace App\Console\Commands;

use App\Models\FilteringRule;
use App\Services\OfferFilteringService;
use App\Services\ScraperHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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

        $totalFoundGlobal = 0;

        foreach ($activeSources as $index => $source) {
            $currentSourceNum = $index + 1;
            $this->info("--- Démarrage: {$source} ({$currentSourceNum}/" . count($activeSources) . ") ---");

            // Mettre à jour la progression UI
            $progressService->updateSource($jobId, $source, $currentSourceNum);

            try {
                $scraper = $this->getScraperForSource($source);

                if (!$scraper) {
                    $this->warn("⚠ Aucun scraper disponible pour {$source}");
                    $progressService->markSourceFailed($jobId, $source, "Scraper non trouvé");
                    continue;
                }

                if (!($scraper instanceof IterativeScraperInterface)) {
                    // Fallback pour les scrapers non itératifs (s'il y en a)
                    $this->warn("⚠ {$source} ne supporte pas le mode itératif strict. Exécution standard...");
                    $result = $scraper->scrape();
                    $count = $result['count'] ?? 0;
                    $this->info("✓ Terminé: {$count} offres traitées (Standard)");
                    $totalFoundGlobal += $count;
                    $progressService->markSourceCompleted($jobId, $source, $count);
                    continue;
                }

                // Initialisation
                $scraper->setJobId($jobId);
                $scraper->initialize();

                $foundCount = 0;
                $lotCount = 0;
                $maxLots = 50; // Sécurité ~500 items
                $targetOffers = 50; // Objectif Cible
                $hasMore = true;

                $bar = $this->output->createProgressBar($targetOffers);
                $bar->setFormatDefinition('custom', ' %current%/%max% [%bar%] %message%');
                $bar->setFormat('custom');
                $bar->setMessage("Recherche d'offres...");
                $bar->start();

                $emptyBatchCount = 0; // Compteur de lots vides consécutifs
                $maxEmptyBatches = 5; // Si 5 lots consécutifs sans résultat, on passe à la source suivante

                while ($hasMore && $foundCount < $targetOffers && $lotCount < $maxLots) {
                    // Vérifier si annulé via UI
                    if ($progressService->isCancelled($jobId)) {
                        $this->warn('❌ Scraping annulé par l\'utilisateur.');
                        $bar->finish();
                        return Command::SUCCESS;
                    }

                    $lotCount++;
                    // Batch size réduit pour feedback rapide
                    $result = $scraper->scrapeBatch(2);

                    $hasMore = $result['has_more'];
                    $batchFindingsCount = isset($result['findings']) ? count($result['findings']) : 0;
                    $foundCount += $batchFindingsCount;

                    // Mettre à jour les trouvailles en temps réel dans l'UI
                    if (!empty($result['findings'])) {
                        $progressService->addFindings($jobId, $result['findings']);
                    }

                    // Mettre à jour le message de progression UI
                    $progressService->updateProgress($jobId, [
                        'message' => "Scraping de {$source}... {$foundCount} offres trouvées (Lot {$lotCount})",
                        'source_progress' => $foundCount
                    ]);

                    // Vérifier si le lot est vide pour skip si trop long
                    if ($batchFindingsCount === 0) {
                        $emptyBatchCount++;
                        if ($emptyBatchCount >= $maxEmptyBatches) {
                            $this->warn("  ⚠ Aucun résultat après {$emptyBatchCount} tentatives, passage à la source suivante...");
                            break;
                        }
                    } else {
                        $emptyBatchCount = 0;
                    }

                    $bar->advance($batchFindingsCount);
                    $bar->setMessage("Lot {$lotCount}: +{$batchFindingsCount} offres");
                }

                $bar->finish();
                $this->newLine();

                if ($foundCount >= $targetOffers) {
                    $this->info("✓ Objectif atteint ({$foundCount} offres) pour {$source}");
                } elseif (!$hasMore) {
                    $this->info("✓ Source épuisée ({$foundCount} offres trouvées) pour {$source}");
                } else {
                    $this->warn("⚠ Arrêt sécurité après {$lotCount} lots ({$foundCount} offres) pour {$source}");
                }

                $totalFoundGlobal += $foundCount;
                $progressService->markSourceCompleted($jobId, $source, $foundCount);

            } catch (\Exception $e) {
                $this->error("✗ Erreur sur {$source}: " . $e->getMessage());
                $progressService->markSourceFailed($jobId, $source, $e->getMessage());
            }

            $this->newLine();
        }

        // Appliquer les filtres si demandé
        if ($this->option('apply-filters')) {
            $progressService->updateSource($jobId, 'Application des filtres', count($activeSources));
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


