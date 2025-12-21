<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppelOffre extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appels_offres';

    protected $fillable = [
        'titre',
        'acheteur',
        'pays',
        'date_limite',
        'date_limite_soumission', // Alias pour compatibilité
        'lien_source',
        'is_actif',
        'is_published', // Alias pour compatibilité
        'source',
        'type_marche',
        'zone_geographique',
        'description',
        'image',
        'mots_cles',
        'pole_activite',
    ];

    protected $casts = [
        'date_limite' => 'date',
        'date_limite_soumission' => 'date',
        'is_actif' => 'boolean',
        'is_published' => 'boolean',
    ];


    /**
     * Scope pour les appels d'offres publiés
     */
    public function scopePublished($query)
    {
        return $query->where('is_actif', true);
    }

    /**
     * Scope pour la recherche par mot-clé
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('titre', 'like', "%{$keyword}%")
              ->orWhere('source', 'like', "%{$keyword}%")
              ->orWhere('type_marche', 'like', "%{$keyword}%")
              ->orWhere('zone_geographique', 'like', "%{$keyword}%")
              ->orWhere('mots_cles', 'like', "%{$keyword}%")
              ->orWhere('pole_activite', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%")
              ->orWhere('acheteur', 'like', "%{$keyword}%")
              ->orWhere('pays', 'like', "%{$keyword}%");
        });
    }

    /**
     * Scope pour filtrer par pays
     */
    public function scopeByCountry($query, $country)
    {
        return $query->where('pays', $country);
    }

    /**
     * Scope pour filtrer par date
     */
    public function scopeByDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->where('date_limite', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('date_limite', '<=', $endDate);
        }
        return $query;
    }
}
