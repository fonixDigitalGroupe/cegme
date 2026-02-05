<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CEGME - Bureau d'Études en Géosciences, Mines et Environnement en RCA</title>
    <meta name="description"
        content="CEGME est le cabinet leader en République Centrafricaine pour l'expertise technique en géosciences, mines et environnement. Bureau d'études et de consultation à Bangui.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="CEGME - Bureau d'Études en Géosciences, Mines et Environnement en RCA">
    <meta property="og:description"
        content="CEGME est le cabinet leader en République Centrafricaine pour l'expertise technique en géosciences, mines et environnement.">
    <meta property="og:image" content="{{ asset('Image/CEGME Logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="CEGME - Bureau d'Études en Géosciences, Mines et Environnement en RCA">
    <meta property="twitter:description"
        content="CEGME est le cabinet leader en République Centrafricaine pour l'expertise technique en géosciences, mines et environnement.">
    <meta property="twitter:image" content="{{ asset('Image/CEGME Logo.png') }}">

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
    @include('partials.site-styles')

    <!-- Forced Logos Layout 6-3 on Desktop - Match Image Exactly -->
    <style>
        @media (min-width: 1024px) {
            .logos-grid-container {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                gap: 20px !important;
                max-width: 1100px !important;
                margin: 48px auto !important;
                padding: 0 !important;
            }

            .logos-grid-container>div {
                flex: 0 0 auto !important;
                width: 155px !important;
                height: 140px !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                background-color: #ffffff !important;
                border: 1px solid rgba(229, 231, 235, 0.5) !important;
                border-radius: 12px !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
            }

            /* Rectangle size for OXFAM (Logo 7) */
            .logos-grid-container>div:nth-child(7) {
                width: 280px !important;
            }

            /* Standard square for others */
            .logos-grid-container>div:nth-child(8),
            .logos-grid-container>div:nth-child(9) {
                width: 155px !important;
            }
        }
    </style>

</head>

