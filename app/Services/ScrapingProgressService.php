<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ScrapingProgressService
{
    private const CACHE_PREFIX = 'scraping_progress_';
    private const CACHE_DURATION = 3600; // 1 heure

    /**
     * Initialise la progression du scraping
     *
     * @param string $jobId Identifiant unique du job
     * @param int $totalSources Nombre total de sources à scraper
     * @return void
     */
    public function initialize(string $jobId, int $totalSources): void
    {
        Cache::put(self::CACHE_PREFIX . $jobId, [
            'status' => 'running',
            'current' => 0,
            'total' => $totalSources,
            'percentage' => 0,
            'current_source' => null,
            'completed_sources' => [],
            'failed_sources' => [],
            'message' => 'Initialisation...',
            'started_at' => now()->toDateTimeString(),
        ], self::CACHE_DURATION);
    }

    /**
     * Met à jour la progression pour une source en cours
     *
     * @param string $jobId
     * @param string $sourceName Nom de la source en cours
     * @param int $current Numéro de la source actuelle
     * @return void
     */
    public function updateSource(string $jobId, string $sourceName, int $current): void
    {
        $progress = $this->getProgress($jobId);
        if (!$progress) {
            return;
        }

        $progress['current'] = $current;
        $progress['current_source'] = $sourceName;
        $progress['percentage'] = $current > 0 ? (int)(($current / $progress['total']) * 100) : 0;
        $progress['message'] = "Scraping de {$sourceName}... ({$current}/{$progress['total']})";

        Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
    }

    /**
     * Marque une source comme terminée avec succès
     *
     * @param string $jobId
     * @param string $sourceName
     * @param int $offresCount Nombre d'offres récupérées
     * @return void
     */
    public function markSourceCompleted(string $jobId, string $sourceName, int $offresCount = 0): void
    {
        $progress = $this->getProgress($jobId);
        if (!$progress) {
            return;
        }

        $progress['completed_sources'][] = [
            'name' => $sourceName,
            'offres_count' => $offresCount,
            'completed_at' => now()->toDateTimeString(),
        ];

        Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
    }

    /**
     * Marque une source comme échouée
     *
     * @param string $jobId
     * @param string $sourceName
     * @param string $errorMessage
     * @return void
     */
    public function markSourceFailed(string $jobId, string $sourceName, string $errorMessage): void
    {
        $progress = $this->getProgress($jobId);
        if (!$progress) {
            return;
        }

        $progress['failed_sources'][] = [
            'name' => $sourceName,
            'error' => $errorMessage,
            'failed_at' => now()->toDateTimeString(),
        ];

        Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
    }

    /**
     * Marque le scraping comme terminé
     *
     * @param string $jobId
     * @return void
     */
    public function complete(string $jobId): void
    {
        $progress = $this->getProgress($jobId);
        if (!$progress) {
            return;
        }

        $progress['status'] = 'completed';
        $progress['percentage'] = 100;
        $progress['message'] = 'Scraping terminé avec succès';
        $progress['completed_at'] = now()->toDateTimeString();

        Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
    }

    /**
     * Marque le scraping comme échoué
     *
     * @param string $jobId
     * @param string $errorMessage
     * @return void
     */
    public function fail(string $jobId, string $errorMessage): void
    {
        $progress = $this->getProgress($jobId);
        if (!$progress) {
            return;
        }

        $progress['status'] = 'failed';
        $progress['message'] = $errorMessage;
        $progress['error'] = $errorMessage;
        $progress['failed_at'] = now()->toDateTimeString();

        Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
    }

    /**
     * Marque le scraping comme annulé
     *
     * @param string $jobId
     * @return void
     */
    public function cancel(string $jobId): void
    {
        $progress = $this->getProgress($jobId);
        if (!$progress) {
            return;
        }

        $progress['status'] = 'cancelled';
        $progress['message'] = 'Scraping annulé par l\'utilisateur';
        $progress['cancelled_at'] = now()->toDateTimeString();

        Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
    }

    /**
     * Vérifie si le scraping a été annulé
     *
     * @param string $jobId
     * @return bool
     */
    public function isCancelled(string $jobId): bool
    {
        $progress = $this->getProgress($jobId);
        return $progress && isset($progress['status']) && $progress['status'] === 'cancelled';
    }

    /**
     * Récupère la progression actuelle
     *
     * @param string $jobId
     * @return array|null
     */
    public function getProgress(string $jobId): ?array
    {
        return Cache::get(self::CACHE_PREFIX . $jobId);
    }

    /**
     * Supprime la progression
     *
     * @param string $jobId
     * @return void
     */
    public function clear(string $jobId): void
    {
        Cache::forget(self::CACHE_PREFIX . $jobId);
    }

    /**
     * Génère un ID unique pour le job
     *
     * @return string
     */
    public static function generateJobId(): string
    {
        return uniqid('scraping_', true);
    }
}

