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

        footer.mobile-footer-home {
            display: none;
        }

        footer.desktop-footer {
            display: block;
        }

        @media (max-width: 768px) {
            body {
                overflow-x: hidden !important;
                max-width: 100vw !important;
            }

            * {
                max-width: 100% !important;
            }

            footer.desktop-footer {
                display: none !important;
            }

            footer.mobile-footer-home {
                display: block !important;
            }

            .desktop-menu {
                display: none !important;
            }

            .mobile-header {
                display: flex !important;
            }

            .mobile-menu-button {
                display: flex !important;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                width: 44px;
                height: 44px;
                background: transparent;
                border: none !important;
                border-radius: 0;
                cursor: pointer;
                padding: 0;
                z-index: 1001;
                position: relative;
                visibility: visible !important;
                opacity: 1 !important;
                gap: 6px;
            }

            .mobile-menu-button span {
                width: 24px;
                height: 3px;
                background-color: #000000 !important;
                border-radius: 0;
                transition: all 0.3s ease;
                display: block;
                position: relative;
            }

            .mobile-menu-button:hover,
            .mobile-menu-button:active {
                background: transparent !important;
                border: none !important;
            }

            .mobile-menu {
                display: block;
                position: fixed;
                top: calc(3px + 64px);
                left: 0;
                right: 0;
                background-color: rgb(255, 255, 255);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 999;
                max-height: calc(100vh - 67px);
                overflow-y: auto;
                border-top: 1px solid rgba(229, 231, 235, 0.5);
                transform: translateY(-100%);
                opacity: 0;
                transition: transform 0.3s ease, opacity 0.3s ease;
                pointer-events: none;
            }

            .mobile-menu.active {
                transform: translateY(0);
                opacity: 1;
                pointer-events: auto;
            }

            .mobile-menu a {
                display: block;
                padding: 16px 20px;
                color: rgb(55, 65, 81);
                text-decoration: none;
                font-size: 16px;
                font-weight: 600;
                border-bottom: 1px solid rgba(229, 231, 235, 0.5);
                transition: background-color 0.2s ease;
            }

            .mobile-menu a:hover,
            .mobile-menu a:active {
                background-color: rgb(249, 250, 251);
            }

            .mobile-menu a.active {
                background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%);
                color: rgb(255, 255, 255);
            }

            .mobile-header {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 16px 24px;
                min-height: 64px;
                position: relative;
                z-index: 1000;
            }

            .mobile-logo {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                min-width: 0;
            }

            .mobile-logo a {
                display: flex;
                align-items: center;
                gap: 8px;
                min-width: 0;
                flex: 1;
            }

            .mobile-logo img {
                height: 40px !important;
                width: auto !important;
                flex-shrink: 0;
            }

            .mobile-logo .flex.flex-col {
                min-width: 0;
                flex: 1;
            }

            .mobile-logo span.font-bold {
                font-size: 16px !important;
                line-height: 1.2 !important;
            }

            .mobile-logo .text-xs,
            .mobile-logo .text-sm {
                font-size: 10px !important;
                line-height: 1.2 !important;
                margin-top: 2px !important;
            }

            /* Masquer le bouton Se connecter du header sur mobile */
            .desktop-login-button {
                display: none !important;
            }

            footer.mobile-footer-home {
                display: block !important;
            }

            footer.mobile-footer-home .grid {
                grid-template-columns: 1fr !important;
                gap: 32px !important;
            }
            
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

        /* Desktop - masquer le menu mobile */
        @media (min-width: 769px) {
            .mobile-menu-button,
            .mobile-menu,
            .mobile-header {
                display: none !important;
            }

            .desktop-menu {
                display: flex !important;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="w-full bg-white sticky top-0 z-50" style="position: fixed; top: 0; left: 0; right: 0; width: 100%; z-index: 1000; background-color: rgb(255, 255, 255); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <div style="height: 3px; background-color: rgb(101, 64, 48);"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (Route::has('login'))
                <div class="mobile-header">
                    <div class="mobile-logo">
                        <a href="/" class="flex items-center gap-2 shrink-0" style="text-decoration: none; color: inherit;">
                            <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="block h-12 w-auto" style="height: 48px; width: auto; object-fit: contain;">
                            <div class="flex flex-col" style="display: flex; flex-direction: column;">
                                <span class="font-bold" style="font-size: 18px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1.2;">CEGME</span>
                                <span class="text-xs text-gray-600" style="font-size: 11px; color: rgb(75, 85, 99); line-height: 1.2; margin-top: 2px;">Géosciences • Mines • Environnement</span>
                            </div>
                        </a>
                    </div>
                    <button class="mobile-menu-button" id="mobileMenuButton" onclick="toggleMobileMenu()" aria-label="Menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

                <div class="mobile-menu" id="mobileMenu">
                    <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Accueil</a>
                    <a href="/a-propos" class="{{ request()->is('a-propos') || request()->is('a-propos/*') ? 'active' : '' }}">À Propos</a>
                    <a href="/services" class="{{ request()->is('services') || request()->is('services/*') ? 'active' : '' }}">Services</a>
                    <a href="/realisations" class="{{ request()->is('realisations') || request()->is('realisations/*') ? 'active' : '' }}">Réalisations</a>
                    <a href="/actualites" class="{{ request()->is('actualites') || request()->is('actualites/*') ? 'active' : '' }}">Actualités</a>
                    <a href="/blog" class="{{ request()->is('blog') || request()->is('blog/*') ? 'active' : '' }}">Blog</a>
                    <a href="{{ route('appels-offres.index') }}" class="{{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'active' : '' }}">Appels d'Offres</a>
                    <a href="/contact" class="{{ request()->is('contact') || request()->is('contact/*') ? 'active' : '' }}">Contact</a>
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); margin: 12px 20px; border-radius: 8px; text-align: center;">
                            Se connecter
                        </a>
                    @endauth
                </div>

                <nav class="py-4 flex items-center justify-between gap-4 flex-wrap desktop-menu">
                    <div class="flex items-center gap-4 flex-wrap" style="margin-left: -24px;">
                        <a href="/" class="flex items-center gap-3 shrink-0" style="text-decoration: none; color: inherit;">
                            <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="block h-16 w-auto" style="height: 64px; width: auto; object-fit: contain;">
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
                            Offres
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
                        class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-white font-medium transition-all duration-200 hover:opacity-90 rounded-full desktop-login-button"
                        style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); padding: 8px 18px; font-size: 14px; border-radius: 8px; flex-shrink: 0; white-space: nowrap;"
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

    <!-- Hero Section - Page Header -->
    <section class="relative w-full flex items-center justify-center overflow-hidden" style="min-height: 45vh; padding: 60px 0; background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42));">
        <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center" style="margin-top: 100px;">
            <h1 class="mb-6" style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                Appels d'Offres
            </h1>
            <p class="mx-auto max-w-3xl" style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                Découvrez les opportunités d'affaires et les appels d'offres dans les domaines des géosciences, des mines et de l'environnement
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container" style="padding-top: 48px;">

        <!-- Filtres -->
        <div class="filters-container" style="background-color: #ffffff; border: 1px solid #dee2e6; border-radius: 4px; padding: 1.5rem; margin-bottom: 2rem;">
            <form method="GET" action="{{ route('appels-offres.index') }}" class="filters-form" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; align-items: end;">
                <!-- Type de marché -->
                <div class="filter-group">
                    <label for="market_type" style="display: block; font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.5rem;">Type de marché</label>
                    <select name="market_type" id="market_type" style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.875rem; color: #495057; background-color: #ffffff;">
                        <option value="">Tous</option>
                        <option value="bureau_d_etude" {{ request('market_type') === 'bureau_d_etude' ? 'selected' : '' }}>Bureau d'études</option>
                        <option value="consultant_individuel" {{ request('market_type') === 'consultant_individuel' ? 'selected' : '' }}>Consultant individuel</option>
                    </select>
                </div>

                <!-- Pôle d'activité -->
                <div class="filter-group">
                    <label for="activity_pole_id" style="display: block; font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.5rem;">Pôle d'activité</label>
                    <select name="activity_pole_id" id="activity_pole_id" style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.875rem; color: #495057; background-color: #ffffff;">
                        <option value="">Tous</option>
                        @foreach($activityPoles ?? [] as $pole)
                            <option value="{{ $pole->id }}" {{ request('activity_pole_id') == $pole->id ? 'selected' : '' }}>{{ $pole->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Mot-clé -->
                <div class="filter-group">
                    <label for="keyword" style="display: block; font-size: 0.875rem; font-weight: 600; color: #495057; margin-bottom: 0.5rem;">Mot-clé</label>
                    <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" placeholder="Rechercher..." style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.875rem; color: #495057;">
                </div>

                <!-- Boutons -->
                <div class="filter-actions" style="display: flex; gap: 0.5rem;">
                    <button type="submit" style="padding: 0.625rem 1.5rem; background: linear-gradient(180deg, #0a9678 0%, #10b981 100%); color: #ffffff; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        Filtrer
                    </button>
                    <a href="{{ route('appels-offres.index') }}" style="padding: 0.625rem 1.5rem; background-color: #6c757d; color: #ffffff; border: none; border-radius: 4px; font-size: 0.875rem; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.2s;">
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
                                        <a href="{{ $offre->lien_source }}" target="_blank" rel="noopener noreferrer" style="color: #2563eb; text-decoration: underline; font-size: 0.875rem;">
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
                        <a href="{{ $offres->url($offres->lastPage()) }}" class="pagination-button">{{ $offres->lastPage() }}</a>
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
    </div>
</div>

<footer class="w-full text-white px-4 sm:px-6 lg:px-8 desktop-footer" style="background: linear-gradient(180deg, rgb(15, 64, 62) 0%, rgb(22, 78, 75) 50%, rgb(25, 85, 82) 100%); padding: 64px 0 32px; color: rgb(255, 255, 255);">
    <div class="max-w-7xl mx-auto" style="padding: 0px;">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px; margin-bottom: 32px; padding: 0px;">
            <div>
                <div class="flex items-center gap-3 mb-4" style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="block h-10 w-auto" style="height: 40px; width: auto; object-fit: contain;">
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
                    <li><a href="/contact" class="text-gray-300 hover:text-white transition-colors" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Contact</a></li>
                </ul>
            </div>

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
                        <p class="text-gray-300 text-sm" style="color: rgb(209, 213, 219); font-size: 14px; margin-top: 4px;">cabinet.rca@cegme.net / cegme.sarl@gmail.com</p>
                    </li>
                    <li style="padding: 4px 0;">
                        <span class="text-white font-semibold" style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block;">Registre</span>
                        <p class="text-gray-300 text-sm" style="color: rgb(209, 213, 219); font-size: 14px; margin-top: 4px;">CA/BG/2015B514</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-center" style="border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 24px; text-align: center; margin-top: 32px;">
            <p class="text-gray-400 text-sm" style="color: rgb(156, 163, 175); font-size: 14px;">
                © 2025 CEGME SARL. Tous droits réservés.
            </p>
        </div>
    </div>
</footer>

<footer class="w-full text-white px-4 sm:px-6 lg:px-8 mobile-footer-home" style="background: linear-gradient(to right bottom, rgb(15, 23, 42), rgb(6, 78, 59), rgb(19, 78, 74)); padding: 80px 0 32px; color: rgb(255, 255, 255); position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(5, 150, 105, 0.08) 0%, transparent 50%); pointer-events: none;"></div>
    <div class="relative z-10" style="position: relative; z-index: 10;">
    <div class="max-w-7xl mx-auto" style="padding: 0px;">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px; margin-bottom: 48px; padding: 0px;">
            <div>
                <div class="flex items-center gap-3 mb-6" style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                    <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="block h-12 w-auto" style="height: 48px; width: auto; object-fit: contain;">
                    <div class="flex flex-col" style="display: flex; flex-direction: column;">
                        <span class="text-2xl font-bold" style="font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1.2;">CEGME</span>
                        <span class="text-xs text-gray-200" style="font-size: 11px; color: rgb(229, 231, 235); line-height: 1.2; margin-top: 2px;">Géosciences • Mines • Environnement</span>
                    </div>
                </div>
                <p class="text-white mb-5 leading-relaxed" style="font-size: 15px; color: rgb(255, 255, 255); margin-bottom: 20px; line-height: 26px; font-weight: 400;">
                    Cabinet d'Études Géologiques, Minières et Environnementales
                </p>
                <p class="text-gray-200 text-sm leading-relaxed" style="font-size: 14px; color: rgb(229, 231, 235); line-height: 22px; margin: 0;">
                    <strong style="font-weight: 600; color: rgb(255, 255, 255);">Plateforme d'experts nationaux agréée</strong><br>
                    N° 004/MEDD/DIRCAB_21
                </p>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-6" style="font-size: 20px; font-weight: 800; margin-bottom: 24px; color: rgb(255, 255, 255); letter-spacing: -0.3px;">
                    Liens Rapides
                </h3>
                <ul class="space-y-3" style="list-style: none; padding: 0; margin: 0;">
                    <li><a href="/" style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Accueil</a></li>
                    <li><a href="/a-propos" style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">À Propos</a></li>
                    <li><a href="/services" style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Services</a></li>
                    <li><a href="/realisations" style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Réalisations</a></li>
                    <li><a href="/actualites" style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Actualités</a></li>
                    <li><a href="/blog" style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Blog</a></li>
                    <li><a href="{{ route('appels-offres.index') }}" style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Appels d'Offres</a></li>
                    <li><a href="/contact" style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Contact</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-6" style="font-size: 20px; font-weight: 800; margin-bottom: 24px; color: rgb(255, 255, 255); letter-spacing: -0.3px;">
                    Contact
                </h3>
                <ul class="space-y-4" style="list-style: none; padding: 0; margin: 0;">
                    <li style="padding: 0;">
                        <span style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Adresse</span>
                        <p style="color: rgb(209, 213, 219); font-size: 14px; margin: 0; line-height: 22px;">Bangui, République Centrafricaine</p>
                    </li>
                    <li style="padding: 0;">
                        <span style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Email</span>
                        <a href="mailto:cabinet.rca@cegme.net" style="color: rgb(229, 231, 235); font-size: 14px; text-decoration: none;">cabinet.rca@cegme.net / cegme.sarl@gmail.com</a>
                    </li>
                    <li style="padding: 0;">
                        <span style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Registre</span>
                        <p style="color: rgb(209, 213, 219); font-size: 14px; margin: 0; line-height: 22px;">CA/BG/2015B514</p>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="text-center border-t border-white border-opacity-20 pt-8" style="border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 32px; text-align: center; margin-top: 32px;">
            <p class="text-gray-400 text-sm" style="color: rgb(156, 163, 175); font-size: 14px; margin: 0;">
                © 2025 CEGME SARL. Tous droits réservés.
            </p>
        </div>
        </div>
    </div>
</footer>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const button = document.getElementById('mobileMenuButton');
        
        if (menu && button) {
            menu.classList.toggle('active');
            button.classList.toggle('active');
        }
    }

    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileMenu');
        const button = document.getElementById('mobileMenuButton');
        
        if (menu && button && menu.classList.contains('active')) {
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.remove('active');
                button.classList.remove('active');
            }
        }
    });
</script>
</body>
</html>
