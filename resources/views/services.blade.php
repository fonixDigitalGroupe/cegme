<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Services - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('Image/CEGME favicon.JPG') }}" type="image/png">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.site-styles')

    <style>
        .pole-contact-button {
            background-color: transparent !important;
            color: #374151 !important;
            border-radius: 0px !important;
            padding: 10px 24px !important;
            font-weight: 600 !important;
            border: 1.5px solid #d1d5db !important;
            transition: all 0.2s ease !important;
            box-shadow: none !important;
        }

        .pole-contact-button:hover {
            background-color: #f3f4f6 !important;
            border-color: #9ca3af !important;
            transform: translateY(-1px) !important;
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
        activeTab: 'environnement',
        setTabFromHash() {
            const raw = (window.location.hash || '').replace('#', '').trim();
            if (!raw) return;
            const allowed = ['environnement', 'recherche', 'geo-ingenierie', 'negoce'];
            if (allowed.includes(raw)) this.activeTab = raw;
        },
        init() {
            this.setTabFromHash();
            window.addEventListener('hashchange', () => this.setTabFromHash());
        }
    }" style="background-color: #ffffff !important;">
    <x-site-header />

    <!-- Hero Section - Page Header -->
    <section class="relative w-full flex items-center justify-center overflow-hidden services-hero-section"
        style="min-height: 30vh; padding: 40px 0; background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42));">
        <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center services-hero-content"
            style="margin-top: 60px;">
            <h1 class="mb-6"
                style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                Nos Pôles d'Activités
            </h1>
            <p class="mx-auto max-w-3xl"
                style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                Quatre pôles d'intervention pour une expertise complète au service de vos projets
            </p>
        </div>
    </section>

    <!-- Tabs Section -->
    <section class="w-full px-4 sm:px-6 lg:px-8" style="padding: 96px 0; background-color: rgb(255, 255, 255);">
        <div class="max-w-7xl mx-auto">
            <!-- Tabs Navigation -->
            <div class="flex flex-wrap gap-4 mb-12 justify-center" role="tablist" style="margin-bottom: 48px;">
                <button @click="activeTab = 'environnement'"
                    :class="activeTab === 'environnement' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                    :style="activeTab === 'environnement' ? 'padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500; background-color: rgb(5, 150, 105); border: none;' : 'padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500; background-color: rgb(255, 255, 255); border: 1px solid rgb(209, 213, 219);'"
                    class="px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2" role="tab">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path
                            d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                        </path>
                    </svg>
                    Environnement
                </button>
                <button @click="activeTab = 'recherche'"
                    :class="activeTab === 'recherche' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                    :style="activeTab === 'recherche' ? 'padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500; background-color: rgb(5, 150, 105); border: none;' : 'padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500; background-color: rgb(255, 255, 255); border: 1px solid rgb(209, 213, 219);'"
                    class="px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2" role="tab">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                        <path d="M2 17l10 5 10-5"></path>
                        <path d="M2 12l10 5 10-5"></path>
                    </svg>
                    Géologie
                </button>
                <button @click="activeTab = 'geo-ingenierie'"
                    :class="activeTab === 'geo-ingenierie' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                    :style="activeTab === 'geo-ingenierie' ? 'padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500; background-color: rgb(5, 150, 105); border: none;' : 'padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500; background-color: rgb(255, 255, 255); border: 1px solid rgb(209, 213, 219);'"
                    class="px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2" role="tab">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                        <path d="M3 9h18"></path>
                        <path d="M9 21V9"></path>
                    </svg>
                    Géo-ingénierie
                </button>
                <button @click="activeTab = 'negoce'"
                    :class="activeTab === 'negoce' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                    :style="activeTab === 'negoce' ? 'padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500; background-color: rgb(5, 150, 105); border: none;' : 'padding: 12px 24px; border-radius: 8px; font-size: 16px; font-weight: 500; background-color: rgb(255, 255, 255); border: 1px solid rgb(209, 213, 219);'"
                    class="px-6 py-3 rounded-lg font-medium transition-colors flex items-center gap-2" role="tab">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Conseil
                </button>
            </div>

            <!-- Tab Panels -->
            <div>
                <!-- Environnement Tab -->
                <div x-show="activeTab === 'environnement'" x-transition role="tabpanel">
                    <!-- Carte d'en-tête avec fond vert clair -->
                    <div class="bg-emerald-50 rounded-2xl p-8 mb-8 border border-gray-100"
                        style="background-color: rgb(236, 253, 245); border-radius: 16px; padding: 32px; margin-bottom: 32px; border: 1px solid rgb(243, 244, 246); box-shadow: none;">
                        <div class="flex flex-col md:flex-row md:items-center gap-6 pole-header-flex"
                            style="display: flex; flex-direction: row; align-items: center; gap: 24px;">
                            <!-- Icône -->
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shadow-lg flex-shrink-0"
                                style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, rgb(34, 197, 94) 0%, rgb(22, 163, 74) 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(34, 197, 94, 0.35); flex-shrink: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path
                                        d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                    </path>
                                </svg>
                            </div>
                            <!-- Titre et description -->
                            <div style="flex: 1;">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2"
                                    style="font-size: 24px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px;">
                                    Environnement & Développement Durable
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Agréé et accrédité sous le numéro : 29/MEEDD/DIR.CAB
                                </p>
                            </div>
                            <!-- Bouton -->
                            <a href="/contact" class="md:ml-auto pole-contact-link"
                                style="margin-left: auto; display: block; text-decoration: none;">
                                <button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors pole-contact-button"
                                    style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; white-space: nowrap; border-radius: 6px; font-size: 14px; font-weight: 500; padding: 8px 16px; background-color: transparent; color: rgb(27, 77, 62); border: 1px solid rgb(27, 77, 62); cursor: pointer;">
                                    <span>Nous contacter</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- Contenu principal -->
                    <div class="space-y-6 mb-8 rounded-lg p-8"
                        style="margin-bottom: 32px; background-color: rgb(249, 250, 251); border-radius: 8px; padding: 32px;">
                        <p class="text-lg text-gray-700"
                            style="font-size: 18px; color: rgb(55, 65, 81); line-height: 29.25px; margin-bottom: 24px;">
                            Au niveau régional, le CEGME travaille en symbiose avec le Bureau d'Étude Solution
                            Environnementale Viable & Entrepreneuriat (Seve-Consulting) Sarl., installé à Lomé au TOGO.
                            Cette coopération sud-sud renforce sa capacité à appréhender les enjeux des projets de
                            développement en Afrique.
                        </p>
                        <p class="text-gray-700 font-semibold"
                            style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px; font-weight: 600;">
                            30+ évaluations environnementales validées par le Ministère en charge de l'environnement en
                            République centrafricaine, au Togo et au Bénin.
                        </p>
                        <h4 class="text-xl font-semibold mt-8 mb-4"
                            style="font-size: 20px; font-weight: 600; color: rgb(17, 24, 39); margin-top: 32px; margin-bottom: 16px;">
                            Services proposés :
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 services-proposes-grid"
                            style="display: grid; gap: 24px;">
                            <!-- Service 1: EIES -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" x2="8" y1="13" y2="13"></line>
                                            <line x1="16" x2="8" y1="17" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    EIES - Études d'Impact Environnemental et Social
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Évaluations complètes conformes aux exigences nationales et standards internationaux
                                    (IFC, Banque Mondiale, BAD)
                                </p>
                            </div>

                            <!-- Service 2: Audits -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Audits environnementaux et sociaux
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Diagnostics de conformité et audits de performance environnementale et sociale
                                </p>
                            </div>

                            <!-- Service 3: PGES -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                            <path d="M3 9h18"></path>
                                            <path d="M9 21V9"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    PGES et outils de sauvegardes
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Conception de Plans de Gestion Environnementale et Sociale, CGESC, PEPP, MGG, PPA,
                                    PGMO
                                </p>
                            </div>

                            <!-- Service 4: Biodiversité -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path
                                                d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z">
                                            </path>
                                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Biodiversité et conservation
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Évaluation de la faune et de la biodiversité, aménagement forestier
                                </p>
                            </div>

                            <!-- Service 5: Gestion des déchets -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M3 9h18"></path>
                                            <path d="M5 9V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2"></path>
                                            <path d="M5 9v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9"></path>
                                            <path d="M9 9v10"></path>
                                            <path d="M15 9v10"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Gestion des déchets et assainissement
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Solutions durables pour la gestion des déchets et l'assainissement
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recherche Géologique Tab -->
                <div x-show="activeTab === 'recherche'" x-transition role="tabpanel">
                    <!-- Carte d'en-tête avec fond beige clair -->
                    <div class="bg-amber-50 rounded-2xl p-8 mb-8 border border-gray-100"
                        style="background-color: rgb(255, 251, 235); border-radius: 16px; padding: 32px; margin-bottom: 32px; border: 1px solid rgb(243, 244, 246); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
                        <div class="flex flex-col md:flex-row md:items-center gap-6 pole-header-flex"
                            style="display: flex; flex-direction: row; align-items: center; gap: 24px;">
                            <!-- Icône -->
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-400 flex items-center justify-center shadow-lg flex-shrink-0"
                                style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(to top, rgb(249, 115, 22) 0%, rgb(251, 146, 60) 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(249, 115, 22, 0.35); flex-shrink: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <path d="M3 20h6l2-6 4 6h8l-3-8-3-4-2 4-2-2z"></path>
                                </svg>
                            </div>
                            <!-- Titre et description -->
                            <div style="flex: 1;">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2"
                                    style="font-size: 24px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px;">
                                    Géologie & Mines
                                </h3>
                                <p class="text-gray-700"
                                    style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px;">
                                    Maximiser le potentiel économique de vos actifs miniers
                                </p>
                            </div>
                            <!-- Bouton -->
                            <a href="/contact" class="md:ml-auto pole-contact-link"
                                style="margin-left: auto; display: block; text-decoration: none;">
                                <button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors pole-contact-button"
                                    style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; white-space: nowrap; border-radius: 6px; font-size: 14px; font-weight: 500; padding: 8px 16px; background-color: transparent; color: rgb(27, 77, 62); border: 1px solid rgb(27, 77, 62); cursor: pointer;">
                                    <span>Nous contacter</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- Contenu principal -->
                    <div class="space-y-6 mb-8 rounded-lg p-8"
                        style="margin-bottom: 32px; background-color: rgb(249, 250, 251); border-radius: 8px; padding: 32px;">
                        <p class="text-lg text-gray-700 mb-6"
                            style="font-size: 18px; color: rgb(55, 65, 81); line-height: 29.25px; margin-bottom: 24px;">
                            Face à l'importante potentialité en ressources géologiques et minières inexplorées en
                            Afrique centrale, particulièrement en Centrafrique, le CEGME propose ses services. Il
                            travaille en étroite collaboration avec le Ministère des Mines et de la Géologie, les
                            sociétés minières et pétrolières installées en RCA.
                        </p>
                        <p class="text-gray-700 font-semibold mb-8"
                            style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px; font-weight: 600; margin-bottom: 32px;">
                            Une dizaine d'études de marchés et de faisabilités technico-économiques validées par le
                            Ministère en charge des Mines de la République centrafricaine.
                        </p>
                        <h4 class="text-xl font-semibold mt-8 mb-4"
                            style="font-size: 20px; font-weight: 600; color: rgb(17, 24, 39); margin-top: 32px; margin-bottom: 16px;">
                            Services proposés :
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 services-proposes-grid"
                            style="display: grid; gap: 24px;">
                            <!-- Service 1: Exploration géologique -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                            <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                            <path d="M4 22h16"></path>
                                            <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                            <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22">
                                            </path>
                                            <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Exploration géologique
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Levés géologiques, échantillonnage, prospection et reconnaissance terrain
                                </p>
                            </div>

                            <!-- Service 2: Cartographie géologique et SIG -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M3 3v18h18"></path>
                                            <path d="M7 16l4-4 4 4 6-6"></path>
                                            <path d="M7 11l5 5 6-6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Cartographie géologique et SIG
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Cartographie numérique haute précision et systèmes d'information géographique
                                </p>
                            </div>

                            <!-- Service 3: Études de faisabilité -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" x2="8" y1="13" y2="13"></line>
                                            <line x1="16" x2="8" y1="17" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Études de faisabilité
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Études technico-économiques pour évaluer la viabilité de vos projets miniers
                                </p>
                            </div>

                            <!-- Service 4: Estimation des réserves -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <line x1="12" x2="12" y1="2" y2="22"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Estimation des réserves
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Évaluation des ressources et réserves selon les normes internationales
                                </p>
                            </div>

                            <!-- Service 5: Encadrement EMAPE -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Encadrement EMAPE
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Formation et accompagnement des coopératives d'exploitation minière artisanale
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Géo-ingénierie Appliquée Tab -->
                <div x-show="activeTab === 'geo-ingenierie'" x-transition role="tabpanel">
                    <!-- Carte d'en-tête avec fond bleu clair -->
                    <div class="bg-blue-50 rounded-2xl p-8 mb-8 border border-gray-100"
                        style="background-color: rgb(239, 246, 255); border-radius: 16px; padding: 32px; margin-bottom: 32px; border: 1px solid rgb(243, 244, 246); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
                        <div class="flex flex-col md:flex-row md:items-center gap-6 pole-header-flex"
                            style="display: flex; flex-direction: row; align-items: center; gap: 24px;">
                            <!-- Icône -->
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-400 flex items-center justify-center shadow-lg flex-shrink-0"
                                style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(to bottom, rgb(59, 130, 246) 0%, rgb(96, 165, 250) 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35); flex-shrink: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
                                    <path d="M9 8a3 3 0 0 1 6 0c0 1.5-3 4-3 4s-3-2.5-3-4z"></path>
                                    <path d="M7 14a3 3 0 0 1 6 0c0 1.5-3 4-3 4s-3-2.5-3-4z"></path>
                                    <path d="M11 18a2 2 0 0 1 2 0c0 1-2 2.5-2 2.5s-2-1.5-2-2.5z"></path>
                                </svg>
                            </div>
                            <!-- Titre et description -->
                            <div style="flex: 1;">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2"
                                    style="font-size: 24px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px;">
                                    Géo-ingénierie Appliquée
                                </h3>
                                <p class="text-gray-700"
                                    style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px;">
                                    Déploiement d'outils technologiques de terrain
                                </p>
                            </div>
                            <!-- Bouton -->
                            <a href="/contact" class="md:ml-auto pole-contact-link"
                                style="margin-left: auto; display: block; text-decoration: none;">
                                <button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors pole-contact-button"
                                    style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; white-space: nowrap; border-radius: 6px; font-size: 14px; font-weight: 500; padding: 8px 16px; background-color: transparent; color: rgb(27, 77, 62); border: 1px solid rgb(27, 77, 62); cursor: pointer;">
                                    <span>Nous contacter</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- Contenu principal -->
                    <div class="space-y-6 mb-8 rounded-lg p-8"
                        style="margin-bottom: 32px; background-color: rgb(249, 250, 251); border-radius: 8px; padding: 32px;">
                        <p class="text-lg text-gray-700 mb-6"
                            style="font-size: 18px; color: rgb(55, 65, 81); line-height: 29.25px; margin-bottom: 24px;">
                            Le CEGME a conclu des partenariats stratégiques et techniques pour renforcer ses
                            prestations.
                        </p>
                        <div class="mb-8" style="margin-bottom: 32px;">
                            <h4 class="text-xl font-semibold mb-4"
                                style="font-size: 20px; font-weight: 600; color: rgb(17, 24, 39); margin-bottom: 16px;">
                                Partenariats stratégiques :
                            </h4>
                            <div class="space-y-4" style="margin-bottom: 16px;">
                                <div>
                                    <p class="text-gray-700 font-semibold mb-2"
                                        style="font-size: 16px; color: rgb(55, 65, 81); font-weight: 600; margin-bottom: 8px;">
                                        National
                                    </p>
                                    <p class="text-gray-700 mb-1"
                                        style="font-size: 16px; color: rgb(55, 65, 81); margin-bottom: 4px;">
                                        <strong>Géomatiques Consulting Services (GCS)</strong>
                                    </p>
                                    <p class="text-gray-600"
                                        style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                        Appui dans les SIG et la cartographie. GCS a développé depuis plusieurs années
                                        une base de données sur la République Centrafricaine.
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-700 font-semibold mb-2"
                                        style="font-size: 16px; color: rgb(55, 65, 81); font-weight: 600; margin-bottom: 8px;">
                                        International
                                    </p>
                                    <p class="text-gray-700 mb-1"
                                        style="font-size: 16px; color: rgb(55, 65, 81); margin-bottom: 4px;">
                                        <strong>SDGM - Shandong Institute of Geophysical and Geochemical
                                            Exploration</strong>
                                    </p>
                                    <p class="text-gray-600"
                                        style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                        Institution de recherche scientifique chinoise fondée en 1958, leader en
                                        exploration géophysique et géochimique dans la province de Shandong. Située au
                                        56th, Lishan Rd, Jingnan city, Shandong province, China.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-xl font-semibold mt-8 mb-4"
                            style="font-size: 20px; font-weight: 600; color: rgb(17, 24, 39); margin-top: 32px; margin-bottom: 16px;">
                            Services proposés :
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 services-proposes-grid"
                            style="display: grid; gap: 24px;">
                            <!-- Service 1: Études hydrogéologiques -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
                                            <path d="M12 2.69v6.62"></path>
                                            <path d="M12 9.31v6.62"></path>
                                            <path d="M12 15.93v6.62"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Études hydrogéologiques
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Recherche d'eau souterraine, caractérisation des aquifères
                                </p>
                            </div>

                            <!-- Service 2: Accès à l'eau -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
                                            <path d="M12 2.69v6.62"></path>
                                            <path d="M12 9.31v6.62"></path>
                                            <path d="M12 15.93v6.62"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Accès à l'eau
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Conception et suivi de projets d'adduction d'eau et forages
                                </p>
                            </div>

                            <!-- Service 3: Études géotechniques -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                            <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                            <path d="M4 22h16"></path>
                                            <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                            <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22">
                                            </path>
                                            <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Études géotechniques
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Sondages géotechniques et études de sol pour infrastructures
                                </p>
                            </div>

                            <!-- Service 4: Prévention des risques -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Prévention des risques
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Détection d'anomalies, prévention des catastrophes géologiques
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Conseil Tab -->
                <div x-show="activeTab === 'negoce'" x-transition role="tabpanel">
                    <!-- Carte d'en-tête avec fond violet clair -->
                    <div class="bg-purple-50 rounded-2xl p-8 mb-8 border border-gray-100"
                        style="background-color: rgb(250, 245, 255); border-radius: 16px; padding: 32px; margin-bottom: 32px; border: 1px solid rgb(243, 244, 246); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
                        <div class="flex flex-col md:flex-row md:items-center gap-6 pole-header-flex"
                            style="display: flex; flex-direction: row; align-items: center; gap: 24px;">
                            <!-- Icône -->
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg flex-shrink-0"
                                style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(to bottom, rgb(168, 85, 247) 0%, rgb(147, 51, 234) 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(168, 85, 247, 0.35); flex-shrink: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <rect width="20" height="14" x="2" y="5" rx="2" ry="2"></rect>
                                    <path d="M2 10h20"></path>
                                </svg>
                            </div>
                            <!-- Titre et description -->
                            <div style="flex: 1;">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2"
                                    style="font-size: 24px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px;">
                                    Conseil, Investissement & RSE
                                </h3>
                                <p class="text-gray-700"
                                    style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px;">
                                    Accompagnement stratégique des investisseurs
                                </p>
                            </div>
                            <!-- Bouton -->
                            <a href="/contact" class="md:ml-auto pole-contact-link"
                                style="margin-left: auto; display: block; text-decoration: none;">
                                <button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors pole-contact-button"
                                    style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; white-space: nowrap; border-radius: 6px; font-size: 14px; font-weight: 500; padding: 8px 16px; background-color: transparent; color: rgb(27, 77, 62); border: 1px solid rgb(27, 77, 62); cursor: pointer;">
                                    <span>Nous contacter</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="width: 16px; height: 16px;">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- Contenu principal -->
                    <div class="space-y-6 mb-8 rounded-lg p-8"
                        style="margin-bottom: 32px; background-color: rgb(249, 250, 251); border-radius: 8px; padding: 32px;">
                        <p class="text-lg text-gray-700 mb-8"
                            style="font-size: 18px; color: rgb(55, 65, 81); line-height: 29.25px; margin-bottom: 32px;">
                            Avec son portefeuille relationnel et professionnel, le CEGME intervient dans le négoce et la
                            représentation. Il assure et accompagne les investisseurs et les sociétés intéressées par
                            les créneaux porteurs d'affaires en RCA.
                        </p>
                        <h4 class="text-xl font-semibold mt-8 mb-4"
                            style="font-size: 20px; font-weight: 600; color: rgb(17, 24, 39); margin-top: 32px; margin-bottom: 16px;">
                            Services proposés :
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 services-proposes-grid"
                            style="display: grid; gap: 24px;">
                            <!-- Service 1: Accompagnement investisseurs -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Accompagnement investisseurs
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Création de sociétés, conseil réglementaire et fiscal, due diligence
                                </p>
                            </div>

                            <!-- Service 2: Permis et conformité -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Permis et conformité
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Obtention de licences et permis, veille réglementaire
                                </p>
                            </div>

                            <!-- Service 3: Politiques RSE -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path
                                                d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z">
                                            </path>
                                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Politiques RSE
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Conception et implémentation de stratégies de responsabilité sociétale
                                </p>
                            </div>

                            <!-- Service 4: Monitoring HSSE -->
                            <div class="bg-white rounded-lg p-6 border border-gray-200"
                                style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; border: 1px solid rgb(229, 231, 235);">
                                <div class="mb-4" style="margin-bottom: 16px;">
                                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center"
                                        style="width: 48px; height: 48px; border-radius: 8px; background-color: rgb(220, 252, 231); display: flex; align-items: center; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                                    Monitoring HSSE
                                </h3>
                                <p class="text-gray-600"
                                    style="font-size: 16px; color: rgb(75, 85, 99); line-height: 24px;">
                                    Hygiène, Sécurité, Santé, Environnement sur chantiers
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Standards et conformité Section -->
    <section class="w-full bg-white px-4 sm:px-6 lg:px-8"
        style="padding: 48px 0; background-color: rgb(255, 255, 255);">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-6" style="margin-bottom: 24px; text-align: center;">
                <h2 class="text-4xl font-bold mb-4"
                    style="font-size: 36px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 16px;">
                    Standards et conformité
                </h2>
                <p class="text-lg text-gray-600" style="font-size: 18px; color: rgb(75, 85, 99);">
                    Nos livrables respectent les exigences nationales et internationales les plus strictes
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 standards-grid"
                style="display: grid; gap: 20px;">
                <!-- Card 1: MEEDD - RCA -->
                <div class="bg-gray-50 rounded-lg p-4 text-center"
                    style="background-color: rgb(248, 250, 252); border-radius: 8px; padding: 20px; text-align: center;">
                    <div class="flex justify-center mb-3"
                        style="display: flex; justify-content: center; margin-bottom: 12px;">
                        <div class="w-12 h-12 rounded-full border-2 border-green-600 flex items-center justify-center"
                            style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid rgb(5, 150, 105); display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold mb-2"
                        style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px;">
                        MEEDD - RCA
                    </h3>
                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                        Conformité nationale
                    </p>
                </div>

                <!-- Card 2: IFC / SFI -->
                <div class="bg-gray-50 rounded-lg p-4 text-center"
                    style="background-color: rgb(248, 250, 252); border-radius: 8px; padding: 20px; text-align: center;">
                    <div class="flex justify-center mb-3"
                        style="display: flex; justify-content: center; margin-bottom: 12px;">
                        <div class="w-12 h-12 rounded-full border-2 border-green-600 flex items-center justify-center"
                            style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid rgb(5, 150, 105); display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold mb-2"
                        style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px;">
                        IFC / SFI
                    </h3>
                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                        Standards internationaux
                    </p>
                </div>

                <!-- Card 3: Banque Mondiale -->
                <div class="bg-gray-50 rounded-lg p-4 text-center"
                    style="background-color: rgb(248, 250, 252); border-radius: 8px; padding: 20px; text-align: center;">
                    <div class="flex justify-center mb-3"
                        style="display: flex; justify-content: center; margin-bottom: 12px;">
                        <div class="w-12 h-12 rounded-full border-2 border-green-600 flex items-center justify-center"
                            style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid rgb(5, 150, 105); display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold mb-2"
                        style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px;">
                        Banque Mondiale
                    </h3>
                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                        Cadres de sauvegarde
                    </p>
                </div>

                <!-- Card 4: BAD -->
                <div class="bg-gray-50 rounded-lg p-4 text-center"
                    style="background-color: rgb(248, 250, 252); border-radius: 8px; padding: 20px; text-align: center;">
                    <div class="flex justify-center mb-3"
                        style="display: flex; justify-content: center; margin-bottom: 12px;">
                        <div class="w-12 h-12 rounded-full border-2 border-green-600 flex items-center justify-center"
                            style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid rgb(5, 150, 105); display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 24px; height: 24px; color: rgb(5, 150, 105);">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-lg font-bold mb-2"
                        style="font-size: 18px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px;">
                        BAD
                    </h3>
                    <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                        Normes africaines
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos livrables Section -->
    <section class="w-full bg-white px-4 sm:px-6 lg:px-8"
        style="padding: 96px 0; background-color: rgb(255, 255, 255);">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center livrables-grid"
                style="display: grid; gap: 48px; align-items: center;">
                <!-- Left Section: Text Content -->
                <div>
                    <h2 class="text-4xl font-bold mb-6"
                        style="font-size: 36px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 24px;">
                        Nos livrables
                    </h2>
                    <p class="text-lg text-gray-700 mb-8"
                        style="font-size: 18px; color: rgb(55, 65, 81); line-height: 28px; margin-bottom: 32px;">
                        Chaque mission se conclut par des livrables de haute qualité, directement exploitables par nos
                        clients.
                    </p>
                    <ul class="space-y-4" style="list-style: none; padding: 0; margin: 0;">
                        <li class="flex items-start gap-3"
                            style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px;">
                            <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center flex-shrink-0"
                                style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(5, 150, 105); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    style="width: 14px; height: 14px; color: rgb(255, 255, 255);">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-gray-700"
                                style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px;">
                                Rapports techniques conformes aux exigences nationales
                            </span>
                        </li>
                        <li class="flex items-start gap-3"
                            style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px;">
                            <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center flex-shrink-0"
                                style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(5, 150, 105); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    style="width: 14px; height: 14px; color: rgb(255, 255, 255);">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-gray-700"
                                style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px;">
                                Rapports selon standards internationaux (IFC, BM, BAD)
                            </span>
                        </li>
                        <li class="flex items-start gap-3"
                            style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px;">
                            <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center flex-shrink-0"
                                style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(5, 150, 105); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    style="width: 14px; height: 14px; color: rgb(255, 255, 255);">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-gray-700"
                                style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px;">
                                Cartes et données SIG haute résolution
                            </span>
                        </li>
                        <li class="flex items-start gap-3"
                            style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px;">
                            <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center flex-shrink-0"
                                style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(5, 150, 105); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    style="width: 14px; height: 14px; color: rgb(255, 255, 255);">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-gray-700"
                                style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px;">
                                Recommandations opérationnelles
                            </span>
                        </li>
                        <li class="flex items-start gap-3"
                            style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px;">
                            <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center flex-shrink-0"
                                style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(5, 150, 105); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                    fill="none" stroke="white" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    style="width: 14px; height: 14px; color: rgb(255, 255, 255);">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span class="text-gray-700"
                                style="font-size: 16px; color: rgb(55, 65, 81); line-height: 24px;">
                                Plans de gestion et de suivi
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Right Section: Image -->
                <div class="relative" style="position: relative;">
                    <div class="rounded-2xl overflow-hidden shadow-lg livrables-image-wrapper"
                        style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);">
                        <img src="{{ asset('Image/Livrable.jpg') }}" alt="Nos livrables"
                            class="w-full h-auto object-cover livrables-image"
                            style="width: 100%; height: auto; object-fit: cover; display: block;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-site-footer />


</body>

</html>