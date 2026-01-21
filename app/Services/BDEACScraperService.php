<?php

namespace App\Services;

use App\Models\Offre;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class BDEACScraperService implements IterativeScraperInterface
{
    private const BASE_URL = 'https://www.bdeac.org/jcms/rh_30762/appels-d-offres';
    private const MAX_PAGES = 100;

    private ?string $jobId = null;
    private int $currentPage = 0;
    private bool $isExhausted = false;
    private array $pendingOffers = [];

    public function setJobId(?string $jobId): void
    {
        $this->jobId = $jobId;
    }

    public function initialize(): void
    {
        $this->currentPage = 0;
        $this->isExhausted = false;
        $this->pendingOffers = [];
    }

    public function reset(): void
    {
        $this->initialize();
    }

    public function scrapeBatch(int $limit = 10): array
    {
        Log::info("BDEAC Scraper: Début scrapeBatch(limit=$limit)");
        $insertedCount = 0;

        // 1. Servir les offres en attente si présentes
        if (!empty($this->pendingOffers)) {
            $batch = array_splice($this->pendingOffers, 0, $limit);
            foreach ($batch as $offre) {
                if ($this->saveOffre($offre)) {
                    $insertedCount++;
                }
            }
            return [
                'count' => $insertedCount,
                'has_more' => !empty($this->pendingOffers) || !$this->isExhausted
            ];
        }

        if ($this->isExhausted) {
            return ['count' => 0, 'has_more' => false];
        }

        // 2. Scrapper une nouvelle page
        try {
            $result = $this->scrapePageForBatch($this->currentPage);
            $offersFound = $result['offers'];

            if (empty($offersFound)) {
                $this->isExhausted = true;
                return ['count' => 0, 'has_more' => false];
            }

            // Mettre en attente les offres trouvées
            $this->pendingOffers = $offersFound;
            $this->currentPage++;

            // Arrêter si on a atteint le maximum de pages configuré
            $maxPages = max(1, min((int) env('BDEAC_MAX_PAGES', 5), self::MAX_PAGES));
            if ($this->currentPage >= $maxPages) {
                $this->isExhausted = true;
            }

            // Servir le premier lot
            $batch = array_splice($this->pendingOffers, 0, $limit);
            foreach ($batch as $offre) {
                if ($this->saveOffre($offre)) {
                    $insertedCount++;
                }
            }

            return [
                'count' => $insertedCount,
                'has_more' => !empty($this->pendingOffers) || !$this->isExhausted
            ];

        } catch (\Exception $e) {
            Log::error('BDEAC Scraper: Exception during scrapeBatch', [
                'error' => $e->getMessage()
            ]);
            $this->isExhausted = true;
            return ['count' => 0, 'has_more' => false];
        }
    }

    private function saveOffre(array $offreData): bool
    {
        $exists = Offre::where('source', 'BDEAC')
            ->where(function ($query) use ($offreData) {
                $query->where('lien_source', $offreData['lien_source'])
                    ->orWhere('titre', $offreData['titre']);
            })
            ->exists();

        if (!$exists) {
            $offreData['created_at'] = now();
            $offreData['updated_at'] = now();
            Offre::insert($offreData);
            return true;
        }

        return false;
    }

    private function scrapePageForBatch(int $page): array
    {
        $offers = [];
        $html = '';

        try {
            $url = self::BASE_URL;
            if ($page > 0) {
                $url .= '?page=' . ($page + 1);
            }

            Log::debug('BDEAC Scraper: Fetching page', ['page' => $page, 'url' => $url]);

            // Utiliser Browsershot
            try {
                $html = Browsershot::url($url)
                    ->waitUntilNetworkIdle()
                    ->delay(2000)
                    ->timeout(120)
                    ->setOption('args', [
                        '--no-sandbox',
                        '--disable-setuid-sandbox',
                        '--disable-dev-shm-usage',
                        '--disable-blink-features=AutomationControlled',
                        '--disable-features=IsolateOrigins,site-per-process',
                    ])
                    ->dismissDialogs()
                    ->userAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->setExtraHttpHeaders(['Accept-Language' => 'fr-FR,fr;q=0.9,en;q=0.8'])
                    ->bodyHtml();

                if (empty($html)) {
                    return ['offers' => [], 'html' => ''];
                }
            } catch (\Exception $e) {
                Log::error('BDEAC Scraper: Browsershot failed, fallback to HTTP', ['url' => $url, 'error' => $e->getMessage()]);
                $response = Http::timeout(30)->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ])->get($url);
                if (!$response->successful())
                    return ['offers' => [], 'html' => ''];
                $html = $response->body();
            }

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);

            $items = $this->extractProcurementItems($xpath, $dom);
            $titresVus = [];

            foreach ($items as $item) {
                try {
                    $offre = $this->extractOffreData($item, $xpath);

                    if (!$offre || empty($offre['titre']) || empty($offre['lien_source']))
                        continue;

                    $titreNormalise = $this->normalizeTitle($offre['titre']);
                    if (isset($titresVus[$titreNormalise]))
                        continue;
                    $titresVus[$titreNormalise] = true;

                    if (!$this->validateUrl($offre['lien_source']))
                        continue;

                    $offers[] = $offre;
                } catch (\Exception $e) {
                    continue;
                }
            }
        } catch (\Exception $e) {
            Log::error('BDEAC Scraper: Error in scrapePageForBatch', ['page' => $page, 'error' => $e->getMessage()]);
        }

        return ['offers' => $offers, 'html' => $html];
    }

    /**
     * Lance le scraping de tous les appels d'offres BDEAC (compatibilité)
     */
    public function scrape(): array
    {
        $this->initialize();
        $totalCount = 0;
        $maxPages = max(1, min((int) env('BDEAC_MAX_PAGES', 5), self::MAX_PAGES));

        for ($i = 0; $i < $maxPages; $i++) {
            $batch = $this->scrapeBatch(100);
            $totalCount += $batch['count'];
            if (!$batch['has_more'])
                break;
        }

        return [
            'count' => $totalCount,
            'stats' => ['total_notices_kept' => $totalCount]
        ];
    }

    /**
     * Extrait les éléments de procurement depuis le DOM
     *
     * @param DOMXPath $xpath
     * @param DOMDocument $dom
     * @return array
     */
    private function extractProcurementItems(DOMXPath $xpath, DOMDocument $dom): array
    {
        $items = [];

        // Stratégie 1: Chercher les liens vers les appels d'offres
        $linkPatterns = [
            "//a[contains(@href, 'appels-d-offres')]",
            "//a[contains(@href, 'appel-d-offre')]",
            "//a[contains(@href, 'avis')]",
            "//a[contains(@href, '/jcms/')]",
            "//article//a[@href]",
            "//div[contains(@class, 'item')]//a[@href]",
            "//div[contains(@class, 'notice')]//a[@href]",
            "//li[contains(@class, 'item')]//a[@href]",
        ];

        $allLinks = [];
        foreach ($linkPatterns as $pattern) {
            $links = $xpath->query($pattern);
            foreach ($links as $link) {
                $allLinks[] = $link;
            }
        }

        foreach ($allLinks as $link) {
            $href = $link->getAttribute('href');
            $text = trim($link->textContent);

            // Ignorer les liens de navigation
            if (
                stripos($text, 'voir tout') !== false ||
                stripos($text, 'voir plus') !== false ||
                stripos($text, 'suivant') !== false ||
                stripos($text, 'précédent') !== false ||
                stripos($text, 'page') !== false ||
                strlen($text) < 20
            ) {
                continue;
            }

            // Trouver le conteneur parent
            $parent = $link->parentNode;
            $maxDepth = 5;
            $depth = 0;

            while ($parent && $depth < $maxDepth) {
                $parentText = trim($parent->textContent);
                if (strlen($parentText) > 50) {
                    $found = false;
                    foreach ($items as $existing) {
                        $existingLinks = $xpath->query(".//a[@href]", $existing);
                        if ($existingLinks->length > 0 && $existingLinks->item(0)->getAttribute('href') === $href) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $items[] = $parent;
                    }
                    break;
                }
                $parent = $parent->parentNode;
                $depth++;
            }
        }

        // Stratégie 2: Chercher par structure de liste/carte
        $selectors = [
            "//article",
            "//div[contains(@class, 'notice')]",
            "//div[contains(@class, 'item')]",
            "//div[contains(@class, 'card')]",
            "//li[contains(@class, 'item')]",
            "//tr[contains(@class, 'item')]",
        ];

        foreach ($selectors as $selector) {
            try {
                $nodes = $xpath->query($selector);
                foreach ($nodes as $node) {
                    $nodeLinks = $xpath->query(".//a[@href]", $node);
                    if ($nodeLinks->length > 0) {
                        $nodeHref = $nodeLinks->item(0)->getAttribute('href');
                        if (
                            stripos($nodeHref, 'appels-d-offres') !== false ||
                            stripos($nodeHref, '/jcms/') !== false
                        ) {
                            $found = false;
                            foreach ($items as $existing) {
                                $existingLinks = $xpath->query(".//a[@href]", $existing);
                                if ($existingLinks->length > 0 && $existingLinks->item(0)->getAttribute('href') === $nodeHref) {
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                $items[] = $node;
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $items;
    }

    /**
     * Extrait les données d'une offre depuis un élément DOM
     *
     * @param \DOMElement $item
     * @param DOMXPath $xpath
     * @return array|null
     */
    private function extractOffreData(\DOMElement $item, DOMXPath $xpath): ?array
    {
        try {
            // Extraire le titre et le lien
            $titre = null;
            $lien = null;

            // Chercher les liens dans l'élément
            $linkNodes = $xpath->query(".//a[@href]", $item);

            foreach ($linkNodes as $link) {
                $href = $link->getAttribute('href');
                $linkText = trim($link->textContent);

                // Ignorer les liens de navigation
                if (
                    stripos($href, 'javascript:') !== false ||
                    stripos($href, '#') === 0 ||
                    stripos($href, 'mailto:') !== false ||
                    stripos($linkText, 'voir tout') !== false ||
                    stripos($linkText, 'voir plus') !== false ||
                    stripos($linkText, 'suivant') !== false ||
                    stripos($linkText, 'précédent') !== false ||
                    strlen($linkText) < 20
                ) {
                    continue;
                }

                // Si le lien pointe vers un appel d'offres ou une page de détail
                if (
                    stripos($href, 'appels-d-offres') !== false ||
                    stripos($href, 'appel-d-offre') !== false ||
                    stripos($href, 'avis') !== false ||
                    stripos($href, '/jcms/') !== false
                ) {

                    $hrefNormalized = $this->normalizeUrl($href);

                    // Si le texte du lien est substantiel, c'est notre notice
                    if (strlen($linkText) > 20 && strlen($linkText) < 500) {
                        $titre = $linkText;
                        $lien = $hrefNormalized;
                        break;
                    }
                }
            }

            // Si pas de lien titre trouvé, chercher "En savoir plus"
            if (!$lien && $linkNodes->length > 0) {
                foreach ($linkNodes as $link) {
                    $href = $link->getAttribute('href');
                    $linkText = strtolower(trim($link->textContent));

                    if (
                        stripos($linkText, 'en savoir plus') !== false ||
                        stripos($linkText, 'lire la suite') !== false ||
                        stripos($linkText, 'détails') !== false
                    ) {

                        $hrefNormalized = $this->normalizeUrl($href);
                        if (
                            stripos($hrefNormalized, 'appels-d-offres') !== false ||
                            stripos($hrefNormalized, '/jcms/') !== false
                        ) {
                            $lien = $hrefNormalized;
                            break;
                        }
                    }
                }
            }

            // Si toujours pas de lien, chercher le titre dans les balises h*
            if (!$titre) {
                $titreNodes = $xpath->query(".//h1 | .//h2 | .//h3 | .//h4 | .//h5 | .//h6", $item);
                if ($titreNodes->length > 0) {
                    foreach ($titreNodes as $titreNode) {
                        $text = trim($titreNode->textContent);
                        if (strlen($text) > 20 && strlen($text) < 500) {
                            $titre = $text;
                            break;
                        }
                    }
                }
            }

            // Si toujours pas de titre, chercher dans le texte complet
            if (!$titre) {
                $fullText = trim($item->textContent);
                $lines = explode("\n", $fullText);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (strlen($line) > 30 && strlen($line) < 500) {
                        $titre = $line;
                        break;
                    }
                }
            }

            if (!$titre || !$lien) {
                return null;
            }

            // Extraire le type d'avis
            $type = $this->extractType($item, $xpath);

            // Extraire le pays/zone
            $pays = $this->extractCountry($item, $xpath);

            // Extraire les dates
            $datePublication = $this->extractPublicationDate($item, $xpath);
            $dateLimite = $this->extractDeadline($item, $xpath);

            return [
                'titre' => $titre,
                'acheteur' => 'Banque de Développement des États de l\'Afrique Centrale (BDEAC)',
                'pays' => $pays,
                'date_limite_soumission' => $dateLimite,
                'lien_source' => $lien,
                'source' => 'BDEAC',
                'detail_url' => $lien,
                'link_type' => 'detail',
                'notice_type' => $type,
            ];

        } catch (\Exception $e) {
            Log::warning('BDEAC Scraper: Error extracting data from item', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Extrait le type d'avis
     */
    private function extractType(\DOMElement $item, DOMXPath $xpath): ?string
    {
        $text = strtolower($item->textContent);

        $types = [
            'appel d\'offres' => 'Appel d\'offres',
            'avis de préqualification' => 'Avis de préqualification',
            'expression d\'intérêt' => 'Expression d\'intérêt',
            'consultation' => 'Consultation',
        ];

        foreach ($types as $keyword => $type) {
            if (stripos($text, $keyword) !== false) {
                return $type;
            }
        }

        return null;
    }

    /**
     * Extrait le pays/zone géographique
     */
    private function extractCountry(\DOMElement $item, DOMXPath $xpath): ?string
    {
        $text = $item->textContent;

        $countries = [
            'Cameroun',
            'Congo',
            'Gabon',
            'Guinée équatoriale',
            'République centrafricaine',
            'Tchad',
            'São Tomé-et-Príncipe',
            'Afrique centrale',
            'CEMAC',
        ];

        foreach ($countries as $country) {
            if (stripos($text, $country) !== false) {
                return $country;
            }
        }

        return null;
    }

    /**
     * Extrait la date de publication
     */
    private function extractPublicationDate(\DOMElement $item, DOMXPath $xpath): ?string
    {
        $text = $item->textContent;

        $patterns = [
            '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
            '/(\d{4})-(\d{2})-(\d{2})/',
            '/(\d{1,2})\s+(janvier|février|mars|avril|mai|juin|juillet|août|septembre|octobre|novembre|décembre)\s+(\d{4})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                try {
                    $dateStr = $matches[0];
                    $date = \Carbon\Carbon::parse($dateStr);
                    return $date->format('Y-m-d');
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return null;
    }

    /**
     * Extrait la date limite / date de clôture
     */
    private function extractDeadline(\DOMElement $item, DOMXPath $xpath): ?string
    {
        $text = strtolower($item->textContent);

        // Chercher des patterns comme "date limite", "clôture", "deadline"
        $deadlineKeywords = ['date limite', 'clôture', 'deadline', 'date de clôture', 'échéance'];

        foreach ($deadlineKeywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                // Chercher une date après le mot-clé
                $pos = stripos($text, $keyword);
                $substring = substr($text, $pos, 100);

                $patterns = [
                    '/(\d{1,2})\/(\d{1,2})\/(\d{4})/',
                    '/(\d{4})-(\d{2})-(\d{2})/',
                    '/(\d{1,2})\s+(janvier|février|mars|avril|mai|juin|juillet|août|septembre|octobre|novembre|décembre)\s+(\d{4})/i',
                ];

                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, $substring, $matches)) {
                        try {
                            $dateStr = $matches[0];
                            $date = \Carbon\Carbon::parse($dateStr);
                            return $date->format('Y-m-d');
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * Normalise une URL (relative -> absolue)
     */
    private function normalizeUrl(string $url): string
    {
        if (empty($url)) {
            return '';
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        if (str_starts_with($url, '/')) {
            return 'https://www.bdeac.org' . $url;
        }

        return 'https://www.bdeac.org/' . $url;
    }

    /**
     * Normalise un titre pour détecter les doublons
     */
    private function normalizeTitle(string $titre): string
    {
        $normalized = strtolower(trim($titre));
        $normalized = preg_replace('/\s+/', ' ', $normalized);
        $normalized = preg_replace('/[^\w\s]/', '', $normalized);
        return $normalized;
    }

    /**
     * Valide une URL HTTP (teste si elle retourne 200 OK)
     */
    private function validateUrl(string $url): bool
    {
        try {
            $response = Http::withoutVerifying()
                ->timeout(10)
                ->head($url);

            $status = $response->status();

            // Accepter seulement 200 OK
            if ($status === 200) {
                return true;
            }

            Log::debug('BDEAC Scraper: URL returned invalid status', [
                'url' => $url,
                'status' => $status,
            ]);
            return false;

        } catch (\Exception $e) {
            Log::debug('BDEAC Scraper: URL validation failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}




