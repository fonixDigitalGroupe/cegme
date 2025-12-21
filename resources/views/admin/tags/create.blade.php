@extends('admin.layout')

@section('title', 'Créer un tag')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Créer un tag</h1>
</div>

<form action="{{ route('admin.tags.store') }}" method="POST">
    @csrf
    
    <!-- Formulaire unifié -->
    <div style="background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px; padding: 1.5rem;">
        <!-- Informations principales -->
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Nom <span style="color: #dc2626;">*</span></label>
            <input type="text" name="name" id="tag-name" value="{{ old('name') }}" required class="form-input" placeholder="Nom du tag" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('name') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
            <a href="{{ route('admin.tags.index') }}" style="padding: 0.625rem 1.25rem; background-color: #dc2626; color: white; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#b91c1c';" onmouseout="this.style.backgroundColor='#dc2626';">Annuler</a>
            <button type="submit" style="padding: 0.625rem 1.25rem; background-color: #ffffff; color: #374151; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-weight: 500; cursor: pointer; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#f9fafb';" onmouseout="this.style.backgroundColor='#ffffff';">Créer</button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('tag-name');
    
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
    
    // Appliquer le masque au champ nom
    if (nameInput) {
        applyCapitalizeMask(nameInput);
    }
});
</script>
@endsection
