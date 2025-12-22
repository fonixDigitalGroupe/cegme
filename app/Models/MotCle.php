<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotCle extends Model
{
    use HasFactory;

    protected $table = 'mots_cles';

    protected $fillable = [
        'nom',
        'pole_activite_id',
    ];

    /**
     * Le pôle d'activité auquel appartient ce mot-clé
     */
    public function poleActivite()
    {
        return $this->belongsTo(PoleActivite::class);
    }
}
