@extends('admin.layout')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Gestion des articles')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Gestion des articles</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn" style="background-color: #00C853; color: rgb(255, 255, 255); border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;" onmouseover="this.style.backgroundColor='#00B04A';" onmouseout="this.style.backgroundColor='#00C853';">
        + Nouvel article
    </a>
</div>

<!-- Formulaire de recherche et filtres -->
<div style="margin-bottom: 1.5rem; padding: 1rem; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px;">
    <form method="GET" action="{{ route('admin.posts.index') }}" style="display: flex; gap: 1rem; align-items: flex-end;">
        <div style="flex: 1;">
            <label for="search" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Chercher:</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Rechercher..." style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        </div>
        <div style="min-width: 180px;">
            <label for="status" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Statut:</label>
            <select id="status" name="status" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                <option value="">Tous</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publié</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archivé</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" style="padding: 0.5rem 1rem; background-color: #ffffff; color: #374151; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; font-weight: 500; cursor: pointer; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#f9fafb';" onmouseout="this.style.backgroundColor='#ffffff';">
                Rechercher
            </button>
            <a href="{{ route('admin.posts.index') }}" style="padding: 0.5rem 1rem; background-color: rgba(220, 38, 38, 0.1); color: #dc2626; border: 1px solid rgba(220, 38, 38, 0.3); border-radius: 4px; font-size: 0.875rem; font-weight: 500; text-decoration: none; display: inline-block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='rgba(220, 38, 38, 0.15)'; this.style.borderColor='rgba(220, 38, 38, 0.4)';" onmouseout="this.style.backgroundColor='rgba(220, 38, 38, 0.1)'; this.style.borderColor='rgba(220, 38, 38, 0.3)';">
                Réinitialiser
            </a>
        </div>
    </form>
</div>

<div style="overflow-x: auto; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px;">
    <table style="width: 100%; border-collapse: collapse; margin: 0;">
        <thead>
            <tr style="background-color: #f9fafb; border-bottom: 2px solid #d1d5db;">
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Image</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Titre</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Auteur</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Catégorie</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Tags</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Statut</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Publication</th>
                <th style="padding: 0.75rem 1rem; text-align: right; font-size: 0.8125rem; font-weight: 600; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb;">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 3px; border: 1px solid #d1d5db;" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div style="display: none; width: 50px; height: 50px; background-color: #f3f4f6; border-radius: 3px; border: 1px solid #d1d5db; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.6875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">—</div>
                    @else
                        <div style="width: 50px; height: 50px; background-color: #f3f4f6; border-radius: 3px; border: 1px solid #d1d5db; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.6875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                            —
                        </div>
                    @endif
                </td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #1a1a1a; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $post->title }}</td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $post->user->name }}</td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">{{ $post->category->name ?? '—' }}</td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb;">
                    @if($post->tags->count() > 0)
                        <div style="display: flex; flex-wrap: wrap; gap: 0.375rem;">
                            @foreach($post->tags->take(2) as $tag)
                                <span style="display: inline-block; padding: 0.25rem 0.625rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; background-color: rgba(37, 99, 235, 0.1); color: #2563eb; border: 1px solid rgba(37, 99, 235, 0.2); font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <span style="color: #9ca3af; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">—</span>
                    @endif
                </td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb;">
                    @php
                        $statusLabels = [
                            'published' => 'Publié',
                            'draft' => 'Brouillon',
                            'archived' => 'Archivé'
                        ];
                        $statusColors = [
                            'published' => ['bg' => 'rgba(0, 200, 83, 0.1)', 'text' => '#00C853', 'border' => 'rgba(0, 200, 83, 0.2)'],
                            'draft' => ['bg' => 'rgba(251, 191, 36, 0.1)', 'text' => '#f59e0b', 'border' => 'rgba(251, 191, 36, 0.2)'],
                            'archived' => ['bg' => '#f3f4f6', 'text' => '#6b7280', 'border' => '#e5e7eb']
                        ];
                        $color = $statusColors[$post->status] ?? $statusColors['archived'];
                    @endphp
                    <span style="display: inline-block; padding: 0.25rem 0.625rem; border-radius: 4px; font-size: 0.75rem; font-weight: 500; background-color: {{ $color['bg'] }}; color: {{ $color['text'] }}; border: 1px solid {{ $color['border'] }}; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        {{ $statusLabels[$post->status] ?? $post->status }}
                    </span>
                </td>
                <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    @if($post->published_at)
                        {{ $post->published_at->format('d/m/Y') }}
                    @else
                        <span style="color: #9ca3af;">—</span>
                    @endif
                </td>
                <td style="padding: 0.75rem 1rem; text-align: right;">
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.375rem;">
                        <a href="{{ route('admin.posts.edit', $post) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; color: #2563eb; text-decoration: none; border-radius: 5px; background-color: transparent; transition: all 0.2s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#eff6ff'; this.style.color='#1d4ed8';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2563eb';" title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; padding: 0; border: none; background-color: transparent; cursor: pointer; color: #dc2626; border-radius: 5px; transition: all 0.2s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#fef2f2'; this.style.color='#b91c1c';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626';" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h14"></path>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2"></path>
                                    <path d="M5 6v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6"></path>
                                    <path d="M8 10v6"></path>
                                    <path d="M12 10v6"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 2rem; color: #9ca3af; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Aucun article trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($posts->hasPages())
<div style="margin-top: 0; padding: 0.75rem 1rem; background-color: #ffffff; border: 1px solid #d1d5db; border-top: none; border-radius: 0 0 4px 4px; display: flex; justify-content: space-between; align-items: center;">
    <div style="font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
        Lignes {{ $posts->firstItem() }} à {{ $posts->lastItem() }} sur {{ $posts->total() }}
    </div>
    <div>
        {{ $posts->links() }}
    </div>
</div>
@endif
@endsection

