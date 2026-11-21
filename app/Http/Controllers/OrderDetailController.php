<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
     *
     * IV-01 (concurrencia): el producto se bloquea con lockForUpdate() y el
     * stock se valida dentro de la misma transacción en la que el
     * OrderDetailObserver lo descuenta.
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

        $detail = DB::transaction(function () use ($validated) {
            // Bloquear el producto hasta que termine la transacción
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

            if (((float) $product->stock - (float) $product->reserved_stock) < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => "Stock insuficiente de {$product->product_name}: disponible {$product->stock}, solicitado {$validated['quantity']}.",
                ]);
            }

            // Copiar barcode y nombre del producto al momento de la venta
            $validated['barcode']      = $product->barcode;
            $validated['product_name'] = $product->product_name;

            $detail = OrderDetail::create($validated);

            return $detail->load(['headerOrder', 'product', 'status']);
        });

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
     *
     * Se bloquean el detalle y los productos involucrados (el anterior y el
     * nuevo, ordenados por id para evitar deadlocks) y se valida que alcance
     * el stock para la cantidad adicional que se está pidiendo.
     */
    public function update(Request $request, string $id): JsonResponse
    {
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

        $detail = DB::transaction(function () use ($validated, $id) {
            $detail = OrderDetail::lockForUpdate()->findOrFail($id);

            $ids = collect([$detail->product_id, $validated['product_id']])
                ->unique()
                ->sort()
                ->values();

            $products = Product::whereIn('id', $ids)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $nuevo = $products[$validated['product_id']];

            // Cantidad extra que hay que sacar del stock del producto nuevo
            $extra = ((int) $detail->product_id === (int) $validated['product_id'])
                ? (float) $validated['quantity'] - (float) $detail->quantity
                : (float) $validated['quantity'];

            if ($extra > 0 && ((float) $nuevo->stock - (float) $nuevo->reserved_stock) < $extra) {
                throw ValidationException::withMessages([
                    'quantity' => "Stock insuficiente de {$nuevo->product_name}: disponible {$nuevo->stock}, se necesitan {$extra} más.",
                ]);
            }

            $detail->update($validated);

            return $detail->load(['headerOrder', 'product', 'status']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Detalle de orden actualizado exitosamente.',
            'data'    => $detail,
        ]);
    }

    /**
     * Elimina un detalle de orden.
     * En una transacción: la devolución de stock del Observer y el borrado
     * se confirman juntos o no se confirman.
     */
    public function destroy(string $id): JsonResponse
    {
        DB::transaction(function () use ($id) {
            $detail = OrderDetail::lockForUpdate()->findOrFail($id);
            $detail->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Detalle de orden eliminado exitosamente.',
        ]);
    }
}
