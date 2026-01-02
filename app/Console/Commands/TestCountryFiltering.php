<?php

namespace App\Console\Commands;

use App\Models\FilteringRule;
use App\Models\Offre;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;

class TestCountryFiltering extends Command
{
    protected $signature = 'app:test-country-filtering';
    protected $description = 'Tester le filtrage par pays en détail';

    public function handle(OfferFilteringService $filteringService)
    {
        $this->info('=== TEST DU FILTRAGE PAR PAYS ===');
        $this->newLine();
        
        // Récupérer la règle active
        $rule = FilteringRule::where('is_active', true)->with('countries')->first();
        
        if (!$rule) {
            $this->warn('Aucune règle active trouvée.');
            return Command::FAILURE;
        }
        
        $this->info("Règle: {$rule->name}");
        $this->info("Source: {$rule->source}");
        $requiredCountries = $rule->countries->pluck('country')->toArray();
        $this->info("Pays requis: " . implode(', ', $requiredCountries));
        $this->newLine();
        
        // Récupérer les offres AFD
        $offres = Offre::where('source', 'AFD')->get();
        
        $this->info("=== ANALYSE DES OFFRES ===");
        $this->info("Total offres AFD: {$offres->count()}");
        $this->newLine();
        
        $matchesCountry = 0;
        $noCountry = 0;
        $doesNotMatch = 0;
        
        foreach ($offres as $offre) {
            $offreCountry = $offre->pays ?? null;
            
            if (empty($offreCountry)) {
                $noCountry++;
                $this->line("ID {$offre->id}: Pays = N/A (pas de pays)");
                continue;
            }
            
            // Vérifier si le pays de l'offre contient l'un des pays requis
            $matches = false;
            foreach ($requiredCountries as $requiredCountry) {
                if (stripos($offreCountry, $requiredCountry) !== false) {
                    $matches = true;
                    break;
                }
            }
            
            if ($matches) {
                $matchesCountry++;
                $this->info("ID {$offre->id}: ✓ Pays = '{$offreCountry}' (MATCHE)");
            } else {
                $doesNotMatch++;
                $this->warn("ID {$offre->id}: ✗ Pays = '{$offreCountry}' (NE MATCHE PAS)");
            }
        }
        
        $this->newLine();
        $this->info('=== RÉSUMÉ ===');
        $this->info("Offres qui matchent le pays: {$matchesCountry}");
        $this->info("Offres sans pays (N/A): {$noCountry}");
        $this->info("Offres qui ne matchent pas: {$doesNotMatch}");
        
        // Appliquer le filtrage complet
        $this->newLine();
        $this->info('=== RÉSULTAT DU FILTRAGE COMPLET ===');
        $filteredOffres = $filteringService->filterOffers($offres);
        $this->info("Offres après filtrage complet: {$filteredOffres->count()}");
        
        if ($filteredOffres->count() < $offres->count()) {
            $rejected = $offres->count() - $filteredOffres->count();
            $this->warn("⚠ {$rejected} offres ont été rejetées par le filtrage");
        } else {
            $this->info("✓ Toutes les offres passent le filtre");
        }
        
        return Command::SUCCESS;
    }
}




