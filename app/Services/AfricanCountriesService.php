<?php

namespace App\Services;

class AfricanCountriesService
{
    /**
     * Retourne la liste des pays africains (Français et Anglais)
     * ainsi que les termes génériques liés à l'Afrique.
     */
    public static function getAfricanCountriesKeywords(): array
    {
        return [
            // Termes génériques
            'Africa', 'Afrique',
            
            // Pays (Français / Anglais)
            'Algérie', 'Algeria',
            'Angola',
            'Bénin', 'Benin',
            'Botswana',
            'Burkina Faso',
            'Burundi',
            'Cameroun', 'Cameroon',
            'Cap-Vert', 'Cape Verde', 'Cabo Verde',
            'Centrafrique', 'République Centrafricaine', 'Central African Republic',
            'Comores', 'Comoros',
            'Congo', // Couvre Congo-Brazzaville et RDC
            'Côte d\'Ivoire', 'Ivory Coast',
            'Djibouti',
            'Égypte', 'Egypt',
            'Dup', // Erythrée (Typo check ?) -> Erythrée
            'Érythrée', 'Eritrea',
            'Eswatini', 'Swaziland',
            'Éthiopie', 'Ethiopia',
            'Gabon',
            'Gambie', 'Gambia',
            'Ghana',
            'Guinée', 'Guinea',
            'Guinée-Bissau', 'Guinea-Bissau',
            'Guinée Équatoriale', 'Equatorial Guinea',
            'Kenya',
            'Lesotho',
            'Liberia',
            'Libye', 'Libya',
            'Madagascar',
            'Malawi',
            'Mali',
            'Maroc', 'Morocco',
            'Maurice', 'Mauritius',
            'Mauritanie', 'Mauritania',
            'Mozambique',
            'Namibie', 'Namibia',
            'Niger',
            'Nigeria',
            'Ouganda', 'Uganda',
            'Rwanda',
            'Sao Tomé-et-Principe', 'São Tomé and Príncipe',
            'Sénégal', 'Senegal',
            'Seychelles',
            'Sierra Leone',
            'Somalie', 'Somalia',
            'Soudan', 'Sudan',
            'Soudan du Sud', 'South Sudan',
            'Tanzanie', 'Tanzania',
            'Tchad', 'Chad',
            'Togo',
            'Tunisie', 'Tunisia',
            'Zambie', 'Zambia',
            'Zimbabwe',
            'Sahara Occidental', 'Western Sahara'
        ];
    }
    /**
     * Traduit le nom d'un pays africain en français.
     * Si le pays n'est pas trouvé dans la liste, retourne la valeur originale.
     */
    public static function translateCountry(string $countryName): string
    {
        $map = [
            'Algeria' => 'Algérie',
            'Benin' => 'Bénin',
            'Botswana' => 'Botswana',
            'Burkina Faso' => 'Burkina Faso',
            'Burundi' => 'Burundi',
            'Cameroon' => 'Cameroun',
            'Cape Verde' => 'Cap-Vert', 'Cabo Verde' => 'Cap-Vert',
            'Central African Republic' => 'République Centrafricaine',
            'Comoros' => 'Comores',
            'Congo' => 'Congo',
            'Ivory Coast' => 'Côte d\'Ivoire', "Cote d'Ivoire" => 'Côte d\'Ivoire',
            'Djibouti' => 'Djibouti',
            'Egypt' => 'Égypte',
            'Eritrea' => 'Érythrée',
            'Eswatini' => 'Eswatini', 'Swaziland' => 'Eswatini',
            'Ethiopia' => 'Éthiopie',
            'Gabon' => 'Gabon',
            'Gambia' => 'Gambie',
            'Ghana' => 'Ghana',
            'Guinea' => 'Guinée',
            'Guinea-Bissau' => 'Guinée-Bissau',
            'Equatorial Guinea' => 'Guinée Équatoriale',
            'Kenya' => 'Kenya',
            'Lesotho' => 'Lesotho',
            'Liberia' => 'Liberia',
            'Libya' => 'Libye',
            'Madagascar' => 'Madagascar',
            'Malawi' => 'Malawi',
            'Mali' => 'Mali',
            'Morocco' => 'Maroc',
            'Mauritius' => 'Maurice',
            'Mauritania' => 'Mauritanie',
            'Mozambique' => 'Mozambique',
            'Namibia' => 'Namibie',
            'Niger' => 'Niger',
            'Nigeria' => 'Nigeria',
            'Uganda' => 'Ouganda',
            'Rwanda' => 'Rwanda',
            'São Tomé and Príncipe' => 'Sao Tomé-et-Principe',
            'Senegal' => 'Sénégal',
            'Seychelles' => 'Seychelles',
            'Sierra Leone' => 'Sierra Leone',
            'Somalia' => 'Somalie',
            'Sudan' => 'Soudan',
            'South Sudan' => 'Soudan du Sud',
            'South Africa' => 'Afrique du Sud',
            'Tanzania' => 'Tanzanie',
            'Chad' => 'Tchad',
            'Togo' => 'Togo',
            'Tunisia' => 'Tunisie',
            'Zambia' => 'Zambie',
            'Zimbabwe' => 'Zimbabwe',
            'Western Sahara' => 'Sahara Occidental',
            'Africa' => 'Afrique',
            'West Africa' => 'Afrique de l\'Ouest',
            'East Africa' => 'Afrique de l\'Est',
            'Central Africa' => 'Afrique Centrale',
            'Southern Africa' => 'Afrique Australe',
            'North Africa' => 'Afrique du Nord',
        ];

        // Nettoyage basique
        $cleanName = trim($countryName);
        
        // Vérifier si c'est une liste séparée par des virgules
        if (str_contains($cleanName, ',')) {
            $parts = explode(',', $cleanName);
            $translatedParts = array_map(function($part) use ($map) {
                $p = trim($part);
                return $map[$p] ?? $p;
            }, $parts);
            return implode(', ', array_unique($translatedParts));
        }

        return $map[$cleanName] ?? $cleanName;
        return $map[$cleanName] ?? $cleanName;
    }

