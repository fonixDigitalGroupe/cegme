<?php

namespace App\Console\Commands;

use App\Models\FilteringRule;
use App\Services\OfferFilteringService;
use App\Services\ScraperHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ScrapeActiveSources extends Command
{
    protected $signature = 'app:scrape-active-sources 
                            {--no-truncate : Ne pas vider la table avant le scraping}
                            {--apply-filters : Appliquer le filtrage après le scraping (supprimer les offres non conformes)}
                            {--show-filters : Afficher les détails des filtres appliqués}';
    protected $description = 'Lancer le scraping uniquement pour les sources avec des règles actives (vide la table avant)';

    /**
     * Mapping des sources vers leurs commandes de scraping
     */
    private $sourceCommands = [
        'AFD' => 'scrape:afd',
        'African Development Bank' => 'app:scrape-afdb',
        'World Bank' => 'app:scrape-world-bank',
        'DGMarket' => 'app:scrape-dgmarket',
        'BDEAC' => 'app:scrape-bdeac',
        'IFAD' => 'app:scrape-ifad',
    ];

    public function handle()
    {
        $this->info('=== SCRAPING DES SOURCES ACTIVES ===');
        $this->newLine();

        // Récupérer les sources actives et leurs règles
        $activeSources = ScraperHelper::getActiveSources();

        if (empty($activeSources)) {
            $this->warn('⚠ Aucune règle de filtrage active trouvée.');
            $this->info('💡 Activez au moins une règle de filtrage dans l\'admin avant de lancer le scraping.');
            return Command::FAILURE;
        }

        // Afficher les filtres si demandé
        if ($this->option('show-filters')) {
            $this->displayFilters($activeSources);
            $this->newLine();
        }

        // Vider la table avant le scraping (sauf si --no-truncate est spécifié)
        if (!$this->option('no-truncate')) {
            $this->info('Vidage de la table offres...');
            $countBefore = DB::table('offres')->count();
            
            // Vider dans toutes les connexions possibles
            try {
                DB::statement('DELETE FROM offres');
                $this->info("✓ {$countBefore} offres supprimées de la table");
            } catch (\Exception $e) {
                $this->warn('⚠ Erreur lors du vidage: ' . $e->getMessage());
            }
            
            // Si SQLite, réinitialiser le compteur auto
            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                try {
                    DB::statement('DELETE FROM sqlite_sequence WHERE name="offres"');
                } catch (\Exception $e) {
                    // Ignorer si la table n'existe pas
                }
            }
            
            // Vider aussi dans MySQL si disponible
            try {
                DB::connection('mysql')->statement('TRUNCATE TABLE offres');
            } catch (\Exception $e) {
                // MySQL non disponible ou déjà vidé, ignorer
            }
            
            $this->newLine();
        } else {
            $this->info('⚠ Mode --no-truncate : la table ne sera pas vidée');
            $this->newLine();
        }

        $this->info('Sources actives détectées: ' . implode(', ', $activeSources));
        $this->newLine();

        $successCount = 0;
        $failCount = 0;

        foreach ($activeSources as $source) {
            if (!isset($this->sourceCommands[$source])) {
                $this->warn("⚠ Aucune commande de scraping trouvée pour la source: {$source}");
                continue;
            }

            $command = $this->sourceCommands[$source];
            $this->info("--- Scraping de: {$source} ---");
            $this->line("Commande: php artisan {$command}");
            $this->newLine();

            try {
                // Utiliser --force car on a déjà vérifié que la source est active
                $exitCode = Artisan::call($command, ['--force' => true]);
                
                if ($exitCode === 0) {
                    $this->info("✓ Scraping de {$source} terminé avec succès");
                    $successCount++;
                } else {
                    $this->warn("⚠ Scraping de {$source} terminé avec des erreurs (code: {$exitCode})");
                    $failCount++;
                }
            } catch (\Exception $e) {
                $this->error("✗ Erreur lors du scraping de {$source}: " . $e->getMessage());
                $failCount++;
            }

            $this->newLine();
        }

        // Résumé du scraping
        $this->info('=== RÉSUMÉ DU SCRAPING ===');
        $this->info("Sources scrapées avec succès: {$successCount}");
        if ($failCount > 0) {
            $this->warn("Sources en erreur: {$failCount}");
        }
        
        $totalOffres = DB::table('offres')->count();
        $this->info("Total d'offres scrapées: {$totalOffres}");
        $this->newLine();

        // Appliquer le filtrage si demandé
        if ($this->option('apply-filters')) {
            $this->info('=== APPLICATION DES FILTRES ===');
            $this->applyFiltering();
            $this->newLine();
        } else {
            $this->comment('💡 Astuce: Utilisez --apply-filters pour supprimer automatiquement les offres non conformes aux filtres.');
            $this->comment('💡 Note: Le filtrage est appliqué automatiquement à l\'affichage, même sans cette option.');
            $this->newLine();
        }

        return $failCount === 0 ? Command::SUCCESS : Command::FAILURE;
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

