@extends('admin.layout')

@section('title', 'Scraping des Offres')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if(count($activeSources) > 0)
        <!-- Affichage des filtres actifs -->
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-body">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #374151;">📋 Filtres actifs par source</h3>
                
                @foreach($filteringRules as $source => $rules)
                    <div style="margin-bottom: 1.5rem; padding: 1rem; background-color: #f9fafb; border-radius: 8px;">
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #3b82f6; margin-bottom: 0.75rem;">{{ $source }}</h4>
                        
                        @foreach($rules as $rule)
                            <div style="margin-left: 1rem; margin-bottom: 0.75rem; padding: 0.75rem; background-color: white; border-radius: 6px; border-left: 3px solid #10b981;">
                                <div style="font-weight: 600; color: #374151; margin-bottom: 0.5rem;">{{ $rule->name }}</div>
                                
                                <div style="font-size: 0.875rem; color: #6b7280;">
                                    @if(!empty($rule->market_type))
                                        <div style="margin-bottom: 0.25rem;">
                                            <strong>Type de marché:</strong> 
                                            <span style="color: #059669;">
                                                {{ $rule->market_type === 'bureau_d_etude' ? 'Bureau d\'études' : 'Consultant individuel' }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if($rule->countries->isNotEmpty())
                                        <div style="margin-bottom: 0.25rem;">
                                            <strong>Pays autorisés:</strong> 
                                            <span style="color: #059669;">
                                                {{ $rule->countries->pluck('country')->implode(', ') }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if($rule->activityPoles->isNotEmpty())
                                        @php
                                            $keywords = [];
                                            foreach($rule->activityPoles as $activityPole) {
                                                $keywords = array_merge($keywords, $activityPole->keywords->pluck('keyword')->toArray());
                                            }
                                            $keywords = array_unique($keywords);
                                        @endphp
                                        @if(!empty($keywords))
                                            <div style="margin-bottom: 0.25rem;">
                                                <strong>Mots-clés requis:</strong> 
                                                <span style="color: #059669;">
                                                    {{ implode(', ', $keywords) }}
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                    
                                    @if(empty($rule->market_type) && $rule->countries->isEmpty() && $rule->activityPoles->isEmpty())
                                        <div style="color: #f59e0b; font-style: italic;">
                                            Aucun filtre spécifique (toutes les offres acceptées)
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        
        <div style="margin-bottom: 2rem; display: flex; gap: 0.5rem; align-items: center;">
            <button id="start-scraping-btn" style="background-color: #3b82f6; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; cursor: pointer;">
                Lancer le scraping
            </button>
            <button id="cancel-scraping-btn" style="display: none; background-color: #ef4444; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; cursor: pointer;">
                Annuler
            </button>
        </div>
    @else
        <div class="alert alert-warning">
            <p><strong>Aucune source active</strong></p>
            <p>Activez au moins une règle de filtrage dans <a href="{{ route('admin.filtering-rules.index') }}">Règles de filtrage</a> pour pouvoir lancer le scraping.</p>
        </div>
    @endif

    <!-- Zone de progression -->
    <div id="progress-container" class="card" style="display: none; margin-top: 2rem;">
        <div class="card-body">
            <div id="progress-status" style="margin-bottom: 1.5rem;">
                <p id="progress-message" style="font-size: 0.875rem; color: #6b7280;">Initialisation...</p>
            </div>

            <!-- Barre de progression -->
            <div style="margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span id="progress-text" style="font-size: 0.875rem; font-weight: 600; color: #374151;">0%</span>
                    <span id="progress-count" style="font-size: 0.875rem; color: #6b7280;">0 / 0</span>
                    <span id="total-offres" style="font-size: 0.875rem; color: #3b82f6; font-weight: 600;">0 offres</span>
                </div>
                <div style="width: 100%; height: 24px; background-color: #e5e7eb; border-radius: 12px; overflow: hidden;">
                    <div id="progress-bar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #10b981 0%, #059669 100%); transition: width 0.3s ease; display: flex; align-items: center; justify-content: center;">
                        <span id="progress-bar-text" style="color: white; font-size: 0.75rem; font-weight: 600;"></span>
                    </div>
                </div>
                <div style="display: flex; gap: 1rem; margin-top: 0.5rem; font-size: 0.8125rem; color: #6b7280;">
                    <span>⏱️ Écoulé: <strong id="elapsed-time">00:00</strong></span>
                    <span>🕒 Restant estimé: <strong id="eta-time">--:--</strong></span>
                </div>
            </div>

            <!-- Sources en cours et complétées -->
            <div id="sources-details" style="margin-bottom: 1.5rem;">
                <h3 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem; color: #374151;">Détails par source</h3>
                <div id="sources-list" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <!-- Sera rempli dynamiquement -->
                </div>
            </div>

            <!-- Sources échouées -->
            <div id="failed-sources" style="display: none;">
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.75rem; color: #dc2626;">Sources échouées</h3>
                <div id="failed-sources-list" style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <!-- Sera rempli dynamiquement -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .sources-list ul {
        list-style: none;
        padding: 0;
        margin: 0.5rem 0;
    }
    .sources-list li {
        padding: 0.5rem 1rem;
        background-color: #f3f4f6;
        border-radius: 6px;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .alert-success {
        background-color: #d1fae5;
        border: 1px solid #10b981;
        color: #065f46;
    }
    .alert-error {
        background-color: #fee2e2;
        border: 1px solid #ef4444;
        color: #991b1b;
    }
    .alert-warning {
        background-color: #fef3c7;
        border: 1px solid #f59e0b;
        color: #92400e;
    }
    .alert-warning a {
        color: #92400e;
        text-decoration: underline;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startBtn = document.getElementById('start-scraping-btn');
    const progressContainer = document.getElementById('progress-container');
    const progressBar = document.getElementById('progress-bar');
    const progressBarText = document.getElementById('progress-bar-text');
    const progressText = document.getElementById('progress-text');
    const progressCount = document.getElementById('progress-count');
        const progressMessage = document.getElementById('progress-message');
        const failedSourcesDiv = document.getElementById('failed-sources');
    const failedSourcesList = document.getElementById('failed-sources-list');
    const totalOffres = document.getElementById('total-offres');
    const sourcesList = document.getElementById('sources-list');
    const elapsedTime = document.getElementById('elapsed-time');
    const etaTime = document.getElementById('eta-time');
    const cancelBtn = document.getElementById('cancel-scraping-btn');

    let jobId = null;
    let pollingInterval = null;

    startBtn.addEventListener('click', function() {
        // Désactiver le bouton
        startBtn.disabled = true;
        startBtn.textContent = 'Lancement...';

        // Afficher la zone de progression
        progressContainer.style.display = 'block';
        progressContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        // Réinitialiser l'affichage
        progressBar.style.width = '0%';
        progressBarText.textContent = '';
        progressText.textContent = '0%';
        progressCount.textContent = '0 / 0';
        totalOffres.textContent = '0 offres';
        progressMessage.textContent = 'Initialisation...';
        failedSourcesList.innerHTML = '';
        sourcesList.innerHTML = '';
        failedSourcesDiv.style.display = 'none';
        
        // Afficher le bouton d'annulation
        if (cancelBtn) {
            cancelBtn.style.display = 'inline-block';
            cancelBtn.disabled = false;
        }

        // Lancer le scraping
        fetch('{{ route("admin.scraping.start") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                jobId = data.job_id;
                // Commencer le polling
                startPolling();
            } else {
                alert('Erreur : ' + (data.message || 'Une erreur est survenue'));
                startBtn.disabled = false;
                startBtn.textContent = 'Lancer';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du lancement du scraping');
            startBtn.disabled = false;
            startBtn.textContent = 'Lancer';
        });
    });

    function startPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }

        pollingInterval = setInterval(function() {
            if (!jobId) return;

            fetch('{{ route("admin.scraping.progress") }}?job_id=' + jobId, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.progress) {
                    updateProgress(data.progress);
                } else {
                    console.error('Erreur de progression:', data.message);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération de la progression:', error);
            });
        }, 1000); // Mise à jour toutes les secondes
    }

    function formatSeconds(sec) {
        if (sec == null || isNaN(sec)) return null;
        const s = Math.max(0, parseInt(sec, 10));
        const h = Math.floor(s / 3600);
        const m = Math.floor((s % 3600) / 60);
        const ss = s % 60;
        return h > 0
            ? `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(ss).padStart(2,'0')}`
            : `${String(m).padStart(2,'0')}:${String(ss).padStart(2,'0')}`;
    }

    function updateProgress(progress) {
        // Mettre à jour le pourcentage
        const percentage = progress.percentage || 0;
        progressBar.style.width = percentage + '%';
        progressBarText.textContent = percentage > 5 ? percentage + '%' : '';
        progressText.textContent = percentage + '%';
        progressCount.textContent = progress.current + ' / ' + progress.total;

        // Mettre à jour le nombre total d'offres
        if (progress.total_offres !== undefined) {
            totalOffres.textContent = progress.total_offres + ' offres';
        }

        // Mettre à jour temps écoulé & ETA
        if (typeof progress.elapsed_seconds !== 'undefined') {
            const t = formatSeconds(progress.elapsed_seconds);
            if (t) elapsedTime.textContent = t;
        }
        if (typeof progress.eta_seconds !== 'undefined') {
            const t = formatSeconds(progress.eta_seconds);
            etaTime.textContent = t ? t : '--:--';
        }

        // Mettre à jour le message
        if (progress.message) {
            progressMessage.textContent = progress.message;
        }

        // Mettre à jour les détails des sources
        let sourcesHtml = '';
        
        // Source actuelle
        if (progress.current_source && progress.status === 'running') {
            sourcesHtml += `
                <div style="padding: 0.75rem; background-color: #dbeafe; border-left: 4px solid #3b82f6; border-radius: 6px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 600; color: #1e40af;">⏳ ${progress.current_source}</span>
                        <span style="font-size: 0.75rem; color: #1e40af;">En cours...</span>
                    </div>
                </div>
            `;
        }

        // Sources complétées
        if (progress.completed_sources && progress.completed_sources.length > 0) {
            progress.completed_sources.forEach(source => {
                const offresText = source.offres_count > 0 ? ` (${source.offres_count} offres)` : '';
                sourcesHtml += `
                    <div style="padding: 0.75rem; background-color: #d1fae5; border-left: 4px solid #10b981; border-radius: 6px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600; color: #065f46;">✓ ${source.name}${offresText}</span>
                            <span style="font-size: 0.75rem; color: #047857;">Terminé</span>
                        </div>
                    </div>
                `;
            });
        }

        // Sources échouées
        if (progress.failed_sources && progress.failed_sources.length > 0) {
            failedSourcesDiv.style.display = 'block';
            failedSourcesList.innerHTML = progress.failed_sources.map(source => {
                return `
                    <div style="padding: 0.75rem; background-color: #fee2e2; border-left: 4px solid #ef4444; border-radius: 6px;">
                        <div style="font-weight: 600; color: #991b1b; margin-bottom: 0.25rem;">✗ ${source.name}</div>
                        <div style="font-size: 0.75rem; color: #991b1b;">${source.error || 'Erreur inconnue'}</div>
                    </div>
                `;
            }).join('');
        }

        sourcesList.innerHTML = sourcesHtml;

        // Vérifier si terminé ou annulé
        if (progress.status === 'completed' || progress.status === 'failed' || progress.status === 'cancelled') {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
            
            startBtn.disabled = false;
            startBtn.textContent = 'Lancer';
            
            if (cancelBtn) {
                cancelBtn.style.display = 'none';
            }

            if (progress.status === 'completed') {
                progressMessage.textContent = progress.message || 'Scraping terminé avec succès !';
                progressBar.style.backgroundColor = '#10b981';
            } else if (progress.status === 'cancelled') {
                progressMessage.textContent = progress.message || 'Scraping annulé';
                progressBar.style.backgroundColor = '#f59e0b';
            } else {
                progressMessage.textContent = progress.message || 'Le scraping a échoué';
                progressBar.style.backgroundColor = '#ef4444';
            }
        }
    }

    // Gestion de l'annulation
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            if (!jobId) return;
            
            if (!confirm('Êtes-vous sûr de vouloir annuler le scraping en cours ?')) {
                return;
            }

            cancelBtn.disabled = true;
            cancelBtn.textContent = 'Annulation...';

            fetch('{{ route("admin.scraping.cancel") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ job_id: jobId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cancelBtn.textContent = 'Annulé';
                    progressMessage.textContent = 'Annulation en cours...';
                } else {
                    alert('Erreur : ' + (data.message || 'Impossible d\'annuler le scraping'));
                    cancelBtn.disabled = false;
                    cancelBtn.textContent = 'Annuler';
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'annulation:', error);
                alert('Erreur lors de l\'annulation du scraping');
                cancelBtn.disabled = false;
                cancelBtn.textContent = 'Annuler';
            });
        });
    }
});
</script>
@endsection

