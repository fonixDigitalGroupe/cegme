@extends('admin.layout')

@section('title', 'Créer une catégorie')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0;">Créer une catégorie</h1>
</div>

<div class="card">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Nom</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="form-input">
            @error('name') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-input">{{ old('description') }}</textarea>
            @error('description') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('admin.categories.index') }}" class="btn" style="background-color: #dc2626; color: rgb(255, 255, 255); border: none; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Annuler</a>
        </div>
    </form>
</div>
@endsection
