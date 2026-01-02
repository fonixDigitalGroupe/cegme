<?php

namespace App\Console\Commands;

use App\Models\Offre;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VerifyDeadlineDates extends Command
{
    protected $signature = 'app:verify-deadline-dates 
                            {--source= : Vérifier une source spécifique (ex: "World Bank")}
                            {--limit=10 : Nombre d\'offres à vérifier}
                            {--show-html : Afficher les extraits HTML où les dates ont été trouvées}';
    protected $description = 'Vérifier et tracer la récupération des dates limites avec preuves';

    public function handle()
    {
        $this->info('=== VÉRIFICATION DES DATES LIMITES ===');
        $this->newLine();

        $source = $this->option('source');
        $limit = (int) $this->option('limit');
        $showHtml = $this->option('show-html');

        // Récupérer les offres à vérifier
        $query = Offre::query();
        
        if ($source) {
            $query->where('source', $source);
        }
        
        $offres = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        if ($offres->isEmpty()) {
            $this->warn('Aucune offre trouvée.');
            return Command::SUCCESS;
        }

        $this->info("Vérification de {$offres->count()} offres" . ($source ? " (Source: {$source})" : ""));
        $this->newLine();

        $withDate = 0;
        $withoutDate = 0;
        $details = [];

        foreach ($offres as $offre) {
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            $this->info("📋 Offre #{$offre->id}: {$offre->titre}");
            $this->line("   Source: {$offre->source}");
            $this->line("   URL: {$offre->lien_source}");
            
            if ($offre->date_limite_soumission) {
                $withDate++;
                $dateStr = is_string($offre->date_limite_soumission) 
                    ? $offre->date_limite_soumission 
                    : $offre->date_limite_soumission->format('Y-m-d');
                
                $this->info("   ✅ Date limite: {$dateStr}");
                
                // Chercher dans les logs pour trouver la source de la date
                $this->findDateSourceInLogs($offre, $dateStr);
                
            } else {
                $withoutDate++;
                $this->warn("   ❌ Aucune date limite trouvée");
                
                // Expliquer pourquoi
                $this->explainMissingDate($offre);
            }
            
            $this->newLine();
        }

        // Résumé
        $this->info('=== RÉSUMÉ ===');
        $this->info("Offres avec date limite: {$withDate}");
        $this->warn("Offres sans date limite: {$withoutDate}");
        
        $percentage = $offres->count() > 0 ? round(($withDate / $offres->count()) * 100, 1) : 0;
        $this->info("Taux de récupération: {$percentage}%");
        
        if ($withoutDate > 0) {
            $this->newLine();
            $this->info('💡 Pour améliorer la récupération des dates:');
            $this->line('   1. Vérifier que les pages de notice sont accessibles');
            $this->line('   2. Vérifier les logs dans storage/logs/laravel.log');
            $this->line('   3. Utiliser --show-html pour voir les extraits HTML');
        }

        return Command::SUCCESS;
    }

    private function findDateSourceInLogs(Offre $offre, string $dateStr)
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!file_exists($logFile)) {
            $this->line("   📝 Logs non disponibles");
            return;
        }

        // Chercher dans les logs récents
        $searchTerms = [
            $offre->lien_source,
            $offre->titre,
            $dateStr,
        ];

        $found = false;
        $lines = file($logFile);
        $recentLines = array_slice($lines, -500); // Dernières 500 lignes

        foreach ($recentLines as $line) {
            if (stripos($line, 'World Bank Scraper') !== false || 
                stripos($line, 'WB') !== false ||
                stripos($line, 'deadline') !== false ||
                stripos($line, 'submission') !== false) {
                
                // Chercher des informations sur la source de la date
                if (stripos($line, 'API') !== false && stripos($line, $dateStr) !== false) {
                    $this->line("   📊 Source: API World Bank (submission_deadline_date)");
                    $found = true;
                    break;
                } elseif (stripos($line, 'notice') !== false && stripos($line, $dateStr) !== false) {
                    $this->line("   📄 Source: Page de notice HTML");
                    $found = true;
                    break;
                } elseif (stripos($line, 'table') !== false && stripos($line, $dateStr) !== false) {
                    $this->line("   📋 Source: Tableau HTML (label trouvé)");
                    $found = true;
                    break;
                } elseif (stripos($line, 'keyword') !== false && stripos($line, $dateStr) !== false) {
                    $this->line("   🔍 Source: Recherche par mot-clé dans le texte");
                    $found = true;
                    break;
                }
            }
        }

        if (!$found) {
            $this->line("   📝 Source: Non trouvée dans les logs récents");
            $this->line("   💡 Vérifiez storage/logs/laravel.log pour plus de détails");
        }
    }

    private function explainMissingDate(Offre $offre)
    {
        $this->line("   🔍 Raisons possibles:");
        
        if ($offre->source === 'World Bank') {
            $this->line("      • L'API n'a pas retourné submission_deadline_date");
            $this->line("      • La page de notice n'est pas accessible");
            $this->line("      • La date n'a pas été trouvée dans le HTML de la page");
            $this->line("      • La page de notice n'existe pas (notice_url manquant)");
            
            // Vérifier si notice_url existe
            if (empty($offre->lien_source) || 
                stripos($offre->lien_source, 'procurement/notice') === false) {
                $this->warn("      ⚠️  L'URL ne semble pas être une page de notice");
                $this->line("         URL actuelle: {$offre->lien_source}");
            }
        } else {
            $this->line("      • La date n'a pas été trouvée dans la page de détail");
            $this->line("      • La page de détail n'est pas accessible");
            $this->line("      • Le format de date n'est pas reconnu");
        }
    }
}

