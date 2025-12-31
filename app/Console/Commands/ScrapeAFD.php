<?php

namespace App\Console\Commands;

use App\Services\AFDScraperService;
use App\Services\ScraperHelper;
use Illuminate\Console\Command;

class ScrapeAFD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:afd {--force : Forcer le scraping même si aucune règle active}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape les appels à projets depuis le site AFD (uniquement si une règle active existe)';

    /**
     * Execute the console command.
     */
    public function handle(AFDScraperService $scraper)
    {
        $source = 'AFD';
        
        // Vérifier si une règle active existe pour cette source
        if (!$this->option('force') && !ScraperHelper::hasActiveRule($source)) {
            $this->warn("⚠ Aucune règle de filtrage active trouvée pour la source '{$source}'.");
            $this->info("💡 Le scraping ne sera pas exécuté. Activez une règle de filtrage dans l'admin ou utilisez --force pour forcer le scraping.");
            return Command::FAILURE;
        }

        $this->info('Début du scraping des appels à projets AFD...');

        try {
            $result = $scraper->scrape();
            $count = $result['count'];
            $stats = $result['stats'];

            // Afficher les statistiques détaillées
            $this->info("\n=== RÉSUMÉ DU SCRAPING AFD ===");
            $this->info("Nombre total de pages parcourues: {$stats['total_pages']}");
            $this->info("Nombre total d'offres récupérées: {$stats['total_offres']}");
            
            if ($stats['total_pages'] > 0) {
                $this->info("\n--- Détails par page ---");
                foreach ($stats['offres_par_page'] as $pageNum => $offresCount) {
                    $this->line("  Page {$pageNum}: {$offresCount} offre(s)");
                }
            }
            
            $totalInDB = \App\Models\Offre::count();
            $this->info("\nTotal d'offres dans la base de données: {$totalInDB}");
            
            if ($count > 0) {
                $this->info("\n✓ {$count} nouveaux appels d'offres récupérés depuis AFD");
            } else {
                $this->warn("\n⚠ Aucun nouvel appel d'offres trouvé (tous existent déjà).");
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erreur lors du scraping: " . $e->getMessage());
            $this->error("Trace: " . $e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}

