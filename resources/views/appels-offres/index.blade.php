<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nos offres - {{ config('app.name', 'Laravel') }}</title>

        <!-- Critical CSS to prevent white flash -->
        <style>
            html {
                margin: 0;
                padding: 0;
                background-color: #ffffff !important;
            }
            body {
                margin: 0;
                padding: 0;
                background-color: #ffffff !important;
                color: #1b1b18 !important;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                min-height: 100vh;
            }
            * {
                box-sizing: border-box;
            }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-[#1b1b18] min-h-screen" style="background-color: #ffffff !important;">
        <header class="w-full bg-white sticky top-0 z-50" style="position: fixed; top: 0; left: 0; right: 0; width: 100%; z-index: 1000; background-color: rgb(255, 255, 255); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
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
                            <a href="/" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('/') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('/') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Accueil
                            </a>
                            <a href="/a-propos" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('a-propos') || request()->is('a-propos/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('a-propos') || request()->is('a-propos/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                À Propos
                            </a>
                            <span class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: rgb(0, 0, 0); cursor: default; pointer-events: none;">
                                Services
                            </span>
                            <a href="/realisations" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('realisations') || request()->is('realisations/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('realisations') || request()->is('realisations/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Réalisations
                            </a>
                            <a href="/actualites" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('actualites') || request()->is('actualites/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('actualites') || request()->is('actualites/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Actualités
                            </a>
                            <a href="/blog" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('blog') || request()->is('blog/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('blog') || request()->is('blog/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Blog
                            </a>
                            <a href="/appels-offres" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Nos offres
                            </a>
                            <span class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: rgb(0, 0, 0); cursor: default; pointer-events: none;">
                                Contact
                            </span>
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
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 text-white font-medium transition-all duration-200 hover:opacity-90 rounded-full"
                            style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); padding: 8px 20px; font-size: 16px; border-radius: 8px;"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
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

        <!-- Hero Section - Page Header -->
        <section class="relative w-full flex items-center justify-center overflow-hidden" style="min-height: 45vh; padding: 60px 0; background: linear-gradient(135deg, rgb(15, 64, 62) 0%, rgb(10, 48, 46) 100%);">
            <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center" style="margin-top: 60px;">
                <h1 class="mb-6" style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                    Nos offres
                </h1>
                <p class="mx-auto max-w-3xl" style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px; margin-bottom: 2rem;">
                    Découvrez les opportunités d'appels d'offres récupérées automatiquement
                </p>
                <!-- Statistiques -->
                <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; margin-top: 2rem;">
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; font-weight: 700; color: rgb(255, 255, 255); line-height: 1;">{{ $totalAppelsOffres }}</div>
                        <div style="font-size: 0.875rem; color: rgb(229, 231, 235); margin-top: 0.5rem;">Appels d'offres</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; font-weight: 700; color: rgb(255, 255, 255); line-height: 1;">{{ $totalPublies }}</div>
                        <div style="font-size: 0.875rem; color: rgb(229, 231, 235); margin-top: 0.5rem;">Publiés</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 2.5rem; font-weight: 700; color: rgb(255, 255, 255); line-height: 1;">{{ $sources->count() }}</div>
                        <div style="font-size: 0.875rem; color: rgb(229, 231, 235); margin-top: 0.5rem;">Sources</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Search and Filters Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 48px 0;">
            <div class="max-w-7xl mx-auto">
                <form method="GET" action="{{ route('appels-offres.index') }}" class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; gap: 24px;">
                    <!-- Search Bar -->
                    <div class="relative flex-1 md:flex-none" style="position: relative; flex: 1; min-width: 300px; max-width: 400px;">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" style="position: absolute; top: 0; bottom: 0; left: 0; padding-left: 12px; display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; color: rgb(156, 163, 175);">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="search"
                            value="{{ request()->get('search') }}"
                            placeholder="Rechercher par mot-clé..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            style="width: 100%; padding-left: 40px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; border: 1px solid rgb(209, 213, 219); border-radius: 6px; font-size: 14px;"
                        >
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-wrap gap-3" style="display: flex; flex-wrap: wrap; gap: 12px;">
                        <select name="source" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="padding: 8px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 6px; font-size: 14px;">
                            <option value="">Toutes les sources</option>
                            @foreach($sources as $source)
                                <option value="{{ $source }}" {{ request()->get('source') === $source ? 'selected' : '' }}>{{ $source }}</option>
                            @endforeach
                        </select>
                        <select name="pays" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" style="padding: 8px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 6px; font-size: 14px;">
                            <option value="">Tous les pays</option>
                            @foreach($pays as $paysItem)
                                <option value="{{ $paysItem }}" {{ request()->get('pays') === $paysItem ? 'selected' : '' }}>{{ $paysItem }}</option>
                            @endforeach
                        </select>
                        <input
                            type="date"
                            name="date_debut"
                            value="{{ request()->get('date_debut') }}"
                            placeholder="Date début"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            style="padding: 8px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 6px; font-size: 14px;"
                        >
                        <input
                            type="date"
                            name="date_fin"
                            value="{{ request()->get('date_fin') }}"
                            placeholder="Date fin"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            style="padding: 8px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 6px; font-size: 14px;"
                        >
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors" style="padding: 8px 24px; background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px; font-size: 14px; font-weight: 500; border: none; cursor: pointer;">
                            Rechercher
                        </button>
                        @if(request()->hasAny(['search', 'source', 'pays', 'date_debut', 'date_fin']))
                            <a href="{{ route('appels-offres.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors" style="padding: 8px 24px; background-color: rgb(243, 244, 246); color: rgb(55, 65, 81); border-radius: 6px; font-size: 14px; font-weight: 500; text-decoration: none; display: inline-block;">
                                Réinitialiser
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </section>


        <!-- Appels d'offres Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 48px 0 96px 0;">
            <div class="max-w-7xl mx-auto">
                @if($appelsOffres->count() > 0)
                    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">
                            Affichage de <strong>{{ $appelsOffres->firstItem() }}</strong> à <strong>{{ $appelsOffres->lastItem() }}</strong> sur <strong>{{ $appelsOffres->total() }}</strong> appels d'offres
                        </p>
                    </div>
                    
                    <!-- Tableau des appels d'offres -->
                    <div style="overflow-x: auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                        <table style="width: 100%; border-collapse: collapse; margin: 0;">
                            <thead>
                                <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                                    <th style="padding: 12px 16px; text-align: left; font-size: 0.875rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; white-space: nowrap;">Source</th>
                                    <th style="padding: 12px 16px; text-align: left; font-size: 0.875rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; white-space: nowrap;">Type</th>
                                    <th style="padding: 12px 16px; text-align: left; font-size: 0.875rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb;">Titre</th>
                                    <th style="padding: 12px 16px; text-align: left; font-size: 0.875rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; white-space: nowrap;">Zone</th>
                                    <th style="padding: 12px 16px; text-align: left; font-size: 0.875rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; white-space: nowrap;">Date limite</th>
                                    <th style="padding: 12px 16px; text-align: center; font-size: 0.875rem; font-weight: 600; color: #374151; white-space: nowrap;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appelsOffres as $appelOffre)
                                <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.2s ease;" onmouseover="this.style.backgroundColor='#f9fafb';" onmouseout="this.style.backgroundColor='#ffffff';">
                                    <td style="padding: 16px; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #6b7280; white-space: nowrap;">
                                        {{ $appelOffre->source ?? '—' }}
                                    </td>
                                    <td style="padding: 16px; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151;">
                                        @if($appelOffre->type_marche)
                                            <span style="display: inline-block; padding: 0.25rem 0.75rem; background-color: #eff6ff; color: #2563eb; border-radius: 4px; font-size: 0.75rem; font-weight: 500;">
                                                {{ \Illuminate\Support\Str::limit($appelOffre->type_marche, 30) }}
                                            </span>
                                        @else
                                            <span style="color: #9ca3af;">—</span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #1a1a1a; max-width: 400px;">
                                        <div style="font-weight: 500; color: #059669; margin-bottom: 4px;">
                                            {{ \Illuminate\Support\Str::limit($appelOffre->titre, 80) }}
                                        </div>
                                        @if($appelOffre->description)
                                        <div style="font-size: 0.8125rem; color: #6b7280; margin-top: 4px; line-height: 1.4;">
                                            {{ \Illuminate\Support\Str::limit($appelOffre->description, 100) }}
                                        </div>
                                        @endif
                                        @if($appelOffre->mots_cles)
                                        <div style="margin-top: 8px; display: flex; flex-wrap: gap: 0.375rem;">
                                            @foreach(array_slice(explode(',', $appelOffre->mots_cles), 0, 3) as $motCle)
                                            <span style="display: inline-block; padding: 0.125rem 0.5rem; background-color: #f3f4f6; color: #374151; border-radius: 3px; font-size: 0.6875rem;">
                                                {{ trim($motCle) }}
                                            </span>
                                            @endforeach
                                        </div>
                                        @endif
                                    </td>
                                    <td style="padding: 16px; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; white-space: nowrap;">
                                        {{ $appelOffre->zone_geographique ?? '—' }}
                                    </td>
                                    <td style="padding: 16px; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #374151; white-space: nowrap;">
                                        @if($isAuthenticated)
                                            @if($appelOffre->date_limite)
                                                <span style="color: #374151;">{{ $appelOffre->date_limite->format('d/m/Y') }}</span>
                                            @else
                                                <span style="color: #9ca3af;">—</span>
                                            @endif
                                        @else
                                            <span style="color: #9ca3af;">[Connectez-vous]</span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px; text-align: center;">
                                        @if($isAuthenticated && $appelOffre->lien_source)
                                        <a href="{{ $appelOffre->lien_source }}" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white; border-radius: 6px; text-decoration: none; font-size: 0.8125rem; font-weight: 500; transition: all 0.2s ease;" onmouseover="this.style.opacity='0.9'; this.style.transform='scale(1.02)';" onmouseout="this.style.opacity='1'; this.style.transform='scale(1)';">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                <polyline points="15 3 21 3 21 9"></polyline>
                                                <line x1="10" y1="14" x2="21" y2="3"></line>
                                            </svg>
                                            Lire
                                        </a>
                                        @else
                                        <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background-color: #f3f4f6; color: #9ca3af; border-radius: 6px; font-size: 0.8125rem; font-weight: 500; cursor: not-allowed;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                            </svg>
                                            [Lien]
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if(!$isAuthenticated)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6" style="background-color: rgb(254, 252, 232); border: 1px solid rgb(253, 230, 138); border-radius: 8px; padding: 16px; margin-top: 24px;">
                            <div class="flex items-start gap-3" style="display: flex; align-items: flex-start; gap: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; color: rgb(217, 119, 6); flex-shrink: 0; margin-top: 2px;">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                <div style="flex: 1;">
                                    <p class="text-yellow-800 font-medium mb-1" style="color: rgb(133, 77, 14); font-weight: 500; margin-bottom: 4px; font-size: 14px;">
                                        Informations limitées
                                    </p>
                                    <p class="text-yellow-700 text-sm" style="color: rgb(161, 98, 7); font-size: 13px; line-height: 20px;">
                                        Pour accéder aux informations complètes (Date Limite, Lien Source), veuillez vous <a href="{{ route('register') }}" class="underline font-semibold" style="text-decoration: underline; font-weight: 600; color: rgb(133, 77, 14);">inscrire</a> ou vous <a href="{{ route('login') }}" class="underline font-semibold" style="text-decoration: underline; font-weight: 600; color: rgb(133, 77, 14);">connecter</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Pagination -->
                    @if($appelsOffres->hasPages())
                        <div class="mt-12" style="margin-top: 48px;">
                            {{ $appelsOffres->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-16" style="text-align: center; padding: 64px 0;">
                        @if(request()->hasAny(['search', 'pays', 'date_debut', 'date_fin']))
                            <p style="font-size: 18px; color: rgb(107, 114, 128); margin-bottom: 16px;">
                                Aucun appel d'offres trouvé avec ces critères de recherche.
                            </p>
                            <a href="{{ route('appels-offres.index') }}" style="display: inline-block; padding: 10px 20px; background-color: rgb(5, 150, 105); color: rgb(255, 255, 255); border-radius: 6px; text-decoration: none; font-weight: 500;">
                                Voir tous les appels d'offres
                            </a>
                        @else
                            <p style="font-size: 18px; color: rgb(107, 114, 128);">Aucun appel d'offres disponible pour le moment.</p>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <!-- Footer -->
        <footer class="w-full text-white px-4 sm:px-6 lg:px-8" style="background: linear-gradient(180deg, rgb(15, 64, 62) 0%, rgb(22, 78, 75) 50%, rgb(25, 85, 82) 100%); padding: 64px 0 32px; color: rgb(255, 255, 255);">
            <div class="max-w-7xl mx-auto" style="padding: 0px;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px; margin-bottom: 32px; padding: 0px;">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center gap-3 mb-4" style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" class="block h-10 w-auto" style="height: 40px; width: auto; object-fit: contain;">
                            <span class="text-xl font-bold" style="font-size: 20px; font-weight: 700; color: rgb(255, 255, 255);">CEGME</span>
                        </div>
                        <p class="text-white mb-4" style="font-size: 16px; color: rgb(255, 255, 255); margin-bottom: 16px; line-height: 26px;">
                            Cabinet d'Études Géologiques, Minières et Environnementales
                        </p>
                        <p class="text-gray-300 text-sm" style="font-size: 14px; color: rgb(209, 213, 219); line-height: 20px;">
                            Plateforme d'experts nationaux agréée<br>
                            N° 004/MEDD/DIRCAB_21
                        </p>
                    </div>
                    
                    <!-- Liens Rapides -->
                    <div>
                        <h3 class="text-lg font-bold mb-4" style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: rgb(255, 255, 255);">
                            Liens Rapides
                        </h3>
                        <ul class="space-y-3" style="list-style: none; padding: 0; margin: 0;">
                            <li><a href="/" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Accueil</a></li>
                            <li><a href="/a-propos" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">À Propos</a></li>
                            <li><a href="/services" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Services</a></li>
                            <li><a href="/realisations" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Réalisations</a></li>
                            <li><a href="/actualites" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Actualités</a></li>
                            <li><a href="/blog" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Blog</a></li>
                            <li><a href="/appels-offres" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Nos offres</a></li>
                            <li><a href="/contact" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Contact</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact -->
                    <div>
                        <h3 class="text-lg font-bold mb-4" style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: rgb(255, 255, 255);">
                            Contact
                        </h3>
                        <ul class="space-y-3" style="list-style: none; padding: 0; margin: 0;">
                            <li style="padding: 4px 0;">
                                <span class="text-white font-semibold" style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block;">Adresse</span>
                                <p class="text-gray-300 text-sm" style="color: rgb(209, 213, 219); font-size: 14px; margin-top: 4px;">Bangui, République Centrafricaine</p>
                            </li>
                            <li style="padding: 4px 0;">
                                <span class="text-white font-semibold" style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block;">Email</span>
                                <p class="text-gray-300 text-sm" style="color: rgb(209, 213, 219); font-size: 14px; margin-top: 4px;">contact@cegme.net</p>
                            </li>
                            <li style="padding: 4px 0;">
                                <span class="text-white font-semibold" style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block;">Registre</span>
                                <p class="text-gray-300 text-sm" style="color: rgb(209, 213, 219); font-size: 14px; margin-top: 4px;">CA/BG/2015B514</p>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Copyright -->
                <div class="text-center" style="border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 24px; text-align: center; margin-top: 32px;">
                    <p class="text-gray-400 text-sm" style="color: rgb(156, 163, 175); font-size: 14px;">
                        © 2025 CEGME SARL. Tous droits réservés.
                    </p>
                </div>
            </div>
        </footer>
    </body>
</html>

