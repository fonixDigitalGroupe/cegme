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
        // Récupérer toutes les offres sauf DGMarket
        $query = Offre::query()->where('source', '!=', 'DGMarket')->orderBy('created_at', 'desc');

        $offres = $query->paginate(12);

        return view('offres', compact('offres'));
    }
}
