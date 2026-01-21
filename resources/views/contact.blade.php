<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contact - {{ config('app.name', 'Laravel') }}</title>

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
    </style>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* MOBILE ONLY STYLES */
        @media (max-width: 768px) {
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

            .contact-icon-address {
                background-color: rgb(16, 185, 129) !important;
            }

            .contact-icon-address svg {
                color: rgb(255, 255, 255) !important;
            }

            .contact-icon-email {
                background-color: rgb(59, 130, 246) !important;
            }

            .contact-icon-email svg {
                color: rgb(255, 255, 255) !important;
            }

            .contact-icon-phone {
                background: linear-gradient(135deg, rgb(168, 85, 247) 0%, rgb(236, 72, 153) 100%) !important;
            }

            .contact-icon-phone svg {
                color: rgb(255, 255, 255) !important;
            }

            .contact-cards-grid {
                grid-template-columns: 1fr !important;
            }

            .contact-info-card {
                width: 320px !important;
                max-width: 100% !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .contact-form-wrapper {
                width: 480px !important;
                max-width: 100% !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            footer .grid.grid-cols-1.md\:grid-cols-3.gap-12 {
                grid-template-columns: 1fr !important;
                gap: 24px !important;
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
</head>

<body class="bg-white text-[#1b1b18] min-h-screen" style="background-color: #ffffff !important;">
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
                                <form method="POST" action="{{ route('logout') }}" class="inline-block" style="margin: 0;">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-white font-medium transition-all duration-200 hover:opacity-90 rounded-full cursor-pointer"
                                        style="font-family: inherit; background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); padding: 8px 18px; font-size: 14px; border-radius: 8px; flex-shrink: 0; white-space: nowrap; border: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" style="width: 16px; height: 16px;">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span>Déconnexion</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-white font-medium transition-all duration-200 hover:opacity-90 rounded-full desktop-login-button"
                                    style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); padding: 8px 18px; font-size: 14px; border-radius: 8px;">
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
                Contactez-Nous
            </h1>
            <p class="mx-auto max-w-3xl"
                style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                Notre équipe est à votre disposition pour répondre à toutes vos questions
            </p>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 96px 0;">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16 contact-cards-grid"
                style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 32px; margin-bottom: 64px;">
                <!-- Card 1: Adresse -->
                <div class="bg-white rounded-lg p-6 shadow-md text-center contact-info-card"
                    style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; text-align: center;">
                    <div class="w-16 h-16 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-4 contact-icon-address"
                        style="width: 64px; height: 64px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 32px; height: 32px; color: rgb(5, 150, 105);">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3"
                        style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                        Adresse
                    </h3>
                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                        Bangui, République Centrafricaine
                    </p>
                </div>

                <!-- Card 2: Email -->
                <div class="bg-white rounded-lg p-6 shadow-md text-center contact-info-card"
                    style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; text-align: center;">
                    <div class="w-16 h-16 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-4 contact-icon-email"
                        style="width: 64px; height: 64px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 32px; height: 32px; color: rgb(5, 150, 105);">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3"
                        style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                        Email
                    </h3>
                    <p class="text-gray-600 mb-1" style="font-size: 16px; color: rgb(75, 85, 99); margin-bottom: 4px;">
                        cabinet.rca@cegme.net
                    </p>
                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                        cegme.sarl@gmail.com
                    </p>
                </div>

                <!-- Card 3: Téléphone -->
                <div class="bg-white rounded-lg p-6 shadow-md text-center contact-info-card"
                    style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; text-align: center;">
                    <div class="w-16 h-16 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-4 contact-icon-phone"
                        style="width: 64px; height: 64px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 32px; height: 32px; color: rgb(5, 150, 105);">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3"
                        style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                        Téléphone
                    </h3>
                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                        (+236) 72 50 51 31 / 75 70 31 20
                    </p>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="max-w-3xl mx-auto contact-form-wrapper">
                <div class="text-center mb-8" style="margin-bottom: 32px; text-align: center;">
                    <h2 class="text-4xl font-bold mb-4"
                        style="font-size: 36px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 16px;">
                        Envoyez-nous un Message
                    </h2>
                    <p class="text-lg text-gray-600"
                        style="font-size: 16px; color: rgb(75, 85, 99); margin-bottom: 0px;">
                        Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais
                    </p>
                </div>

                @if (session('success'))
                    <div class="mb-6 p-4 rounded-lg"
                        style="margin-bottom: 24px; padding: 16px; border-radius: 8px; background-color: rgb(209, 250, 229); color: rgb(5, 150, 105); font-weight: 600;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-lg"
                        style="margin-bottom: 24px; padding: 16px; border-radius: 8px; background-color: rgb(254, 226, 226); color: rgb(185, 28, 28); font-weight: 600;">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg"
                        style="margin-bottom: 24px; padding: 16px; border-radius: 8px; background-color: rgb(254, 226, 226); color: rgb(185, 28, 28);">
                        <div style="font-weight: 700; margin-bottom: 8px;">Veuillez corriger les erreurs ci-dessous :</div>
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" class="bg-white rounded-lg shadow-md p-8"
                    style="background-color: rgb(255, 255, 255); border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; padding: 32px;">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"
                        style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; margin-bottom: 24px;">
                        <!-- Nom complet -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2"
                                style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required placeholder="Votre nom"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px;"
                                value="{{ old('name') }}">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2"
                                style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required placeholder="votre@email.com"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px;"
                                value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"
                        style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; margin-bottom: 24px;">
                        <!-- Téléphone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2"
                                style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                                Téléphone
                            </label>
                            <input type="tel" id="phone" name="phone" placeholder="(+236) 72 50 51 31 / 75 70 31 20"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px;"
                                value="{{ old('phone') }}">
                        </div>

                        <!-- Sujet -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2"
                                style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                                Sujet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="subject" name="subject" required placeholder="Sujet de votre message"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px;"
                                value="{{ old('subject') }}">
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="mb-6" style="margin-bottom: 24px;">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2"
                            style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" required rows="6"
                            placeholder="Décrivez votre projet ou votre demande..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"
                            style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px; resize: none; min-height: 150px;">{{ old('message') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center" style="text-align: center;">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-8 py-4 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors"
                            style="display: inline-flex; align-items: center; gap: 8px; padding: 16px 32px; background-color: rgb(5, 150, 105); color: rgb(255, 255, 255); border-radius: 8px; font-size: 16px; font-weight: 500; border: none; cursor: pointer;">
                            <span>Envoyer le message</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 20px; height: 20px;">
                                <path d="M22 2 11 13"></path>
                                <path d="M22 2l-7 20-4-9-9-4Z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer - Exact from Site -->
    <footer class="w-full text-white px-4 sm:px-6 lg:px-8"
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
                                cabinet.rca@cegme.net</p>
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