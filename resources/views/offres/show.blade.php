<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $offre->titre }} - Appels d'offres - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
        }
        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #d1d5db;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-content {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .header-nav a {
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .header-nav a:hover {
            background-color: #f3f4f6;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #059669;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 1.5rem;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #047857;
        }
        .offre-detail {
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 2rem;
        }
        .offre-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            line-height: 1.3;
        }
        .offre-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .meta-item {
            display: flex;
            flex-direction: column;
        }
        .meta-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }
        .meta-value {
            font-size: 0.875rem;
            color: #1a1a1a;
            font-weight: 500;
        }
        .source-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .source-badge.world-bank {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .source-badge.afd {
            background-color: #dcfce7;
            color: #166534;
        }
        .actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #059669;
            color: white;
        }
        .btn-primary:hover {
            background-color: #047857;
        }
        .btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        .btn-secondary:hover {
            background-color: #e5e7eb;
        }
        .info-text {
            margin-top: 1rem;
            padding: 0.75rem;
            background-color: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 4px;
            font-size: 0.875rem;
            color: #92400e;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <a href="{{ route('home') }}" style="font-size: 1.25rem; font-weight: 700; color: #1a1a1a; text-decoration: none;">
                    {{ config('app.name', 'CEGME') }}
                </a>
            </div>
            <nav class="header-nav">
                <a href="{{ route('home') }}">Accueil</a>
                <a href="{{ route('a-propos') }}">À propos</a>
                <a href="{{ route('services') }}">Services</a>
                <a href="{{ route('realisations') }}">Réalisations</a>
                <a href="{{ route('actualites') }}">Actualités</a>
                <a href="{{ route('blog.index') }}">Blog</a>
                <a href="{{ route('offres.index') }}" style="color: #059669; font-weight: 600;">Appels d'offres</a>
                <a href="{{ route('contact') }}">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <a href="{{ route('offres.index') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Retour à la liste des appels d'offres
        </a>

        <div class="offre-detail">
            <h1 class="offre-title">{{ $offre->titre }}</h1>

            <div class="offre-meta">
                <div class="meta-item">
                    <span class="meta-label">Source</span>
                    <span class="meta-value">
                        @if($offre->source === 'World Bank')
                            <span class="source-badge world-bank">{{ $offre->source }}</span>
                        @elseif($offre->source === 'AFD')
                            <span class="source-badge afd">{{ $offre->source }}</span>
                        @else
                            {{ $offre->source }}
                        @endif
                    </span>
                </div>

                @if($offre->pays)
                <div class="meta-item">
                    <span class="meta-label">Pays / Région</span>
                    <span class="meta-value">{{ $offre->pays }}</span>
                </div>
                @endif

                @if($offre->date_limite_soumission)
                <div class="meta-item">
                    <span class="meta-label">Date limite de soumission</span>
                    <span class="meta-value">{{ $offre->date_limite_soumission->format('d/m/Y') }}</span>
                </div>
                @endif

                @if($offre->notice_type)
                <div class="meta-item">
                    <span class="meta-label">Type d'avis</span>
                    <span class="meta-value">{{ $offre->notice_type }}</span>
                </div>
                @endif

                @if($offre->acheteur)
                <div class="meta-item">
                    <span class="meta-label">Acheteur</span>
                    <span class="meta-value">{{ $offre->acheteur }}</span>
                </div>
                @endif

                <div class="meta-item">
                    <span class="meta-label">Date de publication</span>
                    <span class="meta-value">{{ $offre->created_at->format('d/m/Y à H:i') }}</span>
                </div>
            </div>

            <div class="actions">
                @if($offre->source === 'World Bank')
                    @if($offre->project_id)
                        <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            Voir le projet sur le site de la Banque mondiale
                        </a>
                        <div class="info-text">
                            Les appels d'offres sont consultables dans l'onglet Procurement du projet.
                        </div>
                    @else
                        <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            Rechercher l'avis sur le site de la Banque mondiale
                        </a>
                    @endif
                @else
                    @if($offre->detail_url && $offre->link_type === 'detail')
                        <a href="{{ $offre->detail_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            Voir l'avis sur le site source
                        </a>
                    @else
                        <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            Voir l'avis sur le site source
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</body>
</html>

