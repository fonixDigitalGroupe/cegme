<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Models\FilteringRule;
use Illuminate\Console\Command;

class CheckOffresStatus extends Command
{
    protected $signature = 'app:check-offres-status';
    protected $description = 'Vérifier l\'état des offres dans la base de données';

    public function handle()
    {
        $total = Offre::count();
        $withDate = Offre::whereNotNull('date_limite_soumission')->count();
        $withoutDate = Offre::whereNull('date_limite_soumission')->count();
        $activeRules = FilteringRule::where('is_active', true)->count();
        
        $this->info("=== ÉTAT DE LA BASE DE DONNÉES ===");
        $this->info("Total d'offres: {$total}");
        $this->info("Offres avec date limite: {$withDate}");
        $this->info("Offres sans date limite: {$withoutDate}");
        $this->info("Règles de filtrage actives: {$activeRules}");
        
        if ($total > 0) {
            $this->newLine();
            $this->info("Répartition par source:");
            $sources = Offre::selectRaw('source, COUNT(*) as count')
                ->groupBy('source')
                ->get();
            
            foreach ($sources as $source) {
                $this->line("  - {$source->source}: {$source->count} offres");
            }
        }
        
        if ($withDate === 0 && $total > 0) {
            $this->newLine();
            $this->warn("⚠ ATTENTION: Aucune offre n'a de date limite !");
            $this->warn("   Toutes les offres seront masquées car la date limite est obligatoire.");
        }
        
        return Command::SUCCESS;
    }
}




