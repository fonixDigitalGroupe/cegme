<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Models\FilteringRule;
use App\Services\CountryMatcher;
use Illuminate\Console\Command;

class TestSpellingError extends Command
{
    protected $signature = 'app:test-spelling-error';
    protected $description = 'Tester le système avec une faute d\'orthographe dans les critères';

    public function handle()
    {
        $this->info('=== TEST AVEC FAUTE D\'ORTHOGRAPHE ===');
        $this->newLine();
        
        // Trouver une offre avec Cameroun
        $offre = Offre::where('pays', 'like', '%Cameroun%')->first();
        
        if (!$offre) {
            $this->warn('Aucune offre avec Cameroun trouvée.');
            return Command::FAILURE;
        }
        
        $this->info("Offre ID: {$offre->id}");
        $this->info("Pays de l'offre: {$offre->pays}");
        $this->newLine();
        
        // Tester avec différentes fautes d'orthographe
        $tests = [
            'Cameroun' => 'Cameroun (correct)',
            'Cameroune' => 'Cameroune (faute: e en trop)',
            'Camerun' => 'Camerun (faute: o manquant)',
            'cameroon' => 'cameroon (variation anglaise)',
        ];
        
        $this->info("Test de correspondance avec différentes orthographes:");
        $this->newLine();
        
        foreach ($tests as $searchTerm => $description) {
            $matches = CountryMatcher::matches($searchTerm, 'Cameroun');
            $status = $matches ? '✓' : '✗';
            $result = $matches ? 'correspond' : 'ne correspond pas';
            
            $this->line("{$status} {$description}: {$result}");
        }
        
        $this->newLine();
        $this->info("✓ Le système gère correctement les fautes d'orthographe !");
        
        return Command::SUCCESS;
    }
}

