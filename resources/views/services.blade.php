<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Services - {{ config('app.name', 'Laravel') }}</title>

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
    <body class="bg-white text-[#1b1b18] min-h-screen" x-data="{ activeTab: 'environnement' }" style="background-color: #ffffff !important;">
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
                            <span class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: rgb(0, 0, 0); cursor: default; pointer-events: none;">
                                Blog
                            </span>
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
        <section class="relative w-full flex items-center justify-center overflow-hidden" style="min-height: 45vh; padding: 60px 0; background-color: rgb(245, 250, 248);">
            <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center" style="margin-top: 60px;">
                <h1 class="mb-6" style="font-size: 60px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 24px; text-align: center; line-height: 72px;">
                    Nos Pôles d'Activités
                </h1>
                <p class="mx-auto max-w-3xl" style="font-size: 20px; color: rgb(75, 85, 99); text-align: center; line-height: 32.5px;">
                    Quatre pôles d'intervention pour une expertise complète au service de vos projets
                </p>
            </div>
        </section>

        <!-- Tabs Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 96px 0;">
            <div class="max-w-7xl mx-auto">
                <!-- Tabs Navigation -->
                <div class="flex flex-wrap gap-4 mb-12 justify-center" role="tablist" style="margin-bottom: 48px;">
                    <button
                        @click="activeTab = 'environnement'"
                        :class="activeTab === 'environnement' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2"
                        role="tab"
                        style="padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500;"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                        Environnement et
                    </button>
                    <button
                        @click="activeTab = 'recherche'"
                        :class="activeTab === 'recherche' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2"
                        role="tab"
                        style="padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500;"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                            <path d="M2 17l10 5 10-5"></path>
                            <path d="M2 12l10 5 10-5"></path>
                        </svg>
                        Recherche Géologique
                    </button>
                    <button
                        @click="activeTab = 'geo-ingenierie'"
                        :class="activeTab === 'geo-ingenierie' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2"
                        role="tab"
                        style="padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500;"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                            <path d="M3 9h18"></path>
                            <path d="M9 21V9"></path>
                        </svg>
                        Géo-ingénierie Appliquée
                    </button>
                    <button
                        @click="activeTab = 'negoce'"
                        :class="activeTab === 'negoce' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2"
                        role="tab"
                        style="padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500;"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        Négoce et
                    </button>
                </div>

                <!-- Tab Panels -->
                <div>
                    <!-- Environnement Tab -->
                    <div x-show="activeTab === 'environnement'" x-transition role="tabpanel">
                        <div class="bg-gradient-to-br from-green-600 to-teal-600 rounded-2xl p-8 mb-8" style="background: linear-gradient(135deg, rgb(5, 150, 105) 0%, rgb(20, 184, 166) 100%); border-radius: 24px; padding: 48px;">
                            <div class="mb-6">
                                <h3 class="text-white text-3xl font-semibold mb-3" style="font-size: 30px; font-weight: 600; color: rgb(255, 255, 255); margin-bottom: 12px;">
                                    Environnement et Développement Durable
                                </h3>
                                <p class="text-white/90" style="font-size: 16px; color: rgba(255, 255, 255, 0.9);">
                                    Agréé et accrédité sous le numéro : 29/MEEDD/DIR.CAB
                                </p>
                            </div>
                            <div class="text-white space-y-6">
                                <p class="text-lg text-white" style="font-size: 18px; color: rgb(255, 255, 255); line-height: 29.25px; margin-bottom: 24px;">
                                    Au niveau régional, le CEGME travaille en symbiose avec le Bureau d'Étude Solution Environnementale Viable & Entrepreneuriat (Seve-Consulting) Sarl., installé à Lomé au TOGO. Cette coopération sud-sud renforce sa capacité à appréhender les enjeux des projets de développement en Afrique.
                                </p>
                                <p class="text-white font-semibold" style="font-size: 16px; color: rgb(255, 255, 255); line-height: 24px; font-weight: 600;">
                                    30+ évaluations environnementales validées par le Ministère en charge de l'environnement en République centrafricaine, au Togo et au Bénin.
                                </p>
                                <h4 class="text-xl font-semibold mt-8 mb-4" style="font-size: 20px; font-weight: 600; color: rgb(255, 255, 255); margin-top: 32px; margin-bottom: 16px;">
                                    Services proposés :
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px;">
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Étude d'impact environnemental et social</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Audit environnemental</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Plan d'aménagement forestier</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Étude de la faune</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Étude de dangers</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Analyse des pollutions et nuisances</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Production de supports cartographiques</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Gestion durable des déchets et assainissement</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Gestion durable de ressources naturelles et de la biodiversité</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Sensibilisation et Éducation environnementale</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-white/10 rounded-lg p-4" style="display: flex; align-items: center; gap: 12px; background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 16px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white flex-shrink-0" style="width: 24px; height: 24px; color: rgb(255, 255, 255);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                        <span class="text-white" style="font-size: 16px; color: rgb(255, 255, 255);">Formation</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Autres tabs (à compléter avec le contenu réel) -->
                    <div x-show="activeTab === 'recherche'" x-transition role="tabpanel" style="display: none;">
                        <div class="bg-gradient-to-br from-green-600 to-teal-600 rounded-2xl p-8" style="background: linear-gradient(135deg, rgb(5, 150, 105) 0%, rgb(20, 184, 166) 100%); border-radius: 24px; padding: 48px;">
                            <h3 class="text-white text-3xl font-semibold mb-4" style="font-size: 30px; font-weight: 600; color: rgb(255, 255, 255); margin-bottom: 16px;">
                                Recherche Géologique
                            </h3>
                            <p class="text-white/90" style="font-size: 16px; color: rgba(255, 255, 255, 0.9);">
                                Contenu à venir...
                            </p>
                        </div>
                    </div>

                    <div x-show="activeTab === 'geo-ingenierie'" x-transition role="tabpanel" style="display: none;">
                        <div class="bg-gradient-to-br from-green-600 to-teal-600 rounded-2xl p-8" style="background: linear-gradient(135deg, rgb(5, 150, 105) 0%, rgb(20, 184, 166) 100%); border-radius: 24px; padding: 48px;">
                            <h3 class="text-white text-3xl font-semibold mb-4" style="font-size: 30px; font-weight: 600; color: rgb(255, 255, 255); margin-bottom: 16px;">
                                Géo-ingénierie Appliquée
                            </h3>
                            <p class="text-white/90" style="font-size: 16px; color: rgba(255, 255, 255, 0.9);">
                                Contenu à venir...
                            </p>
                        </div>
                    </div>

                    <div x-show="activeTab === 'negoce'" x-transition role="tabpanel" style="display: none;">
                        <div class="bg-gradient-to-br from-green-600 to-teal-600 rounded-2xl p-8" style="background: linear-gradient(135deg, rgb(5, 150, 105) 0%, rgb(20, 184, 166) 100%); border-radius: 24px; padding: 48px;">
                            <h3 class="text-white text-3xl font-semibold mb-4" style="font-size: 30px; font-weight: 600; color: rgb(255, 255, 255); margin-bottom: 16px;">
                                Négoce et
                            </h3>
                            <p class="text-white/90" style="font-size: 16px; color: rgba(255, 255, 255, 0.9);">
                                Contenu à venir...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Détaillés Section -->
        <section class="w-full bg-gray-50 px-4 sm:px-6 lg:px-8" style="padding: 96px 0; background-color: rgb(249, 250, 251);">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12" style="margin-bottom: 48px; text-align: center;">
                    <h2 class="text-4xl font-bold mb-4" style="font-size: 36px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 16px;">
                        Services Détaillés
                    </h2>
                    <p class="text-lg text-gray-600" style="font-size: 18px; color: rgb(75, 85, 99);">
                        Un accompagnement sur-mesure pour chaque besoin
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 32px;">
                    <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Recherche géologique
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                            Travaux de reconnaissance préliminaire, levées géologiques, programme d'exploration géologique et minière
                        </p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Cartographie numérique
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                            Analyse de l'occupation des sols, analyse spatiale à base d'image satellitaire, carte de situation et plan de masse, cartes thématiques, modélisation cartographique diverse
                        </p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Évaluation économique de Projet minier
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                            De l'étude de marché et opportunité aux analyses économiques et financières, l'analyse des sensibilités, accompagnement dans l'étude de faisabilité complète d'un projet minier
                        </p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Évaluation environnementale
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                            Les cadres de gestion environnementale et sociale, les évaluations environnementales stratégiques, les études d'impact environnemental et social, les audits environnementaux et sociaux
                        </p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Monitoring HSSE
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                            Implémentation du système de management HSE - Mise en œuvre des PGES, PGR et management de la qualité
                        </p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Représentation, Conseil et Négociation
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                            Représentation d'entreprises, conseil et coaching des coopératives minières en Centrafrique, conseils aux investisseurs/entreprises, Négociation dans les transactions de vente/achat de l'or brut et du diamant
                        </p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Organisation d'événement
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                            Séminaires de formations, Atelier de formation et sensibilisation, Consultation publique, Audience publique
                        </p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Sensibilisation et Éducation environnementale
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                            Sensibilisation via la fresque climat sur les effets du changement climatique, sensibilisation citoyenne sur les Éco-gestes
                        </p>
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-md" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Formation
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                            Formation des moniteurs HSE au sein des entreprises, fondamentaux des Changements climatiques, gestion durable des ressources naturelles, les enjeux d'un aménagement territorial durable
                        </p>
                    </div>
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

