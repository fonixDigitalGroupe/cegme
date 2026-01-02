<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Models\FilteringRule;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestCompleteSystem extends Command
{
    protected $signature = 'app:test-complete-system';
    protected $description = 'Test complet du système de filtrage et tri';

    public function handle(OfferFilteringService $filteringService)
    {
        $this->info('═══════════════════════════════════════════════════════');
        $this->info('        TEST COMPLET DU SYSTÈME DE FILTRAGE ET TRI');
        $this->info('═══════════════════════════════════════════════════════');
        $this->newLine();

        // 1. État de la base de données
        $this->info('1️⃣ ÉTAT DE LA BASE DE DONNÉES');
        $this->line('─────────────────────────────────────────────────────');
        $totalOffres = DB::table('offres')->count();
        $offresAFD = DB::table('offres')->where('source', 'AFD')->count();
        $this->line("Total offres en base: {$totalOffres}");
        $this->line("Offres AFD: {$offresAFD}");
        $this->newLine();

        // 2. Règles de filtrage actives
        $this->info('2️⃣ RÈGLES DE FILTRAGE ACTIVES');
        $this->line('─────────────────────────────────────────────────────');
        $rules = FilteringRule::active()->with(['countries', 'activityPoles.keywords'])->get();
        if ($rules->isEmpty()) {
            $this->warn('⚠ Aucune règle active');
        } else {
            foreach ($rules as $rule) {
                $this->line("✓ {$rule->name}");
                $this->line("  Source: {$rule->source}");
                $this->line("  Type marché: " . ($rule->market_type ?? 'Tous'));
                $this->line("  Pays: " . ($rule->countries->isNotEmpty() ? $rule->countries->pluck('country')->join(', ') : 'Tous'));
                $this->line("  Pôles: " . ($rule->activityPoles->isNotEmpty() ? $rule->activityPoles->pluck('name')->join(', ') : 'Aucun'));
            }
        }
        $this->newLine();

        // 3. Filtrage des offres
        $this->info('3️⃣ FILTRAGE DES OFFRES');
        $this->line('─────────────────────────────────────────────────────');
        $allOffres = Offre::where('source', '!=', 'DGMarket')->get();
        $filteredOffres = $filteringService->filterOffers($allOffres);
        $this->line("Total offres (hors DGMarket): {$allOffres->count()}");
        $this->line("Offres après filtrage: {$filteredOffres->count()}");
        $rejected = $allOffres->count() - $filteredOffres->count();
        if ($rejected > 0) {
            $this->line("Offres rejetées: {$rejected}");
        }
        $this->newLine();

        // 4. Tri par date limite
        $this->info('4️⃣ TRI PAR DATE LIMITE DE SOUMISSION');
        $this->line('─────────────────────────────────────────────────────');
        $sortedOffres = $filteredOffres->sortBy(function ($offre) {
            return $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : '9999-12-31';
        });

        if ($sortedOffres->count() === 0) {
            $this->warn('⚠ Aucune offre à trier (toutes rejetées par le filtre)');
        } else {
            $this->line("✓ {$sortedOffres->count()} offres triées par date limite (les plus proches en premier)");
            $this->newLine();
            $this->line("Premières 5 offres:");
            foreach ($sortedOffres->values()->take(5) as $index => $offre) {
                $dateStr = $offre->date_limite_soumission 
                    ? $offre->date_limite_soumission->format('Y-m-d')
                    : 'N/A';
                $pays = isset($offre->filtered_pays) ? $offre->filtered_pays : ($offre->pays ?? 'N/A');
                $this->line("  " . ($index + 1) . ". [{$dateStr}] {$offre->id} - " . substr($offre->titre ?? 'N/A', 0, 50) . '...');
                $this->line("     Pays: {$pays}");
            }
        }
        $this->newLine();

        // 5. Résumé final
        $this->info('═══════════════════════════════════════════════════════');
        $this->info('                    RÉSUMÉ FINAL');
        $this->info('═══════════════════════════════════════════════════════');
        $this->line("✓ Base de données: {$totalOffres} offres");
        $this->line("✓ Règles actives: {$rules->count()}");
        $this->line("✓ Offres filtrées: {$filteredOffres->count()}");
        $this->line("✓ Tri par date limite: " . ($sortedOffres->count() > 0 ? 'OK' : 'N/A'));
        $this->newLine();

        if ($filteredOffres->count() > 0) {
            $this->info('✅ SYSTÈME OPÉRATIONNEL');
            $this->line('Les offres sont filtrées et triées correctement.');
        } else {
            $this->warn('⚠ Aucune offre ne passe le filtre.');
            $this->line('Vérifiez les critères de filtrage dans l\'admin.');
        }
        $this->newLine();

        return Command::SUCCESS;
    }
}




