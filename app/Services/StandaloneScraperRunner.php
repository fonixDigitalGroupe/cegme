<?php

namespace App\Services;

use App\Services\IterativeScraperInterface;
use App\Services\ScrapingProgressService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class StandaloneScraperRunner
{
    public function run(string $source, string $jobId, int $currentSourceNum, int $totalSources): int
    {
        $progressService = App::make(ScrapingProgressService::class);
        $progressService->updateSource($jobId, $source, $currentSourceNum);

        $foundCount = 0;

        try {
            $scraper = $this->getScraperForSource($source);

            if (!$scraper) {
                $progressService->markSourceFailed($jobId, $source, "Scraper non trouvé");
                return 0;
            }

            if (!($scraper instanceof IterativeScraperInterface)) {
                $result = $scraper->scrape();
                $count = $result['count'] ?? 0;
                $progressService->markSourceCompleted($jobId, $source, $count);
                return $count;
            }

            // Initialisation
            $scraper->setJobId($jobId);
            $scraper->initialize();

            $lotCount = 0;
            $maxLots = 50; // Sécurité ~750 items avec batch 15
            $targetOffers = 50; // Objectif Cible
            $hasMore = true;

            $emptyBatchCount = 0; // Compteur de lots vides consécutifs
            $maxEmptyBatches = 3; // Réduit pour accélérer si pas de résultats

            while ($hasMore && $foundCount < $targetOffers && $lotCount < $maxLots) {
                // Vérifier si annulé via UI
                if ($progressService->isCancelled($jobId)) {
                    return $foundCount;
                }

                $lotCount++;
                // Batch size augmenté pour performance (surtout Browsershot)
                $result = $scraper->scrapeBatch(15);

                $hasMore = $result['has_more'];
                $batchFindingsCount = isset($result['findings']) ? count($result['findings']) : 0;
                $foundCount += $batchFindingsCount;

                // Mettre à jour les trouvailles en temps réel dans l'UI
                if (!empty($result['findings'])) {
                    $progressService->addFindings($jobId, $result['findings']);
                }

                // Mettre à jour le message de progression UI
                $progressService->updateProgress($jobId, [
                    'message' => "Scraping de {$source}... {$foundCount} offres trouvées (Lot {$lotCount})",
                    'source_progress' => $foundCount
                ]);

                // Vérifier si le lot est vide pour skip si trop long
                if ($batchFindingsCount === 0) {
                    $emptyBatchCount++;
                    if ($emptyBatchCount >= $maxEmptyBatches) {
                        break;
                    }
                } else {
                    $emptyBatchCount = 0;
                }
            }

            $progressService->markSourceCompleted($jobId, $source, $foundCount);

        } catch (\Exception $e) {
            Log::error("StandaloneScraperRunner: Erreur sur {$source}: " . $e->getMessage());
            $progressService->markSourceFailed($jobId, $source, $e->getMessage());
        }

        return $foundCount;
    }

    private function getScraperForSource(string $source)
    {
        return match ($source) {
            'AFD' => App::make(AFDScraperService::class),
            'African Development Bank' => App::make(AfDBScraperService::class),
            'World Bank' => App::make(WorldBankScraperService::class),
            'DGMarket' => App::make(DGMarketScraperService::class),
            'BDEAC' => App::make(BDEACScraperService::class),
            'IFAD' => App::make(IFADScraperService::class),
            default => null,
        };
    }
}
