<?php

namespace App\Console\Commands;

use App\Models\FilteringRule;
use App\Models\Offre;
use Illuminate\Console\Command;

class TestStrictFiltering extends Command
{
    protected $signature = 'app:test-strict-filtering';
    protected $description = 'Tester le filtrage strict (type de marché + pays)';

    public function handle()
    {
        $this->info('=== TEST DU FILTRAGE STRICT ===');
        $this->newLine();
        
        // Récupérer la règle active
        $rule = FilteringRule::where('is_active', true)->with(['countries', 'activityPoles.keywords'])->first();
        
        if (!$rule) {
            $this->warn('Aucune règle active trouvée.');
            return Command::FAILURE;
        }
        
        $this->info("Règle: {$rule->name}");
        $this->info("Source: {$rule->source}");
        $this->info("Type de marché: " . ($rule->market_type ?? 'Tous'));
        $requiredCountries = $rule->countries->pluck('country')->toArray();
        $this->info("Pays requis: " . implode(', ', $requiredCountries));
        $this->newLine();
        
        // Récupérer les offres
        $offres = Offre::where('source', $rule->source)->get();
        
        $this->info("=== ANALYSE DÉTAILLÉE ===");
        $this->info("Total offres: {$offres->count()}");
        $this->newLine();
        
        $matches = 0;
        $rejected = 0;
        
        foreach ($offres as $offre) {
            $marketTypeMatch = true;
            $countryMatch = true;
            $reason = [];
            
            // Vérifier le type de marché
            if (!empty($rule->market_type)) {
                $text = strtolower(($offre->titre ?? '') . ' ' . ($offre->acheteur ?? ''));
                
                if ($rule->market_type === 'bureau_d_etude') {
                    $keywords = ['bureau d\'étude', 'bureau d\'études', 'cabinet d\'études', 'consulting', 'étude', 'études'];
                    $marketTypeMatch = false;
                    foreach ($keywords as $keyword) {
                        if (stripos($text, $keyword) !== false) {
                            $marketTypeMatch = true;
                            break;
                        }
                    }
                    if (!$marketTypeMatch) {
                        $reason[] = 'Type de marché ne correspond pas';
                    }
                }
            }
            
            // Vérifier le pays
            if (!empty($requiredCountries)) {
                $offreCountry = $offre->pays ?? null;
                
                if (empty($offreCountry)) {
                    $countryMatch = false;
                    $reason[] = 'Pas de pays (N/A)';
                } else {
                    $countryMatch = false;
                    foreach ($requiredCountries as $requiredCountry) {
                        if (stripos(strtolower($offreCountry), strtolower($requiredCountry)) !== false) {
                            $countryMatch = true;
                            break;
                        }
                    }
                    if (!$countryMatch) {
                        $reason[] = "Pays ne correspond pas ({$offreCountry})";
                    }
                }
            }
            
            // Accepter seulement si TOUS les critères correspondent
            if ($marketTypeMatch && $countryMatch) {
                $matches++;
                $this->info("✓ ID {$offre->id}: Acceptée");
                $this->line("  Titre: " . substr($offre->titre ?? 'N/A', 0, 60) . '...');
                if ($offre->pays) {
                    $this->line("  Pays: {$offre->pays}");
                }
            } else {
                $rejected++;
                $this->warn("✗ ID {$offre->id}: Rejetée - " . implode(', ', $reason));
                $this->line("  Titre: " . substr($offre->titre ?? 'N/A', 0, 60) . '...');
            }
        }
        
        $this->newLine();
        $this->info('=== RÉSUMÉ ===');
        $this->info("Offres qui passent le filtre strict: {$matches}");
        $this->warn("Offres rejetées: {$rejected}");
        
        return Command::SUCCESS;
    }
}




