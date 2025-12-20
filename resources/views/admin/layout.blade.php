<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 2.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .header-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 2rem;
        }
        .header-nav a,
        .header-nav button {
            color: #475569;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }
        .header-nav a:hover,
        .header-nav button:hover {
            color: #047857;
            background-color: #f1f5f9;
        }
        .header-nav a.active,
        .header-nav button.active {
            color: #047857;
            background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.1);
        }
        .header-nav-icon {
            width: 18px;
            height: 18px;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }
        .header-nav-separator {
            width: 1px;
            height: 24px;
            background-color: #e2e8f0;
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
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: #ffffff;
            border-color: #059669;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            border-color: #047857;
            box-shadow: 0 4px 6px rgba(5, 150, 105, 0.2);
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
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
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
            background: #f3f4f6;
        }
        .table th {
            padding: 1rem 1.25rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 2px solid #e2e8f0;
        }
        .table td {
            padding: 1.25rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 0.9375rem;
            vertical-align: middle;
        }
        .table tbody tr {
            transition: all 0.15s ease;
        }
        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.001);
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            border: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <img src="{{ asset('Image/CEGME Logo.JPG') }}" alt="CEGME Logo" style="height: 48px; width: auto; object-fit: contain;">
                <div>
                    <h1 style="font-size: 1.5rem; font-weight: 800; margin: 0; letter-spacing: -0.025em; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1.2;">CEGME</h1>
                    <p style="font-size: 0.875rem; color: #64748b; margin: 0.25rem 0 0 0;">Géosciences • Mines • Environnement</p>
                </div>
            </div>
            <nav class="header-nav">
                <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    Articles
                </a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    Catégories
                </a>
                <a href="{{ route('admin.tags.index') }}" class="{{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                    Tags
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    Utilisateurs
                </a>
                @endif
                <span class="header-nav-separator"></span>
                <a href="{{ route('home') }}" target="_blank" style="color: #2563eb;">
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
                <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border: 1px solid #6ee7b7; color: #065f46; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; box-shadow: 0 2px 4px rgba(5, 150, 105, 0.1); font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border: 1px solid #fca5a5; color: #991b1b; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.1); font-weight: 500;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
    </div>
</body>
</html>

