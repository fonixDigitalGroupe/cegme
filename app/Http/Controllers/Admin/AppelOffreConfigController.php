<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppelOffreConfig;
use App\Models\TypeMarche;
use App\Models\PoleActivite;
use Illuminate\Http\Request;

class AppelOffreConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configs = AppelOffreConfig::with(['typeMarche', 'poleActivite'])->orderBy('source_ptf')->paginate(15);
        return view('admin.appel-offre-configs.index', compact('configs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeMarches = TypeMarche::orderBy('nom')->get();
        $poleActivites = PoleActivite::orderBy('nom')->get();
        return view('admin.appel-offre-configs.create', compact('typeMarches', 'poleActivites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'source_ptf' => ['required', 'string', 'max:255'],
            'type_marche_id' => ['nullable', 'exists:type_marches,id'],
            'pole_activite_id' => ['nullable', 'exists:pole_activites,id'],
            'zone_geographique' => ['nullable', 'string', 'max:255'],
            'site_officiel' => ['nullable', 'url', 'max:500'],
        ]);

        AppelOffreConfig::create($validated);

        return redirect()->route('admin.appel-offre-configs.index')
            ->with('success', 'Configuration créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AppelOffreConfig $appelOffreConfig)
    {
        return view('admin.appel-offre-configs.show', compact('appelOffreConfig'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppelOffreConfig $appelOffreConfig)
    {
        $typeMarches = TypeMarche::orderBy('nom')->get();
        $poleActivites = PoleActivite::orderBy('nom')->get();
        return view('admin.appel-offre-configs.edit', compact('appelOffreConfig', 'typeMarches', 'poleActivites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AppelOffreConfig $appelOffreConfig)
    {
        $validated = $request->validate([
            'source_ptf' => ['required', 'string', 'max:255'],
            'type_marche_id' => ['nullable', 'exists:type_marches,id'],
            'pole_activite_id' => ['nullable', 'exists:pole_activites,id'],
            'zone_geographique' => ['nullable', 'string', 'max:255'],
            'site_officiel' => ['nullable', 'url', 'max:500'],
        ]);

        $appelOffreConfig->update($validated);

        return redirect()->route('admin.appel-offre-configs.index')
            ->with('success', 'Configuration mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppelOffreConfig $appelOffreConfig)
    {
        $appelOffreConfig->delete();

        return redirect()->route('admin.appel-offre-configs.index')
            ->with('success', 'Configuration supprimée avec succès.');
    }

    /**
     * Lancer le scraping de tous les sites configurés
     */
    public function scrape()
    {
        try {
            $scraper = new \App\Services\AppelOffreScraperService();
            $total = $scraper->scrapeAll();

            return redirect()->route('admin.appel-offre-configs.index')
                ->with('success', "Scraping terminé : {$total} nouveaux appels d'offres récupérés.");
        } catch (\Exception $e) {
            return redirect()->route('admin.appel-offre-configs.index')
                ->with('error', 'Erreur lors du scraping : ' . $e->getMessage());
        }
    }
}
