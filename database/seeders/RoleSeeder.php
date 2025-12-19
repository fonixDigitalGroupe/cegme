<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Admin',
                'description' => 'Administrateur avec tous les droits',
            ]
        );

        Role::firstOrCreate(
            ['name' => 'editor'],
            [
                'display_name' => 'Éditeur',
                'description' => 'Éditeur avec droits de gestion des articles',
            ]
        );
    }
}
