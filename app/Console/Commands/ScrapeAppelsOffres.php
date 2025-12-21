<?php

namespace App\Console\Commands;

use App\Services\AppelOffreScraperService;
use Illuminate\Console\Command;

class ScrapeAppelsOffres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appels-offres:scrape {--config-id= : ID de la configuration spécifique à scraper}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape les appels d\'offres depuis les sites configurés';

    /**
     * Execute the console command.
     */
    public function handle(AppelOffreScraperService $scraper)
    {
        $this->info('Début du scraping des appels d\'offres...');

        $configId = $this->option('config-id');

        if ($configId) {
            $config = \App\Models\AppelOffreConfig::find($configId);
            if (!$config) {
                $this->error("Configuration avec l'ID {$configId} introuvable.");
                return 1;
            }

            $this->info("Scraping depuis: {$config->source_ptf} ({$config->site_officiel})");
            $this->info("Vérification de la connexion au site...");
            
            try {
                $count = $scraper->scrapeFromConfig($config);
                if ($count > 0) {
                    $this->info("✓ {$count} nouveaux appels d'offres récupérés depuis {$config->source_ptf}");
                } else {
                    $this->warn("⚠ Aucun nouvel appel d'offres trouvé. Vérifiez les logs pour plus de détails.");
                    $this->info("Vérifiez que:");
                    $this->line("  - Le site est accessible");
                    $this->line("  - Le site contient des appels d'offres");
                    $this->line("  - La structure HTML du site correspond aux patterns de scraping");
                }
            } catch (\Exception $e) {
                $this->error("Erreur lors du scraping: " . $e->getMessage());
                $this->error("Trace: " . $e->getTraceAsString());
                return 1;
            }
        } else {
            $this->info('Scraping depuis toutes les configurations...');
            $total = $scraper->scrapeAll();
            $this->info("✓ {$total} nouveaux appels d'offres récupérés au total");
        }

        $this->info('Scraping terminé!');
        return 0;
    }
}
