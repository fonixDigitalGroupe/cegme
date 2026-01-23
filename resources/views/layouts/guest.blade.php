<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('Image/CEGME favicon.JPG') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Site Styles -->
    @include('partials.site-styles')
</head>

<body class="font-sans text-gray-900 antialiased flex flex-col min-h-screen">
    <x-site-header />

    <main class="flex-grow flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50"
        style="padding-top: 80px; padding-bottom: 40px; min-height: calc(100vh - 80px);">
        <div
            class="w-full sm:max-w-md px-8 py-10 bg-white shadow-lg overflow-hidden rounded-2xl border border-gray-100">
            {{ $slot }}
        </div>
    </main>


    <!-- Site Scripts -->
    @include('partials.site-scripts')
</body>

</html>