<body class="bg-white text-[#1b1b18] min-h-screen" style="background-color: #ffffff !important;">
    @include('partials.page-loader')
    <!-- Header from Contact/Services/Realisations Page -->
    <x-site-header />
    <!-- Hero Section - Exact Reproduction from Site -->
    <section class="hero-section relative w-full flex items-center lg:items-start justify-center overflow-hidden"
        style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; min-height: 100vh; padding: 0;">
        <!-- Background Image with Greenish-Blue Overlay -->
        <div class="absolute inset-0"
            style="background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42)); z-index: 1;">
            <!-- Background Image -->
            <img src="{{ asset('Image/IIMG_Banniere.jpg') }}" alt="Bannière CEGME"
                class="absolute inset-0 w-full h-full object-cover" loading="eager" style="z-index: 1; opacity: 0.4;">
            <!-- Gradient overlay filter mixed with image -->
            <div class="absolute inset-0"
                style="background: linear-gradient(to right bottom, rgba(6, 78, 59, 0.75), rgba(17, 94, 89, 0.75), rgba(15, 23, 42, 0.75)); z-index: 2;">
            </div>
        </div>

        <!-- Content Container - Centered Aligned for Hero Desktop -->
        <div class="hero-content-container relative z-10 w-full max-w-7xl mx-auto px-4 flex flex-col items-center justify-start text-center lg:pt-[120px]"
            style="min-height: 100vh; position: relative; z-index: 10;">

            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 mb-2 lg:px-6 lg:mb-4 hero-badge"
                style="background-color: rgba(16, 185, 129, 0.2); border: 1px solid rgba(5, 150, 105, 0.5); border-radius: 9999px;">
                <span style="color: #D1FAE5; font-weight: 500;" class="text-[13px] lg:text-[16px] whitespace-nowrap">
                    Plateforme d'Experts Nationaux Agréée
                </span>
            </div>

            <!-- Main Title (H1) -->
            <h1 class="hero-title mb-8" style="font-size: 84px; font-weight: 700; line-height: 1.1; color: #ffffff;">
                <span class="block">Expertise en Géosciences,</span>
                <span class="block" style="color: #10B981; font-weight: 800;">Mines & Environnement</span>
            </h1>

            <!-- Subtitle -->
            <p class="hero-description mb-12 mx-auto"
                style="font-size: 20px; color: #E5E7EB; line-height: 1.6; max-width: 800px;">
                CEGME accompagne vos projets en République Centrafricaine avec une approche durable et responsable
            </p>

            <!-- Buttons -->
            <div class="hero-buttons flex flex-wrap items-center justify-center" style="gap: 24px;">
                <!-- Prendre un RDV -->
                <a href="https://calendly.com/cegme" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-white font-medium transition-all duration-200 hover:opacity-90"
                    style="background-color: #10B981; border-radius: 9999px; font-size: 18px;">
                    <span>Prendre un RDV</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; stroke-width: 2.5;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <!-- Nous Contacter -->
                <a href="/contact"
                    class="inline-flex items-center justify-center px-8 py-3.5 text-white font-medium border border-white transition-all duration-200 hover:bg-white/10"
                    style="background-color: transparent; border: 1px solid #FFFFFF !important; border-radius: 9999px; font-size: 18px;">
                    <span>Nous Contacter</span>
                </a>
            </div>
        </div>
    </section>

    <section class="w-full"
        style="padding: 80px 0 !important; margin-top: 0 !important; position: relative; z-index: 5; background: linear-gradient(to bottom, rgb(248, 250, 252), rgb(255, 255, 255));">
        <style>
            /* Responsive Hero Positioning */
            .hero-content-container {
                padding-top: 65px !important;
            }

            @media (min-width: 1024px) {
                .hero-content-container {
                    padding-top: 60px !important;
                }
            }

            /* About Section Desktop Layout Fix */
            @media (min-width: 1024px) {
                .about-grid-container {
                    display: grid !important;
                    grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
                    gap: 4rem !important;
                    /* gap-16 */
                }

                .about-image-col {
                    grid-column: span 2 / span 2 !important;
                    order: 1 !important;
                }

                .about-text-col {
                    grid-column: span 3 / span 3 !important;
                    order: 2 !important;
                }
            }

            /* Mobile-only styles: emphasize and reorganize hero text without touching desktop */
            @media (max-width: 639px) {
                .mobile-hero-block {
                    background: transparent;
                    padding: 0;
                    border-radius: 0;
                    box-shadow: none;
                    border: none;
                    max-width: 768px !important;
                    margin: 0 auto !important;
                    text-align: center;
                }

                .mobile-hero-title {
                    font-size: 1.6rem !important;
                    line-height: 1.3 !important;
                    margin-bottom: 1.5rem !important;
                    text-align: center !important;
                }

                .mobile-hero-decor {
                    width: 80px !important;
                    height: 4px !important;
                    margin: 0 auto 2rem auto !important;
                }

                .mobile-hero-para {
                    font-size: 20px !important;
                    line-height: 36px !important;
                    text-align: justify !important;
                    margin-bottom: 24px !important;
                    color: #374151 !important;
                }

                .mobile-hero-image-container {
                    margin-bottom: 2rem !important;
                    height: 300px !important;
                    min-height: 300px !important;
                }
            }
        </style>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flex container for About Section: Column by default (mobile), Row on desktop -->
            <div class="about-flex-container"
                style="display: flex; flex-direction: column; gap: 48px; align-items: stretch;">

                <!-- Image (Index 1 - Left on Desktop) -->
                <div class="about-image-col" style="width: 100%; order: 2;">
                    <!-- Image Container -->
                    <div class="about-image-card expertise-image-container"
                        style="background: transparent; border-radius: 12px; padding: 0; overflow: hidden;">
                        <div class="relative w-full h-full">
                            <div class="relative overflow-hidden w-full h-full"
                                style="position: relative; overflow: hidden; border-radius: 12px; width: 100%; height: 100%;">
                                <img src="{{ asset('Image/Personnel.jpg') }}" alt="Équipe CEGME"
                                    class="w-full h-full object-cover expertise-image-img" loading="lazy"
                                    style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Texte (Index 2 - Right on Desktop) -->
                <div class="about-text-col" style="width: 100%; order: 1;">
                    <div class="space-y-6 mobile-hero-block" style="display: flex; flex-direction: column; gap: 24px;">
                        <!-- Titre et Ligne -->
                        <div>
                            <h2 class="text-4xl font-bold mb-6 leading-tight mobile-hero-title"
                                style="font-size: 42px; font-weight: 800; color: #111827; margin-bottom: 16px; line-height: 1.2; letter-spacing: -0.5px;">
                                L'expertise au service de l'émergence
                            </h2>
                            <div class="w-16 h-1 bg-[#16a34a] rounded-full mobile-hero-decor"
                                style="width: 80px; height: 4px; background-color: #16a34a; border-radius: 2px; margin-bottom: 24px;">
                            </div>
                        </div>

                        <p class="text-[17px] text-[#374151] leading-[32px] mobile-hero-para"
                            style="font-size: 17px; color: #374151; line-height: 32px; margin: 0 0 16px 0; font-weight: 400; text-align: justify;">
                            Le <strong style="font-weight: 700; color: #111827;">Cabinet d'Études Géologiques,
                                Minières et Environnementales (CEGME) Sarl.</strong>, est le partenaire de référence
                            pour la conception et la concrétisation de projets stratégiques en République Centrafricaine
                            (RCA) et en Afrique Centrale. Spécialisé dans les géosciences, les mines et le développement
                            durable, le cabinet transforme les enjeux complexes en leviers de croissance responsable
                            pour les investisseurs et les institutions.
                        </p>
                        <p class="text-[17px] text-[#374151] leading-[32px] mobile-hero-para"
                            style="font-size: 17px; color: #374151; line-height: 32px; margin: 0; font-weight: 400; text-align: justify;">
                            Enregistré sous le numéro <strong style="font-weight: 700; color: #111827;">N°RCCM :
                                CA/BG/2015B541</strong>, le CEGME est une structure multidisciplinaire agréée et
                            accréditée par le Ministère de l'Environnement et du Développement Durable (<strong
                                style="font-weight: 700; color: #111827;">N°004/MEEDD/DIR.CAB_21</strong> et
                            <strong style="font-weight: 700; color: #111827;">N°29/MEEDD/DIR.CAB</strong>).
                        </p>
                    </div>
                </div>
            </div>

            <style>
                /* Force Desktop Layout side-by-side with exact proportions */
                @media (min-width: 1024px) {
                    .about-flex-container {
                        flex-direction: row !important;
                        gap: 48px !important;
                        align-items: flex-start !important;
                        /* Top align image and text */
                    }

                    .about-image-col {
                        order: 1 !important;
                        flex-basis: 45% !important;
                        width: 45% !important;
                    }

                    .about-text-col {
                        order: 2 !important;
                        flex-basis: 55% !important;
                        width: 55% !important;
                        margin-top: 0 !important;
                        /* Force top alignment */
                        padding-top: 0 !important;
                    }

                    .expertise-image-container {
                        height: 500px !important;
                        /* Reduced from 600px */
                        min-height: 500px !important;
                    }

                    .expertise-image-img {
                        height: 100% !important;
                        object-position: center !important;
                    }
                }

                /* Mobile: Protect vertical layout and fixed height */
                @media (max-width: 1023px) {
                    .about-image-card {
                        background: transparent !important;
                        border-radius: 12px !important;
                        padding: 0 !important;
                        box-shadow: none !important;
                    }

                    .expertise-image-container {
                        height: 350px !important;
                        min-height: 350px !important;
                    }
                }
            </style>
        </div>
    </section>

    <!-- Statistics Section - Enhanced Professional Design -->
    <section class="w-full bg-white" style="padding: 40px 0; margin: 0; background-color: #ffffff !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding: 0; margin: 0;">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 stats-grid-container"
                style="padding: 0; margin: 0;">
                <!-- Card 1: Missions stratégiques -->
                <div class="text-center" style="text-align: center; padding: 0;">
                    <!-- Icon Container -->
                    <div class="mb-4 mx-auto"
                        style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; padding: 0; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 28px; height: 28px; color: #ffffff;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                        </svg>
                    </div>
                    <!-- Number -->
                    <div
                        style="font-size: 38px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 42px; margin-bottom: 6px; margin-top: 0; letter-spacing: -1.5px;">
                        70+
                    </div>
                    <!-- Title -->
                    <h3
                        style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px; line-height: 22px; letter-spacing: -0.2px;">
                        Missions stratégiques
                    </h3>
                    <!-- Description -->
                    <p
                        style="font-size: 13px; color: rgb(107, 114, 128); line-height: 18px; margin-top: 0; max-width: 100%;">
                        réalisées depuis 2011
                    </p>
                </div>

                <!-- Card 2: EIES & Audits -->
                <div class="text-center" style="text-align: center; padding: 0;">
                    <!-- Icon Container -->
                    <div class="mb-4 mx-auto"
                        style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; padding: 0; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 28px; height: 28px; color: #ffffff;">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                    <!-- Number -->
                    <div
                        style="font-size: 38px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 42px; margin-bottom: 6px; margin-top: 0; letter-spacing: -1.5px;">
                        45+
                    </div>
                    <!-- Title -->
                    <h3
                        style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px; line-height: 22px; letter-spacing: -0.2px;">
                        EIES & Audits
                    </h3>
                    <!-- Description -->
                    <p
                        style="font-size: 13px; color: rgb(107, 114, 128); line-height: 18px; margin-top: 0; max-width: 100%;">
                        validés officiellement
                    </p>
                </div>

                <!-- Card 3: Études de faisabilité -->
                <div class="text-center" style="text-align: center; padding: 0;">
                    <!-- Icon Container -->
                    <div class="mb-4 mx-auto"
                        style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; padding: 0; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 28px; height: 28px; color: #ffffff;">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                    </div>
                    <!-- Number -->
                    <div
                        style="font-size: 38px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 42px; margin-bottom: 6px; margin-top: 0; letter-spacing: -1.5px;">
                        10+
                    </div>
                    <!-- Title -->
                    <h3
                        style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px; line-height: 22px; letter-spacing: -0.2px;">
                        Études de faisabilité
                    </h3>
                    <!-- Description -->
                    <p
                        style="font-size: 13px; color: rgb(107, 114, 128); line-height: 18px; margin-top: 0; max-width: 100%;">
                        pour le secteur minier
                    </p>
                </div>

                <!-- Card 4: Années d'expertise -->
                <div class="text-center" style="text-align: center; padding: 0;">
                    <!-- Icon Container -->
                    <div class="mb-4 mx-auto"
                        style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; padding: 0; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 28px; height: 28px; color: #ffffff;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <!-- Number -->
                    <div
                        style="font-size: 38px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 42px; margin-bottom: 6px; margin-top: 0; letter-spacing: -1.5px;">
                        10+
                    </div>
                    <!-- Title -->
                    <h3
                        style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px; line-height: 22px; letter-spacing: -0.2px;">
                        Années d'expertise
                    </h3>
                    <!-- Description -->
                    <p
                        style="font-size: 13px; color: rgb(107, 114, 128); line-height: 18px; margin-top: 0; max-width: 100%;">
                        depuis 2014
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Identité et synergies scientifiques Section -->
    <section class="w-full bg-gray-100" style="padding: 100px 0; margin: 0; background-color: #f3f4f6 !important;">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 identity-section-container">
            <!-- Titre avec ligne décorative -->
            <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                <h2 class="text-4xl font-bold mb-4"
                    style="font-size: 40px; font-weight: 800; color: rgb(17, 24, 39); text-align: center; margin-bottom: 16px; line-height: 48px; letter-spacing: -0.5px;">
                    Identité et synergies scientifiques
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto"
                    style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto;">
                </div>
            </div>

            <!-- Deux colonnes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 identity-grid-container items-stretch">
                <!-- Colonne gauche: Une résilience entrepreneuriale -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 h-full"
                    style="background-color: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08); border: 1px solid rgb(243, 244, 246); transition: all 0.3s ease; cursor: default; position: relative; overflow: hidden; height: 100%;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full -mr-16 -mt-16 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10 h-full" style="position: relative; z-index: 10; height: 100%;">
                        <div class="flex flex-col h-full" style="display: flex; flex-direction: column; height: 100%;">
                            <!-- Icône verte -->
                            <div class="mb-6" style="margin-bottom: 24px;">
                                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg"
                                    style="width: 80px; height: 80px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <!-- Contenu -->
                            <div class="flex-grow" style="flex-grow: 1;">
                                <h3 class="text-2xl font-bold mb-5"
                                    style="font-size: 26px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 20px; line-height: 34px;">
                                    Une résilience entrepreneuriale
                                </h3>
                                <p class="text-gray-700 leading-relaxed"
                                    style="font-size: 18px; color: rgb(55, 65, 81); line-height: 32px; margin: 0; text-align: justify;">
                                    Né en 2014 au cœur d'une période de défis majeurs pour la RCA, le CEGME est passé
                                    d'un collectif d'experts nationaux à une SARL de conseil reconnue à l'échelle
                                    régionale. Le cabinet emploie aujourd'hui une équipe multidisciplinaire
                                    (enseignants-chercheurs, ingénieurs, chargés de mission) capable d'intervenir sur
                                    toute la chaîne de valeur des ressources naturelles.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne droite: Un socle académique et international -->
                <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 h-full"
                    style="background-color: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08); border: 1px solid rgb(243, 244, 246); transition: all 0.3s ease; cursor: default; position: relative; overflow: hidden; height: 100%;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(239, 246, 255); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10 h-full" style="position: relative; z-index: 10; height: 100%;">
                        <div class="flex flex-col h-full" style="display: flex; flex-direction: column; height: 100%;">
                            <!-- Icône bleue -->
                            <div class="mb-6" style="margin-bottom: 24px;">
                                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg"
                                    style="width: 80px; height: 80px; border-radius: 16px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                            </div>
                            <!-- Contenu -->
                            <div class="flex-grow" style="flex-grow: 1;">
                                <h3 class="text-2xl font-bold mb-5"
                                    style="font-size: 26px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 20px; line-height: 34px;">
                                    Un socle académique et international
                                </h3>
                                <p class="text-gray-700 leading-relaxed mb-6"
                                    style="font-size: 18px; color: rgb(55, 65, 81); line-height: 32px; margin: 0 0 24px 0; text-align: justify;">
                                    Pour garantir une approche fondée sur l'innovation, le CEGME maintient des
                                    collaborations organiques :
                                </p>
                                <ul class="space-y-4"
                                    style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px;">
                                    <li class="flex items-start gap-4"
                                        style="display: flex; align-items: flex-start; gap: 16px;">
                                        <div class="flex-shrink-0 mt-1" style="flex-shrink: 0; margin-top: 4px;">
                                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center"
                                                style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    style="width: 14px; height: 14px; color: rgb(16, 185, 129);">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 flex-1"
                                            style="font-size: 17px; color: rgb(55, 65, 81); line-height: 30px; flex: 1;">
                                            <strong style="font-weight: 700; color: rgb(17, 24, 39);">Partenariats
                                                universitaires :</strong> Collaboration avec les laboratoires de
                                            l'Université de Bangui (Laboratoire Lavoisier Hydro-sciences, Cartographie).
                                        </span>
                                    </li>
                                    <li class="flex items-start gap-4"
                                        style="display: flex; align-items: flex-start; gap: 16px;">
                                        <div class="flex-shrink-0 mt-1" style="flex-shrink: 0; margin-top: 4px;">
                                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center"
                                                style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    style="width: 14px; height: 14px; color: rgb(16, 185, 129);">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 flex-1"
                                            style="font-size: 17px; color: rgb(55, 65, 81); line-height: 30px; flex: 1;">
                                            <strong style="font-weight: 700; color: rgb(17, 24, 39);">Alliance avec le
                                                SDGM (Chine) :</strong> Partenariat avec le Shandong Institute of
                                            Geophysical and Geochemical Exploration pour l'exploration géophysique et
                                            géochimique de haute technologie.
                                        </span>
                                    </li>
                                    <li class="flex items-start gap-4"
                                        style="display: flex; align-items: flex-start; gap: 16px;">
                                        <div class="flex-shrink-0 mt-1" style="flex-shrink: 0; margin-top: 4px;">
                                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center"
                                                style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    style="width: 14px; height: 14px; color: rgb(16, 185, 129);">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="text-gray-700 flex-1"
                                            style="font-size: 17px; color: rgb(55, 65, 81); line-height: 30px; flex: 1;">
                                            <strong style="font-weight: 700; color: rgb(17, 24, 39);">Réseaux mondiaux
                                                :</strong> Collaboration Sud-Sud avec Seve-Consulting (Togo) et ses
                                            dirigeants des anciens stagiaires du réseau CESMAT (France) et du GIRAF.
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section - Enhanced Professional Design -->
    <section class="w-full bg-gray-100 px-4 sm:px-6 lg:px-8"
        style="padding: 80px 0; background-color: #f9fafb !important;">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                <h2 class="text-4xl font-bold text-black mb-4"
                    style="font-size: 40px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; text-align: center; line-height: 48px; letter-spacing: -0.5px;">
                    Pourquoi choisir CEGME ?
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto mb-6"
                    style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto 24px;">
                </div>
                <p class="text-lg text-gray-600 mx-auto"
                    style="font-size: 18px; color: #6b7280; max-width: 700px; margin: 0 auto; text-align: center; line-height: 28px;">
                    Des atouts qui font la différence pour la réussite de vos projets
                </p>
            </div>

            <!-- Cards Grid - 3 cards per row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 benefits-grid-container"
                style="max-width: 100%; margin: 0;">
                <!-- Card 1: Expertise locale -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <circle cx="12" cy="12" r="9"></circle>
                                <circle cx="12" cy="12" r="5"></circle>
                                <circle cx="12" cy="12" r="1.5" fill="white"></circle>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Expertise locale
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center"
                            style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Connaissance approfondie du contexte centrafricain et des réglementations nationales
                        </p>
                    </div>
                </div>

                <!-- Card 2: Agrément officiel -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <path
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Agrément officiel
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center"
                            style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Plateforme d'experts agréée par le Ministère de l'Environnement (N° 004/MEDD/DIRCAB_21)
                        </p>
                    </div>
                </div>

                <!-- Card 3: Réseau de spécialistes -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Réseau de spécialistes
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center"
                            style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Équipe pluridisciplinaire et partenariats stratégiques nationaux et internationaux
                        </p>
                    </div>
                </div>

                <!-- Card 4: Réactivité -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Réactivité
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center"
                            style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Intervention rapide sur tout le territoire centrafricain avec une approche flexible
                        </p>
                    </div>
                </div>

                <!-- Card 5: Conformité garantie -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Conformité garantie
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center"
                            style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Tous nos rapports sont validés par les ministères compétents
                        </p>
                    </div>
                </div>

                <!-- Card 6: Approche innovante -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <circle cx="12" cy="12" r="5"></circle>
                                <line x1="12" y1="1" x2="12" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="23"></line>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                <line x1="1" y1="12" x2="3" y2="12"></line>
                                <line x1="21" y1="12" x2="23" y2="12"></line>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4 text-center"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Approche innovante
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed text-center"
                            style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Solutions durables combinant expertise technique et bonnes pratiques internationales
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos pôles d'activités Section - Enhanced Design -->
    <section class="w-full bg-white px-4 sm:px-6 lg:px-8"
        style="padding: 80px 0; margin: 0; border: none !important; border-top: none !important; border-bottom: none !important; outline: none !important; background-color: #ffffff !important;">
        <div class="max-w-5xl mx-auto"
            style="border: none !important; border-top: none !important; border-bottom: none !important; max-width: 1024px;">
            <!-- Header -->
            <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                <h2 class="text-4xl font-bold text-black mb-4"
                    style="font-size: 40px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; text-align: center; line-height: 48px; letter-spacing: -0.5px;">
                    Nos pôles d'activités
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto mb-6"
                    style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto 24px;">
                </div>
                <p class="text-lg text-gray-600 mx-auto"
                    style="font-size: 18px; color: #6b7280; max-width: 700px; margin: 0 auto; text-align: center; line-height: 28px;">
                    Une expertise complète au service de vos projets
                </p>
            </div>

            <!-- Cards Grid - 2x2 layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 activities-grid-container"
                style="max-width: 100%; margin: 0;">
                <!-- Card 1: Environnement et Développement Durable -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default; max-width: 100%;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full -mr-16 -mt-16 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, rgb(34, 197, 94) 0%, rgb(22, 163, 74) 100%); box-shadow: 0 8px 20px rgba(34, 197, 94, 0.35); margin-bottom: 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path
                                    d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                </path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; letter-spacing: -0.3px;">
                            Environnement et Développement Durable
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 mb-5"
                            style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin-bottom: 20px;">
                            Études d'impact environnemental et social, audits, gestion durable des ressources naturelles
                        </p>
                        <!-- Button -->
                        <a href="/services#environnement"
                            class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors"
                            style="font-size: 16px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                            <span>En savoir plus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Recherche Géologique et Minière -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-full -mr-16 -mt-16 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(255, 247, 237); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(to top, rgb(249, 115, 22) 0%, rgb(251, 146, 60) 100%); box-shadow: 0 8px 20px rgba(249, 115, 22, 0.35); margin-bottom: 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <path d="M3 20h6l2-6 4 6h8l-3-8-3-4-2 4-2-2z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; letter-spacing: -0.3px;">
                            Recherche Géologique et Minière
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 mb-5"
                            style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin-bottom: 20px;">
                            Exploration géologique, cartographie numérique, évaluation économique de projets miniers
                        </p>
                        <!-- Button -->
                        <a href="/services#recherche"
                            class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors"
                            style="font-size: 16px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                            <span>En savoir plus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 3: Géo-ingénierie appliquée -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(239, 246, 255); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(to bottom, rgb(59, 130, 246) 0%, rgb(96, 165, 250) 100%); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35); margin-bottom: 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
                                <path d="M9 8a3 3 0 0 1 6 0c0 1.5-3 4-3 4s-3-2.5-3-4z"></path>
                                <path d="M7 14a3 3 0 0 1 6 0c0 1.5-3 4-3 4s-3-2.5-3-4z"></path>
                                <path d="M11 18a2 2 0 0 1 2 0c0 1-2 2.5-2 2.5s-2-1.5-2-2.5z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; letter-spacing: -0.3px;">
                            Géo-ingénierie appliquée
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 mb-5"
                            style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin-bottom: 20px;">
                            SIG, études hydrogéologiques et géotechniques, modélisation cartographique
                        </p>
                        <!-- Button -->
                        <a href="/services#geo-ingenierie"
                            class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors"
                            style="font-size: 16px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                            <span>En savoir plus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 4: Négoce et Représentation -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2"
                    style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                    <!-- Effet de fond décoratif -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-full -mr-16 -mt-16 opacity-50"
                        style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(250, 245, 255); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;">
                    </div>
                    <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                        <div class="flex items-center justify-center mb-6"
                            style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(to bottom, rgb(168, 85, 247) 0%, rgb(147, 51, 234) 100%); box-shadow: 0 8px 20px rgba(168, 85, 247, 0.35); margin-bottom: 24px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                <rect width="20" height="14" x="2" y="5" rx="2" ry="2"></rect>
                                <path d="M2 10h20"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                        <h3 class="text-xl font-bold mb-4"
                            style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; letter-spacing: -0.3px;">
                            Négoce et Représentation
                        </h3>
                        <!-- Description -->
                        <p class="text-gray-600 mb-5"
                            style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin-bottom: 20px;">
                            Conseil aux investisseurs, représentation d'entreprises, négociation commerciale
                        </p>
                        <!-- Button -->
                        <a href="/services#negoce"
                            class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors"
                            style="font-size: 16px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                            <span>En savoir plus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ils nous font confiance Section - RESTORED MOBILE / REDESIGNED DESKTOP -->
    <section class="w-full bg-gray-50 lg:bg-white px-4 sm:px-6 lg:px-8"
        style="padding: 80px 0; margin: 0; lg:padding: 100px 0;">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                <h2 class="text-4xl lg:text-[48px] font-bold lg:font-black text-[#111827] mb-4"
                    style="margin-bottom: 16px; text-align: center; line-height: 1.2;">
                    Ils nous font confiance
                </h2>
                <!-- Mobile Underline -->
                <div class="lg:hidden w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto"
                    style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%);">
                </div>
                <!-- Desktop Underline -->
                <div class="hidden lg:block w-20 h-1.5 bg-[#10B981] rounded-full mx-auto"
                    style="width: 80px; height: 6px; background-color: #10B981;">
                </div>
            </div>

            <!-- Logos Container - Forced 6-col Grid on Desktop via Head CSS -->
            <div
                class="logos-grid-container flex flex-wrap justify-center items-center gap-4 md:gap-6 max-w-7xl mx-auto">

                <!-- Logo 1: Banque mondiale -->
                <div class="bg-white rounded-xl lg:rounded-2xl p-6 lg:p-4 shadow-md lg:shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-200 lg:border-white flex items-center justify-center flex-shrink-0 lg:flex-shrink"
                    style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; lg:min-height: 140px; lg:min-width: 0;">
                    <img src="{{ asset('Image/Wordbank.png') }}" alt="Banque mondiale"
                        class="max-w-full max-h-full object-contain lg:filter lg:grayscale lg:hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                        style="max-width: 100%; max-height: 70px; lg:max-height: 80px; object-fit: contain;">
                </div>

                <!-- Logo 2: USAID -->
                <div class="bg-white rounded-xl lg:rounded-2xl p-6 lg:p-4 shadow-md lg:shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-200 lg:border-white flex items-center justify-center flex-shrink-0 lg:flex-shrink"
                    style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; lg:min-height: 140px; lg:min-width: 0;">
                    <img src="{{ asset('Image/Usaid.png') }}" alt="USAID"
                        class="max-w-full max-h-full object-contain lg:filter lg:grayscale lg:hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                        style="max-width: 100%; max-height: 70px; lg:max-height: 80px; object-fit: contain;">
                </div>

                <!-- Logo 3: BAD -->
                <div class="bg-white rounded-xl lg:rounded-2xl p-6 lg:p-4 shadow-md lg:shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-200 lg:border-white flex items-center justify-center flex-shrink-0 lg:flex-shrink"
                    style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; lg:min-height: 140px; lg:min-width: 0;">
                    <img src="{{ asset('Image/BAD.png') }}" alt="BAD"
                        class="max-w-full max-h-full object-contain lg:filter lg:grayscale lg:hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                        style="max-width: 100%; max-height: 70px; lg:max-height: 80px; object-fit: contain;">
                </div>

                <!-- Logo 4: BDEAC -->
                <div class="bg-white rounded-xl lg:rounded-2xl p-6 lg:p-4 shadow-md lg:shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-200 lg:border-white flex items-center justify-center flex-shrink-0 lg:flex-shrink"
                    style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; lg:min-height: 140px; lg:min-width: 0;">
                    <img src="{{ asset('Image/BDEAC.png') }}" alt="BDEAC"
                        class="max-w-full max-h-full object-contain lg:filter lg:grayscale lg:hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                        style="max-width: 100%; max-height: 70px; lg:max-height: 80px; object-fit: contain;">
                </div>

                <!-- Logo 5: FIDA -->
                <div class="bg-white rounded-xl lg:rounded-2xl p-6 lg:p-4 shadow-md lg:shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-200 lg:border-white flex items-center justify-center flex-shrink-0 lg:flex-shrink"
                    style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; lg:min-height: 140px; lg:min-width: 0;">
                    <img src="{{ asset('Image/FIDA.png') }}" alt="FIDA"
                        class="max-w-full max-h-full object-contain lg:filter lg:grayscale lg:hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                        style="max-width: 100%; max-height: 70px; lg:max-height: 80px; object-fit: contain;">
                </div>

                <!-- Logo 6: UNICEF -->
                <div class="bg-white rounded-xl lg:rounded-2xl p-6 lg:p-4 shadow-md lg:shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-200 lg:border-white flex items-center justify-center flex-shrink-0 lg:flex-shrink"
                    style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; lg:min-height: 140px; lg:min-width: 0;">
                    <img src="{{ asset('Image/unicef.png') }}" alt="UNICEF"
                        class="max-w-full max-h-full object-contain lg:filter lg:grayscale lg:hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                        style="max-width: 100%; max-height: 70px; lg:max-height: 80px; object-fit: contain;">
                </div>

                <!-- Logo 7: OXFAM -->
                <div class="bg-white rounded-xl lg:rounded-2xl p-6 lg:p-4 shadow-md lg:shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-200 lg:border-white flex items-center justify-center flex-shrink-0 lg:flex-shrink "
                    style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; lg:min-height: 140px; lg:min-width: 0;">
                    <img src="{{ asset('Image/oxfam.png') }}" alt="OXFAM"
                        class="max-w-full max-h-full object-contain lg:filter lg:grayscale lg:hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                        style="max-width: 100%; max-height: 70px; lg:max-height: 80px; object-fit: contain;">
                </div>

                <!-- Logo 8: FAO -->
                <div class="bg-white rounded-xl lg:rounded-2xl p-6 lg:p-4 shadow-md lg:shadow-[0_4px_20px_rgb(0,0,0,0.04)] border border-gray-200 lg:border-white flex items-center justify-center flex-shrink-0 lg:flex-shrink"
                    style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; lg:min-height: 140px; lg:min-width: 0;">
                    <img src="{{ asset('Image/FAO.png') }}" alt="FAO"
                        class="max-w-full max-h-full object-contain lg:filter lg:grayscale lg:hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                        style="max-width: 100%; max-height: 70px; lg:max-height: 80px; object-fit: contain;">
                </div>

                <!-- Logo 9: African Parks -->
                <div class="bg-white rounded-xl lg:rounded-2xl p-6 lg:p-4 shadow-md lg:shadow-[0_4px_20_rgb(0,0,0,0.04)] border border-gray-200 lg:border-white flex items-center justify-center flex-shrink-0 lg:flex-shrink"
                    style="background-color: #ffffff; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; lg:min-height: 140px; lg:min-width: 0;">
                    <img src="{{ asset('Image/Africain park.png') }}" alt="African Parks"
                        class="max-w-full max-h-full object-contain lg:filter lg:grayscale lg:hover:grayscale-0 transition-all duration-300"
                        loading="lazy"
                        style="max-width: 100%; max-height: 70px; lg:max-height: 80px; object-fit: contain;">
                </div>
            </div>
        </div>
    </section>

    <!-- Mot de la direction Section - REPLICATED FROM REFERENCE -->
    <section class="mt-[-1px] w-full bg-gradient-to-b from-white to-gray-50 lg:bg-white px-4 sm:px-6 lg:px-8"
        style="padding: 100px 0; margin: 0; position: relative; z-index: 10;">
        <div class="max-w-3xl mx-auto px-4 md:px-8 lg:px-0" style="margin: 0 auto; max-width: 736px !important;">
            <!-- Header -->
            <div class="text-center mb-12 lg:mb-12" style="text-align: center;">
                <h2 class="text-4xl font-bold text-[#1F2937]"
                    style="margin-bottom: 24px; text-align: center; line-height: 1.2; letter-spacing: -1px; font-size: 42px; font-weight: 800; color: rgb(17, 24, 39);">
                    Mot de la direction
                </h2>
                <!-- Green Underline - Replicated from Reference -->
                <div class="w-24 h-1 bg-gradient-to-r from-[#059669] to-[#10B981] mx-auto"
                    style="width: 96px; height: 4px; background: linear-gradient(90deg, #059669 0%, #10b981 100%); border-radius: 9999px; margin-bottom: 48px;">
                </div>
            </div>

            <!-- Content -->
            <div class="relative" style="position: relative;">
                <!-- Quote icon - Replicated from Reference -->
                <div class="flex justify-center mb-10 lg:mb-16">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center shadow-lg"
                        style="width: 55px; height: 55px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 28px; height: 28px; color: #ffffff;">
                            <path
                                d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z">
                            </path>
                            <path
                                d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!-- Text with exact reference typography on desktop -->
                <div class="space-y-8 lg:space-y-10" style="display: flex; flex-direction: column;">
                    <p class="text-[20px] text-gray-700 leading-relaxed text-justify"
                        style="margin: 0; font-weight: 400; font-size: 20px; line-height: 36px; text-align: justify; color: rgb(55, 65, 81);">
                        « Notre identité repose sur une conviction forte : <strong class="font-extrabold text-black"
                            style="font-weight: 700; color: rgb(17, 24, 39);">l'expertise de pointe et la
                            connaissance profonde du terrain sont indissociables</strong>. Le CEGME Sarl., mobilise un
                        réseau d'élite composé d'universitaires et de consultants ayant évolué au sein de groupes
                        mondiaux tels qu'<strong class="font-extrabold text-black"
                            style="font-weight: 700; color: rgb(17, 24, 39);">AREVA,
                            DEBEERS, AURAFRIQUE et DIGOIL</strong>.
                    </p>
                    <p class="text-[20px] text-gray-700 leading-relaxed text-justify"
                        style="margin: 0; font-weight: 400; font-size: 20px; line-height: 36px; text-align: justify; color: rgb(55, 65, 81);">
                        Cette dualité constitue notre <strong class="font-extrabold text-[#059669]"
                            style="font-weight: 700;">"plus-value"</strong> :
                        nous offrons aux investisseurs internationaux et nationaux la rigueur des bonnes pratiques
                        (<strong class="font-extrabold text-black"
                            style="font-weight: 700; color: rgb(17, 24, 39);">SFI, Banque mondiale,
                            BAD</strong>) tout en garantissant un ancrage local et une maîtrise des réalités
                        sociopolitiques de la région. En valorisant le contenu local et le capital humain centrafricain,
                        nous sécurisons vos actifs et bâtissons une prospérité durable pour la Nation. »
                    </p>
                </div>

                <!-- mobile decorative element -->
                <div class="lg:hidden w-32 h-0.5 bg-gradient-to-r from-transparent via-green-500 to-transparent mx-auto mt-10 mb-8"
                    style="width: 128px; height: 2px; background: linear-gradient(90deg, transparent 0%, rgb(5, 150, 105) 50%, transparent 100%); margin: 40px auto 32px;">
                </div>

                <!-- Signature - Replicated from Reference -->
                <div class="flex items-center justify-center gap-4 mt-12 lg:mt-16"
                    style="display: flex; align-items: center; justify-content: center; gap: 16px;">
                    <!-- Circle Circle DG -->
                    <div class="w-16 h-16 rounded-full flex items-center justify-center shadow-md flex-shrink-0"
                        style="width: 64px; height: 64px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                        <span class="text-white font-bold" style="color: #ffffff; font-weight: 700; font-size: 18px;">
                            DG
                        </span>
                    </div>
                    <!-- Text -->
                    <div class="text-left" style="text-align: left;">
                        <p class="text-lg font-bold text-[#111827]"
                            style="font-size: 18px; font-weight: 700; color: #111827; margin: 0; line-height: 1.2;">
                            Directeur Général
                        </p>
                        <p class="text-base text-gray-500 mt-1"
                            style="font-size: 16px; color: #4b5563; margin-top: 4px; margin-bottom: 0; line-height: 1.2;">
                            CEGME Sarl.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projets récents Section -->
    <section class="w-full bg-white px-4 sm:px-6 lg:px-8"
        style="padding: 80px 0; margin: 0; background-color: #ffffff !important;">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                <h2 class="text-4xl font-bold text-black mb-4"
                    style="font-size: 40px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; text-align: center; line-height: 48px; letter-spacing: -0.5px;">
                    Projets récents
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto mb-6"
                    style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto 24px;">
                </div>
                <p class="text-lg text-gray-600 mx-auto max-w-2xl"
                    style="font-size: 18px; color: rgb(75, 85, 99); max-width: 600px; margin: 0 auto; text-align: center; line-height: 28px;">
                    Découvrez nos dernières réalisations et projets d'envergure
                </p>
            </div>

            <!-- Projects Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 projects-grid-container"
                style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 32px;">
                <!-- Project 1 -->
                <a href="/services#geo-ingenierie"
                    class="block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100"
                    style="display: block; background-color: rgb(255, 255, 255); border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.3s ease; text-decoration: none; color: inherit; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                    <div class="relative overflow-hidden"
                        style="position: relative; overflow: hidden; height: 260px; background-color: #f3f4f6;">
                        <img src="{{ asset('Image/Complexe Immobilier.jpg') }}"
                            alt="Études hydrogéologiques OXFAM & UNICEF"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-110"
                            loading="lazy"
                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; display: block;">
                        <div class="absolute top-4 right-4 bg-white text-gray-800 px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg"
                            style="position: absolute; top: 16px; right: 16px; background-color: rgb(255, 255, 255); color: rgb(31, 41, 55); padding: 6px 16px; border-radius: 9999px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                            2025
                        </div>
                    </div>
                    <div class="p-6" style="padding: 24px;">
                        <div class="mb-4" style="margin-bottom: 16px; display: flex; flex-wrap: wrap; gap: 8px;">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-sm font-semibold"
                                style="background-color: rgb(239, 246, 255); color: rgb(29, 78, 216); padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-block;">
                                Hydrogéologie
                            </span>
                            <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-semibold"
                                style="background-color: rgb(220, 252, 231); color: rgb(5, 150, 105); padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-block;">
                                OXFAM & UNICEF
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-3"
                            style="font-size: 20px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; letter-spacing: -0.3px;">
                            Études hydrogéologiques - Programmes d'urgence
                        </h3>
                        <p class="text-gray-600 mb-2"
                            style="font-size: 14px; font-weight: 600; color: rgb(107, 114, 128);">
                            Bria / Batangafo
                        </p>
                        <p class="text-gray-600" style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px;">
                            Mobilisation des eaux souterraines, tarification de l'eau, rentabilité AEP et enquêtes
                            socio-économiques.
                        </p>
                    </div>
                </a>

                <!-- Project 2 -->
                <a href="/services#environnement"
                    class="block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100"
                    style="display: block; background-color: rgb(255, 255, 255); border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.3s ease; text-decoration: none; color: inherit; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                    <div class="relative overflow-hidden"
                        style="position: relative; overflow: hidden; height: 260px; background-color: #f3f4f6;">
                        <img src="{{ asset('Image/City Apartment Bangui..jpg') }}"
                            alt="CGES & PGES - Aire de Conservation de Chinko"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-110"
                            loading="lazy"
                            style="width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform 0.3s ease; display: block;">
                        <div class="absolute top-4 right-4 bg-white text-gray-800 px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg"
                            style="position: absolute; top: 16px; right: 16px; background-color: rgb(255, 255, 255); color: rgb(31, 41, 55); padding: 6px 16px; border-radius: 9999px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                            2024
                        </div>
                    </div>
                    <div class="p-6" style="padding: 24px;">
                        <div class="mb-4" style="margin-bottom: 16px; display: flex; flex-wrap: wrap; gap: 8px;">
                            <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-semibold"
                                style="background-color: rgb(220, 252, 231); color: rgb(5, 150, 105); padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-block;">
                                Environnement
                            </span>
                            <span class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-sm font-semibold"
                                style="background-color: rgb(239, 246, 255); color: rgb(29, 78, 216); padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-block;">
                                African Parks / USAID
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-3"
                            style="font-size: 20px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; letter-spacing: -0.3px;">
                            CGES & PGES - Aire de Conservation de Chinko
                        </h3>
                        <p class="text-gray-600 mb-2"
                            style="font-size: 14px; font-weight: 600; color: rgb(107, 114, 128);">
                            Chinko, RCA
                        </p>
                        <p class="text-gray-600" style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px;">
                            Élaboration du Cadre de Gestion Environnementale et Sociale et du PGES pour l'Aire de
                            Conservation.
                        </p>
                    </div>
                </a>

                <!-- Project 3 -->
                <a href="/services#environnement"
                    class="block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100"
                    style="display: block; background-color: rgb(255, 255, 255); border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.3s ease; text-decoration: none; color: inherit; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                    <div class="relative overflow-hidden"
                        style="position: relative; overflow: hidden; height: 260px; background-color: #f3f4f6;">
                        <img src="{{ asset('Image/Exploitation Rivière Sangha.jpg') }}"
                            alt="EIES - Projet de réduction de la vulnérabilité climatique"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-110"
                            loading="lazy"
                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; display: block;">
                        <div class="absolute top-4 right-4 bg-white text-gray-800 px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg"
                            style="position: absolute; top: 16px; right: 16px; background-color: rgb(255, 255, 255); color: rgb(31, 41, 55); padding: 6px 16px; border-radius: 9999px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                            2022
                        </div>
                    </div>
                    <div class="p-6" style="padding: 24px;">
                        <div class="mb-4" style="margin-bottom: 16px; display: flex; flex-wrap: wrap; gap: 8px;">
                            <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-semibold"
                                style="background-color: rgb(220, 252, 231); color: rgb(5, 150, 105); padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-block;">
                                Environnement
                            </span>
                            <span class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-sm font-semibold"
                                style="background-color: rgb(239, 246, 255); color: rgb(29, 78, 216); padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; display: inline-block;">
                                Ministère de l'Énergie / BAD
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-3"
                            style="font-size: 20px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px; letter-spacing: -0.3px;">
                            EIES - Projet de réduction de la vulnérabilité climatique
                        </h3>
                        <p class="text-gray-600 mb-2"
                            style="font-size: 14px; font-weight: 600; color: rgb(107, 114, 128);">
                            République Centrafricaine
                        </p>
                        <p class="text-gray-600" style="font-size: 15px; color: rgb(75, 85, 99); line-height: 24px;">
                            EIES du Projet de Réduction de la Vulnérabilité face aux changements climatiques
                            (PCRVP-FCAE).
                        </p>
                    </div>
                </a>
            </div>

            <!-- Button -->
            <div class="text-center mt-12" style="text-align: center; margin-top: 48px;">
                <a href="/realisations"
                    class="inline-flex items-center gap-2 px-8 py-3.5 text-green-600 font-semibold rounded-xl border-2 border-green-600 hover:bg-green-600 hover:text-white transition-all duration-200"
                    style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; color: rgb(5, 150, 105); font-size: 16px; font-weight: 600; background-color: transparent; border: 2px solid rgb(5, 150, 105) !important; border-radius: 12px; transition: all 0.2s ease; text-decoration: none;">
                    <span>Voir toutes nos réalisations</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        style="width: 20px; height: 20px;">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Notre approche Section - Enhanced Design -->
    <section class="w-full bg-gray-100 px-4 sm:px-6 lg:px-8"
        style="padding: 32px 0; margin: 0; background-color: #f9fafb !important;">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8" style="text-align: center; margin-bottom: 32px;">
                <h2 class="text-4xl font-bold text-black mb-3"
                    style="font-size: 40px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; text-align: center;">
                    Notre approche
                </h2>
                <p class="text-lg text-gray-600 mx-auto"
                    style="font-size: 18px; color: #6b7280; max-width: 700px; margin: 0 auto; text-align: center;">
                    Une méthodologie éprouvée pour garantir le succès de vos projets
                </p>
            </div>

            <!-- Steps Grid - 4 steps -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 approach-grid-container"
                style="position: relative;">
                <!-- Step 1: Analyse & Diagnostic -->
                <div class="text-center"
                    style="text-align: center; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2;">
                    <!-- Connecting Line -->
                    <div class="step-connector"></div>
                    <!-- Number Badge -->
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 text-2xl font-bold mb-2"
                        style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 9999px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 auto 8px; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); position: relative; z-index: 3;">
                        01
                    </div>
                    <!-- Title -->
                    <h3 class="text-xl font-bold mb-1.5"
                        style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin: 0 auto 6px; line-height: 28px; text-align: center; width: 100%;">
                        Analyse & Diagnostic
                    </h3>
                    <!-- Description -->
                    <p class="text-gray-600"
                        style="font-size: 15px; color: rgb(107, 114, 128); line-height: 22px; margin: 0 auto; text-align: center; max-width: 100%;">
                        Étude approfondie du projet et évaluation des enjeux environnementaux et sociaux
                    </p>
                </div>

                <!-- Step 2: Méthodologie adaptée -->
                <div class="text-center"
                    style="text-align: center; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2;">
                    <!-- Connecting Line -->
                    <div class="step-connector"></div>
                    <!-- Number Badge -->
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 text-2xl font-bold mb-2"
                        style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 9999px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 auto 8px; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); position: relative; z-index: 3;">
                        02
                    </div>
                    <!-- Title -->
                    <h3 class="text-xl font-bold mb-1.5"
                        style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin: 0 auto 6px; line-height: 28px; text-align: center; width: 100%;">
                        Méthodologie adaptée
                    </h3>
                    <!-- Description -->
                    <p class="text-gray-600"
                        style="font-size: 15px; color: rgb(107, 114, 128); line-height: 22px; margin: 0 auto; text-align: center; max-width: 100%;">
                        Conception d'une approche sur-mesure conforme aux normes nationales et internationales
                    </p>
                </div>

                <!-- Step 3: Études de terrain -->
                <div class="text-center"
                    style="text-align: center; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2;">
                    <!-- Connecting Line -->
                    <div class="step-connector"></div>
                    <!-- Number Badge -->
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 text-2xl font-bold mb-2"
                        style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 9999px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 auto 8px; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); position: relative; z-index: 3;">
                        03
                    </div>
                    <!-- Title -->
                    <h3 class="text-xl font-bold mb-1.5"
                        style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin: 0 auto 6px; line-height: 28px; text-align: center; width: 100%;">
                        Études de terrain
                    </h3>
                    <!-- Description -->
                    <p class="text-gray-600"
                        style="font-size: 15px; color: rgb(107, 114, 128); line-height: 22px; margin: 0 auto; text-align: center; max-width: 100%;">
                        Collecte de données, consultations publiques et investigations techniques
                    </p>
                </div>

                <!-- Step 4: Rapports & Validation -->
                <div class="text-center"
                    style="text-align: center; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2;">
                    <!-- Number Badge -->
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 text-2xl font-bold mb-2"
                        style="display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 9999px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 auto 8px; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25); position: relative; z-index: 3;">
                        04
                    </div>
                    <!-- Title -->
                    <h3 class="text-xl font-bold mb-1.5"
                        style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin: 0 auto 6px; line-height: 28px; text-align: center; width: 100%;">
                        Rapports & Validation
                    </h3>
                    <!-- Description -->
                    <p class="text-gray-600"
                        style="font-size: 15px; color: rgb(107, 114, 128); line-height: 22px; margin: 0 auto; text-align: center; max-width: 100%;">
                        Rédaction de rapports détaillés et accompagnement jusqu'à la validation officielle
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Besoin d'une étude de terrain ? Section -->
    <section class="w-full px-4 sm:px-6 lg:px-8"
        style="padding: 80px 0; margin: 0; background: linear-gradient(180deg, rgb(15, 64, 62) 0%, rgb(22, 78, 75) 50%, rgb(25, 85, 82) 100%);">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-white mb-4"
                style="font-size: 40px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 16px; text-align: center;">
                Besoin d'une étude de terrain ?
            </h2>
            <p class="text-xl text-white mb-8"
                style="font-size: 20px; color: rgb(255, 255, 255); margin-bottom: 32px; text-align: center; line-height: 30px;">
                Experts dans la promotion d'une gestion durable des ressources géologiques, minières et<br>
                naturelles de la Centrafrique
            </p>
            <div class="flex justify-center" style="display: flex; justify-content: center;">
                <a href="/contact"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-white text-black rounded-xl font-semibold shadow-lg transition-transform hover:scale-105 active:scale-95"
                    style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 32px; background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); border-radius: 12px; font-size: 16px; font-weight: 600; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); text-decoration: none; cursor: pointer;">
                    <span>Contactez-nous</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        style="width: 20px; height: 20px;">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <x-site-footer />

    @include('partials.site-scripts')

</body>

</html>
