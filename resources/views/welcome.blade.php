<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
            <style>
            .why-choose-grid {
                display: grid;
                grid-template-columns: repeat(3, 389px);
                gap: 32px;
                max-width: 100%;
                justify-content: center;
                margin: 0 auto;
            }
            @media (max-width: 1280px) {
                .why-choose-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }
            @media (max-width: 768px) {
                .why-choose-grid {
                    grid-template-columns: 1fr !important;
                }
            }
            section {
                border: none !important;
                border-top: none !important;
                border-bottom: none !important;
                background-color: #ffffff !important;
            }
            body {
                background-color: #ffffff !important;
            }
            * {
                border-color: transparent !important;
            }
            .step-connector {
                position: absolute;
                top: 32px;
                left: calc(50% + 32px);
                right: calc(-50% + 32px);
                height: 2px;
                background: linear-gradient(90deg, rgba(128, 221, 203, 0.7) 0%, rgba(144, 224, 208, 0.9) 50%, rgba(128, 221, 203, 0.7) 100%);
                z-index: 1;
                pointer-events: none;
            }
            @media (max-width: 1024px) {
                .step-connector {
                    display: none;
                }
            }
            </style>
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
                            <a href="/contact" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('contact') || request()->is('contact/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('contact') || request()->is('contact/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Rendez-vous
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
        <!-- Hero Section - Exact Reproduction from Site -->
        <section class="relative w-full flex items-center justify-center overflow-hidden" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; min-height: 100vh; padding: 0;">
            <!-- Background Image with Greenish-Blue Overlay -->
            <div class="absolute inset-0" style="background-color: rgb(5, 130, 80);">
                <!-- Background Image -->
                <img src="{{ asset('Image/IIMG_Banniere.jpg') }}" alt="Bannière CEGME" class="absolute inset-0 w-full h-full object-cover" loading="eager" style="background-color: rgb(5, 130, 80); z-index: 1;">
                <!-- Green overlay filter mixed with image -->
                <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(5, 130, 80, 0.7) 0%, rgba(8, 60, 45, 0.7) 100%); z-index: 2;"></div>
            </div>
            
            <!-- Content Container - Centered, Exact Positioning from Site -->
            <div class="relative z-10 w-full max-w-[1200px] mx-auto px-4 text-center flex flex-col items-center justify-start" style="min-height: 100vh; padding-top: 120px; z-index: 10; position: relative;">
                <!-- Badge - Plateforme d'Experts Nationaux Agréée -->
                <div class="inline-block px-6 py-2 mb-6 rounded-full" style="background-color: rgba(16, 185, 129, 0.3); border: 1px solid rgb(5, 150, 105) !important; border-radius: 9999px; padding: 8px 24px; margin-bottom: 24px; margin-top: 20px;">
                    <p class="text-center" style="color: rgb(110, 231, 183) !important; font-size: 16px; font-weight: 500; margin: 0;">
                        Plateforme d'Experts Nationaux Agréée
                    </p>
                </div>
                
                <!-- Main Title - Exact Typography from Site -->
                <h1 class="mb-6 text-center" style="font-size: 72px; font-weight: 700; line-height: 72px; margin-bottom: 24px; margin-top: 40px; color: #ffffff;">
                    <span class="block text-white">Expertise en Géosciences,</span>
                    <span class="block text-center" style="color: rgb(20, 184, 166); text-align: center;">Mines & Environnement</span>
                </h1>
                
                <!-- Descriptive Paragraph - Exact from Site -->
                <p class="mb-10 mx-auto text-center" style="font-size: 20px; color: rgb(229, 231, 235); line-height: 32.5px; margin-bottom: 40px; max-width: 768px; text-align: center; display: block; margin-left: auto; margin-right: auto;">
                    CEGME accompagne vos projets en République Centrafricaine avec une approche durable et responsable
                </p>
                
                <!-- Call-to-Action Buttons - Exact from Site -->
                <div class="flex flex-row items-center justify-center" style="gap: 20px; margin-top: 40px;">
                    <!-- Nos Services Button - Exact from Site -->
                    <a href="/services" class="inline-flex items-center justify-center gap-2 px-8 py-2 text-white font-medium transition-all duration-200 hover:opacity-90" style="background-color: rgb(5, 150, 105); border-radius: 9999px; padding: 10px 32px; font-size: 18px;">
                        <span>Nos Services</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; stroke-width: 2.5;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                    
                    <!-- Nous Contacter Button - Exact from Site -->
                    <span class="inline-flex items-center justify-center px-8 py-2 text-white font-medium" style="background-color: transparent !important; border: 2px solid rgb(255, 255, 255) !important; border-radius: 9999px; padding: 10px 32px; font-size: 18px; cursor: default; pointer-events: none;">
                        <span>Nous Contacter</span>
                    </span>
                </div>
            </div>
        </section>
        
        <!-- Statistics Section - Enhanced Professional Design -->
        <section class="w-full bg-white" style="padding: 60px 0; margin: 0; background-color: #ffffff;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding: 0; margin: 0;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 24px; padding: 0; margin: 0;">
                    <!-- Card 1: Évaluations Environnementales -->
                    <div class="text-center" style="text-align: center; padding: 0;">
                        <!-- Icon Container -->
                        <div class="mb-6 mx-auto" style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; padding: 0; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 35px; height: 35px; color: #ffffff;">
                                <path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path>
                                <circle cx="12" cy="8" r="6"></circle>
                            </svg>
                        </div>
                        <!-- Number -->
                        <div style="font-size: 48px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 52px; margin-bottom: 8px; margin-top: 0; letter-spacing: -2px;">
                            30+
                        </div>
                        <!-- Title -->
                        <h3 style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 26px; letter-spacing: -0.3px;">
                            Évaluations Environnementales
                        </h3>
                        <!-- Description -->
                        <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-top: 0; max-width: 100%;">
                            EIES, Audit, Diagnostic, Manuel réalisés aux niveaux national et régional
                        </p>
                    </div>

                    <!-- Card 2: Années d'Expérience -->
                    <div class="text-center" style="text-align: center; padding: 0;">
                        <!-- Icon Container -->
                        <div class="mb-6 mx-auto" style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; padding: 0; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 35px; height: 35px; color: #ffffff;">
                                <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>
                        </div>
                        <!-- Number -->
                        <div style="font-size: 48px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 52px; margin-bottom: 8px; margin-top: 0; letter-spacing: -2px;">
                            7
                        </div>
                        <!-- Title -->
                        <h3 style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 26px; letter-spacing: -0.3px;">
                            Années d'Expérience
                        </h3>
                        <!-- Description -->
                        <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-top: 0; max-width: 100%;">
                            Dans le domaine des géosciences, mines et environnement
                        </p>
                    </div>

                    <!-- Card 3: Pays d'Intervention -->
                    <div class="text-center" style="text-align: center; padding: 0;">
                        <!-- Icon Container -->
                        <div class="mb-6 mx-auto" style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; padding: 0; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 35px; height: 35px; color: #ffffff;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg>
                        </div>
                        <!-- Number -->
                        <div style="font-size: 48px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 52px; margin-bottom: 8px; margin-top: 0; letter-spacing: -2px;">
                            4
                        </div>
                        <!-- Title -->
                        <h3 style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 26px; letter-spacing: -0.3px;">
                            Pays d'Intervention
                        </h3>
                        <!-- Description -->
                        <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-top: 0; max-width: 100%;">
                            Actifs au Niger, Cameroun, Togo et Maroc
                        </p>
                    </div>

                    <!-- Card 4: Études Minières -->
                    <div class="text-center" style="text-align: center; padding: 0;">
                        <!-- Icon Container -->
                        <div class="mb-6 mx-auto" style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; padding: 0; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 35px; height: 35px; color: #ffffff;">
                                <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
                                <path d="M9 22v-4h6v4"></path>
                                <path d="M8 6h.01"></path>
                                <path d="M16 6h.01"></path>
                                <path d="M12 6h.01"></path>
                                <path d="M12 10h.01"></path>
                                <path d="M12 14h.01"></path>
                                <path d="M16 10h.01"></path>
                                <path d="M16 14h.01"></path>
                                <path d="M8 10h.01"></path>
                                <path d="M8 14h.01"></path>
                            </svg>
                        </div>
                        <!-- Number -->
                        <div style="font-size: 48px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 52px; margin-bottom: 8px; margin-top: 0; letter-spacing: -2px;">
                            10+
                        </div>
                        <!-- Title -->
                        <h3 style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 26px; letter-spacing: -0.3px;">
                            Études Minières
                        </h3>
                        <!-- Description -->
                        <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 20px; margin-top: 0; max-width: 100%;">
                            Études de faisabilité et évaluations économiques validées
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Why Choose Us Section - Enhanced Professional Design -->
        <section class="w-full bg-gray-100 px-4 sm:px-6 lg:px-8" style="padding: 96px 0; background-color: #f9fafb !important;">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                    <h2 class="text-4xl font-bold text-black mb-4" style="font-size: 40px; font-weight: 700; color: #1b1b18; margin-bottom: 16px; text-align: center;">
                        Pourquoi Choisir CEGME ?
                    </h2>
                    <p class="text-lg text-gray-600 mx-auto" style="font-size: 18px; color: #6b7280; max-width: 700px; margin: 0 auto; text-align: center;">
                        Des atouts qui font la différence pour la réussite de vos projets
                    </p>
                </div>
                
                <!-- Cards Grid - 3 cards per row (exact from site: grid with 3 columns of 389px, gap 32px) -->
                <div class="why-choose-grid items-stretch justify-center">
                    <!-- Card 1: Expertise Locale -->
                    <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100" style="border-radius: 16px; padding: 36px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; width: 389px; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); margin: 0 auto 24px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <circle cx="12" cy="12" r="9" stroke="white" fill="none"></circle>
                                <circle cx="12" cy="12" r="5" stroke="white" fill="none"></circle>
                                <circle cx="12" cy="12" r="1.5" fill="white"></circle>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 700; color: #1b1b18; margin-bottom: 16px; line-height: 28px; text-align: center;">
                            Expertise Locale
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center" style="font-size: 15px; line-height: 1.75; color: #6b7280; margin: 0; text-align: center;">
                            Connaissance approfondie du contexte centrafricain et des réglementations nationales
                        </p>
                    </div>
                    
                    <!-- Card 2: Agrément Officiel -->
                    <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100" style="border-radius: 16px; padding: 36px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; width: 389px; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); margin: 0 auto 24px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 700; color: #1b1b18; margin-bottom: 16px; line-height: 28px; text-align: center;">
                            Agrément Officiel
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center" style="font-size: 15px; line-height: 1.75; color: #6b7280; margin: 0; text-align: center;">
                            Plateforme d'experts agréée par le Ministère de l'Environnement (N° 004/MEDD/DIRCAB_21)
                        </p>
                    </div>
                    
                    <!-- Card 3: Réseau de Spécialistes -->
                    <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100" style="border-radius: 16px; padding: 36px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; width: 389px; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); margin: 0 auto 24px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 700; color: #1b1b18; margin-bottom: 16px; line-height: 28px; text-align: center;">
                            Réseau de Spécialistes
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center" style="font-size: 15px; line-height: 1.75; color: #6b7280; margin: 0; text-align: center;">
                            Équipe pluridisciplinaire et partenariats stratégiques nationaux et internationaux
                        </p>
                    </div>
                    
                    <!-- Card 4: Réactivité -->
                    <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100" style="border-radius: 16px; padding: 36px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; width: 389px; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); margin: 0 auto 24px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 700; color: #1b1b18; margin-bottom: 16px; line-height: 28px; text-align: center;">
                            Réactivité
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center" style="font-size: 15px; line-height: 1.75; color: #6b7280; margin: 0; text-align: center;">
                            Intervention rapide sur tout le territoire centrafricain avec une approche flexible
                        </p>
                    </div>
                    
                    <!-- Card 5: Conformité Garantie -->
                    <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100" style="border-radius: 16px; padding: 36px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; width: 389px; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); margin: 0 auto 24px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 700; color: #1b1b18; margin-bottom: 16px; line-height: 28px; text-align: center;">
                            Conformité Garantie
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center" style="font-size: 15px; line-height: 1.75; color: #6b7280; margin: 0; text-align: center;">
                            Tous nos rapports sont validés par les ministères compétents
                        </p>
                    </div>
                    
                    <!-- Card 6: Approche Innovante -->
                    <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100" style="border-radius: 16px; padding: 36px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; width: 389px; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); margin: 0 auto 24px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 700; color: #1b1b18; margin-bottom: 16px; line-height: 28px; text-align: center;">
                            Approche Innovante
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center" style="font-size: 15px; line-height: 1.75; color: #6b7280; margin: 0; text-align: center;">
                            Solutions durables combinant expertise technique et bonnes pratiques internationales
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Nos Pôles d'Activités Section - Enhanced Design -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 96px 0; margin: 0; border: none !important; border-top: none !important; border-bottom: none !important; outline: none !important; background-color: #ffffff !important;">
            <div class="max-w-6xl mx-auto" style="border: none !important; border-top: none !important; border-bottom: none !important;">
                <!-- Header -->
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                    <h2 class="text-4xl font-bold text-black mb-4" style="font-size: 40px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 16px; text-align: center;">
                        Nos Pôles d'Activités
                    </h2>
                    <p class="text-lg text-gray-600 mx-auto" style="font-size: 18px; color: #6b7280; max-width: 700px; margin: 0 auto; text-align: center;">
                        Une expertise complète au service de vos projets
                    </p>
                </div>
                
                <!-- Cards Grid - 2x2 layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; max-width: 1150px; margin: 0 auto;">
                    <!-- Card 1: Environnement et Développement Durable -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); max-width: 100%; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="inline-flex items-center justify-center mb-6" style="width: 64px; height: 64px; border-radius: 16px; background: rgb(34, 197, 94); box-shadow: 0 8px 16px rgba(34, 197, 94, 0.25); margin-bottom: 20px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px;">
                            Environnement et Développement Durable
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 mb-4" style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 20px;">
                            Études d'impact environnemental et social, audits, gestion durable des ressources naturelles
                        </p>
                        <!-- Button -->
                        <button class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors" style="font-size: 15px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 6px;">
                            <span>En savoir plus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Card 2: Recherche Géologique et Minière -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); max-width: 100%; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="inline-flex items-center justify-center mb-6" style="width: 64px; height: 64px; border-radius: 16px; background: rgb(249, 115, 22); box-shadow: 0 8px 16px rgba(249, 115, 22, 0.25); margin-bottom: 20px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px;">
                            Recherche Géologique et Minière
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 mb-4" style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 20px;">
                            Exploration géologique, cartographie numérique, évaluation économique de projets miniers
                        </p>
                        <!-- Button -->
                        <button class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors" style="font-size: 15px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 6px;">
                            <span>En savoir plus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Card 3: Géo-ingénierie Appliquée -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); max-width: 100%; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="inline-flex items-center justify-center mb-6" style="width: 64px; height: 64px; border-radius: 16px; background: rgb(59, 130, 246); box-shadow: 0 8px 16px rgba(59, 130, 246, 0.25); margin-bottom: 20px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px;">
                            Géo-ingénierie Appliquée
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 mb-4" style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 20px;">
                            SIG, études hydrogéologiques et géotechniques, modélisation cartographique
                        </p>
                        <!-- Button -->
                        <button class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors" style="font-size: 15px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 6px;">
                            <span>En savoir plus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Card 4: Négoce et Représentation -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); max-width: 100%; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <!-- Icon -->
                        <div class="inline-flex items-center justify-center mb-6" style="width: 64px; height: 64px; border-radius: 16px; background: rgb(147, 51, 234); box-shadow: 0 8px 16px rgba(147, 51, 234, 0.25); margin-bottom: 20px;">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 2; width: 32px; height: 32px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px;">
                            Négoce et Représentation
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 mb-4" style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px; margin-bottom: 20px;">
                            Conseil aux investisseurs, représentation d'entreprises, négociation commerciale
                        </p>
                        <!-- Button -->
                        <button class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors" style="font-size: 15px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 6px;">
                            <span>En savoir plus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Projets Récents Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 32px 0; margin: 0 0 64px; background-color: #ffffff !important;">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-6" style="text-align: center; margin-bottom: 24px;">
                    <h2 class="text-4xl font-bold text-black mb-4" style="font-size: 40px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; text-align: center;">
                        Projets Récents
                    </h2>
                    <p class="text-lg text-gray-600 mx-auto max-w-2xl" style="font-size: 18px; color: rgb(75, 85, 99); max-width: 600px; margin: 0 auto; text-align: center;">
                        Découvrez nos dernières réalisations et projets d'envergure
                    </p>
                </div>
                
                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px;">
                    <!-- Project 1 -->
                    <a href="/services" class="block bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow" style="display: block; background-color: rgb(255, 255, 255); border-radius: 16px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; overflow: hidden; transition: box-shadow 0.3s ease; text-decoration: none; color: inherit; cursor: pointer;">
                        <div class="relative" style="position: relative;">
                            <img src="{{ asset('Image/Complexe Immobilier.jpg') }}" alt="Complexe Immobilier BDEAC" class="w-full h-48 object-cover" style="width: 100%; height: 192px; object-fit: cover;">
                            <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium" style="position: absolute; top: 16px; right: 16px; background-color: rgb(5, 150, 105); color: rgb(255, 255, 255); padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500;">
                                2021
                            </div>
                        </div>
                        <div class="p-6" style="padding: 24px;">
                            <div class="mb-3" style="margin-bottom: 12px;">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium" style="background-color: rgb(220, 252, 231); color: rgb(5, 150, 105); padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500; display: inline-block;">
                                    environnement
                                </span>
                            </div>
                            <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px;">
                                Complexe Immobilier BDEAC
                            </h3>
                            <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                EIES pour construction d'un complexe administratif et résidentiel au centre-ville de Bangui
                            </p>
                        </div>
                    </a>
                    
                    <!-- Project 2 -->
                    <a href="/services" class="block bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow" style="display: block; background-color: rgb(255, 255, 255); border-radius: 16px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; overflow: hidden; transition: box-shadow 0.3s ease; text-decoration: none; color: inherit; cursor: pointer;">
                        <div class="relative" style="position: relative;">
                            <img src="{{ asset('Image/City Apartment Bangui.jpg') }}" alt="City Apartment Bangui" class="w-full h-48 object-cover" style="width: 100%; height: 192px; object-fit: cover;">
                            <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium" style="position: absolute; top: 16px; right: 16px; background-color: rgb(5, 150, 105); color: rgb(255, 255, 255); padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500;">
                                2020
                            </div>
                        </div>
                        <div class="p-6" style="padding: 24px;">
                            <div class="mb-3" style="margin-bottom: 12px;">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium" style="background-color: rgb(220, 252, 231); color: rgb(5, 150, 105); padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500; display: inline-block;">
                                    environnement
                                </span>
                            </div>
                            <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px;">
                                City Apartment Bangui
                            </h3>
                            <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                Étude d'impact pour un complexe immobilier à usage administratif et d'appartement
                            </p>
                        </div>
                    </a>
                    
                    <!-- Project 3 -->
                    <a href="/services" class="block bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow" style="display: block; background-color: rgb(255, 255, 255); border-radius: 16px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; overflow: hidden; transition: box-shadow 0.3s ease; text-decoration: none; color: inherit; cursor: pointer;">
                        <div class="relative" style="position: relative;">
                            <img src="{{ asset('Image/Exploitation Rivière Sangha.jpg') }}" alt="Exploitation Rivière Sangha" class="w-full h-48 object-cover" style="width: 100%; height: 192px; object-fit: cover;">
                            <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-medium" style="position: absolute; top: 16px; right: 16px; background-color: rgb(5, 150, 105); color: rgb(255, 255, 255); padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500;">
                                2019
                            </div>
                        </div>
                        <div class="p-6" style="padding: 24px;">
                            <div class="mb-3" style="margin-bottom: 12px;">
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium" style="background-color: rgb(255, 237, 213); color: rgb(249, 115, 22); padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500; display: inline-block;">
                                    mines
                                </span>
                            </div>
                            <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px;">
                                Exploitation Rivière Sangha
                            </h3>
                            <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                EIES pour exploitation semi-mécanisée d'or et diamant sur la rivière Sangha
                            </p>
                        </div>
                    </a>
                </div>
                
                <!-- Button -->
                <div class="text-center mt-8" style="text-align: center; margin-top: 40px;">
                    <a href="/realisations" class="inline-flex items-center gap-2 px-8 py-3 text-green-600 font-semibold rounded-xl border-2 border-green-600 hover:bg-green-600 hover:text-white transition-all duration-200" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 32px; color: rgb(10, 150, 120); font-size: 16px; font-weight: 600; border: 2px solid rgb(10, 150, 120) !important; border-radius: 24px; transition: all 0.2s ease;">
                        <span>Voir toutes nos réalisations</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
        
        <!-- Notre Approche Section - Enhanced Design -->
        <section class="w-full bg-gray-100 px-4 sm:px-6 lg:px-8" style="padding: 32px 0; margin: 0; background-color: #f3f4f6 !important;">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8" style="text-align: center; margin-bottom: 32px;">
                    <h2 class="text-4xl font-bold text-black mb-3" style="font-size: 40px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; text-align: center;">
                        Notre Approche
                    </h2>
                    <p class="text-lg text-gray-600 mx-auto" style="font-size: 18px; color: #6b7280; max-width: 700px; margin: 0 auto; text-align: center;">
                        Une méthodologie éprouvée pour garantir le succès de vos projets
                    </p>
                </div>
                
                <!-- Steps Grid - 4 steps -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; position: relative;">
                    <!-- Step 1: Analyse & Diagnostic -->
                    <div class="text-center" style="text-align: center; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2;">
                        <!-- Connecting Line -->
                        <div class="step-connector"></div>
                        <!-- Number Badge -->
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 text-2xl font-bold mb-2" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 9999px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 auto 8px; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); position: relative; z-index: 3;">
                            01
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-1.5" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin: 0 auto 6px; line-height: 28px; text-align: center; width: 100%;">
                            Analyse & Diagnostic
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600" style="font-size: 15px; color: rgb(107, 114, 128); line-height: 22px; margin: 0 auto; text-align: center; max-width: 100%;">
                            Étude approfondie du projet et évaluation des enjeux environnementaux et sociaux
                        </p>
                    </div>
                    
                    <!-- Step 2: Méthodologie Adaptée -->
                    <div class="text-center" style="text-align: center; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2;">
                        <!-- Connecting Line -->
                        <div class="step-connector"></div>
                        <!-- Number Badge -->
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 text-2xl font-bold mb-2" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 9999px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 auto 8px; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); position: relative; z-index: 3;">
                            02
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-1.5" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin: 0 auto 6px; line-height: 28px; text-align: center; width: 100%;">
                            Méthodologie Adaptée
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600" style="font-size: 15px; color: rgb(107, 114, 128); line-height: 22px; margin: 0 auto; text-align: center; max-width: 100%;">
                            Conception d'une approche sur-mesure conforme aux normes nationales et internationales
                        </p>
                    </div>
                    
                    <!-- Step 3: Études de Terrain -->
                    <div class="text-center" style="text-align: center; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2;">
                        <!-- Connecting Line -->
                        <div class="step-connector"></div>
                        <!-- Number Badge -->
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 text-2xl font-bold mb-2" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 9999px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 auto 8px; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); position: relative; z-index: 3;">
                            03
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-1.5" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin: 0 auto 6px; line-height: 28px; text-align: center; width: 100%;">
                            Études de Terrain
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600" style="font-size: 15px; color: rgb(107, 114, 128); line-height: 22px; margin: 0 auto; text-align: center; max-width: 100%;">
                            Collecte de données, consultations publiques et investigations techniques
                        </p>
                    </div>
                    
                    <!-- Step 4: Rapports & Validation -->
                    <div class="text-center" style="text-align: center; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2;">
                        <!-- Number Badge -->
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 text-2xl font-bold mb-2" style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 9999px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 auto 8px; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); position: relative; z-index: 3;">
                            04
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-1.5" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin: 0 auto 6px; line-height: 28px; text-align: center; width: 100%;">
                            Rapports & Validation
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600" style="font-size: 15px; color: rgb(107, 114, 128); line-height: 22px; margin: 0 auto; text-align: center; max-width: 100%;">
                            Rédaction de rapports détaillés et accompagnement jusqu'à la validation officielle
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Besoin d'une Étude de Terrain ? Section -->
        <section class="w-full px-4 sm:px-6 lg:px-8" style="padding: 80px 0; margin: 0; background: linear-gradient(180deg, rgb(15, 64, 62) 0%, rgb(22, 78, 75) 50%, rgb(25, 85, 82) 100%);">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold text-white mb-4" style="font-size: 40px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 16px; text-align: center;">
                    Besoin d'une Étude de Terrain ?
                </h2>
                <p class="text-xl text-white mb-8" style="font-size: 20px; color: rgb(255, 255, 255); margin-bottom: 32px; text-align: center; line-height: 30px;">
                    Experts dans la promotion d'une gestion durable des ressources géologiques, minières et<br>
                    naturelles de la Centrafrique
                </p>
                <div class="flex justify-center" style="display: flex; justify-content: center;">
                    <span class="inline-flex items-center gap-2 px-8 py-3 bg-white text-black rounded-xl font-semibold shadow-lg" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 32px; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); border-radius: 12px; font-size: 16px; font-weight: 600; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); cursor: default; pointer-events: none;">
                        <span>Contactez-nous</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </span>
                </div>
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
