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
        .offres-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .offre-card {
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 1.5rem;
            transition: box-shadow 0.2s;
        }
        .offre-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .offre-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        .offre-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .offre-meta span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .offre-link {
            display: inline-block;
            padding: 0.625rem 1.5rem;
            background-color: #059669;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            text-align: center;
            transition: background-color 0.2s;
        }
        .offre-link:hover {
            background-color: #047857;
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
        <h1 class="page-title">Appels d'offres</h1>

        <!-- Filters -->
        <div class="filters">
            <form action="{{ route('offres.index') }}" method="GET">
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
                        <a href="{{ route('offres.index') }}" style="margin-left: 0.5rem; padding: 0.625rem 1.5rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">Réinitialiser</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Offres Grid -->
        @if($offres->count() > 0)
            <div class="offres-grid">
                @foreach($offres as $offre)
                    <div class="offre-card">
                        <h2 class="offre-title">{{ $offre->titre }}</h2>
                        <div class="offre-meta">
                            @if($offre->source)
                                <span><strong>Source:</strong> {{ $offre->source }}</span>
                            @endif
                            @if($offre->pays)
                                <span><strong>Pays:</strong> {{ $offre->pays }}</span>
                            @endif
                            @if($offre->date_limite_soumission)
                                <span><strong>Date limite:</strong> {{ $offre->date_limite_soumission->format('d/m/Y') }}</span>
                            @endif
                            @if($offre->acheteur)
                                <span><strong>Acheteur:</strong> {{ $offre->acheteur }}</span>
                            @endif
                        </div>
                        <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" class="offre-link">
                            Voir l'avis
                        </a>
                    </div>
                @endforeach
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
