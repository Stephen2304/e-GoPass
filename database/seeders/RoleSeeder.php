<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Créer les rôles
        Role::create(['name' => 'admin', 'guard_name'=> 'api']);
        Role::create(['name' => 'super-admin', 'guard_name'=> 'api']);
    }
} 