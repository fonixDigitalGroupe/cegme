<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== RÉSULTATS DU SCRAPING ===\n\n";

// Total offres
$total = App\Models\Offre::count();
echo "Total offres: {$total}\n\n";

// Par source
echo "Répartition par source:\n";
$sources = App\Models\Offre::selectRaw('source, count(*) as count')
    ->groupBy('source')
    ->orderBy('count', 'desc')
    ->get();
foreach($sources as $s) {
    echo "  - {$s->source}: {$s->count}\n";
}

echo "\n";

// Offres avec dates
$withDates = App\Models\Offre::whereNotNull('date_limite_soumission')->count();
$withoutDates = $total - $withDates;
echo "Offres avec date limite: {$withDates}\n";
echo "Offres sans date limite: {$withoutDates}\n\n";

// Par source avec dates
echo "Offres avec dates par source:\n";
foreach($sources as $s) {
    $withDate = App\Models\Offre::where('source', $s->source)
        ->whereNotNull('date_limite_soumission')
        ->count();
    $percentage = $s->count > 0 ? round(($withDate / $s->count) * 100, 1) : 0;
    echo "  - {$s->source}: {$withDate}/{$s->count} ({$percentage}%)\n";
}

echo "\n";

// Exemples d'offres triées par date
echo "Exemples d'offres (triées par date limite, plus proche en premier):\n";
$examples = App\Models\Offre::whereNotNull('date_limite_soumission')
    ->orderBy('date_limite_soumission', 'asc')
    ->limit(10)
    ->get(['source', 'titre', 'date_limite_soumission', 'pays']);

if ($examples->count() > 0) {
    foreach($examples as $i => $offre) {
        $date = $offre->date_limite_soumission instanceof \Carbon\Carbon 
            ? $offre->date_limite_soumission->format('d/m/Y')
            : $offre->date_limite_soumission;
        $titre = mb_substr($offre->titre, 0, 60) . (mb_strlen($offre->titre) > 60 ? '...' : '');
        echo ($i + 1) . ". [{$offre->source}] {$titre}\n";
        echo "   Date: {$date} | Pays: " . ($offre->pays ?? 'N/A') . "\n\n";
    }
} else {
    echo "Aucune offre avec date trouvée.\n";
}

