<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        try {
            // Verificar permisos
            if (!auth()->user()->hasRole('superadmin')) {
                Log::warning('Intento de acceso no autorizado a approve', [
                    'user_id' => auth()->id(),
                    'target_user_id' => $user->id
                ]);
                return response()->json(['error' => 'No autorizado'], 403);
            }

            // Validar datos
            $validated = $request->validate([
                'role' => 'required|exists:roles,name',
                'area' => 'nullable|string|max:255',
            ]);

            Log::info('Aprobando usuario', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'role' => $validated['role'],
                'area' => $validated['area'] ?? null,
                'before_is_active' => $user->is_active
            ]);

            // Usar transacción para asegurar consistencia
            DB::beginTransaction();

            try {
                // Activar usuario y asignar datos
                $user->is_active = true;
                $user->role_name = $validated['role'];
                $user->area = $validated['area'];
                $user->save();

                // Asignar rol de Spatie
                $user->syncRoles([$validated['role']]);

                // Refrescar modelo para obtener datos actualizados
                $user->refresh();
                $user->load('roles');

                Log::info('Usuario aprobado exitosamente', [
                    'user_id' => $user->id,
                    'after_is_active' => $user->is_active,
                    'assigned_roles' => $user->roles->pluck('name')->toArray()
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => "Usuario {$user->name} aprobado correctamente. Ya puede iniciar sesión.",
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_active' => $user->is_active,
                        'role_name' => $user->role_name,
                        'area' => $user->area,
                        'roles' => $user->roles->pluck('name')
                    ]
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación al aprobar usuario', [
                'errors' => $e->errors(),
                'user_id' => $user->id
            ]);
            return response()->json([
                'error' => 'Datos inválidos',
                'details' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error al aprobar usuario', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Error al aprobar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rechazar solicitud de registro
     */
    public function reject(User $user)
    {
        try {
            if (!auth()->user()->hasRole('superadmin')) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            $userName = $user->name;
            $userEmail = $user->email;

            Log::info('Rechazando usuario', [
                'user_id' => $user->id,
                'user_email' => $userEmail,
                'rejected_by' => auth()->id()
            ]);

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => "Solicitud de {$userName} rechazada y eliminada correctamente."
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al rechazar usuario', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Error al rechazar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar rol de usuario existente
     */
    public function updateRole(Request $request, User $user)
    {
        try {
            if (!auth()->user()->hasRole('superadmin')) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            $validated = $request->validate([
                'role' => 'required|exists:roles,name',
                'area' => 'nullable|string|max:255',
            ]);

            Log::info('Actualizando rol de usuario', [
                'user_id' => $user->id,
                'old_role' => $user->role_name,
                'new_role' => $validated['role'],
                'old_area' => $user->area,
                'new_area' => $validated['area'] ?? null
            ]);

            DB::beginTransaction();

            try {
                $user->role_name = $validated['role'];
                $user->area = $validated['area'];
                $user->save();

                $user->syncRoles([$validated['role']]);
                $user->refresh();
                $user->load('roles');

                DB::commit();

                Log::info('Rol actualizado exitosamente', [
                    'user_id' => $user->id,
                    'roles' => $user->roles->pluck('name')->toArray()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "Rol de {$user->name} actualizado correctamente.",
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'role_name' => $user->role_name,
                        'area' => $user->area,
                        'roles' => $user->roles->pluck('name')
                    ]
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Datos inválidos',
                'details' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error al actualizar rol', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Error al actualizar rol: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desactivar usuario
     */
    public function deactivate(User $user)
    {
        try {
            if (!auth()->user()->hasRole('superadmin')) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            Log::info('Desactivando usuario', [
                'user_id' => $user->id,
                'user_email' => $user->email
            ]);

            $user->is_active = false;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => "Usuario {$user->name} desactivado correctamente."
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al desactivar usuario', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Error al desactivar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar usuario permanentemente
     */
    public function destroy(User $user)
    {
        try {
            if (!auth()->user()->hasRole('superadmin')) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            // No permitir eliminar al propio usuario
            if ($user->id === auth()->id()) {
                return response()->json([
                    'error' => 'No puedes eliminarte a ti mismo.'
                ], 400);
            }

            $userName = $user->name;

            Log::warning('Eliminando usuario permanentemente', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'deleted_by' => auth()->id()
            ]);

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => "Usuario {$userName} eliminado permanentemente."
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al eliminar usuario', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Error al eliminar usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}
