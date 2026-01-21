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
    @include('partials.site-styles')
    <style>

    </style>
</head>

<body class="bg-white text-[#1b1b18] min-h-screen" style="background-color: #ffffff !important;">
    <x-site-header />

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

    <x-site-footer />
    <!-- Site Scripts -->
    @include('partials.site-scripts')
</body>

</html>