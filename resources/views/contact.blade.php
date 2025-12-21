<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Contact - {{ config('app.name', 'Laravel') }}</title>

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
                            <a href="/" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('/') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('/') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Accueil
                            </a>
                            <a href="/a-propos" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('a-propos') || request()->is('a-propos/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('a-propos') || request()->is('a-propos/*') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                À Propos
                            </a>
                            <a href="/services" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('services') || request()->is('services/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('services') || request()->is('services/*') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Services
                            </a>
                            <a href="/realisations" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('realisations') || request()->is('realisations/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('realisations') || request()->is('realisations/*') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Réalisations
                            </a>
                            <a href="/actualites" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('actualites') || request()->is('actualites/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('actualites') || request()->is('actualites/*') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Actualités
                            </a>
                            <a href="/blog" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('blog') || request()->is('blog/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('blog') || request()->is('blog/*') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Blog
                            </a>
                            <a href="/appels-offres" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Nos offres
                            </a>
                            <a href="/contact" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('contact') || request()->is('contact/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('contact') || request()->is('contact/*') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
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
                            style="background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); padding: 8px 20px; font-size: 16px; border-radius: 8px;"
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
        <section class="relative w-full flex items-center justify-center overflow-hidden" style="min-height: 60vh; padding: 80px 0; background: linear-gradient(135deg, rgb(15, 64, 62) 0%, rgb(10, 48, 46) 100%);">
            <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center">
                <h1 class="text-white mb-6" style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                    Contactez-Nous
                </h1>
                <p class="text-white/90 mx-auto max-w-3xl" style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                    Notre équipe est à votre disposition pour répondre à toutes vos questions
                </p>
            </div>
        </section>

        <!-- Contact Info Section -->
        <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 96px 0;">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 32px; margin-bottom: 64px;">
                    <!-- Card 1: Adresse -->
                    <div class="bg-white rounded-lg p-6 shadow-md text-center" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; text-align: center;">
                        <div class="w-16 h-16 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-4" style="width: 64px; height: 64px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: rgb(5, 150, 105);">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Adresse
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                            Bangui, République Centrafricaine
                        </p>
                    </div>

                    <!-- Card 2: Email -->
                    <div class="bg-white rounded-lg p-6 shadow-md text-center" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; text-align: center;">
                        <div class="w-16 h-16 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-4" style="width: 64px; height: 64px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: rgb(5, 150, 105);">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Email
                        </h3>
                        <p class="text-gray-600 mb-1" style="font-size: 16px; color: rgb(75, 85, 99); margin-bottom: 4px;">
                            contact@cegme.net
                        </p>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                            info@cegme.net
                        </p>
                    </div>

                    <!-- Card 3: Téléphone -->
                    <div class="bg-white rounded-lg p-6 shadow-md text-center" style="background-color: rgb(255, 255, 255); border-radius: 8px; padding: 24px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; text-align: center;">
                        <div class="w-16 h-16 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-4" style="width: 64px; height: 64px; border-radius: 8px; background-color: rgb(209, 250, 229); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: rgb(5, 150, 105);">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3" style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px;">
                            Téléphone
                        </h3>
                        <p class="text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99);">
                            +236 XX XX XX XX
                        </p>
                    </div>
                </div>

                <!-- Contact Form Section -->
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-8" style="margin-bottom: 32px; text-align: center;">
                        <h2 class="text-4xl font-bold mb-4" style="font-size: 36px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 16px;">
                            Envoyez-nous un Message
                        </h2>
                        <p class="text-lg text-gray-600" style="font-size: 16px; color: rgb(75, 85, 99); margin-bottom: 0px;">
                            Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais
                        </p>
                    </div>

                    <form class="bg-white rounded-lg shadow-md p-8" style="background-color: rgb(255, 255, 255); border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; padding: 32px;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; margin-bottom: 24px;">
                            <!-- Nom complet -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2" style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                                    Nom complet <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    required
                                    placeholder="Votre nom"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px;"
                                >
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2" style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    required
                                    placeholder="votre@email.com"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px;"
                                >
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; margin-bottom: 24px;">
                            <!-- Téléphone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2" style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                                    Téléphone
                                </label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    placeholder="+236 XX XX XX XX"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px;"
                                >
                            </div>

                            <!-- Sujet -->
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2" style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                                    Sujet <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    required
                                    placeholder="Sujet de votre message"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px;"
                                >
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="mb-6" style="margin-bottom: 24px;">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2" style="display: block; font-size: 14px; font-weight: 500; color: rgb(55, 65, 81); margin-bottom: 8px;">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                required
                                rows="6"
                                placeholder="Décrivez votre projet ou votre demande..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"
                                style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 8px; font-size: 16px; resize: none; min-height: 150px;"
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center" style="text-align: center;">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors"
                                style="display: inline-flex; align-items: center; gap: 8px; padding: 16px 32px; background-color: rgb(5, 150, 105); color: rgb(255, 255, 255); border-radius: 8px; font-size: 16px; font-weight: 500; border: none; cursor: pointer;"
                            >
                                <span>Envoyer le message</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;">
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

