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
                    visibility: visible !important;
                    opacity: 1 !important;
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
                    border: 2px solid rgba(55, 65, 81, 0.2);
                    border-radius: 8px;
                    cursor: pointer;
                    padding: 0;
                    z-index: 1001;
                    position: relative;
                    visibility: visible !important;
                    opacity: 1 !important;
                    gap: 5px;
                }
                
                .mobile-menu-button span {
                    width: 24px;
                    height: 3px;
                    background-color: rgb(55, 65, 81);
                    border-radius: 2px;
                    transition: all 0.3s ease;
                    display: block;
                    position: relative;
                }
                
                /* Améliorer la visibilité du bouton hamburger */
                .mobile-menu-button:hover {
                    border-color: rgb(5, 150, 105);
                    background-color: rgba(5, 150, 105, 0.05);
                }
                
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
                
                /* Sections mobile - Style site de référence */
                section {
                    padding-left: 24px !important;
                    padding-right: 24px !important;
                    padding-top: 48px !important;
                    padding-bottom: 48px !important;
                }
                
                /* Hero section mobile - Style selon image */
                .hero-section {
                    padding-top: 0 !important;
                    padding-bottom: 0 !important;
                    min-height: 100vh !important;
                    position: relative !important;
                    overflow: hidden !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                }
                
                /* Image de fond Hero mobile - Style selon site de référence */
                .hero-section > div[style*="background: linear-gradient(to right bottom"] {
                    position: absolute !important;
                    top: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    bottom: 0 !important;
                    width: 100% !important;
                    height: 100% !important;
                }
                
                .hero-section img[alt="Bannière CEGME"] {
                    width: 100% !important;
                    height: 100% !important;
                    object-fit: cover !important;
                    object-position: center center !important;
                    position: absolute !important;
                    top: 0 !important;
                    left: 0 !important;
                    z-index: 1 !important;
                    opacity: 0.4 !important;
                }
                
                /* Overlay gradient sur l'image */
                .hero-section > div[style*="background: linear-gradient(to right bottom"] > div[style*="background: linear-gradient"] {
                    position: absolute !important;
                    top: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    bottom: 0 !important;
                    z-index: 2 !important;
                }
                
                /* Conteneur de contenu - Pixel perfect site de référence */
                .hero-section > div[style*="padding-top: 120px"] {
                    padding-top: 80px !important;
                    padding-bottom: 0 !important;
                    padding-left: 24px !important;
                    padding-right: 24px !important;
                    min-height: 100vh !important;
                    position: relative !important;
                    z-index: 10 !important;
                    display: flex !important;
                    flex-direction: column !important;
                    align-items: center !important;
                    justify-content: flex-start !important;
                    text-align: center !important;
                    width: 100% !important;
                    max-width: 100% !important;
                }
                
                /* Largeur des éléments pour correspondre exactement */
                .hero-section > div[style*="padding-top: 120px"] > .hero-title,
                .hero-section > div[style*="padding-top: 120px"] > .hero-description,
                .hero-section > div[style*="padding-top: 120px"] > .hero-buttons {
                    max-width: 344px !important;
                    width: 100% !important;
                }
                
                .hero-section > div[style*="padding-top: 120px"] > .inline-block {
                    max-width: none !important;
                    width: auto !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                    display: inline-block !important;
                    position: relative !important;
                    z-index: 20 !important;
                }
                
                /* Badge Hero mobile - Pixel perfect site de référence */
                .hero-section .inline-block {
                    padding: 14px 36px !important;
                    font-size: 18px !important;
                    margin-bottom: 33px !important;
                    margin-top: 40px !important;
                    background-color: rgba(16, 185, 129, 0.3) !important;
                    border: 1px solid rgb(5, 150, 105) !important;
                    border-radius: 9999px !important;
                    width: auto !important;
                    max-width: 85% !important;
                    display: inline-block !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                    position: relative !important;
                    z-index: 20 !important;
                }
                
                .hero-section .inline-block p {
                    font-size: 18px !important;
                    line-height: 28px !important;
                    color: rgb(110, 231, 183) !important;
                    font-weight: 500 !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                    display: block !important;
                }
                
                /* Titre Hero mobile - Pixel perfect site de référence */
                .hero-title {
                    font-size: 48px !important;
                    line-height: 60px !important;
                    padding: 0 !important;
                    margin-bottom: 24px !important;
                    margin-top: 0 !important;
                    font-weight: 700 !important;
                    width: 344px !important;
                    max-width: 100% !important;
                    color: rgb(255, 255, 255) !important;
                }
                
                .hero-title span {
                    display: block !important;
                    margin-bottom: 0 !important;
                    font-size: 48px !important;
                    line-height: 60px !important;
                    font-weight: 700 !important;
                }
                
                .hero-title span.text-white {
                    font-size: 48px !important;
                    line-height: 60px !important;
                    color: rgb(255, 255, 255) !important;
                }
                
                .hero-title span[style*="color: rgb(20, 184, 166)"] {
                    font-size: 48px !important;
                    line-height: 60px !important;
                    background: linear-gradient(to right, rgb(52, 211, 153), rgb(45, 212, 191)) !important;
                    -webkit-background-clip: text !important;
                    -webkit-text-fill-color: transparent !important;
                    background-clip: text !important;
                    color: transparent !important;
                }
                
                /* Description Hero mobile - Pixel perfect site de référence */
                .hero-description {
                    font-size: 20px !important;
                    line-height: 32.5px !important;
                    padding: 0 !important;
                    margin-bottom: 40px !important;
                    margin-top: 0 !important;
                    color: rgb(229, 231, 235) !important;
                    max-width: 768px !important;
                    width: 344px !important;
                    font-weight: 400 !important;
                }
                
                /* Boutons Hero mobile - Pixel perfect site de référence */
                .hero-buttons {
                    display: flex !important;
                    flex-direction: column !important;
                    gap: 16px !important;
                    padding: 0 !important;
                    margin-top: 0 !important;
                    width: 100% !important;
                    max-width: 100% !important;
                    align-items: stretch !important;
                    justify-content: center !important;
                    margin-left: 0 !important;
                    margin-right: 0 !important;
                }
                
                .hero-buttons a {
                    width: 100% !important;
                    max-width: 100% !important;
                    padding: 24px 32px !important;
                    font-size: 18px !important;
                    line-height: 28px !important;
                    text-align: center !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    height: 48px !important;
                    min-height: 48px !important;
                    border-radius: 9999px !important;
                    background-color: rgb(5, 150, 105) !important;
                    color: rgb(255, 255, 255) !important;
                    font-weight: 500 !important;
                    gap: 8px !important;
                    flex-shrink: 0 !important;
                    box-sizing: border-box !important;
                }
                
                .hero-buttons > span {
                    width: 100% !important;
                    max-width: 100% !important;
                    padding: 24px 32px !important;
                    font-size: 18px !important;
                    line-height: 28px !important;
                    text-align: center !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    height: 52px !important;
                    min-height: 52px !important;
                    border-radius: 9999px !important;
                    background-color: rgba(255, 255, 255, 0.1) !important;
                    border: 2px solid rgb(255, 255, 255) !important;
                    color: rgb(255, 255, 255) !important;
                    font-weight: 500 !important;
                    gap: 8px !important;
                    flex-shrink: 0 !important;
                    box-sizing: border-box !important;
                }
                
                .hero-buttons a svg {
                    width: 20px !important;
                    height: 20px !important;
                    stroke-width: 2.5 !important;
                }
                
                /* Statistiques mobile - Style site de référence */
                .stats-grid,
                .grid.grid-cols-1.md\\:grid-cols-4,
                div[style*="grid-template-columns: repeat(4"] {
                    grid-template-columns: 1fr !important;
                    gap: 20px !important;
                    padding: 0 24px !important;
                }
                
                /* Statistiques - réduire taille des icônes et textes */
                .stats-grid > div {
                    padding: 20px !important;
                }
                
                .stats-grid .text-4xl,
                .stats-grid .text-5xl {
                    font-size: 32px !important;
                }
                
                .stats-grid .text-xl {
                    font-size: 16px !important;
                }
                
                /* Cartes mobile - empiler verticalement */
                .card-grid,
                .grid.grid-cols-1.md\\:grid-cols-2,
                .grid.grid-cols-1.md\\:grid-cols-3 {
                    grid-template-columns: 1fr !important;
                    gap: 20px !important;
                }
                
                /* Titres de sections mobile */
                h2 {
                    font-size: 28px !important;
                    line-height: 36px !important;
                    margin-bottom: 16px !important;
                    padding: 0 16px !important;
                }
                
                /* Textes descriptifs mobile */
                p.text-lg,
                p.text-xl {
                    font-size: 16px !important;
                    line-height: 24px !important;
                    padding: 0 16px !important;
                }
                
                /* Styles Hero déjà définis plus haut - suppression dupliqués */
                
                /* Badge Hero mobile */
                .hero-section .inline-block {
                    padding: 6px 16px !important;
                    font-size: 14px !important;
                    margin-bottom: 16px !important;
                }
                
                /* Description Hero mobile */
                .hero-description {
                    font-size: 16px !important;
                    line-height: 24px !important;
                    padding: 0 16px !important;
                    margin-bottom: 24px !important;
                }
                
                /* Images mobile */
                img {
                    max-width: 100% !important;
                    height: auto !important;
                }
                
                /* Boutons mobile - taille tactile */
                button,
                a[class*="button"],
                a[class*="btn"] {
                    min-height: 44px !important;
                    padding: 12px 20px !important;
                    font-size: 16px !important;
                }
                
                /* Footer mobile */
                footer {
                    padding: 40px 24px 24px !important;
                }
                
                footer .grid {
                    grid-template-columns: 1fr !important;
                    gap: 32px !important;
                }
                
                footer h3 {
                    font-size: 18px !important;
                    margin-bottom: 16px !important;
                }
                
                /* About section mobile - empiler image et texte */
                .grid.grid-cols-1.lg\\:grid-cols-2,
                section[style*="background: linear-gradient(to bottom, #ffffff"] .grid {
                    grid-template-columns: 1fr !important;
                    gap: 32px !important;
                    align-items: flex-start !important;
                }
                
                /* Section "L'Expertise au Service de l'Émergence" mobile - Style site de référence */
                section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] {
                    padding: 48px 24px !important;
                }
                
                /* Image dans section About mobile */
                section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] .relative.w-full {
                    order: 1 !important;
                    width: 100% !important;
                    margin-bottom: 24px !important;
                }
                
                section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] img[alt="Équipe CEGME"] {
                    width: 100% !important;
                    height: auto !important;
                    min-height: 300px !important;
                    max-height: 400px !important;
                    object-fit: cover !important;
                    object-position: center !important;
                }
                
                /* Grid mobile pour section About */
                section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] .grid {
                    grid-template-columns: 1fr !important;
                    gap: 32px !important;
                }
                
                section[style*="background: linear-gradient(to bottom, #ffffff"] div[style*="min-height: 550px"] {
                    min-height: 300px !important;
                    max-height: 400px !important;
                }
                
                /* Texte dans section About mobile */
                section[style*="background: linear-gradient(to bottom, #ffffff"] .w-full:not(.relative) {
                    order: 2 !important;
                    width: 100% !important;
                    padding: 0 !important;
                }
                
                section[style*="background: linear-gradient(to bottom, #ffffff"] h2 {
                    font-size: 26px !important;
                    line-height: 34px !important;
                    margin-bottom: 16px !important;
                    padding: 0 !important;
                }
                
                section[style*="background: linear-gradient(to bottom, #ffffff"] p {
                    font-size: 15px !important;
                    line-height: 24px !important;
                    margin-bottom: 16px !important;
                    padding: 0 !important;
                }
                
                section[style*="background: linear-gradient(to bottom, #ffffff"] .space-y-6 {
                    gap: 16px !important;
                }
                
                /* Projets récents mobile */
                .project-card,
                a[href="/services"] {
                    margin-bottom: 24px !important;
                    width: 100% !important;
                }
                
                /* Images de projets mobile */
                .project-card img,
                a[href="/services"] img {
                    height: 200px !important;
                    object-fit: cover !important;
                }
                
                /* Logos partenaires mobile */
                .flex.flex-wrap {
                    justify-content: center !important;
                    gap: 12px !important;
                    padding: 0 16px !important;
                }
                
                /* Cartes de logos partenaires mobile */
                .flex.flex-wrap > div {
                    min-width: 120px !important;
                    min-height: 100px !important;
                    padding: 16px !important;
                }
                
                .flex.flex-wrap img {
                    max-height: 50px !important;
                }
                
                /* Mot de la direction mobile */
                .max-w-3xl {
                    max-width: 100% !important;
                    padding: 0 16px !important;
                }
                
                /* Espacement général mobile */
                .mb-16,
                .mb-12 {
                    margin-bottom: 24px !important;
                }
                
                .gap-12,
                .gap-16 {
                    gap: 24px !important;
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
    </head>
    <body class="bg-white text-[#1b1b18] min-h-screen" style="background-color: #ffffff !important;">
        <header class="w-full bg-white sticky top-0 z-50" style="position: fixed; top: 0; left: 0; right: 0; width: 100%; z-index: 1000; background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
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
                    
                    <!-- Desktop Menu -->
                    <nav class="py-4 flex items-center justify-between gap-4 flex-wrap desktop-menu">
                        <div class="flex items-center gap-4 flex-wrap" style="margin-left: -24px;">
                            <a href="/" class="flex items-center gap-3 shrink-0" style="text-decoration: none; color: inherit;">
                                <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" class="block h-16 w-auto" style="height: 64px; width: auto; object-fit: contain;">
                                <div class="flex flex-col" style="display: flex; flex-direction: column;">
                                    <span class="font-bold" style="font-size: 20px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1.2;">CEGME</span>
                                    <span class="text-sm text-gray-600" style="font-size: 13px; color: rgb(75, 85, 99); line-height: 1.2; margin-top: 2px;">Géosciences • Mines • Environnement</span>
                                </div>
                            </a>
                        </div>
                        <div class="flex items-center gap-4 flex-wrap desktop-menu" style="margin-right: -32px;">
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
                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2 text-white font-medium transition-all duration-200 hover:opacity-90 rounded-full desktop-login-button"
                            style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); padding: 8px 18px; font-size: 14px; border-radius: 8px; flex-shrink: 0; white-space: nowrap;"
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
        <!-- Hero Section - Exact Reproduction from Site -->
        <section class="hero-section relative w-full flex items-center justify-center overflow-hidden" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; min-height: 100vh; padding: 0;">
            <!-- Background Image with Greenish-Blue Overlay -->
            <div class="absolute inset-0" style="background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42)); z-index: 1;">
                <!-- Background Image -->
                <img src="{{ asset('Image/IIMG_Banniere.jpg') }}" alt="Bannière CEGME" class="absolute inset-0 w-full h-full object-cover" loading="eager" style="z-index: 1; opacity: 0.4;">
                <!-- Gradient overlay filter mixed with image -->
                <div class="absolute inset-0" style="background: linear-gradient(to right bottom, rgba(6, 78, 59, 0.75), rgba(17, 94, 89, 0.75), rgba(15, 23, 42, 0.75)); z-index: 2;"></div>
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
                <h1 class="hero-title mb-6 text-center" style="font-size: 84px; font-weight: 700; line-height: 84px; margin-bottom: 24px; margin-top: 40px; color: #ffffff;">
                    <span class="block text-white">Expertise en Géosciences,</span>
                    <span class="block text-center" style="background: linear-gradient(to right, rgb(52, 211, 153), rgb(45, 212, 191)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent; text-align: center;">Mines & Environnement</span>
                </h1>
                
                <!-- Descriptive Paragraph - Exact from Site -->
                <p class="hero-description mb-10 mx-auto text-center" style="font-size: 20px; color: rgb(229, 231, 235); line-height: 32.5px; margin-bottom: 24px; max-width: 768px; text-align: center; display: block; margin-left: auto; margin-right: auto;">
                    CEGME accompagne vos projets en République Centrafricaine avec une approche durable et responsable
                </p>
                
                <!-- Call-to-Action Buttons - Exact from Site -->
                <div class="hero-buttons flex flex-row items-center justify-center" style="gap: 20px; margin-top: 20px;">
                    <!-- Nos Services Button - Exact from Site -->
                    <a href="/services" class="inline-flex items-center justify-center gap-2 px-8 py-2 text-white font-medium transition-all duration-200 hover:opacity-90" style="background-color: rgb(5, 150, 105); border-radius: 9999px; padding: 10px 32px; font-size: 18px;">
                        <span>Nos Services</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; stroke-width: 2.5;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                    
                    <!-- Nous Contacter Button - Exact from Site -->
                    <span class="inline-flex items-center justify-center px-8 py-2 text-white font-medium" style="background-color: rgba(55, 65, 81, 0.8) !important; border: 2px solid rgb(255, 255, 255) !important; border-radius: 9999px; padding: 10px 32px; font-size: 18px; cursor: default; pointer-events: none;">
                        <span>Nous Contacter</span>
                    </span>
                </div>
            </div>
        </section>
        
        <!-- About Section - Before Statistics -->
        <section class="w-full" style="padding: 100px 0; margin: 0; background: linear-gradient(to bottom, rgb(248, 250, 252), rgb(255, 255, 255));">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 64px; align-items: stretch;">
                    <!-- Image à gauche -->
                    <div class="relative w-full flex items-stretch" style="position: relative; width: 100%; display: flex; align-items: stretch;">
                        <div class="absolute -inset-4 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl opacity-20 blur-xl" style="position: absolute; top: -16px; right: -16px; bottom: -16px; left: -16px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.3) 0%, rgba(5, 150, 105, 0.3) 100%); border-radius: 16px; opacity: 0.2; filter: blur(20px); z-index: 0;"></div>
                        <div class="relative overflow-hidden rounded-2xl shadow-2xl w-full" style="position: relative; overflow: hidden; border-radius: 16px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03); z-index: 1; width: 100%; height: 100%; min-height: 550px;">
                            <img src="{{ asset('Image/Personnel.jpg') }}" alt="Équipe CEGME" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105" style="width: 100%; height: 100%; min-height: 550px; object-fit: cover; transition: transform 0.7s ease; display: block;">
                        </div>
                    </div>
                    
                    <!-- Texte à droite -->
                    <div class="w-full" style="width: 100%;">
                        <h2 class="text-4xl font-bold mb-6 leading-tight" style="font-size: 42px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 24px; line-height: 1.2; letter-spacing: -0.5px;">
                            L'Expertise au Service de l'Émergence
                        </h2>
                        
                        <!-- Ligne décorative -->
                        <div class="w-20 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mb-8" style="width: 80px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin-bottom: 32px;"></div>
                        
                        <div class="space-y-6" style="display: flex; flex-direction: column; gap: 24px;">
                            <p class="text-lg text-gray-700 leading-relaxed" style="font-size: 17px; color: rgb(55, 65, 81); line-height: 32px; margin: 0; font-weight: 400;">
                                Le <strong style="font-weight: 700; color: rgb(17, 24, 39);">Cabinet d'Études Géologiques, Minières et Environnementales (CEGME) Sarl.</strong>, est le partenaire de référence pour la conception et la concrétisation de projets stratégiques en République Centrafricaine (RCA) et en Afrique Centrale. Spécialisé dans les géosciences, les mines et le développement durable, le cabinet transforme les enjeux complexes en leviers de croissance responsable pour les investisseurs et les institutions.
                            </p>
                            <p class="text-lg text-gray-700 leading-relaxed" style="font-size: 17px; color: rgb(55, 65, 81); line-height: 32px; margin: 0; font-weight: 400;">
                                Enregistré sous le numéro <strong style="font-weight: 700; color: rgb(17, 24, 39);">N°RCCM : CA/BG/2015B541</strong>, le CEGME est une structure multidisciplinaire agréée et accréditée par le Ministère de l'Environnement et du Développement Durable (<strong style="font-weight: 700; color: rgb(17, 24, 39);">N°004/MEEDD/DIR.CAB_21</strong> et <strong style="font-weight: 700; color: rgb(17, 24, 39);">N°29/MEEDD/DIR.CAB</strong>).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Statistics Section - Enhanced Professional Design -->
        <section class="w-full bg-white" style="padding: 40px 0; margin: 0; background-color: #ffffff !important;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding: 0; margin: 0;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 20px; padding: 0; margin: 0;">
                    <!-- Card 1: Missions stratégiques -->
                    <div class="text-center" style="text-align: center; padding: 0;">
                        <!-- Icon Container -->
                        <div class="mb-4 mx-auto" style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; padding: 0; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; color: #ffffff;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="6"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg>
                        </div>
                        <!-- Number -->
                        <div style="font-size: 38px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 42px; margin-bottom: 6px; margin-top: 0; letter-spacing: -1.5px;">
                            70+
                        </div>
                        <!-- Title -->
                        <h3 style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px; line-height: 22px; letter-spacing: -0.2px;">
                            Missions stratégiques
                        </h3>
                        <!-- Description -->
                        <p style="font-size: 13px; color: rgb(107, 114, 128); line-height: 18px; margin-top: 0; max-width: 100%;">
                            réalisées depuis 2011
                        </p>
                    </div>

                    <!-- Card 2: EIES & Audits -->
                    <div class="text-center" style="text-align: center; padding: 0;">
                        <!-- Icon Container -->
                        <div class="mb-4 mx-auto" style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; padding: 0; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; color: #ffffff;">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="9" y1="15" x2="15" y2="15"></line>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                        </div>
                        <!-- Number -->
                        <div style="font-size: 38px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 42px; margin-bottom: 6px; margin-top: 0; letter-spacing: -1.5px;">
                            45+
                        </div>
                        <!-- Title -->
                        <h3 style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px; line-height: 22px; letter-spacing: -0.2px;">
                            EIES & Audits
                        </h3>
                        <!-- Description -->
                        <p style="font-size: 13px; color: rgb(107, 114, 128); line-height: 18px; margin-top: 0; max-width: 100%;">
                            validés officiellement
                        </p>
                    </div>

                    <!-- Card 3: Études de faisabilité -->
                    <div class="text-center" style="text-align: center; padding: 0;">
                        <!-- Icon Container -->
                        <div class="mb-4 mx-auto" style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; padding: 0; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; color: #ffffff;">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                        </div>
                        <!-- Number -->
                        <div style="font-size: 38px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 42px; margin-bottom: 6px; margin-top: 0; letter-spacing: -1.5px;">
                            10+
                        </div>
                        <!-- Title -->
                        <h3 style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px; line-height: 22px; letter-spacing: -0.2px;">
                            Études de faisabilité
                        </h3>
                        <!-- Description -->
                        <p style="font-size: 13px; color: rgb(107, 114, 128); line-height: 18px; margin-top: 0; max-width: 100%;">
                            pour le secteur minier
                        </p>
                    </div>

                    <!-- Card 4: Années d'expertise -->
                    <div class="text-center" style="text-align: center; padding: 0;">
                        <!-- Icon Container -->
                        <div class="mb-4 mx-auto" style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; padding: 0; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 12px rgba(16, 185, 129, 0.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; color: #ffffff;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <!-- Number -->
                        <div style="font-size: 38px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 42px; margin-bottom: 6px; margin-top: 0; letter-spacing: -1.5px;">
                            10+
                        </div>
                        <!-- Title -->
                        <h3 style="font-size: 16px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 6px; line-height: 22px; letter-spacing: -0.2px;">
                            Années d'expertise
                        </h3>
                        <!-- Description -->
                        <p style="font-size: 13px; color: rgb(107, 114, 128); line-height: 18px; margin-top: 0; max-width: 100%;">
                            depuis 2014
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Identité et Synergies Scientifiques Section -->
        <section class="w-full bg-gray-100" style="padding: 60px 0; margin: 0; background-color: #f3f4f6 !important;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Titre avec ligne décorative -->
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                    <h2 class="text-4xl font-bold mb-4" style="font-size: 40px; font-weight: 800; color: rgb(17, 24, 39); text-align: center; margin-bottom: 16px; line-height: 48px; letter-spacing: -0.5px;">
                        Identité et Synergies Scientifiques
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto" style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto;"></div>
                </div>
                
                <!-- Deux colonnes -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 32px;">
                    <!-- Colonne gauche: Une Résilience Entrepreneuriale -->
                    <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2" style="background-color: #ffffff; border-radius: 16px; padding: 40px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08); border: 1px solid rgb(243, 244, 246); transition: all 0.3s ease; cursor: default; position: relative; overflow: hidden;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full -mr-16 -mt-16 opacity-50" style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                            <div class="flex flex-col" style="display: flex; flex-direction: column;">
                                <!-- Icône verte -->
                                <div class="mb-6" style="margin-bottom: 24px;">
                                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-lg" style="width: 80px; height: 80px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <!-- Contenu -->
                                <div>
                                    <h3 class="text-2xl font-bold mb-5" style="font-size: 26px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 20px; line-height: 34px;">
                                        Une Résilience Entrepreneuriale
                                    </h3>
                                    <p class="text-gray-700 leading-relaxed" style="font-size: 17px; color: rgb(55, 65, 81); line-height: 30px; margin: 0;">
                                        Né en 2014 au coeur d'une période de défis majeurs pour la RCA, le CEGME est passé d'un collectif d'experts nationaux à une SARL de conseil reconnue à l'échelle régionale. Le cabinet emploie aujourd'hui une équipe multidisciplinaire (enseignants-chercheurs, ingénieurs, chargés de mission) capable d'intervenir sur toute la chaîne de valeur des ressources naturelles.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Colonne droite: Un Socle Académique et International -->
                    <div class="bg-white rounded-2xl p-10 shadow-xl border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2" style="background-color: #ffffff; border-radius: 16px; padding: 40px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08); border: 1px solid rgb(243, 244, 246); transition: all 0.3s ease; cursor: default; position: relative; overflow: hidden;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 opacity-50" style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(239, 246, 255); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                            <div class="flex flex-col" style="display: flex; flex-direction: column;">
                                <!-- Icône bleue -->
                                <div class="mb-6" style="margin-bottom: 24px;">
                                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg" style="width: 80px; height: 80px; border-radius: 16px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                </div>
                                <!-- Contenu -->
                                <div>
                                    <h3 class="text-2xl font-bold mb-5" style="font-size: 26px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 20px; line-height: 34px;">
                                        Un Socle Académique et International
                                    </h3>
                                    <p class="text-gray-700 leading-relaxed mb-6" style="font-size: 17px; color: rgb(55, 65, 81); line-height: 30px; margin: 0 0 24px 0;">
                                        Pour garantir une approche fondée sur l'innovation, le CEGME maintient des collaborations organiques :
                                    </p>
                                    <ul class="space-y-4" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px;">
                                        <li class="flex items-start gap-4" style="display: flex; align-items: flex-start; gap: 16px;">
                                            <div class="flex-shrink-0 mt-1" style="flex-shrink: 0; margin-top: 4px;">
                                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center" style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px; color: rgb(16, 185, 129);">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span class="text-gray-700 flex-1" style="font-size: 17px; color: rgb(55, 65, 81); line-height: 30px; flex: 1;">
                                                <strong style="font-weight: 700; color: rgb(17, 24, 39);">Partenariats universitaires :</strong> Collaboration avec les laboratoires de l'Université de Bangui (Laboratoire Lavoisier Hydro-sciences, Cartographie).
                                            </span>
                                        </li>
                                        <li class="flex items-start gap-4" style="display: flex; align-items: flex-start; gap: 16px;">
                                            <div class="flex-shrink-0 mt-1" style="flex-shrink: 0; margin-top: 4px;">
                                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center" style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px; color: rgb(16, 185, 129);">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span class="text-gray-700 flex-1" style="font-size: 17px; color: rgb(55, 65, 81); line-height: 30px; flex: 1;">
                                                <strong style="font-weight: 700; color: rgb(17, 24, 39);">Alliance avec le SDGM (Chine) :</strong> Partenariat avec le Shandong Institute of Geophysical and Geochemical Exploration pour l'exploration géophysique et géochimique de haute technologie.
                                            </span>
                                        </li>
                                        <li class="flex items-start gap-4" style="display: flex; align-items: flex-start; gap: 16px;">
                                            <div class="flex-shrink-0 mt-1" style="flex-shrink: 0; margin-top: 4px;">
                                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center" style="width: 24px; height: 24px; border-radius: 50%; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px; color: rgb(16, 185, 129);">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span class="text-gray-700 flex-1" style="font-size: 17px; color: rgb(55, 65, 81); line-height: 30px; flex: 1;">
                                                <strong style="font-weight: 700; color: rgb(17, 24, 39);">Réseaux mondiaux :</strong> Collaboration Sud-Sud avec Seve-Consulting (Togo) et ses dirigeants des anciens stagiaires du réseau CESMAT (France) et du GIRAF.
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
        <section class="w-full bg-gray-100 px-4 sm:px-6 lg:px-8" style="padding: 80px 0; background-color: #f9fafb !important;">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                    <h2 class="text-4xl font-bold text-black mb-4" style="font-size: 40px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; text-align: center; line-height: 48px; letter-spacing: -0.5px;">
                        Pourquoi Choisir CEGME ?
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto mb-6" style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto 24px;"></div>
                    <p class="text-lg text-gray-600 mx-auto" style="font-size: 18px; color: #6b7280; max-width: 700px; margin: 0 auto; text-align: center; line-height: 28px;">
                        Des atouts qui font la différence pour la réussite de vos projets
                    </p>
                </div>
                
                <!-- Cards Grid - 3 cards per row -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px; max-width: 100%; margin: 0;">
                    <!-- Card 1: Expertise Locale -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50" style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <circle cx="12" cy="12" r="5"></circle>
                                <circle cx="12" cy="12" r="1.5" fill="white"></circle>
                            </svg>
                        </div>
                        <!-- Title -->
                            <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Expertise Locale
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 leading-relaxed text-center" style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Connaissance approfondie du contexte centrafricain et des réglementations nationales
                        </p>
                        </div>
                    </div>
                    
                    <!-- Card 2: Agrément Officiel -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50" style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                            <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Agrément Officiel
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 leading-relaxed text-center" style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Plateforme d'experts agréée par le Ministère de l'Environnement (N° 004/MEDD/DIRCAB_21)
                        </p>
                        </div>
                    </div>
                    
                    <!-- Card 3: Réseau de Spécialistes -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50" style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                            <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Réseau de Spécialistes
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 leading-relaxed text-center" style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Équipe pluridisciplinaire et partenariats stratégiques nationaux et internationaux
                        </p>
                        </div>
                    </div>
                    
                    <!-- Card 4: Réactivité -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50" style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                        </div>
                        <!-- Title -->
                            <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Réactivité
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 leading-relaxed text-center" style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Intervention rapide sur tout le territoire centrafricain avec une approche flexible
                        </p>
                        </div>
                    </div>
                    
                    <!-- Card 5: Conformité Garantie -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50" style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                        </div>
                        <!-- Title -->
                            <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Conformité Garantie
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 leading-relaxed text-center" style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Tous nos rapports sont validés par les ministères compétents
                        </p>
                        </div>
                    </div>
                    
                    <!-- Card 6: Approche Innovante -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-full -mr-12 -mt-12 opacity-50" style="position: absolute; top: 0; right: 0; width: 96px; height: 96px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -48px; margin-top: -48px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); margin: 0 auto 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
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
                            <h3 class="text-xl font-bold mb-4 text-center" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; text-align: center; letter-spacing: -0.3px;">
                            Approche Innovante
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 leading-relaxed text-center" style="font-size: 16px; line-height: 26px; color: rgb(75, 85, 99); margin: 0; text-align: center;">
                            Solutions durables combinant expertise technique et bonnes pratiques internationales
                        </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Nos Pôles d'Activités Section - Enhanced Design -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 80px 0; margin: 0; border: none !important; border-top: none !important; border-bottom: none !important; outline: none !important; background-color: #ffffff !important;">
            <div class="max-w-5xl mx-auto" style="border: none !important; border-top: none !important; border-bottom: none !important; max-width: 1024px;">
                <!-- Header -->
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                    <h2 class="text-4xl font-bold text-black mb-4" style="font-size: 40px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; text-align: center; line-height: 48px; letter-spacing: -0.5px;">
                        Nos Pôles d'Activités
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto mb-6" style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto 24px;"></div>
                    <p class="text-lg text-gray-600 mx-auto" style="font-size: 18px; color: #6b7280; max-width: 700px; margin: 0 auto; text-align: center; line-height: 28px;">
                        Une expertise complète au service de vos projets
                    </p>
                </div>
                
                <!-- Cards Grid - 2x2 layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 32px; max-width: 100%; margin: 0;">
                    <!-- Card 1: Environnement et Développement Durable -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default; max-width: 100%;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full -mr-16 -mt-16 opacity-50" style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(240, 253, 250); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(135deg, rgb(34, 197, 94) 0%, rgb(22, 163, 74) 100%); box-shadow: 0 8px 20px rgba(34, 197, 94, 0.35); margin-bottom: 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                            <h3 class="text-xl font-bold mb-4" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; letter-spacing: -0.3px;">
                            Environnement et Développement Durable
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 mb-5" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin-bottom: 20px;">
                            Études d'impact environnemental et social, audits, gestion durable des ressources naturelles
                        </p>
                        <!-- Button -->
                            <button class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors" style="font-size: 16px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 8px;">
                            <span>En savoir plus</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                        </div>
                    </div>
                    
                    <!-- Card 2: Recherche Géologique et Minière -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-full -mr-16 -mt-16 opacity-50" style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(255, 247, 237); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(to top, rgb(249, 115, 22) 0%, rgb(251, 146, 60) 100%); box-shadow: 0 8px 20px rgba(249, 115, 22, 0.35); margin-bottom: 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <path d="M3 20h6l2-6 4 6h8l-3-8-3-4-2 4-2-2z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                            <h3 class="text-xl font-bold mb-4" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; letter-spacing: -0.3px;">
                            Recherche Géologique et Minière
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 mb-5" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin-bottom: 20px;">
                            Exploration géologique, cartographie numérique, évaluation économique de projets miniers
                        </p>
                        <!-- Button -->
                            <button class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors" style="font-size: 16px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 8px;">
                            <span>En savoir plus</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                        </div>
                    </div>
                    
                    <!-- Card 3: Géo-ingénierie Appliquée -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 opacity-50" style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(239, 246, 255); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(to bottom, rgb(59, 130, 246) 0%, rgb(96, 165, 250) 100%); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35); margin-bottom: 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
                                    <path d="M9 8a3 3 0 0 1 6 0c0 1.5-3 4-3 4s-3-2.5-3-4z"></path>
                                    <path d="M7 14a3 3 0 0 1 6 0c0 1.5-3 4-3 4s-3-2.5-3-4z"></path>
                                    <path d="M11 18a2 2 0 0 1 2 0c0 1-2 2.5-2 2.5s-2-1.5-2-2.5z"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                            <h3 class="text-xl font-bold mb-4" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; letter-spacing: -0.3px;">
                            Géo-ingénierie Appliquée
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 mb-5" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin-bottom: 20px;">
                            SIG, études hydrogéologiques et géotechniques, modélisation cartographique
                        </p>
                        <!-- Button -->
                            <button class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors" style="font-size: 16px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 8px;">
                            <span>En savoir plus</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                        </div>
                    </div>
                    
                    <!-- Card 4: Négoce et Représentation -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2" style="border-radius: 16px; padding: 32px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border: 1px solid rgba(229, 231, 235, 0.8); position: relative; overflow: hidden; cursor: default;">
                        <!-- Effet de fond décoratif -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-full -mr-16 -mt-16 opacity-50" style="position: absolute; top: 0; right: 0; width: 128px; height: 128px; background-color: rgb(250, 245, 255); border-radius: 50%; margin-right: -64px; margin-top: -64px; opacity: 0.5;"></div>
                        <div class="relative z-10" style="position: relative; z-index: 10;">
                        <!-- Icon -->
                            <div class="flex items-center justify-center mb-6" style="display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 16px; background: linear-gradient(to bottom, rgb(168, 85, 247) 0%, rgb(147, 51, 234) 100%); box-shadow: 0 8px 20px rgba(168, 85, 247, 0.35); margin-bottom: 24px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <rect width="20" height="14" x="2" y="5" rx="2" ry="2"></rect>
                                    <path d="M2 10h20"></path>
                            </svg>
                        </div>
                        <!-- Title -->
                            <h3 class="text-xl font-bold mb-4" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 30px; letter-spacing: -0.3px;">
                            Négoce et Représentation
                        </h3>
                        <!-- Description -->
                            <p class="text-gray-600 mb-5" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin-bottom: 20px;">
                            Conseil aux investisseurs, représentation d'entreprises, négociation commerciale
                        </p>
                        <!-- Button -->
                            <button class="inline-flex items-center gap-2 text-green-600 font-semibold hover:text-green-700 transition-colors" style="font-size: 16px; font-weight: 600; color: rgb(5, 150, 105); background-color: rgba(0, 0, 0, 0); display: inline-flex; align-items: center; gap: 8px;">
                            <span>En savoir plus</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Ils nous font confiance Section -->
        <section class="w-full bg-gray-50 px-4 sm:px-6 lg:px-8" style="padding: 80px 0; margin: 0; background-color: #f9fafb !important;">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                    <h2 class="text-4xl font-bold text-black mb-4" style="font-size: 40px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; text-align: center; line-height: 48px; letter-spacing: -0.5px;">
                        Ils nous font confiance
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto mb-6" style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto 24px;"></div>
                </div>
                
                <!-- Logos Grid - Horizontal -->
                <div class="flex flex-wrap justify-center items-center gap-4 md:gap-6" style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 24px;">
                    <!-- Logo 1: Banque Mondiale -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:-translate-y-1 flex items-center justify-center flex-shrink-0" style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid rgb(229, 231, 235); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; flex-shrink: 0;">
                        <img src="{{ asset('Image/Wordbank.png') }}" alt="Banque Mondiale" class="max-w-full max-h-full object-contain" style="max-width: 100%; max-height: 70px; object-fit: contain;">
                    </div>
                    
                    <!-- Logo 2: USAID -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:-translate-y-1 flex items-center justify-center flex-shrink-0" style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid rgb(229, 231, 235); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; flex-shrink: 0;">
                        <img src="{{ asset('Image/Usaid.png') }}" alt="USAID" class="max-w-full max-h-full object-contain" style="max-width: 100%; max-height: 70px; object-fit: contain;">
                    </div>
                    
                    <!-- Logo 3: BAD -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:-translate-y-1 flex items-center justify-center flex-shrink-0" style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid rgb(229, 231, 235); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; flex-shrink: 0;">
                        <img src="{{ asset('Image/BAD.png') }}" alt="BAD" class="max-w-full max-h-full object-contain" style="max-width: 100%; max-height: 70px; object-fit: contain;">
                    </div>
                    
                    <!-- Logo 4: BDEAC -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:-translate-y-1 flex items-center justify-center flex-shrink-0" style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid rgb(229, 231, 235); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; flex-shrink: 0;">
                        <img src="{{ asset('Image/BDEAC.png') }}" alt="BDEAC" class="max-w-full max-h-full object-contain" style="max-width: 100%; max-height: 70px; object-fit: contain;">
                    </div>
                    
                    <!-- Logo 5: FIDA -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:-translate-y-1 flex items-center justify-center flex-shrink-0" style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid rgb(229, 231, 235); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; flex-shrink: 0;">
                        <img src="{{ asset('Image/FIDA.png') }}" alt="FIDA" class="max-w-full max-h-full object-contain" style="max-width: 100%; max-height: 70px; object-fit: contain;">
                    </div>
                    
                    <!-- Logo 6: UNICEF -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:-translate-y-1 flex items-center justify-center flex-shrink-0" style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid rgb(229, 231, 235); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; flex-shrink: 0;">
                        <img src="{{ asset('Image/unicef.png') }}" alt="UNICEF" class="max-w-full max-h-full object-contain" style="max-width: 100%; max-height: 70px; object-fit: contain;">
                    </div>
                    
                    <!-- Logo 7: OXFAM -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:-translate-y-1 flex items-center justify-center flex-shrink-0" style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid rgb(229, 231, 235); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; flex-shrink: 0;">
                        <img src="{{ asset('Image/oxfam.png') }}" alt="OXFAM" class="max-w-full max-h-full object-contain" style="max-width: 100%; max-height: 70px; object-fit: contain;">
                    </div>
                    
                    <!-- Logo 8: FAO -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:-translate-y-1 flex items-center justify-center flex-shrink-0" style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid rgb(229, 231, 235); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; flex-shrink: 0;">
                        <img src="{{ asset('Image/FAO.png') }}" alt="FAO" class="max-w-full max-h-full object-contain" style="max-width: 100%; max-height: 70px; object-fit: contain;">
                    </div>
                    
                    <!-- Logo 9: African Parks -->
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 hover:-translate-y-1 flex items-center justify-center flex-shrink-0" style="background-color: #ffffff; border-radius: 12px; padding: 24px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid rgb(229, 231, 235); transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; min-height: 120px; min-width: 140px; flex-shrink: 0;">
                        <img src="{{ asset('Image/Africain park.png') }}" alt="African Parks" class="max-w-full max-h-full object-contain" style="max-width: 100%; max-height: 70px; object-fit: contain;">
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Mot de la direction Section -->
        <section class="w-full bg-gradient-to-b from-white to-gray-50 px-4 sm:px-6 lg:px-8" style="padding: 100px 0; margin: 0; background: linear-gradient(to bottom, #ffffff 0%, #f9fafb 100%);">
            <div class="max-w-3xl mx-auto px-2 md:px-4 lg:px-6" style="max-width: 768px; margin: 0 auto; padding-left: 16px; padding-right: 16px;">
                <!-- Header -->
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                    <h2 class="text-4xl font-bold text-black mb-4" style="font-size: 42px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; text-align: center; line-height: 50px; letter-spacing: -0.5px;">
                        Mot de la direction
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto mb-6" style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto 24px;"></div>
                </div>
                
                <!-- Content -->
                <div class="relative" style="position: relative;">
                        <!-- Quote icon en haut -->
                        <div class="flex justify-center mb-6" style="display: flex; justify-content: center; margin-bottom: 24px;">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-md" style="width: 64px; height: 64px; background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: #ffffff;">
                                    <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"></path>
                                    <path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Text -->
                        <div class="space-y-6" style="display: flex; flex-direction: column; gap: 24px;">
                            <p class="text-xl text-gray-700 leading-relaxed" style="font-size: 20px; color: rgb(55, 65, 81); line-height: 36px; margin: 0; font-weight: 400; text-align: justify;">
                                « Notre identité repose sur une conviction forte : <strong style="font-weight: 700; color: rgb(17, 24, 39);">l'expertise de pointe et la connaissance profonde du terrain sont indissociables</strong>. Le CEGME Sarl., mobilise un réseau d'élite composé d'universitaires et de consultants ayant évolué au sein de groupes mondiaux tels qu'<strong style="font-weight: 600; color: rgb(17, 24, 39);">AREVA, DEBEERS, AURAFRIQUE et DIGOIL</strong>.
                            </p>
                            <p class="text-xl text-gray-700 leading-relaxed" style="font-size: 20px; color: rgb(55, 65, 81); line-height: 36px; margin: 0; font-weight: 400; text-align: justify;">
                                Cette dualité constitue notre <strong style="font-weight: 700; color: rgb(5, 150, 105);">"plus-value"</strong> : nous offrons aux investisseurs internationaux et nationaux la rigueur des bonnes pratiques (<strong style="font-weight: 600; color: rgb(17, 24, 39);">SFI, Banque Mondiale, BAD</strong>) tout en garantissant un ancrage local et une maîtrise des réalités sociopolitiques de la région. En valorisant le contenu local et le capital humain centrafricain, nous sécurisons vos actifs et bâtissons une prospérité durable pour la Nation. »
                            </p>
                        </div>
                        
                        <!-- Ligne de séparation décorative -->
                        <div class="w-32 h-0.5 bg-gradient-to-r from-transparent via-green-500 to-transparent mx-auto mt-10 mb-8" style="width: 128px; height: 2px; background: linear-gradient(90deg, transparent 0%, rgb(5, 150, 105) 50%, transparent 100%); margin: 40px auto 32px;"></div>
                        
                        <!-- Signature -->
                        <div class="flex items-center justify-center gap-4" style="display: flex; align-items: center; justify-content: center; gap: 16px;">
                            <!-- Cercle vert avec DG -->
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-md flex-shrink-0" style="width: 64px; height: 64px; background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); flex-shrink: 0;">
                                <span class="text-white font-bold text-xl" style="color: #ffffff; font-weight: 800; font-size: 20px;">
                                    DG
                                </span>
                            </div>
                            <!-- Texte -->
                            <div class="text-left" style="text-align: left;">
                                <p class="text-lg font-semibold text-gray-800" style="font-size: 18px; font-weight: 700; color: rgb(31, 41, 55); margin: 0; line-height: 24px;">
                                    Directeur Général
                                </p>
                                <p class="text-base text-gray-600 mt-1" style="font-size: 16px; color: rgb(75, 85, 99); margin-top: 4px; margin-bottom: 0; line-height: 22px;">
                                    CEGME Sarl.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Projets Récents Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 80px 0; margin: 0; background-color: #ffffff !important;">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 64px;">
                    <h2 class="text-4xl font-bold text-black mb-4" style="font-size: 40px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 16px; text-align: center; line-height: 48px; letter-spacing: -0.5px;">
                        Projets Récents
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-green-500 to-green-600 rounded-full mx-auto mb-6" style="width: 96px; height: 4px; background: linear-gradient(90deg, rgb(5, 150, 105) 0%, rgb(16, 185, 129) 100%); border-radius: 9999px; margin: 0 auto 24px;"></div>
                    <p class="text-lg text-gray-600 mx-auto max-w-2xl" style="font-size: 18px; color: rgb(75, 85, 99); max-width: 600px; margin: 0 auto; text-align: center; line-height: 28px;">
                        Découvrez nos dernières réalisations et projets d'envergure
                    </p>
                </div>
                
                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 32px;">
                    <!-- Project 1 -->
                    <a href="/services" class="block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100" style="display: block; background-color: rgb(255, 255, 255); border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.3s ease; text-decoration: none; color: inherit; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <div class="relative overflow-hidden" style="position: relative; overflow: hidden;">
                            <img src="{{ asset('Image/Complexe Immobilier.jpg') }}" alt="Complexe Immobilier BDEAC" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110" style="width: 100%; height: 200px; object-fit: cover; transition: transform 0.3s ease;">
                            <div class="absolute top-4 right-4 bg-white text-gray-800 px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg" style="position: absolute; top: 16px; right: 16px; background-color: rgb(255, 255, 255); color: rgb(31, 41, 55); padding: 6px 16px; border-radius: 9999px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                                2021
                            </div>
                        </div>
                        <div class="p-6" style="padding: 24px;">
                            <div class="mb-4" style="margin-bottom: 16px;">
                                <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-semibold" style="background-color: rgb(220, 252, 231); color: rgb(5, 150, 105); padding: 6px 12px; border-radius: 9999px; font-size: 14px; font-weight: 600; display: inline-block;">
                                    environnement
                                </span>
                            </div>
                            <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 30px; letter-spacing: -0.3px;">
                                Complexe Immobilier BDEAC
                            </h3>
                            <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px;">
                                EIES pour construction d'un complexe administratif et résidentiel au centre-ville de Bangui
                            </p>
                        </div>
                    </a>
                    
                    <!-- Project 2 -->
                    <a href="/services" class="block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100" style="display: block; background-color: rgb(255, 255, 255); border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.3s ease; text-decoration: none; color: inherit; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <div class="relative overflow-hidden" style="position: relative; overflow: hidden; height: 240px; background-color: #f3f4f6;">
                            <img src="{{ asset('Image/City Apartment Bangui..jpg') }}" alt="City Apartment Bangui" class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" style="width: 100%; height: 100%; min-height: 240px; object-fit: cover; object-position: center; transition: transform 0.3s ease; display: block;">
                            <div class="absolute top-4 right-4 bg-white text-gray-800 px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg" style="position: absolute; top: 16px; right: 16px; background-color: rgb(255, 255, 255); color: rgb(31, 41, 55); padding: 6px 16px; border-radius: 9999px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                                2020
                            </div>
                        </div>
                        <div class="p-6" style="padding: 24px;">
                            <div class="mb-4" style="margin-bottom: 16px;">
                                <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-sm font-semibold" style="background-color: rgb(220, 252, 231); color: rgb(5, 150, 105); padding: 6px 12px; border-radius: 9999px; font-size: 14px; font-weight: 600; display: inline-block;">
                                    environnement
                                </span>
                            </div>
                            <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 30px; letter-spacing: -0.3px;">
                                City Apartment Bangui
                            </h3>
                            <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px;">
                                Étude d'impact pour un complexe immobilier à usage administratif et d'appartement
                            </p>
                        </div>
                    </a>
                    
                    <!-- Project 3 -->
                    <a href="/services" class="block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100" style="display: block; background-color: rgb(255, 255, 255); border-radius: 16px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.3s ease; text-decoration: none; color: inherit; cursor: pointer; border: 1px solid rgba(229, 231, 235, 0.8);">
                        <div class="relative overflow-hidden" style="position: relative; overflow: hidden;">
                            <img src="{{ asset('Image/Exploitation Rivière Sangha.jpg') }}" alt="Exploitation Rivière Sangha" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110" style="width: 100%; height: 200px; object-fit: cover; transition: transform 0.3s ease;">
                            <div class="absolute top-4 right-4 bg-white text-gray-800 px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg" style="position: absolute; top: 16px; right: 16px; background-color: rgb(255, 255, 255); color: rgb(31, 41, 55); padding: 6px 16px; border-radius: 9999px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                                2019
                            </div>
                        </div>
                        <div class="p-6" style="padding: 24px;">
                            <div class="mb-4" style="margin-bottom: 16px;">
                                <span class="bg-orange-100 text-orange-700 px-3 py-1.5 rounded-full text-sm font-semibold" style="background-color: rgb(255, 237, 213); color: rgb(249, 115, 22); padding: 6px 12px; border-radius: 9999px; font-size: 14px; font-weight: 600; display: inline-block;">
                                    mines
                                </span>
                            </div>
                            <h3 class="text-xl font-bold mb-3" style="font-size: 22px; font-weight: 800; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 30px; letter-spacing: -0.3px;">
                                Exploitation Rivière Sangha
                            </h3>
                            <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px;">
                                EIES pour exploitation semi-mécanisée d'or et diamant sur la rivière Sangha
                            </p>
                        </div>
                    </a>
                </div>
                
                <!-- Button -->
                <div class="text-center mt-12" style="text-align: center; margin-top: 48px;">
                    <a href="/realisations" class="inline-flex items-center gap-2 px-8 py-3.5 text-green-600 font-semibold rounded-xl border-2 border-green-600 hover:bg-green-600 hover:text-white transition-all duration-200" style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 32px; color: rgb(5, 150, 105); font-size: 16px; font-weight: 600; background-color: transparent; border: 2px solid rgb(5, 150, 105) !important; border-radius: 12px; transition: all 0.2s ease; text-decoration: none;">
                        <span>Voir toutes nos réalisations</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
        
        <!-- Notre Approche Section - Enhanced Design -->
        <section class="w-full bg-gray-100 px-4 sm:px-6 lg:px-8" style="padding: 32px 0; margin: 0; background-color: #f9fafb !important;">
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
        
        <!-- Footer - Enhanced Professional Design -->
        <footer class="w-full text-white px-4 sm:px-6 lg:px-8" style="background: linear-gradient(to right bottom, rgb(15, 23, 42), rgb(6, 78, 59), rgb(19, 78, 74)); padding: 80px 0 32px; color: rgb(255, 255, 255); position: relative; overflow: hidden;">
            <!-- Decorative overlay -->
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(5, 150, 105, 0.08) 0%, transparent 50%); pointer-events: none;"></div>
            <div class="relative z-10" style="position: relative; z-index: 10;">
            <div class="max-w-7xl mx-auto" style="padding: 0px;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px; margin-bottom: 48px; padding: 0px;">
                    <!-- Company Info -->
                    <div>
                        <!-- Logo and Company Name -->
                        <div class="flex items-center gap-3 mb-6" style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                            <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" class="block h-12 w-auto" style="height: 48px; width: auto; object-fit: contain;">
                            <div class="flex flex-col" style="display: flex; flex-direction: column;">
                                <span class="text-2xl font-bold" style="font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1.2;">CEGME</span>
                                <span class="text-xs text-gray-200" style="font-size: 11px; color: rgb(229, 231, 235); line-height: 1.2; margin-top: 2px;">Géosciences • Mines • Environnement</span>
                            </div>
                        </div>
                        <!-- Description -->
                        <p class="text-white mb-5 leading-relaxed" style="font-size: 15px; color: rgb(255, 255, 255); margin-bottom: 20px; line-height: 26px; font-weight: 400;">
                            Cabinet d'Études Géologiques, Minières et Environnementales
                        </p>
                        <p class="text-gray-200 text-sm leading-relaxed" style="font-size: 14px; color: rgb(229, 231, 235); line-height: 22px; margin: 0;">
                            <strong style="font-weight: 600; color: rgb(255, 255, 255);">Plateforme d'experts nationaux agréée</strong><br>
                            N° 004/MEDD/DIRCAB_21
                        </p>
                    </div>
                    
                    <!-- Liens Rapides -->
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
                    
                    <!-- Contact -->
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
                                        <a href="mailto:contact@cegme.net" class="text-gray-200 text-sm hover:text-green-300 transition-colors" style="color: rgb(229, 231, 235); font-size: 14px; text-decoration: none; transition: color 0.2s ease;">contact@cegme.net</a>
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
                
                <!-- Copyright -->
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
                
                menu.classList.toggle('active');
                button.classList.toggle('active');
            }
            
            // Fermer le menu au clic sur un lien
            document.querySelectorAll('.mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    const menu = document.getElementById('mobileMenu');
                    const button = document.getElementById('mobileMenuButton');
                    menu.classList.remove('active');
                    button.classList.remove('active');
                });
            });
            
            // Fermer le menu en cliquant en dehors
            document.addEventListener('click', (e) => {
                const menu = document.getElementById('mobileMenu');
                const button = document.getElementById('mobileMenuButton');
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
