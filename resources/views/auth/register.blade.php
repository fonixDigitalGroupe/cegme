<x-guest-layout>
    <div class="flex flex-col items-center mb-6">
        <div
            class="w-24 h-24 sm:w-28 sm:h-28 rounded-full sm:bg-white sm:shadow-md flex items-center justify-center overflow-hidden p-2 mb-4">
            <img src="{{ asset('Image/CEGME Logo.png') }}" alt="CEGME" class="w-full h-full object-contain" />
        </div>
        <h2 class="text-2xl font-bold text-gray-800">{{ __('Inscription') }}</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" class="block mt-1 w-full auth-input shadow-none" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name"
                style="border: 1.5px solid #d1d5db !important; box-shadow: none !important;" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email" class="block mt-1 w-full auth-input shadow-none" type="email" name="email"
                :value="old('email')" required autocomplete="username"
                style="border: 1.5px solid #d1d5db !important; box-shadow: none !important;" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full auth-input shadow-none" type="password" name="password"
                required autocomplete="new-password"
                style="border: 1.5px solid #d1d5db !important; box-shadow: none !important;" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full auth-input shadow-none" type="password"
                name="password_confirmation" required autocomplete="new-password"
                style="border: 1.5px solid #d1d5db !important; box-shadow: none !important;" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <div class="flex justify-center">
                <x-primary-button
                    class="w-full justify-center bg-gradient-to-b from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 focus:from-green-700 focus:to-emerald-600 active:from-green-800 active:to-emerald-700 focus:ring-green-500"
                    style="background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%);">
                    {{ __("S'inscrire") }}
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
                    {{ __("S'inscrire avec Google") }}
                </a>
            </div>

            <div class="mt-4 text-center">
                <span class="text-sm text-gray-600">{{ __('Déjà inscrit ?') }}</span>
                <a class="text-sm font-semibold text-green-600 hover:text-green-500 ml-1" href="{{ route('login') }}">
                    {{ __('Se connecter') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>