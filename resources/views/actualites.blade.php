<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Actualités - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('Image/CEGME Logo.png') }}" type="image/png">

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

        footer.mobile-footer-home {
            display: none;
        }

        /* MOBILE ONLY STYLES */
        @media (max-width: 768px) {

            /* Empêcher le débordement horizontal */
            body {
                overflow-x: hidden !important;
                max-width: 100vw !important;
            }

            * {
                max-width: 100% !important;
            }

            header {
                background-color: rgba(255, 255, 255, 0.95) !important;
                backdrop-filter: blur(10px) !important;
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

            .actualites-main-row {
                flex-direction: column !important;
            }

            .actualites-left-column {
                max-width: 520px !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .actualites-facebook-widget {
                max-width: 520px !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .actualites-facebook-widget iframe[src*="facebook.com/plugins/page.php"] {
                width: 100% !important;
                max-width: 100% !important;
            }

            .actualites-join-community {
                max-width: 520px !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* Masquer le menu desktop sur mobile */
            .desktop-menu {
                display: none !important;
            }

            /* Afficher le header mobile */
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

            /* Logo mobile adjustments */
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

            /* Afficher le bouton hamburger */
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

            /* Menu mobile - masqué par défaut avec animation slide */
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
        }

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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-[#1b1b18] min-h-screen" style="background-color: #ffffff !important;">
    <!-- Header from Contact/Services/Realisations Page -->
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
                Réseaux Sociaux
            </h1>
            <p class="mx-auto max-w-3xl"
                style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                Suivez nos dernières actualités, projets et événements sur Facebook
            </p>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="w-full px-4 sm:px-6 lg:px-8" style="padding: 96px 0; background-color: #F9FAFB;">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-row gap-8 items-start justify-between actualites-main-row"
                style="display: flex; flex-direction: row; gap: 32px; align-items: flex-start; justify-content: space-between;">
                <!-- Left Column - Two separate blocks -->
                <div class="actualites-left-column"
                    style="max-width: 400px; width: 100%; flex-shrink: 0; display: flex; flex-direction: column; gap: 24px;">
                    <!-- Block 1: Follow Us Widget -->
                    <div class="bg-white rounded-lg shadow-md p-6"
                        style="background-color: rgb(255, 255, 255); border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; padding: 32px;">
                        <!-- Facebook Icon -->
                        <div
                            style="width: 64px; height: 64px; background-color: #1877F2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="white"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </div>
                        <!-- Title -->
                        <h2
                            style="font-size: 24px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 1.3;">
                            Suivez-nous sur Facebook
                        </h2>
                        <!-- Description -->
                        <p style="font-size: 16px; color: rgb(75, 85, 99); line-height: 1.6; margin-bottom: 24px;">
                            Restez informés de nos derniers projets, actualités environnementales et événements en
                            République Centrafricaine.
                        </p>
                        <!-- Button -->
                        <a href="https://www.facebook.com/CEGME.BG" target="_blank" rel="noopener noreferrer"
                            style="display: inline-flex; align-items: center; gap: 10px; background-color: #1877F2; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px; transition: background-color 0.2s;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            <span>Visiter notre page Facebook</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                style="width: 16px; height: 16px;">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                        </a>
                    </div>

                    <!-- Block 2: Join Our Community -->
                    <div class="bg-white rounded-lg shadow-md p-6"
                        style="background-color: rgb(255, 255, 255); border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; padding: 32px;">
                        <h3
                            style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 20px; line-height: 1.3;">
                            Rejoignez notre communauté
                        </h3>

                        <!-- Like our page -->
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            <div
                                style="width: 48px; height: 48px; background-color: #FCE7F3; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#EC4899"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </div>
                            <div style="flex: 1;">
                                <div
                                    style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 4px;">
                                    Aimez notre page
                                </div>
                                <div style="font-size: 14px; color: rgb(107, 114, 128);">
                                    Restez connectés
                                </div>
                            </div>
                        </div>

                        <!-- Share our posts -->
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            <div
                                style="width: 48px; height: 48px; background-color: #DBEAFE; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3B82F6"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="18" cy="5" r="3"></circle>
                                    <circle cx="6" cy="12" r="3"></circle>
                                    <circle cx="18" cy="19" r="3"></circle>
                                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                                    <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                                </svg>
                            </div>
                            <div style="flex: 1;">
                                <div
                                    style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 4px;">
                                    Partagez nos posts
                                </div>
                                <div style="font-size: 14px; color: rgb(107, 114, 128);">
                                    Diffusez l'information
                                </div>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div
                                style="width: 48px; height: 48px; background-color: #D1FAE5; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10B981"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </div>
                            <div style="flex: 1;">
                                <div
                                    style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 4px;">
                                    Commentez
                                </div>
                                <div style="font-size: 14px; color: rgb(107, 114, 128);">
                                    Engagez la conversation
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facebook Widget -->
                <div class="actualites-facebook-widget" style="max-width: 750px; width: 100%; margin-left: auto;">
                    <!-- Facebook Widget -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden"
                        style="background-color: rgb(255, 255, 255); border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <!-- Facebook Header -->
                        <div
                            style="background-color: #1877F2; padding: 20px 20px; display: flex; align-items: center; gap: 16px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="white"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            <div style="flex: 1;">
                                <div style="color: white; font-weight: 700; font-size: 20px; line-height: 1.3;">Fil
                                    d'actualité Facebook</div>
                                <div style="color: white; font-size: 16px; line-height: 1.3; margin-top: 4px;">@CEGME.BG
                                </div>
                            </div>
                        </div>
                        <div
                            style="display: flex; justify-content: center; align-items: center; width: 100%; padding: 0;">
                            <iframe
                                src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FCEGME.BG%2F&tabs=timeline&width=550&height=600&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                                width="550" height="600"
                                style="border:none;overflow:hidden;width:550px;max-width:550px;margin:0 auto;display:block;"
                                scrolling="no" frameborder="0" allowfullscreen="true"
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                        </div>

                        <!-- Fallback message -->
                        <div style="padding: 24px; text-align: center; background-color: rgb(255, 255, 255);">
                            <p style="font-size: 16px; color: rgb(75, 85, 99); margin-bottom: 16px;">
                                Le widget ne s'affiche pas correctement ?
                            </p>
                            <a href="https://www.facebook.com/CEGME.BG" target="_blank" rel="noopener noreferrer"
                                style="display: inline-flex; align-items: center; gap: 8px; background-color: transparent; color: #1877F2; padding: 10px 20px; border: 1px solid #1877F2; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px; transition: all 0.2s;">
                                <span>Ouvrir Facebook dans un nouvel onglet</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1877F2"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    style="width: 16px; height: 16px;">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Our Online Community Section -->
    <section class="w-full px-4 sm:px-6 lg:px-8"
        style="padding: 80px 0; background: linear-gradient(135deg, rgb(30, 58, 138) 0%, rgb(79, 70, 229) 100%);">
        <div class="max-w-4xl mx-auto text-center actualites-join-community">
            <!-- Facebook Icon -->
            <div style="display: flex; justify-content: center; margin-bottom: 12px;">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" style="width: 60px; height: 60px;">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                </svg>
            </div>

            <!-- Title -->
            <h2
                style="font-size: 28px; font-weight: 700; color: white; margin-bottom: 10px; line-height: 1.2; text-align: center;">
                Rejoignez notre communauté en<br>ligne
            </h2>

            <!-- Description -->
            <p
                style="font-size: 14px; color: white; margin-bottom: 16px; line-height: 1.4; text-align: center; opacity: 0.95;">
                Interagissez avec nous, posez vos questions et découvrez nos projets en temps réel
            </p>

            <!-- Button -->
            <div style="display: flex; justify-content: center; width: 100%;">
                <a href="https://www.facebook.com/CEGME.BG" target="_blank" rel="noopener noreferrer"
                    style="display: inline-flex; align-items: center; gap: 8px; background-color: white; color: black; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                    <span>Suivre CEGME sur Facebook</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer - Exact from Site -->
    <footer class="w-full text-white px-4 sm:px-6 lg:px-8 desktop-footer"
        style="background: linear-gradient(180deg, rgb(15, 64, 62) 0%, rgb(22, 78, 75) 50%, rgb(25, 85, 82) 100%); padding: 64px 0 32px; color: rgb(255, 255, 255);">
        <div class="max-w-7xl mx-auto" style="padding: 0px;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12"
                style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px; margin-bottom: 32px; padding: 0px;">
                <!-- Company Info -->
                <div>
                    <!-- Logo and Company Name -->
                    <div class="flex items-center gap-3 mb-4"
                        style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="block h-10 w-auto"
                            style="height: 40px; width: auto; object-fit: contain;">
                        <span class="text-xl font-bold"
                            style="font-size: 20px; font-weight: 700; color: rgb(255, 255, 255);">CEGME</span>
                    </div>
                    <!-- Description -->
                    <p class="text-white mb-4"
                        style="font-size: 16px; color: rgb(255, 255, 255); margin-bottom: 16px; line-height: 26px;">
                        Cabinet d'Études Géologiques, Minières et Environnementales
                    </p>
                    <p class="text-gray-300 text-sm"
                        style="font-size: 14px; color: rgb(209, 213, 219); line-height: 20px;">
                        Plateforme d'experts nationaux agréée<br>
                        N° 004/MEDD/DIRCAB_21
                    </p>
                </div>

                <!-- Liens Rapides -->
                <div>
                    <h3 class="text-lg font-bold mb-4"
                        style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: rgb(255, 255, 255);">
                        Liens Rapides
                    </h3>
                    <ul class="space-y-3" style="list-style: none; padding: 0; margin: 0;">
                        <li><a href="/" class="text-gray-300 hover:text-white transition-colors"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Accueil</a>
                        </li>
                        <li><a href="/a-propos" class="text-gray-300 hover:text-white transition-colors"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">À
                                Propos</a></li>
                        <li><a href="/services" class="text-gray-300 hover:text-white transition-colors"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Services</a>
                        </li>
                        <li><a href="/realisations" class="text-gray-300 hover:text-white transition-colors"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Réalisations</a>
                        </li>
                        <li><a href="/actualites" class="text-gray-300 hover:text-white transition-colors"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Actualités</a>
                        </li>
                        <li><a href="/blog" class="text-gray-300 hover:text-white transition-colors"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Blog</a>
                        </li>
                        <li><a href="/contact" class="text-gray-300 hover:text-white transition-colors"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 14px; display: block; padding: 4px 0;">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-bold mb-4"
                        style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: rgb(255, 255, 255);">
                        Contact
                    </h3>
                    <ul class="space-y-3" style="list-style: none; padding: 0; margin: 0;">
                        <li style="padding: 4px 0;">
                            <span class="text-white font-semibold"
                                style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block;">Adresse</span>
                            <p class="text-gray-300 text-sm"
                                style="color: rgb(209, 213, 219); font-size: 14px; margin-top: 4px;">Bangui, République
                                Centrafricaine</p>
                        </li>
                        <li style="padding: 4px 0;">
                            <span class="text-white font-semibold"
                                style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block;">Email</span>
                            <p class="text-gray-300 text-sm"
                                style="color: rgb(209, 213, 219); font-size: 14px; margin-top: 4px;">
                                cabinet.rca@cegme.net / cegme.sarl@gmail.com</p>
                        </li>
                        <li style="padding: 4px 0;">
                            <span class="text-white font-semibold"
                                style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block;">Registre</span>
                            <p class="text-gray-300 text-sm"
                                style="color: rgb(209, 213, 219); font-size: 14px; margin-top: 4px;">CA/BG/2015B514</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center"
                style="border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 24px; text-align: center; margin-top: 32px;">
                <p class="text-gray-400 text-sm" style="color: rgb(156, 163, 175); font-size: 14px;">
                    © 2025 CEGME SARL. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    <footer class="w-full text-white px-4 sm:px-6 lg:px-8 mobile-footer-home"
        style="background: linear-gradient(to right bottom, rgb(15, 23, 42), rgb(6, 78, 59), rgb(19, 78, 74)); padding: 80px 0 32px; color: rgb(255, 255, 255); position: relative; overflow: hidden;">
        <div
            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(5, 150, 105, 0.08) 0%, transparent 50%); pointer-events: none;">
        </div>
        <div class="relative z-10" style="position: relative; z-index: 10;">
            <div class="max-w-7xl mx-auto" style="padding: 0px;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12"
                    style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px; margin-bottom: 48px; padding: 0px;">
                    <div>
                        <div class="flex items-center gap-3 mb-6"
                            style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                            <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="block h-12 w-auto"
                                style="height: 48px; width: auto; object-fit: contain;">
                            <div class="flex flex-col" style="display: flex; flex-direction: column;">
                                <span class="text-2xl font-bold"
                                    style="font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1.2;">CEGME</span>
                                <span class="text-xs text-gray-200"
                                    style="font-size: 11px; color: rgb(229, 231, 235); line-height: 1.2; margin-top: 2px;">Géosciences
                                    • Mines • Environnement</span>
                            </div>
                        </div>
                        <p class="text-white mb-5 leading-relaxed"
                            style="font-size: 15px; color: rgb(255, 255, 255); margin-bottom: 20px; line-height: 26px; font-weight: 400;">
                            Cabinet d'Études Géologiques, Minières et Environnementales
                        </p>
                        <p class="text-gray-200 text-sm leading-relaxed"
                            style="font-size: 14px; color: rgb(209, 213, 219); line-height: 22px; margin: 0;">
                            <strong style="font-weight: 600; color: rgb(255, 255, 255);">Plateforme d'experts nationaux
                                agréée</strong><br>
                            N° 004/MEDD/DIRCAB_21
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-6"
                            style="font-size: 20px; font-weight: 800; margin-bottom: 24px; color: rgb(255, 255, 255); letter-spacing: -0.3px;">
                            Liens Rapides
                        </h3>
                        <ul class="space-y-3" style="list-style: none; padding: 0; margin: 0;">
                            <li>
                                <a href="/"
                                    class="text-gray-200 hover:text-green-300 transition-all duration-200 flex items-center gap-2 group"
                                    style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                                        style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Accueil</span>
                                </a>
                            </li>
                            <li>
                                <a href="/a-propos"
                                    class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                    style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                                        style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>À Propos</span>
                                </a>
                            </li>
                            <li>
                                <a href="/services"
                                    class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                    style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                                        style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Services</span>
                                </a>
                            </li>
                            <li>
                                <a href="/realisations"
                                    class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                    style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                                        style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Réalisations</span>
                                </a>
                            </li>
                            <li>
                                <a href="/actualites"
                                    class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                    style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                                        style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Actualités</span>
                                </a>
                            </li>
                            <li>
                                <a href="/blog"
                                    class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                    style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                                        style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Blog</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('appels-offres.index') }}"
                                    class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                    style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                                        style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Appels d'Offres</span>
                                </a>
                            </li>
                            <li>
                                <a href="/contact"
                                    class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                    style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                                        style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Contact</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-6"
                            style="font-size: 20px; font-weight: 800; margin-bottom: 24px; color: rgb(255, 255, 255); letter-spacing: -0.3px;">
                            Contact
                        </h3>
                        <ul class="space-y-4" style="list-style: none; padding: 0; margin: 0;">
                            <li style="padding: 0;">
                                <div class="flex items-start gap-3"
                                    style="display: flex; align-items: flex-start; gap: 12px;">
                                    <div class="w-10 h-10 bg-green-400 bg-opacity-25 rounded-lg flex items-center justify-center flex-shrink-0"
                                        style="width: 40px; height: 40px; background-color: rgba(52, 211, 153, 0.25); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 18px; height: 18px; color: rgb(52, 211, 153);">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-white font-semibold block mb-1"
                                            style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Adresse</span>
                                        <p class="text-gray-300 text-sm leading-relaxed"
                                            style="color: rgb(209, 213, 219); font-size: 14px; margin: 0; line-height: 22px;">
                                            Bangui, République Centrafricaine</p>
                                    </div>
                                </div>
                            </li>
                            <li style="padding: 0;">
                                <div class="flex items-start gap-3"
                                    style="display: flex; align-items: flex-start; gap: 12px;">
                                    <div class="w-10 h-10 bg-green-400 bg-opacity-25 rounded-lg flex items-center justify-center flex-shrink-0"
                                        style="width: 40px; height: 40px; background-color: rgba(52, 211, 153, 0.25); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 18px; height: 18px; color: rgb(52, 211, 153);">
                                            <path
                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                            </path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-white font-semibold block mb-1"
                                            style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Email</span>
                                        <a href="mailto:cabinet.rca@cegme.net"
                                            class="text-gray-200 text-sm hover:text-green-300 transition-colors"
                                            style="color: rgb(229, 231, 235); font-size: 14px; text-decoration: none; transition: color 0.2s ease;">cabinet.rca@cegme.net
                                            / cegme.sarl@gmail.com</a>
                                    </div>
                                </div>
                            </li>
                            <li style="padding: 0;">
                                <div class="flex items-start gap-3"
                                    style="display: flex; align-items: flex-start; gap: 12px;">
                                    <div class="w-10 h-10 bg-green-400 bg-opacity-25 rounded-lg flex items-center justify-center flex-shrink-0"
                                        style="width: 40px; height: 40px; background-color: rgba(52, 211, 153, 0.25); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 18px; height: 18px; color: rgb(52, 211, 153);">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-white font-semibold block mb-1"
                                            style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Registre</span>
                                        <p class="text-gray-300 text-sm leading-relaxed"
                                            style="color: rgb(209, 213, 219); font-size: 14px; margin: 0; line-height: 22px;">
                                            CA/BG/2015B514</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="text-center border-t border-white border-opacity-20 pt-8"
                    style="border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 32px; text-align: center; margin-top: 32px;">
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

        document.addEventListener('click', function (event) {
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