<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityPole;
use App\Models\ActivityPoleKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityPoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activityPoles = ActivityPole::with('keywords')
            ->orderBy('name')
            ->get();

        return view('admin.activity-poles.index', compact('activityPoles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.activity-poles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Filtrer les mots-clés vides avant la validation
        if ($request->has('keywords')) {
            $request->merge([
                'keywords' => array_filter($request->input('keywords', []), function($keyword) {
                    return !empty(trim($keyword ?? ''));
                })
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated) {
            $activityPole = ActivityPole::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            // Ajouter les mots-clés
            if (!empty($validated['keywords'])) {
                foreach ($validated['keywords'] as $keyword) {
                    if (!empty(trim($keyword))) {
                        $activityPole->keywords()->create(['keyword' => trim($keyword)]);
                    }
                }
            }
        });

        return redirect()->route('admin.activity-poles.index')
            ->with('success', 'Pôle d\'activité créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityPole $activityPole)
    {
        $activityPole->load('keywords');
        return view('admin.activity-poles.show', compact('activityPole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityPole $activityPole)
    {
        $activityPole->load('keywords');
        return view('admin.activity-poles.edit', compact('activityPole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityPole $activityPole)
    {
        // Filtrer les mots-clés vides avant la validation
        if ($request->has('keywords')) {
            $request->merge([
                'keywords' => array_filter($request->input('keywords', []), function($keyword) {
                    return !empty(trim($keyword ?? ''));
                })
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated, $activityPole) {
            $activityPole->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            // Mettre à jour les mots-clés
            // Supprimer les anciens mots-clés
            $activityPole->keywords()->delete();

            // Ajouter les nouveaux mots-clés
            if (!empty($validated['keywords'])) {
                foreach ($validated['keywords'] as $keyword) {
                    if (!empty(trim($keyword))) {
                        $activityPole->keywords()->create(['keyword' => trim($keyword)]);
                    }
                }
            }
        });

        return redirect()->route('admin.activity-poles.index')
            ->with('success', 'Pôle d\'activité mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityPole $activityPole)
    {
        $activityPole->delete();

        return redirect()->route('admin.activity-poles.index')
            ->with('success', 'Pôle d\'activité supprimé avec succès.');
    }

    /**
     * Ajouter un mot-clé à un pôle d'activité (AJAX)
     */
    public function addKeyword(Request $request, ActivityPole $activityPole)
    {
        $validated = $request->validate([
            'keyword' => ['required', 'string', 'max:255'],
        ]);

        $keyword = $activityPole->keywords()->create([
            'keyword' => trim($validated['keyword']),
        ]);

        return response()->json([
            'success' => true,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Supprimer un mot-clé d'un pôle d'activité (AJAX)
     */
    public function removeKeyword(ActivityPole $activityPole, ActivityPoleKeyword $keyword)
    {
        if ($keyword->activity_pole_id !== $activityPole->id) {
            return response()->json([
                'success' => false,
                'message' => 'Le mot-clé n\'appartient pas à ce pôle d\'activité.',
            ], 403);
        }

        $keyword->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