    /**
     * Retourne les définitions des sous-régions pour le filtrage.
     */
    public static function getAfricanRegions(): array
    {
        return [
            'central_africa' => [
                'label' => 'Afrique Centrale',
                'keywords' => [
                    'Cameroun', 'Cameroon',
                    'Gabon',
                    'Congo', // Brazzaville & RDC
                    'Tchad', 'Chad',
                    'Centrafrique', 'Central African Republic',
                    'Guinée Équatoriale', 'Equatorial Guinea',
                    'Sao Tomé', 'São Tomé',
                    'Angola',
                    'Burundi',
                    'Rwanda',
                    'Afrique Centrale', 'Central Africa'
                ]
            ],
            'west_africa' => [
                'label' => 'Afrique de l\'Ouest',
                'keywords' => [
                    'Bénin', 'Benin',
                    'Burkina Faso',
                    'Cap-Vert', 'Cape Verde', 'Cabo Verde',
                    'Côte d\'Ivoire', 'Ivory Coast',
                    'Gambie', 'Gambia',
                    'Ghana',
                    'Guinée', 'Guinea', // Attention aux autres Guinées
                    'Guinée-Bissau', 'Guinea-Bissau',
                    'Liberia',
                    'Mali',
                    'Niger',
                    'Nigeria',
                    'Sénégal', 'Senegal',
                    'Sierra Leone',
                    'Togo',
                    'Afrique de l\'Ouest', 'West Africa'
                ]
            ],
            'benin' => [
                'label' => 'Bénin',
                'keywords' => [
                    'Bénin', 'Benin'
                ]
            ],
            'togo' => [
                'label' => 'Togo',
                'keywords' => [
                    'Togo'
                ]
            ]
        ];
    }
}
