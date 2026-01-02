<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\ScraperHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class TestActiveSourcesScraping extends Command
{
    protected $signature = 'app:test-active-sources-scraping 
                            {--limit=5 : Nombre maximum de pages à scraper par source (pour le test)}
                            {--source= : Tester une source spécifique seulement}';
    protected $description = 'Tester le scraping des sources actives et vérifier que les dates limites sont récupérées';

    /**
     * Mapping des sources vers leurs commandes de scraping
     */
    private $sourceCommands = [
        'AFD' => 'scrape:afd',
        'African Development Bank' => 'app:scrape-afdb',
        'World Bank' => 'app:scrape-world-bank',
        'DGMarket' => 'app:scrape-dgmarket',
        'BDEAC' => 'app:scrape-bdeac',
        'IFAD' => 'app:scrape-ifad',
        'DG Market (TED)' => 'app:scrape-ted',
    ];

    public function handle()
    {
        $this->info('=== TEST DU SCRAPING DES SOURCES ACTIVES ===');
        $this->newLine();

        // Récupérer les sources actives
        $activeSources = ScraperHelper::getActiveSources();

        if (empty($activeSources)) {
            $this->warn('⚠ Aucune règle de filtrage active trouvée.');
            $this->info('💡 Activez au moins une règle de filtrage dans l\'admin avant de lancer le scraping.');
            return Command::FAILURE;
        }

        // Filtrer par source si spécifiée
        $sourceFilter = $this->option('source');
        if ($sourceFilter) {
            if (!in_array($sourceFilter, $activeSources)) {
                $this->error("⚠ La source '{$sourceFilter}' n'est pas active.");
                return Command::FAILURE;
            }
            $activeSources = [$sourceFilter];
        }

        $this->info('Sources actives à tester: ' . implode(', ', $activeSources));
        $this->newLine();

        // Compter les offres avant
        $countBefore = DB::table('offres')->count();
        $this->info("Nombre d'offres avant le test: {$countBefore}");
        $this->newLine();

        $results = [];
        $limit = (int) $this->option('limit');

        foreach ($activeSources as $source) {
            if (!isset($this->sourceCommands[$source])) {
                $this->warn("⚠ Aucune commande de scraping trouvée pour la source: {$source}");
                continue;
            }

            $command = $this->sourceCommands[$source];
            $this->info("--- Test de scraping: {$source} ---");
            $this->line("Commande: php artisan {$command}");
            
            // Pour World Bank, on peut limiter le nombre de pages via l'env
            if ($source === 'World Bank' && $limit > 0) {
                $this->line("⚠ Limite de pages: {$limit} (via WORLD_BANK_MAX_PAGES)");
            }

            $this->newLine();

            try {
                $startTime = microtime(true);
                
                // Lancer le scraping avec --force
                $exitCode = Artisan::call($command, ['--force' => true]);
                
                $duration = round(microtime(true) - $startTime, 2);
                
                if ($exitCode === 0) {
                    $this->info("✓ Scraping de {$source} terminé avec succès (durée: {$duration}s)");
                    
                    // Compter les offres ajoutées pour cette source
                    $countAfter = DB::table('offres')->where('source', $source)->count();
                    $newOffres = $countAfter - DB::table('offres')->where('source', $source)->where('created_at', '<', now()->subMinutes(5))->count();
                    
                    // Vérifier les dates limites
                    $offresWithDate = DB::table('offres')
                        ->where('source', $source)
                        ->whereNotNull('date_limite_soumission')
                        ->count();
                    
                    $offresWithoutDate = DB::table('offres')
                        ->where('source', $source)
                        ->whereNull('date_limite_soumission')
                        ->count();
                    
                    $totalOffres = $offresWithDate + $offresWithoutDate;
                    $datePercentage = $totalOffres > 0 ? round(($offresWithDate / $totalOffres) * 100, 1) : 0;
                    
                    $results[$source] = [
                        'success' => true,
                        'duration' => $duration,
                        'total_offres' => $totalOffres,
                        'with_date' => $offresWithDate,
                        'without_date' => $offresWithoutDate,
                        'date_percentage' => $datePercentage,
                    ];
                    
                    $this->line("  • Offres trouvées: {$totalOffres}");
                    $this->line("  • Avec date limite: {$offresWithDate} ({$datePercentage}%)");
                    if ($offresWithoutDate > 0) {
                        $this->warn("  • Sans date limite: {$offresWithoutDate}");
                    }
                    
                } else {
                    $this->warn("⚠ Scraping de {$source} terminé avec des erreurs (code: {$exitCode})");
                    $results[$source] = [
                        'success' => false,
                        'exit_code' => $exitCode,
                    ];
                }
            } catch (\Exception $e) {
                $this->error("✗ Erreur lors du scraping de {$source}: " . $e->getMessage());
                $results[$source] = [
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }

            $this->newLine();
        }

        // Résumé final
        $this->info('=== RÉSUMÉ DU TEST ===');
        $this->newLine();
        
        $successCount = 0;
        $failCount = 0;
        $totalOffres = 0;
        $totalWithDate = 0;
        $totalWithoutDate = 0;

        foreach ($results as $source => $result) {
            if ($result['success']) {
                $successCount++;
                $totalOffres += $result['total_offres'];
                $totalWithDate += $result['with_date'];
                $totalWithoutDate += $result['without_date'];
                
                $status = $result['date_percentage'] >= 80 ? '✓' : '⚠';
                $this->line("{$status} {$source}: {$result['total_offres']} offres, {$result['date_percentage']}% avec date limite");
            } else {
                $failCount++;
                $this->error("✗ {$source}: Échec");
            }
        }

        $this->newLine();
        $this->info("Sources testées avec succès: {$successCount}");
        if ($failCount > 0) {
            $this->warn("Sources en erreur: {$failCount}");
        }
        
        $this->info("Total d'offres scrapées: {$totalOffres}");
        $this->info("Offres avec date limite: {$totalWithDate}");
        if ($totalWithoutDate > 0) {
            $this->warn("Offres sans date limite: {$totalWithoutDate}");
            
            // Afficher quelques exemples d'offres sans date limite
            $this->newLine();
            $this->info("Exemples d'offres sans date limite:");
            $examples = Offre::whereNull('date_limite_soumission')
                ->whereIn('source', $activeSources)
                ->limit(5)
                ->get(['id', 'titre', 'source', 'lien_source']);
            
            foreach ($examples as $offre) {
                $this->line("  • [{$offre->source}] {$offre->titre}");
                $this->line("    URL: {$offre->lien_source}");
            }
        }
        
        $overallPercentage = $totalOffres > 0 ? round(($totalWithDate / $totalOffres) * 100, 1) : 0;
        $this->newLine();
        
        if ($overallPercentage >= 80) {
            $this->info("✓ Taux de récupération des dates limites: {$overallPercentage}% (excellent)");
        } elseif ($overallPercentage >= 50) {
            $this->warn("⚠ Taux de récupération des dates limites: {$overallPercentage}% (acceptable)");
        } else {
            $this->error("✗ Taux de récupération des dates limites: {$overallPercentage}% (problématique)");
        }

        $this->newLine();
        $countAfter = DB::table('offres')->count();
        $this->info("Nombre total d'offres dans la base: {$countAfter} (ajout: " . ($countAfter - $countBefore) . ")");

        return Command::SUCCESS;
    }
}

