<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Créer les rôles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Créer un utilisateur admin
        $admin = User::create([
            'nom' => 'Admin',
            'prenom' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Assurez-vous de sécuriser ce mot de passe
        ]);
        $admin->assignRole($adminRole);

        // Créer un utilisateur super-admin
        $superAdmin = User::create([
            'nom' => 'Super',
            'prenom' => 'Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'), // Assurez-vous de sécuriser ce mot de passe
        ]);
        $superAdmin->assignRole($superAdminRole);
    }
} 