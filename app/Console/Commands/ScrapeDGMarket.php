<?php

namespace App\Console\Commands;

use App\Services\DGMarketScraperService;
use App\Services\ScraperHelper;
use Illuminate\Console\Command;

class ScrapeDGMarket extends Command
{
    protected $signature = 'app:scrape-dgmarket {--force : Forcer le scraping même si aucune règle active}';
    protected $description = 'Scrape DGMarket procurement notices for African countries (uniquement si une règle active existe)';

    public function handle(DGMarketScraperService $scraper)
    {
        $source = 'DGMarket';
        
        // Vérifier si une règle active existe pour cette source
        if (!$this->option('force') && !ScraperHelper::hasActiveRule($source)) {
            $this->warn("⚠ Aucune règle de filtrage active trouvée pour la source '{$source}'.");
            $this->info("💡 Le scraping ne sera pas exécuté. Activez une règle de filtrage dans l'admin ou utilisez --force pour forcer le scraping.");
            return Command::FAILURE;
        }

        $this->info('Début du scraping des appels d\'offres DGMarket pour l\'Afrique...');
        
        try {
            $result = $scraper->scrape();
            $count = $result['count'];
            $stats = $result['stats'];
            
            $this->info("\n=== RÉSUMÉ DU SCRAPING DGMARKET ===");
            $this->info("Nombre total de pages parcourues: {$stats['total_pages_scraped']}");
            $this->info("Nombre total de notices conservées: {$stats['total_notices_kept']}");
            
            $totalInDB = \App\Models\Offre::where('source', 'DGMarket')->count();
            $this->info("\nTotal d'offres DGMarket dans la base de données: {$totalInDB}");
            
            if ($count > 0) {
                $this->info("\n✓ {$count} nouveaux appels d'offres récupérés depuis DGMarket");
            } else {
                $this->warn("\n⚠ Aucun nouvel appel d'offres trouvé.");
            }
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erreur lors du scraping: " . $e->getMessage());
            $this->error("Trace: " . $e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}












