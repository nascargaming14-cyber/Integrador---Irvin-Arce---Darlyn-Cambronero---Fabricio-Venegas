<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Lista todos los estados.
     */
    public function index(): JsonResponse
    {
        $statuses = Status::orderBy('status_name')->get();

        return response()->json([
            'success' => true,
            'data'    => $statuses,
        ]);
    }

    /**
     * Crea un nuevo estado.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status_name' => 'required|string|max:50|unique:status,status_name',
        ]);

        $status = Status::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Estado creado exitosamente.',
            'data'    => $status,
        ], 201);
    }

    /**
     * Muestra un estado específico.
     */
    public function show(string $id): JsonResponse
    {
        $status = Status::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $status,
        ]);
    }

    /**
     * Actualiza un estado existente.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $status = Status::findOrFail($id);

        $validated = $request->validate([
            'status_name' => 'required|string|max:50|unique:status,status_name,' . $id,
        ]);

        $status->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado exitosamente.',
            'data'    => $status,
        ]);
    }

    /**
     * Elimina un estado.
     */
    public function destroy(string $id): JsonResponse
    {
        $status = Status::findOrFail($id);
        $status->delete();

        return response()->json([
            'success' => true,
            'message' => 'Estado eliminado exitosamente.',
        ]);
    }
}