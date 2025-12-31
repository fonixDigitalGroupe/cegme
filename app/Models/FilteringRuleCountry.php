<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilteringRuleCountry extends Model
{
    protected $fillable = [
        'filtering_rule_id',
        'country',
    ];

    /**
     * La règle de filtrage à laquelle appartient ce pays
     */
    public function filteringRule(): BelongsTo
    {
        return $this->belongsTo(FilteringRule::class);
    }
}
