<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Réinitialise le mot de passe de l\'administrateur et assigne le rôle admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'admin@cegme.com';
        $password = 'admin';

        // S'assurer que le rôle admin existe
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Admin',
                'description' => 'Administrateur avec tous les droits',
            ]
        );

        $user = User::where('email', $email)->first();

        if (!$user) {
            // Créer l'utilisateur s'il n'existe pas
            $user = User::create([
                'name' => 'Administrateur',
                'email' => $email,
                'password' => $password, // Le cast 'hashed' dans le modèle va automatiquement hasher le mot de passe
                'role_id' => $adminRole->id,
            ]);
            $this->info("Utilisateur créé avec succès: {$email}");
        } else {
            // Réinitialiser le mot de passe et assigner le rôle admin
            $user->password = $password; // Le cast 'hashed' dans le modèle va automatiquement hasher le mot de passe
            $user->role_id = $adminRole->id;
            $user->save();
            $this->info("Mot de passe réinitialisé et rôle admin assigné pour {$email}");
        }

        $this->info("Email: {$email}");
        $this->info("Mot de passe: {$password}");
        $this->info("Rôle: Admin");

        return 0;
    }
}
