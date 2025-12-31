<?php

namespace App\Console\Commands;

use App\Services\ScraperHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ScrapeActiveSources extends Command
{
    protected $signature = 'app:scrape-active-sources {--no-truncate : Ne pas vider la table avant le scraping}';
    protected $description = 'Lancer le scraping uniquement pour les sources avec des règles actives (vide la table avant)';

    /**
     * Mapping des sources vers leurs commandes de scraping
     */
    private $sourceCommands = [
        'AFD' => 'scrape:afd',
        'African Development Bank' => 'app:scrape-afdb',
        'World Bank' => 'app:scrape-world-bank',
        'DGMarket' => 'app:scrape-dgmarket',
        'BDEAC' => 'app:scrape-bdeac',
        'IFAD' => 'app:scrape-ifad',
        'TED' => 'app:scrape-ted',
    ];

    public function handle()
    {
        $this->info('=== SCRAPING DES SOURCES ACTIVES ===');
        $this->newLine();

        // Vider la table avant le scraping (sauf si --no-truncate est spécifié)
        if (!$this->option('no-truncate')) {
            $this->info('Vidage de la table offres...');
            $countBefore = DB::table('offres')->count();
            
            // Vider dans toutes les connexions possibles
            try {
                DB::statement('DELETE FROM offres');
                $this->info("✓ {$countBefore} offres supprimées de la table");
            } catch (\Exception $e) {
                $this->warn('⚠ Erreur lors du vidage: ' . $e->getMessage());
            }
            
            // Si SQLite, réinitialiser le compteur auto
            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                try {
                    DB::statement('DELETE FROM sqlite_sequence WHERE name="offres"');
                } catch (\Exception $e) {
                    // Ignorer si la table n'existe pas
                }
            }
            
            // Vider aussi dans MySQL si disponible
            try {
                DB::connection('mysql')->statement('TRUNCATE TABLE offres');
            } catch (\Exception $e) {
                // MySQL non disponible ou déjà vidé, ignorer
            }
            
            $this->newLine();
        } else {
            $this->info('⚠ Mode --no-truncate : la table ne sera pas vidée');
            $this->newLine();
        }

        // Récupérer les sources actives
        $activeSources = ScraperHelper::getActiveSources();

        if (empty($activeSources)) {
            $this->warn('⚠ Aucune règle de filtrage active trouvée.');
            $this->info('💡 Activez au moins une règle de filtrage dans l\'admin avant de lancer le scraping.');
            return Command::FAILURE;
        }

        $this->info('Sources actives détectées: ' . implode(', ', $activeSources));
        $this->newLine();

        $successCount = 0;
        $failCount = 0;

        foreach ($activeSources as $source) {
            if (!isset($this->sourceCommands[$source])) {
                $this->warn("⚠ Aucune commande de scraping trouvée pour la source: {$source}");
                continue;
            }

            $command = $this->sourceCommands[$source];
            $this->info("--- Scraping de: {$source} ---");
            $this->line("Commande: php artisan {$command}");
            $this->newLine();

            try {
                $exitCode = Artisan::call($command);
                
                if ($exitCode === 0) {
                    $this->info("✓ Scraping de {$source} terminé avec succès");
                    $successCount++;
                } else {
                    $this->warn("⚠ Scraping de {$source} terminé avec des erreurs (code: {$exitCode})");
                    $failCount++;
                }
            } catch (\Exception $e) {
                $this->error("✗ Erreur lors du scraping de {$source}: " . $e->getMessage());
                $failCount++;
            }

            $this->newLine();
        }

        // Résumé
        $this->info('=== RÉSUMÉ ===');
        $this->info("Sources scrapées avec succès: {$successCount}");
        if ($failCount > 0) {
            $this->warn("Sources en erreur: {$failCount}");
        }

        return $failCount === 0 ? Command::SUCCESS : Command::FAILURE;
    }
}

