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
        // If it's not a firm, these imply an individual (Specialist, Expert, etc.)
        $weakConsultantKeywords = [
            'spécialiste', 
            'specialist',
            'expert ', // Space to avoid matching 'expertise' too easily? Or rely on regex?
            ' expert',
            'uncodified individual' // sometimes used?
        ];
        
        // Check for 'specialiste' / 'specialist'
        if (mb_strpos($text, 'spécialiste') !== false || mb_strpos($text, 'specialist') !== false) {
            return self::TYPE_CONSULTANT_INDIVIDUEL;
        }

        // Check for 'expert' but try to avoid partial matches if possible (simple heuristic)
        // We look for " expert " or start/end of string
        // preg_match is safer for word boundaries
        if (preg_match('/\bexpert\b/u', $text)) {
            return self::TYPE_CONSULTANT_INDIVIDUEL;
        }

        return null;
    }
}
