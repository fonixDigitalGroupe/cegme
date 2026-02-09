@extends('admin.layout')

@section('title', 'Créer une catégorie')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem; text-align: center;">
        <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Créer une catégorie</h1>
    </div>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    
    <!-- Formulaire unifié -->
    <div style="background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px; padding: 1.5rem;">
        <!-- Informations principales -->
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Nom <span style="color: #dc2626;">*</span></label>
            <input type="text" name="name" id="category-name" value="{{ old('name') }}" required class="form-input" placeholder="Nom de la catégorie" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('name') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Description</label>
            <textarea name="description" id="category-description" rows="3" class="form-input" placeholder="Description de la catégorie (optionnel)" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ old('description') }}</textarea>
            @error('description') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
            <button type="submit" style="padding: 0.75rem 1.75rem; background-color: #00C853; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#00a946'" onmouseout="this.style.backgroundColor='#00C853'">Créer</button>
            <a href="{{ route('admin.categories.index') }}" style="padding: 0.75rem 1.75rem; background-color: #6b7280; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: inline-block; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">Annuler</a>
        </div>
    </div>
</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('category-name');
    const descriptionInput = document.getElementById('category-description');
    
    // Fonction pour mettre la première lettre en majuscule
    function capitalizeFirstLetter(text) {
        if (!text) return text;
        return text.charAt(0).toUpperCase() + text.slice(1);
    }
    
    // Fonction pour appliquer le masque de saisie
    function applyCapitalizeMask(input) {
        input.addEventListener('input', function(e) {
            const cursorPosition = this.selectionStart;
            const value = this.value;
            
            // Si le texte existe et que la première lettre n'est pas en majuscule
            if (value.length > 0 && value.charAt(0) !== value.charAt(0).toUpperCase()) {
                const newValue = capitalizeFirstLetter(value);
                this.value = newValue;
                // Restaurer la position du curseur
                const newCursorPosition = Math.min(cursorPosition, newValue.length);
                this.setSelectionRange(newCursorPosition, newCursorPosition);
            }
        });
        
        // S'assurer que la première lettre est en majuscule au focus
        input.addEventListener('focus', function() {
            if (this.value && this.value.charAt(0) !== this.value.charAt(0).toUpperCase()) {
                const cursorPosition = this.selectionStart;
                this.value = capitalizeFirstLetter(this.value);
                this.setSelectionRange(cursorPosition, cursorPosition);
            }
        });
    }
    
    // Appliquer le masque aux champs
    if (nameInput) {
        applyCapitalizeMask(nameInput);
    }
    
    if (descriptionInput) {
        applyCapitalizeMask(descriptionInput);
    }
});
</script>
@endsection
