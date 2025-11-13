<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RoleHelper
{
    /**
     * Verifica si el usuario actual es SuperAdmin
     */
    public static function isSuperAdmin(): bool
    {
        return Auth::check() && Auth::user()->hasRole('superadmin');
    }

    /**
     * Verifica si el usuario tiene acceso a un área específica
     */
    public static function hasAccessToArea(string $areaSlug): bool
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        return Auth::check() && Auth::user()->hasAnyRole([
            "{$areaSlug}.director",
            "{$areaSlug}.coordinador",
            "{$areaSlug}.asistente",
        ]);
    }

    /**
     * Verifica si el usuario es director de un área
     */
    public static function isDirector(string $areaSlug): bool
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        return Auth::check() && Auth::user()->hasRole("{$areaSlug}.director");
    }

    /**
     * Verifica si el usuario es coordinador de un área
     */
    public static function isCoordinator(string $areaSlug): bool
    {
        if (self::isSuperAdmin()) {
            return true;
        }

        return Auth::check() && Auth::user()->hasRole("{$areaSlug}.coordinador");
    }

    /**
     * Verifica si el usuario puede gestionar un área (director o coordinador)
     */
    public static function canManageArea(string $areaSlug): bool
    {
        return self::isDirector($areaSlug) || self::isCoordinator($areaSlug);
    }

    /**
     * Obtiene el rol del usuario en un área específica
     */
    public static function getUserRoleInArea(string $areaSlug): ?string
    {
        if (self::isSuperAdmin()) {
            return 'superadmin';
        }

        $user = Auth::user();
        if (!$user) {
            return null;
        }

        $roles = $user->roles->pluck('name')->toArray();

        foreach ($roles as $role) {
            if (str_starts_with($role, "{$areaSlug}.")) {
                return str_replace("{$areaSlug}.", '', $role);
            }
        }

        return null;
    }

    /**
     * Obtiene todas las áreas a las que el usuario tiene acceso
     */
    public static function getUserAreas(): array
    {
        if (self::isSuperAdmin()) {
            return self::getAllAreas();
        }

        $user = Auth::user();
        if (!$user) {
            return [];
        }

        $areas = [];
        $roles = $user->roles->pluck('name')->toArray();

        foreach ($roles as $role) {
            if (str_contains($role, '.')) {
                $areaSlug = explode('.', $role)[0];
                if (!in_array($areaSlug, $areas)) {
                    $areas[] = $areaSlug;
                }
            }
        }

        return $areas;
    }

    /**
     * Lista de todas las áreas del sistema
     */
    public static function getAllAreas(): array
    {
        return [
            'educacion_superior',
            'virtualizacion',
            'investigaciones',
            'direccionamiento_estrategico',
            'bienestar_institucional',
            'extension_comunitaria',
            'aseguramiento_calidad',
            'gestion_calidad',
            'registro_control',
            'procesos_apoyo',
            'mercadeo_estrategico',
            'comunicaciones',
            'gestion_humana',
            'gestion_tecnologica',
            'gestion_administrativa',
            'gestion_financiera',
            'gestion_contable_financiera',
            'gestion_biblioteca',
        ];
    }

    /**
     * Obtiene el nombre legible de un área
     */
    public static function getAreaName(string $areaSlug): string
    {
        $names = [
            'educacion_superior' => 'Educación Superior',
            'virtualizacion' => 'Virtualización',
            'investigaciones' => 'Investigaciones',
            'direccionamiento_estrategico' => 'Direccionamiento Estratégico',
            'bienestar_institucional' => 'Bienestar Institucional',
            'extension_comunitaria' => 'Extensión y Proyección a la Comunidad',
            'aseguramiento_calidad' => 'Aseguramiento Interno de Calidad',
            'gestion_calidad' => 'Gestión de Calidad',
            'registro_control' => 'Registro y Control',
            'procesos_apoyo' => 'Procesos de Apoyo',
            'mercadeo_estrategico' => 'Mercadeo Estratégico',
            'comunicaciones' => 'Comunicaciones',
            'gestion_humana' => 'Gestión Humana',
            'gestion_tecnologica' => 'Gestión Tecnológica',
            'gestion_administrativa' => 'Gestión Administrativa',
            'gestion_financiera' => 'Gestión Financiera',
            'gestion_contable_financiera' => 'Gestión Contable y Financiera',
            'gestion_biblioteca' => 'Gestión de Biblioteca',
        ];

        return $names[$areaSlug] ?? ucwords(str_replace('_', ' ', $areaSlug));
    }
}
