<?php

namespace App\Console\Commands;

use App\Services\WorldBankScraperService;
use App\Services\ScraperHelper;
use Illuminate\Console\Command;

class ScrapeWorldBank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape-world-bank {--force : Forcer le scraping même si aucune règle active} {--job-id= : ID du job pour le suivi de progression}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape World Bank procurement notices (uniquement si une règle active existe)';

    /**
     * Execute the console command.
     */
    public function handle(WorldBankScraperService $scraper)
    {
        $source = 'World Bank';

        if ($this->option('job-id')) {
            $scraper->setJobId($this->option('job-id'));
        }

        // Vérifier si une règle active existe pour cette source
        if (!$this->option('force') && !ScraperHelper::hasActiveRule($source)) {
            $this->warn("⚠ Aucune règle de filtrage active trouvée pour la source '{$source}'.");
            $this->info("💡 Le scraping ne sera pas exécuté. Activez une règle de filtrage dans l'admin ou utilisez --force pour forcer le scraping.");
            return Command::FAILURE;
        }

        $this->info('Début du scraping des appels d\'offres World Bank...');

        try {
            $result = $scraper->scrape();
            $count = $result['count'];
            $stats = $result['stats'];

            $this->info("\n=== RÉSUMÉ DU SCRAPING WORLD BANK ===");
            $this->info("Nombre total de pages parcourues: {$stats['total_pages_scraped']}");
            $this->info("Nombre total de notices trouvées: {$stats['total_notices_found']}");
            $this->info("Nombre total de notices conservées: {$stats['total_notices_kept']}");
            $this->info("Nombre total de notices exclues: {$stats['total_notices_excluded']}");

            $totalInDB = \App\Models\Offre::count();
            $this->info("\nTotal d'offres dans la base de données: {$totalInDB}");

            if ($count > 0) {
                $this->info("\n✓ {$count} nouveaux appels d'offres récupérés depuis World Bank");
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
