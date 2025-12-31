<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\CountryMatcher;
use Illuminate\Console\Command;

class TestTunisiaSpelling extends Command
{
    protected $signature = 'app:test-tunisia-spelling';
    protected $description = 'Tester la correspondance Tunisi vs Tunisie';

    public function handle()
    {
        $this->info('=== TEST CORRESPONDANCE TUNISI vs TUNISIE ===');
        $this->newLine();
        
        // Trouver une offre avec Tunisie
        $offre = Offre::where('pays', 'like', '%Tunisie%')->first();
        
        if (!$offre) {
            $this->warn('Aucune offre avec Tunisie trouvée.');
            // Testons quand même la correspondance
            $this->info('Test de correspondance directe:');
            $matches = CountryMatcher::matches('Tunisi', 'Tunisie');
            $this->line('Tunisi vs Tunisie: ' . ($matches ? '✓ Correspond' : '✗ Ne correspond pas'));
            return Command::SUCCESS;
        }
        
        $this->info("Offre ID: {$offre->id}");
        $this->info("Pays de l'offre: {$offre->pays}");
        $this->newLine();
        
        // Tester la correspondance
        $this->info("Test de correspondance:");
        $matches = CountryMatcher::matches('Tunisi', 'Tunisie');
        $this->line('Tunisi vs Tunisie: ' . ($matches ? '✓ Correspond' : '✗ Ne correspond pas'));
        $this->newLine();
        
        // Tester avec getFilteredPays
        $this->info("Test avec getFilteredPays:");
        $filtered = $offre->getFilteredPays(['Tunisi']);
        $this->line('Critère: Tunisi');
        $this->line('Résultat: ' . ($filtered ?? 'Aucun'));
        
        return Command::SUCCESS;
    }
}

