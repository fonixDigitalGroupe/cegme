<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScrapingSchedule;
use Illuminate\Http\Request;

class ScrapingScheduleController extends Controller
{
    /**
     * Mettre à jour la configuration du scraping automatique
     */
    public function updateSchedule(Request $request)
    {
        $request->validate([
            'frequency' => 'required|in:1min,30min,1hour,24hours',
            'is_active' => 'required|boolean',
        ]);

        $schedule = ScrapingSchedule::firstOrCreate([]);

        $schedule->update([
            'frequency' => $request->frequency,
            'is_active' => $request->is_active,
            'next_run_at' => $request->is_active ? now()->addMinutes($this->getMinutes($request->frequency)) : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Configuration mise à jour avec succès',
            'schedule' => $schedule,
        ]);
    }

    /**
     * Obtenir la configuration actuelle
     */
    public function getSchedule()
    {
        $schedule = ScrapingSchedule::first();

        if (!$schedule) {
            $schedule = ScrapingSchedule::create([
                'frequency' => '24hours',
                'is_active' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'schedule' => $schedule,
        ]);
    }

    private function getMinutes($frequency)
    {
        return match ($frequency) {
            '1min' => 1,
            '30min' => 30,
            '1hour' => 60,
            '24hours' => 1440,
            default => 1440,
        };
    }
}
