<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoleActivite extends Model
{
    use HasFactory;

    protected $table = 'pole_activites';

    protected $fillable = [
        'nom',
        'description',
    ];

    /**
     * Les mots-clés associés à ce pôle d'activité
     */
    public function motsCles()
    {
        return $this->hasMany(MotCle::class);
    }

    /**
     * Les configurations d'appels d'offres qui utilisent ce pôle d'activité
     */
    public function appelOffreConfigs()
    {
        return $this->hasMany(AppelOffreConfig::class);
    }
}
