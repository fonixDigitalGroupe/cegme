<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class TestOffresPagination extends Command
{
    protected $signature = 'app:test-offres-pagination';
    protected $description = 'Tester la pagination exactement comme dans le contrôleur';

    public function handle(OfferFilteringService $filteringService)
    {
        $this->info('=== TEST DE LA PAGINATION (COMME DANS LE CONTRÔLEUR) ===');
        $this->newLine();
        
        // Récupérer toutes les offres (comme dans le contrôleur)
        $query = Offre::query()->where('source', '!=', 'DGMarket');
        $allOffres = $query->get();
        
        $this->info("Total offres (hors DGMarket): {$allOffres->count()}");
        
        // Appliquer le filtrage
        $filteredOffres = $filteringService->filterOffers($allOffres);
        
        $this->info("Offres après filtrage: {$filteredOffres->count()}");
        
        // Trier (comme dans le contrôleur)
        $filteredOffres = $filteredOffres->sortBy(function ($offre) {
            return $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : '9999-12-31';
        });
        
        // Créer la pagination (exactement comme dans le contrôleur)
        $currentPage = 1;
        $perPage = 12;
        
        // Utiliser values() pour réinitialiser les clés
        $sortedCollection = $filteredOffres->values();
        
        $this->info("Collection après tri et values(): {$sortedCollection->count()}");
        
        // Créer la pagination
        $offres = new \Illuminate\Pagination\LengthAwarePaginator(
            $sortedCollection->forPage($currentPage, $perPage),
            $sortedCollection->count(),
            $perPage,
            $currentPage,
            ['path' => '/appels-offres', 'query' => []]
        );
        
        $this->newLine();
        $this->info("=== RÉSULTATS DE LA PAGINATION ===");
        $this->line("Total items: {$offres->total()}");
        $this->line("Per page: {$offres->perPage()}");
        $this->line("Current page: {$offres->currentPage()}");
        $this->line("Count (items sur cette page): {$offres->count()}");
        $this->line("Has pages: " . ($offres->hasPages() ? 'Oui' : 'Non'));
        $this->line("Is empty: " . ($offres->isEmpty() ? 'Oui' : 'Non'));
        $this->newLine();
        
        if ($offres->count() > 0) {
            $this->info("✓ Les offres sont disponibles pour l'affichage");
            $this->newLine();
            $this->info("Premières 5 offres de la page 1:");
            foreach ($offres->take(5) as $index => $offre) {
                $dateStr = $offre->date_limite_soumission 
                    ? $offre->date_limite_soumission->format('Y-m-d')
                    : 'N/A';
                $this->line(($index + 1) . ". [{$dateStr}] {$offre->source} - ID {$offre->id}");
                $this->line("   " . substr($offre->titre ?? 'N/A', 0, 60) . '...');
            }
        } else {
            $this->error("✗ AUCUNE OFFRE SUR LA PAGE 1");
            $this->newLine();
            $this->warn("Problème détecté ! Vérifiez le code de pagination.");
        }
        
        return Command::SUCCESS;
    }
}




