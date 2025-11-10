<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Preparando rol y usuario SuperAdmin...');

        // Limpia el caché de permisos/roles de Spatie
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Asegura el rol 'superadmin' con el guard correcto
        $guard = config('auth.defaults.guard', 'web');
        $role  = Role::findOrCreate('superadmin', $guard);

        // Crea o toma el usuario
        $superadmin = User::firstOrCreate(
            ['email' => 'admin@fesc.edu.co'],
            [
                'name'              => 'Super Administrador',
                'password'          => Hash::make('admin@2025'),
                'email_verified_at' => now(),
                'is_active'         => true,
                'role_name'         => 'superadmin',
            ]
        );

        if (! $superadmin->hasRole('superadmin')) {
            $superadmin->syncRoles([$role]);
        }

        $this->command->info(' Usuario SuperAdmin listo.');

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
