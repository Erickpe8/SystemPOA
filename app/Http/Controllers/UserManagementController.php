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
     * Mostrar panel principal de gestión de usuarios con paginación
     */
    public function index(Request $request)
    {
        // Solo SuperAdmin puede acceder
        if (!auth()->user()->hasRole('superadmin')) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Parámetros de paginación y búsqueda
        $pendingPerPage = $request->get('pending_per_page', 10);
        $activePerPage = $request->get('active_per_page', 10);
        $pendingSearch = $request->get('pending_search', '');
        $activeSearch = $request->get('active_search', '');
        $activeRoleFilter = $request->get('active_role', '');

        // Query para usuarios pendientes con búsqueda
        $pendingQuery = User::where('is_active', false);

        if ($pendingSearch) {
            $pendingQuery->where(function($q) use ($pendingSearch) {
                $q->where('name', 'like', "%{$pendingSearch}%")
                  ->orWhere('email', 'like', "%{$pendingSearch}%");
            });
        }

        $pendingUsers = $pendingQuery->orderBy('created_at', 'desc')
                                    ->paginate($pendingPerPage, ['*'], 'pending_page')
                                    ->withQueryString();

        // Query para usuarios activos con búsqueda y filtros
        $activeQuery = User::where('is_active', true)->with('roles');

        if ($activeSearch) {
            $activeQuery->where(function($q) use ($activeSearch) {
                $q->where('name', 'like', "%{$activeSearch}%")
                  ->orWhere('email', 'like', "%{$activeSearch}%")
                  ->orWhere('area', 'like', "%{$activeSearch}%");
            });
        }

        if ($activeRoleFilter) {
            $activeQuery->whereHas('roles', function($q) use ($activeRoleFilter) {
                $q->where('name', $activeRoleFilter);
            });
        }

        $activeUsers = $activeQuery->orderBy('created_at', 'desc')
                                  ->paginate($activePerPage, ['*'], 'active_page')
                                  ->withQueryString();

        $roles = Role::all();

        return view('usermanagement.managemet', compact('pendingUsers', 'activeUsers', 'roles'));
    }

    /**
     * Aprobar solicitud de registro
     */
    public function approve(Request $request, User $user)
    {
        try {
            if (!auth()->user()->hasRole('superadmin')) {
                Log::warning('Intento de acceso no autorizado a approve', [
                    'user_id' => auth()->id(),
                    'target_user_id' => $user->id
                ]);
                return response()->json(['error' => 'No autorizado'], 403);
            }

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

            DB::beginTransaction();

            try {
                $user->is_active = true;
                $user->role_name = $validated['role'];
                $user->area = $validated['area'];
                $user->save();

                $user->syncRoles([$validated['role']]);
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
                'is_active' => 'required|boolean',
            ]);

            Log::info('Actualizando usuario', [
                'user_id' => $user->id,
                'old_role' => $user->role_name,
                'new_role' => $validated['role'],
                'old_area' => $user->area,
                'new_area' => $validated['area'] ?? null,
                'old_is_active' => $user->is_active,
                'new_is_active' => $validated['is_active']
            ]);

            DB::beginTransaction();

            try {
                // Actualizar datos del usuario
                $user->role_name = $validated['role'];
                $user->area = $validated['area'];
                $user->is_active = $validated['is_active'];
                $user->save();

                // Sincronizar roles
                $user->syncRoles([$validated['role']]);
                $user->refresh();
                $user->load('roles');

                DB::commit();

                $statusMessage = $validated['is_active'] ? 'activado' : 'desactivado';

                Log::info('Usuario actualizado exitosamente', [
                    'user_id' => $user->id,
                    'roles' => $user->roles->pluck('name')->toArray(),
                    'is_active' => $user->is_active
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "Usuario {$user->name} actualizado correctamente. Estado: {$statusMessage}.",
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'role_name' => $user->role_name,
                        'area' => $user->area,
                        'is_active' => $user->is_active,
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
            Log::error('Error al actualizar usuario', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => 'Error al actualizar usuario: ' . $e->getMessage()
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
