<?php

namespace App\Console\Commands;

use App\Models\AppelOffreConfig;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use DOMXPath;

class TestScraper extends Command
{
    protected $signature = 'test:scraper {url}';
    protected $description = 'Test le scraper sur une URL spécifique';

    public function handle()
    {
        $url = $this->argument('url');
        
        $this->info("Testing scraper on: {$url}");
        
        try {
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'fr-FR,fr;q=0.9,en;q=0.8',
                ])
                ->get($url);
            
            if (!$response->successful()) {
                $this->error("Failed to fetch: HTTP {$response->status()}");
                return 1;
            }

            $html = $response->body();
            $this->info("HTML length: " . strlen($html) . " bytes");
            
            // Sauvegarder le HTML
            $filename = storage_path('logs/test_page_' . date('Y-m-d_His') . '.html');
            file_put_contents($filename, $html);
            $this->info("HTML saved to: {$filename}");
            
            // Parser
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);
            
            // Compter les éléments
            $allLinks = $xpath->query('//a[@href]');
            $afdLinks = $xpath->query('//a[contains(@href, "appel") or contains(@href, "projet")]');
            $articles = $xpath->query('//article');
            $h2s = $xpath->query('//h2');
            $h3s = $xpath->query('//h3');
            
            $this->info("Total links: " . ($allLinks ? $allLinks->length : 0));
            $this->info("Links with 'appel' or 'projet': " . ($afdLinks ? $afdLinks->length : 0));
            $this->info("Articles: " . ($articles ? $articles->length : 0));
            $this->info("H2 tags: " . ($h2s ? $h2s->length : 0));
            $this->info("H3 tags: " . ($h3s ? $h3s->length : 0));
            
            // Afficher quelques liens pertinents
            if ($afdLinks && $afdLinks->length > 0) {
                $this->info("\nFirst 5 relevant links:");
                for ($i = 0; $i < min(5, $afdLinks->length); $i++) {
                    $link = $afdLinks->item($i);
                    $href = $link->getAttribute('href');
                    $text = trim($link->textContent);
                    $this->line("  " . ($i+1) . ". {$href} - " . substr($text, 0, 50));
                }
            }
            
            // Chercher les titres avec "Appel"
            $titles = $xpath->query('//h2[contains(text(), "Appel")] | //h3[contains(text(), "Appel")]');
            if ($titles && $titles->length > 0) {
                $this->info("\nFound " . $titles->length . " titles with 'Appel':");
                for ($i = 0; $i < min(5, $titles->length); $i++) {
                    $title = $titles->item($i);
                    $this->line("  " . substr(trim($title->textContent), 0, 80));
                }
            }
            
            // Vérifier si le contenu semble être chargé via JS
            if (strpos($html, 'appel') === false && strpos($html, 'projet') === false) {
                $this->warn("\n⚠ WARNING: HTML doesn't contain 'appel' or 'projet' keywords!");
                $this->warn("The page might load content via JavaScript.");
                $this->warn("You may need to use a headless browser (Puppeteer, Selenium) to scrape this site.");
            }
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}

