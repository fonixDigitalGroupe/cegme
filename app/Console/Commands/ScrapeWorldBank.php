<?php

namespace App\Console\Commands;

use App\Services\WorldBankScraperService;
use Illuminate\Console\Command;

class ScrapeWorldBank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape-world-bank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape World Bank procurement notices';

    /**
     * Execute the console command.
     */
    public function handle(WorldBankScraperService $scraper)
    {
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
