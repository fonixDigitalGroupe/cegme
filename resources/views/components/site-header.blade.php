<header class="w-full sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm"
    style="background-color: white !important;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- ==========================================
             MOBILE HEADER (STRICTLY UNTOUCHED)
             ========================================== -->
        <div class="lg:hidden">
            <div class="mobile-header py-3 flex items-center justify-between">
                <div class="mobile-logo">
                    <a href="/" class="flex items-center gap-3"
                        style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
                        <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo"
                            style="height: 40px; width: auto;">
                        <span class="font-bold"
                            style="font-size: 18px; font-weight: 800; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: #10b981;">CEGME</span>
                    </a>
                </div>
                <!-- Menu hamburger -->
                <button class="mobile-menu-button" id="mobileMenuButton" onclick="toggleMobileMenu()" aria-label="Menu">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>

            <!-- Mobile Menu Content -->
            <div class="mobile-menu" id="mobileMenu">
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Accueil</a>
                <a href="/a-propos"
                    class="{{ request()->is('a-propos') || request()->is('a-propos/*') ? 'active' : '' }}">À Propos</a>
                <a href="/services"
                    class="{{ request()->is('services') || request()->is('services/*') ? 'active' : '' }}">Services</a>
                <a href="/realisations"
                    class="{{ request()->is('realisations') || request()->is('realisations/*') ? 'active' : '' }}">Réalisations</a>
                <a href="/actualites"
                    class="{{ request()->is('actualites') || request()->is('actualites/*') ? 'active' : '' }}">Actualités</a>
                <a href="/blog" class="{{ request()->is('blog') || request()->is('blog/*') ? 'active' : '' }}">Blog</a>
                <a href="{{ route('appels-offres.index') }}"
                    class="{{ request()->is('appels-offres') || request()->is('appels-offres/*') ? 'active' : '' }}">Appels
                    d'offres</a>
                <a href="/contact"
                    class="{{ request()->is('contact') || request()->is('contact/*') ? 'active' : '' }}">Contact</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}" style="display: block;">
                        @csrf
                        <button type="submit"
                            style="display: block; width: 100%; text-align: left; padding: 16px 20px; color: rgb(55, 65, 81); font-size: 16px; font-weight: 600; background: none; border: none; border-bottom: 1px solid rgba(229, 231, 235, 0.5); cursor: pointer; color: rgb(10, 150, 120);">
                            Déconnexion
                        </button>
                    </form>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                            style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%); color: rgb(255, 255, 255); margin: 8px 16px; padding: 8px 16px; border-radius: 6px; text-align: center; display: block; font-size: 14px;">
                            Se connecter
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <!-- ==========================================
             DESKTOP HEADER (RECONSTRUCTED)
             ========================================== -->
        <nav class="hidden lg:flex items-center justify-between py-4 w-full desktop-menu">
            <!-- Left: Logo Section -->
            <div class="flex items-center" style="display: flex; align-items: center;">
                <a href="/" class="flex items-center"
                    style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                    <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="h-16 w-auto object-contain"
                        style="height: 64px; width: auto;">
                    <div class="flex flex-col" style="display: flex; flex-direction: column;">
                        <span
                            style="color: #039477; font-size: 18px; font-weight: 800; line-height: 1.2; font-family: sans-serif; display: block;">CEGME</span>
                        <span
                            style="color: #4b5563; font-size: 12px; font-weight: 500; white-space: nowrap; font-family: sans-serif; display: block;">Géosciences
                            • Mines • Environnement</span>
                    </div>
                </a>
            </div>

            <!-- Center: Navigation -->
            <div class="flex items-center justify-center gap-0.5"
                style="display: flex; align-items: center; justify-content: center; gap: 2px;">
                @php
                    $navLinks = [
                        ['url' => '/', 'label' => 'Accueil'],
                        ['url' => '/a-propos', 'label' => 'À Propos'],
                        ['url' => '/services', 'label' => 'Services'],
                        ['url' => '/realisations', 'label' => 'Réalisations'],
                        ['url' => '/actualites', 'label' => 'Actualités'],
                        ['url' => '/blog', 'label' => 'Blog'],
                        ['url' => route('appels-offres.index'), 'label' => "Appels d'offres"],
                        ['url' => '/contact', 'label' => 'Contact'],
                    ];
                @endphp

                @foreach($navLinks as $link)
                    @php
                        $isActive = ($link['url'] == '/' && request()->is('/')) ||
                            ($link['url'] != '/' && (request()->is(trim($link['url'], '/')) || request()->is(trim($link['url'], '/') . '/*')));

                        $baseStyle = "color: #1b1b18; padding: 0 10px; font-size: 14px; font-weight: 500; text-decoration: none; display: flex; align-items: center; justify-content: center; height: 36px; white-space: nowrap; line-height: 1; margin: 0 !important;";
                        if ($isActive) {
                            $baseStyle .= " background-color: #039477; color: white; border-radius: 6px;";
                        }
                    @endphp

                    <a href="{{ $link['url'] }}" style="{{ $baseStyle }}"
                        class="{{ $isActive ? 'shadow-sm' : 'hover:text-[#039477] transition-colors' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Right: Login Button -->
            <div class="flex items-center justify-end"
                style="display: flex; align-items: center; justify-content: flex-end;">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="m-0" style="margin: 0;">
                        @csrf
                        <button type="submit"
                            style="color: #dc2626; background-color: #fef2f2; padding: 8px 20px; border-radius: 9999px; border: 1px solid #fee2e2; font-size: 14px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <span>Déconnexion</span>
                        </button>
                    </form>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                            style="background-color: #039477; color: white; padding: 10px 20px; border-radius: 9999px; font-size: 14px; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 8px;"
                            class="shadow hover:opacity-90 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            <span>Se connecter</span>
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
    </div>

    <!-- Scripts (Strictly Unchanged) -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const button = document.getElementById('mobileMenuButton');
            if (!menu || !button) return;
            menu.classList.toggle('active');
            button.classList.toggle('active');
        }

        document.addEventListener('click', (e) => {
            const menu = document.getElementById('mobileMenu');
            const button = document.getElementById('mobileMenuButton');
            if (!menu || !button) return;

            if (!menu.contains(e.target) && !button.contains(e.target) && menu.classList.contains('active')) {
                menu.classList.remove('active');
                button.classList.remove('active');
            }
        });
    </script>
</header>