<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\ActivityPole;
use App\Services\OfferFilteringService;
use App\Services\AfricanCountriesService;
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
        $sourceFilter = $request->get('source_filter'); // New source filter
        $status = $request->get('status', 'en_cours'); // Default to 'en_cours'

        // Récupérer TOUTES les offres (même les offres expirées)
        $query = Offre::query();

        // Appliquer les filtres
        if ($marketType) {
            if ($marketType === 'consultant_individuel') {
                $query->where('market_type', 'consultant_individuel');
            } elseif ($marketType === 'bureau_d_etude') {
                // Bureau d'étude est le "contraire" de consultant individuel
                // On prend tout ce qui est marqué bureau_d_etude OU qui n'est pas marqué consultant_individuel
                $query->where(function($q) {
                    $q->where('market_type', 'bureau_d_etude')
                      ->orWhereNull('market_type')
                      ->orWhere('market_type', '!=', 'consultant_individuel');
                });
            }
        }

        if ($sourceFilter) {
            $query->where('source', $sourceFilter);
        }

        // Les mots-clés sont maintenant gérés soit par le pôle d'activité soit par le pays.
        // On a supprimé le champ générique 'keyword' pour plus de clarté.

        // Filtrage géographique
        $subRegion = $request->get('sub_region');
        $regions = AfricanCountriesService::getAfricanRegions();

        if ($subRegion) {
            if (isset($regions[$subRegion])) {
                // Filtrer par sous-région spécifique (ex: central_africa)
                $regionKeywords = $regions[$subRegion]['keywords'];
                $query->where(function ($q) use ($regionKeywords) {
                    foreach ($regionKeywords as $kw) {
                        $q->orWhere('pays', 'like', '%' . $kw . '%');
                    }
                });
            } else {
                // Filtrer par pays spécifique (ex: Cameroun)
                // On utilise tous les variants (Cameroun, Cameroon, etc.)
                $countryKeywords = AfricanCountriesService::getKeywordsForCountry($subRegion);
                $query->where(function ($q) use ($countryKeywords) {
                    foreach ($countryKeywords as $kw) {
                        $q->orWhere('pays', 'like', '%' . $kw . '%');
                    }
                });
            }
        } else {
            // Sinon, filtrer par pays africains uniquement (OBLIGATOIRE par défaut)
            $africanKeywords = AfricanCountriesService::getAfricanCountriesKeywords();
            $query->where(function ($q) use ($africanKeywords) {
                foreach ($africanKeywords as $kw) {
                    $q->orWhere('pays', 'like', '%' . $kw . '%');
                }
            });
        }

        // Appliquer le pôle d'activité APRÈS le filtrage géographique (AND)
        if ($activityPoleId) {
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

        // Filtrer par statut (Date)
        $now = now();
        $filteredOffres = $filteredOffres->filter(function ($offre) use ($status, $now) {
            // Pays ne doit pas être null ou vide
            if (empty($offre->pays)) {
                return false;
            }

            $deadline = null;
            if (!empty($offre->date_limite_soumission)) {
                try {
                    $deadline = is_string($offre->date_limite_soumission) 
                        ? \Carbon\Carbon::parse($offre->date_limite_soumission) 
                        : $offre->date_limite_soumission;
                } catch (\Exception $e) {
                    // Ignore parsing errors
                }
            }

            if ($status === 'cloture') {
                // Clôturé: Date limite passée
                return $deadline && $deadline->lt($now);
            } else {
                // En cours: Date limite future ou aujourd'hui, ou pas de date
                return !$deadline || $deadline->gte($now);
            }
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

        // Trier par date limite de soumission (du plus proche au plus lointain)
        // Les offres sans date sont placées à la fin
        $filteredOffres = $filteredOffres->sortBy(function ($offre) {
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
            // Les offres sans date sont placées à la fin (date très lointaine)
            return '9999-12-31';
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
        
        // Régions et Pays pour le filtre
        $africanRegions = AfricanCountriesService::getAfricanRegions();
        $africanCountries = AfricanCountriesService::getAfricanCountriesFlat();
        
        // Liste des sources pour le filtre
        $sources = [
            'African Development Bank',
            'World Bank',
            'AFD',
            'BDEAC',
            'DGMarket',
            'IFAD',
        ];

        return view('offres', compact('offres', 'activityPoles', 'marketType', 'activityPoleId', 'keyword', 'status', 'africanRegions', 'subRegion', 'africanCountries', 'sources', 'sourceFilter'));
    }
}
