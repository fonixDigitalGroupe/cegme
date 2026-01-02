<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class TestOffresDisplay extends Command
{
    protected $signature = 'app:test-offres-display';
    protected $description = 'Tester l\'affichage des offres comme dans le contrôleur';

    public function handle(OfferFilteringService $filteringService)
    {
        $this->info('=== TEST DE L\'AFFICHAGE DES OFFRES ===');
        $this->newLine();
        
        // Simuler exactement ce que fait le contrôleur
        $query = Offre::query()->where('source', '!=', 'DGMarket');
        $allOffres = $query->get();
        
        $this->info("Total offres (hors DGMarket): {$allOffres->count()}");
        
        // Appliquer le filtrage
        $filteredOffres = $filteringService->filterOffers($allOffres);
        
        $this->info("Offres après filtrage: {$filteredOffres->count()}");
        
        // Trier
        $filteredOffres = $filteredOffres->sortBy(function ($offre) {
            return $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : '9999-12-31';
        });
        
        // Créer la pagination (comme dans le contrôleur)
        $currentPage = 1;
        $perPage = 12;
        $offres = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredOffres->values()->forPage($currentPage, $perPage),
            $filteredOffres->count(),
            $perPage,
            $currentPage,
            ['path' => '/offres', 'query' => []]
        );
        
        $this->info("Offres paginées pour la page 1: {$offres->count()}");
        $this->info("Total items: {$offres->total()}");
        $this->info("Per page: {$offres->perPage()}");
        $this->info("Current page: {$offres->currentPage()}");
        $this->info("Has pages: " . ($offres->hasPages() ? 'Oui' : 'Non'));
        $this->newLine();
        
        if ($offres->count() > 0) {
            $this->info("✓ Les offres sont disponibles pour l'affichage");
            $this->newLine();
            $this->info("Premières 5 offres:");
            foreach ($offres->take(5) as $index => $offre) {
                $dateStr = $offre->date_limite_soumission 
                    ? $offre->date_limite_soumission->format('Y-m-d')
                    : 'N/A';
                $this->line(($index + 1) . ". [{$dateStr}] ID {$offre->id}: " . substr($offre->titre ?? 'N/A', 0, 50) . '...');
            }
        } else {
            $this->warn("⚠ Aucune offre à afficher sur la page 1");
        }
        
        return Command::SUCCESS;
    }
}




