<?php

namespace App\Console\Commands;

use App\Services\IFADScraperService;
use Illuminate\Console\Command;

class ScrapeIFAD extends Command
{
    protected $signature = 'app:scrape-ifad';
    protected $description = 'Scrape IFAD procurement notices from UNGM';

    public function handle(IFADScraperService $scraper)
    {
        $this->info('Début du scraping des appels d\'offres IFAD...');
        
        try {
            $result = $scraper->scrape();
            $count = $result['count'];
            $stats = $result['stats'];
            
            $this->info("\n=== RÉSUMÉ DU SCRAPING IFAD ===");
            $this->info("Stratégie: Liens contextuels vers UNGM (chargement dynamique JS)");
            $this->info("Nombre total de liens contextuels créés: {$stats['total_notices_kept']}");
            
            $totalInDB = \App\Models\Offre::where('source', 'IFAD')->count();
            $this->info("\nTotal d'enregistrements IFAD dans la base de données: {$totalInDB}");
            
            if ($count > 0) {
                $this->info("\n✓ {$count} lien(s) contextuel(s) créé(s) vers UNGM");
                $this->info("Les utilisateurs peuvent consulter les appels d'offres IFAD sur UNGM via le lien de recherche.");
            } else {
                $this->info("\n✓ Lien contextuel déjà présent dans la base de données.");
            }
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Erreur lors du scraping: " . $e->getMessage());
            $this->error("Trace: " . $e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}

