<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ForceTruncateOffres extends Command
{
    protected $signature = 'app:force-truncate-offres';
    protected $description = 'Forcer la suppression de toutes les données de la table offres (MySQL et SQLite)';

    public function handle()
    {
        $this->info('=== SUPPRESSION FORCÉE DE LA TABLE OFFRES ===');
        $this->newLine();
        
        // Détecter toutes les connexions disponibles et supprimer dans chacune
        $connections = ['mysql', 'sqlite'];
        $defaultConnection = config('database.default');
        
        if (!in_array($defaultConnection, $connections)) {
            $connections[] = $defaultConnection;
        }
        
        // Ajouter la connexion par défaut en premier pour la traiter
        array_unshift($connections, $defaultConnection);
        $connections = array_unique($connections);
        
        $totalDeleted = 0;
        
        foreach ($connections as $connection) {
            try {
                $count = DB::connection($connection)->table('offres')->count();
                $this->info("--- Connexion: {$connection} ---");
                $this->info("Nombre d'offres avant suppression : {$count}");
                
                if ($count === 0) {
                    $this->info("La table est déjà vide dans {$connection}.");
                    $this->newLine();
                    continue;
                }
                
                $this->deleteFromConnection($connection);
                
                $finalCount = DB::connection($connection)->table('offres')->count();
                $deleted = $count - $finalCount;
                $totalDeleted += $deleted;
                $this->info("Nombre d'offres après suppression : {$finalCount}");
                if ($finalCount === 0) {
                    $this->info("✓ {$deleted} offres supprimées avec succès dans {$connection}!");
                } else {
                    $this->warn("⚠ Il reste encore {$finalCount} offres dans {$connection}.");
                }
                $this->newLine();
            } catch (\Exception $e) {
                $this->warn("Connexion {$connection} non disponible ou erreur: " . $e->getMessage());
                $this->newLine();
            }
        }
        
        $this->info("=== RÉSUMÉ ===");
        $this->info("Total d'offres supprimées: {$totalDeleted}");
        
        return Command::SUCCESS;
    }
    
    private function deleteFromConnection(string $connection)
    {
        $driver = DB::connection($connection)->getDriverName();
        
        // Méthode 1: TRUNCATE pour MySQL
        if ($driver === 'mysql') {
            $this->line('Tentative 1: TRUNCATE (MySQL)...');
            try {
                DB::connection($connection)->statement('TRUNCATE TABLE offres');
                $this->info('✓ TRUNCATE réussi');
                return;
            } catch (\Exception $e) {
                $this->warn('✗ TRUNCATE échoué: ' . $e->getMessage());
            }
        }
        
        // Méthode 2: DELETE FROM (fonctionne pour SQLite et MySQL)
        $this->line('Tentative 2: DELETE FROM...');
        try {
            DB::connection($connection)->statement('DELETE FROM offres');
            $this->info('✓ DELETE FROM réussi');
            
            // Pour SQLite, réinitialiser le compteur auto
            if ($driver === 'sqlite') {
                try {
                    DB::connection($connection)->statement('DELETE FROM sqlite_sequence WHERE name="offres"');
                } catch (\Exception $e) {
                    // Ignorer si la table n'existe pas
                }
            }
            return;
        } catch (\Exception $e) {
            $this->warn('✗ DELETE FROM échoué: ' . $e->getMessage());
        }
        
        // Méthode 3: Via Eloquent avec chunk pour éviter les problèmes de mémoire
        $this->line('Tentative 3: Suppression par chunks...');
        try {
            DB::connection($connection)->table('offres')->chunkById(100, function ($offres) use ($connection) {
                $ids = $offres->pluck('id')->toArray();
                if (!empty($ids)) {
                    DB::connection($connection)->table('offres')->whereIn('id', $ids)->delete();
                }
            });
            $this->info('✓ Suppression par chunks réussie');
        } catch (\Exception $e) {
            $this->warn('✗ Suppression par chunks échouée: ' . $e->getMessage());
        }
    }
}
