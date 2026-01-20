@extends('admin.layout')

@section('title', 'Règles de filtrage des offres')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0;">Règles de filtrage des offres</h1>
    <div style="display: flex; gap: 0.5rem;">
        <button id="start-scraping-simple" type="button" style="background-color: #3b82f6; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; cursor: pointer;">
            Lancer le scraping
        </button>
        <form id="truncate-offres-form" method="POST" action="{{ route('admin.scraping.truncate') }}" style="display: inline;" onsubmit="return confirm('Cette action va supprimer toutes les offres. Continuer ?');">
            @csrf
            <button type="submit" style="background-color: #ef4444; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; cursor: pointer;">
                Vider la table offres
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
                        <div style="display: flex; align-items: center; justify-content: flex-start; gap: 0.375rem;">
                            <a href="{{ route('admin.filtering-rules.edit', $rule) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; color: #2563eb; text-decoration: none; border-radius: 5px; background-color: transparent; transition: all 0.2s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;" onmouseover="this.style.backgroundColor='#eff6ff'; this.style.color='#1d4ed8';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2563eb';" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.filtering-rules.destroy', $rule) }}" style="display: inline; margin: 0;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette règle ?');">
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
                    <td colspan="7" style="padding: 2rem; text-align: center; color: #9ca3af;">
                        Aucune règle de filtrage configurée. <a href="{{ route('admin.filtering-rules.create') }}" style="color: #3b82f6;">Créer la première règle</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('start-scraping-simple');
    // Le vidage utilise désormais un formulaire POST classique avec confirmation
    if (!btn) return;

    let polling = null;
    let jobId = null;
    let dots = 0;
    let dotsTimer = null;

    function setRunningState(running) {
        if (running) {
            btn.disabled = true;
            btn.style.opacity = '0.85';
            btn.textContent = 'Lancement du scraping...';
            if (dotsTimer) clearInterval(dotsTimer);
            dots = 0;
            dotsTimer = setInterval(() => {
                dots = (dots + 1) % 4;
                const suffix = '.'.repeat(dots);
                btn.textContent = 'Scraping en cours' + suffix;
            }, 600);
        } else {
            btn.disabled = false;
            btn.style.opacity = '1';
            if (dotsTimer) clearInterval(dotsTimer);
            btn.textContent = 'Lancer le scraping';
        }
    }

    function stopPolling() {
        if (polling) {
            clearInterval(polling);
            polling = null;
        }
    }

    btn.addEventListener('click', function() {
        // démarrer
        setRunningState(true);
        fetch('{{ route("admin.scraping.start") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({})
        })
        .then(r => {
            if (!r.ok) { throw new Error('HTTP ' + r.status); }
            return r.json();
        })
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Erreur lors du démarrage du scraping');
                setRunningState(false);
                return;
            }
            jobId = data.job_id;
            // Poll minimal pour savoir quand c'est fini
            polling = setInterval(() => {
                fetch('{{ route("admin.scraping.progress") }}?job_id=' + encodeURIComponent(jobId), {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(r => r.ok ? r.json() : Promise.reject(new Error('HTTP ' + r.status)))
                .then(p => {
                    if (p && p.success && p.progress) {
                        const status = p.progress.status;
                        if (status === 'completed' || status === 'failed' || status === 'cancelled') {
                            stopPolling();
                            setRunningState(false);
                            if (status === 'completed') {
                                alert('Scraping terminé avec succès. Offres mises à jour.');
                            } else if (status === 'cancelled') {
                                alert('Scraping annulé.');
                            } else {
                                alert('Le scraping a échoué.');
                            }
                            // Optionnel: recharger la page pour voir l'effet des règles si nécessaire
                            // location.reload();
                        }
                    }
                })
                .catch(() => {});
            }, 1000);
        })
        .catch(() => {
            alert('Erreur lors du démarrage du scraping');
            setRunningState(false);
        });
    });

    // (Pas de JS nécessaire ici pour le bouton de vidage)
});
</script>
@endsection

