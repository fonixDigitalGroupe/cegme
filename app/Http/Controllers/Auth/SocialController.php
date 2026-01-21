<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if (!$user) {
                // Créer un nouvel utilisateur
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(16)), // Mot de passe aléatoire
                ]);
            } else {
                // Mettre à jour les infos si l'utilisateur existe déjà
                // On lie le compte Google si ce n'est pas déjà fait
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar() ?? $user->avatar,
                    ]);
                }
            }

            Auth::login($user);

            return redirect()->intended('/');

        } catch (\Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Une erreur est survenue lors de la connexion avec Google. Veuillez réessayer.');
        }
    }
}
