<?php

namespace App\Http\Controllers;

use App\Models\AppelOffre;
use Illuminate\Http\Request;

class AppelOffreController extends Controller
{
    /**
     * Affiche la liste des appels d'offres
     */
    public function index(Request $request)
    {
        // Afficher tous les appels d'offres (publiés et non publiés)
        $query = AppelOffre::query();

        // Recherche par mot-clé
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filtre par pays
        if ($request->filled('pays')) {
            $query->byCountry($request->pays);
        }

        // Filtre par source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->byDateRange($request->date_debut, $request->date_fin);
        }

        // Tri par date (plus récent au plus ancien)
        $query->orderBy('date_limite', 'desc')
              ->orderBy('created_at', 'desc');

        $appelsOffres = $query->paginate(18)->withQueryString();

        // Récupérer la liste des pays uniques pour le filtre
        $pays = AppelOffre::whereNotNull('pays')
            ->distinct()
            ->pluck('pays')
            ->sort()
            ->values();

        // Récupérer la liste des sources uniques pour le filtre
        $sources = AppelOffre::whereNotNull('source')
            ->distinct()
            ->pluck('source')
            ->sort()
            ->values();

        // Statistiques
        $totalAppelsOffres = AppelOffre::count();
        $totalPublies = AppelOffre::where('is_actif', true)->count();

        $isAuthenticated = auth()->check();

        return view('appels-offres.index', compact('appelsOffres', 'pays', 'sources', 'totalAppelsOffres', 'totalPublies', 'isAuthenticated'));
    }
}
