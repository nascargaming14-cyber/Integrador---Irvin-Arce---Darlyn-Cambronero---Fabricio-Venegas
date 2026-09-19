<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Lista todos los detalles de órdenes con sus relaciones.
     */
    public function index(): JsonResponse
    {
        $details = OrderDetail::with(['headerOrder', 'product', 'status'])
            ->orderBy('id')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $details,
        ]);
    }

    /**
     * Crea un nuevo detalle de orden.
     * Copia barcode y product_name desde el producto para mantener historial.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'header_order_id' => 'required|integer|exists:header_orders,id',
            'product_id'      => 'required|integer|exists:products,id',
            'quantity'        => 'required|numeric|min:0.01',
            'price'           => 'required|numeric|min:0',
            'subtotal'        => 'required|numeric|min:0',
            'iva'             => 'nullable|numeric|min:0',
            'status_id'       => 'required|integer|exists:status,id',
        ]);

        // Copiar barcode y nombre del producto al momento de la venta
        $product = \App\Models\Product::findOrFail($validated['product_id']);
        $validated['barcode']      = $product->barcode;
        $validated['product_name'] = $product->product_name;

        $detail = OrderDetail::create($validated);
        $detail->load(['headerOrder', 'product', 'status']);

        return response()->json([
            'success' => true,
            'message' => 'Detalle de orden creado exitosamente.',
            'data'    => $detail,
        ], 201);
    }

    /**
     * Muestra un detalle de orden específico.
     */
    public function show(string $id): JsonResponse
    {
        $detail = OrderDetail::with(['headerOrder.customer', 'product', 'status'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $detail,
        ]);
    }

    /**
     * Actualiza un detalle de orden existente.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $detail = OrderDetail::findOrFail($id);

        $validated = $request->validate([
            'header_order_id' => 'required|integer|exists:header_orders,id',
            'product_id'      => 'required|integer|exists:products,id',
            'quantity'        => 'required|numeric|min:0.01',
            'barcode'         => 'nullable|string|max:100',
            'product_name'    => 'nullable|string|max:150',
            'price'           => 'required|numeric|min:0',
            'subtotal'        => 'required|numeric|min:0',
            'iva'             => 'nullable|numeric|min:0',
            'status_id'       => 'required|integer|exists:status,id',
        ]);

        $detail->update($validated);
        $detail->load(['headerOrder', 'product', 'status']);

        return response()->json([
            'success' => true,
            'message' => 'Detalle de orden actualizado exitosamente.',
            'data'    => $detail,
        ]);
    }

    /**
     * Elimina un detalle de orden.
     */
    public function destroy(string $id): JsonResponse
    {
        $detail = OrderDetail::findOrFail($id);
        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Detalle de orden eliminado exitosamente.',
        ]);
    }
}