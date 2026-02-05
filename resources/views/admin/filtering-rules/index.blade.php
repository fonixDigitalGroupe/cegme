@extends('admin.layout')

@section('title', 'Règles de filtrage des offres')

@section('content')
    <!-- Configuration du scraping automatique -->
    <div
        style="padding: 1.5rem; margin-bottom: 2rem; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
        <h2
            style="font-size: 1.125rem; font-weight: 600; color: #1a1a1a; margin-bottom: 1.25rem;">
            Scraping Automatique
        </h2>
        <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <label style="font-size: 0.875rem; font-weight: 500; color: #374151;">Fréquence:</label>
                <select id="scraping-frequency"
                    style="min-width: 200px; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.875rem; color: #374151; background-color: #ffffff; cursor: pointer;">
                    <option value="1min">Toutes les 1 minute</option>
                    <option value="30min">Toutes les 30 minutes</option>
                    <option value="1hour">Toutes les 1 heure</option>
                    <option value="24hours" selected>Toutes les 24 heures</option>
                </select>
            </div>

            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <label style="font-size: 0.875rem; font-weight: 500; color: #000000;">Statut:</label>
                <label style="display: inline-flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" id="scraping-active"
                        style="width: 18px; height: 18px; cursor: pointer; margin-right: 0.5rem; accent-color: #10b981;">
                    <span id="scraping-status-text" style="font-size: 0.875rem; color: #6b7280;">Inactif</span>
                </label>
            </div>

            <button id="save-schedule" type="button"
                style="background-color: #10b981; color: white; border: none; padding: 0.5rem 1rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; cursor: pointer;">
                Enregistrer
            </button>

            <div id="schedule-info" style="font-size: 0.8125rem; color: #374151; margin-left: auto; border: 1px solid #d1d5db; background-color: #f9fafb; padding: 0.5rem 0.75rem; border-radius: 4px; font-weight: 500;">
                <span id="next-run-text"></span>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="font-size: 1.5rem; font-weight: 600; color: #1a1a1a; margin: 0;">Règles de filtrage des offres</h1>
        <div style="display: flex; gap: 0.5rem;">
            <button id="start-scraping-simple" type="button"
                style="background-color: #3b82f6; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; cursor: pointer;">
                Lancer le scraping
            </button>
            <button id="cancel-scraping-simple" type="button"
                style="display: none; background-color: #ef4444; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; cursor: pointer;">
                Arrêter le scraping
            </button>
            <a href="{{ route('admin.filtering-rules.create') }}" class="btn"
                style="background-color: #00C853; color: white; border: none; padding: 0.625rem 1.25rem; font-weight: 500; font-size: 0.875rem; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center;">
                + Nouvelle règle
            </a>
        </div>
    </div>


    @if(session('success'))
        <div
            style="padding: 1rem; background-color: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 4px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f9fafb; border-bottom: 2px solid #d1d5db;">
                    <th
                        style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">
                        Nom</th>
                    <th
                        style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">
                        Source</th>

                    <th
                        style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">
                        Statut</th>
                    <th
                        style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151;">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rules as $rule)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: #374151;">{{ $rule->name }}</td>
                        <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: #374151;">{{ $rule->source }}</td>

                        <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                            @if($rule->is_active)
                                <span style="color: #10b981; font-weight: 500;">✓ Actif</span>
                            @else
                                <span style="color: #ef4444; font-weight: 500;">✗ Inactif</span>
                            @endif
                        </td>
                        <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                            <div style="display: flex; align-items: center; justify-content: flex-start; gap: 0.375rem;">
                                <a href="{{ route('admin.filtering-rules.edit', $rule) }}"
                                    style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; color: #2563eb; text-decoration: none; border-radius: 5px; background-color: transparent; transition: all 0.2s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
                                    onmouseover="this.style.backgroundColor='#eff6ff'; this.style.color='#1d4ed8';"
                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2563eb';"
                                    title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20"
                                        fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.filtering-rules.destroy', $rule) }}"
                                    style="display: inline; margin: 0;"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette règle ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; padding: 0; border: none; background-color: transparent; cursor: pointer; color: #dc2626; border-radius: 5px; transition: all 0.2s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
                                        onmouseover="this.style.backgroundColor='#fef2f2'; this.style.color='#b91c1c';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626';"
                                        title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 20 20"
                                            fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"
                                            stroke-linejoin="round">
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
                        <td colspan="4" style="padding: 2rem; text-align: center; color: #9ca3af;">
                            Aucune règle de filtrage configurée. <a href="{{ route('admin.filtering-rules.create') }}"
                                style="color: #3b82f6;">Créer la première règle</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Barre de progression (déplacée après le tableau) -->
    <div id="scraping-progress-container"
        style="display: none; margin-top: 1.5rem; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
            <span id="scraping-status-label"
                style="font-weight: 600; color: #374151; font-size: 0.9375rem;">Initialisation...</span>
            <span id="scraping-percentage" style="font-weight: 700; color: #3b82f6; font-size: 0.9375rem;">0%</span>
        </div>
        <div style="width: 100%; background-color: #e5e7eb; border-radius: 9999px; height: 10px; overflow: hidden;">
            <div id="scraping-progress-bar"
                style="width: 0%; height: 100%; background-color: #3b82f6; transition: width 0.4s ease; border-radius: 9999px;">
            </div>
        </div>
        <p id="scraping-details" style="margin-top: 0.75rem; font-size: 0.8125rem; color: #6b7280;"></p>

        <div style="margin-top: 1.25rem; display: flex; justify-content: flex-end;">
            <button id="cancel-scraping-large" type="button"
                style="display: none; background-color: #ef4444; color: white; border: none; padding: 0.5rem 1rem; font-weight: 600; font-size: 0.875rem; border-radius: 4px; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                ⚠ Arrêter le scraping en cours
            </button>
        </div>

        <div id="recent-findings"
            style="margin-top: 1rem; border-top: 1px solid #f3f4f6; padding-top: 1rem; display: none;">
            <h4
                style="font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.025em; color: #9ca3af; margin-bottom: 0.5rem; font-weight: 700;">
                Dernières trouvailles :</h4>
            <ul id="findings-list" style="list-style: none; padding: 0; margin: 0; max-height: 120px; overflow-y: auto;">
                <!-- Rempli en JS -->
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('start-scraping-simple');
            const cancelBtn = document.getElementById('cancel-scraping-simple');
            const cancelBtnLarge = document.getElementById('cancel-scraping-large');
            const progContainer = document.getElementById('scraping-progress-container');
            const progBar = document.getElementById('scraping-progress-bar');
            const progPercentage = document.getElementById('scraping-percentage');
            const progLabel = document.getElementById('scraping-status-label');
            const progDetails = document.getElementById('scraping-details');
            const findingsContainer = document.getElementById('recent-findings');
            const findingsList = document.getElementById('findings-list');

            if (!btn) return;

            let polling = null;
            let jobId = null;
            let dots = 0;
            let dotsTimer = null;

            function setRunningState(running) {
                if (running) {
                    btn.disabled = true;
                    btn.style.opacity = '0.85';
                    btn.textContent = 'Scraping en cours...';
                    progContainer.style.display = 'block';
                    if (cancelBtn) {
                        cancelBtn.style.display = 'inline-block';
                        cancelBtn.disabled = false;
                        cancelBtn.textContent = 'Arrêter le scraping';
                    }
                    if (cancelBtnLarge) {
                        cancelBtnLarge.style.display = 'inline-block';
                        cancelBtnLarge.disabled = false;
                    }
                } else {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    btn.textContent = 'Lancer le scraping';
                    if (cancelBtn) {
                        cancelBtn.style.display = 'none';
                    }
                    if (cancelBtnLarge) {
                        cancelBtnLarge.style.display = 'none';
                    }
                    // On laisse la barre visible un moment ou on la cache si succès
                }
            }

            function stopPolling() {
                if (polling) {
                    clearInterval(polling);
                    polling = null;
                }
            }

            function startPolling(id) {
                jobId = id;
                stopPolling();
                setRunningState(true);

                polling = setInterval(() => {
                    fetch('{{ route("admin.scraping.progress") }}?job_id=' + encodeURIComponent(jobId))
                        .then(r => r.json())
                        .then(p => {
                            if (p && p.success && p.progress) {
                                const progress = p.progress;

                                // Mise à jour visuelle
                                const pct = progress.percentage || 0;
                                progBar.style.width = pct + '%';
                                progPercentage.textContent = pct + '%';
                                progLabel.textContent = progress.current_source ? 'Source : ' + progress.current_source : 'Initialisation...';
                                progDetails.textContent = progress.message;

                                // Afficher les trouvailles
                                if (progress.recent_findings && progress.recent_findings.length > 0) {
                                    findingsContainer.style.display = 'block';
                                    findingsList.innerHTML = progress.recent_findings.map(f => `
                                                <li style="font-size: 0.8125rem; color: #4b5563; padding: 0.25rem 0; border-bottom: 1px solid #f9fafb;">
                                                    <span style="font-weight: 500; color: #111827;">[${f.found_at}]</span> 
                                                    <span style="color: #3b82f6;">${f.source}</span>: ${f.titre.substring(0, 80)}${f.titre.length > 80 ? '...' : ''} 
                                                    <span style="color: #6b7280;">(${f.pays})</span>
                                                </li>
                                            `).join('');
                                }

                                if (progress.status === 'completed' || progress.status === 'failed' || progress.status === 'cancelled') {
                                    stopPolling();
                                    setRunningState(false);
                                    window._autoTriggerInProgress = false; // Reset pour le prochain cycle
                                    
                                    // Rafraîchir l'horaire pour le prochain cycle
                                    loadSchedule();

                                    if (progress.status === 'completed') {
                                        progLabel.textContent = 'Terminé !';
                                        progBar.style.width = '100%';
                                        progBar.style.backgroundColor = '#10b981';
                                    } else {
                                        progLabel.textContent = 'Échec ou annulation';
                                        progBar.style.backgroundColor = '#ef4444';
                                        if (progress.status === 'cancelled') {
                                            progDetails.textContent = 'Annulé par l\'utilisateur';
                                        }
                                    }
                                }
                            }
                        })
                        .catch(() => { });
                }, 1500);
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    handleCancel();
                });
            }

            if (cancelBtnLarge) {
                cancelBtnLarge.addEventListener('click', function() {
                    handleCancel();
                });
            }

            function handleCancel() {
                if (!jobId || !confirm('Arrêter le scraping en cours ?')) return;
                
                const buttons = [cancelBtn, cancelBtnLarge];
                buttons.forEach(b => {
                    if (b) {
                        b.disabled = true;
                        b.textContent = 'Arrêt...';
                    }
                });
                
                fetch('{{ route("admin.scraping.cancel") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ job_id: jobId })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        progDetails.textContent = 'Arrêt demandé...';
                    } else {
                        alert('Erreur: ' + (data.message || 'Impossible d\'arrêter'));
                        buttons.forEach(b => {
                            if (b) {
                                b.disabled = false;
                                b.textContent = 'Arrêter le scraping';
                            }
                        });
                    }
                })
                .catch(e => {
                    console.error(e);
                    buttons.forEach(b => {
                        if (b) {
                            b.disabled = false;
                            b.textContent = 'Arrêter le scraping';
                        }
                    });
                });
            }

            function startScrapingSession() {
                if (polling) return;

                // Réinitialiser UI
                progBar.style.width = '0%';
                progBar.style.backgroundColor = '#3b82f6';
                progPercentage.textContent = '0%';
                progLabel.textContent = 'Lancement...';
                progDetails.textContent = '';
                findingsList.innerHTML = '';
                findingsContainer.style.display = 'none';

                setRunningState(true);

                fetch('{{ route("admin.scraping.start") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({})
                })
                    .then(r => r.json())
                    .then(data => {
                        if (!data.success) {
                            if (!window._isAutoTrigger) alert(data.message || 'Erreur au démarrage');
                            setRunningState(false);
                            return;
                        }
                        startPolling(data.job_id);
                    })
                    .catch(err => {
                        console.error(err);
                        if (!window._isAutoTrigger) alert('Erreur lors de la communication avec le serveur');
                        setRunningState(false);
                    });
            }

            btn.addEventListener('click', function () {
                window._isAutoTrigger = false;
                startScrapingSession();
            });

            // Vérifier s'il y a un job en cours au chargement
            function checkCurrentJob() {
                // Si on surveille déjà un job, pas besoin de vérifier
                if (polling) return;

                fetch('{{ route("admin.scraping.current-job-id") }}')
                    .then(r => r.json())
                    .then(data => {
                        if (polling) return; // Sécurité supplémentaire

                        if (data.success && data.job_id) {
                            startPolling(data.job_id);
                        }
                    })
                    .catch(e => console.error("Erreur checkCurrentJob:", e));
            }

            checkCurrentJob();
            // Vérifier périodiquement pour détecter le lancement automatique
            setInterval(checkCurrentJob, 5000);

            // === GESTION DU SCRAPING AUTOMATIQUE ===
            const frequencySelect = document.getElementById('scraping-frequency');
            const activeCheckbox = document.getElementById('scraping-active');
            const statusText = document.getElementById('scraping-status-text');
            const nextRunText = document.getElementById('next-run-text');
            const saveScheduleBtn = document.getElementById('save-schedule');

            // Charger la configuration actuelle
            function loadSchedule() {
                fetch('{{ route("admin.scraping.schedule.get") }}')
                    .then(r => r.json())
                    .then(data => {
                        if (data.success && data.schedule) {
                            frequencySelect.value = data.schedule.frequency;
                            activeCheckbox.checked = data.schedule.is_active;
                            updateStatusText(data.schedule.is_active);
                            updateNextRunText(data.schedule.next_run_at, data.schedule.is_active);
                        }
                    })
                    .catch(err => console.error('Erreur lors du chargement de la configuration:', err));
            }

            // Mettre à jour le texte du statut
            // Mettre à jour le texte du statut
            function updateStatusText(isActive) {
                if (isActive) {
                    statusText.textContent = 'Actif';
                    statusText.style.color = '#000000';
                    statusText.style.fontWeight = '600';
                } else {
                    statusText.textContent = 'Inactif';
                    statusText.style.color = '#6b7280';
                    statusText.style.fontWeight = '400';
                }
            }

            // Mettre à jour le texte de la prochaine exécution
            let nextRunDate = null;
            function updateNextRunText(nextRunAt, isActive) {
                if (!isActive || !nextRunAt) {
                    nextRunDate = null;
                    nextRunText.textContent = '';
                    return;
                }
                nextRunDate = new Date(nextRunAt);
                updateCountdown(); // Appel immédiat
            }

            function updateCountdown() {
                if (!nextRunDate || !activeCheckbox.checked) {
                    nextRunText.textContent = '';
                    return;
                }
                
                if (polling) {
                    nextRunText.textContent = 'Scraping en cours...';
                    return;
                }

                const now = new Date();
                const diff = nextRunDate - now;
                
                if (diff <= 0) {
                    // Déclenchement par navigateur immédiat si pas de CRON détecté
                    if (!polling && !window._autoTriggerInProgress) {
                        window._autoTriggerInProgress = true;
                        window._isAutoTrigger = true;
                        nextRunText.innerHTML = '<span style="color: #3b82f6; font-weight: 600;">Lancement automatique par le navigateur...</span>';
                        startScrapingSession();
                    } else if (!polling) {
                        nextRunText.innerHTML = '<span style="color: #3b82f6; font-weight: 600;">Lancement imminent...</span>';
                    }
                    checkCurrentJob(); 
                    return;
                }

                const s = Math.floor((diff / 1000) % 60);
                const m = Math.floor((diff / 1000 / 60) % 60);
                const h = Math.floor((diff / (1000 * 60 * 60)));

                let parts = [];
                if (h > 0) parts.push(h + "h");
                if (m > 0 || h > 0) parts.push(m + "m");
                parts.push(s + "s");

                nextRunText.textContent = 'Prochaine exécution dans : ' + parts.join(' ');
            }

            // Mettre à jour le compte à rebours chaque seconde
            setInterval(updateCountdown, 1000);

            // Événement checkbox
            activeCheckbox.addEventListener('change', function () {
                updateStatusText(this.checked);
            });

            // Sauvegarder la configuration
            saveScheduleBtn.addEventListener('click', function () {
                const frequency = frequencySelect.value;
                const isActive = activeCheckbox.checked;

                fetch('{{ route("admin.scraping.schedule.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        frequency: frequency,
                        is_active: isActive
                    })
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            alert('✓ Configuration enregistrée avec succès!');
                            updateNextRunText(data.schedule.next_run_at, data.schedule.is_active);
                        } else {
                            alert('Erreur: ' + (data.message || 'Impossible d\'enregistrer'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Erreur lors de la sauvegarde');
                    });
            });

            // Charger la configuration au chargement de la page
            loadSchedule();
        });
    </script>
@endsection