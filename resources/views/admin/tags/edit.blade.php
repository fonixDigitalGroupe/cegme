@extends('admin.layout')

@section('title', 'Modifier un tag')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0;">Modifier un tag</h1>
</div>

<div class="card">
    <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label">Nom</label>
            <input type="text" name="name" value="{{ old('name', $tag->name) }}" required class="form-input">
            @error('name') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.tags.index') }}" class="btn" style="background-color: #dc2626; color: rgb(255, 255, 255); border: none; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Annuler</a>
        </div>
    </form>
</div>
@endsection
