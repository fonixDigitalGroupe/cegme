<?php

namespace App\Console\Commands;

use App\Models\FilteringRule;
use App\Models\Offre;
use Illuminate\Console\Command;

class TestMultipleCountries extends Command
{
    protected $signature = 'app:test-multiple-countries';
    protected $description = 'Tester le filtrage avec plusieurs pays dans les critères';

    public function handle()
    {
        $this->info('=== TEST FILTRAGE AVEC PLUSIEURS PAYS ===');
        $this->newLine();
        
        // Récupérer la règle active
        $rule = FilteringRule::where('is_active', true)->with('countries')->first();
        
        if (!$rule) {
            $this->warn('Aucune règle active trouvée.');
            return Command::FAILURE;
        }
        
        $requiredCountries = $rule->countries->pluck('country')->toArray();
        $this->info("Règle: {$rule->name}");
        $this->info("Source: {$rule->source}");
        $this->info("Pays requis: " . implode(', ', $requiredCountries));
        $this->newLine();
        
        // Récupérer les offres
        $offres = Offre::where('source', $rule->source)->get();
        
        $this->info("=== TEST AVEC PLUSIEURS PAYS ===");
        $this->info("Total offres: {$offres->count()}");
        $this->newLine();
        
        // Simuler le filtrage avec plusieurs pays
        $matches = 0;
        $examples = [];
        
        foreach ($offres as $offre) {
            $offreCountry = $offre->pays ?? null;
            
            if (empty($offreCountry)) {
                continue;
            }
            
            // Vérifier si au moins UN pays correspond
            $matchesAny = false;
            $matchedCountries = [];
            
            foreach ($requiredCountries as $requiredCountry) {
                if (stripos(strtolower($offreCountry), strtolower($requiredCountry)) !== false) {
                    $matchesAny = true;
                    $matchedCountries[] = $requiredCountry;
                    break; // Un seul pays suffit
                }
            }
            
            if ($matchesAny) {
                $matches++;
                if (count($examples) < 5) {
                    $examples[] = [
                        'id' => $offre->id,
                        'titre' => substr($offre->titre ?? 'N/A', 0, 60),
                        'pays_offre' => $offreCountry,
                        'pays_matche' => implode(', ', $matchedCountries)
                    ];
                }
            }
        }
        
        $this->info("=== RÉSULTATS ===");
        $this->info("Offres qui matchent (au moins un pays): {$matches}");
        $this->newLine();
        
        if (!empty($examples)) {
            $this->info("Exemples d'offres qui matchent:");
            foreach ($examples as $example) {
                $this->line("ID {$example['id']}:");
                $this->line("  Titre: {$example['titre']}...");
                $this->line("  Pays de l'offre: {$example['pays_offre']}");
                $this->info("  ✓ Correspond à: {$example['pays_matche']}");
                $this->newLine();
            }
        }
        
        $this->info("✓ Le système accepte une offre si elle contient au moins UN des pays requis");
        
        return Command::SUCCESS;
    }
}




