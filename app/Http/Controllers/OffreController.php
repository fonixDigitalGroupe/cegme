<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\ActivityPole;
use App\Services\OfferFilteringService;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    /**
     * Display a listing of the appels d'offres.
     */
    public function index(Request $request, OfferFilteringService $filteringService)
    {
        // Récupérer les paramètres de filtrage
        $marketType = $request->get('market_type');
        $activityPoleId = $request->get('activity_pole_id');
        $keyword = $request->get('keyword');

        // Récupérer TOUTES les offres sauf DGMarket (même les offres expirées)
        $query = Offre::query()
            ->where('source', '!=', 'DGMarket');

        // Appliquer les filtres
        if ($marketType) {
            // Filtrer par type de marché (basé sur le titre et l'acheteur)
            $query->where(function ($q) use ($marketType) {
                $text = '%';
                if ($marketType === 'bureau_d_etude') {
                    $keywords = ['bureau d\'étude', 'bureau d\'études', 'cabinet', 'consulting', 'étude', 'études'];
                    foreach ($keywords as $kw) {
                        $q->orWhere('titre', 'like', '%' . $kw . '%')
                            ->orWhere('acheteur', 'like', '%' . $kw . '%');
                    }
                } elseif ($marketType === 'consultant_individuel') {
                    $keywords = ['consultant individuel', 'individual consultant', 'expert individuel', 'individual expert'];
                    foreach ($keywords as $kw) {
                        $q->orWhere('titre', 'like', '%' . $kw . '%')
                            ->orWhere('acheteur', 'like', '%' . $kw . '%');
                    }
                }
            });
        }

        if ($activityPoleId) {
            // Filtrer par pôle d'activité (via les mots-clés)
            $activityPole = ActivityPole::with('keywords')->find($activityPoleId);
            if ($activityPole && $activityPole->keywords->isNotEmpty()) {
                $keywords = $activityPole->keywords->pluck('keyword')->toArray();
                $query->where(function ($q) use ($keywords) {
                    foreach ($keywords as $kw) {
                        $q->orWhere('titre', 'like', '%' . $kw . '%')
                            ->orWhere('acheteur', 'like', '%' . $kw . '%');
                    }
                });
            }
        }

        if ($keyword) {
            // Filtrer par mot-clé
            $query->where(function ($q) use ($keyword) {
                $q->where('titre', 'like', '%' . $keyword . '%')
                    ->orWhere('acheteur', 'like', '%' . $keyword . '%')
                    ->orWhere('pays', 'like', '%' . $keyword . '%');
            });
        }

        $allOffres = $query->get();

        // Appliquer le filtrage dynamique
        $filteredOffres = $filteringService->filterOffers($allOffres);

        // Règle métier: inclure TOUTES les World Bank, même si elles ne matchent pas les règles
        // Règle métier: inclure TOUTES les World Bank et IFAD, même si elles ne matchent pas les règles
        $wbOffres = $allOffres->filter(function ($o) {
            return in_array($o->source, ['World Bank', 'IFAD']);
        });
        $filteredOffres = $filteredOffres->merge($wbOffres)->unique('id');

        // Compter avant le filtre de date
        $countBeforeDateFilter = $filteredOffres->count();

        // Filtrer uniquement par pays non nul (afficher TOUTES les offres, même expirées)
        $filteredOffres = $filteredOffres->filter(function ($offre) {
            // Pays ne doit pas être null ou vide
            if (empty($offre->pays)) {
                return false;
            }
            return true;
        });

        // Compter après le filtre de date
        $countAfterDateFilter = $filteredOffres->count();

        // Log pour debug (si en mode debug)
        if (config('app.debug')) {
            \Log::info('OffresController: Filtrage', [
                'total_offres' => $allOffres->count(),
                'apres_filtrage_criteres' => $countBeforeDateFilter,
                'apres_filtrage_date' => $countAfterDateFilter,
            ]);
        }

        // Trier par date limite de soumission (du plus récent au plus ancien)
        // Les offres sans date sont placées à la fin
        $filteredOffres = $filteredOffres->sortByDesc(function ($offre) {
            try {
                if (!empty($offre->date_limite_soumission)) {
                    if (is_object($offre->date_limite_soumission) && method_exists($offre->date_limite_soumission, 'format')) {
                        return $offre->date_limite_soumission->format('Y-m-d');
                    }
                    return \Carbon\Carbon::parse($offre->date_limite_soumission)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                // En cas d'erreur de parsing, placer à la fin
            }
            // Les offres sans date sont placées à la fin (date très ancienne)
            return '1900-01-01';
        });

        // Paginer les résultats filtrés
        $currentPage = (int) $request->get('page', 1);
        $perPage = 12;
        $offres = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredOffres->values()->forPage($currentPage, $perPage),
            $filteredOffres->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Récupérer les pôles d'activité pour les filtres
        $activityPoles = ActivityPole::with('keywords')->get();

        return view('offres', compact('offres', 'activityPoles', 'marketType', 'activityPoleId', 'keyword'));
    }
}
