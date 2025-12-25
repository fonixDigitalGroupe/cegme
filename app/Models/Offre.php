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
}
