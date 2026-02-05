<?php

namespace App\Services;

class TranslationService
{
    /**
     * Traduit le nom de la source.
     */
    public static function translateSource(string $source): string
    {
        $map = [
            'World Bank' => 'Banque Mondiale',
            'African Development Bank' => 'Banque Africaine de Développement',
            'AfDB' => 'BAD',
            'BDEAC' => 'BDEAC', // Déjà en FR
            'Boad' => 'BOAD',
            'DgMarket' => 'DGMarket',
            'Ifad' => 'FIDA',
            'IFAD' => 'FIDA'
        ];

        return $map[$source] ?? $source;
    }

    /**
     * Traduit partiellement le titre en remplaçant des mots-clés courants.
     */
    public static function translateTitle(string $title): string
    {
        // Dictionnaire de termes courants dans les appels d'offres
        $dictionary = [
            // Types de marché
            'Consultancy' => 'Consultance',
            'Consultant' => 'Consultant',
            'Services' => 'Services',
            'Supply' => 'Fourniture',
            'Supplies' => 'Fournitures',
            'Works' => 'Travaux',
            'Rehabilitation' => 'Réhabilitation',
            'Construction' => 'Construction',
            'Acquisition' => 'Acquisition',
            'Selection' => 'Sélection',
            'Recruitment' => 'Recrutement',
            'Project' => 'Projet',
            'Program' => 'Programme',
            'Development' => 'Développement',
            'Support' => 'Appui',
            'Technical Assistance' => 'Assistance Technique',
            'Audit' => 'Audit',
            'Financial' => 'Financier',
            'Management' => 'Gestion',
            'Implementation' => 'Mise en œuvre',
            'Design' => 'Conception',
            'Review' => 'Revue',
            'Study' => 'Étude',
            'Feasibility' => 'Faisabilité',
            'Assessment' => 'Évaluation',
            'Monitoring' => 'Suivi',
            'Evaluation' => 'Évaluation',
            'Training' => 'Formation',
            'Capacity Building' => 'Renforcement de capacités',
            'Equipment' => 'Équipement',
            'Vehicle' => 'Véhicule',
            'Vehicles' => 'Véhicules',
            'System' => 'Système',
            'Maintenance' => 'Maintenance',
            'Software' => 'Logiciel',
            'Hardware' => 'Matériel informatique',
            'Data' => 'Données',
            'Analysis' => 'Analyse',
            'Quality' => 'Qualité',
            'Control' => 'Contrôle',
            'Supervision' => 'Supervision',
            
            // Prépositions et mots de liaison (avec espaces pour éviter les faux positifs)
            ' of ' => ' de ',
            ' for ' => ' pour ',
            ' and ' => ' et ',
            ' in ' => ' à ', // ou 'en' selon contexte, mais 'à' est souvent safe pour lieux
            ' with ' => ' avec ',
            ' on ' => ' sur ',
            ' at ' => ' à ',
            
            // Dates et temps
            'Year' => 'Année',
            'Month' => 'Mois',
            'Period' => 'Période',
            'Long Term' => 'Long terme',
            'Short Term' => 'Court terme',
        ];

        // Remplacement insensible à la casse mais on préfère garder la casse d'origine si possible
        // Ici on fait un remplacement simple str_ireplace ou str_replace
        
        $translated = $title;
        foreach ($dictionary as $en => $fr) {
            // Utilisation de str_ireplace pour être insensible à la casse
            $translated = str_ireplace($en, $fr, $translated);
        }

        return $translated;
    }
}
