<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #d1d5db;
            padding: 1rem 2rem;
            box-shadow: none;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 2rem;
        }
        .header-nav a,
        .header-nav button {
            color: #374151;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            padding: 0.5rem 0.875rem;
            border-radius: 3px;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .header-nav a:hover,
        .header-nav button:hover {
            color: #1a1a1a;
            background-color: #f3f4f6;
        }
        .header-nav a.active,
        .header-nav button.active {
            color: #00C853;
            background-color: transparent;
            font-weight: 600;
        }
        .header-nav-icon {
            width: 16px;
            height: 16px;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }
        .header-nav-separator {
            width: 1px;
            height: 20px;
            background-color: #d1d5db;
            margin: 0 0.5rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .btn-primary {
            background-color: #1a1a1a;
            color: #ffffff;
            border-color: #1a1a1a;
        }
        .btn-primary:hover {
            background-color: #000000;
            border-color: #000000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        .btn-secondary {
            background-color: #64748b;
            color: #ffffff;
            border-color: #64748b;
        }
        .btn-secondary:hover {
            background-color: #475569;
            border-color: #475569;
            box-shadow: 0 4px 6px rgba(71, 85, 105, 0.2);
            transform: translateY(-1px);
        }
        .btn-danger {
            background-color: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
        }
        .btn-danger:hover {
            background-color: #b91c1c;
            border-color: #b91c1c;
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.2);
            transform: translateY(-1px);
        }
        .btn-link {
            color: #2563eb;
            text-decoration: none;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .btn-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            background-color: #ffffff;
        }
        .form-input:focus {
            outline: none;
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
            background-color: #ffffff;
        }
        textarea.form-input {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }
        .form-label {
            display: block;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.625rem;
            font-size: 0.875rem;
            letter-spacing: 0.01em;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }
        .table thead {
            background: #f9fafb;
            border-bottom: 2px solid #d1d5db;
        }
        .table th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #374151;
            border-right: 1px solid #e5e7eb;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            color: #1a1a1a;
            font-size: 0.875rem;
            vertical-align: middle;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .table tbody tr {
            transition: background-color 0.1s ease;
        }
        .table tbody tr:hover {
            background-color: #f9fafb;
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            border: 1px solid #e5e7eb;
        }
        
        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding: 0.75rem 1rem;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-top: none;
            border-radius: 0 0 4px 4px;
        }
        .pagination > div {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.375rem 0.75rem;
            border-radius: 3px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            transition: all 0.15s ease;
            border: 1px solid #d1d5db;
        }
        .pagination a {
            color: #374151;
            background-color: #ffffff;
        }
        .pagination a:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }
        .pagination span {
            color: #ffffff;
            background-color: #2563eb;
            border-color: #2563eb;
        }
        .pagination .disabled {
            color: #9ca3af;
            background-color: #f3f4f6;
            cursor: not-allowed;
        }
        
        /* Dropdown Styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-toggle {
            cursor: pointer;
        }
        .dropdown-arrow {
            transition: transform 0.2s ease;
        }
        .dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 1000;
            margin-top: 0.5rem;
            padding: 0.5rem 0;
        }
        .dropdown.active .dropdown-menu {
            display: block;
        }
        .dropdown-item {
            display: block;
            padding: 0.625rem 1rem;
            color: #374151;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            transition: background-color 0.2s ease;
        }
        .dropdown-item:hover {
            background-color: #f9fafb;
        }
        .dropdown-item.active {
            background-color: transparent;
            color: #00C853;
            font-weight: 600;
        }
    </style>
    <script>
        function toggleDropdown(element) {
            const dropdown = element.closest('.dropdown');
            const isActive = dropdown.classList.contains('active');
            
            // Fermer tous les autres dropdowns
            document.querySelectorAll('.dropdown').forEach(d => {
                d.classList.remove('active');
            });
            
            // Toggle le dropdown actuel
            if (!isActive) {
                dropdown.classList.add('active');
            }
        }
        
        // Fermer le dropdown quand on clique ailleurs
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown').forEach(d => {
                    d.classList.remove('active');
                });
            }
        });
    </script>
</head>
<body>
    @include('partials.page-loader')
    <!-- Header -->
    <header class="header">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" style="height: 48px; width: auto; object-fit: contain;">
                <div>
                    <h1 style="font-size: 1.25rem; font-weight: 700; margin: 0; letter-spacing: -0.02em; color: #00C853; line-height: 1.2; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">CEGME</h1>
                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0.125rem 0 0 0; font-weight: 400; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">Géosciences • Mines • Environnement</p>
                </div>
            </div>
            <nav class="header-nav">
                <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    Articles
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    Utilisateurs
                </a>
                @endif
                <div class="dropdown {{ request()->routeIs('admin.filtering-rules.*') || request()->routeIs('admin.activity-poles.*') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle {{ request()->routeIs('admin.filtering-rules.*') || request()->routeIs('admin.activity-poles.*') ? 'active' : '' }}" onclick="event.preventDefault(); toggleDropdown(this);">
                        Offres
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="dropdown-arrow">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('admin.filtering-rules.index') }}" class="dropdown-item {{ request()->routeIs('admin.filtering-rules.*') ? 'active' : '' }}">
                            Sources de filtrage
                        </a>
                        <a href="{{ route('admin.activity-poles.index') }}" class="dropdown-item {{ request()->routeIs('admin.activity-poles.*') ? 'active' : '' }}">
                            Pôles d'activité
                        </a>
                    </div>
                </div>
                <div class="dropdown {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                    <a href="#" class="dropdown-toggle {{ request()->routeIs('admin.categories.*') || request()->routeIs('admin.tags.*') ? 'active' : '' }}" onclick="event.preventDefault(); toggleDropdown(this);">
                        Paramètres
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="dropdown-arrow">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('admin.categories.index') }}" class="dropdown-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            Catégories
                        </a>
                        <a href="{{ route('admin.tags.index') }}" class="dropdown-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                            Tags
                        </a>
                    </div>
                </div>
                <span class="header-nav-separator"></span>
                <a href="{{ route('home') }}" target="_blank" style="color: #374151;">
                    <svg class="header-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Site public
                </a>
                <span class="header-nav-separator"></span>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="{{ request()->routeIs('logout') ? 'active' : '' }}" style="color: #dc2626;" onmouseover="this.style.backgroundColor='#fee2e2'; this.style.color='#991b1b';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#dc2626';">
                        Déconnexion
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div style="padding: 2.5rem 3rem; min-height: calc(100vh - 80px);">
            @if(session('success'))
                <div id="success-message" style="background-color: rgba(0, 200, 83, 0.1); border: 1px solid rgba(0, 200, 83, 0.3); color: #00C853; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; max-width: 400px; font-size: 0.875rem; font-weight: 500; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; box-shadow: 0 1px 3px rgba(0, 200, 83, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                        <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path>
                        <path d="m6 10 2 2 6-6"></path>
                    </svg>
                    <span style="flex: 1;">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #00C853; cursor: pointer; padding: 0; margin-left: 0.5rem; display: flex; align-items: center; opacity: 0.6; transition: opacity 0.2s; font-size: 18px; line-height: 1; width: 20px; height: 20px; justify-content: center;" onmouseover="this.style.opacity='1';" onmouseout="this.style.opacity='0.6';" title="Fermer">
                        ×
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        var msg = document.getElementById('success-message');
                        if (msg) {
                            msg.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                            msg.style.opacity = '0';
                            msg.style.transform = 'translateY(-10px)';
                            setTimeout(function() { msg.remove(); }, 300);
                        }
                    }, 3000);
                </script>
            @endif

            @if(session('error'))
                <div id="error-message" style="background-color: rgba(220, 38, 38, 0.1); border: 1px solid rgba(220, 38, 38, 0.3); color: #dc2626; padding: 0.75rem 1rem; border-radius: 4px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; max-width: 400px; font-size: 0.875rem; font-weight: 500; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; box-shadow: 0 1px 3px rgba(220, 38, 38, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                        <circle cx="10" cy="10" r="8"></circle>
                        <path d="m10 6 0 4"></path>
                        <path d="m10 14 0.01 0"></path>
                    </svg>
                    <span style="flex: 1;">{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #dc2626; cursor: pointer; padding: 0; margin-left: 0.5rem; display: flex; align-items: center; opacity: 0.6; transition: opacity 0.2s; font-size: 18px; line-height: 1; width: 20px; height: 20px; justify-content: center;" onmouseover="this.style.opacity='1';" onmouseout="this.style.opacity='0.6';" title="Fermer">
                        ×
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        var msg = document.getElementById('error-message');
                        if (msg) {
                            msg.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                            msg.style.opacity = '0';
                            msg.style.transform = 'translateY(-10px)';
                            setTimeout(function() { msg.remove(); }, 300);
                        }
                    }, 4000);
                </script>
            @endif

            @yield('content')
    </div>
</body>
</html>

