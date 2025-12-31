<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $fillable = [
        'titre',
        'acheteur',
        'pays',
        'date_limite_soumission',
        'lien_source',
        'source',
        'link_type',
        'detail_url',
        'project_id',
        'notice_type',
    ];

    protected $casts = [
        'date_limite_soumission' => 'date',
    ];

    /**
     * Retourne seulement le(s) pays qui correspondent aux critères de filtrage
     * (avec tolérance aux fautes d'orthographe)
     * 
     * @param array|null $allowedCountries Liste des pays autorisés (null = retourner tous les pays)
     * @return string|null
     */
    public function getFilteredPays(?array $allowedCountries = null): ?string
    {
        if (empty($this->pays)) {
            return null;
        }

        // Si aucun pays autorisé spécifié, retourner tous les pays
        if (empty($allowedCountries)) {
            return $this->pays;
        }

        // Extraire les pays de l'offre (séparés par des virgules)
        $offrePays = array_map('trim', explode(',', $this->pays));
        $matchedPays = [];

        // Trouver les pays qui correspondent aux critères (avec tolérance aux fautes)
        foreach ($offrePays as $pays) {
            foreach ($allowedCountries as $allowedCountry) {
                if (\App\Services\CountryMatcher::matches($allowedCountry, $pays)) {
                    $matchedPays[] = $pays; // Garder le nom original du pays dans l'offre
                    break; // Ne garder qu'une seule occurrence
                }
            }
        }

        return !empty($matchedPays) ? implode(', ', array_unique($matchedPays)) : null;
    }
}
