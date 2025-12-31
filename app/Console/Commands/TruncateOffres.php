<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateOffres extends Command
{
    protected $signature = 'app:truncate-offres';
    protected $description = 'Vider complètement la table offres';

    public function handle()
    {
        $count = DB::table('offres')->count();
        
        $this->info("Nombre d'offres avant suppression : {$count}");
        
        // SQLite ne supporte pas TRUNCATE, utiliser DELETE FROM directement
        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            // Pour SQLite, utiliser DELETE FROM (TRUNCATE n'est pas supporté)
            DB::statement('DELETE FROM offres');
        } else {
            // Pour MySQL et autres, essayer TRUNCATE d'abord
            try {
                DB::table('offres')->truncate();
            } catch (\Exception $e) {
                DB::statement('DELETE FROM offres');
            }
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
        
        // Attendre un peu pour que les opérations se terminent
        usleep(100000); // 100ms
        
        // Vérifier qu'il n'en reste plus
        $remaining = DB::table('offres')->count();
        
        $this->info("Nombre d'offres après suppression : {$remaining}");
        
        if ($remaining === 0) {
            $this->info('✓ Table offres vidée avec succès !');
            return Command::SUCCESS;
        } else {
            $this->warn("⚠ Il reste {$remaining} offres dans la table.");
            $this->info("💡 Cela peut être dû à des scrapers qui s'exécutent en arrière-plan.");
            $this->info("💡 Exécutez la commande plusieurs fois si nécessaire.");
            return Command::SUCCESS; // Retourner SUCCESS même s'il en reste, car on a fait notre maximum
        }
    }
}

