<?php

namespace App\Console\Commands;

use App\Models\FilteringRule;
use App\Services\OfferFilteringService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestScrapingWithFilters extends Command
{
    protected $signature = 'app:test-scraping-filters';
    protected $description = 'Afficher les règles actives et tester le scraping avec filtrage';

    public function handle()
    {
        $this->info('=== RÈGLES DE FILTRAGE ACTIVES ===');
        $this->newLine();
        
        $rules = FilteringRule::where('is_active', true)
            ->with(['countries', 'activityPoles.keywords'])
            ->get();
        
        if ($rules->isEmpty()) {
            $this->warn('Aucune règle de filtrage active trouvée.');
            return Command::SUCCESS;
        }
        
        foreach ($rules as $rule) {
            $this->info("Règle: {$rule->name}");
            $this->line("  Source: {$rule->source}");
            $this->line("  Type de marché: " . ($rule->market_type ?? 'Tous'));
            
            $countries = $rule->countries->pluck('country');
            $this->line("  Pays: " . ($countries->isEmpty() ? 'Tous' : $countries->join(', ')));
            
            $poles = $rule->activityPoles->pluck('name');
            $this->line("  Pôles d'activité: " . ($poles->isEmpty() ? 'Aucun' : $poles->join(', ')));
            
            if ($rule->activityPoles->isNotEmpty()) {
                $this->line("  Mots-clés:");
                foreach ($rule->activityPoles as $pole) {
                    $keywords = $pole->keywords->pluck('keyword')->join(', ');
                    $this->line("    - {$pole->name}: {$keywords}");
                }
            }
            $this->newLine();
        }
        
        // Afficher le nombre d'offres actuel
        $totalOffres = DB::table('offres')->count();
        $this->info("Nombre d'offres dans la base: {$totalOffres}");
        
        $this->newLine();
        $this->info('=== INSTRUCTIONS ===');
        $this->line('Pour tester le scraping avec filtrage:');
        $sources = $rules->pluck('source')->unique();
        foreach ($sources as $source) {
            $command = $this->getScraperCommand($source);
            if ($command) {
                $this->line("  php artisan {$command}");
            }
        }
        
        return Command::SUCCESS;
    }
    
    private function getScraperCommand(string $source): ?string
    {
        $commands = [
            'AFD' => 'scrape:afd',
            'African Development Bank' => 'app:scrape-afdb',
            'World Bank' => 'app:scrape-world-bank',
            'DGMarket' => 'app:scrape-dgmarket',
            'BDEAC' => 'app:scrape-bdeac',
            'IFAD' => 'app:scrape-ifad',
            'TED' => 'app:scrape-ted',
        ];
        
        return $commands[$source] ?? null;
    }
}

