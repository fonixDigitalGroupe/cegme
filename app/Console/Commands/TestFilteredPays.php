<?php

namespace App\Console\Commands;

use App\Models\Offre;
use Illuminate\Console\Command;

class TestFilteredPays extends Command
{
    protected $signature = 'app:test-filtered-pays';
    protected $description = 'Tester l\'affichage des pays filtrés';

    public function handle()
    {
        $this->info('=== TEST DES PAYS FILTRÉS ===');
        $this->newLine();
        
        // Trouver une offre avec plusieurs pays
        $offre = Offre::where('pays', 'like', '%Cameroun%')->first();
        
        if (!$offre) {
            $this->warn('Aucune offre avec Cameroun trouvée.');
            return Command::FAILURE;
        }
        
        $this->info("Offre ID: {$offre->id}");
        $this->info("Titre: " . substr($offre->titre ?? 'N/A', 0, 60) . '...');
        $this->newLine();
        
        $this->info("Pays originaux (tous):");
        $this->line("  {$offre->pays}");
        $this->newLine();
        
        // Tester avec seulement Cameroun
        $this->info("Pays filtrés (critère: Cameroun):");
        $filtered = $offre->getFilteredPays(['Cameroun']);
        $this->line("  " . ($filtered ?? 'Aucun'));
        $this->newLine();
        
        // Tester avec plusieurs pays
        $this->info("Pays filtrés (critère: Cameroun, Togo):");
        $filtered2 = $offre->getFilteredPays(['Cameroun', 'Togo']);
        $this->line("  " . ($filtered2 ?? 'Aucun'));
        
        return Command::SUCCESS;
    }
}




