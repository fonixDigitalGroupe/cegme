<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appels d'offres - {{ config('app.name', 'Laravel') }}</title>
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
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem;
        }
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 2rem;
        }
        .filters {
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .filters form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: end;
        }
        .filter-group {
            flex: 1;
            min-width: 200px;
        }
        .filter-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 0.625rem;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 0.875rem;
        }
        .btn {
            padding: 0.625rem 1.5rem;
            background-color: #059669;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn:hover {
            background-color: #047857;
        }
        .offres-table-container {
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .offres-table {
            width: 100%;
            border-collapse: collapse;
        }
        .offres-table thead {
            background-color: #f9fafb;
            border-bottom: 2px solid #d1d5db;
        }
        .offres-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .offres-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.875rem;
            color: #1a1a1a;
        }
        .offres-table tbody tr:hover {
            background-color: #f9fafb;
        }
        .offres-table tbody tr:last-child td {
            border-bottom: none;
        }
        .offre-title {
            font-weight: 600;
            color: #1a1a1a;
            line-height: 1.4;
            max-width: 400px;
        }
        .offre-link {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #059669;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }
        .offre-link:hover {
            background-color: #047857;
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .badge-source {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .badge-pays {
            background-color: #dcfce7;
            color: #166534;
        }
        @media (max-width: 768px) {
            .offres-table-container {
                overflow-x: auto;
            }
            .offres-table {
                min-width: 800px;
            }
            .offres-table th,
            .offres-table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.8125rem;
            }
            .offre-title {
                max-width: 250px;
            }
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }
        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            text-decoration: none;
            color: #374151;
        }
        .pagination .active {
            background-color: #059669;
            color: white;
            border-color: #059669;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="w-full bg-white sticky top-0 z-50" style="position: fixed; top: 0; left: 0; right: 0; width: 100%; z-index: 1000; background-color: rgb(255, 255, 255); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <div style="height: 3px; background-color: rgb(101, 64, 48);"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (Route::has('login'))
                <nav class="py-4 flex items-center justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-4 flex-wrap" style="margin-left: -24px;">
                        <a href="/" class="flex items-center gap-3 shrink-0" style="text-decoration: none; color: inherit;">
                            <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" class="block h-16 w-auto" style="height: 64px; width: auto; object-fit: contain;">
                            <div class="flex flex-col" style="display: flex; flex-direction: column;">
                                <span class="font-bold" style="font-size: 20px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1.2;">CEGME</span>
                                <span class="text-sm text-gray-600" style="font-size: 13px; color: rgb(75, 85, 99); line-height: 1.2; margin-top: 2px;">Géosciences • Mines • Environnement</span>
                            </div>
                        </a>
                    </div>
                    <div class="flex items-center gap-4 flex-wrap" style="margin-right: -32px;">
                        <a href="/" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('/') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('/') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Accueil
                        </a>
                        <a href="/a-propos" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('a-propos') || request()->is('a-propos/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('a-propos') || request()->is('a-propos/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            À Propos
                        </a>
                        <a href="/services" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('services') || request()->is('services/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('services') || request()->is('services/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Services
                        </a>
                        <a href="/realisations" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('realisations') || request()->is('realisations/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('realisations') || request()->is('realisations/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Réalisations
                        </a>
                        <a href="/actualites" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('actualites') || request()->is('actualites/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('actualites') || request()->is('actualites/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Actualités
                        </a>
                        <a href="/blog" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('blog') || request()->is('blog/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('blog') || request()->is('blog/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Blog
                        </a>
                        <a href="{{ route('appels-offres.index') }}" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Appels d'Offres
                        </a>
                        <a href="/contact" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('contact') || request()->is('contact/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('contact') || request()->is('contact/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Contact
                        </a>
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 text-black border border-gray-300 hover:border-gray-400 rounded-sm text-sm leading-normal"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-white font-medium transition-all duration-200 hover:opacity-90 rounded-full"
                        style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); padding: 8px 18px; font-size: 14px; border-radius: 8px;"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                        <span>Se connecter</span>
                    </a>
                @endauth
                    </div>
            </nav>
        @endif
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <h1 class="page-title">Appels d'offres</h1>

        <!-- Filters -->
        <div class="filters">
            <form action="{{ route('appels-offres.index') }}" method="GET">
                <div class="filter-group">
                    <label for="search">Recherche</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Titre, acheteur, pays...">
                </div>
                <div class="filter-group">
                    <label for="pays">Pays</label>
                    <select name="pays" id="pays">
                        <option value="">Tous les pays</option>
                        @foreach($pays as $p)
                            <option value="{{ $p }}" {{ request('pays') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <button type="submit" class="btn">Rechercher</button>
                    @if(request()->has('search') || request()->has('pays'))
                        <a href="{{ route('appels-offres.index') }}" style="margin-left: 0.5rem; padding: 0.625rem 1.5rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">Réinitialiser</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Offres Table -->
        @if($offres->count() > 0)
            <div class="offres-table-container">
                <table class="offres-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Source</th>
                            <th>Pays</th>
                            <th>Acheteur</th>
                            <th>Date limite</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($offres as $offre)
                            <tr>
                                <td>
                                    <div class="offre-title">{{ $offre->titre }}</div>
                                </td>
                                <td>
                                    @if($offre->source)
                                        <span class="badge badge-source">{{ $offre->source }}</span>
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($offre->pays)
                                        <span class="badge badge-pays">{{ $offre->pays }}</span>
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($offre->acheteur)
                                        <span style="font-size: 0.875rem;">{{ Str::limit($offre->acheteur, 40) }}</span>
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($offre->date_limite_soumission)
                                        @if(is_string($offre->date_limite_soumission))
                                            {{ \Carbon\Carbon::parse($offre->date_limite_soumission)->format('d/m/Y') }}
                                        @else
                                            {{ $offre->date_limite_soumission->format('d/m/Y') }}
                                        @endif
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($offre->source === 'World Bank')
                                        @if($offre->project_id)
                                            <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="offre-link">
                                                Voir le projet
                                            </a>
                                        @else
                                            <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="offre-link">
                                                Rechercher
                                            </a>
                                        @endif
                                    @elseif($offre->source === 'African Development Bank')
                                        <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="offre-link">
                                            Voir l'avis sur le site de la BAD
                                        </a>
                                    @elseif($offre->source === 'IFAD' && isset($offre->link_type) && $offre->link_type === 'search_context')
                                        <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="offre-link">
                                            Voir les appels d'offres IFAD sur UNGM
                                        </a>
                                    @elseif($offre->source === 'DGMarket')
                                        <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="offre-link">
                                            Voir l'avis sur DGMarket
                                        </a>
                                    @else
                                        <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="offre-link">
                                            Voir l'avis
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $offres->links() }}
            </div>
        @else
            <div class="empty-state">
                <p>Aucun appel d'offres trouvé.</p>
            </div>
        @endif
    </div>
</body>
</html>
