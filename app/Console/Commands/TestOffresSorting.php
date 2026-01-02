<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;

class TestOffresSorting extends Command
{
    protected $signature = 'app:test-offres-sorting';
    protected $description = 'Tester le tri des offres par date limite de soumission';

    public function handle(OfferFilteringService $filteringService)
    {
        $this->info('=== TEST DU TRI DES OFFRES ===');
        $this->newLine();
        
        // Récupérer les offres
        $allOffres = Offre::where('source', '!=', 'DGMarket')->get();
        
        // Appliquer le filtrage
        $filteredOffres = $filteringService->filterOffers($allOffres);
        
        // Trier par date limite (comme dans le contrôleur)
        $sortedOffres = $filteredOffres->sortBy(function ($offre) {
            return $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : '9999-12-31';
        });
        
        $this->info("Total offres filtrées: {$sortedOffres->count()}");
        $this->newLine();
        $this->info("=== PREMIÈRES 10 OFFRES (triées par date limite) ===");
        $this->newLine();
        
        foreach ($sortedOffres->take(10) as $index => $offre) {
            $dateStr = $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : 'N/A';
            $this->line(($index + 1) . ". Date limite: {$dateStr}");
            $this->line("   Titre: " . substr($offre->titre ?? 'N/A', 0, 60) . '...');
            $this->newLine();
        }
        
        return Command::SUCCESS;
    }
}




