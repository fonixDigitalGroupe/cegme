<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex justify-center mb-6">
        <div
            class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-white shadow-md flex items-center justify-center overflow-hidden p-2">
            <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME" class="w-full h-full object-contain" />
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

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
                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5 mr-2">
                    {{ __('Se connecter avec Google') }}
                </a>
            </div>

            <div class="mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('home') }}">
                    {{ __('Retour à l\'accueil') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>