<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    /**
     * Display a listing of the appels d'offres.
     */
    public function index(Request $request)
    {
        // Récupérer TOUTES les offres (plus de filtre)
        $query = Offre::query()->orderBy('created_at', 'desc');

        // Recherche par mot-clé
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('acheteur', 'like', "%{$search}%")
                  ->orWhere('pays', 'like', "%{$search}%");
            });
        }

        // Filtre par pays (chercher dans les pays multiples aussi)
        if ($request->filled('pays')) {
            $paysFiltre = $request->pays;
            $query->where(function($q) use ($paysFiltre) {
                $q->where('pays', $paysFiltre) // Correspondance exacte
                  ->orWhere('pays', 'like', "{$paysFiltre},%") // Pays au début avec virgule
                  ->orWhere('pays', 'like', "%, {$paysFiltre}") // Pays à la fin avec virgule et espace
                  ->orWhere('pays', 'like', "%, {$paysFiltre},%") // Pays au milieu avec virgules et espaces
                  ->orWhere('pays', 'like', "%,{$paysFiltre},%") // Pays au milieu avec virgules sans espaces
                  ->orWhere('pays', 'like', "%{$paysFiltre}%"); // Correspondance partielle (fallback)
            });
        }

        $offres = $query->paginate(15)->withQueryString();

        // Récupérer la liste des pays uniques pour le filtre
        // Extraire tous les pays individuels (même dans les chaînes multiples)
        $allPaysStrings = Offre::whereNotNull('pays')
            ->where('pays', '!=', '')
            ->distinct()
            ->pluck('pays');
        
        // Extraire chaque pays individuellement depuis les chaînes multiples
        $paysUniques = collect();
        foreach ($allPaysStrings as $paysString) {
            // Séparer par virgule et nettoyer
            $paysList = array_map('trim', explode(',', $paysString));
            foreach ($paysList as $pays) {
                if (!empty($pays)) {
                    $paysUniques->push($pays);
                }
            }
        }
        
        $pays = $paysUniques->unique()->sort()->values();

        return view('offres', compact('offres', 'pays'));
    }
}
