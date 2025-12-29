<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Support\Facades\Log;

class IFADScraperService
{
    /**
     * Lance le scraping de tous les appels d'offres IFAD
     * STRATÉGIE: Utiliser des liens de recherche contextuelle (comme World Bank)
     * Les notices UNGM sont chargées dynamiquement via JavaScript
     *
     * @return array
     */
    public function scrape(): array
    {
        Log::info('IFAD Scraper: Début du scraping (stratégie liens contextuels)');
        
        try {
            // URL de recherche UNGM avec filtre IFAD
            $searchUrl = 'https://www.ungm.org/Public/Notice?Agency=IFAD&Status=Open';
            
            // Vérifier si une offre IFAD existe déjà
            $existingOffre = Offre::where('source', 'IFAD')
                ->where('link_type', 'search_context')
                ->first();
            
            if ($existingOffre) {
                Log::info('IFAD Scraper: Offre contextuelle déjà existante', [
                    'count' => Offre::where('source', 'IFAD')->count(),
                ]);
                return [
                    'count' => 0,
                    'stats' => [
                        'total_pages_scraped' => 0,
                        'total_notices_kept' => Offre::where('source', 'IFAD')->count(),
                        'offres_par_page' => [],
                    ],
                ];
            }
            
            // Créer une offre contextuelle unique pour IFAD
            $offre = [
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
            
            Offre::insert($offre);
            
            $totalCount = 1;
            
            Log::info('IFAD Scraper: Offre contextuelle créée', [
                'url' => $searchUrl,
                'total_ifad' => Offre::where('source', 'IFAD')->count(),
            ]);

        } catch (\Exception $e) {
            Log::error('IFAD Scraper: Exception during scraping', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $totalCount = 0;
        }

        $stats = [
            'total_pages_scraped' => 0,
            'total_notices_kept' => $totalCount,
            'offres_par_page' => [],
        ];

        Log::info('IFAD Scraper: Résumé du scraping', $stats);

        return [
            'count' => $totalCount,
            'stats' => $stats,
        ];
    }
}
