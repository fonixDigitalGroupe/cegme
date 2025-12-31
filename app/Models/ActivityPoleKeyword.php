<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityPoleKeyword extends Model
{
    protected $fillable = [
        'activity_pole_id',
        'keyword',
    ];

    /**
     * Le pôle d'activité auquel appartient ce mot-clé
     */
    public function activityPole(): BelongsTo
    {
        return $this->belongsTo(ActivityPole::class);
    }
}
