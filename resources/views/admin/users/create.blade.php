@extends('admin.layout')

@section('title', 'Créer un utilisateur')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0;">Créer un utilisateur</h1>
</div>

<div class="card">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Nom</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="form-input">
            @error('name') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="form-input">
            @error('email') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" required class="form-input">
            @error('password') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required class="form-input">
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label">Rôle</label>
            <select name="role_id" class="form-input">
                <option value="">Aucun rôle</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->display_name }}
                    </option>
                @endforeach
            </select>
            @error('role_id') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection

