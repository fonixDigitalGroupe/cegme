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

        // Récupérer toutes les offres sauf DGMarket
        $query = Offre::query()->where('source', '!=', 'DGMarket');

        // Appliquer les filtres
        if ($marketType) {
            // Filtrer par type de marché (basé sur le titre et l'acheteur)
            $query->where(function($q) use ($marketType) {
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
                $query->where(function($q) use ($keywords) {
                    foreach ($keywords as $kw) {
                        $q->orWhere('titre', 'like', '%' . $kw . '%')
                          ->orWhere('acheteur', 'like', '%' . $kw . '%');
                    }
                });
            }
        }

        if ($keyword) {
            // Filtrer par mot-clé
            $query->where(function($q) use ($keyword) {
                $q->where('titre', 'like', '%' . $keyword . '%')
                  ->orWhere('acheteur', 'like', '%' . $keyword . '%')
                  ->orWhere('pays', 'like', '%' . $keyword . '%');
            });
        }

        $allOffres = $query->get();

        // Appliquer le filtrage dynamique
        $filteredOffres = $filteringService->filterOffers($allOffres);

        // Règle métier: inclure TOUTES les World Bank, même si elles ne matchent pas les règles
        $wbOffres = $allOffres->filter(function ($o) { return $o->source === 'World Bank'; });
        $filteredOffres = $filteredOffres->merge($wbOffres)->unique('id');

        // Compter avant le filtre de date
        $countBeforeDateFilter = $filteredOffres->count();

        // Règle métier: garder les World Bank même si la date est NULL
        $filteredOffres = $filteredOffres->filter(function ($offre) {
            // Si source = World Bank et date NULL -> garder
            if ($offre->source === 'World Bank' && is_null($offre->date_limite_soumission)) {
                return true;
            }
            // Sinon, exiger une date valide
            if (is_null($offre->date_limite_soumission)) {
                return false;
            }
            if (is_string($offre->date_limite_soumission) && trim($offre->date_limite_soumission) === '') {
                return false;
            }
            if (is_object($offre->date_limite_soumission) && method_exists($offre->date_limite_soumission, 'format')) {
                try {
                    $offre->date_limite_soumission->format('Y-m-d');
                    return true;
                } catch (\Exception $e) {
                    return false;
                }
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

        // Trier par date limite (les plus proches en premier), puis mettre les WB sans date après
        $filteredOffres = $filteredOffres->sortBy(function ($offre) {
            try {
                if (!is_null($offre->date_limite_soumission)) {
                    if (is_object($offre->date_limite_soumission) && method_exists($offre->date_limite_soumission, 'format')) {
                        return '0-' . $offre->date_limite_soumission->format('Y-m-d'); // groupe 0 = datés
                    }
                    return '0-' . (string) $offre->date_limite_soumission;
                }
            } catch (\Exception $e) {}
            // Groupe 1 = WB sans date, Groupe 2 = autres sans date (devraient déjà être filtrées)
            return ($offre->source === 'World Bank') ? '1-9999-12-31' : '2-9999-12-31';
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
