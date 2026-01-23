<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col items-center mb-6">
        <div
            class="w-24 h-24 sm:w-28 sm:h-28 rounded-full sm:bg-white sm:shadow-md flex items-center justify-center overflow-hidden p-2 mb-4">
            <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME" class="w-full h-full object-contain" />
        </div>
        <h2 class="text-2xl font-bold text-gray-800">{{ __('Connexion') }}</h2>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email" class="block mt-1 w-full auth-input shadow-none" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username"
                style="border: 1.5px solid #d1d5db !important; box-shadow: none !important;" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full auth-input shadow-none pr-10" type="password"
                    name="password" required autocomplete="current-password"
                    style="border: 1.5px solid #d1d5db !important; box-shadow: none !important;" />

                <button type="button" onclick="togglePasswordVisibility()"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <script>
            function togglePasswordVisibility() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eye-icon');
                const eyeOffIcon = document.getElementById('eye-off-icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeOffIcon.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeOffIcon.classList.add('hidden');
                }
            }
        </script>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="mt-4">
            <div class="flex justify-center">
                <x-primary-button
                    class="w-full justify-center bg-gradient-to-b from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 focus:from-green-700 focus:to-emerald-600 active:from-green-800 active:to-emerald-700 focus:ring-green-500"
                    style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%);">
                    {{ __('Connexion') }}
                </x-primary-button>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <hr class="w-full border-gray-300">
                <span class="px-2 text-gray-500 text-sm">{{ __('OU') }}</span>
                <hr class="w-full border-gray-300">
            </div>

            <div class="mt-4">
                <a href="{{ route('auth.google') }}"
                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-white rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150 auth-button"
                    style="border: 1.5px solid #d1d5db !important; box-shadow: none !important;">
                    <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5 mr-2">
                    {{ __('Se connecter avec Google') }}
                </a>
            </div>

            <div class="mt-4 text-center">
                <span class="text-sm text-gray-600">{{ __("Pas encore de compte ?") }}</span>
                <a href="{{ route('register') }}"
                    class="text-sm font-semibold text-green-600 hover:text-green-500 ml-1">
                    {{ __("S'inscrire") }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>