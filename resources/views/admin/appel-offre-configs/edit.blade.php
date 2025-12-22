@extends('admin.layout')

@section('title', 'Modifier une configuration')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Modifier une configuration</h1>
</div>

<form action="{{ route('admin.appel-offre-configs.update', $appelOffreConfig) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div style="background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px; padding: 1.5rem;">
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Source (PTF) <span style="color: #dc2626;">*</span></label>
            <input type="text" name="source_ptf" id="source_ptf" value="{{ old('source_ptf', $appelOffreConfig->source_ptf) }}" required class="form-input" placeholder="Ex: Banque Mondiale, BAD, AFD, FIDA, BDEAC..." style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('source_ptf') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Type de Marché</label>
            <select name="type_marche_id" id="type_marche_id" class="form-input" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                <option value="">Sélectionner un type de marché</option>
                @foreach($typeMarches as $typeMarche)
                    <option value="{{ $typeMarche->id }}" {{ old('type_marche_id', $appelOffreConfig->type_marche_id) == $typeMarche->id ? 'selected' : '' }}>{{ $typeMarche->nom }}</option>
                @endforeach
            </select>
            @error('type_marche_id') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Pôle d'Activité</label>
            <select name="pole_activite_id" id="pole_activite_id" class="form-input" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                <option value="">Sélectionner un pôle d'activité</option>
                @foreach($poleActivites as $poleActivite)
                    <option value="{{ $poleActivite->id }}" {{ old('pole_activite_id', $appelOffreConfig->pole_activite_id) == $poleActivite->id ? 'selected' : '' }}>{{ $poleActivite->nom }}</option>
                @endforeach
            </select>
            @error('pole_activite_id') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Zone Géographique</label>
            <select name="zone_geographique" id="zone_geographique" class="form-input" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                <option value="">Sélectionner un pays/région</option>
                <optgroup label="Afrique Centrale">
                    <option value="Cameroun" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Cameroun' ? 'selected' : '' }}>Cameroun</option>
                    <option value="Congo" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Congo' ? 'selected' : '' }}>Congo</option>
                    <option value="Gabon" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Gabon' ? 'selected' : '' }}>Gabon</option>
                    <option value="Guinée" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Guinée' ? 'selected' : '' }}>Guinée</option>
                    <option value="République centrafricaine" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'République centrafricaine' ? 'selected' : '' }}>République centrafricaine</option>
                    <option value="République démocratique du Congo" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'République démocratique du Congo' ? 'selected' : '' }}>République démocratique du Congo</option>
                    <option value="Tchad" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Tchad' ? 'selected' : '' }}>Tchad</option>
                    <option value="Guinée équatoriale" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Guinée équatoriale' ? 'selected' : '' }}>Guinée équatoriale</option>
                    <option value="São Tomé-et-Príncipe" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'São Tomé-et-Príncipe' ? 'selected' : '' }}>São Tomé-et-Príncipe</option>
                </optgroup>
                <optgroup label="Afrique de l'Ouest">
                    <option value="Bénin" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Bénin' ? 'selected' : '' }}>Bénin</option>
                    <option value="Burkina Faso" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                    <option value="Cap-Vert" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Cap-Vert' ? 'selected' : '' }}>Cap-Vert</option>
                    <option value="Côte d'Ivoire" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Côte d\'Ivoire' ? 'selected' : '' }}>Côte d'Ivoire</option>
                    <option value="Gambie" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Gambie' ? 'selected' : '' }}>Gambie</option>
                    <option value="Ghana" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                    <option value="Guinée-Bissau" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Guinée-Bissau' ? 'selected' : '' }}>Guinée-Bissau</option>
                    <option value="Libéria" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Libéria' ? 'selected' : '' }}>Libéria</option>
                    <option value="Mali" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Mali' ? 'selected' : '' }}>Mali</option>
                    <option value="Mauritanie" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Mauritanie' ? 'selected' : '' }}>Mauritanie</option>
                    <option value="Niger" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Niger' ? 'selected' : '' }}>Niger</option>
                    <option value="Nigeria" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                    <option value="Sénégal" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Sénégal' ? 'selected' : '' }}>Sénégal</option>
                    <option value="Sierra Leone" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Sierra Leone' ? 'selected' : '' }}>Sierra Leone</option>
                    <option value="Togo" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Togo' ? 'selected' : '' }}>Togo</option>
                </optgroup>
                <optgroup label="Afrique de l'Est">
                    <option value="Burundi" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                    <option value="Comores" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Comores' ? 'selected' : '' }}>Comores</option>
                    <option value="Djibouti" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Djibouti' ? 'selected' : '' }}>Djibouti</option>
                    <option value="Érythrée" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Érythrée' ? 'selected' : '' }}>Érythrée</option>
                    <option value="Éthiopie" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Éthiopie' ? 'selected' : '' }}>Éthiopie</option>
                    <option value="Kenya" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                    <option value="Madagascar" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Madagascar' ? 'selected' : '' }}>Madagascar</option>
                    <option value="Maurice" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Maurice' ? 'selected' : '' }}>Maurice</option>
                    <option value="Ouganda" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Ouganda' ? 'selected' : '' }}>Ouganda</option>
                    <option value="Rwanda" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Rwanda' ? 'selected' : '' }}>Rwanda</option>
                    <option value="Seychelles" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Seychelles' ? 'selected' : '' }}>Seychelles</option>
                    <option value="Somalie" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Somalie' ? 'selected' : '' }}>Somalie</option>
                    <option value="Soudan" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Soudan' ? 'selected' : '' }}>Soudan</option>
                    <option value="Soudan du Sud" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Soudan du Sud' ? 'selected' : '' }}>Soudan du Sud</option>
                    <option value="Tanzanie" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Tanzanie' ? 'selected' : '' }}>Tanzanie</option>
                </optgroup>
                <optgroup label="Afrique Australe">
                    <option value="Afrique du Sud" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Afrique du Sud' ? 'selected' : '' }}>Afrique du Sud</option>
                    <option value="Angola" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Angola' ? 'selected' : '' }}>Angola</option>
                    <option value="Botswana" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Botswana' ? 'selected' : '' }}>Botswana</option>
                    <option value="Eswatini" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Eswatini' ? 'selected' : '' }}>Eswatini</option>
                    <option value="Lesotho" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Lesotho' ? 'selected' : '' }}>Lesotho</option>
                    <option value="Malawi" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Malawi' ? 'selected' : '' }}>Malawi</option>
                    <option value="Mozambique" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Mozambique' ? 'selected' : '' }}>Mozambique</option>
                    <option value="Namibie" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Namibie' ? 'selected' : '' }}>Namibie</option>
                    <option value="Zambie" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Zambie' ? 'selected' : '' }}>Zambie</option>
                    <option value="Zimbabwe" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Zimbabwe' ? 'selected' : '' }}>Zimbabwe</option>
                </optgroup>
                <optgroup label="Afrique du Nord">
                    <option value="Algérie" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Algérie' ? 'selected' : '' }}>Algérie</option>
                    <option value="Égypte" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Égypte' ? 'selected' : '' }}>Égypte</option>
                    <option value="Libye" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Libye' ? 'selected' : '' }}>Libye</option>
                    <option value="Maroc" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Maroc' ? 'selected' : '' }}>Maroc</option>
                    <option value="Soudan" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Soudan' ? 'selected' : '' }}>Soudan</option>
                    <option value="Tunisie" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Tunisie' ? 'selected' : '' }}>Tunisie</option>
                </optgroup>
                <optgroup label="Régions">
                    <option value="Afrique" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Afrique' ? 'selected' : '' }}>Afrique</option>
                    <option value="Afrique Centrale" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Afrique Centrale' ? 'selected' : '' }}>Afrique Centrale</option>
                    <option value="Afrique de l'Ouest" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Afrique de l\'Ouest' ? 'selected' : '' }}>Afrique de l'Ouest</option>
                    <option value="Afrique de l'Est" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Afrique de l\'Est' ? 'selected' : '' }}>Afrique de l'Est</option>
                    <option value="Afrique Australe" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Afrique Australe' ? 'selected' : '' }}>Afrique Australe</option>
                    <option value="Afrique du Nord" {{ old('zone_geographique', $appelOffreConfig->zone_geographique) == 'Afrique du Nord' ? 'selected' : '' }}>Afrique du Nord</option>
                </optgroup>
            </select>
            @error('zone_geographique') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Site officiel</label>
            <input type="url" name="site_officiel" id="site_officiel" value="{{ old('site_officiel', $appelOffreConfig->site_officiel) }}" class="form-input" placeholder="https://..." style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('site_officiel') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>

        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
            <a href="{{ route('admin.appel-offre-configs.index') }}" style="padding: 0.625rem 1.25rem; background-color: #dc2626; color: white; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#b91c1c';" onmouseout="this.style.backgroundColor='#dc2626';">Annuler</a>
            <button type="submit" style="padding: 0.625rem 1.25rem; background-color: #ffffff; color: #374151; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-weight: 500; cursor: pointer; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#f9fafb';" onmouseout="this.style.backgroundColor='#ffffff';">Mettre à jour</button>
        </div>
    </div>
</form>
@endsection

