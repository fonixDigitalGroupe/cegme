<?php

namespace App\Services;

interface IterativeScraperInterface
{
    /**
     * Initialise le scraper (position de départ, état initial)
     */
    public function initialize(): void;

    /**
     * Scrappe un lot d'offres (jusqu'à $limit)
     * 
     * @param int $limit Nombre maximum d'offres à scraper
     * @return array ['count' => int, 'has_more' => bool, 'findings' => array]
     */
    public function scrapeBatch(int $limit = 10): array;

    /**
     * Réinitialise l'état du scraper
     */
    public function reset(): void;

    /**
     * Définit l'ID du job pour le suivi de progression
     */
    public function setJobId(?string $jobId): void;
}
