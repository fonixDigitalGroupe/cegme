@extends('admin.layout')

@section('title', 'Gestion des tags')

@section('content')
<div style="margin-bottom: 4rem; display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0;">Gestion des tags</h1>
    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
        + Nouveau tag
    </a>
</div>

<div class="card" style="overflow-x: auto; margin-top: 2rem;">
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tags as $tag)
            <tr>
                <td>{{ $tag->name }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem;">
                        <a href="{{ route('admin.tags.edit', $tag) }}" class="btn-link" style="display: inline-flex; align-items: center; gap: 0.375rem; margin-right: 0;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Modifier
                        </a>
                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" style="display: inline; margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tag ?');">
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
                <td colspan="2" style="text-align: center; padding: 2rem; color: #6b7280;">Aucun tag trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($tags->hasPages())
<div style="margin-top: 1.5rem;">
    {{ $tags->links() }}
</div>
@endif
@endsection

