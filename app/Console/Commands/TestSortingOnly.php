<?php

namespace App\Console\Commands;

use App\Models\Offre;
use Illuminate\Console\Command;

class TestSortingOnly extends Command
{
    protected $signature = 'app:test-sorting-only';
    protected $description = 'Tester uniquement le tri par date limite (sans filtrage)';

    public function handle()
    {
        $this->info('=== TEST DU TRI PAR DATE LIMITE ===');
        $this->newLine();
        
        // Récupérer toutes les offres AFD (sans filtrage)
        $offres = Offre::where('source', 'AFD')->get();
        
        $this->info("Total offres AFD: {$offres->count()}");
        $this->newLine();
        
        // Trier par date limite (comme dans le contrôleur)
        $sortedOffres = $offres->sortBy(function ($offre) {
            return $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : '9999-12-31';
        });
        
        $this->info("=== OFFRES TRIÉES PAR DATE LIMITE (les plus proches en premier) ===");
        $this->newLine();
        
        foreach ($sortedOffres->values()->take(10) as $index => $offre) {
            $dateStr = $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : 'N/A (en dernier)';
            $this->line(($index + 1) . ". Date limite: {$dateStr}");
            $this->line("   ID: {$offre->id}");
            $this->line("   Titre: " . substr($offre->titre ?? 'N/A', 0, 60) . '...');
            $this->newLine();
        }
        
        return Command::SUCCESS;
    }
}

