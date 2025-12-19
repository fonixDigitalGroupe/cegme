<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if (!$adminRole) {
            $this->command->error('Le rôle Admin n\'existe pas. Exécutez d\'abord RoleSeeder.');
            return;
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@cegme.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info('Utilisateur admin créé avec succès !');
            $this->command->info('Email: admin@cegme.com');
            $this->command->info('Mot de passe: admin123');
        } else {
            // Mettre à jour le rôle si l'utilisateur existe déjà
            $admin->role_id = $adminRole->id;
            $admin->password = Hash::make('admin123');
            $admin->save();
            $this->command->info('Utilisateur admin mis à jour !');
            $this->command->info('Email: admin@cegme.com');
            $this->command->info('Mot de passe: admin123');
        }
    }
}
