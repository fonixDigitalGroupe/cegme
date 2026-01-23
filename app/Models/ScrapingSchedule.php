<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScrapingSchedule extends Model
{
    protected $fillable = [
        'frequency',
        'is_active',
        'last_run_at',
        'next_run_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_run_at' => 'datetime',
        'next_run_at' => 'datetime',
    ];

    /**
     * Obtenir la fréquence en minutes
     */
    public function getFrequencyInMinutes(): int
    {
        return match ($this->frequency) {
            '1min' => 1,
            '30min' => 30,
            '1hour' => 60,
            '24hours' => 1440,
            default => 1440,
        };
    }

    /**
     * Vérifier si le scraping doit être exécuté
     */
    public function shouldRun(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->last_run_at) {
            return true;
        }

        $minutesSinceLastRun = now()->diffInMinutes($this->last_run_at);
        return $minutesSinceLastRun >= $this->getFrequencyInMinutes();
    }
}
