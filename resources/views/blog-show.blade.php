<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="{{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content), 160) }}">

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

        @media (max-width: 768px) {
            body {
                overflow-x: hidden !important;
                max-width: 100vw !important;
            }

            * {
                max-width: 100% !important;
            }


        }
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



    <!-- Hero Section - Article Header -->
    <section class="relative w-full flex items-center justify-center overflow-hidden blog-show-hero-section"
        style="min-height: 50vh; padding-top: 100px; padding-bottom: 80px; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%); position: relative;">
        @if($post->header_image ?? $post->featured_image)
            <div class="absolute inset-0 z-0" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;">
                <img src="{{ asset('storage/' . ($post->header_image ?? $post->featured_image)) }}" alt="{{ $post->title }}"
                    style="width: 100%; height: 100%; object-fit: cover;">
                <!-- Overlay élégant pour améliorer la lisibilité -->
                <div
                    style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(26, 26, 26, 0.92) 0%, rgba(45, 45, 45, 0.88) 50%, rgba(26, 26, 26, 0.95) 100%); z-index: 1;">
                </div>
            </div>
        @endif
        <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 blog-show-hero-container"
            style="position: relative; z-index: 10;">
            <!-- Contenu organisé verticalement avec espacement professionnel -->
            <div class="blog-show-hero-inner" style="max-width: 900px; margin: 0 auto;">
                <!-- Lien retour - première ligne -->
                <div style="margin-bottom: 40px;">
                    <a href="{{ route('blog.index') }}"
                        style="color: rgba(255, 255, 255, 0.7); text-decoration: none; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s ease; letter-spacing: 0.5px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
                        onmouseover="this.style.color='rgba(255, 255, 255, 1)'; this.style.gap='12px';"
                        onmouseout="this.style.color='rgba(255, 255, 255, 0.7)'; this.style.gap='10px';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 14px; height: 14px;">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        Retour au blog
                    </a>
                </div>

                <!-- Catégorie -->
                @if($post->category)
                    <div style="margin-bottom: 24px;">
                        <span
                            style="display: inline-block; padding: 6px 16px; background-color: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.15); color: rgba(255, 255, 255, 0.85); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; border-radius: 4px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                            {{ $post->category->name }}
                        </span>
                    </div>
                @endif

                <!-- Titre - Design Magazine Premium -->
                <div style="margin-bottom: 48px;">
                    <h1
                        style="font-size: clamp(42px, 6vw, 64px); font-weight: 700; color: rgb(255, 255, 255); line-height: 1.1; text-align: left; letter-spacing: -1px; margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
                        {{ $post->title }}
                    </h1>
                </div>

                <!-- Métadonnées élégantes -->
                <div
                    style="display: flex; align-items: center; gap: 28px; flex-wrap: wrap; color: rgba(255, 255, 255, 0.75); font-size: 14px; font-weight: 400; padding-top: 32px; border-top: 1px solid rgba(255, 255, 255, 0.15); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    <span style="display: inline-flex; align-items: center; gap: 8px; font-weight: 400;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 16px; height: 16px; opacity: 0.6;">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                    </span>
                    <span style="opacity: 0.3; font-size: 18px;">•</span>
                    <span style="display: inline-flex; align-items: center; gap: 8px; font-weight: 400;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 16px; height: 16px; opacity: 0.6;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        {{ $post->user->name ?? 'CEGME' }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <section class="w-full bg-white blog-show-main-section"
        style="padding: 100px 0 80px; min-height: 300px; background: #ffffff;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="article-content-wrapper" style="max-width: 900px; margin: 0 auto; padding: 0 60px;">
                @if($post->excerpt)
                    <div class="excerpt"
                        style="background: #f8f9fa; border-left: 3px solid #1a1a1a; padding: 40px 48px; margin-bottom: 64px; margin-top: -20px; font-size: 24px; color: #2d2d2d; line-height: 1.65; font-weight: 400; letter-spacing: -0.3px; font-family: 'Georgia', 'Times New Roman', serif; font-style: italic;">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <div class="article-content"
                    style="font-family: 'Georgia', 'Times New Roman', 'Times', serif; font-size: 22px; line-height: 1.8; color: #1a1a1a; letter-spacing: -0.01em; font-weight: 400;">
                    {!! $post->content !!}
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div style="margin-top: 48px; padding-top: 32px; border-top: 1px solid #e5e7eb;">
                        <h3
                            style="font-size: 11px; font-weight: 600; color: #6b7280; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 2px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                            Mots-clés</h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            @foreach($post->tags as $tag)
                                <span
                                    style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background-color: #f3f4f6; color: #374151; border: none; border-radius: 4px; font-size: 13px; font-weight: 500; transition: all 0.2s ease; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
                                    onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#1f2937';"
                                    onmouseout="this.style.backgroundColor='#f3f4f6'; this.style.color='#374151';">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Share Buttons -->
                <div style="margin-top: 80px; padding-top: 48px; border-top: 1px solid #e5e7eb;">
                    <h3
                        style="font-size: 11px; font-weight: 600; color: #6b7280; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 2px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        Partager cet article</h3>
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                            target="_blank"
                            style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; background-color: #1877F2; color: rgb(255, 255, 255); border: none; border-radius: 6px; text-decoration: none; transition: all 0.2s ease; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
                            onmouseover="this.style.backgroundColor='#166FE5'; this.style.transform='translateY(-1px)';"
                            onmouseout="this.style.backgroundColor='#1877F2'; this.style.transform='translateY(0)';"
                            title="Partager sur Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                            target="_blank"
                            style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; background-color: #0077B5; color: rgb(255, 255, 255); border: none; border-radius: 6px; text-decoration: none; transition: all 0.2s ease; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
                            onmouseover="this.style.backgroundColor='#006399'; this.style.transform='translateY(-1px)';"
                            onmouseout="this.style.backgroundColor='#0077B5'; this.style.transform='translateY(0)';"
                            title="Partager sur LinkedIn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                                </path>
                                <rect x="2" y="9" width="4" height="12"></rect>
                                <circle cx="4" cy="4" r="2"></circle>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                            target="_blank"
                            style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; background-color: #000000; color: rgb(255, 255, 255); border: none; border-radius: 6px; text-decoration: none; transition: all 0.2s ease; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
                            onmouseover="this.style.backgroundColor='#1a1a1a'; this.style.transform='translateY(-1px)';"
                            onmouseout="this.style.backgroundColor='#000000'; this.style.transform='translateY(0)';"
                            title="Partager sur X (Twitter)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z">
                                </path>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}"
                            target="_blank"
                            style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; background-color: #25D366; color: rgb(255, 255, 255); border: none; border-radius: 6px; text-decoration: none; transition: all 0.2s ease; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
                            onmouseover="this.style.backgroundColor='#20BA5A'; this.style.transform='translateY(-1px)';"
                            onmouseout="this.style.backgroundColor='#25D366'; this.style.transform='translateY(0)';"
                            title="Partager sur WhatsApp">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z">
                                </path>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank"
                            style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: rgb(255, 255, 255); border: none; border-radius: 6px; text-decoration: none; transition: all 0.2s ease; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;"
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.opacity='0.9';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.opacity='1';"
                            title="Partager sur Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <section class="w-full bg-white" style="padding: 100px 0; border-top: 1px solid #e5e7eb; background: #ffffff;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div style="text-align: center; margin-bottom: 64px;">
                    <h2
                        style="font-size: 36px; font-weight: 700; color: #1a1a1a; margin-bottom: 16px; letter-spacing: -1px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        Articles similaires</h2>
                    <p
                        style="font-size: 16px; color: #6b7280; max-width: 600px; margin: 0 auto; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        Découvrez d'autres articles qui pourraient vous intéresser</p>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px;">
                    @foreach($relatedPosts as $relatedPost)
                        <article
                            style="background-color: #ffffff; border-radius: 0; overflow: hidden; border: 1px solid #e5e7eb; transition: all 0.3s ease;"
                            onmouseover="this.style.borderColor='#d1d5db'; this.style.transform='translateY(-2px)';"
                            onmouseout="this.style.borderColor='#e5e7eb'; this.style.transform='translateY(0)';">
                            @if($relatedPost->featured_image)
                                <a href="{{ route('blog.show', $relatedPost->slug) }}" style="display: block; overflow: hidden;">
                                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}"
                                        alt="{{ $relatedPost->title }}"
                                        style="width: 100%; height: 240px; object-fit: cover; transition: transform 0.3s ease;"
                                        onmouseover="this.style.transform='scale(1.03)';"
                                        onmouseout="this.style.transform='scale(1)';">
                                </a>
                            @endif
                            <div style="padding: 32px;">
                                @if($relatedPost->category)
                                    <span
                                        style="display: inline-block; padding: 4px 12px; background-color: #f3f4f6; color: #374151; border-radius: 4px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 20px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                        {{ $relatedPost->category->name }}
                                    </span>
                                @endif
                                <h3
                                    style="font-size: 24px; font-weight: 700; color: #1a1a1a; margin-bottom: 16px; line-height: 1.3; letter-spacing: -0.5px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}"
                                        style="color: inherit; text-decoration: none; transition: color 0.2s;"
                                        onmouseover="this.style.color='#000000';" onmouseout="this.style.color='#1a1a1a';">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h3>
                                @if($relatedPost->excerpt)
                                    <p
                                        style="font-size: 16px; color: #6b7280; line-height: 1.6; margin-bottom: 20px; font-family: 'Georgia', 'Times New Roman', serif;">
                                        {{ \Illuminate\Support\Str::limit($relatedPost->excerpt, 140) }}
                                    </p>
                                @endif
                                <div
                                    style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #9ca3af; font-weight: 400; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    {{ $relatedPost->published_at ? $relatedPost->published_at->format('d M Y') : $relatedPost->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-site-footer />

    <style>
        /* IMPORTANT: Les styles inline de Quill ont TOUJOURS priorité */
        /* Ne pas écraser les styles inline générés par Quill */

        /* Design professionnel style grand blog */
        .article-content {
            font-family: 'Georgia', 'Times New Roman', 'Times', serif;
            font-size: 22px;
            line-height: 1.8;
            color: #1a1a1a;
            letter-spacing: -0.01em;
            font-weight: 400;
        }

        /* Par défaut, tous les éléments sont en poids normal (pas de gras) */
        .article-content * {
            font-weight: normal;
        }

        /* PRIORITÉ ABSOLUE : Les styles inline de Quill ont toujours priorité - JAMAIS écrasés */
        .article-content *[style] {
            /* Tous les styles inline sont préservés - ne jamais écraser */
            /* Les styles inline ont naturellement la priorité la plus élevée en CSS */
        }

        /* S'assurer qu'aucune règle CSS n'écrase les styles inline */
        .article-content *[style*="font-weight"] {
            /* Respecter le poids défini dans Quill - ne jamais forcer */
        }

        .article-content *[style*="text-align"] {
            /* Respecter l'alignement défini dans Quill - ne jamais forcer */
        }

        .article-content *[style*="color"] {
            /* Respecter la couleur définie dans Quill - ne jamais forcer */
        }

        .article-content *[style*="background"] {
            /* Respecter le fond défini dans Quill - ne jamais forcer */
        }

        .article-content *[style*="text-decoration"] {
            /* Respecter la décoration définie dans Quill - ne jamais forcer */
        }

        .article-content *[style*="font-style"] {
            /* Respecter le style défini dans Quill - ne jamais forcer */
        }

        /* Titres - design professionnel grand blog */
        .article-content h1,
        .article-content h2,
        .article-content h3,
        .article-content h4,
        .article-content h5 {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            margin-top: 56px;
            margin-bottom: 24px;
            line-height: 1.25;
            font-weight: 700;
            color: #1a1a1a;
            letter-spacing: -0.5px;
        }

        /* Tailles par défaut pour les titres SEULEMENT si Quill n'a pas défini de taille */
        .article-content h1:not([style*="font-size"]) {
            font-size: 36px;
        }

        .article-content h2:not([style*="font-size"]) {
            font-size: 30px;
        }

        .article-content h3:not([style*="font-size"]) {
            font-size: 24px;
        }

        .article-content h4:not([style*="font-size"]) {
            font-size: 20px;
        }

        .article-content h5:not([style*="font-size"]) {
            font-size: 18px;
        }

        /* Respecter le poids défini par Quill dans les styles inline */
        .article-content h1[style*="font-weight"],
        .article-content h2[style*="font-weight"],
        .article-content h3[style*="font-weight"],
        .article-content h4[style*="font-weight"],
        .article-content h5[style*="font-weight"] {
            /* Le style inline a priorité - ne rien forcer */
        }

        /* Par défaut, les titres sont en gras pour le design professionnel */
        .article-content h1:not([style*="font-weight"]):not([class*="ql-"]),
        .article-content h2:not([style*="font-weight"]):not([class*="ql-"]),
        .article-content h3:not([style*="font-weight"]):not([class*="ql-"]),
        .article-content h4:not([style*="font-weight"]):not([class*="ql-"]),
        .article-content h5:not([style*="font-weight"]):not([class*="ql-"]) {
            font-weight: 700;
        }

        /* Paragraphes - design professionnel */
        .article-content p {
            margin-bottom: 32px;
            font-size: 22px;
            line-height: 1.8;
            color: #1a1a1a;
            letter-spacing: -0.01em;
            font-weight: 400;
        }

        /* Par défaut, poids normal SAUF si Quill a défini autre chose */
        .article-content p:not([style*="font-weight"]):not([class*="ql-bold"]):not(strong):not(b) {
            font-weight: normal;
        }

        /* Respecter le poids défini par Quill dans les styles inline */
        .article-content p[style*="font-weight"] {
            /* Le style inline a priorité absolue */
        }

        /* Respecter les classes Quill pour le gras */
        .article-content p[class*="ql-bold"],
        .article-content [class*="ql-bold"] {
            font-weight: 700 !important;
        }

        /* Couleur par défaut SEULEMENT si Quill n'a pas défini de couleur */
        .article-content p:not([style*="color"]):not([class*="ql-color"]) {
            color: rgb(17, 24, 39);
        }

        /* Premier paragraphe - style grand blog */
        .article-content p:first-of-type:not([style*="font-size"]) {
            font-size: 26px;
            line-height: 1.75;
            color: #2d2d2d;
            font-weight: 400;
            margin-bottom: 40px;
            letter-spacing: -0.02em;
        }

        /* Gras - seulement si explicitement défini dans Quill */
        /* Balises HTML - seulement si elles ont été explicitement mises en gras */
        .article-content strong[style*="font-weight"],
        .article-content b[style*="font-weight"],
        .article-content strong[class*="ql-bold"],
        .article-content b[class*="ql-bold"] {
            font-weight: 700 !important;
        }

        /* Par défaut, strong et b sont en poids normal (même s'ils sont des balises HTML) */
        .article-content strong:not([style*="font-weight"]):not([class*="ql-bold"]),
        .article-content b:not([style*="font-weight"]):not([class*="ql-bold"]) {
            font-weight: normal !important;
        }

        /* Styles inline de Quill - seulement si explicitement défini */
        .article-content [style*="font-weight: bold"],
        .article-content [style*="font-weight:700"],
        .article-content [style*="font-weight: 700"],
        .article-content [style*="font-weight:bold"] {
            font-weight: 700 !important;
        }

        /* Classes Quill - seulement si explicitement appliquées */
        .article-content [class*="ql-bold"],
        .article-content .ql-bold {
            font-weight: 700 !important;
        }

        /* Ne pas forcer la couleur sur strong si Quill a défini une couleur */
        .article-content strong:not([style*="color"]),
        .article-content b:not([style*="color"]) {
            color: inherit;
        }

        /* Italique - respecter TOUS les formats */
        .article-content em,
        .article-content i {
            font-style: italic !important;
        }

        .article-content [style*="font-style: italic"],
        .article-content [class*="ql-italic"],
        .article-content .ql-italic {
            font-style: italic !important;
        }

        /* Souligné - respecter TOUS les formats */
        .article-content u {
            text-decoration: underline !important;
        }

        .article-content [style*="text-decoration: underline"],
        .article-content [class*="ql-underline"],
        .article-content .ql-underline {
            text-decoration: underline !important;
        }

        /* Barré - respecter TOUS les formats */
        .article-content s,
        .article-content strike {
            text-decoration: line-through !important;
        }

        .article-content [style*="text-decoration: line-through"],
        .article-content [class*="ql-strike"],
        .article-content .ql-strike {
            text-decoration: line-through !important;
        }

        /* Liens */
        .article-content a {
            color: rgb(37, 99, 235);
            text-decoration: underline;
        }

        /* Respecter les couleurs définies dans Quill */
        .article-content [style*="color"] {
            /* Les styles inline ont priorité - ne pas écraser */
        }

        /* Respecter les couleurs de fond définies dans Quill */
        .article-content [style*="background-color"],
        .article-content [style*="background"] {
            /* Les styles inline ont priorité */
        }

        /* Listes - design professionnel */
        .article-content ul,
        .article-content ol {
            margin-bottom: 32px;
            padding-left: 32px;
            line-height: 1.8;
        }

        .article-content ul li,
        .article-content ol li {
            margin-bottom: 16px;
            font-size: 22px;
            line-height: 1.8;
            color: #1a1a1a;
        }

        .article-content ul[style*="text-align: center"],
        .article-content ol[style*="text-align: center"] {
            padding-left: 0;
            list-style-position: inside;
            text-align: center !important;
        }

        .article-content ul[style*="text-align: right"],
        .article-content ol[style*="text-align: right"] {
            padding-left: 0;
            padding-right: 32px;
            list-style-position: inside;
            text-align: right !important;
        }

        .article-content li {
            margin-bottom: 12px;
            font-weight: normal;
        }

        .article-content li[style*="text-align"] {
            /* Respecter l'alignement défini dans Quill pour les éléments de liste */
        }

        /* Gras dans les listes - seulement si explicitement défini */
        .article-content li strong[style*="font-weight"],
        .article-content li b[style*="font-weight"],
        .article-content li strong[class*="ql-bold"],
        .article-content li b[class*="ql-bold"] {
            font-weight: 700 !important;
        }

        /* Par défaut, strong et b dans les listes sont en poids normal */
        .article-content li strong:not([style*="font-weight"]):not([class*="ql-bold"]),
        .article-content li b:not([style*="font-weight"]):not([class*="ql-bold"]) {
            font-weight: normal !important;
        }

        /* Respecter les styles inline de Quill - les styles inline ont toujours priorité */
        /* Ne pas écraser les styles inline générés par Quill */

        /* Styles inline de Quill ont toujours priorité - ne pas écraser */
        .article-content *[style] {
            /* Respecter tous les styles inline générés par Quill */
        }

        /* Assurer que les styles inline ne sont pas écrasés */
        .article-content [style*="font-weight"] {
            /* Respecter le poids défini dans Quill */
        }

        .article-content [style*="font-style"] {
            /* Respecter le style défini dans Quill */
        }

        .article-content [style*="text-decoration"] {
            /* Respecter la décoration définie dans Quill */
        }

        .article-content [style*="color"] {
            /* Respecter la couleur définie dans Quill */
        }

        .article-content [style*="background"] {
            /* Respecter le fond défini dans Quill */
        }

        /* Alignement du texte - respecter les classes et styles inline de Quill */
        /* Les styles inline ont toujours priorité - respecter l'alignement défini dans Quill */

        /* Classes d'alignement de Quill - PRIORITÉ ABSOLUE */
        .article-content .ql-align-center,
        .article-content [class*="ql-align-center"],
        .article-content p.ql-align-center,
        .article-content div.ql-align-center,
        .article-content h1.ql-align-center,
        .article-content h2.ql-align-center,
        .article-content h3.ql-align-center,
        .article-content h4.ql-align-center,
        .article-content h5.ql-align-center {
            text-align: center !important;
        }

        .article-content .ql-align-right,
        .article-content [class*="ql-align-right"],
        .article-content p.ql-align-right,
        .article-content div.ql-align-right,
        .article-content h1.ql-align-right,
        .article-content h2.ql-align-right,
        .article-content h3.ql-align-right,
        .article-content h4.ql-align-right,
        .article-content h5.ql-align-right {
            text-align: right !important;
        }

        .article-content .ql-align-justify,
        .article-content [class*="ql-align-justify"],
        .article-content p.ql-align-justify,
        .article-content div.ql-align-justify {
            text-align: justify !important;
        }

        .article-content .ql-align-left,
        .article-content [class*="ql-align-left"],
        .article-content p.ql-align-left,
        .article-content div.ql-align-left {
            text-align: left !important;
        }

        /* Respecter les styles inline pour l'alignement - PRIORITÉ ABSOLUE */
        .article-content p[style*="text-align: center"],
        .article-content div[style*="text-align: center"],
        .article-content h1[style*="text-align: center"],
        .article-content h2[style*="text-align: center"],
        .article-content h3[style*="text-align: center"],
        .article-content h4[style*="text-align: center"],
        .article-content h5[style*="text-align: center"],
        .article-content span[style*="text-align: center"],
        .article-content li[style*="text-align: center"] {
            text-align: center !important;
        }

        .article-content p[style*="text-align: right"],
        .article-content div[style*="text-align: right"],
        .article-content h1[style*="text-align: right"],
        .article-content h2[style*="text-align: right"],
        .article-content h3[style*="text-align: right"],
        .article-content h4[style*="text-align: right"],
        .article-content h5[style*="text-align: right"],
        .article-content span[style*="text-align: right"],
        .article-content li[style*="text-align: right"] {
            text-align: right !important;
        }

        .article-content p[style*="text-align: justify"],
        .article-content div[style*="text-align: justify"],
        .article-content h1[style*="text-align: justify"],
        .article-content h2[style*="text-align: justify"],
        .article-content h3[style*="text-align: justify"],
        .article-content h4[style*="text-align: justify"],
        .article-content h5[style*="text-align: justify"],
        .article-content span[style*="text-align: justify"] {
            text-align: justify !important;
        }

        .article-content p[style*="text-align: left"],
        .article-content div[style*="text-align: left"],
        .article-content h1[style*="text-align: left"],
        .article-content h2[style*="text-align: left"],
        .article-content h3[style*="text-align: left"],
        .article-content h4[style*="text-align: left"],
        .article-content h5[style*="text-align: left"],
        .article-content span[style*="text-align: left"],
        .article-content li[style*="text-align: left"] {
            text-align: left !important;
        }

        /* Ne pas forcer l'alignement par défaut - laisser Quill décider */
        .article-content p:not([style*="text-align"]):not([class*="ql-align"]) {
            text-align: left;
        }

        .article-content h1:not([style*="text-align"]):not([class*="ql-align"]),
        .article-content h2:not([style*="text-align"]):not([class*="ql-align"]),
        .article-content h3:not([style*="text-align"]):not([class*="ql-align"]),
        .article-content h4:not([style*="text-align"]):not([class*="ql-align"]),
        .article-content h5:not([style*="text-align"]):not([class*="ql-align"]) {
            text-align: left;
        }

        .article-content blockquote {
            border-left: 3px solid #1a1a1a;
            background: #f8f9fa;
            padding: 40px 48px;
            margin: 56px 0;
            border-radius: 0;
            font-family: Georgia, 'Times New Roman', serif;
            font-style: italic;
            font-size: 24px;
            line-height: 1.65;
            color: #2d2d2d;
            letter-spacing: -0.02em;
        }

        .article-content blockquote::before {
            display: none;
        }

        .article-content img {
            width: 100%;
            max-width: 100%;
            height: 450px;
            object-fit: cover;
            margin: 56px auto;
            border-radius: 0;
            display: block;
        }

        /* Uniformiser la taille de toutes les images dans le contenu */
        .article-content img,
        .article-content img[style*="width"],
        .article-content img[style*="height"] {
            width: 100% !important;
            max-width: 100% !important;
            height: 450px !important;
            object-fit: cover !important;
            margin: 56px auto !important;
            border-radius: 0 !important;
            display: block !important;
        }

        /* Respecter la rotation définie dans l'éditeur */
        .article-content img[style*="transform"] {
            /* Respecter la rotation définie dans l'éditeur */
        }

        /* Images alignées - respecter l'alignement défini dans Quill */
        .article-content img[style*="text-align: center"],
        .article-content p[style*="text-align: center"] img,
        .article-content div[style*="text-align: center"] img,
        .article-content .ql-align-center img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .article-content img[style*="text-align: right"],
        .article-content p[style*="text-align: right"] img,
        .article-content div[style*="text-align: right"] img,
        .article-content .ql-align-right img {
            display: block;
            margin-left: auto;
            margin-right: 0;
        }

        .article-content img[style*="text-align: left"],
        .article-content p[style*="text-align: left"] img,
        .article-content div[style*="text-align: left"] img,
        .article-content .ql-align-left img {
            display: block;
            margin-left: 0;
            margin-right: auto;
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
                padding: 0 24px !important;
            }

            .article-content {
                margin-left: 0 !important;
                margin-right: 0 !important;
                font-size: 19px !important;
                line-height: 1.75 !important;
            }

            .article-content p:first-of-type {
                font-size: 22px !important;
                line-height: 1.7 !important;
            }

            .article-content h1,
            .article-content h2,
            .article-content h3 {
                font-size: 28px !important;
                margin-top: 40px !important;
            }
        }
    </style>
    @include('partials.site-scripts')
</body>

</html>