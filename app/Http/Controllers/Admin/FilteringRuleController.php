<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FilteringRule;
use App\Models\ActivityPole;
use App\Services\OfferFilteringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilteringRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rules = FilteringRule::with(['countries', 'activityPoles'])
                ->orderBy('source')
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Illuminate\Database\QueryException $e) {
            // Si la table n'existe pas encore, renvoyer une collection vide et logguer
            \Log::warning('FilteringRuleController@index: table filtering_rules manquante', ['error' => $e->getMessage()]);
            $rules = collect();
        }

        // Liste des sources disponibles
        $sources = [
            'African Development Bank',
            'World Bank',
            'AFD',
            'BDEAC',
            'DGMarket',
            'IFAD',
        ];

        return view('admin.filtering-rules.index', compact('rules', 'sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sources = [
            'African Development Bank',
            'World Bank',
            'AFD',
            'BDEAC',
            'DGMarket',
            'IFAD',
        ];

        try {
            $activityPoles = ActivityPole::with('keywords')->get();
        } catch (\Illuminate\Database\QueryException $e) {
            // Si la table n'existe pas encore, logguer et renvoyer une collection vide
            \Log::warning('FilteringRuleController@create: table activity_poles manquante', ['error' => $e->getMessage()]);
            $activityPoles = collect();
        }

        return view('admin.filtering-rules.create', compact('sources', 'activityPoles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Filtrer les pays vides avant la validation
        if ($request->has('countries')) {
            $request->merge([
                'countries' => array_filter($request->input('countries', []), function($country) {
                    return !empty(trim($country ?? ''));
                })
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'source' => ['required', 'string'],
            'market_type' => ['nullable', 'in:bureau_d_etude,consultant_individuel'],
            'is_active' => ['nullable', 'boolean'],
            'countries' => ['nullable', 'array'],
            'countries.*' => ['required', 'string'],
            'activity_pole_ids' => ['nullable', 'array'],
            'activity_pole_ids.*' => ['exists:activity_poles,id'],
        ], [
            'market_type.in' => 'Le type de marché doit être "Bureau d\'études" ou "Consultant individuel"',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $rule = FilteringRule::create([
                'name' => $validated['name'],
                'source' => $validated['source'],
                'market_type' => $validated['market_type'] ?? null,
                'is_active' => $request->has('is_active') && $request->input('is_active') == '1',
            ]);

            // Ajouter les pays
            if (!empty($validated['countries'])) {
                foreach ($validated['countries'] as $country) {
                    if (!empty(trim($country))) {
                        $rule->countries()->create(['country' => trim($country)]);
                    }
                }
            }

            // Associer les pôles d'activité
            if (!empty($validated['activity_pole_ids'])) {
                $rule->activityPoles()->sync($validated['activity_pole_ids']);
            }
        });

        return redirect()->route('admin.filtering-rules.index')
            ->with('success', 'Règle de filtrage créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FilteringRule $filteringRule)
    {
        // Rediriger vers la page d'édition (on n'a pas de vue show)
        return redirect()->route('admin.filtering-rules.edit', $filteringRule);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FilteringRule $filteringRule)
    {
        $filteringRule->load(['countries', 'activityPoles']);

        $sources = [
            'African Development Bank',
            'World Bank',
            'AFD',
            'BDEAC',
            'DGMarket',
            'IFAD',
        ];

        $activityPoles = ActivityPole::with('keywords')->get();

        return view('admin.filtering-rules.edit', compact('filteringRule', 'sources', 'activityPoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FilteringRule $filteringRule)
    {
        // Filtrer les pays vides avant la validation
        if ($request->has('countries')) {
            $request->merge([
                'countries' => array_filter($request->input('countries', []), function($country) {
                    return !empty(trim($country ?? ''));
                })
            ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'source' => ['required', 'string'],
            'market_type' => ['nullable', 'in:bureau_d_etude,consultant_individuel'],
            'is_active' => ['nullable', 'boolean'],
            'countries' => ['nullable', 'array'],
            'countries.*' => ['required', 'string'],
            'activity_pole_ids' => ['nullable', 'array'],
            'activity_pole_ids.*' => ['exists:activity_poles,id'],
        ], [
            'market_type.in' => 'Le type de marché doit être "Bureau d\'études" ou "Consultant individuel"',
        ]);

        DB::transaction(function () use ($validated, $request, $filteringRule) {
            $filteringRule->update([
                'name' => $validated['name'],
                'source' => $validated['source'],
                'market_type' => $validated['market_type'] ?? null,
                'is_active' => $request->has('is_active') && $request->input('is_active') == '1',
            ]);

            // Mettre à jour les pays
            $filteringRule->countries()->delete();
            if (!empty($validated['countries'])) {
                foreach ($validated['countries'] as $country) {
                    if (!empty(trim($country))) {
                        $filteringRule->countries()->create(['country' => trim($country)]);
                    }
                }
            }

            // Mettre à jour les pôles d'activité
            $filteringRule->activityPoles()->sync($validated['activity_pole_ids'] ?? []);
        });

        return redirect()->route('admin.filtering-rules.index')
            ->with('success', 'Règle de filtrage mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FilteringRule $filteringRule)
    {
        $filteringRule->delete();

        return redirect()->route('admin.filtering-rules.index')
            ->with('success', 'Règle de filtrage supprimée avec succès.');
    }

    /**
     * Relancer le filtrage sur toutes les offres
     */
    public function reapplyFiltering(Request $request, OfferFilteringService $filteringService)
    {
        $stats = $filteringService->applyFilteringToAllOffers();

        return redirect()->route('admin.filtering-rules.index')
            ->with('success', "Filtrage relancé. {$stats['filtered']} offres sur {$stats['total']} sont valides.");
    }
}
