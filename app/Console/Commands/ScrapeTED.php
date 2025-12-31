<?php

namespace App\Console\Commands;

use App\Services\TEDScraperService;
use Illuminate\Console\Command;

class ScrapeTED extends Command
{
    protected $signature = 'app:scrape-ted';
    protected $description = 'Scrape DG Market (TED) procurement notices for African countries';

    public function handle(TEDScraperService $scraper)
    {
        $this->info('Début du scraping des appels d\'offres DG Market (TED) pour l\'Afrique...');
        
        try {
            $result = $scraper->scrape();
            $count = $result['count'];
            $stats = $result['stats'];
            
            $this->info("\n=== RÉSUMÉ DU SCRAPING TED ===");
            $this->info("Nombre total de pages parcourues: {$stats['total_pages_scraped']}");
            $this->info("Nombre total de notices conservées: {$stats['total_notices_kept']}");
            
            $totalInDB = \App\Models\Offre::where('source', 'DG Market (TED)')->count();
            $this->info("\nTotal d'offres TED dans la base de données: {$totalInDB}");
            
            if ($count > 0) {
                $this->info("\n✓ {$count} nouveaux appels d'offres récupérés depuis DG Market (TED)");
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








