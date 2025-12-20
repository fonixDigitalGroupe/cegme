<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content), 160) }}">

        <title>{{ $post->title }} - {{ config('app.name', 'Laravel') }}</title>

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
                            <a href="/blog" class="inline-block px-3 py-1.5 rounded-sm text-base leading-normal transition-colors {{ request()->is('blog') || request()->is('blog/*') ? 'text-white bg-green-600' : 'hover:text-gray-700' }}" style="font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; {{ request()->is('blog') || request()->is('blog/*') ? 'background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); border-radius: 6px;' : 'color: rgb(0, 0, 0); text-decoration: none;' }}">
                                Blog
                            </a>
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

        <!-- Hero Section - Article Header -->
        <section class="relative w-full flex items-center justify-center overflow-hidden" style="min-height: 60vh; padding-top: 100px; padding-bottom: 80px; background-color: rgb(245, 250, 248); position: relative;">
            @if($post->header_image ?? $post->featured_image)
                <div class="absolute inset-0 z-0" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;">
                    <img src="{{ asset('storage/' . ($post->header_image ?? $post->featured_image)) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <!-- Overlay sombre pour améliorer la lisibilité du texte -->
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.6) 100%); z-index: 1;"></div>
                </div>
            @endif
            <div class="relative z-10 w-full max-w-4xl mx-auto px-4" style="position: relative; z-index: 10; padding-left: 250px;">
                <!-- Lien retour et Catégorie alignés à gauche avec le titre -->
                <div style="margin-top: 80px; margin-bottom: 32px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                    <a href="{{ route('blog.index') }}" style="color: rgb(255, 255, 255); text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; opacity: 0.9; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        Retour au blog
                    </a>
                    @if($post->category)
                        <span style="display: inline-block; padding: 8px 16px; background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); color: rgb(255, 255, 255); border-radius: 6px; font-size: 13px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; border: 1px solid rgba(255, 255, 255, 0.3);">
                            {{ $post->category->name }}
                        </span>
                    @endif
                </div>
                
                <!-- Titre principal - aligné à gauche, deux lignes -->
                <div style="margin-bottom: 24px;">
                    @php
                        // Diviser le titre en deux lignes si nécessaire
                        $titleParts = explode(' dans les ', $post->title);
                        if (count($titleParts) == 2) {
                            $line1 = $titleParts[0];
                            $line2 = 'dans les ' . $titleParts[1];
                        } else {
                            // Essayer avec une virgule
                            $titleParts = explode(', ', $post->title);
                            if (count($titleParts) == 2) {
                                $line1 = $titleParts[0];
                                $line2 = $titleParts[1];
                            } else {
                                // Diviser au milieu si le titre est long
                                $words = explode(' ', $post->title);
                                $midPoint = ceil(count($words) / 2);
                                $line1 = implode(' ', array_slice($words, 0, $midPoint));
                                $line2 = implode(' ', array_slice($words, $midPoint));
                            }
                        }
                    @endphp
                    <h1 style="font-size: clamp(28px, 4vw, 42px); font-weight: 800; color: rgb(255, 255, 255); line-height: 1.3; text-align: left; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); width: 100%; margin: 0;">
                        <span style="display: block;">{{ $line1 }}</span>
                        <span style="display: block;">{{ $line2 }}</span>
                    </h1>
                </div>
                
                <!-- Métadonnées (date et auteur) - alignées à gauche avec le titre -->
                <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap; color: rgba(255, 255, 255, 0.95); font-size: 15px; margin-top: 24px; font-weight: 500;">
                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; opacity: 0.8;">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                    </span>
                    <span style="opacity: 0.6;">•</span>
                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; opacity: 0.8;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        {{ $post->user->name ?? 'CEGME' }}
                    </span>
                </div>
            </div>
        </section>

        <!-- Article Content -->
        <section class="w-full bg-white" style="padding: 60px 0 30px; min-height: 300px;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="article-content-wrapper" style="max-width: 1000px; margin: 0 auto; padding: 0 64px;">
                    @if($post->excerpt)
                        <div class="excerpt" style="border-top: 1px solid rgb(229, 231, 235); border-bottom: 1px solid rgb(229, 231, 235); background: rgb(255, 255, 255); padding: 24px 0; margin-bottom: 32px; font-style: italic; font-size: 20px; color: rgb(75, 85, 99); line-height: 1.6;">
                            {{ $post->excerpt }}
                        </div>
                    @endif

                    <div class="article-content" style="font-family: Georgia, 'Times New Roman', serif; font-size: 19px; line-height: 1.9; color: rgb(17, 24, 39); margin-left: 32px; margin-right: 32px;">
                        {!! $post->content !!}
                    </div>

                    <!-- Tags -->
                    @if($post->tags->count() > 0)
                        <div style="margin-top: 48px; padding-top: 32px; border-top: 1px solid rgb(229, 231, 235);">
                            <h3 style="font-size: 14px; font-weight: 700; color: rgb(55, 65, 81); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Tags</h3>
                            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                @foreach($post->tags as $tag)
                                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background-color: rgb(243, 244, 246); color: rgb(55, 65, 81); border: 1px solid rgb(229, 231, 235); border-radius: 4px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.3px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                        </svg>
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div style="margin-top: 48px; padding-top: 32px; border-top: 1px solid rgb(229, 231, 235);">
                        <h3 style="font-size: 14px; font-weight: 600; color: rgb(55, 65, 81); margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">Partager cet article</h3>
                        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background-color: #1877F2; color: rgb(255, 255, 255); border: none; border-radius: 4px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#166FE5'; this.style.transform='translateY(-1px)';" onmouseout="this.style.backgroundColor='#1877F2'; this.style.transform='translateY(0)';" title="Partager sur Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background-color: #0077B5; color: rgb(255, 255, 255); border: none; border-radius: 4px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#006399'; this.style.transform='translateY(-1px)';" onmouseout="this.style.backgroundColor='#0077B5'; this.style.transform='translateY(0)';" title="Partager sur LinkedIn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                                    <rect x="2" y="9" width="4" height="12"></rect>
                                    <circle cx="4" cy="4" r="2"></circle>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Back to Blog -->
                    <div style="margin-top: 48px; padding-top: 32px; border-top: 1px solid rgb(229, 231, 235);">
                        <a href="{{ route('blog.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgb(55, 65, 81); text-decoration: none; font-size: 14px; font-weight: 500; padding-bottom: 8px; border-bottom: 1px solid rgb(209, 213, 219); transition: all 0.2s;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                            Retour au blog
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
        <section class="w-full bg-white" style="padding: 64px 0; border-top: 1px solid rgb(229, 231, 235);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 style="font-size: 28px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 32px; text-align: center;">Articles similaires</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
                    @foreach($relatedPosts as $relatedPost)
                        <article style="background-color: rgb(255, 255, 255); border-radius: 8px; overflow: hidden; border: 1px solid rgb(229, 231, 235); transition: all 0.2s;">
                            @if($relatedPost->featured_image)
                                <a href="{{ route('blog.show', $relatedPost->slug) }}">
                                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                                </a>
                            @endif
                            <div style="padding: 24px;">
                                @if($relatedPost->category)
                                    <span style="display: inline-block; padding: 4px 8px; background-color: rgb(31, 41, 55); color: rgb(255, 255, 255); border-radius: 4px; font-size: 11px; font-weight: 500; text-transform: uppercase; margin-bottom: 12px;">
                                        {{ $relatedPost->category->name }}
                                    </span>
                                @endif
                                <h3 style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 8px; line-height: 1.3;">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}" style="color: inherit; text-decoration: none;">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h3>
                                @if($relatedPost->excerpt)
                                    <p style="font-size: 14px; color: rgb(107, 114, 128); line-height: 1.6; margin-bottom: 12px;">
                                        {{ \Illuminate\Support\Str::limit($relatedPost->excerpt, 120) }}
                                    </p>
                                @endif
                                <div style="font-size: 12px; color: rgb(156, 163, 175);">
                                    {{ $relatedPost->published_at ? $relatedPost->published_at->format('d M Y') : $relatedPost->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="w-full text-white px-4 sm:px-6 lg:px-8" style="background: linear-gradient(180deg, rgb(15, 64, 62) 0%, rgb(22, 78, 75) 50%, rgb(25, 85, 82) 100%); padding: 64px 0 32px; color: rgb(255, 255, 255);">
            <div class="max-w-7xl mx-auto" style="padding: 0px;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12" style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 48px; margin-bottom: 32px; padding: 0px;">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center gap-3 mb-4" style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" class="block h-10 w-auto" style="height: 40px; width: auto; object-fit: contain;">
                            <span class="text-xl font-bold" style="font-size: 20px; font-weight: 700; color: rgb(255, 255, 255);">CEGME</span>
                        </div>
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

        <style>
            .article-content h1,
            .article-content h2,
            .article-content h3,
            .article-content h4,
            .article-content h5 {
                font-family: Georgia, 'Times New Roman', serif;
                font-weight: 700;
                color: rgb(17, 24, 39);
                margin-top: 32px;
                margin-bottom: 16px;
                line-height: 1.3;
            }

            .article-content h1 { font-size: 36px; }
            .article-content h2 { font-size: 30px; }
            .article-content h3 { font-size: 24px; }
            .article-content h4 { font-size: 20px; }
            .article-content h5 { font-size: 18px; }

            .article-content p {
                margin-bottom: 24px;
                color: rgb(17, 24, 39);
            }

            .article-content p:first-of-type {
                font-size: 22px;
                line-height: 1.8;
            }

            .article-content strong {
                font-weight: 700;
                color: rgb(17, 24, 39);
            }

            .article-content em {
                font-style: italic;
            }

            .article-content a {
                color: rgb(37, 99, 235);
                text-decoration: underline;
            }

            .article-content ul,
            .article-content ol {
                margin-bottom: 24px;
                padding-left: 32px;
            }

            .article-content li {
                margin-bottom: 12px;
            }

            .article-content blockquote {
                border-left: 3px solid rgb(209, 213, 219);
                background: rgb(249, 250, 251);
                padding: 24px;
                margin: 32px 0;
                border-radius: 8px;
                font-family: Georgia, 'Times New Roman', serif;
                font-style: italic;
                color: rgb(75, 85, 99);
            }

            .article-content blockquote::before {
                display: none;
            }

            .article-content img {
                max-width: 100%;
                height: auto;
                margin: 32px 0;
                border-radius: 8px;
            }

            .article-content table {
                width: 100%;
                border-collapse: collapse;
                margin: 32px 0;
            }

            .article-content table th {
                background-color: rgb(31, 41, 55);
                color: rgb(255, 255, 255);
                padding: 12px;
                text-align: left;
                font-weight: 600;
            }

            .article-content table td {
                padding: 12px;
                border-bottom: 1px solid rgb(229, 231, 235);
            }

            @media (max-width: 768px) {
                .article-content-wrapper {
                    padding: 0 16px !important;
                }

                .article-content {
                    margin-left: 0 !important;
                    margin-right: 0 !important;
                    font-size: 17px !important;
                }

                .article-content p:first-of-type {
                    font-size: 19px !important;
                }
            }
        </style>
    </body>
</html>

