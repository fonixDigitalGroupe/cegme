<?php

namespace App\Console\Commands;

use App\Services\IFADScraperService;
use App\Services\ScraperHelper;
use Illuminate\Console\Command;

class ScrapeIFAD extends Command
{
    protected $signature = 'app:scrape-ifad {--force : Forcer le scraping même si aucune règle active}';
    protected $description = 'Scrape IFAD procurement notices from UNGM (uniquement si une règle active existe)';

    public function handle(IFADScraperService $scraper)
    {
        $source = 'IFAD';
        
        // Vérifier si une règle active existe pour cette source
        if (!$this->option('force') && !ScraperHelper::hasActiveRule($source)) {
            $this->warn("⚠ Aucune règle de filtrage active trouvée pour la source '{$source}'.");
            $this->info("💡 Le scraping ne sera pas exécuté. Activez une règle de filtrage dans l'admin ou utilisez --force pour forcer le scraping.");
            return Command::FAILURE;
        }

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

