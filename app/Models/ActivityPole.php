<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ActivityPole extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Les mots-clés associés à ce pôle d'activité
     */
    public function keywords(): HasMany
    {
        return $this->hasMany(ActivityPoleKeyword::class);
    }

    /**
     * Les règles de filtrage qui utilisent ce pôle
     */
    public function filteringRules(): BelongsToMany
    {
        return $this->belongsToMany(FilteringRule::class, 'filtering_rule_activity_poles');
    }
}
