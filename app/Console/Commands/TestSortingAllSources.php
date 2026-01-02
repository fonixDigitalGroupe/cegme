<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;

class TestSortingAllSources extends Command
{
    protected $signature = 'app:test-sorting-all-sources';
    protected $description = 'Tester que le tri par date limite fonctionne sur toutes les sources';

    public function handle(OfferFilteringService $filteringService)
    {
        $this->info('=== TEST DU TRI PAR DATE LIMITE (TOUTES SOURCES) ===');
        $this->newLine();
        
        // Récupérer toutes les offres (comme dans le contrôleur)
        $allOffres = Offre::where('source', '!=', 'DGMarket')->get();
        
        // Appliquer le filtrage
        $filteredOffres = $filteringService->filterOffers($allOffres);
        
        $this->info("Total offres filtrées: {$filteredOffres->count()}");
        
        // Regrouper par source pour afficher
        $bySource = $filteredOffres->groupBy('source');
        foreach ($bySource as $source => $offres) {
            $this->line("  - {$source}: {$offres->count()} offres");
        }
        $this->newLine();
        
        // Trier par date limite (comme dans le contrôleur) - TOUTES SOURCES MÊLÉES
        $sortedOffres = $filteredOffres->sortBy(function ($offre) {
            return $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : '9999-12-31';
        });
        
        $this->info("=== PREMIÈRES 15 OFFRES TRIÉES (TOUTES SOURCES MÊLÉES) ===");
        $this->info("Les offres sont triées par date limite, peu importe la source");
        $this->newLine();
        
        foreach ($sortedOffres->values()->take(15) as $index => $offre) {
            $dateStr = $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : 'N/A (en dernier)';
            $this->line(($index + 1) . ". [{$dateStr}] {$offre->source} - ID {$offre->id}");
            $this->line("   " . substr($offre->titre ?? 'N/A', 0, 60) . '...');
            if (isset($offre->filtered_pays)) {
                $this->line("   Pays: " . ($offre->filtered_pays ?? 'N/A'));
            }
            $this->newLine();
        }
        
        // Vérifier que le tri est correct (dates croissantes)
        $dates = $sortedOffres->values()->map(function($offre) {
            return $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : '9999-12-31';
        })->take(10)->toArray();
        
        $this->info("=== VÉRIFICATION DU TRI ===");
        $this->line("Dates des 10 premières offres:");
        foreach ($dates as $i => $date) {
            $this->line("  " . ($i + 1) . ". {$date}");
        }
        
        $isSorted = true;
        for ($i = 0; $i < count($dates) - 1; $i++) {
            if ($dates[$i] > $dates[$i + 1]) {
                $isSorted = false;
                break;
            }
        }
        
        $this->newLine();
        if ($isSorted) {
            $this->info("✓ Le tri est correct : les dates sont en ordre croissant (les plus proches en premier)");
        } else {
            $this->error("✗ Le tri n'est pas correct");
        }
        $this->newLine();
        
        return Command::SUCCESS;
    }
}




