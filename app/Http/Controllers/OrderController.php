<?php

namespace App\Http\Controllers;

use App\Models\HeaderOrder;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Lista todas las órdenes completas (cabecera + detalles).
     */
    public function index(): JsonResponse
    {
        $orders = HeaderOrder::with([
            'customer',
            'status',
            'orderDetails.product',
        ])->orderBy('order_date', 'desc')->get();

        return response()->json([
            'success' => true,
            'data'    => $orders,
        ]);
    }

    /**
     * Crea una orden completa (cabecera + detalles) en una transacción.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id'          => 'required|integer|exists:customers,id',
            'order_status'         => 'nullable|string|max:50',
            'discount'             => 'nullable|numeric|min:0',
            'status_id'            => 'required|integer|exists:status,id',

            // Detalles
            'details'                    => 'required|array|min:1',
            'details.*.product_id'       => 'required|integer|exists:products,id',
            'details.*.quantity'         => 'required|numeric|min:0.01',
            'details.*.price'            => 'required|numeric|min:0',
            'details.*.iva'              => 'nullable|numeric|min:0',
        ]);

        $order = DB::transaction(function () use ($validated) {

            $orderAmount = 0;
            $detailsData = [];

            foreach ($validated['details'] as $item) {
                $product  = Product::findOrFail($item['product_id']);
                $subtotal = round($item['quantity'] * $item['price'], 2);
                $iva      = isset($item['iva']) ? round($subtotal * $item['iva'], 2) : 0;

                $orderAmount += $subtotal;

                $detailsData[] = [
                    'product_id'   => $product->id,
                    'quantity'     => $item['quantity'],
                    'barcode'      => $product->barcode,
                    'product_name' => $product->product_name,
                    'price'        => $item['price'],
                    'subtotal'     => $subtotal,
                    'iva'          => $iva,
                    'status_id'    => $validated['status_id'],
                ];
            }

            $discount = $validated['discount'] ?? 0;
            $total    = round($orderAmount - $discount, 2);

            // Crear cabecera
            $header = HeaderOrder::create([
                'customer_id'  => $validated['customer_id'],
                'order_status' => $validated['order_status'] ?? null,
                'order_amount' => $orderAmount,
                'discount'     => $discount,
                'total'        => $total,
                'status_id'    => $validated['status_id'],
            ]);

            // Crear detalles vinculados a la cabecera.
            // IMPORTANTE: create() individual en vez de insert() masivo,
            // para que el OrderDetailObserver dispare y descuente el stock.
            foreach ($detailsData as $detail) {
                $detail['header_order_id'] = $header->id;
                OrderDetail::create($detail);
            }

            return $header->load(['customer', 'status', 'orderDetails.product']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Orden creada exitosamente.',
            'data'    => $order,
        ], 201);
    }

    /**
     * Muestra una orden completa con todos sus detalles.
     */
    public function show(string $id): JsonResponse
    {
        $order = HeaderOrder::with([
            'customer',
            'status',
            'orderDetails.product.unitMeasurement',
            'orderDetails.status',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $order,
        ]);
    }

    /**
     * Actualiza el estado y descuento de una orden (cabecera).
     * Para modificar detalles usar OrderDetailController.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $order = HeaderOrder::findOrFail($id);

        $validated = $request->validate([
            'customer_id'  => 'required|integer|exists:customers,id',
            'order_status' => 'nullable|string|max:50',
            'order_amount' => 'nullable|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0',
            'total'        => 'nullable|numeric|min:0',
            'status_id'    => 'required|integer|exists:status,id',
        ]);

        $order->update($validated);
        $order->load(['customer', 'status', 'orderDetails.product']);

        return response()->json([
            'success' => true,
            'message' => 'Orden actualizada exitosamente.',
            'data'    => $order,
        ]);
    }

    /**
     * Elimina una orden y sus detalles (cascade en lógica de negocio).
     */
    public function destroy(string $id): JsonResponse
    {
        $order = HeaderOrder::findOrFail($id);

        DB::transaction(function () use ($order) {
            // Borrado individual (no ->delete() masivo) para que el
            // Observer devuelva el stock de cada línea.
            foreach ($order->orderDetails as $detail) {
                $detail->delete();
            }

            $order->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Orden eliminada exitosamente.',
        ]);
    }
}