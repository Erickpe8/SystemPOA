<?php

namespace App\Http\Middleware;

use App\Helpers\RoleHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAreaAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $areaSlug): Response
    {
        // SuperAdmin tiene acceso a todo
        if (RoleHelper::isSuperAdmin()) {
            return $next($request);
        }

        // Verificar acceso al área
        if (!RoleHelper::hasAccessToArea($areaSlug)) {
            abort(403, 'No tienes acceso a esta área.');
        }

        return $next($request);
    }
}
