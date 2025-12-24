<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Appels d'offres - {{ config('app.name', 'Laravel') }}</title>

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
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                min-height: 100vh;
            }
            .header {
                background-color: #ffffff;
                border-bottom: 1px solid #d1d5db;
                padding: 1rem 2rem;
                box-shadow: none;
                position: sticky;
                top: 0;
                z-index: 100;
            }
            .header-nav {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-left: 2rem;
            }
            .header-nav a,
            .header-nav button {
                color: #374151;
                transition: all 0.15s ease;
                display: flex;
                align-items: center;
                padding: 0.5rem 0.875rem;
                border-radius: 3px;
                text-decoration: none;
                font-size: 0.75rem;
                font-weight: 500;
                text-transform: uppercase;
                position: relative;
                background: none;
                border: none;
                cursor: pointer;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }
            .header-nav a:hover,
            .header-nav button:hover {
                color: #1a1a1a;
                background-color: #f3f4f6;
            }
            .header-nav a.active,
            .header-nav button.active {
                color: #00C853;
                background-color: transparent;
                font-weight: 600;
            }
            .header-nav-separator {
                width: 1px;
                height: 20px;
                background-color: #d1d5db;
                margin: 0 0.5rem;
            }
            * {
                box-sizing: border-box;
            }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-[#1b1b18] min-h-screen" style="background-color: #ffffff !important;">
        <header class="header">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" style="height: 48px; width: auto; object-fit: contain;">
                    <div>
                        <h1 style="font-size: 1.25rem; font-weight: 700; margin: 0; letter-spacing: -0.02em; color: #00C853; line-height: 1.2; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">CEGME</h1>
                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0.125rem 0 0 0; font-weight: 400; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Géosciences • Mines • Environnement</p>
                    </div>
                </div>
                @if (Route::has('login'))
                <nav class="header-nav">
                    <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Accueil</a>
                    <a href="/a-propos" class="{{ request()->is('a-propos') || request()->is('a-propos/*') ? 'active' : '' }}">À Propos</a>
                    <a href="/services" class="{{ request()->is('services') || request()->is('services/*') ? 'active' : '' }}">Services</a>
                    <a href="/realisations" class="{{ request()->is('realisations') || request()->is('realisations/*') ? 'active' : '' }}">Réalisations</a>
                    <a href="/actualites" class="{{ request()->is('actualites') || request()->is('actualites/*') ? 'active' : '' }}">Actualités</a>
                    <a href="{{ route('offres.index') }}" class="{{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'active' : '' }}">Appels d'offres</a>
                    <a href="/blog" class="{{ request()->is('blog') || request()->is('blog/*') ? 'active' : '' }}">Blog</a>
                    <span class="header-nav-separator"></span>
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                        <span class="header-nav-separator"></span>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0; display: inline;">
                            @csrf
                            <button type="submit" style="color: #dc2626;" onmouseover="this.style.backgroundColor='#fee2e2'; this.style.color='#991b1b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626';">
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">
                            Se connecter
                        </a>
                    @endauth
                </nav>
                @endif
            </div>
        </header>

        <!-- Hero Section - Page Header -->
        <section class="relative w-full flex items-center justify-center overflow-hidden" style="min-height: 45vh; padding: 60px 0; background: linear-gradient(135deg, rgb(15, 64, 62) 0%, rgb(10, 48, 46) 100%);">
            <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center" style="margin-top: 60px;">
                <h1 class="mb-6" style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                    Appels d'offres
                </h1>
                <p class="mx-auto max-w-3xl" style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                    Consultez les derniers appels d'offres publiés et accédez aux informations détaillées
                </p>
            </div>
        </section>

        <!-- Search and Filters Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 48px 0;">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; gap: 24px;">
                    <!-- Search Bar - Left -->
                    <div class="relative flex-1 md:flex-none" style="position: relative; flex: 1; min-width: 300px; max-width: 400px;">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" style="position: absolute; top: 0; bottom: 0; left: 0; padding-left: 12px; display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; color: rgb(156, 163, 175);">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                        <form method="GET" action="{{ route('offres.index') }}" class="w-full">
                            <input
                                type="text"
                                name="search"
                                value="{{ request()->get('search') }}"
                                placeholder="Rechercher un appel d'offre..."
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                style="width: 100%; padding-left: 40px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; border: 1px solid rgb(209, 213, 219); border-radius: 6px; font-size: 14px;"
                            >
                        </form>
                    </div>

                    <!-- Filter Buttons - Right -->
                    @if($pays->count() > 0)
                    <div class="flex flex-wrap gap-3 justify-end" style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: flex-end;">
                        <a href="{{ route('offres.index') }}" class="px-4 py-2 rounded-lg font-medium transition-colors {{ !request()->has('pays') ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}" style="padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; text-decoration: none; display: inline-block;">
                            Tous les pays
                        </a>
                        @foreach($pays->take(8) as $p)
                            <a href="{{ route('offres.index', ['pays' => $p]) }}" class="px-4 py-2 rounded-lg font-medium transition-colors {{ request()->get('pays') === $p ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}" style="padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; text-decoration: none; display: inline-block;">
                                {{ $p }}
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Offers Table Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 0 0 96px 0;">
            <div class="max-w-7xl mx-auto">
                @if($offres->count() > 0)
                    <div style="overflow-x: auto; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px;">
                        <table style="width: 100%; border-collapse: collapse; margin: 0;">
                            <thead>
                                <tr style="background-color: #f9fafb; border-bottom: 2px solid #d1d5db;">
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Titre de l'appel d'offre</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Acheteur</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Pays</th>
                                    <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.8125rem; font-weight: 600; color: #374151; border-right: 1px solid #e5e7eb; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Date limite</th>
                                    <th style="padding: 0.75rem 1rem; text-align: right; font-size: 0.8125rem; font-weight: 600; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offres as $offre)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #1a1a1a; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <div style="font-weight: 500; color: #1a1a1a;">{{ $offre->titre }}</div>
                                        </td>
                                        <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #6b7280; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            {{ $offre->acheteur ?? '-' }}
                                        </td>
                                        <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #6b7280; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            {{ $offre->pays ?? '-' }}
                                        </td>
                                        <td style="padding: 0.75rem 1rem; border-right: 1px solid #e5e7eb; font-size: 0.875rem; color: #6b7280; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            {{ $offre->date_limite_soumission ? $offre->date_limite_soumission->format('d/m/Y') : '-' }}
                                        </td>
                                        <td style="padding: 0.75rem 1rem; text-align: right; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            <a 
                                                href="{{ $offre->lien_source }}" 
                                                target="_blank" 
                                                rel="noopener noreferrer"
                                                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.375rem 0.75rem; background-color: transparent; color: #2563eb; border: none; font-weight: 500; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; text-decoration: none;"
                                                onmouseover="this.style.backgroundColor='#eff6ff'; this.style.color='#1d4ed8';"
                                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='#2563eb';"
                                            >
                                                Lire l'information
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($offres->hasPages())
                        <div style="margin-top: 0; padding: 0.75rem 1rem; background-color: #ffffff; border: 1px solid #d1d5db; border-top: none; border-radius: 0 0 4px 4px; display: flex; justify-content: space-between; align-items: center;">
                            <div style="font-size: 0.875rem; color: #374151; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                Lignes {{ $offres->firstItem() }} à {{ $offres->lastItem() }} sur {{ $offres->total() }}
                            </div>
                            <div>
                                {{ $offres->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <div style="overflow-x: auto; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 4px;">
                        <table style="width: 100%; border-collapse: collapse; margin: 0;">
                            <tbody>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 2rem; color: #9ca3af; font-size: 0.875rem; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                        @if(request()->has('search') || request()->has('pays'))
                                            Aucun appel d'offre trouvé avec ces critères de recherche.
                                        @else
                                            Aucun appel d'offre disponible pour le moment.
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </section>

        <!-- Footer - Exact from Site -->
        <footer class="w-full text-white px-4 sm:px-6 lg:px-8" style="background: linear-gradient(180deg, rgb(15, 64, 62) 0%, rgb(22, 78, 75) 50%, rgb(25, 85, 82) 100%); padding: 64px 0 32px; color: rgb(255, 255, 255);">
            <div class="max-w-7xl mx-auto" style="padding: 0px;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px; margin-bottom: 32px; padding: 0px;">
                    <!-- Company Info -->
                    <div>
                        <!-- Logo and Company Name -->
                        <div class="flex items-center gap-3 mb-4" style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" class="block h-10 w-auto" style="height: 40px; width: auto; object-fit: contain;">
                            <span class="text-xl font-bold" style="font-size: 20px; font-weight: 700; color: rgb(255, 255, 255);">CEGME</span>
                        </div>
                        <!-- Description -->
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
                            <li><a href="{{ route('offres.index') }}" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Appels d'offres</a></li>
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
