<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blog et Actualités | CEGME</title>
    <meta name="description"
        content="Découvrez nos derniers articles, analyses techniques et actualités sur les mines, l'environnement et les géosciences en République Centrafricaine.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Blog et Actualités | CEGME">
    <meta property="og:description"
        content="Découvrez nos derniers articles, analyses techniques et actualités sur les mines et l'environnement.">
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

        @media (max-width: 768px) {

            body {
                overflow-x: hidden !important;
                max-width: 100vw !important;
            }

            * {
                max-width: 100% !important;
            }

            /* Mobile Header and Footer are handled globally by site-styles.blade.php */

            .blog-posts-grid {
                grid-template-columns: 1fr !important;
            }

            .blog-post-card {
                width: 100% !important;
                max-width: 520px !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .blog-post-image-wrapper {
                border-radius: 0 !important;
            }

            .blog-post-image-wrapper img {
                border-radius: 0 !important;
            }

            .blog-search-filters-row {
                flex-direction: column !important;
                align-items: stretch !important;
                justify-content: flex-start !important;
                gap: 12px !important;
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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.site-styles')
</head>

<body class="bg-white text-[#1b1b18] min-h-screen" x-data="{ activeFilter: 'all', searchQuery: '' }"
    style="background-color: #ffffff !important;">
    @include('partials.page-loader')
    <!-- Header from Contact/Services/Realisations Page -->
    <x-site-header />



    <!-- Hero Section - Page Header -->
    <section class="relative w-full flex items-center justify-center overflow-hidden blog-hero-section"
        style="min-height: 30vh; padding: 40px 0; background: linear-gradient(to right bottom, rgb(6, 78, 59), rgb(17, 94, 89), rgb(15, 23, 42));">
        <div class="relative z-10 w-full max-w-4xl mx-auto px-4 text-center blog-hero-content"
            style="margin-top: 60px;">
            <h1 class="mb-6"
                style="font-size: 60px; font-weight: 700; color: rgb(255, 255, 255); margin-bottom: 24px; text-align: center; line-height: 72px;">
                Blog & Actualités
            </h1>
            <p class="mx-auto max-w-3xl"
                style="font-size: 20px; color: rgb(229, 231, 235); text-align: center; line-height: 32.5px;">
                Découvrez nos dernières actualités, projets et expertises dans les domaines de l'environnement, des
                géosciences et des mines
            </p>
        </div>
    </section>

    <!-- Search and Filters Section -->
    <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 48px 0;">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 blog-search-filters-row"
                style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; gap: 24px;">
                <!-- Search Bar - Left -->
                <div class="relative flex-1 md:flex-none blog-search-box"
                    style="position: relative; flex: 1; min-width: 300px; max-width: 400px;">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                        style="position: absolute; top: 0; bottom: 0; left: 0; padding-left: 12px; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            style="width: 20px; height: 20px; color: rgb(156, 163, 175);">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </div>
                    <form method="GET" action="{{ route('blog.index') }}" class="w-full">
                        <input type="text" name="search" value="{{ request()->get('search') }}"
                            placeholder="Rechercher un article..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            style="width: 100%; padding-left: 44px; padding-right: 16px; padding-top: 12px; padding-bottom: 12px; border: 2px solid rgb(209, 213, 219); border-radius: 10px; font-size: 16px; background-color: #fff;">
                        @if(request()->has('category'))
                            <input type="hidden" name="category" value="{{ request()->get('category') }}">
                        @endif
                        @if(request()->has('tag'))
                            <input type="hidden" name="tag" value="{{ request()->get('tag') }}">
                        @endif
                    </form>
                </div>

                <!-- Filter Buttons - Right -->
                <div class="flex flex-wrap gap-3 justify-end blog-filter-buttons"
                    style="display: flex; flex-wrap: wrap; gap: 8px; justify-content: flex-end; align-items: center;">
                    <a href="{{ route('blog.index') }}"
                        class="px-6 py-2.5 rounded-full font-bold transition-all duration-200 {{ !request()->has('category') && !request()->has('tag') ? 'bg-teal-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                        style="padding: 10px 24px; border-radius: 9999px; font-size: 14px; font-weight: 700; text-decoration: none; display: inline-block; {{ !request()->has('category') && !request()->has('tag') ? 'background-color: rgb(20, 184, 166); color: rgb(255, 255, 255); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);' : 'background-color: rgb(243, 244, 246); color: rgb(55, 65, 81);' }}">
                        Tous
                    </a>
                    @foreach($categories as $category)
                        @if($category->posts_count > 0)
                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                class="px-6 py-2.5 rounded-full font-bold transition-all duration-200 {{ request()->get('category') === $category->slug ? 'bg-teal-500 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                style="padding: 10px 24px; border-radius: 9999px; font-size: 14px; font-weight: 700; text-decoration: none; display: inline-block; {{ request()->get('category') === $category->slug ? 'background-color: rgb(20, 184, 166); color: rgb(255, 255, 255); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);' : 'background-color: rgb(243, 244, 246); color: rgb(55, 65, 81);' }}">
                                {{ $category->name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Articles Section -->
    <section class="w-full bg-white px-4 sm:px-6 lg:px-8" style="padding: 0 0 96px 0;">
        <div class="max-w-7xl mx-auto">
            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 blog-posts-grid"
                    style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 32px;">
                    @foreach($posts as $post)
                        <article
                            class="bg-white rounded-2xl shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow blog-post-card"
                            style="background-color: rgb(255, 255, 255); border-radius: 24px; padding: 0px; box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.1) 0px 4px 6px -4px; cursor: pointer;"
                            onclick="window.location.href='{{ route('blog.show', $post->slug) }}'">
                            <div class="relative blog-post-image-wrapper"
                                style="position: relative; border-radius: 24px; overflow: hidden;">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                        class="w-full h-48 object-cover" style="width: 100%; height: 240px; object-fit: cover;">
                                @else
                                    <div class="w-full h-48 bg-gray-200"
                                        style="width: 100%; height: 240px; background-color: rgb(229, 231, 235);"></div>
                                @endif
                                @if($post->category)
                                    <div class="absolute top-4 left-4 bg-gray-800 text-white px-3 py-1 rounded-full text-sm font-medium"
                                        style="position: absolute; top: 16px; left: 16px; background-color: rgb(31, 41, 55); color: rgb(255, 255, 255); padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500;">
                                        {{ $post->category->name }}
                                    </div>
                                @endif
                            </div>
                            <div class="p-6" style="padding: 24px;">
                                <h3 class="text-xl font-bold mb-3"
                                    style="font-size: 20px; font-weight: 700; color: rgb(17, 24, 39); margin-bottom: 12px; line-height: 28px;">
                                    {{ $post->title }}
                                </h3>
                                @if($post->excerpt)
                                    <p class="text-gray-600 mb-4"
                                        style="font-size: 16px; color: rgb(75, 85, 99); line-height: 26px; margin-bottom: 16px;">
                                        {{ \Illuminate\Support\Str::limit($post->excerpt, 150) }}
                                    </p>
                                @endif
                                <div class="flex items-center justify-between mb-4 text-sm text-gray-500"
                                    style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; font-size: 14px; color: rgb(107, 114, 128);">
                                    <div class="flex items-center gap-4" style="display: flex; align-items: center; gap: 16px;">
                                        <div class="flex items-center gap-2"
                                            style="display: flex; align-items: center; gap: 8px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" style="width: 16px; height: 16px;">
                                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                            <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2"
                                            style="display: flex; align-items: center; gap: 8px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" style="width: 16px; height: 16px;">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                            <span>{{ $post->user->name ?? 'CEGME' }}</span>
                                        </div>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" style="width: 20px; height: 20px; color: #10b981;">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                                @if($post->tags->count() > 0)
                                    <div class="flex flex-wrap gap-2" style="display: flex; flex-wrap: wrap; gap: 8px;">
                                        @foreach($post->tags->take(3) as $tag)
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium flex items-center gap-1.5"
                                                style="padding: 4px 12px; background-color: rgb(243, 244, 246); color: rgb(55, 65, 81); border-radius: 9999px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" style="width: 14px; height: 14px;">
                                                    <path
                                                        d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                                                    </path>
                                                    <line x1="7" y1="7" x2="7.01" y2="7"></line>
                                                </svg>
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                    <div class="mt-12" style="margin-top: 48px;">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16" style="text-align: center; padding: 64px 0;">
                    @if(request()->has('search') || request()->has('category') || request()->has('tag'))
                        <p style="font-size: 18px; color: rgb(107, 114, 128); margin-bottom: 16px;">
                            Aucun article trouvé avec ces critères de recherche.
                        </p>
                        <a href="{{ route('blog.index') }}"
                            style="display: inline-block; padding: 10px 20px; background-color: rgb(5, 150, 105); color: rgb(255, 255, 255); border-radius: 6px; text-decoration: none; font-weight: 500;">
                            Voir tous les articles
                        </a>
                    @else
                        <p style="font-size: 18px; color: rgb(107, 114, 128);">Aucun article disponible pour le moment.</p>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <x-site-footer />

    <!-- Site Scripts -->
    @include('partials.site-scripts')
</body>

</html>