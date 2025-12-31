<?php

namespace App\Services;

use App\Models\FilteringRule;

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
        return FilteringRule::where('is_active', true)
            ->pluck('source')
            ->unique()
            ->toArray();
    }

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
            'TED' => 'TED',
        ];

        return $mapping[$scraperSource] ?? $scraperSource;
    }
}

