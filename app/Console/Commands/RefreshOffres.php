<?php

namespace App\Console\Commands;

use App\Services\ScraperHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RefreshOffres extends Command
{
    protected $signature = 'app:refresh-offres';
    protected $description = 'Vide la table des offres et relance le scraping des sources actives';

    public function handle()
    {
        $this->info('=== VIDAGE ET RE-SCRAPING DES OFFRES ===');
        $this->newLine();

        // Étape 1: Vider la table
        $this->info('📋 Étape 1: Vidage de la table offres...');
        try {
            $countBefore = DB::table('offres')->count();
            
            // Vider dans la connexion par défaut
            DB::statement('DELETE FROM offres');
            $this->info("✓ {$countBefore} offres supprimées de la table");
            
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
                $this->info('✓ Table vidée dans MySQL également');
            } catch (\Exception $e) {
                // MySQL non disponible ou déjà vidé, ignorer
            }
            
            $this->newLine();
        } catch (\Exception $e) {
            $this->error('✗ Erreur lors du vidage: ' . $e->getMessage());
            return Command::FAILURE;
        }

        // Étape 2: Vérifier les sources actives
        $this->info('📋 Étape 2: Vérification des sources actives...');
        $activeSources = ScraperHelper::getActiveSources();
        
        if (empty($activeSources)) {
            $this->warn('⚠ Aucune règle de filtrage active trouvée.');
            $this->info('💡 Activez au moins une règle de filtrage dans l\'admin avant de lancer le scraping.');
            return Command::FAILURE;
        }
        
        $this->info('✓ Sources actives détectées: ' . implode(', ', $activeSources));
        $this->newLine();

        // Étape 3: Lancer le scraping
        $this->info('📋 Étape 3: Lancement du scraping...');
        $this->info('⏳ Cela peut prendre plusieurs minutes car le scraper AfDB visite chaque page de détail pour extraire les vraies dates limites.');
        $this->newLine();

        try {
            $exitCode = Artisan::call('app:scrape-active-sources');
            
            if ($exitCode === 0) {
                $this->newLine();
                $this->info('=== ✅ SCRAPING TERMINÉ AVEC SUCCÈS ===');
                
                $countAfter = DB::table('offres')->count();
                $this->info("📊 Total d'offres dans la base: {$countAfter}");
                
                return Command::SUCCESS;
            } else {
                $this->newLine();
                $this->warn('⚠ Le scraping s\'est terminé avec des erreurs (code: ' . $exitCode . ')');
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error('✗ Erreur lors du scraping: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}




