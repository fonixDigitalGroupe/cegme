@extends('admin.layout')

@section('title', 'Créer une configuration')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Créer une configuration</h1>
</div>

<form action="{{ route('admin.appel-offre-configs.store') }}" method="POST">
    @csrf
    
    <div style="background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px; padding: 1.5rem;">
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Source (PTF) <span style="color: #dc2626;">*</span></label>
            <input type="text" name="source_ptf" id="source_ptf" value="{{ old('source_ptf') }}" required class="form-input" placeholder="Ex: Banque Mondiale, BAD, AFD, FIDA, BDEAC..." style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('source_ptf') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Type de Marché</label>
            <input type="text" name="type_marche" id="type_marche" value="{{ old('type_marche') }}" class="form-input" placeholder="Ex: Bureau d'études, Consultant Indiv., etc." style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('type_marche') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Zone Géographique</label>
            <input type="text" name="zone_geographique" id="zone_geographique" value="{{ old('zone_geographique') }}" class="form-input" placeholder="Ex: Afrique Centrale, Afrique de l'Ouest, etc." style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('zone_geographique') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Site officiel</label>
            <input type="url" name="site_officiel" id="site_officiel" value="{{ old('site_officiel') }}" class="form-input" placeholder="https://..." style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('site_officiel') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>

        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
            <a href="{{ route('admin.appel-offre-configs.index') }}" style="padding: 0.625rem 1.25rem; background-color: #dc2626; color: white; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#b91c1c';" onmouseout="this.style.backgroundColor='#dc2626';">Annuler</a>
            <button type="submit" style="padding: 0.625rem 1.25rem; background-color: #ffffff; color: #374151; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-weight: 500; cursor: pointer; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#f9fafb';" onmouseout="this.style.backgroundColor='#ffffff';">Créer</button>
        </div>
    </div>
</form>
@endsection

