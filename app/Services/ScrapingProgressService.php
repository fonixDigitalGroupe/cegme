<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ScrapingProgressService
{
    private const CACHE_PREFIX = 'scraping_progress_';
    private const CURRENT_JOB_KEY = 'scraping_current_job_id';
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
        Cache::put(self::CURRENT_JOB_KEY, $jobId, self::CACHE_DURATION);

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
        Cache::lock(self::CACHE_PREFIX . $jobId . '_lock', 10)->block(5, function () use ($jobId, $sourceName, $current) {
            $progress = $this->getProgress($jobId);
            if (!$progress) {
                return;
            }

            $progress['current'] = $current;
            $progress['current_source'] = $sourceName;
            $progress['percentage'] = $progress['total'] > 0 ? max(0, (int) ((($current - 1) / $progress['total']) * 100)) : 0;
            $progress['message'] = "Scraping de {$sourceName}... ({$current}/{$progress['total']})";

            Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
        });
    }

    /**
     * Met à jour des champs spécifiques de la progression
     *
     * @param string $jobId
     * @param array $data Données à mettre à jour
     * @return void
     */
    public function updateProgress(string $jobId, array $data): void
    {
        Cache::lock(self::CACHE_PREFIX . $jobId . '_lock', 10)->block(5, function () use ($jobId, $data) {
            $progress = $this->getProgress($jobId);
            if (!$progress) {
                return;
            }

            foreach ($data as $key => $value) {
                $progress[$key] = $value;
            }

            Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
        });
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
        Cache::lock(self::CACHE_PREFIX . $jobId . '_lock', 10)->block(5, function () use ($jobId, $sourceName, $offresCount) {
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
        });
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
        Cache::lock(self::CACHE_PREFIX . $jobId . '_lock', 10)->block(5, function () use ($jobId, $sourceName, $errorMessage) {
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
        });
    }

    /**
     * Marque le scraping comme terminé
     *
     * @param string $jobId
     * @return void
     */
    public function complete(string $jobId): void
    {
        Cache::lock(self::CACHE_PREFIX . $jobId . '_lock', 10)->block(5, function () use ($jobId) {
            $progress = $this->getProgress($jobId);
            if (!$progress) {
                return;
            }

            $progress['status'] = 'completed';
            $progress['percentage'] = 100;
            $progress['message'] = 'Scraping terminé avec succès';
            $progress['completed_at'] = now()->toDateTimeString();

            Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
        });
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
        Cache::lock(self::CACHE_PREFIX . $jobId . '_lock', 10)->block(5, function () use ($jobId, $errorMessage) {
            $progress = $this->getProgress($jobId);
            if (!$progress) {
                return;
            }

            $progress['status'] = 'failed';
            $progress['message'] = $errorMessage;
            $progress['error'] = $errorMessage;
            $progress['failed_at'] = now()->toDateTimeString();

            Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
        });
    }

    /**
     * Marque le scraping comme annulé
     *
     * @param string $jobId
     * @return void
     */
    public function cancel(string $jobId): void
    {
        Cache::lock(self::CACHE_PREFIX . $jobId . '_lock', 10)->block(5, function () use ($jobId) {
            $progress = $this->getProgress($jobId);
            if (!$progress) {
                return;
            }

            $progress['status'] = 'cancelled';
            $progress['message'] = 'Scraping annulé par l\'utilisateur';
            $progress['cancelled_at'] = now()->toDateTimeString();

            Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
        });
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
     * Ajoute des offres découvertes à la liste des trouvailles récentes
     *
     * @param string $jobId
     * @param array $findings Liste d'offres (tableaux associatifs avec titre, pays, etc.)
     * @return void
     */
    public function addFindings(string $jobId, array $findings): void
    {
        Cache::lock(self::CACHE_PREFIX . $jobId . '_lock', 10)->block(5, function () use ($jobId, $findings) {
            $progress = $this->getProgress($jobId);
            if (!$progress) {
                return;
            }

            if (!isset($progress['recent_findings'])) {
                $progress['recent_findings'] = [];
            }

            // Ajouter les nouvelles trouvailles au début
            $newFindings = array_map(function ($f) {
                return [
                    'titre' => $f['titre'] ?? 'Sans titre',
                    'pays' => $f['pays'] ?? 'N/A',
                    'source' => $f['source'] ?? 'N/A',
                    'date_limite' => $f['date_limite_soumission'] ?? 'N/A',
                    'found_at' => now()->format('H:i:s'),
                ];
            }, $findings);

            $progress['recent_findings'] = array_merge($newFindings, $progress['recent_findings']);

            // Garder seulement les 20 dernières trouvailles pour ne pas exploser le cache
            $progress['recent_findings'] = array_slice($progress['recent_findings'], 0, 20);

            // Mettre à jour aussi le nombre total d'offres en base (estimation rapide)
            $progress['total_offres'] = \App\Models\Offre::count();

            Cache::put(self::CACHE_PREFIX . $jobId, $progress, self::CACHE_DURATION);
        });
    }

    /**
     * Récupère les dernières trouvailles
     *
     * @param string $jobId
     * @return array
     */
    public function getFindings(string $jobId): array
    {
        $progress = $this->getProgress($jobId);
        return $progress['recent_findings'] ?? [];
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

    /**
     * Récupère l'ID du job en cours
     *
     * @return string|null
     */
    public function getCurrentJobId(): ?string
    {
        return Cache::get(self::CURRENT_JOB_KEY);
    }

    /**
     * Supprime l'ID du job en cours
     *
     * @return void
     */
    public function clearCurrentJobId(): void
    {
        Cache::forget(self::CURRENT_JOB_KEY);
    }
}

