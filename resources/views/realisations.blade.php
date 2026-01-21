<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Réalisations - {{ config('app.name', 'Laravel') }}</title>

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

        < !-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @include('partials.site-styles')

        /* MOBILE ONLY STYLES - Ne pas affecter le desktop */
        @media (max-width: 768px) {

            /* Header Styles from Contact/Services Page - FIXED */
            header {
                background-color: rgba(255, 255, 255, 0.95) !important;
                backdrop-filter: blur(10px) !important;
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

            .desktop-menu {
                display: none !important;
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
                gap: 6px;
                position: relative;
                visibility: visible !important;
                opacity: 1 !important;
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
                background-color: #fff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                z-index: 999;
                max-height: calc(100vh - 67px);
                overflow-y: auto;
                border-top: 1px solid rgba(229, 231, 235, 0.5);
                transform: translateY(-100%);
                opacity: 0;
                transition: transform .3s ease, opacity .3s ease;
                pointer-events: none;
            }

            .mobile-menu.active {
                transform: translateY(0);
                opacity: 1;
                pointer-events: auto;
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
                height: 64px !important;
                width: auto !important;
                flex-shrink: 0;
            }

            .mobile-logo .flex.flex-col {
                min-width: 0;
                flex: 1;
            }

            .mobile-logo span.font-bold {
                font-size: 20px !important;
                line-height: 1.2 !important;
                font-weight: 800 !important;
                background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent !important;
                background-clip: text !important;
            }

            .mobile-logo .text-xs,
            .mobile-logo .text-sm {
                font-size: 13px !important;
                line-height: 1.2 !important;
                margin-top: 2px !important;
            }

            .desktop-login-button {
                display: none !important;
            }

            /* Empêcher le débordement horizontal */
            body {
                overflow-x: hidden !important;
                max-width: 100vw !important;
            }

            * {
                max-width: 100% !important;
            }



            .realisations-filters-row {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
            }

            .realisations-filters-row select {
                width: 100% !important;
                max-width: 320px !important;
                min-width: 0 !important;
                align-self: flex-start !important;
            }

            .realisations-year-filter {
                margin-left: 0 !important;
                overflow-x: visible !important;
                width: 100% !important;
                display: grid !important;
                grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
                gap: 8px !important;
            }

            .realisations-year-filter button {
                width: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 8px 0 !important;
                font-size: 12px !important;
            }

            .realisations-projects-grid {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
                justify-items: center !important;
            }

            .project-card {
                padding: 16px !important;
                width: 100% !important;
                max-width: 460px !important;
            }

            footer.desktop-footer {
                display: none !important;
            }

            footer.mobile-footer-home {
                display: block !important;
            }

            footer.mobile-footer-home .grid {
                grid-template-columns: 1fr !important;
                gap: 32px !important;
            }

            /* Mobile Header and Footer are handled globally by site-styles.blade.php */

            .mobile-menu-button:hover span {
                background-color: rgb(5, 150, 105);
            }

            .mobile-menu-button:active span {
                background-color: rgb(5, 150, 105);
            }

            .mobile-menu-button.active span:nth-child(1) {
                transform: rotate(45deg) translate(8px, 8px);
            }

            .mobile-menu-button.active span:nth-child(2) {
                opacity: 0;
            }

            .mobile-menu-button.active span:nth-child(3) {
                transform: rotate(-45deg) translate(8px, -8px);
            }

            /* Masquer le bouton Se connecter du header sur mobile */
            .desktop-login-button {
                display: none !important;
            }

            /* Ajuster le padding du header */
            header nav {
                padding: 12px 0 !important;
            }

            /* Styles pour les cartes de projets - Hauteur uniforme et positionnement icône/date */
            .project-card {
                display: flex;
                flex-direction: column;
                height: 100%;
                min-height: 420px;
            }

            .project-card-content {
                flex: 1;
                display: flex;
                flex-direction: column;
            }
    </style>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-[#1b1b18] min-h-screen" x-data="{ 
        activeSector: 'all',
        activeYear: 'all',
        matchesFilter(sector, year) {
            const sectorMatch = this.activeSector === 'all' || this.activeSector === sector;
            const yearMatch = this.activeYear === 'all' || this.activeYear === year;
            return sectorMatch && yearMatch;
        }
    }" style="background-color: #ffffff !important;">
    <!-- Header from Contact/Services Page -->
    <header class="w-full bg-white sticky top-0 z-50"
        style="position: fixed; top: 0; left: 0; right: 0; width: 100%; z-index: 1000; background-color: rgb(255, 255, 255); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <div style="height: 3px; background-color: rgb(101, 64, 48);"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (Route::has('login'))
                <!-- Mobile Header -->
                <div class="mobile-header">
                    <div class="mobile-logo">
                        <a href="/" class="flex items-center gap-2 shrink-0" style="text-decoration: none; color: inherit;">
                            <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="block h-16 w-auto"
                                style="height: 64px; width: auto; object-fit: contain;">
                            <div class="flex flex-col" style="display: flex; flex-direction: column !important;">
                                <span class="font-bold"
                                    style="font-size: 20px !important; font-weight: 800 !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important; background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; background-clip: text !important; line-height: 1.2 !important;">CEGME</span>
                                <span class="text-sm text-gray-600"
                                    style="font-size: 13px !important; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important; color: rgb(75, 85, 99) !important; line-height: 1.2 !important; margin-top: 2px !important;">Géosciences
                                    • Mines • Environnement</span>
                            </div>
                        </a>
                    </div>
                    <button class="mobile-menu-button" id="mobileMenuButton" onclick="toggleMobileMenu()" aria-label="Menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div class="mobile-menu" id="mobileMenu">
                    <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Accueil</a>
                    <a href="/a-propos"
                        class="{{ request()->is('a-propos') || request()->is('a-propos/*') ? 'active' : '' }}">À Propos</a>
                    <a href="/services"
                        class="{{ request()->is('services') || request()->is('services/*') ? 'active' : '' }}">Services</a>
                    <a href="/realisations"
                        class="{{ request()->is('realisations') || request()->is('realisations/*') ? 'active' : '' }}">Réalisations</a>
                    <a href="/actualites"
                        class="{{ request()->is('actualites') || request()->is('actualites/*') ? 'active' : '' }}">Actualités</a>
                    <a href="/blog" class="{{ request()->is('blog') || request()->is('blog/*') ? 'active' : '' }}">Blog</a>
                    <a href="{{ route('appels-offres.index') }}"
                        class="{{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'active' : '' }}">Offres</a>
                    <a href="/contact"
                        class="{{ request()->is('contact') || request()->is('contact/*') ? 'active' : '' }}">Contact</a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" style="display: block;">
                            @csrf
                            <button type="submit"
                                style="display: block; width: 100%; text-align: left; padding: 16px 20px; color: rgb(55, 65, 81); font-size: 16px; font-weight: 600; background: none; border: none; border-bottom: 1px solid rgba(229, 231, 235, 0.5); cursor: pointer; color: rgb(10, 150, 120);">
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: #fff; margin: 12px 20px; border-radius: 8px; text-align: center;">Se
                            connecter</a>
                    @endauth
                </div>

                <!-- Desktop Menu -->
                <nav class="py-4 flex items-center justify-between gap-4 flex-wrap desktop-menu">
                    <div class="flex items-center gap-4 flex-wrap" style="margin-left: -24px;">
                        <a href="/" class="flex items-center gap-3 shrink-0" style="text-decoration: none; color: inherit;">
                            <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="block h-16 w-auto"
                                style="height: 64px; width: auto; object-fit: contain;">
                            <div class="flex flex-col" style="display: flex; flex-direction: column;">
                                <span class="font-bold"
                                    style="font-size: 20px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1.2;">CEGME</span>
                                <span class="text-sm text-gray-600"
                                    style="font-size: 13px; color: rgb(75, 85, 99); line-height: 1.2; margin-top: 2px;">Géosciences
                                    • Mines • Environnement</span>
                            </div>
                        </a>
                    </div>
                    <div class="flex items-center gap-4 flex-wrap desktop-menu" style="margin-right: -32px;">
                        <a href="/"
                            class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('/') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}"
                            style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('/') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Accueil
                        </a>
                        <a href="/a-propos"
                            class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('a-propos') || request()->is('a-propos/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}"
                            style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('a-propos') || request()->is('a-propos/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            À Propos
                        </a>
                        <a href="/services"
                            class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('services') || request()->is('services/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}"
                            style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('services') || request()->is('services/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Services
                        </a>
                        <a href="/realisations"
                            class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('realisations') || request()->is('realisations/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}"
                            style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('realisations') || request()->is('realisations/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Réalisations
                        </a>
                        <a href="/actualites"
                            class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('actualites') || request()->is('actualites/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}"
                            style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('actualites') || request()->is('actualites/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Actualités
                        </a>
                        <a href="/blog"
                            class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('blog') || request()->is('blog/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}"
                            style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('blog') || request()->is('blog/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Blog
                        </a>
                        <a href="{{ route('appels-offres.index') }}"
                            class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}"
                            style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Offres
                        </a>
                        <a href="/contact"
                            class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('contact') || request()->is('contact/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}"
                            style="font-size: 15px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('contact') || request()->is('contact/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(55, 65, 81); text-decoration: none;' }}">
                            Contact
                        </a>
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 text-black border border-gray-300 hover:border-gray-400 rounded-sm text-sm leading-normal">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-white font-medium transition-all duration-200 hover:opacity-90 rounded-full desktop-login-button"
                                style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); padding: 8px 18px; font-size: 14px; border-radius: 8px; flex-shrink: 0; white-space: nowrap;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    style="width: 16px; height: 16px;">
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
    <section class="relative w-full flex items-center justify-center overflow-hidden"
        style="min-height: 45vh; padding: 60px 0; background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42));">
        <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center" style="margin-top: 100px;">
            <h1 class="mb-6"
                style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                Nos Réalisations
            </h1>
            <p class="mx-auto max-w-3xl"
                style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                Plus de 70 missions stratégiques réalisées à travers l'Afrique depuis 2011
            </p>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 48px 0;">
        <div class="max-w-7xl mx-auto" style="width: 100%;">
            <div class="flex flex-row items-start justify-between gap-4 flex-wrap"
                style="display: flex; flex-direction: row; gap: 16px; padding: 0; margin: 0; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
                <!-- Card 1: Missions stratégiques -->
                <div class="text-center"
                    style="flex: 1; min-width: 200px; padding: 0; margin: 0; text-align: center; display: block;">
                    <div class="text-6xl font-bold mb-3"
                        style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); line-height: 44px; margin-bottom: 8px;">
                        70+
                    </div>
                    <h3 class="text-lg font-bold mb-2"
                        style="font-size: 14px; font-weight: 400; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 0px;">
                        Missions réalisées
                    </h3>
                </div>

                <!-- Card 2: EIES & Audits -->
                <div class="text-center"
                    style="flex: 1; min-width: 200px; padding: 0; margin: 0; text-align: center; display: block;">
                    <div class="text-6xl font-bold mb-3"
                        style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); line-height: 44px; margin-bottom: 8px;">
                        45+
                    </div>
                    <h3 class="text-lg font-bold mb-2"
                        style="font-size: 14px; font-weight: 400; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 0px;">
                        EIES & Audits validés
                    </h3>
                </div>

                <!-- Card 3: Pays d'intervention -->
                <div class="text-center"
                    style="flex: 1; min-width: 200px; padding: 0; margin: 0; text-align: center; display: block;">
                    <div class="text-6xl font-bold mb-3"
                        style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); line-height: 44px; margin-bottom: 8px;">
                        4
                    </div>
                    <h3 class="text-lg font-bold mb-2"
                        style="font-size: 14px; font-weight: 400; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 0px;">
                        Pays d'intervention
                    </h3>
                </div>

                <!-- Card 4: Bailleurs partenaires -->
                <div class="text-center"
                    style="flex: 1; min-width: 200px; padding: 0; margin: 0; text-align: center; display: block;">
                    <div class="text-6xl font-bold mb-3"
                        style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); line-height: 44px; margin-bottom: 8px;">
                        10+
                    </div>
                    <h3 class="text-lg font-bold mb-2"
                        style="font-size: 14px; font-weight: 400; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 0px;">
                        Bailleurs partenaires
                    </h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section - Grille unique comme le site de référence -->
    <section class="w-full bg-white px-4 sm:px-6 lg:px-8"
        style="padding: 48px 0 96px 0; background-color: rgb(249, 250, 251);">
        <div class="max-w-7xl mx-auto">
            <!-- Filtres -->
            <div class="mb-8" style="margin-bottom: 32px;">
                <div class="flex items-center gap-4 justify-start flex-wrap realisations-filters-row"
                    style="display: flex; align-items: center; gap: 16px; justify-content: flex-start; flex-wrap: nowrap;">
                    <div class="flex items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 20px; height: 20px; color: rgb(75, 85, 99);">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        <span style="font-size: 16px; font-weight: 600; color: rgb(55, 65, 81);">Filtrer secteur
                            :</span>
                    </div>
                    <select x-model="activeSector"
                        class="px-4 py-2 rounded-lg font-medium transition-colors border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500"
                        style="padding: 12px 20px; border-radius: 6px; font-size: 16px; font-weight: 600; background-color: rgb(255, 255, 255); color: rgb(55, 65, 81); border: 1px solid rgb(209, 213, 219); cursor: pointer; min-width: 180px; max-width: 200px;">
                        <option value="all">Tous les secteurs</option>
                        <option value="eau-humanitaire">Eau, Humanitaire et Développement Rural</option>
                        <option value="conservation-environnement">Conservation et Environnement</option>
                        <option value="infrastructures-urbanisme-btp">Infrastructures, Urbanisme et BTP</option>
                        <option value="mines-energie-hydrocarbures">Mines, Énergie et Hydrocarbures</option>
                        <option value="agro-industrie-services">Agro-Industrie et Services</option>
                    </select>
                    <!-- Filtre par date - Boutons horizontaux -->
                    <div class="flex items-center gap-2 realisations-year-filter"
                        style="display: flex; align-items: center; gap: 8px; flex-wrap: nowrap; overflow-x: auto; margin-left: 24px;">
                        <button @click="activeYear = 'all'"
                            :class="activeYear === 'all' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            Tous
                        </button>
                        <button @click="activeYear = '2025'"
                            :class="activeYear === '2025' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2025
                        </button>
                        <button @click="activeYear = '2024'"
                            :class="activeYear === '2024' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2024
                        </button>
                        <button @click="activeYear = '2022'"
                            :class="activeYear === '2022' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2022
                        </button>
                        <button @click="activeYear = '2021'"
                            :class="activeYear === '2021' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2021
                        </button>
                        <button @click="activeYear = '2020'"
                            :class="activeYear === '2020' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2020
                        </button>
                        <button @click="activeYear = '2019'"
                            :class="activeYear === '2019' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2019
                        </button>
                        <button @click="activeYear = '2018'"
                            :class="activeYear === '2018' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2018
                        </button>
                        <button @click="activeYear = '2017'"
                            :class="activeYear === '2017' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2017
                        </button>
                        <button @click="activeYear = '2016'"
                            :class="activeYear === '2016' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2016
                        </button>
                        <button @click="activeYear = '2011'"
                            :class="activeYear === '2011' ? 'bg-gradient-to-r from-green-600 to-green-500 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm hover:shadow-md flex-shrink-0"
                            style="padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                            2011
                        </button>
                    </div>
                </div>
            </div>

            <!-- Grille de projets -->
            <div class="realisations-projects-grid"
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 32px; padding: 0; align-items: stretch;">
                <!-- 2025 Projects -->
                <!-- Project 1: Études hydrogéologiques - Programmes d'urgence -->
                <div x-show="matchesFilter('eau-humanitaire', '2025')" style="position: relative;"
                    data-sector="eau-humanitaire" data-year="2025">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2025</span>
                        </div>
                        <!-- Contenu -->
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Études hydrogéologiques - Programmes d'urgence
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                OXFAM & UNICEF
                            </p>
                            <!-- Badge localisation -->
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bria /
                                    Batangafo, RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Études sur la mobilisation des eaux souterraines, tarification de l'eau, rentabilité des
                                systèmes d'AEP et enquêtes socio-économiques.
                            </p>
                            <!-- Tags -->
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Hydrogéologie</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Études
                                    socio-économiques</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Tarification</span>
                            </div>
                            <!-- Financement -->
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : UNICEF / OXFAM
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project 2: Stratégie nationale filière manioc -->
                <div x-show="matchesFilter('agro-industrie-services')" style="position: relative;"
                    data-sector="agro-industrie-services">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2025</span>
                        </div>
                        <!-- Contenu -->
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Stratégie nationale filière manioc
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                FAO & SMCAF
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">République
                                    Centrafricaine</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Élaboration de la stratégie nationale de développement de la filière manioc, plan
                                d'action et projets bancables.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Stratégie
                                    nationale</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Plan
                                    d'action</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Projets
                                    bancables</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : FAO
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project 3: EIESC - Unités de transformation alimentaire -->
                <div x-show="matchesFilter('agro-industrie-services')" style="position: relative;"
                    data-sector="agro-industrie-services">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2025</span>
                        </div>
                        <!-- Contenu -->
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                EIESC - Unités de transformation alimentaire
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                PREPAS / FIDA
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bouar / Yaloké,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Consultant principal pour l'Étude d'Impact Environnemental, Social et Climatique
                                d'unités de transformation alimentaire.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIESC</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Évaluation
                                    climatique</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : FIDA
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2024 Projects -->
                <!-- Project 1: CGES & PGES - Aire de Conservation de Chinko -->
                <div x-show="matchesFilter('conservation-environnement', '2024')" style="position: relative;"
                    data-sector="conservation-environnement" data-year="2024">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2024</span>
                        </div>
                        <!-- Contenu -->
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                CGES & PGES - Aire de Conservation de Chinko
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                African Parks Network / USAID
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Chinko,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Élaboration du Cadre de Gestion Environnementale et Sociale et du PGES pour l'Aire de
                                Conservation de Chinko.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">CGES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">PGES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Conservation</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : USAID
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project 2: Audit E&S et monitoring HSSE - Voiries de Bangui -->
                <div x-show="matchesFilter('infrastructures-urbanisme-btp', '2024')" style="position: relative;"
                    data-sector="infrastructures-urbanisme-btp" data-year="2024">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2024</span>
                        </div>
                        <!-- Contenu -->
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Audit E&S et monitoring HSSE - Voiries de Bangui
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                EverTrump Ltd
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bangui, RCA
                                    (Axe PK0-PK12)</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Audit E&S et monitoring HSSE permanent des travaux de bitumage des voiries de Bangui.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Audit
                                    E&S</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Monitoring
                                    HSSE</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Surveillance
                                    chantier</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project 3: Audit E&S et EIES - Complexe industriel Palme d'OR -->
                <div x-show="matchesFilter('agro-industrie-services', '2024')" style="position: relative;"
                    data-sector="agro-industrie-services" data-year="2024">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2024</span>
                        </div>
                        <!-- Contenu -->
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Audit E&S et EIES - Complexe industriel Palme d'OR
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Palme d'OR SA
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Lessé / Bimbo,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Audit E&S d'une palmeraie de 3500 ha et EIES du complexe industriel (Savonnerie,
                                Raffinerie, Plasturgie).
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Audit
                                    E&S</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Agro-industrie</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2022 Projects -->
                <!-- Project 1: EIES - Projet de Réduction de la Vulnérabilité Climatique -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2022')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2022">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2022</span>
                        </div>
                        <!-- Contenu -->
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                EIES - Projet de Réduction de la Vulnérabilité Climatique
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Ministère de l'Énergie / BAD
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">République
                                    Centrafricaine</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                EIES du Projet de Réduction de la Vulnérabilité face aux changements climatiques
                                (PCRVP-FCAE).
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Changement
                                    climatique</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : BAD
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project 2: EIES - Complexe hôtelier LACASA -->
                <div x-show="matchesFilter('infrastructures-urbanisme-btp', '2022')" style="position: relative;"
                    data-sector="infrastructures-urbanisme-btp" data-year="2022">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2022</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                EIES - Complexe hôtelier LACASA
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                EverTrump Ltd
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bangui,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                EIES pour le complexe hôtelier LACASA et le supermarché SUPER STORE.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Hôtellerie</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Commerce</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project 3: Supervision exploration pétrolière -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2022')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2022">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2022</span>
                        </div>
                        <!-- Contenu -->
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Supervision exploration pétrolière
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                DigOIL Centrafrique
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">République
                                    Centrafricaine</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Représentation pays et supervision complète (administrative, technique et logistique) de
                                l'exploration pétrolière.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Représentation</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Supervision
                                    technique</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Exploration
                                    pétrolière</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project 4: Notices d'impact et PEASM - Permis d'or -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2022')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2022">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2022</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Notices d'impact et PEASM - Permis d'or
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Société Lixiang
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">République
                                    Centrafricaine</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Notices d'impact et plans d'exploitation pour trois permis d'or.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Notices
                                    d'impact</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">PEASM</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Exploitation
                                    aurifère</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2021 Projects -->
                <!-- Project 1: EIES - Complexe immobilier BDEAC -->
                <div x-show="matchesFilter('infrastructures-urbanisme-btp', '2021')" style="position: relative;"
                    data-sector="infrastructures-urbanisme-btp" data-year="2021">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2021</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                EIES - Complexe immobilier BDEAC
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                BDEAC
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Centre-ville de
                                    Bangui, RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                EIES pour la construction d'un complexe immobilier administratif et résidentiel.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Urbanisme</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : BDEAC
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project 2: Formation EMAPE - Coopératives minières -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2021')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2021">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2021</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Formation EMAPE - Coopératives minières
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                PGRN / Banque Mondiale
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">République
                                    Centrafricaine</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Formation des coopératives minières aux approches d'exploitation artisanale à petite
                                échelle.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Formation</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EMAPE</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Renforcement
                                    capacités</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Banque Mondiale
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project 3: EIES - Stations-services Green Oil -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2021')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2021">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2021</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                EIES - Stations-services Green Oil
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Green Oil RCA
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">République
                                    Centrafricaine</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                EIES pour la construction de trois stations-services et du siège social.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Distribution
                                    pétrolière</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2020 Projects -->
                <!-- Project 1: Audit environnemental - HUSACA -->
                <div x-show="matchesFilter('agro-industrie-services', '2020')" style="position: relative;"
                    data-sector="agro-industrie-services" data-year="2020">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2020</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Audit environnemental - HUSACA
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Nouvelle HUSACA
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bangui,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Audit environnemental et social des unités industrielles de Bangui.
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Audit
                                    E&S</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Industrie</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Complexe immobilier BDEAC (2021, Octobre) -->
                <div x-show="matchesFilter('infrastructures-urbanisme-btp', '2021')" style="position: relative;"
                    data-sector="infrastructures-urbanisme-btp" data-year="2021">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2021</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Complexe immobilier BDEAC
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                BDEAC
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bangui,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Etude d'Impact Environnemental et Social du projet de la construction et de
                                l'exploitation d'un complexe immobilier à usage administratif et résidentiel au
                                centre-ville dans l'enceinte de son agence centrale sur financement de la Banque de
                                Développement des États d'Afrique Central (BDEAC)
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Immobilier</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : BDEAC
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Parc agro-industriel Lessé (2021, Janvier) -->
                <div x-show="matchesFilter('agro-industrie-services', '2021')" style="position: relative;"
                    data-sector="agro-industrie-services" data-year="2021">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2021</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Parc agro-industriel Lessé
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Lessé,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Diagnostic socio-économique Exploitation du parc agro-industriel de transformation
                                d'huile de palme brute dans la commune de Lessé
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Diagnostic</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Agro-industrie</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Audit huilerie et savonnerie (2020, Janvier) -->
                <div x-show="matchesFilter('agro-industrie-services', '2020')" style="position: relative;"
                    data-sector="agro-industrie-services" data-year="2020">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2020</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Audit huilerie et savonnerie
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bangui,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Audit environnemental et social des unités de l'huilerie et de la savonnerie à son siège
                                de Bangui
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Audit
                                    E&S</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Industrie</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Dépotoir privé Samba 1 (2020, Février) -->
                <div x-show="matchesFilter('conservation-environnement')" style="position: relative;"
                    data-sector="conservation-environnement">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2020</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Dépotoir privé Samba 1
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Samba 1, Bimbo,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Étude d'Impact Environnemental et social du projet d'installation d'un dépotoir privé
                                d'excrément et des ordures au village Samba 1 dans la commune de Bimbo
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Assainissement</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: City Apartment Bangui (2020, Mai) -->
                <div x-show="matchesFilter('infrastructures-urbanisme-btp')" style="position: relative;"
                    data-sector="infrastructures-urbanisme-btp">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2020</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                City Apartment Bangui
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bangui,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Étude d'Impact Environnemental et Social (EIES) du projet de la construction et de
                                l'exploitation d'un complexe immobilier à usage administratif et d'appartement (City
                                Apartment) à Bangui
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Immobilier</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Mine d'or alluvionnaire Bossangoa (2019, Février) -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2019')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2019">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2019</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Mine d'or alluvionnaire Bossangoa
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bossangoa,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Étude d'impact environnemental et social sommaire du projet de la mise en exploitation
                                des sites pilotes d'une mine d'or alluvionnaire dans la sous-préfecture de Bossangoa
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Mines</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Exploitation semi-mécanisée rivière Sangha (2019, Septembre) -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2019')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2019">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2019</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Exploitation semi-mécanisée rivière Sangha
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Rivière Sangha,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Étude d'Impact Environnemental et Social du projet de l'exploitation semi-mécanisée (à
                                l'aide des barges à godets) d'or et de diamant sur le lit vif de la rivière Sangha en
                                République Centrafricaine
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Mines</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Mine d'or alluvionnaire Gaga Yaloké (2018, Octobre) -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2018')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2018">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2018</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Mine d'or alluvionnaire Gaga Yaloké
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Gaga Yaloké,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Étude d'Impact Environnemental et social sommaire du projet d'exploitation d'une zone
                                pilote d'or alluvionnaire dans la région de Gaga Yaloké en RCA
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Mines</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Audit de clôture exploration pétrolière (2017, Mai) -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2017')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2017">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2017</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Audit de clôture exploration pétrolière
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Audit environnemental et social interne pour la clôture des activités d'exploration
                                pétrolière par méthode sismique 2D
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Audit
                                    E&S</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Pétrole</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: EIES Centrale hydroélectrique Lobaye (2017, Octobre) -->
                <div x-show="matchesFilter('eau-humanitaire', '2017')" style="position: relative;"
                    data-sector="eau-humanitaire" data-year="2017">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2017</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                EIES Centrale hydroélectrique Lobaye
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Rivière Lobaye,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Étude d'Impact Environnemental et Social Approfondie du projet de la construction de la
                                centrale hydroélectrique sur la rivière Lobaye (sites de Bac & Lotémo)
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Énergie</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Plan de Réinstallation Lobaye (2017, Novembre) -->
                <div x-show="matchesFilter('eau-humanitaire', '2017')" style="position: relative;"
                    data-sector="eau-humanitaire" data-year="2017">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2017</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Plan de Réinstallation Lobaye
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Rivière Lobaye,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Plan d'Action de Réinstallation des populations affectées par le projet de la
                                construction de la centrale hydroélectrique sur la rivière Lobaye (sites de Bac &
                                Lotémo)
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Plan
                                    de réinstallation</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Social</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Exploration sismique permis C et manuel HSE (2017, Décembre) -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2017')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2017">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2017</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Exploration sismique permis C et manuel HSE
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                DigOIL Centrafrique
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Sud-ouest
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Étude d'Impact Environnemental et social du projet d'exploration sismique 2D,
                                d'échantillonnage géochimique et de levé aéroporté gravimétrique haute résolution sur le
                                permis C au sud-ouest de la RCA • Conception du manuel de procédure HSE de DIG OIL
                                Centrafrique SA
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">HSE</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Pétrole</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Exploration sismique et manuels HSE (2016, Mai) -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2016')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2016">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <!-- Icône à gauche -->
                        <div
                            style="position: absolute; top: 20px; left: 20px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background-color: rgb(243, 244, 246); border-radius: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <!-- Badge année à droite -->
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2016</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Exploration sismique et manuels HSE
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Étude d'Impact Environnemental et Social du projet d'exploration sismique 2D •
                                Conception du manuel de procédure HSE PTIAL • Conception du manuel de procédure HSE
                                PTI-IAS
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">EIES</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">HSE</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Pétrole</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project: Études de terrain (2011) -->
                <div x-show="matchesFilter('mines-energie-hydrocarbures', '2011')" style="position: relative;"
                    data-sector="mines-energie-hydrocarbures" data-year="2011">
                    <div class="project-card bg-white rounded-2xl shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                        <div
                            style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <div
                            style="position: absolute; top: 20px; right: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(254, 243, 199); padding: 8px 16px; border-radius: 8px;">
                            <span style="font-size: 16px; font-weight: 600; color: rgb(180, 83, 9);">2011</span>
                        </div>
                        <div class="project-card-content" style="padding-top: 60px;">
                            <h3 class="text-xl font-bold mb-2"
                                style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 28px; margin-top: 0;">
                                Études de terrain
                            </h3>
                            <p
                                style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 12px;">
                                Privé
                            </p>
                            <div
                                style="display: inline-flex; align-items: center; gap: 6px; background-color: rgb(249, 250, 251); padding: 6px 12px; border-radius: 6px; margin-bottom: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 16px; height: 16px;">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <span style="font-size: 14px; font-weight: 500; color: rgb(75, 85, 99);">Bakouma,
                                    RCA</span>
                            </div>
                            <p class="text-gray-600 mb-3"
                                style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 12px;">
                                Contribution aux études thématiques de l'Étude d'Impact du gisement d'uranium de Bakouma
                                – RCA
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Études
                                    de terrain</span>
                                <span
                                    style="display: inline-flex; align-items: center; padding: 4px 12px; background-color: rgb(236, 253, 245); color: rgb(5, 150, 105); border-radius: 6px; font-size: 13px; font-weight: 500;">Uranium</span>
                            </div>
                            <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin: 0;">
                                Financement : Privé
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-site-footer />

    @include('partials.site-scripts')

    <!-- Mobile Menu JavaScript -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const button = document.getElementById('mobileMenuButton');
            if (!menu || !button) return;
            menu.classList.toggle('active');
            button.classList.toggle('active');
        }
        document.addEventListener('click', (e) => {
            const menu = document.getElementById('mobileMenu');
            const button = document.getElementById('mobileMenuButton');
            if (!menu || !button) return;
            const isClickInsideMenu = menu.contains(e.target);
            const isClickOnButton = button.contains(e.target);
            if (!isClickInsideMenu && !isClickOnButton && menu.classList.contains('active')) {
                menu.classList.remove('active');
                button.classList.remove('active');
            }
        });
    </script>
</body>

</html>