<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateOffresMySQL extends Command
{
    protected $signature = 'app:truncate-offres-mysql';
    protected $description = 'Vider la table offres dans MySQL (utilise la connexion mysql)';

    public function handle()
    {
        // Forcer l'utilisation de MySQL si disponible
        $connection = 'mysql';
        
        // Vérifier si la connexion MySQL existe
        try {
            $count = DB::connection($connection)->table('offres')->count();
            $this->info("=== SUPPRESSION DANS MYSQL ===");
            $this->info("Connexion: {$connection}");
            $this->info("Nombre d'offres avant suppression : {$count}");
        } catch (\Exception $e) {
            $this->error("Impossible de se connecter à MySQL: " . $e->getMessage());
            $this->info("Vérifiez votre configuration dans .env");
            return Command::FAILURE;
        }
        
        if ($count === 0) {
            $this->info('La table est déjà vide dans MySQL.');
            return Command::SUCCESS;
        }
        
        // Supprimer toutes les offres
        try {
            DB::connection($connection)->table('offres')->truncate();
            $this->info('✓ TRUNCATE réussi sur MySQL');
        } catch (\Exception $e) {
            // Si truncate échoue, utiliser delete
            try {
                DB::connection($connection)->table('offres')->delete();
                $this->info('✓ DELETE réussi sur MySQL');
            } catch (\Exception $e2) {
                $this->error('✗ Erreur lors de la suppression: ' . $e2->getMessage());
                return Command::FAILURE;
            }
        }
        
        // Vérification finale
        $finalCount = DB::connection($connection)->table('offres')->count();
        $this->info("Nombre d'offres après suppression : {$finalCount}");
        
        if ($finalCount === 0) {
            $this->info('✓ Table offres vidée avec succès dans MySQL !');
            return Command::SUCCESS;
        } else {
            $this->warn("⚠ Il reste encore {$finalCount} offres dans MySQL.");
            return Command::FAILURE;
        }
    }
}




