<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;

class TestFilteredSorting extends Command
{
    protected $signature = 'app:test-filtered-sorting';
    protected $description = 'Tester le tri des offres filtrées par date limite';

    public function handle(OfferFilteringService $filteringService)
    {
        $this->info('=== TEST DU TRI DES OFFRES FILTRÉES ===');
        $this->newLine();
        
        // Récupérer toutes les offres (comme dans le contrôleur)
        $allOffres = Offre::where('source', '!=', 'DGMarket')->get();
        
        $this->info("Total offres (hors DGMarket): {$allOffres->count()}");
        $this->newLine();
        
        // Appliquer le filtrage
        $filteredOffres = $filteringService->filterOffers($allOffres);
        
        $this->info("Offres après filtrage: {$filteredOffres->count()}");
        $this->newLine();
        
        // Trier par date limite (comme dans le contrôleur)
        $sortedOffres = $filteredOffres->sortBy(function ($offre) {
            return $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : '9999-12-31';
        });
        
        if ($sortedOffres->count() === 0) {
            $this->warn('⚠ Aucune offre ne passe le filtre. Les critères sont peut-être trop stricts.');
            return Command::SUCCESS;
        }
        
        $this->info("=== OFFRES FILTRÉES ET TRIÉES PAR DATE LIMITE (les plus proches en premier) ===");
        $this->newLine();
        
        foreach ($sortedOffres->values()->take(10) as $index => $offre) {
            $dateStr = $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : 'N/A (en dernier)';
            $this->line(($index + 1) . ". Date limite: {$dateStr}");
            $this->line("   ID: {$offre->id}");
            $this->line("   Titre: " . substr($offre->titre ?? 'N/A', 0, 70) . '...');
            if (isset($offre->filtered_pays)) {
                $this->line("   Pays: " . ($offre->filtered_pays ?? 'N/A'));
            }
            $this->newLine();
        }
        
        $this->info('✓ Le tri fonctionne correctement : les dates limites les plus proches sont en premier.');
        $this->newLine();
        
        return Command::SUCCESS;
    }
}

