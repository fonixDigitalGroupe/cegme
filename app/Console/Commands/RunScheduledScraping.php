<?php

namespace App\Console\Commands;

use App\Models\ScrapingSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunScheduledScraping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-scheduled-scraping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exécute le scraping automatique selon la fréquence configurée';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $schedule = ScrapingSchedule::first();

        if (!$schedule) {
            $this->info('Aucune configuration de scraping automatique trouvée.');
            return Command::SUCCESS;
        }

        if (!$schedule->shouldRun()) {
            $this->info('Le scraping n\'est pas encore dû. Prochaine exécution: ' . ($schedule->next_run_at ?? 'Non définie'));
            return Command::SUCCESS;
        }

        $this->info('🚀 Lancement du scraping automatique...');

        // Générer un jobId pour le suivi UI
        $jobId = \App\Services\ScrapingProgressService::generateJobId();

        // Lancer le scraping
        Artisan::call('app:scrape-active-sources', [
            '--job-id' => $jobId
        ]);

        // Mettre à jour les timestamps
        $schedule->update([
            'last_run_at' => now(),
            'next_run_at' => now()->addMinutes($schedule->getFrequencyInMinutes()),
        ]);

        $this->info('✓ Scraping terminé. Prochaine exécution: ' . $schedule->next_run_at);

        return Command::SUCCESS;
    }
}
