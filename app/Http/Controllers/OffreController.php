<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Services\OfferFilteringService;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    /**
     * Display a listing of the appels d'offres.
     */
    public function index(Request $request, OfferFilteringService $filteringService)
    {
        // Récupérer toutes les offres sauf DGMarket
        $query = Offre::query()->where('source', '!=', 'DGMarket');

        $allOffres = $query->get();

        // Appliquer le filtrage dynamique
        $filteredOffres = $filteringService->filterOffers($allOffres);

        // Trier par date limite de soumission (les plus proches en premier)
        // Les offres sans date limite seront placées en dernier
        $filteredOffres = $filteredOffres->sortBy(function ($offre) {
            // Si la date limite existe, retourner la date (les plus proches en premier)
            // Si NULL, retourner une date très lointaine pour les mettre en dernier
            return $offre->date_limite_soumission 
                ? $offre->date_limite_soumission->format('Y-m-d')
                : '9999-12-31'; // Date très lointaine pour mettre les NULL en dernier
        });

        // Paginer les résultats filtrés
        $currentPage = $request->get('page', 1);
        $perPage = 12;
        $offres = new \Illuminate\Pagination\LengthAwarePaginator(
            $filteredOffres->values()->forPage($currentPage, $perPage),
            $filteredOffres->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('offres', compact('offres'));
    }
}
