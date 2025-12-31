<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;

class TestFiltering extends Command
{
    protected $signature = 'app:test-filtering';
    protected $description = 'Tester le filtrage des offres selon les règles actives';

    public function handle(OfferFilteringService $filteringService)
    {
        $this->info('=== TEST DU FILTRAGE DES OFFRES ===');
        $this->newLine();
        
        // Récupérer toutes les offres (sauf DGMarket)
        $allOffres = Offre::where('source', '!=', 'DGMarket')->get();
        
        $this->info("Nombre total d'offres (hors DGMarket): {$allOffres->count()}");
        
        // Grouper par source
        $bySource = $allOffres->groupBy('source');
        foreach ($bySource as $source => $offres) {
            $this->line("  - {$source}: {$offres->count()} offres");
        }
        
        $this->newLine();
        
        // Appliquer le filtrage
        $filteredOffres = $filteringService->filterOffers($allOffres);
        
        $this->info("Nombre d'offres après filtrage: {$filteredOffres->count()}");
        
        // Grouper par source
        $filteredBySource = $filteredOffres->groupBy('source');
        foreach ($filteredBySource as $source => $offres) {
            $this->line("  - {$source}: {$offres->count()} offres");
        }
        
        $this->newLine();
        
        // Détails pour AFD
        if ($allOffres->where('source', 'AFD')->isNotEmpty()) {
            $this->info('=== DÉTAILS AFD ===');
            $afdAll = $allOffres->where('source', 'AFD');
            $afdFiltered = $filteredOffres->where('source', 'AFD');
            
            $this->line("Total AFD: {$afdAll->count()}");
            $this->line("Filtré AFD: {$afdFiltered->count()}");
            
            if ($afdFiltered->count() < $afdAll->count()) {
                $rejected = $afdAll->count() - $afdFiltered->count();
                $this->warn("⚠ {$rejected} offres AFD ont été filtrées (rejetées)");
            } else {
                $this->info("✓ Toutes les offres AFD sont acceptées");
            }
        }
        
        return Command::SUCCESS;
    }
}
