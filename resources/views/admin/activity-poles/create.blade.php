@extends('admin.layout')

@section('title', 'Créer un pôle d\'activité')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0;">Créer un pôle d'activité</h1>
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

<form method="POST" action="{{ route('admin.activity-poles.store') }}" style="background-color: #ffffff; padding: 1.5rem; border: 1px solid #d1d5db; border-radius: 4px;">
    @csrf

    <div style="margin-bottom: 1.5rem;">
        <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Nom du pôle *</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="description" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Description</label>
        <textarea id="description" name="description" rows="3" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">{{ old('description') }}</textarea>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Mots-clés</label>
        <div id="keywords-container">
            <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                <input type="text" name="keywords[]" placeholder="Mot-clé" style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
                <button type="button" onclick="addKeywordField()" style="padding: 0.5rem 1rem; background-color: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer;">+</button>
            </div>
        </div>
        <small style="color: #6b7280; font-size: 0.75rem;">Les mots-clés seront recherchés dans le titre, la description et l'acheteur des offres</small>
    </div>

    <div style="display: flex; gap: 0.5rem;">
        <button type="submit" style="padding: 0.625rem 1.25rem; background-color: #00C853; color: white; border: none; border-radius: 4px; font-weight: 500; cursor: pointer;">Créer</button>
        <a href="{{ route('admin.activity-poles.index') }}" style="padding: 0.625rem 1.25rem; background-color: #6b7280; color: white; border: none; border-radius: 4px; font-weight: 500; text-decoration: none; display: inline-block;">Annuler</a>
    </div>
</form>

<script>
function addKeywordField() {
    const container = document.getElementById('keywords-container');
    const div = document.createElement('div');
    div.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
    div.innerHTML = `
        <input type="text" name="keywords[]" placeholder="Mot-clé" style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem;">
        <button type="button" onclick="this.parentElement.remove()" style="padding: 0.5rem 1rem; background-color: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer;">-</button>
    `;
    container.appendChild(div);
}
</script>
@endsection

