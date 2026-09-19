<?php

namespace App\Http\Controllers;

use App\Models\ProductSupplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductSupplierController extends Controller
{
    /**
     * Lista todas las relaciones producto-proveedor.
     */
    public function index(): JsonResponse
    {
        $productSuppliers = ProductSupplier::with(['product', 'supplier', 'status'])
            ->orderBy('id')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $productSuppliers,
        ]);
    }

    /**
     * Crea una nueva relación producto-proveedor.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id'  => 'required|integer|exists:products,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'status_id'   => 'required|integer|exists:status,id',
        ]);

        // Evitar duplicados activos
        $exists = ProductSupplier::where('product_id', $validated['product_id'])
            ->where('supplier_id', $validated['supplier_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Esta relación producto-proveedor ya existe.',
            ], 422);
        }

        $productSupplier = ProductSupplier::create($validated);
        $productSupplier->load(['product', 'supplier', 'status']);

        return response()->json([
            'success' => true,
            'message' => 'Relación producto-proveedor creada exitosamente.',
            'data'    => $productSupplier,
        ], 201);
    }

    /**
     * Muestra una relación producto-proveedor específica.
     */
    public function show(string $id): JsonResponse
    {
        $productSupplier = ProductSupplier::with(['product', 'supplier', 'status'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $productSupplier,
        ]);
    }

    /**
     * Actualiza una relación producto-proveedor existente.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $productSupplier = ProductSupplier::findOrFail($id);

        $validated = $request->validate([
            'product_id'  => 'required|integer|exists:products,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'status_id'   => 'required|integer|exists:status,id',
        ]);

        $productSupplier->update($validated);
        $productSupplier->load(['product', 'supplier', 'status']);

        return response()->json([
            'success' => true,
            'message' => 'Relación producto-proveedor actualizada exitosamente.',
            'data'    => $productSupplier,
        ]);
    }

    /**
     * Elimina una relación producto-proveedor.
     */
    public function destroy(string $id): JsonResponse
    {
        $productSupplier = ProductSupplier::findOrFail($id);
        $productSupplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Relación producto-proveedor eliminada exitosamente.',
        ]);
    }
}