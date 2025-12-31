<?php

namespace App\Console\Commands;

use App\Services\DGMarketScraperService;
use Illuminate\Console\Command;

class ScrapeDGMarket extends Command
{
    protected $signature = 'app:scrape-dgmarket';
    protected $description = 'Scrape DGMarket procurement notices for African countries';

    public function handle(DGMarketScraperService $scraper)
    {
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








