<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Models\FilteringRule;
use Illuminate\Console\Command;

class CheckOffres extends Command
{
    protected $signature = 'offers:check';
    protected $description = 'Vérifier les offres et règles';

    public function handle()
    {
        $this->info('=== VÉRIFICATION DES OFFRES ===');
        $this->newLine();

        $totalOffres = Offre::count();
        $this->info("Total d'offres en base: {$totalOffres}");

        $rulesActive = FilteringRule::where('is_active', true)->count();
        $this->info("Règles actives: {$rulesActive}");

        if ($totalOffres > 0) {
            $this->newLine();
            $this->info('Répartition par source:');
            
            $sources = Offre::select('source')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('source')
                ->get();

            foreach ($sources as $source) {
                $this->line("  {$source->source}: {$source->count}");
            }

            $this->newLine();
            $offresNonDGMarket = Offre::where('source', '!=', 'DGMarket')->count();
            $this->info("Offres (sauf DGMarket): {$offresNonDGMarket}");
        } else {
            $this->warn('Aucune offre en base. Lancez d\'abord les scrapers.');
        }

        return Command::SUCCESS;
    }
}




