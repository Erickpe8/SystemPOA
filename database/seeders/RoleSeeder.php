<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==========================================
        // SUPERADMIN
        // ==========================================
        Role::firstOrCreate(
            ['name' => 'superadmin'],
            ['guard_name' => 'web']
        );

        // ==========================================
        // ROLES POR ÁREA/MÓDULO
        // ==========================================

        $areas = [
            // 1. Educación Superior
            [
                'slug' => 'educacion_superior',
                'name' => 'Educación Superior',
                'roles' => ['director']
            ],

            // 2. Virtualización
            [
                'slug' => 'virtualizacion',
                'name' => 'Virtualización',
                'roles' => ['director']
            ],

            // 3. Investigaciones
            [
                'slug' => 'investigaciones',
                'name' => 'Investigaciones',
                'roles' => ['director']
            ],

            // 4. Direccionamiento Estratégico
            [
                'slug' => 'direccionamiento_estrategico',
                'name' => 'Direccionamiento Estratégico',
                'roles' => ['director']
            ],

            // 5. Bienestar Institucional
            [
                'slug' => 'bienestar_institucional',
                'name' => 'Bienestar Institucional',
                'roles' => ['director']
            ],

            // 6. Extensión Comunitaria
            [
                'slug' => 'extension_comunitaria',
                'name' => 'Extensión y Proyección a la Comunidad',
                'roles' => ['director']
            ],

            // 7. Aseguramiento de Calidad
            [
                'slug' => 'aseguramiento_calidad',
                'name' => 'Aseguramiento Interno de Calidad',
                'roles' => ['director']
            ],

            // 8. Gestión de Calidad
            [
                'slug' => 'gestion_calidad',
                'name' => 'Gestión de Calidad',
                'roles' => ['director']
            ],

            // 9. Registro y Control
            [
                'slug' => 'registro_control',
                'name' => 'Registro y Control',
                'roles' => ['director']
            ],

            // 10. Procesos de Apoyo
            [
                'slug' => 'procesos_apoyo',
                'name' => 'Procesos de Apoyo',
                'roles' => ['director']
            ],

            // 11. Mercadeo Estratégico
            [
                'slug' => 'mercadeo_estrategico',
                'name' => 'Mercadeo Estratégico',
                'roles' => ['director']
            ],

            // 12. Comunicaciones
            [
                'slug' => 'comunicaciones',
                'name' => 'Comunicaciones',
                'roles' => ['director']
            ],

            // 13. Gestión Humana
            [
                'slug' => 'gestion_humana',
                'name' => 'Gestión Humana',
                'roles' => ['director']
            ],

            // 14. Gestión Tecnológica
            [
                'slug' => 'gestion_tecnologica',
                'name' => 'Gestión Tecnológica',
                'roles' => ['director']
            ],

            // 15. Gestión Administrativa
            [
                'slug' => 'gestion_administrativa',
                'name' => 'Gestión Administrativa',
                'roles' => ['director']
            ],

            // 16. Gestión Financiera
            [
                'slug' => 'gestion_financiera',
                'name' => 'Gestión Financiera',
                'roles' => ['director']
            ],

            // 17. Gestión Contable y Financiera
            [
                'slug' => 'gestion_contable_financiera',
                'name' => 'Gestión Contable y Financiera',
                'roles' => ['director']
            ],

            // 18. Gestión de Biblioteca
            [
                'slug' => 'gestion_biblioteca',
                'name' => 'Gestión de Biblioteca',
                'roles' => ['director']
            ],
        ];

        // Crear roles para cada área
        foreach ($areas as $area) {
            $this->command->info("Creando roles para: {$area['name']}");

            foreach ($area['roles'] as $role) {
                $roleName = "{$area['slug']}.{$role}";

                Role::firstOrCreate(
                    ['name' => $roleName],
                    ['guard_name' => 'web']
                );

                $this->command->info("Rol creado: {$roleName}");
            }
        }

        // ==========================================
        // PERMISOS BÁSICOS POR MÓDULO
        // ==========================================
        $this->command->info("\nCreando permisos básicos...");

        $basicPermissions = ['view', 'create', 'edit', 'delete', 'manage'];

        foreach ($areas as $area) {
            foreach ($basicPermissions as $permission) {
                $permissionName = "{$area['slug']}.{$permission}";

                Permission::firstOrCreate(
                    ['name' => $permissionName],
                    ['guard_name' => 'web']
                );

                $this->command->info("  ✓ Permiso creado: {$permissionName}");
            }

            // Asignar permisos a roles del área
            $this->assignPermissionsToAreaRoles($area['slug'], $area['roles']);
        }

        // Dar todos los permisos al SuperAdmin
        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo(Permission::all());

        $this->command->info("\n Seeder de roles y permisos completado exitosamente!");
    }

    /**
     * Asignar permisos a roles de un área específica
     */
    private function assignPermissionsToAreaRoles(string $areaSlug, array $roles): void
    {
        foreach ($roles as $roleSlug) {
            $roleName = "{$areaSlug}.{$roleSlug}";
            $role = Role::findByName($roleName);

            // Permisos según el rol
            switch ($roleSlug) {
                case 'director':
                    // todos los permisos del área
                    $role->givePermissionTo([
                        "{$areaSlug}.view",
                        "{$areaSlug}.create",
                        "{$areaSlug}.edit",
                        "{$areaSlug}.delete",
                        "{$areaSlug}.manage",
                    ]);
                    break;

                /* case 'coordinador':
                    // Coordinador puede ver, crear y editar
                    $role->givePermissionTo([
                        "{$areaSlug}.view",
                        "{$areaSlug}.create",
                        "{$areaSlug}.edit",
                    ]);
                    break;

                case  :
                    // Asistente solo puede ver
                    $role->givePermissionTo([
                        "{$areaSlug}.view",
                    ]);
                    break;

                default:
                    // Roles específicos (investigador, analista, etc.) pueden ver y crear
                    $role->givePermissionTo([
                        "{$areaSlug}.view",
                        "{$areaSlug}.create",
                    ]);
                    break; */
            }
        }
    }
}
