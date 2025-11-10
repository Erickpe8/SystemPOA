<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Mostrar panel principal de gestión de usuarios
     */
    public function index()
    {
        // Solo SuperAdmin puede acceder
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $pendingUsers = User::where('is_active', false)->get();
        $activeUsers = User::where('is_active', true)->with('roles')->get();
        $roles = Role::all();

        return view('usermanagement.managemet', compact('pendingUsers', 'activeUsers', 'roles'));
    }

    /**
     * Aprobar solicitud de registro
     */
    public function approve(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'role' => 'required|exists:roles,name',
            'area' => 'nullable|string|max:255',
        ]);

        // Activar usuario
        $user->update([
            'is_active' => true,
            'role_name' => $request->role,
            'area' => $request->area,
        ]);

        // Asignar rol
        $user->syncRoles([$request->role]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario aprobado y rol asignado correctamente.',
            'user' => $user->load('roles')
        ]);
    }

    /**
     * Rechazar solicitud de registro
     */
    public function reject(User $user)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Solicitud rechazada y usuario eliminado.'
        ]);
    }

    /**
     * Actualizar rol de usuario existente
     */
    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'role' => 'required|exists:roles,name',
            'area' => 'nullable|string|max:255',
        ]);

        $user->update([
            'role_name' => $request->role,
            'area' => $request->area,
        ]);

        $user->syncRoles([$request->role]);

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado correctamente.',
            'user' => $user->load('roles')
        ]);
    }

    /**
     * Desactivar usuario
     */
    public function deactivate(User $user)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $user->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario desactivado correctamente.'
        ]);
    }

    /**
     * Eliminar usuario permanentemente
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        // No permitir eliminar al propio usuario
        if ($user->id === auth()->id()) {
            return response()->json([
                'error' => 'No puedes eliminarte a ti mismo.'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado permanentemente.'
        ]);
    }
}
