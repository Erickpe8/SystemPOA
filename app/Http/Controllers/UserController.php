<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Mostrar listado de usuarios.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Guardar nuevo usuario con rol asignado.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|string',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_name' => $request->role,
            'area'     => $request->area,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Editar usuario existente.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar usuario y su rol.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|string',
        ]);

        $user->update($request->only('name', 'email', 'area'));
        $user->syncRoles([$request->role]);
        $user->role_name = $request->role;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
