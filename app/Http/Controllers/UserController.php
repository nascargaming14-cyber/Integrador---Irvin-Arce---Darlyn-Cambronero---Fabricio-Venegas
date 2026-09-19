<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Lista todos los usuarios con su rol y estado.
     */
    public function index(): JsonResponse
    {
        $users = User::with(['role', 'status'])
            ->orderBy('user_name')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $users,
        ]);
    }

    /**
     * Crea un nuevo usuario.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
            'email'     => 'required|email|max:150|unique:users,email',
            'telephone' => 'nullable|string|max:20|unique:users,telephone',
            'password'  => 'required|string|min:8|confirmed',
            'role_id'   => 'required|integer|exists:roles,id',
            'status_id' => 'required|integer|exists:status,id',
        ]);

        // El modelo aplica cast 'hashed' automáticamente
        $user = User::create($validated);
        $user->load(['role', 'status']);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado exitosamente.',
            'data'    => $user,
        ], 201);
    }

    /**
     * Muestra un usuario específico con su rol y estado.
     */
    public function show(string $id): JsonResponse
    {
        $user = User::with(['role', 'status'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $user,
        ]);
    }

    /**
     * Actualiza un usuario existente.
     */
    public function update(Request $request, string $id): JsonResponse
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

        // Solo actualizar contraseña si se envía
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);
        $user->load(['role', 'status']);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado exitosamente.',
            'data'    => $user,
        ]);
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado exitosamente.',
        ]);
    }
}