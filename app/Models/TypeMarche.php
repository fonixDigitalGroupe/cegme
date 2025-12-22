<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMarche extends Model
{
    use HasFactory;

    protected $table = 'type_marches';

    protected $fillable = [
        'nom',
        'description',
    ];

    /**
     * Les configurations d'appels d'offres qui utilisent ce type de marché
     */
    public function appelOffreConfigs()
    {
        return $this->hasMany(AppelOffreConfig::class);
    }
}
