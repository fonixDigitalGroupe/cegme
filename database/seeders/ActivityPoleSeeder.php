<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityPole;

class ActivityPoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pôle Environnement
        $environnement = ActivityPole::create([
            'name' => 'Environnement',
            'description' => 'Projets liés à l\'environnement, impact environnemental et social',
        ]);
        
        $environnement->keywords()->createMany([
            ['keyword' => 'EIES'],
            ['keyword' => 'Impact environnemental'],
            ['keyword' => 'Audit environnemental'],
            ['keyword' => 'Plan de Gestion Environnementale et Sociale (PGES)'],
            ['keyword' => 'PGES'],
            ['keyword' => 'Plan de Gestion Environnementale et Sociale'],
            ['keyword' => 'Environnement'],
            ['keyword' => 'Vulnérabilité climatique'],
            ['keyword' => 'Climat'],
            ['keyword' => 'Audit'],
        ]);

        // Pôle Mines & Technique
        $mines = ActivityPole::create([
            'name' => 'Mines & Technique',
            'description' => 'Projets miniers, géologiques et techniques',
        ]);
        
        $mines->keywords()->createMany([
            ['keyword' => 'Étude de faisabilité'],
            ['keyword' => 'Faisabilité'],
            ['keyword' => 'Ressources minérales'],
            ['keyword' => 'Géologie'],
            ['keyword' => 'Exploitation minière'],
            ['keyword' => 'Mines'],
            ['keyword' => 'Projet minier'],
        ]);

        // Pôle Eau
        $eau = ActivityPole::create([
            'name' => 'Eau & Assainissement',
            'description' => 'Projets liés à l\'eau, l\'assainissement et l\'hydraulique',
        ]);
        
        $eau->keywords()->createMany([
            ['keyword' => 'Hydrogéologie'],
            ['keyword' => 'Forages'],
            ['keyword' => 'Alimentation en Eau Potable (AEP)'],
            ['keyword' => 'AEP'],
            ['keyword' => 'Alimentation en Eau Potable'],
            ['keyword' => 'Hydraulique'],
            ['keyword' => 'Eau'],
            ['keyword' => 'Assainissement'],
        ]);

        // Pôle Infrastructures & BTP
        $infra = ActivityPole::create([
            'name' => 'Infrastructures & BTP',
            'description' => 'Projets d\'infrastructure, construction et travaux publics',
        ]);
        
        $infra->keywords()->createMany([
            ['keyword' => 'Monitoring'],
            ['keyword' => 'BTP'],
            ['keyword' => 'Infrastructure'],
            ['keyword' => 'Surveillance de chantier'],
            ['keyword' => 'Construction'],
            ['keyword' => 'Travaux publics'],
        ]);

        // Pôle Agriculture
        $agriculture = ActivityPole::create([
            'name' => 'Agriculture',
            'description' => 'Projets agricoles et de développement rural',
        ]);
        
        $agriculture->keywords()->createMany([
            ['keyword' => 'Agriculture'],
            ['keyword' => 'Projets agricoles'],
            ['keyword' => 'Développement rural'],
        ]);

        // Pôle Sécurité & HSSE
        $securite = ActivityPole::create([
            'name' => 'Sécurité & HSSE',
            'description' => 'Sécurité, santé, hygiène et environnement (HSSE)',
        ]);
        
        $securite->keywords()->createMany([
            ['keyword' => 'HSSE'],
            ['keyword' => 'Hygiène et Sécurité'],
            ['keyword' => 'Risques professionnels'],
            ['keyword' => 'Surveillance de chantier'],
            ['keyword' => 'Sécurité'],
            ['keyword' => 'Santé'],
            ['keyword' => 'Hygiène'],
        ]);
    }
}
