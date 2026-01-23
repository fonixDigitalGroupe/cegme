<?php

namespace App\Services;

use App\Models\FilteringRule;
use Illuminate\Support\Facades\Log;

class ScraperHelper
{
    /**
     * Vérifie si une source a au moins une règle de filtrage active
     *
     * @param string $source Le nom de la source (ex: 'AFD', 'African Development Bank')
     * @return bool
     */
    public static function hasActiveRule(string $source): bool
    {
        return FilteringRule::where('source', $source)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Récupère toutes les sources qui ont des règles actives
     *
     * @return array Liste des sources actives
     */
    public static function getActiveSources(): array
    {
        $sources = FilteringRule::where('is_active', true)
            ->pluck('source')
            ->unique()
            ->toArray();

        // Prioriser World Bank (API rapide) avant AfDB (Browsershot lent)
        $priority = ['World Bank', 'AFD', 'IFAD', 'DGMarket', 'BDEAC', 'African Development Bank'];

        usort($sources, function ($a, $b) use ($priority) {
            $posA = array_search($a, $priority);
            $posB = array_search($b, $priority);

            // Si non trouvé dans priority, mettre à la fin
            $posA = $posA === false ? 999 : $posA;
            $posB = $posB === false ? 999 : $posB;

            return $posA - $posB;
        });

        return $sources;
    }

    /**
     * Mappe le nom de source utilisé dans les scrapers vers le nom utilisé dans les règles de filtrage
     *
     * @param string $scraperSource Le nom de source du scraper
     * @return string Le nom de source correspondant dans les règles
     */
    /**
     * Mappe le nom de source utilisé dans les scrapers vers le nom utilisé dans les règles de filtrage
     *
     * @param string $scraperSource Le nom de source du scraper
     * @return string Le nom de source correspondant dans les règles
     */
    public static function mapScraperSourceToRuleSource(string $scraperSource): string
    {
        $mapping = [
            'AFD' => 'AFD',
            'African Development Bank' => 'African Development Bank',
            'World Bank' => 'World Bank',
            'DGMarket' => 'DGMarket',
            'BDEAC' => 'BDEAC',
            'IFAD' => 'IFAD',
        ];

        return $mapping[$scraperSource] ?? $scraperSource;
    }

    /**
     * Récupère les IDs des offres qui correspondent aux filtres actifs
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getIdsMatchingActiveFilters(): \Illuminate\Support\Collection
    {
        $activeRules = FilteringRule::with('countries')->where('is_active', true)->get();
        $allIds = collect();

        Log::info('Filtrage post-scraping: Début', [
            'active_sources' => $activeRules->pluck('source')->toArray()
        ]);

        foreach ($activeRules as $rule) {
            $allowedCountries = $rule->countries->pluck('country_name')->toArray();
            $query = \App\Models\Offre::where('source', $rule->source);

            $sourceCountBefore = $query->count();

            if ($rule->source === 'World Bank') {
                $ids = $query->pluck('id');
                $allIds = $allIds->merge($ids);
                Log::info("Filtrage post-scraping: World Bank (règle active)", ['kept_count' => count($ids)]);
                continue;
            }

            if (!empty($allowedCountries)) {
                $offres = $query->get();
                $keptCount = 0;
                foreach ($offres as $offre) {
                    if ($offre->getFilteredPays($allowedCountries)) {
                        $allIds->push($offre->id);
                        $keptCount++;
                    }
                }
                Log::info("Filtrage post-scraping: {$rule->source}", [
                    'total_found' => $sourceCountBefore,
                    'kept_after_country_filter' => $keptCount
                ]);
            } else {
                $ids = $query->pluck('id');
                $allIds = $allIds->merge($ids);
                Log::info("Filtrage post-scraping: {$rule->source} (pas de filtre pays)", ['kept_count' => count($ids)]);
            }
        }

        $result = $allIds->unique();
        Log::info('Filtrage post-scraping: Terminé', ['total_ids_to_keep' => $result->count()]);

        return $result;
    }
}

