<?php

namespace App\Services;

class MarketTypeClassifier
{
    public const TYPE_BUREAU_ETUDE = 'bureau_d_etude';
    public const TYPE_CONSULTANT_INDIVIDUEL = 'consultant_individuel';

    public static function classify(string $text): ?string
    {
        $text = mb_strtolower($text, 'UTF-8');

        // 1. Strong Keywords for Consultant Individuel (Explicitly individual)
        // These override "Firm" keywords (e.g. "Individual Consultant for Firm Audit")
        $strongConsultantKeywords = [
            'consultant individuel', 
            'individual consultant', 
            'expert individuel', 
            'individual expert',
            'personne physique',
            'consultants individuels',
            'individual consultants'
        ];

        foreach ($strongConsultantKeywords as $kw) {
            if (mb_strpos($text, $kw) !== false) {
                return self::TYPE_CONSULTANT_INDIVIDUEL;
            }
        }

        // 2. Keywords for Bureau d'étude (Firm)
        // If not explicitly individual, check for firm indicators
        $firmKeywords = [
            'bureau d\'étude', 
            'bureau d\'études', 
            'cabinet', 
            'consulting firm', 
            'firm',
            'société de conseil',
            'agence',
            'groupement',
            'personne morale',
            'company',
            'entreprise'
        ];

        foreach ($firmKeywords as $kw) {
            if (mb_strpos($text, $kw) !== false) {
                return self::TYPE_BUREAU_ETUDE;
            }
        }

        // 3. Additional/Weak Keywords for Consultant Individuel
        // If it's not a firm, these imply an individual (Specialist, Expert, Consultant, etc.)
        $individualTerms = [
            'spécialiste', 
            'specialist',
            'particulier',
            'expert',
            'consultant',
            'personne physique'
        ];
        
        foreach ($individualTerms as $term) {
            if (preg_match('/\b' . preg_quote($term, '/') . '\b/iu', $text)) {
                return self::TYPE_CONSULTANT_INDIVIDUEL;
            }
        }

        // If we reach here and it's not classified, we'll assume it's more likely a bureau d'étude
        // in the context of the user's "opposite" requirement, but the classifier should stay neutral
        // and return null, leaving the logic to the Controller's filter.
        return null;
    }
}
