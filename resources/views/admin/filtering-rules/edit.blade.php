@extends('admin.layout')

@section('title', 'Modifier une règle de filtrage')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0;">Modifier une règle de filtrage</h1>
</div>

@if($errors->any())
    <div style="padding: 1rem; background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 4px; margin-bottom: 1.5rem;">
        <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.filtering-rules.update', $filteringRule) }}" style="background-color: #ffffff; padding: 1.5rem; border: 1px solid #d1d5db; border-radius: 4px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 1.5rem;">
        <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Nom de la règle *</label>
        <input type="text" id="name" name="name" value="{{ old('name', $filteringRule->name) }}" required style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="source" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Source *</label>
        <select id="source" name="source" required style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
            @foreach($sources as $source)
                <option value="{{ $source }}" {{ old('source', $filteringRule->source) === $source ? 'selected' : '' }}>{{ $source }}</option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="market_type" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Type de marché</label>
        <select id="market_type" name="market_type" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
            <option value="">Aucun (tous les types)</option>
            <option value="bureau_d_etude" {{ old('market_type', $filteringRule->market_type) === 'bureau_d_etude' ? 'selected' : '' }}>Bureau d'études</option>
            <option value="consultant_individuel" {{ old('market_type', $filteringRule->market_type) === 'consultant_individuel' ? 'selected' : '' }}>Consultant individuel</option>
        </select>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Pays autorisés (optionnel)</label>
        <div id="countries-container">
            @foreach($filteringRule->countries as $country)
                <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <input type="text" name="countries[]" value="{{ $country->country }}" style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
                    <button type="button" onclick="this.parentElement.remove()" style="padding: 0.5rem 1rem; background-color: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer;">-</button>
                </div>
            @endforeach
            <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                <input type="text" name="countries[]" placeholder="Nom du pays" style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
                <button type="button" onclick="addCountryField()" style="padding: 0.5rem 1rem; background-color: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer;">+</button>
            </div>
        </div>
        <small style="color: #6b7280; font-size: 0.75rem;">Laissez vide pour accepter tous les pays</small>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Pôles d'activité (optionnel)</label>
        @foreach($activityPoles as $pole)
            <label style="display: flex; align-items: center; margin-bottom: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="activity_pole_ids[]" value="{{ $pole->id }}" {{ $filteringRule->activityPoles->contains($pole->id) ? 'checked' : '' }} style="margin-right: 0.5rem;">
                <span>{{ $pole->name }} ({{ $pole->keywords->count() }} mots-clés)</span>
            </label>
        @endforeach
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label style="display: flex; align-items: center; cursor: pointer;">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $filteringRule->is_active) ? 'checked' : '' }} style="margin-right: 0.5rem;">
            <span style="font-size: 0.875rem; font-weight: 500; color: #374151;">Règle active</span>
        </label>
    </div>

    <div style="display: flex; gap: 0.5rem;">
        <button type="submit" style="padding: 0.625rem 1.25rem; background-color: #00C853; color: white; border: none; border-radius: 4px; font-weight: 500; cursor: pointer;">Mettre à jour</button>
        <a href="{{ route('admin.filtering-rules.index') }}" style="padding: 0.625rem 1.25rem; background-color: #6b7280; color: white; border: none; border-radius: 4px; font-weight: 500; text-decoration: none; display: inline-block;">Annuler</a>
    </div>
</form>

<script>
function addCountryField() {
    const container = document.getElementById('countries-container');
    const div = document.createElement('div');
    div.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
    div.innerHTML = `
        <input type="text" name="countries[]" placeholder="Nom du pays" style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
        <button type="button" onclick="this.parentElement.remove()" style="padding: 0.5rem 1rem; background-color: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer;">-</button>
    `;
    container.appendChild(div);
}
</script>
@endsection

