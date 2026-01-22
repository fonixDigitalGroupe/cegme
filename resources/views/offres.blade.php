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
    @include('partials.site-styles')
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

        .offres-table-container {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.05);
        }

        .table-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 1.25rem;
            text-align: center;
            padding: 1.5rem 2rem 0;
            letter-spacing: -0.01em;
        }

        .offres-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .offres-table thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .offres-table th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            color: #495057;
            text-transform: none;
            letter-spacing: normal;
            border-right: 1px solid #dee2e6;
            white-space: nowrap;
        }

        .offres-table th:last-child {
            border-right: none;
        }

        .offres-table td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            font-size: 0.875rem;
            color: #212529;
            vertical-align: middle;
        }

        .offres-table td:last-child {
            border-right: none;
        }

        .offres-table tbody tr {
            transition: background-color 0.1s ease;
        }

        .offres-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .offres-table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        .offres-table tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .offres-table tbody tr:nth-child(odd):hover {
            background-color: #e9ecef;
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





        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding: 1rem 0;
            border-top: 1px solid #dee2e6;
        }

        .pagination-info {
            font-size: 0.875rem;
            color: #6c757d;
            font-weight: 400;
        }

        .pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination-button {
            padding: 0.375rem 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            text-decoration: none;
            color: #495057;
            font-size: 0.875rem;
            font-weight: 400;
            background-color: #ffffff;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            min-width: 38px;
            justify-content: center;
        }

        .pagination-button:hover:not(.disabled):not(.active) {
            background-color: #e9ecef;
            border-color: #adb5bd;
            color: #212529;
        }

        .pagination-button.active {
            background: linear-gradient(180deg, #0a9678 0%, #10b981 100%);
            border-color: #10b981;
            color: #ffffff;
            font-weight: 500;
        }

        .pagination-button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #adb5bd;
        }

        .pagination-button svg {
            width: 14px;
            height: 14px;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <x-site-header />

    <!-- Hero Section - Page Header -->
    <section class="relative w-full flex items-center justify-center overflow-hidden offres-hero-section"
        style="min-height: 25vh; padding: 60px 0; background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42));">
        <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center offres-hero-content"
            style="margin-top: 40px;">
            <h1 class="mb-6"
                style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                Appels d'Offres
            </h1>
            <p class="mx-auto max-w-3xl"
                style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                Découvrez les opportunités d'affaires et les appels d'offres dans les domaines des géosciences, des
                mines et de l'environnement
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container" style="padding-top: 48px;">
        @auth
            <!-- Filtres -->
            <div class="filters-container"
                style="background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 4px; padding: 1.5rem; margin-bottom: 2rem;">
                <form method="GET" action="{{ route('appels-offres.index') }}" class="filters-form"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; align-items: end;">
                    <!-- Type de marché -->
                    <div class="filter-group">
                        <label for="market_type"
                            style="display: block; font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.5rem;">Type
                            de marché</label>
                        <select name="market_type" id="market_type"
                            style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.875rem; color: #495057; background-color: #ffffff;">
                            <option value="">Tous</option>
                            <option value="bureau_d_etude" {{ request('market_type') === 'bureau_d_etude' ? 'selected' : '' }}>Bureau d'études</option>
                            <option value="consultant_individuel" {{ request('market_type') === 'consultant_individuel' ? 'selected' : '' }}>Consultant individuel</option>
                        </select>
                    </div>

                    <!-- Pôle d'activité -->
                    <div class="filter-group">
                        <label for="activity_pole_id"
                            style="display: block; font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.5rem;">Pôle
                            d'activité</label>
                        <select name="activity_pole_id" id="activity_pole_id"
                            style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.875rem; color: #495057; background-color: #ffffff;">
                            <option value="">Tous</option>
                            @foreach($activityPoles ?? [] as $pole)
                                <option value="{{ $pole->id }}" {{ request('activity_pole_id') == $pole->id ? 'selected' : '' }}>
                                    {{ $pole->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mot-clé -->
                    <div class="filter-group">
                        <label for="keyword"
                            style="display: block; font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.5rem;">Mot-clé</label>
                        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}"
                            placeholder="Rechercher..."
                            style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.875rem; color: #495057;">
                    </div>

                    <!-- Boutons -->
                    <div class="filter-actions" style="display: flex; gap: 0.5rem;">
                        <button type="submit"
                            style="padding: 0.625rem 1.5rem; background: linear-gradient(180deg, #0a9678 0%, #10b981 100%); color: #ffffff; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                            Filtrer
                        </button>
                        <a href="{{ route('appels-offres.index') }}"
                            style="padding: 0.625rem 1.5rem; background-color: #6c757d; color: #ffffff; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.2s;">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            <!-- Offres Table -->
            @if($offres->count() > 0)
                <div class="offres-table-container">
                    <h2 class="table-title">Tableau de Veille Stratégique : Appels d'Offres & AMI</h2>
                    <table class="offres-table">
                        <thead>
                            <tr>
                                <th>Source</th>
                                <th>Intitulé de la Mission</th>
                                <th>Zone Géographique</th>
                                <th>Date limite</th>
                                <th>Lien</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offres as $offre)
                                <tr>
                                    <td>
                                        @if($offre->source)
                                            <span style="color: #1a1a1a; font-size: 0.875rem;">{{ $offre->source }}</span>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="offre-title" style="color: #1a1a1a;">{{ $offre->titre }}</div>
                                    </td>
                                    <td>
                                        @php
                                            // Afficher seulement les pays filtrés si disponibles, sinon tous les pays
                                            $paysToDisplay = $offre->filtered_pays ?? $offre->pays;
                                        @endphp
                                        @if($paysToDisplay)
                                            <span style="color: #1a1a1a; font-size: 0.875rem;">{{ $paysToDisplay }}</span>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($offre->date_limite_soumission)
                                            <span style="color: #1a1a1a; font-size: 0.875rem;">
                                                @if(is_string($offre->date_limite_soumission))
                                                    {{ \Carbon\Carbon::parse($offre->date_limite_soumission)->format('d/m/Y') }}
                                                @else
                                                    {{ $offre->date_limite_soumission->format('d/m/Y') }}
                                                @endif
                                            </span>
                                        @else
                                            @if(($offre->source ?? '') === 'World Bank')
                                                <span style="color: #9ca3af;">Date limite : À confirmer (World Bank)</span>
                                            @else
                                                <span style="color: #9ca3af;">-</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($offre->lien_source)
                                            <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer"
                                                style="color: #2563eb; text-decoration: underline; font-size: 0.875rem;">
                                                Lire plus
                                            </a>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Lignes {{ $offres->firstItem() ?? 0 }} à {{ $offres->lastItem() ?? 0 }} sur {{ $offres->total() }}
                    </div>
                    <div class="pagination">
                        @if($offres->onFirstPage())
                            <span class="pagination-button disabled">Préc</span>
                        @else
                            <a href="{{ $offres->previousPageUrl() }}" class="pagination-button">Préc</a>
                        @endif

                        @if($offres->currentPage() > 1)
                            <a href="{{ $offres->url(1) }}" class="pagination-button">1</a>
                        @endif

                        @if($offres->currentPage() > 3)
                            <span class="pagination-button disabled">...</span>
                        @endif

                        @for($i = max(1, $offres->currentPage() - 1); $i <= min($offres->lastPage(), $offres->currentPage() + 1); $i++)
                            @if($i == $offres->currentPage())
                                <span class="pagination-button active">{{ $i }}</span>
                            @else
                                <a href="{{ $offres->url($i) }}" class="pagination-button">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($offres->currentPage() < $offres->lastPage() - 2)
                            <span class="pagination-button disabled">...</span>
                        @endif

                        @if($offres->currentPage() < $offres->lastPage() && $offres->lastPage() > 1)
                            <a href="{{ $offres->url($offres->lastPage()) }}"
                                class="pagination-button">{{ $offres->lastPage() }}</a>
                        @endif

                        @if($offres->hasMorePages())
                            <a href="{{ $offres->nextPageUrl() }}" class="pagination-button">Suiv</a>
                        @else
                            <span class="pagination-button disabled">Suiv</span>
                        @endif
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <p>Aucun appel d'offres trouvé.</p>
                </div>
            @endif
        @else
            <div
                style="background-color: #ffffff; border: 1.5px solid #d1d5db; border-radius: 8px; padding: 3rem 2rem; text-align: center; max-width: 600px; margin: 2rem auto; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div style="margin-bottom: 1.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor"
                        style="width: 64px; height: 64px; margin: 0 auto; color: #9ca3af;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 style="font-size: 24px; font-weight: 700; color: #111827; margin-bottom: 1rem;">Accès Restreint</h2>
                <p style="font-size: 16px; color: #4b5563; margin-bottom: 2rem; line-height: 1.5;">
                    Veuillez vous connecter pour accéder aux appels d'offres et aux opportunités stratégiques de CEGME.
                </p>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition-colors duration-200"
                    style="background: linear-gradient(180deg, #0a9678 0%, #10b981 100%); color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600;">
                    Se connecter
                </a>
            </div>
        @endauth
    </div>
    </div>

    <x-site-footer />

    <!-- Site Scripts -->
    @include('partials.site-scripts')
</body>

</html>