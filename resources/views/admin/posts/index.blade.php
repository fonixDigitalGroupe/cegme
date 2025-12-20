@extends('admin.layout')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Gestion des articles')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0;">Gestion des articles</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn" style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border: none;">
        + Nouvel article
    </a>
</div>

<!-- Formulaire de recherche et filtres -->
<div class="card" style="margin-bottom: 2rem; padding: 1.5rem;">
    <form method="GET" action="{{ route('admin.posts.index') }}" style="display: flex; flex-direction: column; gap: 1rem;">
        <!-- Barre de recherche et filtre statut -->
        <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: end;">
            <div>
                <label for="search" class="form-label">Rechercher</label>
                <input type="text" id="search" name="search" class="form-input" placeholder="Rechercher par titre, extrait ou contenu..." value="{{ request('search') }}">
            </div>
            <div style="min-width: 200px;">
                <label for="status" class="form-label">Statut</label>
                <select id="status" name="status" class="form-input">
                    <option value="">Tous les statuts</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archivé</option>
                </select>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div style="display: flex; gap: 0.75rem; margin-top: 0.5rem;">
            <button type="submit" class="btn" style="flex: 0 0 auto; background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border: none;">
                Rechercher
            </button>
            <a href="{{ route('admin.posts.index') }}" class="btn" style="flex: 0 0 auto; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; background-color: #dc2626; color: rgb(255, 255, 255); border: none;">
                Réinitialiser
            </a>
        </div>
    </form>
</div>

<div class="card" style="overflow-x: auto; margin-top: 2rem;">
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Catégorie</th>
                <th>Tags</th>
                <th>Statut</th>
                <th>Date de publication</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td>
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div style="display: none; width: 60px; height: 60px; background-color: #f3f4f6; border-radius: 4px; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.75rem;">Erreur</div>
                    @else
                        <div style="width: 60px; height: 60px; background-color: #f3f4f6; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.75rem;">
                            Pas d'image
                        </div>
                    @endif
                </td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->category->name ?? 'Aucune' }}</td>
                <td>
                    @if($post->tags->count() > 0)
                        <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                            @foreach($post->tags->take(3) as $tag)
                                <span style="display: inline-block; padding: 0.125rem 0.5rem; border-radius: 4px; font-size: 0.75rem; background-color: #e0f2fe; color: #0369a1;">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                            @if($post->tags->count() > 3)
                                <span style="font-size: 0.75rem; color: #6b7280;">+{{ $post->tags->count() - 3 }}</span>
                            @endif
                        </div>
                    @else
                        <span style="color: #9ca3af;">Aucun</span>
                    @endif
                </td>
                <td>
                    @php
                        $statusColors = [
                            'published' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                            'draft' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                            'archived' => ['bg' => '#f3f4f6', 'text' => '#6b7280']
                        ];
                        $statusLabels = [
                            'published' => 'Publié',
                            'draft' => 'Brouillon',
                            'archived' => 'Archivé'
                        ];
                        $color = $statusColors[$post->status] ?? $statusColors['archived'];
                    @endphp
                    <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                        {{ $statusLabels[$post->status] ?? $post->status }}
                    </span>
                </td>
                <td>
                    @if($post->published_at)
                        {{ $post->published_at->format('d/m/Y') }}
                    @else
                        <span style="color: #9ca3af;">Non publié</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem;">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn-link" style="display: inline-flex; align-items: center; gap: 0.375rem; margin-right: 0;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Modifier
                        </a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-link" style="color: #dc2626; display: inline-flex; align-items: center; gap: 0.375rem; padding: 0; border: none; background: none; cursor: pointer; font-family: inherit; font-size: inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 2rem; color: #6b7280;">Aucun article trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($posts->hasPages())
<div style="margin-top: 1.5rem;">
    {{ $posts->links() }}
</div>
@endif
@endsection

