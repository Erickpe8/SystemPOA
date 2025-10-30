<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'direccion']);
        Role::create(['name' => 'director_programa']);
        Role::create(['name' => 'docente']);
    }
}
