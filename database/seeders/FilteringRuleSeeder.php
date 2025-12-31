<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FilteringRule;
use App\Models\ActivityPole;

class FilteringRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les pôles d'activité
        $environnement = ActivityPole::where('name', 'Environnement')->first();
        $mines = ActivityPole::where('name', 'Mines & Technique')->first();
        $eau = ActivityPole::where('name', 'Eau & Assainissement')->first();
        $infra = ActivityPole::where('name', 'Infrastructures & BTP')->first();
        $agriculture = ActivityPole::where('name', 'Agriculture')->first();
        $securite = ActivityPole::where('name', 'Sécurité & HSSE')->first();

        // 1. Banque Mondiale - Bureau d'études
        if ($environnement) {
            $rule1 = FilteringRule::create([
                'name' => 'Banque Mondiale - Bureau d\'études Environnement',
                'source' => 'World Bank',
                'market_type' => 'bureau_d_etude',
                'is_active' => true,
            ]);
            
            $rule1->countries()->createMany([
                ['country' => 'RCA'],
                ['country' => 'République Centrafricaine'],
                ['country' => 'Afrique Centrale'],
            ]);
            
            $rule1->activityPoles()->attach($environnement->id);
        }

        // 2. BAD - Consultant Individuel
        if ($eau) {
            $rule2 = FilteringRule::create([
                'name' => 'BAD - Consultant Individuel Eau',
                'source' => 'African Development Bank',
                'market_type' => 'consultant_individuel',
                'is_active' => true,
            ]);
            
            $rule2->countries()->createMany([
                ['country' => 'Afrique de l\'Ouest'],
                ['country' => 'Afrique Centrale'],
            ]);
            
            $rule2->activityPoles()->attach($eau->id);
        }

        // 3. AFD - Bureau d'études
        if ($mines) {
            $rule3 = FilteringRule::create([
                'name' => 'AFD - Bureau d\'études Mines',
                'source' => 'AFD',
                'market_type' => 'bureau_d_etude',
                'is_active' => true,
            ]);
            
            $rule3->countries()->createMany([
                ['country' => 'Bénin'],
                ['country' => 'Togo'],
            ]);
            
            $rule3->activityPoles()->attach($mines->id);
        }

        // 4. FIDA - Consultant Individuel
        if ($agriculture && $securite) {
            $rule4 = FilteringRule::create([
                'name' => 'FIDA - Consultant Individuel Agriculture/HSSE',
                'source' => 'IFAD',
                'market_type' => 'consultant_individuel',
                'is_active' => true,
            ]);
            
            $rule4->countries()->createMany([
                ['country' => 'Afrique'],
            ]);
            
            $rule4->activityPoles()->attach([$agriculture->id, $securite->id]);
        }

        // 5. BDEAC - Bureau d'études
        if ($infra) {
            $rule5 = FilteringRule::create([
                'name' => 'BDEAC - Bureau d\'études Infrastructures',
                'source' => 'BDEAC',
                'market_type' => 'bureau_d_etude',
                'is_active' => true,
            ]);
            
            // Sous-région = Afrique Centrale
            $rule5->countries()->createMany([
                ['country' => 'Afrique Centrale'],
                ['country' => 'Sous-région'],
            ]);
            
            $rule5->activityPoles()->attach($infra->id);
        }

        // 6. Fonds Adaptation - Bureau d'études (Climat/Environnement)
        if ($environnement) {
            $rule6 = FilteringRule::create([
                'name' => 'Fonds Adaptation - Bureau d\'études Environnement',
                'source' => 'World Bank', // Note: Le Fonds Adaptation peut être sous World Bank
                'market_type' => 'bureau_d_etude',
                'is_active' => true,
            ]);
            
            $rule6->countries()->createMany([
                ['country' => 'Afrique Centrale'],
            ]);
            
            $rule6->activityPoles()->attach($environnement->id);
        }
    }
}
