<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;

class CheckFilteredOffres extends Command
{
    protected $signature = 'app:check-filtered-offres';
    protected $description = 'Vérifier les offres filtrées et pourquoi elles ne s\'affichent pas';

    public function handle()
    {
        $filteringService = new OfferFilteringService();
        
        // Récupérer toutes les offres sauf DGMarket
        $query = Offre::query()->where('source', '!=', 'DGMarket');
        $allOffres = $query->get();
        
        $this->info("=== ÉTAT DES OFFRES ===");
        $this->info("Total offres (sans DGMarket): {$allOffres->count()}");
        $this->newLine();
        
        // Appliquer le filtrage dynamique
        $filteredOffres = $filteringService->filterOffers($allOffres);
        $this->info("Offres après filtrage (critères): {$filteredOffres->count()}");
        $this->newLine();
        
        // Compter les offres avec date limite
        $withDate = $filteredOffres->filter(function ($offre) {
            return !empty($offre->date_limite_soumission);
        });
        
        $this->info("Offres avec date limite: {$withDate->count()}");
        $this->info("Offres sans date limite: " . ($filteredOffres->count() - $withDate->count()));
        $this->newLine();
        
        if ($withDate->count() === 0 && $filteredOffres->count() > 0) {
            $this->warn("⚠ PROBLÈME: Les offres filtrées n'ont pas de date limite !");
            $this->warn("   C'est pour cela que le tableau est vide.");
            $this->newLine();
            $this->info("Exemples d'offres filtrées (sans date limite):");
            foreach ($filteredOffres->take(5) as $offre) {
                $this->line("  - {$offre->titre} (Source: {$offre->source}, Date: " . ($offre->date_limite_soumission ? $offre->date_limite_soumission->format('Y-m-d') : 'NULL') . ")");
            }
        } elseif ($withDate->count() > 0) {
            $this->info("✓ {$withDate->count()} offres devraient s'afficher dans le tableau");
            $this->newLine();
            $this->info("Exemples d'offres qui devraient s'afficher:");
            foreach ($withDate->take(5) as $offre) {
                $date = is_string($offre->date_limite_soumission) 
                    ? $offre->date_limite_soumission 
                    : $offre->date_limite_soumission->format('Y-m-d');
                $this->line("  - {$offre->titre} (Source: {$offre->source}, Date: {$date})");
            }
        }
        
        return Command::SUCCESS;
    }
}




