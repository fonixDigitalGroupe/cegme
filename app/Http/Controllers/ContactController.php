<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        try {
            Mail::to('cabinet.rca@cegme.net')
                ->send(new ContactFormSubmitted($validated));

            return back()->with('success', "Votre message a été envoyé avec succès.");
        } catch (\Throwable $e) {
            Log::error('Contact form email failed', [
                'exception' => $e,
                'payload' => [
                    'name' => $validated['name'] ?? null,
                    'email' => $validated['email'] ?? null,
                    'phone' => $validated['phone'] ?? null,
                    'subject' => $validated['subject'] ?? null,
                ],
            ]);

            return back()
                ->withInput()
                ->with('error', "Erreur lors de l'envoi du message. Veuillez réessayer.");
        }
    }
}
