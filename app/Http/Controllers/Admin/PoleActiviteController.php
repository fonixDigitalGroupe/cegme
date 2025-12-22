<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoleActivite;
use Illuminate\Http\Request;

class PoleActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $poleActivites = PoleActivite::withCount('motsCles')->orderBy('nom')->paginate(15);
        return view('admin.pole-activites.index', compact('poleActivites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pole-activites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        PoleActivite::create($validated);

        return redirect()->route('admin.pole-activites.index')
            ->with('success', 'Pôle d\'activité créé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($pole_activite)
    {
        $poleActivite = PoleActivite::findOrFail($pole_activite);
        return view('admin.pole-activites.edit', compact('poleActivite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $pole_activite)
    {
        $poleActivite = PoleActivite::findOrFail($pole_activite);
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $poleActivite->update($validated);

        return redirect()->route('admin.pole-activites.index')
            ->with('success', 'Pôle d\'activité mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($pole_activite)
    {
        $poleActivite = PoleActivite::findOrFail($pole_activite);
        $poleActivite->delete();

        return redirect()->route('admin.pole-activites.index')
            ->with('success', 'Pôle d\'activité supprimé avec succès.');
    }
}
