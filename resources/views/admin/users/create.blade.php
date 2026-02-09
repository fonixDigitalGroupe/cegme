@extends('admin.layout')

@section('title', 'Créer un utilisateur')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem; text-align: center;">
        <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Créer un utilisateur</h1>
    </div>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    
    <!-- Formulaire unifié -->
    <div style="background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px; padding: 1.5rem;">
        <!-- Informations principales -->
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Nom <span style="color: #dc2626;">*</span></label>
            <input type="text" name="name" id="user-name" value="{{ old('name') }}" required class="form-input" placeholder="Nom de l'utilisateur" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('name') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Email <span style="color: #dc2626;">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="Email de l'utilisateur" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            @error('email') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
            <div>
                <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Mot de passe <span style="color: #dc2626;">*</span></label>
                <div style="position: relative;">
                    <input type="password" name="password" id="password" required class="form-input" placeholder="Mot de passe" style="width: 100%; padding: 0.625rem 2.5rem 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    <button type="button" onclick="togglePassword('password', 'password-toggle-1')" style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0.25rem; display: flex; align-items: center; color: #6b7280; opacity: 0.6; transition: opacity 0.2s;" onmouseover="this.style.opacity='1';" onmouseout="this.style.opacity='0.6';" title="Afficher/Masquer le mot de passe">
                        <svg id="password-toggle-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 10s4-6 9-6 9 6 9 6-4 6-9 6-9-6-9-6z"></path>
                            <circle cx="10" cy="10" r="3"></circle>
                        </svg>
                    </button>
                </div>
                @error('password') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Confirmer le mot de passe <span style="color: #dc2626;">*</span></label>
                <div style="position: relative;">
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="form-input" placeholder="Confirmer le mot de passe" style="width: 100%; padding: 0.625rem 2.5rem 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    <button type="button" onclick="togglePassword('password_confirmation', 'password-toggle-2')" style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0.25rem; display: flex; align-items: center; color: #6b7280; opacity: 0.6; transition: opacity 0.2s;" onmouseover="this.style.opacity='1';" onmouseout="this.style.opacity='0.6';" title="Afficher/Masquer le mot de passe">
                        <svg id="password-toggle-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 10s4-6 9-6 9 6 9 6-4 6-9 6-9-6-9-6z"></path>
                            <circle cx="10" cy="10" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <script>
            function togglePassword(inputId, iconId) {
                var input = document.getElementById(inputId);
                var icon = document.getElementById(iconId);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 10 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 10 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="19" y2="19"></line>';
                } else {
                    input.type = 'password';
                    icon.innerHTML = '<path d="M1 10s4-6 9-6 9 6 9 6-4 6-9 6-9-6-9-6z"></path><circle cx="10" cy="10" r="3"></circle>';
                }
            }
        </script>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label" style="font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Rôle</label>
            <select name="role_id" class="form-input" style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                <option value="">Aucun rôle</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->display_name }}
                    </option>
                @endforeach
            </select>
            @error('role_id') <p style="color: #dc2626; font-size: 0.8125rem; margin-top: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $message }}</p> @enderror
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
            <button type="submit" style="padding: 0.75rem 1.75rem; background-color: #00C853; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#00a946'" onmouseout="this.style.backgroundColor='#00C853'">Créer</button>
            <a href="{{ route('admin.users.index') }}" style="padding: 0.75rem 1.75rem; background-color: #6b7280; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: inline-block; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">Annuler</a>
        </div>
    </div>
</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('user-name');
    
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
