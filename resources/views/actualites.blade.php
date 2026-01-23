<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Actualités et Réseaux Sociaux | CEGME</title>
    <meta name="description"
        content="Suivez l'actualité du CEGME sur Facebook et LinkedIn. Restez informés de nos derniers projets, actualités environnementales et événements en République Centrafricaine.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Actualités et Réseaux Sociaux | CEGME">
    <meta property="og:description"
        content="Suivez nos dernières actualités, projets et événements sur Facebook et LinkedIn.">
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
        }



        * {
            box-sizing: border-box;
        }



        /* MOBILE ONLY STYLES */
    </style>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.site-styles')
</head>

<body class="bg-white text-[#1b1b18] min-h-screen" style="background-color: #ffffff !important;">
    <x-site-header />

    <!-- Hero Section - Page Header -->
    <section class="relative w-full flex items-center justify-center overflow-hidden actualites-hero-section"
        style="min-height: 30vh; padding: 40px 0; background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42));">
        <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center actualites-hero-content"
            style="margin-top: 60px;">
            <h1 class="mb-6"
                style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                Réseaux Sociaux
            </h1>
            <p class="mx-auto max-w-3xl"
                style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                Suivez nos dernières actualités, projets et événements sur Facebook et LinkedIn
            </p>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="w-full px-4 sm:px-6 lg:px-8" style="padding: 96px 0; background-color: #F9FAFB;">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row gap-8 items-start justify-between actualites-main-row"
                style="display: flex; gap: 32px; align-items: flex-start; justify-content: space-between;">
                <!-- Left Column - Content -->
                <div class="actualites-left-column"
                    style="width: 100%; max-width: 450px; display: flex; flex-direction: column; gap: 32px;">
                    <!-- Block 1: Facebook Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8"
                        style="background-color: #ffffff; border-radius: 20px; padding: 32px; border: 1px solid #f3f4f6; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                        <!-- Facebook Icon -->
                        <div
                            style="width: 56px; height: 56px; background-color: #1877F2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="white"
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
                        <p style="font-size: 16px; color: rgb(75, 85, 99); line-height: 1.6; margin-bottom: 28px;">
                            Restez informés de nos derniers projets, actualités environnementales et événements en
                            République Centrafricaine.
                        </p>
                        <!-- Button -->
                        <a href="https://www.facebook.com/CEGME.BG" target="_blank" rel="noopener noreferrer"
                            style="display: inline-flex; align-items: center; gap: 10px; background-color: #1877F2; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px; transition: all 0.2s; box-shadow: 0 4px 6px rgba(24, 119, 242, 0.2);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            <span>Visiter notre page Facebook</span>
                        </a>
                    </div>

                    <!-- Block 2: LinkedIn Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8"
                        style="background-color: #ffffff; border-radius: 20px; padding: 32px; border: 1px solid #f3f4f6; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                        <!-- LinkedIn Icon -->
                        <div
                            style="width: 56px; height: 56px; background-color: #0A66C2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="white"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </div>
                        <!-- Title -->
                        <h2
                            style="font-size: 24px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 16px; line-height: 1.3;">
                            Suivez-nous sur LinkedIn
                        </h2>
                        <!-- Description -->
                        <p style="font-size: 16px; color: rgb(75, 85, 99); line-height: 1.6; margin-bottom: 28px;">
                            Découvrez notre expertise professionnelle, nos offres d'emploi et nos réalisations majeures
                            au niveau national et international.
                        </p>
                        <!-- Button -->
                        <a href="https://cf.linkedin.com/company/cegme" target="_blank" rel="noopener noreferrer"
                            style="display: inline-flex; align-items: center; gap: 10px; background-color: #0A66C2; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px; transition: all 0.2s; box-shadow: 0 4px 6px rgba(10, 102, 194, 0.2);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                            <span>Visiter notre page LinkedIn</span>
                        </a>
                    </div>

                    <!-- Block 3: Community Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8"
                        style="background-color: #ffffff; border-radius: 20px; padding: 32px; border: 1px solid #f3f4f6; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                        <h3
                            style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 24px; line-height: 1.3;">
                            Rejoignez notre communauté
                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            <!-- Like our page -->
                            <div style="display: flex; align-items: center; gap: 16px;">
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
                            <div style="display: flex; align-items: center; gap: 16px;">
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
                            <div style="display: flex; align-items: center; gap: 16px;">
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
                </div>

                <!-- Right Column - Sidebar with Interactive Widgets -->
                <div class="actualites-right-column"
                    style="width: 100%; max-width: 700px; flex-shrink: 0; display: flex; flex-direction: column; gap: 32px;">
                    <div class="actualites-facebook-widget" style="width: 100%;">
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
                                    <div style="color: white; font-size: 16px; line-height: 1.3; margin-top: 4px;">
                                        @CEGME.BG
                                    </div>
                                </div>
                            </div>
                            <div
                                style="display: flex; justify-content: center; align-items: center; width: 100%; padding: 0;">
                                <iframe
                                    src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FCEGME.BG%2F&tabs=timeline&width=700&height=600&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                                    width="700" height="600" class="facebook-iframe"
                                    style="border:none;overflow:hidden;width:100%;max-width:700px;height:600px;margin:0 auto;display:block;"
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

                        <!-- LinkedIn Widget -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden"
                            style="background-color: rgb(255, 255, 255); border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; margin-top: 32px;">
                            <!-- LinkedIn Header -->
                            <div
                                style="background-color: #0A66C2; padding: 20px 20px; display: flex; align-items: center; gap: 16px;">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="white"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                </svg>
                                <div style="flex: 1;">
                                    <div style="color: white; font-weight: 700; font-size: 20px; line-height: 1.3;">
                                        Actualités LinkedIn</div>
                                    <div style="color: white; font-size: 16px; line-height: 1.3; margin-top: 4px;">
                                        Cabinet CEGME</div>
                                </div>
                            </div>

                            <!-- LinkedIn Profile Card (Mockup) -->
                            <div style="padding: 40px 32px; text-align: center; border-bottom: 1px solid #f3f4f6;">
                                <div
                                    style="width: 100px; height: 100px; border-radius: 8px; background: #fff; border: 1px solid #e5e7eb; margin: 0 auto 20px; padding: 10px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME"
                                        style="max-height: 80px; width: auto;">
                                </div>
                                <h3 style="font-size: 24px; font-weight: 700; color: #111827; margin-bottom: 8px;">CEGME
                                    Sarl</h3>
                                <p
                                    style="font-size: 16px; color: #6b7280; margin-bottom: 24px; max-width: 400px; margin-left: auto; margin-right: auto;">
                                    Expertise en Géosciences, Mines & Environnement. Partenaire stratégique pour le
                                    développement durable.
                                </p>
                                <a href="https://cf.linkedin.com/company/cegme" target="_blank"
                                    rel="noopener noreferrer"
                                    style="background-color: #0A66C2; color: white; padding: 12px 32px; border-radius: 9999px; font-weight: 600; text-decoration: none; display: inline-block; transition: background-color 0.2s;">
                                    Suivre sur LinkedIn
                                </a>
                            </div>

                            <div style="padding: 24px; text-align: center; background-color: #f9fafb;">
                                <p style="font-size: 14px; color: #6b7280;">
                                    Consultez nos derniers articles et partages professionnels directement sur notre
                                    page LinkedIn officielle.
                                </p>
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

    <x-site-footer />

    <!-- Site Scripts -->
    @include('partials.site-scripts')
</body>