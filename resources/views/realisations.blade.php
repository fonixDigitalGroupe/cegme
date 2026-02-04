<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Nos réalisations - Projets et Études Stratégiques | CEGME</title>
    <meta name="description"
        content="Consultez nos réalisations : plus de 70 missions stratégiques en Afrique. Audits E&S, études géologiques et projets d'adduction d'eau en République Centrafricaine.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Nos réalisations - Projets et Études Stratégiques | CEGME">
    <meta property="og:description"
        content="Plus de 70 missions stratégiques réalisées à travers l'Afrique depuis 2011 par le cabinet CEGME.">
    <meta property="og:image" content="{{ asset('Image/CEGME Logo.png') }}">

    <link rel="icon" href="{{ asset('Image/CEGME favicon.JPG') }}" type="image/png">

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
    </style>
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
    <x-site-header />

    <!-- Hero Section - Page Header -->
    <section class="relative w-full flex items-center justify-center overflow-hidden realisations-hero-section"
        style="min-height: 30vh; padding: 40px 0; background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42));">
        <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center realisations-hero-content"
            style="margin-top: 60px;">
            <h1 class="mb-6"
                style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                Nos réalisations
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
            <div class="mb-8" style="margin-bottom: 32px; padding: 0;">
                <div class="flex flex-col gap-8">
                    <!-- Row 1: Secteurs -->
                    <div class="flex flex-col md:flex-row md:items-center gap-6">
                        <div class="flex items-center gap-3 min-w-[180px]">
                            <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                </svg>
                            </div>
                            <span style="font-size: 16px; font-weight: 700; color: #1f2937;">Filtrer par secteur
                                :</span>
                        </div>
                        <select x-model="activeSector"
                            class="w-full md:w-auto px-4 py-2 rounded-lg font-medium transition-all duration-200 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500/20 focus:border-green-500"
                            style="padding: 12px 20px; border-radius: 8px; font-size: 15px; font-weight: 500; background-color: rgb(255, 255, 255); color: rgb(55, 65, 81); border: 1.5px solid #e5e7eb; cursor: pointer; min-width: 300px;">
                            <option value="all">Tous les secteurs d'activité</option>
                            <option value="eau-humanitaire">Eau, Humanitaire et Développement Rural</option>
                            <option value="conservation-environnement">Conservation et Environnement</option>
                            <option value="infrastructures-urbanisme-btp">Infrastructures, Urbanisme et BTP</option>
                            <option value="mines-energie-hydrocarbures">Mines, Énergie et Hydrocarbures</option>
                            <option value="agro-industrie-services">Agro-Industrie et Services</option>
                        </select>
                    </div>

                    <!-- Separator line for desktop -->
                    <div class="hidden md:block h-px bg-gray-100" style="height: 1px; background-color: #f3f4f6;"></div>

                    <!-- Row 2: Années -->
                    <div class="flex flex-col md:flex-row md:items-center gap-6">
                        <div class="flex items-center gap-3 min-w-[180px]">
                            <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(5, 150, 105)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <span style="font-size: 16px; font-weight: 700; color: #1f2937;">Filtrer par année :</span>
                        </div>
                        <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-hide"
                            style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <button @click="activeYear = 'all'"
                                :class="activeYear === 'all' ? 'bg-green-600 text-white shadow-lg shadow-green-900/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                class="px-5 py-2.5 rounded-lg font-bold transition-all duration-200 flex-shrink-0"
                                style="padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                                Tous
                            </button>
                            @foreach(['2025', '2024', '2022', '2021', '2020', '2019', '2018', '2017', '2016', '2011'] as $year)
                                <button @click="activeYear = '{{ $year }}'"
                                    :class="activeYear === '{{ $year }}' ? 'bg-green-600 text-white shadow-lg shadow-green-900/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                    class="px-5 py-2.5 rounded-lg font-bold transition-all duration-200 flex-shrink-0"
                                    style="padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 700; cursor: pointer; border: none; white-space: nowrap;">
                                    {{ $year }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grille de projets -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 realisations-projects-grid"
                style="display: grid; gap: 32px; padding: 0; align-items: stretch;">
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
                <div x-show="matchesFilter('agro-industrie-services', '2025')" style="position: relative;"
                    data-sector="agro-industrie-services" data-year="2025">
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
                <div x-show="matchesFilter('agro-industrie-services', '2025')" style="position: relative;"
                    data-sector="agro-industrie-services" data-year="2025">
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

                <!-- Project 3: Audit E&S et EIES - Complexe industriel Palme d'or -->
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
                                Audit E&S et EIES - Complexe industriel Palme d'or
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
                <!-- Project 1: EIES - Projet de réduction de la vulnérabilité climatique -->
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
                                EIES - Projet de réduction de la vulnérabilité climatique
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
                                PGRN / Banque mondiale
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
                                Financement : Banque mondiale
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
                <div x-show="matchesFilter('conservation-environnement', '2020')" style="position: relative;"
                    data-sector="conservation-environnement" data-year="2020">
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
                <div x-show="matchesFilter('infrastructures-urbanisme-btp', '2020')" style="position: relative;"
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

                <!-- Project: Plan de réinstallation Lobaye (2017, Novembre) -->
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
                                Plan de réinstallation Lobaye
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


</body>

</html>