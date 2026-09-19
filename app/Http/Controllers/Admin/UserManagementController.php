<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::with(['role', 'status'])->orderBy('user_name')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $roles    = Role::orderBy('role_name')->get();
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('admin.users.create', compact('roles', 'statuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
            'email'     => 'required|email|max:150|unique:users,email',
            'telephone' => 'nullable|string|max:20|unique:users,telephone',
            'password'  => 'required|string|min:8|confirmed',
            'role_id'   => 'required|integer|exists:roles,id',
            'status_id' => 'required|integer|exists:status,id',
        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(string $id): View
    {
        $user     = User::findOrFail($id);
        $roles    = Role::orderBy('role_name')->get();
        $statuses = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('admin.users.edit', compact('user', 'roles', 'statuses'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
            'email'     => 'required|email|max:150|unique:users,email,' . $id,
            'telephone' => 'nullable|string|max:20|unique:users,telephone,' . $id,
            'password'  => 'nullable|string|min:8|confirmed',
            'role_id'   => 'required|integer|exists:roles,id',
            'status_id' => 'required|integer|exists:status,id',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        if ((int) $id === Auth::id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
