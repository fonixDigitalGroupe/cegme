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
    <body class="bg-white text-[#1b1b18] min-h-screen" x-data="{ activeFilter: 'all' }" style="background-color: #ffffff !important;">
        <header class="w-full bg-white sticky top-0 z-50" style="position: fixed; top: 0; left: 0; right: 0; width: 100%; z-index: 1000; background-color: rgb(255, 255, 255); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (Route::has('login'))
                    <nav class="py-4 flex items-center justify-between gap-4 flex-wrap">
                        <div class="flex items-center gap-4 flex-wrap" style="margin-left: -24px;">
                            <a href="/" class="flex items-center gap-3 shrink-0" style="text-decoration: none; color: inherit;">
                                <img src="{{ asset('Image/logo_cegme.png') }}" alt="CEGME Logo" class="block h-16 w-auto" style="height: 64px; width: auto; object-fit: contain;">
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
                    Nos Réalisations
                </h1>
                <p class="mx-auto max-w-3xl" style="font-size: 20px; color: rgb(75, 85, 99); text-align: center; line-height: 32px;">
                    Un retour d'expérience important en évaluation environnementale et sociale depuis<br>2011
                </p>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 48px 0;">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-row items-start justify-center gap-8 flex-wrap" style="display: flex; flex-direction: row; gap: 32px; padding: 0; margin: 0; justify-content: center; align-items: flex-start; flex-wrap: wrap;">
                    <!-- Card 1: Projets Réalisés -->
                    <div class="text-center" style="width: 284px; max-width: 100%; padding: 0; margin: 0; text-align: center; display: block;">
                        <div class="text-6xl font-bold text-teal-600 mb-3" style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); line-height: 44px; margin-bottom: 4px;">
                            30+
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2" style="font-size: 14px; font-weight: 500; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 0px;">
                            Projets Réalisés
                        </h3>
                    </div>

                    <!-- Card 2: Années d'Expérience -->
                    <div class="text-center" style="width: 284px; max-width: 100%; padding: 0; margin: 0; text-align: center; display: block;">
                        <div class="text-6xl font-bold text-teal-600 mb-3" style="font-size: 36px; font-weight: 700; color: rgb(20, 184, 166); line-height: 44px; margin-bottom: 4px;">
                            10+
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2" style="font-size: 14px; font-weight: 500; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 0px;">
                            Années d'Expérience
                        </h3>
                    </div>

                    <!-- Card 3: Pays -->
                    <div class="text-center" style="width: 284px; max-width: 100%; padding: 0; margin: 0; text-align: center; display: block;">
                        <div class="text-6xl font-bold text-teal-600 mb-3" style="font-size: 36px; font-weight: 700; color: rgb(59, 130, 246); line-height: 44px; margin-bottom: 4px;">
                            3
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2" style="font-size: 14px; font-weight: 500; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 0px;">
                            Pays (RCA, Togo, Bénin)
                        </h3>
                    </div>

                    <!-- Card 4: Projets Validés -->
                    <div class="text-center" style="width: 284px; max-width: 100%; padding: 0; margin: 0; text-align: center; display: block;">
                        <div class="text-6xl font-bold text-teal-600 mb-3" style="font-size: 36px; font-weight: 700; color: rgb(147, 51, 234); line-height: 44px; margin-bottom: 4px;">
                            100%
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2" style="font-size: 14px; font-weight: 500; color: rgb(107, 114, 128); line-height: 20px; margin-bottom: 0px;">
                            Projets Validés
                        </h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 0 0 48px 0;">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-wrap gap-4 justify-center" style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: center;">
                    <button
                        @click="activeFilter = 'all'"
                        :class="activeFilter === 'all' ? '' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        :style="activeFilter === 'all' ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255);' : ''"
                        class="px-6 py-3 rounded-lg font-medium transition-colors"
                        style="padding: 20px 40px; border-radius: 6px; font-size: 20px; font-weight: 600;"
                    >
                        Tous les projets
                    </button>
                    <button
                        @click="activeFilter = '2021'"
                        :class="activeFilter === '2021' ? '' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        :style="activeFilter === '2021' ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255);' : ''"
                        class="px-6 py-3 rounded-lg font-medium transition-colors"
                        style="padding: 20px 40px; border-radius: 6px; font-size: 20px; font-weight: 600;"
                    >
                        2021
                    </button>
                    <button
                        @click="activeFilter = '2020'"
                        :class="activeFilter === '2020' ? '' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        :style="activeFilter === '2020' ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255);' : ''"
                        class="px-6 py-3 rounded-lg font-medium transition-colors"
                        style="padding: 20px 40px; border-radius: 6px; font-size: 20px; font-weight: 600;"
                    >
                        2020
                    </button>
                    <button
                        @click="activeFilter = '2019'"
                        :class="activeFilter === '2019' ? '' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        :style="activeFilter === '2019' ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255);' : ''"
                        class="px-6 py-3 rounded-lg font-medium transition-colors"
                        style="padding: 20px 40px; border-radius: 6px; font-size: 20px; font-weight: 600;"
                    >
                        2019
                    </button>
                    <button
                        @click="activeFilter = '2018'"
                        :class="activeFilter === '2018' ? '' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        :style="activeFilter === '2018' ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255);' : ''"
                        class="px-6 py-3 rounded-lg font-medium transition-colors"
                        style="padding: 20px 40px; border-radius: 6px; font-size: 20px; font-weight: 600;"
                    >
                        2018
                    </button>
                    <button
                        @click="activeFilter = '2017'"
                        :class="activeFilter === '2017' ? '' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        :style="activeFilter === '2017' ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255);' : ''"
                        class="px-6 py-3 rounded-lg font-medium transition-colors"
                        style="padding: 20px 40px; border-radius: 6px; font-size: 20px; font-weight: 600;"
                    >
                        2017
                    </button>
                    <button
                        @click="activeFilter = '2016'"
                        :class="activeFilter === '2016' ? '' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        :style="activeFilter === '2016' ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255);' : ''"
                        class="px-6 py-3 rounded-lg font-medium transition-colors"
                        style="padding: 20px 40px; border-radius: 6px; font-size: 20px; font-weight: 600;"
                    >
                        2016
                    </button>
                    <button
                        @click="activeFilter = '2011'"
                        :class="activeFilter === '2011' ? '' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        :style="activeFilter === '2011' ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255);' : ''"
                        class="px-6 py-3 rounded-lg font-medium transition-colors"
                        style="padding: 20px 40px; border-radius: 6px; font-size: 20px; font-weight: 600;"
                    >
                        2011
                    </button>
                </div>
            </div>
        </section>

        <!-- Divider -->
        <div style="width: 100%; height: 1px; background-color: rgb(229, 231, 235); margin: 0;"></div>

        <!-- Projects Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 0 0 96px 0; background-color: rgb(249, 250, 251);">
            <div class="max-w-5xl mx-auto">
                <!-- 2021 Projects -->
                <div x-show="activeFilter === 'all' || activeFilter === '2021'" x-transition>
                    <div style="position: relative; max-width: 600px; margin: 0 auto;">
                        <!-- Titre année -->
                        <div style="margin-bottom: 48px;">
                            <h2 class="text-3xl font-bold mb-4" style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); margin-bottom: 24px;">
                        2021
                    </h2>
                        </div>
                        
                        <!-- Projects wrapper -->
                        <div style="position: relative;">
                            
                        <!-- Project 1 -->
                        <div style="position: relative; margin-bottom: 48px;" class="timeline-project">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(209, 250, 229); padding: 10px 16px; border-radius: 8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 16px; font-weight: 600; color: rgb(17, 24, 39);">Février</span>
                            </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                    Trois stations-services Bangui
                                </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                    Etude d'Impact Environnemental et Social du projet de la construction et de l'exploitation de trois stations-services et d'un immeuble servant de siège (Site Marabena, Site Miskine et Site Pk12) dans la ville de Bangui
                                </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project 2 -->
                        <div style="position: relative; margin-bottom: 48px;">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Mai-Juillet</span>
                            </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                    Mécanisation activités minières
                                </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                    Etude d'Impact Environnemental et Social des activités de mécanisation des activités minières dans les zones d'interventions Nola, Boganangone (en cours)
                                </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project 3 -->
                        <div style="position: relative; margin-bottom: 48px;" class="timeline-project">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 8px; background-color: rgb(209, 250, 229); padding: 10px 16px; border-radius: 8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 16px; font-weight: 600; color: rgb(17, 24, 39);">Juillet</span>
                            </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                    Complexe immobilier BDEAC
                                </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                    Etude d'Impact Environnemental et Social du projet de la construction et de l'exploitation d'un complexe immobilier à usage administratif et résidentiel au centre-ville dans l'enceinte de son agence centrale sur financement de la Banque de Développement des États d'Afrique Central (BDEAC)
                                </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project 4 -->
                        <div style="position: relative; margin-bottom: 48px;">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Octobre</span>
                            </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                    Parc agro-industriel Lessé
                                </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                    Diagnostic socio-économique Exploitation du parc agro-industriel de transformation d'huile de palme brute dans la commune de Lessé
                                </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- 2020 Projects -->
                <div x-show="activeFilter === 'all' || activeFilter === '2020'" x-transition>
                    <div style="position: relative;  max-width: 600px; margin: 0 auto;">
                        <!-- Titre année -->
                        <div style="margin-bottom: 48px;">
                            <h2 class="text-3xl font-bold mb-4" style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); margin-bottom: 24px;">
                        2020
                    </h2>
                        </div>
                        
                        <!-- Projects wrapper -->
                        <div style="position: relative;">
                            
                        <!-- Project 1 -->
                        <div style="position: relative; margin-bottom: 48px;" class="timeline-project">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Janvier</span>
                            </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                    Audit huilerie et savonnerie
                                </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                    Audit environnemental et social des unités de l'huilerie et de la savonnerie à son siège de Bangui
                                </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project 2 -->
                        <div style="position: relative; margin-bottom: 48px;">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Février</span>
                            </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                    Dépotoir privé Samba 1
                                </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                    Étude d'Impact Environnemental et social du projet d'installation d'un dépotoir privé d'excrément et des ordures au village Samba 1 dans la commune de Bimbo
                                </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project 3 -->
                        <div style="position: relative; margin-bottom: 48px;">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Mai</span>
                            </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                    City Apartment Bangui
                                </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                    Étude d'Impact Environnemental et Social (EIES) du projet de la construction et de l'exploitation d'un complexe immobilier à usage administratif et d'appartement (City Apartment) à Bangui
                                </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- 2019 Projects -->
                <div x-show="activeFilter === 'all' || activeFilter === '2019'" x-transition>
                    <div style="position: relative;  max-width: 600px; margin: 0 auto;">
                        <!-- Titre année aligné avec timeline -->
                        <div style="margin-bottom: 48px; position: relative;">
                            <h2 class="text-3xl font-bold mb-4" style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); margin-bottom: 0; display: inline-block; position: absolute;  top: 0;">
                        2019
                    </h2>
                            <div style="display: inline-block; width: 150px; height: 2px; background-color: rgb(209, 250, 229); margin-left: 16px; vertical-align: middle; margin-top: 18px;"></div>
                        </div>
                        
                        <!-- Projects wrapper for timeline -->
                        <div style="position: relative;">
                            
                        <!-- Project 1 -->
                        <div style="position: relative; margin-bottom: 48px;" class="timeline-project">
                            <!-- Carte projet -->
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative;">
                                <!-- Icône document en haut à droite -->
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Février</span>
                                </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                        Mine d'or alluvionnaire Bossangoa
                                    </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                        Étude d'impact environnemental et social sommaire du projet de la mise en exploitation des sites pilotes d'une mine d'or alluvionnaire dans la sous-préfecture de Bossangoa
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project 2 -->
                        <div style="position: relative; margin-bottom: 48px;">
                            <!-- Marqueur timeline -->
                            
                            <!-- Carte projet -->
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative;">
                                <!-- Icône document en haut à droite -->
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Septembre</span>
                                </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                        Exploitation semi-mécanisée rivière Sangha
                                    </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                        Étude d'Impact Environnemental et Social du projet de l'exploitation semi-mécanisée (à l'aide des barges à godets) d'or et de diamant sur le lit vif de la rivière Sangha en République Centrafricaine
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- 2018 Projects -->
                <div x-show="activeFilter === 'all' || activeFilter === '2018'" x-transition>
                    <div style="position: relative;  max-width: 600px; margin: 0 auto;">
                        <!-- Titre année aligné avec timeline -->
                        <div style="margin-bottom: 48px; position: relative;">
                            <h2 class="text-3xl font-bold mb-4" style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); margin-bottom: 0; display: inline-block; position: absolute;  top: 0;">
                                2018
                            </h2>
                            <div style="display: inline-block; width: 150px; height: 2px; background-color: rgb(209, 250, 229); margin-left: 16px; vertical-align: middle; margin-top: 18px;"></div>
                        </div>
                        
                        <!-- Projects wrapper for timeline -->
                        <div style="position: relative;" class="projects-timeline-wrapper">
                            
                        <!-- Project 1 -->
                        <div style="position: relative; margin-bottom: 48px;" class="timeline-project">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Octobre</span>
                                </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                        Mine d'or alluvionnaire Gaga Yaloké
                                    </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                        Étude d'Impact Environnemental et social sommaire du projet d'exploitation d'une zone pilote d'or alluvionnaire dans la région de Gaga Yaloké en RCA
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- 2017 Projects -->
                <div x-show="activeFilter === 'all' || activeFilter === '2017'" x-transition>
                    <div style="position: relative;  max-width: 600px; margin: 0 auto;">
                        <!-- Titre année aligné avec timeline -->
                        <div style="margin-bottom: 48px; position: relative;">
                            <h2 class="text-3xl font-bold mb-4" style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); margin-bottom: 0; display: inline-block; position: absolute;  top: 0;">
                                2017
                            </h2>
                            <div style="display: inline-block; width: 150px; height: 2px; background-color: rgb(209, 250, 229); margin-left: 16px; vertical-align: middle; margin-top: 18px;"></div>
                        </div>
                        
                        <!-- Projects wrapper for timeline -->
                        <div style="position: relative;">
                        
                        <!-- Project 1 -->
                        <div style="position: relative; margin-bottom: 48px;">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Mai</span>
                                </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                        Audit de clôture exploration pétrolière
                                    </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                        Audit environnemental et social interne pour la clôture des activités d'exploration pétrolière par méthode sismique 2D
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project 2 -->
                        <div style="position: relative; margin-bottom: 48px;">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Octobre</span>
                                </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                        EIES Centrale hydroélectrique Lobaye
                                    </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                        Étude d'Impact Environnemental et Social Approfondie du projet de la construction de la centrale hydroélectrique sur la rivière Lobaye (sites de Bac & Lotémo)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project 3 -->
                        <div style="position: relative; margin-bottom: 48px;">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Novembre</span>
                                </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                        Plan de Réinstallation Lobaye
                                    </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                        Plan d'Action de Réinstallation des populations affectées par le projet de la construction de la centrale hydroélectrique sur la rivière Lobaye (sites de Bac & Lotémo)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Project 4 -->
                        <div style="position: relative; margin-bottom: 48px;">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Décembre</span>
                                </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                        Exploration sismique permis C et manuel HSE
                                    </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                        Étude d'Impact Environnemental et social du projet d'exploration sismique 2D, d'échantillonnage géochimique et de levé aéroporté gravimétrique haute résolution sur le permis C au sud-ouest de la RCA • Conception du manuel de procédure HSE de DIG OIL Centrafrique SA
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- 2016 Projects -->
                <div x-show="activeFilter === 'all' || activeFilter === '2016'" x-transition>
                    <div style="position: relative;  max-width: 600px; margin: 0 auto;">
                        <!-- Titre année aligné avec timeline -->
                        <div style="margin-bottom: 48px; position: relative;">
                            <h2 class="text-3xl font-bold mb-4" style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); margin-bottom: 0; display: inline-block; position: absolute;  top: 0;">
                                2016
                            </h2>
                            <div style="display: inline-block; width: 150px; height: 2px; background-color: rgb(209, 250, 229); margin-left: 16px; vertical-align: middle; margin-top: 18px;"></div>
                        </div>
                        
                        <!-- Projects wrapper for timeline -->
                        <div style="position: relative;" class="projects-timeline-wrapper">
                            
                        <!-- Project 1 -->
                        <div style="position: relative; margin-bottom: 48px;" class="timeline-project">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div style="position: absolute; top: 20px; left: 20px; display: inline-flex; align-items: center; gap: 6px; background-color: rgb(209, 250, 229); padding: 6px 12px; border-radius: 8px; ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span style="font-size: 14px; font-weight: 500; color: rgb(17, 24, 39);">Mai</span>
                                </div>
                                <div class="p-6" style="padding: 24px; padding-top: 60px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                        Exploration sismique et manuels HSE
                                    </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                        Étude d'Impact Environnemental et Social du projet d'exploration sismique 2D • Conception du manuel de procédure HSE PTIAL • Conception du manuel de procédure HSE PTI-IAS
                                    </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- 2011 Projects -->
                <div x-show="activeFilter === 'all' || activeFilter === '2011'" x-transition>
                    <div style="position: relative;  max-width: 600px; margin: 0 auto;">
                        <!-- Titre année aligné avec timeline -->
                        <div style="margin-bottom: 48px; position: relative;">
                            <h2 class="text-3xl font-bold mb-4" style="font-size: 36px; font-weight: 700; color: rgb(5, 150, 105); margin-bottom: 0; display: inline-block; position: absolute;  top: 0;">
                                2011
                            </h2>
                            <div style="display: inline-block; width: 150px; height: 2px; background-color: rgb(209, 250, 229); margin-left: 16px; vertical-align: middle; margin-top: 18px;"></div>
                        </div>
                        
                        <!-- Projects wrapper for timeline -->
                        <div style="position: relative;" class="projects-timeline-wrapper">
                            
                        <!-- Project 1 -->
                        <div style="position: relative; margin-bottom: 48px;" class="timeline-project">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 16px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.1) 0px 2px 4px -1px; position: relative; width: 100%;">
                                <div style="position: absolute; top: 20px; right: 20px; width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                            </div>
                            <div class="p-6" style="padding: 24px;">
                                    <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; margin-top: 0;">
                                        Études de terrain
                                </h3>
                                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin: 0;">
                                        Contribution aux études thématiques de l'Étude d'Impact du gisement d'uranium de Bakouma – RCA
                                </p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="w-full px-4 sm:px-6 lg:px-8" style="padding: 80px 0; margin: 0; background: linear-gradient(180deg, rgb(15, 64, 62) 0%, rgb(22, 78, 75) 50%, rgb(25, 85, 82) 100%);">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl font-bold text-white mb-4" style="font-size: 40px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 16px; text-align: center;">
                    Prêt à Démarrer Votre Projet ?
                </h2>
                <p class="text-xl text-white mb-8" style="font-size: 20px; color: rgb(255, 255, 255); margin-bottom: 32px; text-align: center; line-height: 30px;">
                    Bénéficiez de notre expertise et de notre expérience pour mener à bien vos projets
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
                            <img src="{{ asset('Image/logo_cegme.png') }}" alt="CEGME Logo" class="block h-10 w-auto" style="height: 40px; width: auto; object-fit: contain;">
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

