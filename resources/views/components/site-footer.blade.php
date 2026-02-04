<footer class="w-full text-white px-4 sm:px-6 lg:px-8 desktop-footer hidden lg:block"
    style="background: linear-gradient(to right bottom, rgb(15, 23, 42), rgb(6, 78, 59), rgb(19, 78, 74)); padding: 80px 0; color: #ffffff; position: relative; overflow: hidden; font-family: sans-serif;">
    <!-- Decorative overlay -->
    <div
        style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(5, 150, 105, 0.08) 0%, transparent 50%); pointer-events: none;">
    </div>

    <div class="relative z-10" style="position: relative; z-index: 10;">
        <div class="max-w-7xl mx-auto" style="padding: 0 24px;">
            <div class="grid grid-cols-3 gap-16 mb-16"
                style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 64px; margin-bottom: 64px;">
                <!-- Column 1: Info -->
                <div class="flex flex-col gap-6">
                    <div class="flex items-center gap-3"
                        style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                        <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo"
                            style="height: 32px; width: auto; object-fit: contain;">
                        <div class="flex flex-col">
                            <span
                                style="font-size: 20px; font-weight: 800; color: #ffffff; line-height: 1.2;">CEGME</span>
                            <span
                                style="font-size: 11px; color: #d1d5db; line-height: 1.2; margin-top: 2px;">Géosciences
                                • Mines • Environnement</span>
                        </div>
                    </div>
                    <p style="font-size: 15px; color: #ffffff; line-height: 1.6; margin-bottom: 20px;">
                        Cabinet d'Études Géologiques, Minières et Environnementales
                    </p>
                    <p style="font-size: 14px; color: #d1d5db; line-height: 1.6; margin: 0;">
                        <strong style="font-weight: 600; color: #ffffff;">Plateforme d'experts nationaux
                            agréée</strong><br>
                        N° 004/MEDD/DIRCAB_21
                    </p>
                </div>

                <!-- Column 2: Liens rapides -->
                <div>
                    <h3 style="font-size: 20px; font-weight: 700; color: #ffffff; margin-bottom: 32px;">Liens rapides
                    </h3>
                    <ul
                        style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px;">
                        @php
                            $links = [
                                ['url' => '/', 'label' => 'Accueil'],
                                ['url' => '/a-propos', 'label' => 'À propos'],
                                ['url' => '/services', 'label' => 'Services'],
                                ['url' => '/realisations', 'label' => 'Réalisations'],
                                ['url' => '/actualites', 'label' => 'Actualités'],
                                ['url' => '/blog', 'label' => 'Blog'],
                                ['url' => route('appels-offres.index'), 'label' => "Appels d'offres"],
                                ['url' => '/contact', 'label' => 'Contact'],
                            ];
                        @endphp
                        @foreach($links as $link)
                            <li>
                                <a href="{{ $link['url'] }}"
                                    style="color: #d1d5db; text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; transition: all 0.2s;"
                                    class="group hover:text-[#4ade80]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        style="width: 16px; height: 16px; opacity: 0; transform: translateX(-4px); transition: all 0.2s;"
                                        class="group-hover:opacity-100 group-hover:translate-x-0">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                    <span>{{ $link['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Column 3: Contact -->
                <div>
                    <h3 style="font-size: 20px; font-weight: 700; color: #ffffff; margin-bottom: 32px;">Contact</h3>
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <!-- Address -->
                        <div style="display: flex; items-start; gap: 16px;">
                            <div
                                style="width: 40px; height: 40px; min-width: 40px; background: rgba(74, 222, 128, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4ade80;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <span style="font-size: 14px; font-weight: 600; color: #ffffff;">Adresse</span>
                                <span style="font-size: 14px; color: #d1d5db;">Bangui, République Centrafricaine</span>
                            </div>
                        </div>
                        <!-- Email -->
                        <div style="display: flex; items-start; gap: 16px;">
                            <div
                                style="width: 40px; height: 40px; min-width: 40px; background: rgba(74, 222, 128, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4ade80;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <span style="font-size: 14px; font-weight: 600; color: #ffffff;">Email</span>
                                <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                    <a href="mailto:cabinet.rca@cegme.net"
                                        style="font-size: 14px; color: #d1d5db; text-decoration: none;"
                                        class="hover:text-[#4ade80]">cabinet.rca@cegme.net</a>
                                    <span style="color: #6b7280;">/</span>
                                    <a href="mailto:cegme.sarl@gmail.com"
                                        style="font-size: 14px; color: #d1d5db; text-decoration: none;"
                                        class="hover:text-[#4ade80]">cegme.sarl@gmail.com</a>
                                </div>
                            </div>
                        </div>
                        <!-- UI/UX fix for NRC -->
                        <div style="display: flex; items-start; gap: 16px;">
                            <div
                                style="width: 40px; height: 40px; min-width: 40px; background: rgba(74, 222, 128, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4ade80;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z">
                                    </path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <line x1="10" y1="9" x2="8" y2="9"></line>
                                </svg>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <span style="font-size: 14px; font-weight: 600; color: #ffffff;">Registre du
                                    Commerce</span>
                                <span
                                    style="font-size: 14px; color: #d1d5db; font-family: monospace;">CA/BG/2015B541</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 32px; text-align: center;">
                <p style="color: #9ca3af; font-size: 14px; margin: 0;">
                    © {{ date('Y') }} CEGME SARL. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Force correct footer visibility */
    @media (min-width: 1024px) {
        .desktop-footer {
            display: block !important;
        }

        .mobile-footer-home {
            display: none !important;
        }
    }

    @media (max-width: 1023px) {
        .desktop-footer {
            display: none !important;
        }

        .mobile-footer-home {
            display: block !important;
        }
    }
</style>

<footer class="w-full text-white px-4 sm:px-6 lg:px-8 mobile-footer-home lg:hidden"
    style="background: linear-gradient(to right bottom, rgb(15, 23, 42), rgb(6, 78, 59), rgb(19, 78, 74)); padding: 80px 0; color: rgb(255, 255, 255); position: relative; overflow: hidden;">
    <div
        style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(5, 150, 105, 0.08) 0%, transparent 50%); pointer-events: none;">
    </div>
    <div class="relative z-10" style="position: relative; z-index: 10;">
        <div class="max-w-7xl mx-auto" style="padding: 0px 24px;">
            <div class="grid grid-cols-1 gap-12 mb-12"
                style="display: grid; grid-template-columns: 1fr; gap: 48px; margin-bottom: 48px; padding: 0px;">
                <!-- Company Info Mobile -->
                <div>
                    <div class="flex items-center gap-3 mb-6"
                        style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                        <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME Logo" class="block h-8 w-auto"
                            style="height: 32px; width: auto; max-width: 120px; object-fit: contain;">
                        <div class="flex flex-col" style="display: flex; flex-direction: column;">
                            <span class="text-xl font-bold"
                                style="font-size: 20px; font-weight: 800; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1.2;">CEGME</span>
                            <span class="text-xs text-gray-200"
                                style="font-size: 11px; color: rgb(229, 231, 235); line-height: 1.2; margin-top: 2px;">Géosciences
                                • Mines • Environnement</span>
                        </div>
                    </div>
                    <p class="text-white mb-5 leading-relaxed"
                        style="font-size: 15px; color: rgb(255, 255, 255); margin-bottom: 20px; line-height: 26px; font-weight: 400;">
                        Cabinet d'Études Géologiques, Minières et Environnementales
                    </p>
                    <p class="text-gray-200 text-sm leading-relaxed"
                        style="font-size: 14px; color: rgb(229, 231, 235); line-height: 22px; margin: 0;">
                        <strong style="font-weight: 600; color: rgb(255, 255, 255);">Plateforme d'experts nationaux
                            agréée</strong><br>
                        N° 004/MEDD/DIRCAB_21
                    </p>
                </div>

                <!-- Liens rapides Mobile -->
                <div>
                    <h3 class="text-xl font-bold mb-6"
                        style="font-size: 20px; font-weight: 800; margin-bottom: 24px; color: rgb(255, 255, 255); letter-spacing: -0.3px;">
                        Liens rapides
                    </h3>
                    <ul class="space-y-3" style="list-style: none; padding: 0; margin: 0;">
                        <li><a href="/"
                                style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Accueil</a>
                        </li>
                        <li><a href="/a-propos"
                                style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">À
                                Propos</a></li>
                        <li><a href="/services"
                                style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Services</a>
                        </li>
                        <li><a href="/realisations"
                                style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Réalisations</a>
                        </li>
                        <li><a href="/actualites"
                                style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Actualités</a>
                        </li>
                        <li><a href="/blog"
                                style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Blog</a>
                        </li>
                        <li><a href="{{ route('appels-offres.index') }}"
                                style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Appels
                                d'offres</a></li>
                        <li><a href="/contact"
                                style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: block; padding: 6px 0;">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Mobile -->
                <div>
                    <h3 class="text-xl font-bold mb-6"
                        style="font-size: 20px; font-weight: 800; margin-bottom: 24px; color: rgb(255, 255, 255); letter-spacing: -0.3px;">
                        Contact
                    </h3>
                    <ul class="space-y-4" style="list-style: none; padding: 0; margin: 0;">
                        <li style="padding: 0;">
                            <span
                                style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Adresse</span>
                            <p style="color: rgb(209, 213, 219); font-size: 14px; margin: 0; line-height: 22px;">Bangui,
                                République Centrafricaine</p>
                        </li>
                        <li style="padding: 0;">
                            <span
                                style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Email</span>
                            <a href="mailto:cabinet.rca@cegme.net"
                                style="color: rgb(229, 231, 235); font-size: 14px; text-decoration: none;">cabinet.rca@cegme.net</a>
                            <br>
                            <a href="mailto:cegme.sarl@gmail.com"
                                style="color: rgb(229, 231, 235); font-size: 14px; text-decoration: none;">cegme.sarl@gmail.com</a>
                        </li>
                        <li style="padding: 0;">
                            <span
                                style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Registre
                                du Commerce</span>
                            <p
                                style="color: rgb(209, 213, 219); font-size: 14px; margin: 0; line-height: 22px; font-family: monospace;">
                                CA/BG/2015B541</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar Mobile -->
            <div class="pt-8 border-t border-white/10 text-center"
                style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 32px; text-align: center;">
                <p class="text-gray-400 text-sm" style="color: rgb(156, 163, 175); font-size: 14px;">
                    © {{ date('Y') }} CEGME SARL. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>
</footer>