<?php

namespace App\Console\Commands;

use App\Services\CountryMatcher;
use Illuminate\Console\Command;

class TestCountryMatching extends Command
{
    protected $signature = 'app:test-country-matching';
    protected $description = 'Tester la correspondance de pays avec tolérance aux fautes d\'orthographe';

    public function handle()
    {
        $this->info('=== TEST DE CORRESPONDANCE DE PAYS ===');
        $this->newLine();

        $testCases = [
            ['Cameroun', 'Cameroun', true],
            ['Cameroun', 'Cameroune', true], // Faute d'orthographe
            ['Cameroun', 'Camerun', true], // Faute d'orthographe
            ['Cameroun', 'cameroon', true], // Variation anglaise
            ['Cameroun', 'camerou', true], // Faute
            ['Togo', 'Toggo', true], // Faute
            ['Bénin', 'Benin', true], // Sans accent
            ['Sénégal', 'Senegal', true], // Sans accent
            ['Côte d\'Ivoire', 'Cote d\'Ivoire', true], // Sans accent
            ['Cameroun', 'Rwanda', false], // Pays différents
            ['Cameroun', 'Cameroun, Rwanda', true], // Liste contenant le pays
        ];

        $this->info('Tests de correspondance:');
        $this->newLine();

        $passed = 0;
        $failed = 0;

        foreach ($testCases as $index => $test) {
            list($country1, $country2, $expected) = $test;
            $result = CountryMatcher::matches($country1, $country2);
            $status = ($result === $expected) ? '✓' : '✗';
            
            if ($result === $expected) {
                $passed++;
            } else {
                $failed++;
            }

            $expectedText = $expected ? 'doit correspondre' : 'ne doit PAS correspondre';
            $resultText = $result ? 'correspond' : 'ne correspond pas';
            
            $this->line("{$status} Test " . ($index + 1) . ": '{$country1}' vs '{$country2}'");
            $this->line("   Attendu: {$expectedText}, Résultat: {$resultText}");
            $this->newLine();
        }

        $this->info('=== RÉSUMÉ ===');
        $this->info("Tests réussis: {$passed}");
        if ($failed > 0) {
            $this->warn("Tests échoués: {$failed}");
        } else {
            $this->info("✓ Tous les tests sont passés !");
        }

        return $failed === 0 ? Command::SUCCESS : Command::FAILURE;
    }
}




