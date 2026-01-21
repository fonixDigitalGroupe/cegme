<footer class="w-full text-white px-4 sm:px-6 lg:px-8 desktop-footer hidden lg:block"
    style="background: linear-gradient(to right bottom, rgb(15, 23, 42), rgb(6, 78, 59), rgb(19, 78, 74)); padding: 80px 0; color: rgb(255, 255, 255); position: relative; overflow: hidden;">
    <!-- Decorative overlay -->
    <div
        style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(5, 150, 105, 0.08) 0%, transparent 50%); pointer-events: none;">
    </div>
    <div class="relative z-10" style="position: relative; z-index: 10;">
        <div class="max-w-7xl mx-auto" style="padding: 0px 24px;">
            <div class="grid grid-cols-1 gap-12 mb-12"
                style="display: grid; grid-template-columns: 1fr; gap: 48px; margin-bottom: 48px; padding: 0px;">
                <!-- Company Info -->
                <div>
                    <!-- Logo and Company Name -->
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
                    <!-- Description -->
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

                <!-- Liens Rapides -->
                <div>
                    <h3 class="text-xl font-bold mb-6"
                        style="font-size: 20px; font-weight: 800; margin-bottom: 24px; color: rgb(255, 255, 255); letter-spacing: -0.3px;">
                        Liens Rapides
                    </h3>
                    <ul class="space-y-3" style="list-style: none; padding: 0; margin: 0;">
                        <li>
                            <a href="/"
                                class="text-gray-200 hover:text-green-300 transition-all duration-200 flex items-center gap-2 group"
                                style="color: rgb(229, 231, 235); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity"
                                    style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                                <span>Accueil</span>
                            </a>
                        </li>
                        <li>
                            <a href="/a-propos"
                                class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity"
                                    style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                                <span>À Propos</span>
                            </a>
                        </li>
                        <li>
                            <a href="/services"
                                class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity"
                                    style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                                <span>Services</span>
                            </a>
                        </li>
                        <li>
                            <a href="/realisations"
                                class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity"
                                    style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                                <span>Réalisations</span>
                            </a>
                        </li>
                        <li>
                            <a href="/actualites"
                                class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity"
                                    style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                                <span>Actualités</span>
                            </a>
                        </li>
                        <li>
                            <a href="/blog"
                                class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity"
                                    style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                                <span>Blog</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('appels-offres.index') }}"
                                class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity"
                                    style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                                <span>Appels d'Offres</span>
                            </a>
                        </li>
                        <li>
                            <a href="/contact"
                                class="text-gray-300 hover:text-green-400 transition-all duration-200 flex items-center gap-2 group"
                                style="color: rgb(209, 213, 219); text-decoration: none; font-size: 15px; display: flex; align-items: center; gap: 8px; padding: 6px 0; transition: all 0.2s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity"
                                    style="width: 16px; height: 16px; opacity: 0; transition: opacity 0.2s ease;">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                                <span>Contact</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
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
                                class="hover:text-green-400 transition-colors duration-200"
                                style="color: rgb(229, 231, 235); font-size: 14px; text-decoration: none;">cabinet.rca@cegme.net</a>
                            <span style="color: rgb(156, 163, 175); margin: 0 4px;">/</span>
                            <a href="mailto:cegme.sarl@gmail.com"
                                class="hover:text-green-400 transition-colors duration-200"
                                style="color: rgb(229, 231, 235); font-size: 14px; text-decoration: none;">cegme.sarl@gmail.com</a>
                        </li>
                        <li style="padding: 0;">
                            <span
                                style="color: rgb(255, 255, 255); font-weight: 600; font-size: 14px; display: block; margin-bottom: 4px;">Registre
                                du Commerce</span>
                            <p
                                style="color: rgb(209, 213, 219); font-size: 14px; margin: 0; line-height: 22px; font-family: monospace;">
                                CA/BG/2015B514</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-white/10 text-center"
                style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 32px; text-align: center;">
                <p class="text-gray-400 text-sm" style="color: rgb(156, 163, 175); font-size: 14px;">
                    © {{ date('Y') }} CEGME SARL. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>
</footer>

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

                <!-- Liens Rapides Mobile -->
                <div>
                    <h3 class="text-xl font-bold mb-6"
                        style="font-size: 20px; font-weight: 800; margin-bottom: 24px; color: rgb(255, 255, 255); letter-spacing: -0.3px;">
                        Liens Rapides
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
                                d'Offres</a></li>
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
                                CA/BG/2015B514</p>
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