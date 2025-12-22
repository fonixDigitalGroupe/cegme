@extends('admin.layout')

@section('title', 'Modifier un pôle d\'activité')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Modifier un pôle d'activité</h1>
</div>

<form action="{{ route('admin.pole-activites.update', $poleActivite) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div style="background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px; padding: 1.5rem;">
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Nom <span style="color: #dc2626;">*</span></label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $poleActivite->nom) }}" required class="form-input" placeholder="Ex: Pôle Environnement, Pôle Mines & Technique..." style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('nom') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Description</label>
            <textarea name="description" id="description" rows="4" class="form-input" placeholder="Description du pôle d'activité..." style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ old('description', $poleActivite->description) }}</textarea>
            @error('description') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>

        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
            <a href="{{ route('admin.pole-activites.index') }}" style="padding: 0.625rem 1.25rem; background-color: #dc2626; color: white; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#b91c1c';" onmouseout="this.style.backgroundColor='#dc2626';">Annuler</a>
            <button type="submit" style="padding: 0.625rem 1.25rem; background-color: #ffffff; color: #374151; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-weight: 500; cursor: pointer; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#f9fafb';" onmouseout="this.style.backgroundColor='#ffffff';">Mettre à jour</button>
        </div>
    </div>
</form>
@endsection

