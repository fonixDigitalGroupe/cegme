<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppelOffreConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_ptf',
        'type_marche',
        'zone_geographique',
        'site_officiel',
    ];
}
