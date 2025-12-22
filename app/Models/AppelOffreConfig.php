<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppelOffreConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_ptf',
        'zone_geographique',
        'site_officiel',
        'type_marche_id',
        'pole_activite_id',
    ];

    /**
     * Le type de marché associé à cette configuration
     */
    public function typeMarche()
    {
        return $this->belongsTo(TypeMarche::class);
    }

    /**
     * Le pôle d'activité associé à cette configuration
     */
    public function poleActivite()
    {
        return $this->belongsTo(PoleActivite::class);
    }
}
