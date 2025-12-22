<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MotCle;
use App\Models\PoleActivite;
use Illuminate\Http\Request;

class MotCleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motsCles = MotCle::with('poleActivite')->orderBy('nom')->paginate(15);
        return view('admin.mots-cles.index', compact('motsCles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $poleActivites = PoleActivite::orderBy('nom')->get();
        return view('admin.mots-cles.create', compact('poleActivites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'pole_activite_id' => ['required', 'exists:pole_activites,id'],
        ]);

        MotCle::create($validated);

        return redirect()->route('admin.mots-cles.index')
            ->with('success', 'Mot-clé créé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($mots_cle)
    {
        $motsCle = MotCle::findOrFail($mots_cle);
        $poleActivites = PoleActivite::orderBy('nom')->get();
        return view('admin.mots-cles.edit', compact('motsCle', 'poleActivites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $mots_cle)
    {
        $motsCle = MotCle::findOrFail($mots_cle);
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'pole_activite_id' => ['required', 'exists:pole_activites,id'],
        ]);

        $motsCle->update($validated);

        return redirect()->route('admin.mots-cles.index')
            ->with('success', 'Mot-clé mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($mots_cle)
    {
        $motsCle = MotCle::findOrFail($mots_cle);
        $motsCle->delete();

        return redirect()->route('admin.mots-cles.index')
            ->with('success', 'Mot-clé supprimé avec succès.');
    }
}
