<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>À Propos - {{ config('app.name', 'Laravel') }}</title>

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
                font-family: 'Georgia', 'Times New Roman', Times, serif;
                min-height: 100vh;
            }
            .header {
                background-color: #ffffff;
                border-bottom: 1px solid #d1d5db;
                padding: 1.25rem 2rem;
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
                color: #4b5563;
                transition: all 0.15s ease;
                display: flex;
                align-items: center;
                padding: 0.5rem 0.875rem;
                border-radius: 6px;
                text-decoration: none;
                font-size: 0.875rem;
                font-weight: 500;
                text-transform: none;
                position: relative;
                background: none;
                border: none;
                cursor: pointer;
                font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }
            .header-nav a:hover,
            .header-nav button:hover {
                color: #1f2937;
                background-color: #f3f4f6;
            }
            .header-nav a.active,
            .header-nav button.active {
                color: white;
                background: #0d9488;
                font-weight: 500;
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

            footer.mobile-footer-home {
                display: none;
            }

            /* MOBILE ONLY STYLES - Ne pas affecter le desktop */
            @media (max-width: 768px) {
                /* Empêcher le débordement horizontal */
                body {
                    overflow-x: hidden !important;
                    max-width: 100vw !important;
                }
                
                * {
                    max-width: 100% !important;
                }
                /* Masquer le menu desktop sur mobile */
                .desktop-menu {
                    display: none !important;
                }
                
                /* Afficher le header mobile */
                .mobile-header {
                    display: flex !important;
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
                
                /* Header mobile - logo centré - Style site de référence */
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
                
                /* Bouton hamburger - VISIBLE ET FONCTIONNEL */
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
                
                /* Améliorer la visibilité du bouton hamburger */
                .mobile-menu-button:hover {
                    border-color: transparent;
                    background-color: transparent;
                }
                
                .mobile-menu-button:hover span {
                    background-color: #000000 !important;
                }
                
                .mobile-menu-button:active span {
                    background-color: #000000 !important;
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

                header {
                    background-color: rgba(255, 255, 255, 0.95) !important;
                    backdrop-filter: blur(10px) !important;
                }

                .mobile-logo a,
                .mobile-logo span,
                .mobile-menu a {
                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
                }

                /* Ajustements spécifiques à la page À Propos sur mobile */
                .grid {
                    grid-template-columns: 1fr !important;
                }
                
                /* Sections mobile */
                section {
                    padding-left: 24px !important;
                    padding-right: 24px !important;
                }
                
                /* Titres mobile */
                h1 {
                    font-size: 36px !important;
                    line-height: 1.2 !important;
                }
                
                h2 {
                    font-size: 28px !important;
                    line-height: 1.3 !important;
                }

                section[style*="min-height: 45vh"] h1,
                section[style*="min-height: 45vh"] p {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
                }
                
                /* Images mobile */
                img {
                    max-width: 100% !important;
                    height: auto !important;
                }
                
                /* Footer mobile */
                footer .grid {
                    gap: 32px !important;
                }

                footer.mobile-footer-home img[alt="CEGME Logo"] {
                    height: 36px !important;
                    max-height: 36px !important;
                    width: auto !important;
                    max-width: 100% !important;
                    object-fit: contain !important;
                }

                section[style*="background-color: rgb(209, 250, 229)"] span {
                    white-space: normal !important;
                    overflow-wrap: anywhere !important;
                    word-break: break-word !important;
                }

                footer.desktop-footer {
                    display: none !important;
                }

                footer.mobile-footer-home {
                    display: block !important;
                }
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

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-[#1b1b18] min-h-screen" style="background-color: #ffffff !important;">
        <header class="w-full bg-white sticky top-0 z-50" style="position: fixed; top: 0; left: 0; right: 0; width: 100%; z-index: 1000; background-color: rgb(255, 255, 255); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div style="height: 3px; background-color: rgb(101, 64, 48);"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (Route::has('login'))
                    <!-- Mobile Header -->
                    <div class="mobile-header">
                        <div class="mobile-logo">
                            <a href="/" class="flex items-center gap-2 shrink-0" style="text-decoration: none; color: inherit;">
                                <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" class="block h-12 w-auto" style="height: 48px; width: auto; object-fit: contain;">
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
                    
                    <!-- Mobile Menu -->
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

                    <nav class="desktop-menu py-4 flex items-center justify-between gap-4 flex-wrap">
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

        <!-- Hero Section - Page Header -->
        <section class="relative w-full flex items-center justify-center overflow-hidden" style="min-height: 45vh; padding: 60px 0; background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42)); font-family: 'Georgia', 'Times New Roman', Times, serif;">
            <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center" style="margin-top: 100px;">
                <h1 class="mb-6" style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px; font-family: 'Georgia', 'Times New Roman', Times, serif;">
                    À Propos de Nous
                </h1>
                <p class="mx-auto max-w-3xl" style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px; font-family: 'Georgia', 'Times New Roman', Times, serif;">
                    Bureau d'études et de consultation dans le domaine des géosciences, des mines et de<br>l'environnement en République Centrafricaine
                </p>
            </div>
        </section>

        <!-- Main Content Section -->
        <section class="w-full bg-white" style="padding: 0px 24px; font-family: 'Georgia', 'Times New Roman', Times, serif;">
            <div class="max-w-7xl mx-auto" style="padding: 96px 0;">
                <!-- Image and Text Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20" style="display: grid; grid-template-columns: 592px 592px; gap: 48px; align-items: center; margin-bottom: 80px;">
                    <!-- Image -->
                    <div>
                        <img src="{{ asset('Image/Cabinet d\'Études Géologiques.jpg') }}" alt="Cabinet d'Études Géologiques" class="w-full h-auto" style="width: 592px; height: 500px; object-fit: cover; border-radius: 0px;">
                    </div>
                    <!-- Text Content -->
                    <div style="font-family: 'Georgia', 'Times New Roman', Times, serif;">
                        <div class="mb-4" style="margin-bottom: 16px;">
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold" style="background-color: rgba(16, 185, 129, 0.1); color: rgb(5, 150, 105); padding: 8px 16px; border-radius: 9999px; font-size: 14px; font-weight: 600; display: inline-block;">
                                CEGME SARL
                            </span>
                        </div>
                        <h2 class="text-3xl font-bold mb-6" style="font-size: 32px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 24px; line-height: 40px; font-family: 'Georgia', 'Times New Roman', Times, serif;">
                            Cabinet d'Études Géologiques, Minières et Environnementales
                        </h2>
                        <p class="text-gray-700 mb-4" style="font-size: 16px; color: rgb(55, 65, 81); line-height: 26px; margin-bottom: 16px; font-family: 'Georgia', 'Times New Roman', Times, serif;">
                            Entreprise de droit centrafricain, CEGME est implanté dans la capitale Bangui et exerce ses activités sur l'ensemble du territoire national de la République Centrafricaine.
                        </p>
                        <p class="text-gray-700 mb-6" style="font-size: 16px; color: rgb(55, 65, 81); line-height: 26px; margin-bottom: 24px; font-family: 'Georgia', 'Times New Roman', Times, serif;">
                            Nous nous appuyons sur un réseau de compétence nationale constitué d'un puzzle de spécialistes. Nous combinons le point de vue du client, la compétence du cabinet, la connaissance des exigences de l'administration et les bonnes pratiques pour produire des résultats durables et rentables.
                        </p>
                        <!-- Location -->
                        <div class="flex items-center gap-2" style="display: flex; align-items: center; gap: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; color: rgb(5, 150, 105);">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span class="text-gray-600 font-bold" style="font-size: 16px; color: rgb(75, 85, 99); font-weight: 700;">Bangui, République Centrafricaine</span>
                        </div>
                    </div>
                </div>

                <!-- Agréments & Certifications Section -->
                <section class="mb-20" style="margin-bottom: 80px;">
                    <h2 class="text-4xl font-bold text-center mb-12" style="font-size: 36px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 48px; text-align: center;">
                        Agréments & Certifications
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 32px;">
                        <!-- Card 1: Agrément Ministériel -->
                        <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-4" style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; text-align: center;">
                                Agrément Ministériel
                            </h3>
                            <p class="text-green-600 text-2xl font-bold mb-2" style="font-size: 24px; font-weight: 800; color: rgb(5, 150, 105); margin-bottom: 12px; text-align: center;">
                                004/MEDD/DIRCAB_21
                            </p>
                            <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 0px; text-align: center;">
                                Plateforme d'experts nationaux agréée par le Ministère de l'Environnement
                            </p>
                        </div>

                        <!-- Card 2: Registre du Commerce -->
                        <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-4" style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                    <path d="M3 9h18"></path>
                                    <path d="M9 21V9"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; text-align: center;">
                                Registre du Commerce
                            </h3>
                            <p class="text-green-600 text-2xl font-bold mb-2" style="font-size: 24px; font-weight: 800; color: rgb(5, 150, 105); margin-bottom: 12px; text-align: center;">
                                CA/BG/2015B514
                            </p>
                            <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 0px; text-align: center;">
                                Entreprise de droit centrafricain
                            </p>
                        </div>

                        <!-- Card 3: OAPI -->
                        <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-4" style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; text-align: center;">
                                OAPI
                            </h3>
                            <p class="text-green-600 text-2xl font-bold mb-2" style="font-size: 24px; font-weight: 800; color: rgb(5, 150, 105); margin-bottom: 12px; text-align: center;">
                                120557
                            </p>
                            <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 0px; text-align: center;">
                                Enregistré à l'Organisation Africaine de la Propriété Intellectuelle
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Nos Valeurs Section -->
                <section class="mb-20" style="margin-bottom: 80px;">
                    <h2 class="text-4xl font-bold text-center mb-12" style="font-size: 36px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 48px; text-align: center;">
                        Nos Valeurs
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 32px;">
                        <!-- Card 1: Développement Durable -->
                        <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-4" style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2" style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; text-align: center;">
                                Développement Durable
                            </h3>
                            <p class="text-gray-600" style="font-size: 14px; color: rgb(75, 85, 99); line-height: 22.75px; text-align: center;">
                                Promotion d'une gestion responsable des ressources naturelles
                            </p>
                        </div>

                        <!-- Card 2: Expertise Locale -->
                        <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-4" style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2" style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; text-align: center;">
                                Expertise Locale
                            </h3>
                            <p class="text-gray-600" style="font-size: 14px; color: rgb(75, 85, 99); line-height: 22.75px; text-align: center;">
                                Réseau de compétences nationales et puzzle de spécialistes
                            </p>
                        </div>

                        <!-- Card 3: Vision Régionale -->
                        <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-4" style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                    <path d="M2 12h20"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2" style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; text-align: center;">
                                Vision Régionale
                            </h3>
                            <p class="text-gray-600" style="font-size: 14px; color: rgb(75, 85, 99); line-height: 22.75px; text-align: center;">
                                Coopération sud-sud pour une approche panafricaine
                            </p>
                        </div>

                        <!-- Card 4: Résultats Durables -->
                        <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-4" style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-2" style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; text-align: center;">
                                Résultats Durables
                            </h3>
                            <p class="text-gray-600" style="font-size: 14px; color: rgb(75, 85, 99); line-height: 22.75px; text-align: center;">
                                Combinaison d'expertise technique et de bonnes pratiques
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Coopération Régionale Section -->
                <section class="mb-20" style="margin-bottom: 80px; background-color: rgb(209, 250, 229); padding: 48px 24px; border-radius: 12px;">
                    <h3 class="text-3xl font-bold mb-6" style="font-size: 30px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 24px; text-align: center;">
                        Coopération Régionale
                    </h3>
                    <p class="text-gray-700 mb-4" style="font-size: 18px; color: rgb(55, 65, 81); line-height: 29.25px; margin-bottom: 16px; text-align: center;">
                        Au niveau régional, sur le volet des évaluations environnementales, le CEGME travaille en symbiose avec le <span>Bureau d'Étude Solution Environnementale Viable & Entrepreneuriat (Seve-Consulting) Sarl., installé à Lomé au</span><br>TOGO en Afrique de l'Ouest.
                    </p>
                    <p class="text-gray-700" style="font-size: 18px; color: rgb(55, 65, 81); line-height: 29.25px; margin-bottom: 0px; text-align: center;">
                        Cette coopération sud-sud renforce notre capacité à appréhender les enjeux des projets de développement en<br>Afrique.
                    </p>
                </section>
            </div>
        </section>

        <!-- Footer - Exact from Site -->
        <footer class="w-full text-white px-4 sm:px-6 lg:px-8 desktop-footer" style="background: linear-gradient(180deg, rgb(15, 64, 62) 0%, rgb(22, 78, 75) 50%, rgb(25, 85, 82) 100%); padding: 64px 0 32px; color: rgb(255, 255, 255);">
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
                                <p class="text-gray-300 text-sm" style="color: rgb(209, 213, 219); font-size: 14px; margin-top: 4px;">cabinet.rca@cegme.net / cegme.sarl@gmail.com</p>
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

        <footer class="w-full text-white px-4 sm:px-6 lg:px-8 mobile-footer-home" style="background: linear-gradient(to right bottom, rgb(15, 23, 42), rgb(6, 78, 59), rgb(19, 78, 74)); padding: 80px 0 32px; color: rgb(255, 255, 255); position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(5, 150, 105, 0.08) 0%, transparent 50%); pointer-events: none;"></div>
            <div class="relative z-10" style="position: relative; z-index: 10;">
            <div class="max-w-7xl mx-auto" style="padding: 0px;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px; margin-bottom: 48px; padding: 0px;">
                    <div>
                        <div class="flex items-center gap-3 mb-6" style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                            <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" class="block h-12 w-auto" style="height: 48px; width: auto; object-fit: contain;">
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
                            <li>
                                <a href="/" class="text-gray-200 hover:text-green-300 transition-all duration-200 flex items-center gap-2 group" style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity" style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Accueil</span>
                                </a>
                            </li>
                            <li>
                                <a href="/a-propos" class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity" style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>À Propos</span>
                                </a>
                            </li>
                            <li>
                                <a href="/services" class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity" style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Services</span>
                                </a>
                            </li>
                            <li>
                                <a href="/realisations" class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity" style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Réalisations</span>
                                </a>
                            </li>
                            <li>
                                <a href="/actualites" class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity" style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Actualités</span>
                                </a>
                            </li>
                            <li>
                                <a href="/blog" class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity" style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Blog</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('appels-offres.index') }}" class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity" style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Appels d'Offres</span>
                                </a>
                            </li>
                            <li>
                                <a href="/contact" class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group" style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity" style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>Contact</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-bold mb-6" style="font-size: 20px; font-weight: 800; margin-bottom: 24px; color: rgb(255, 255, 255); letter-spacing: -0.3px;">
                            Contact
                        </h3>
                        <ul class="space-y-4" style="list-style: none; padding: 0; margin: 0;">
                            <li style="padding: 0;">
                                <div class="flex items-start gap-3" style="display: flex; align-items: flex-start; gap: 12px;">
                                    <div class="w-10 h-10 bg-green-400 bg-opacity-25 rounded-lg flex items-center justify-center flex-shrink-0" style="width: 40px; height: 40px; background-color: rgba(52, 211, 153, 0.25); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; color: rgb(52, 211, 153);">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-white font-semibold block mb-1" style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Adresse</span>
                                        <p class="text-gray-300 text-sm leading-relaxed" style="color: rgb(209, 213, 219); font-size: 14px; margin: 0; line-height: 22px;">Bangui, République Centrafricaine</p>
                                    </div>
                                </div>
                            </li>
                            <li style="padding: 0;">
                                <div class="flex items-start gap-3" style="display: flex; align-items: flex-start; gap: 12px;">
                                    <div class="w-10 h-10 bg-green-400 bg-opacity-25 rounded-lg flex items-center justify-center flex-shrink-0" style="width: 40px; height: 40px; background-color: rgba(52, 211, 153, 0.25); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; color: rgb(52, 211, 153);">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-white font-semibold block mb-1" style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Email</span>
                                        <a href="mailto:cabinet.rca@cegme.net" class="text-gray-200 text-sm hover:text-green-300 transition-colors" style="color: rgb(229, 231, 235); font-size: 14px; text-decoration: none; transition: color 0.2s ease;">cabinet.rca@cegme.net / cegme.sarl@gmail.com</a>
                                    </div>
                                </div>
                            </li>
                            <li style="padding: 0;">
                                <div class="flex items-start gap-3" style="display: flex; align-items: flex-start; gap: 12px;">
                                    <div class="w-10 h-10 bg-green-400 bg-opacity-25 rounded-lg flex items-center justify-center flex-shrink-0" style="width: 40px; height: 40px; background-color: rgba(52, 211, 153, 0.25); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; color: rgb(52, 211, 153);">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-white font-semibold block mb-1" style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Registre</span>
                                        <p class="text-gray-300 text-sm leading-relaxed" style="color: rgb(209, 213, 219); font-size: 14px; margin: 0; line-height: 22px;">CA/BG/2015B514</p>
                                    </div>
                                </div>
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

        <!-- Mobile Menu JavaScript -->
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

