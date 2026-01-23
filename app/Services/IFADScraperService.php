<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Support\Facades\Log;

class IFADScraperService implements IterativeScraperInterface
{
    private ?string $jobId = null;
    private bool $isExhausted = false;

    public function setJobId(?string $jobId): void
    {
        $this->jobId = $jobId;
    }

    public function initialize(): void
    {
        $this->isExhausted = false;
    }

    public function reset(): void
    {
        $this->isExhausted = false;
    }

    public function scrapeBatch(int $limit = 10): array
    {
        if ($this->isExhausted) {
            return ['count' => 0, 'has_more' => false];
        }

        Log::info('IFAD Scraper: Début du scraping (stratégie liens contextuels)');

        try {
            // URL de recherche UNGM avec filtre IFAD
            $searchUrl = 'https://www.ungm.org/Public/Notice?Agency=IFAD&Status=Open';

            // Vérifier si une offre IFAD existe déjà
            $existingOffre = Offre::where('source', 'IFAD')
                ->where('link_type', 'search_context')
                ->first();

            if ($existingOffre) {
                Log::info('IFAD Scraper: Offre contextuelle déjà existante');
                $this->isExhausted = true;
                return [
                    'count' => 0,
                    'has_more' => false,
                    'findings' => [], // Aucune nouvelle offre
                ];
            }

            // Créer une offre contextuelle unique pour IFAD
            $offreData = [
                'titre' => 'Appels d\'offres IFAD',
                'acheteur' => 'IFAD',
                'pays' => null,
                'date_limite_soumission' => null,
                'lien_source' => $searchUrl,
                'source' => 'IFAD',
                'detail_url' => null,
                'link_type' => 'search_context',
                'notice_type' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Offre::insert($offreData);

            Log::info('IFAD Scraper: Offre contextuelle créée', [
                'url' => $searchUrl,
            ]);

            $this->isExhausted = true;
            return [
                'count' => 1,
                'has_more' => false,
                'findings' => [$offreData], // Ajouter l'offre créée
            ];

        } catch (\Exception $e) {
            Log::error('IFAD Scraper: Exception during scraping', [
                'error' => $e->getMessage(),
            ]);
            $this->isExhausted = true;
            return [
                'count' => 0,
                'has_more' => false,
            ];
        }
    }

    /**
     * Lance le scraping de tous les appels d'offres IFAD
     * (Conservé pour compatibilité)
     */
    public function scrape(): array
    {
        $this->initialize();
        $result = $this->scrapeBatch(10);

        $stats = [
            'total_pages_scraped' => 0,
            'total_notices_kept' => $result['count'],
            'offres_par_page' => [],
        ];

        return [
            'count' => $result['count'],
            'stats' => $stats,
        ];
    }
}
