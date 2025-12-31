@extends('admin.layout')

@section('title', 'Règles de filtrage des offres')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0;">Règles de filtrage des offres</h1>
    <div style="display: flex; gap: 0.5rem;">
        <form method="POST" action="{{ route('admin.filtering-rules.reapply') }}" style="display: inline;">
            @csrf
            <button type="submit" style="background-color: #3b82f6; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; cursor: pointer;">
                🔄 Relancer le filtrage
            </button>
        </form>
        <a href="{{ route('admin.filtering-rules.create') }}" class="btn" style="background-color: #00C853; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center;">
            + Nouvelle règle
        </a>
    </div>
</div>

@if(session('success'))
    <div style="padding: 1rem; background-color: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 4px; margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif

<div style="overflow-x: auto; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f9fafb; border-bottom: 2px solid #d1d5db;">
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">Nom</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">Source</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">Type de marché</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">Pays</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">Pôles d'activité</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">Statut</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rules as $rule)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: #374151;">{{ $rule->name }}</td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: #374151;">{{ $rule->source }}</td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: #374151;">
                        @if($rule->market_type === 'bureau_d_etude')
                            Bureau d'études
                        @elseif($rule->market_type === 'consultant_individuel')
                            Consultant individuel
                        @else
                            <span style="color: #9ca3af;">Tous</span>
                        @endif
                    </td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: #374151;">
                        @if($rule->countries->count() > 0)
                            {{ $rule->countries->pluck('country')->join(', ') }}
                        @else
                            <span style="color: #9ca3af;">Tous</span>
                        @endif
                    </td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: #374151;">
                        @if($rule->activityPoles->count() > 0)
                            {{ $rule->activityPoles->pluck('name')->join(', ') }}
                        @else
                            <span style="color: #9ca3af;">Aucun</span>
                        @endif
                    </td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                        @if($rule->is_active)
                            <span style="color: #10b981; font-weight: 500;">✓ Actif</span>
                        @else
                            <span style="color: #ef4444; font-weight: 500;">✗ Inactif</span>
                        @endif
                    </td>
                    <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.filtering-rules.edit', $rule) }}" style="color: #3b82f6; text-decoration: none;">Modifier</a>
                            <form method="POST" action="{{ route('admin.filtering-rules.destroy', $rule) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette règle ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer; padding: 0;">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 2rem; text-align: center; color: #9ca3af;">
                        Aucune règle de filtrage configurée. <a href="{{ route('admin.filtering-rules.create') }}" style="color: #3b82f6;">Créer la première règle</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

