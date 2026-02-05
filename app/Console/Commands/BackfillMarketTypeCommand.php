<?php

namespace App\Console\Commands;

use App\Models\Offre;
use App\Services\MarketTypeClassifier;
use Illuminate\Console\Command;

class BackfillMarketTypeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offres:backfill-market-type {--force : Force update even if market_type is already set}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill market_type based on title, buyer, and notice_type analysis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting market_type backfill...");

        $force = $this->option('force');
        $query = Offre::query();

        if (!$force) {
            $query->whereNull('market_type');
        }

        $total = $query->count();
        $bar = $this->output->createProgressBar($total);
        $updated = 0;

        $query->chunk(100, function ($offres) use ($bar, &$updated) {
            foreach ($offres as $offre) {
                // Combine text for analysis
                $textToAnalyze = ($offre->titre ?? '') . ' ' . ($offre->acheteur ?? '') . ' ' . ($offre->notice_type ?? '');
                
                $type = MarketTypeClassifier::classify($textToAnalyze);

                if ($type) {
                    $offre->market_type = $type;
                    $offre->save();
                    $updated++;
                }
                
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info("Backfill complete. updated {$updated} offers.");
    }
}
