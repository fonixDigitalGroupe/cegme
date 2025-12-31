<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FilteringRule extends Model
{
    protected $fillable = [
        'name',
        'source',
        'market_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Les pays autorisés pour cette règle
     */
    public function countries(): HasMany
    {
        return $this->hasMany(FilteringRuleCountry::class);
    }

    /**
     * Les pôles d'activité associés à cette règle
     */
    public function activityPoles(): BelongsToMany
    {
        return $this->belongsToMany(ActivityPole::class, 'filtering_rule_activity_poles');
    }

    /**
     * Scope pour les règles actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour une source spécifique
     */
    public function scopeForSource($query, string $source)
    {
        return $query->where('source', $source);
    }
}
