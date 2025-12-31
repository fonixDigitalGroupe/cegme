<?php

namespace App\Services;

class CountryMatcher
{
    /**
     * Mapping des variations communes de noms de pays
     * Pour gérer les fautes d'orthographe courantes
     */
    private static $countryVariations = [
        'cameroun' => ['cameroune', 'camerun', 'cameroon', 'camerou'],
        'togo' => ['toggo', 'togoo'],
        'bénin' => ['benin', 'benine'],
        'sénégal' => ['senegal', 'sénagal', 'senagal'],
        'côte d\'ivoire' => ['cote d\'ivoire', 'côte divoire', 'cote divoire', 'ivory coast'],
        'mali' => ['mally', 'malie'],
        'burkina faso' => ['burkina', 'burkinafaso'],
        'niger' => ['nigeria'], // Attention: Niger et Nigeria sont différents !
        'madagascar' => ['madagaskar'],
        'tunisie' => ['tunusie', 'tunise'],
        'maroc' => ['marocco', 'morocco'],
        'algérie' => ['algerie', 'algeria'],
        'égypte' => ['egypte', 'egypt'],
        'ghana' => ['gana', 'ghanna'],
        'kenya' => ['kenia'],
        'ouganda' => ['uganda', 'ouganda'],
        'tanzanie' => ['tanzania'],
        'rwanda' => ['ruanda'],
        'congo' => ['kong', 'kongo'],
    ];

    /**
     * Normalise un nom de pays pour la comparaison
     * 
     * @param string $country
     * @return string
     */
    public static function normalize(string $country): string
    {
        $normalized = strtolower(trim($country));
        
        // Retirer les accents
        $normalized = self::removeAccents($normalized);
        
        // Retirer les espaces multiples
        $normalized = preg_replace('/\s+/', ' ', $normalized);
        
        return trim($normalized);
    }

    /**
     * Retire les accents d'une chaîne
     * 
     * @param string $str
     * @return string
     */
    private static function removeAccents(string $str): string
    {
        $accents = [
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'Ç' => 'C', 'Ñ' => 'N'
        ];
        
        return strtr($str, $accents);
    }

    /**
     * Vérifie si deux noms de pays correspondent (avec tolérance aux fautes d'orthographe)
     * 
     * @param string $country1
     * @param string $country2
     * @return bool
     */
    public static function matches(string $country1, string $country2): bool
    {
        $normalized1 = self::normalize($country1);
        $normalized2 = self::normalize($country2);
        
        // Correspondance exacte après normalisation
        if ($normalized1 === $normalized2) {
            return true;
        }
        
        // Vérifier les variations connues
        $variations1 = self::getVariations($normalized1);
        $variations2 = self::getVariations($normalized2);
        
        // Si l'une des variations correspond exactement
        foreach ($variations1 as $variation) {
            if ($variation === $normalized2) {
                return true;
            }
        }
        foreach ($variations2 as $variation) {
            if ($variation === $normalized1) {
                return true;
            }
        }
        
        // Utiliser la distance de Levenshtein pour les fautes mineures (très restrictif)
        // Seulement si les mots ont une longueur similaire (différence max 2 caractères)
        $len1 = strlen($normalized1);
        $len2 = strlen($normalized2);
        
        if (abs($len1 - $len2) <= 2) {
            $distance = levenshtein($normalized1, $normalized2);
            $minLength = min($len1, $len2);
            
            // Seulement pour les distances très petites (1 caractère max) et mots assez longs
            if ($minLength >= 5 && $distance === 1) {
                return true;
            }
        }
        
        // Vérifier si l'un contient l'autre (pour les noms composés comme "Côte d'Ivoire")
        // Mais seulement si le mot contenu fait au moins 5 caractères pour éviter les faux positifs
        $longer = strlen($normalized1) > strlen($normalized2) ? $normalized1 : $normalized2;
        $shorter = strlen($normalized1) > strlen($normalized2) ? $normalized2 : $normalized1;
        
        if (strlen($shorter) >= 5 && stripos($longer, $shorter) !== false) {
            return true;
        }
        
        return false;
    }

    /**
     * Récupère toutes les variations possibles d'un pays
     * 
     * @param string $country
     * @return array
     */
    private static function getVariations(string $country): array
    {
        $variations = [$country];
        
        // Chercher dans le mapping
        foreach (self::$countryVariations as $base => $vars) {
            if ($base === $country) {
                $variations = array_merge($variations, $vars);
            }
            if (in_array($country, $vars)) {
                $variations[] = $base;
                $variations = array_merge($variations, $vars);
            }
        }
        
        return array_unique($variations);
    }

    /**
     * Trouve le pays correspondant dans une liste de pays (avec tolérance aux fautes)
     * 
     * @param string $searchCountry Le pays recherché
     * @param array $countryList Liste des pays où chercher
     * @return string|null Le pays correspondant trouvé, ou null
     */
    public static function findMatch(string $searchCountry, array $countryList): ?string
    {
        $normalizedSearch = self::normalize($searchCountry);
        
        foreach ($countryList as $country) {
            if (self::matches($searchCountry, $country)) {
                return $country; // Retourner le pays original (pas normalisé)
            }
        }
        
        return null;
    }
}

