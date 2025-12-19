@extends('admin.layout')

@section('title', 'Créer un article')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0;">Créer un article</h1>
</div>

<div class="card">
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Titre</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="form-input">
            @error('title') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Contenu</label>
            <textarea name="content" rows="10" required class="form-input">{{ old('content') }}</textarea>
            @error('content') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Image mise en avant</label>
            <input type="file" name="featured_image" accept="image/*" class="form-input">
            @error('featured_image') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Statut</label>
            <select name="status" required class="form-input">
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publié</option>
                <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archivé</option>
            </select>
            @error('status') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Catégorie</label>
            <select name="category_id" class="form-input">
                <option value="">Aucune catégorie</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label">Tags</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.75rem;">
                @foreach($tags as $tag)
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} style="margin-right: 0.5rem;">
                        <span>{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('tags') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('admin.posts.index') }}" class="btn" style="background-color: #dc2626; color: rgb(255, 255, 255); border: none; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Annuler</a>
        </div>
    </form>
</div>
@endsection

