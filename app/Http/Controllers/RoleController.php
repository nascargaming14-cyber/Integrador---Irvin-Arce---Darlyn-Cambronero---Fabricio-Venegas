<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Lista todos los roles con su estado.
     */
    public function index(): JsonResponse
    {
        $roles = Role::with('status')->orderBy('role_name')->get();

        return response()->json([
            'success' => true,
            'data'    => $roles,
        ]);
    }

    /**
     * Crea un nuevo rol.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:100|unique:roles,role_name',
            'status_id' => 'required|integer|exists:status,id',
        ]);

        $role = Role::create($validated);
        $role->load('status');

        return response()->json([
            'success' => true,
            'message' => 'Rol creado exitosamente.',
            'data'    => $role,
        ], 201);
    }

    /**
     * Muestra un rol específico con su estado y usuarios.
     */
    public function show(string $id): JsonResponse
    {
        $role = Role::with(['status', 'users'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $role,
        ]);
    }

    /**
     * Actualiza un rol existente.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'role_name' => 'required|string|max:100|unique:roles,role_name,' . $id,
            'status_id' => 'required|integer|exists:status,id',
        ]);

        $role->update($validated);
        $role->load('status');

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado exitosamente.',
            'data'    => $role,
        ]);
    }

    /**
     * Elimina un rol.
     */
    public function destroy(string $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rol eliminado exitosamente.',
        ]);
    }
}