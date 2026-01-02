@extends('admin.layout')

@section('title', 'Pôles d\'activité')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0;">Pôles d'activité</h1>
    <a href="{{ route('admin.activity-poles.create') }}" class="btn" style="background-color: #00C853; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center;">
        + Nouveau pôle
    </a>
</div>

@if(session('success'))
    <div style="padding: 1rem; background-color: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 4px; margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
    @forelse($activityPoles as $pole)
        <div style="background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px; padding: 1.5rem;">
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #1a1a1a; margin: 0 0 0.5rem 0;">{{ $pole->name }}</h3>
            @if($pole->description)
                <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 1rem 0;">{{ $pole->description }}</p>
            @endif
            <div style="margin-bottom: 1rem;">
                <strong style="font-size: 0.875rem; color: #374151;">Mots-clés ({{ $pole->keywords->count() }}):</strong>
                @if($pole->keywords->count() > 0)
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                        @foreach($pole->keywords as $keyword)
                            <span style="padding: 0.25rem 0.5rem; background-color: #f3f4f6; color: #374151; border-radius: 4px; font-size: 0.75rem;">{{ $keyword->keyword }}</span>
                        @endforeach
                    </div>
                @else
                    <p style="font-size: 0.875rem; color: #9ca3af; margin-top: 0.5rem;">Aucun mot-clé</p>
                @endif
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.activity-poles.edit', $pole) }}" style="color: #3b82f6; text-decoration: none; font-size: 0.875rem;">Modifier</a>
                <form method="POST" action="{{ route('admin.activity-poles.destroy', $pole) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce pôle d\'activité ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer; padding: 0; font-size: 0.875rem;">Supprimer</button>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; padding: 2rem; text-align: center; color: #9ca3af;">
            Aucun pôle d'activité configuré. <a href="{{ route('admin.activity-poles.create') }}" style="color: #3b82f6;">Créer le premier pôle</a>
        </div>
    @endforelse
</div>
@endsection




