<?php

namespace App\Console\Commands;

use App\Models\Offre;
use Illuminate\Console\Command;

class CheckAFDOffres extends Command
{
    protected $signature = 'app:check-afd-offres';
    protected $description = 'Vérifier les détails des offres AFD';

    public function handle()
    {
        $offres = Offre::where('source', 'AFD')->take(5)->get();
        
        $this->info('=== PREMIÈRES 5 OFFRES AFD ===');
        $this->newLine();
        
        foreach ($offres as $index => $offre) {
            $this->line("Offre #" . ($index + 1));
            $this->line("  Titre: " . substr($offre->titre ?? 'N/A', 0, 80));
            $this->line("  Type (link_type): " . ($offre->link_type ?? 'N/A'));
            $this->line("  Pays: " . ($offre->pays ?? 'N/A'));
            $this->line("  Acheteur: " . substr($offre->acheteur ?? 'N/A', 0, 60));
            $this->newLine();
        }
        
        $this->info("Total offres AFD: " . Offre::where('source', 'AFD')->count());
        
        return Command::SUCCESS;
    }
}




