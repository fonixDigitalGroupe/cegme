<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeMarche;
use Illuminate\Http\Request;

class TypeMarcheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeMarches = TypeMarche::orderBy('nom')->paginate(15);
        return view('admin.type-marches.index', compact('typeMarches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.type-marches.create');
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

        TypeMarche::create($validated);

        return redirect()->route('admin.type-marches.index')
            ->with('success', 'Type de marché créé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($type_march)
    {
        $typeMarche = TypeMarche::findOrFail($type_march);
        return view('admin.type-marches.edit', compact('typeMarche'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $type_march)
    {
        $typeMarche = TypeMarche::findOrFail($type_march);
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $typeMarche->update($validated);

        return redirect()->route('admin.type-marches.index')
            ->with('success', 'Type de marché mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($type_march)
    {
        $typeMarche = TypeMarche::findOrFail($type_march);
        $typeMarche->delete();

        return redirect()->route('admin.type-marches.index')
            ->with('success', 'Type de marché supprimé avec succès.');
    }
}
