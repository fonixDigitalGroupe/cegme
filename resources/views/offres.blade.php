<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Appels d'offres - CEGME</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
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
                            <a href="{{ route('offres.index') }}" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Appels d'offres
                            </a>
                            <a href="/blog" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('blog') || request()->is('blog/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 400; font-family: Arial, Helvetica, sans-serif; {{ request()->is('blog') || request()->is('blog/*') ? 'background: linear-gradient(135deg, rgb(16, 185, 129) 0%, rgb(5, 150, 105) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Blog
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
        <section class="relative w-full flex items-center justify-center overflow-hidden" style="min-height: 45vh; padding: 60px 0; background-color: rgb(245, 250, 248);">
            <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center" style="margin-top: 60px;">
                <h1 class="mb-6" style="font-size: 60px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 24px; text-align: center; line-height: 72px;">
                    Appels d'offres
                </h1>
                <p class="mx-auto max-w-3xl" style="font-size: 20px; color: rgb(75, 85, 99); text-align: center; line-height: 32px;">
                    Consultez les derniers appels d'offres publiés et accédez aux informations détaillées.
                </p>
            </div>
        </section>

        <!-- Main Content Section -->
        <section class="w-full px-4 sm:px-6 lg:px-8" style="padding: 96px 0; background-color: #F9FAFB;">
            <div class="max-w-7xl mx-auto">
                <!-- Search and Filters -->
                <div class="mb-8" style="margin-bottom: 32px;">
                    <form method="GET" action="{{ route('offres.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input
                                type="text"
                                name="search"
                                value="{{ request()->get('search') }}"
                                placeholder="Rechercher par titre, acheteur ou pays..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 6px; font-size: 14px;"
                            >
                        </div>
                        @if($pays->count() > 0)
                        <div class="md:w-48">
                            <select
                                name="pays"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                style="width: 100%; padding: 12px 16px; border: 1px solid rgb(209, 213, 219); border-radius: 6px; font-size: 14px;"
                            >
                                <option value="">Tous les pays</option>
                                @foreach($pays as $p)
                                    <option value="{{ $p }}" {{ request()->get('pays') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <button
                            type="submit"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                            style="padding: 12px 24px; background-color: rgb(5, 150, 105); color: white; border-radius: 6px; font-weight: 600;"
                        >
                            Rechercher
                        </button>
                        @if(request()->has('search') || request()->has('pays'))
                        <a
                            href="{{ route('offres.index') }}"
                            class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors"
                            style="padding: 12px 24px; background-color: rgb(209, 213, 219); color: rgb(55, 65, 81); border-radius: 6px; font-weight: 600; text-decoration: none;"
                        >
                            Réinitialiser
                        </a>
                        @endif
                    </form>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden" style="background-color: rgb(255, 255, 255); border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px;">
                    <div class="overflow-x-auto">
                        <table class="w-full" style="width: 100%;">
                            <thead style="background-color: rgb(245, 250, 248);">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700" style="padding: 16px 24px; text-align: left; font-size: 14px; font-weight: 600; color: rgb(55, 65, 81);">Titre de l'appel d'offre</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700" style="padding: 16px 24px; text-align: left; font-size: 14px; font-weight: 600; color: rgb(55, 65, 81);">Acheteur</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700" style="padding: 16px 24px; text-align: left; font-size: 14px; font-weight: 600; color: rgb(55, 65, 81);">Pays</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700" style="padding: 16px 24px; text-align: left; font-size: 14px; font-weight: 600; color: rgb(55, 65, 81);">Date limite</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700" style="padding: 16px 24px; text-align: center; font-size: 14px; font-weight: 600; color: rgb(55, 65, 81);">Lien</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @if($offres->count() > 0)
                                    @foreach($offres as $offre)
                                    <tr class="hover:bg-gray-50" style="transition: background-color 0.2s;">
                                        <td class="px-6 py-4 text-sm text-gray-900" style="padding: 16px 24px; font-size: 14px; color: rgb(17, 24, 39);">
                                            <div class="font-medium" style="font-weight: 500;">{{ $offre->titre }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600" style="padding: 16px 24px; font-size: 14px; color: rgb(75, 85, 99);">
                                            {{ $offre->acheteur ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600" style="padding: 16px 24px; font-size: 14px; color: rgb(75, 85, 99);">
                                            {{ $offre->pays ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600" style="padding: 16px 24px; font-size: 14px; color: rgb(75, 85, 99);">
                                            {{ $offre->date_limite_soumission ? $offre->date_limite_soumission->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center" style="padding: 16px 24px; text-align: center;">
                                            <a
                                                href="{{ $offre->lien_source }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                                                style="display: inline-flex; align-items: center; padding: 8px 16px; background-color: rgb(5, 150, 105); color: white; border-radius: 6px; font-weight: 500; font-size: 14px; text-decoration: none;"
                                            >
                                                Lire l'information
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; margin-left: 8px;">
                                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                    <polyline points="15 3 21 3 21 9"></polyline>
                                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center" style="padding: 48px 24px; text-align: center;">
                                            <p class="text-gray-500 text-lg" style="color: rgb(107, 114, 128); font-size: 18px;">
                                                Aucun appel d'offre disponible pour le moment.
                                            </p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    @if($offres->count() > 0)
                    <div class="px-6 py-4 border-t border-gray-200" style="padding: 16px 24px; border-top: 1px solid rgb(229, 231, 235);">
                        {{ $offres->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </body>
</html>
