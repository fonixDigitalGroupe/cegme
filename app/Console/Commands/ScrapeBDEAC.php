<?php

namespace App\Console\Commands;

use App\Services\BDEACScraperService;
use Illuminate\Console\Command;

class ScrapeBDEAC extends Command
{
    protected $signature = 'app:scrape-bdeac';
    protected $description = 'Scrape BDEAC procurement notices';

    public function handle(BDEACScraperService $scraper)
    {
        $this->info('Début du scraping des appels d\'offres BDEAC...');
        
        try {
            $result = $scraper->scrape();
            $count = $result['count'];
            $stats = $result['stats'];
            
            $this->info("\n=== RÉSUMÉ DU SCRAPING BDEAC ===");
            $this->info("Nombre total de pages parcourues: {$stats['total_pages_scraped']}");
            $this->info("Nombre total de notices conservées: {$stats['total_notices_kept']}");
            
            $totalInDB = \App\Models\Offre::where('source', 'BDEAC')->count();
            $this->info("\nTotal d'offres BDEAC dans la base de données: {$totalInDB}");
            
            if ($count > 0) {
                $this->info("\n✓ {$count} nouveaux appels d'offres récupérés depuis BDEAC");
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








