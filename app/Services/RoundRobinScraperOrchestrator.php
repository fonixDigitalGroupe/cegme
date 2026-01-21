<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class RoundRobinScraperOrchestrator
{
    private $scrapers = [];
    private $batchSize = 10;
    private $batchTimeout = 60; // 1 minute en secondes

    public function __construct(
        private ScrapingProgressService $progressService,
        private string $jobId
    ) {
    }

    /**
     * Ajoute un scraper à l'orchestrateur
     */
    public function addScraper(string $source, IterativeScraperInterface $scraper): void
    {
        $this->scrapers[$source] = [
            'scraper' => $scraper,
            'active' => true,
            'total_count' => 0,
        ];
    }

    /**
     * Lance le scraping round-robin
     */
    public function run(): array
    {
        $totalCount = 0;
        $round = 0;

        // Initialisation
        foreach ($this->scrapers as $source => $data) {
            $data['scraper']->setJobId($this->jobId);
            $data['scraper']->initialize();
        }

        while ($this->hasActiveScrapers()) {
            $round++;

            Log::info("Round-robin: Starting round {$round}");

            foreach ($this->scrapers as $source => &$data) {
                if (!$data['active']) {
                    continue;
                }

                $this->progressService->updateSource($this->jobId, $source, $round);

                // Scraper avec timeout
                $startTime = microtime(true);

                try {
                    $result = $this->scrapeBatchWithTimeout(
                        $data['scraper'],
                        $this->batchSize,
                        $this->batchTimeout
                    );

                    $count = $result['count'];
                    $data['total_count'] += $count;
                    $totalCount += $count;

                    // Envoyer les trouvailles à l'UI
                    if (!empty($result['findings'])) {
                        $this->progressService->addFindings($this->jobId, $result['findings']);
                    }

                    // Désactiver si terminé
                    if (!$result['has_more']) {
                        $data['active'] = false;
                        $this->progressService->markSourceCompleted($this->jobId, $source, $data['total_count']);
                        Log::info("Round-robin: {$source} completed", [
                            'total_count' => $data['total_count'],
                        ]);
                    }

                } catch (\Exception $e) {
                    $data['active'] = false;
                    $this->progressService->markSourceFailed($this->jobId, $source, $e->getMessage());
                    Log::error("Round-robin: {$source} failed", [
                        'error' => $e->getMessage(),
                    ]);
                }

                $elapsed = microtime(true) - $startTime;
                Log::info("Round-robin: {$source} batch completed", [
                    'round' => $round,
                    'count' => $count ?? 0,
                    'elapsed' => round($elapsed, 2) . 's',
                    'has_more' => $result['has_more'] ?? false,
                ]);

                // Plus de pause entre les sources pour accélérer le processus
            }
        }

        Log::info("Round-robin: Scraping completed", [
            'total_rounds' => $round,
            'total_count' => $totalCount,
        ]);

        return [
            'total_count' => $totalCount,
            'rounds' => $round,
        ];
    }

    /**
     * Scrappe un batch avec timeout
     */
    private function scrapeBatchWithTimeout(
        IterativeScraperInterface $scraper,
        int $limit,
        int $timeout
    ): array {
        $startTime = time();

        // Note: pcntl_alarm n'est pas disponible sur Windows
        // On utilise un timeout simple basé sur le temps
        try {
            $result = $scraper->scrapeBatch($limit);

            $elapsed = time() - $startTime;
            if ($elapsed > $timeout) {
                Log::warning("Round-robin: Batch exceeded timeout", [
                    'elapsed' => $elapsed,
                    'timeout' => $timeout,
                ]);
            }

            return $result;

        } catch (\Exception $e) {
            Log::error("Round-robin: Exception during batch scraping", [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Vérifie s'il reste des scrapers actifs
     */
    private function hasActiveScrapers(): bool
    {
        foreach ($this->scrapers as $data) {
            if ($data['active']) {
                return true;
            }
        }
        return false;
    }

    /**
     * Définit la taille des lots
     */
    public function setBatchSize(int $size): void
    {
        $this->batchSize = $size;
    }

    /**
     * Définit le timeout par lot (en secondes)
     */
    public function setBatchTimeout(int $timeout): void
    {
        $this->batchTimeout = $timeout;
    }
}
