<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\HeaderOrder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Endpoint de respaldo (polling) para notificaciones.
     * El frontend puede llamarlo periódicamente (ej. cada 15-30s)
     * como fallback si el WebSocket de Reverb se desconecta,
     * o para cargar el estado inicial al abrir el dashboard.
     *
     * GET /notifications/poll?since=2026-07-18T10:00:00
     */
    public function poll(Request $request): JsonResponse
    {
        $since = $request->query('since');

        // --- Productos con stock bajo (stock <= minimum_stock) ---
        $lowStockProducts = Product::query()
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->get()
            ->map(function (Product $product) {
                return [
                    'type'          => 'low-stock',
                    'product_id'    => $product->id,
                    'product_name'  => $product->product_name,
                    'stock'         => (float) $product->stock,
                    'minimum_stock' => (float) $product->minimum_stock,
                ];
            });

        // --- Órdenes recientes ---
        $ordersQuery = HeaderOrder::query()->with('customer')->latest();

        if ($since) {
            $ordersQuery->where('created_at', '>', $since);
        } else {
            // Sin "since", limitamos a las últimas 10 para no saturar
            $ordersQuery->limit(10);
        }

        $recentOrders = $ordersQuery->get()->map(function (HeaderOrder $order) {
            return [
                'type'          => 'new-order',
                'order_id'      => $order->id,
                'customer_name' => $order->customer->customer_name ?? 'Cliente',
                'total'         => (float) $order->total,
                'created_at'    => $order->created_at?->toIso8601String(),
            ];
        });

        return response()->json([
            'server_time'    => now()->toIso8601String(),
            'low_stock'      => $lowStockProducts,
            'recent_orders'  => $recentOrders,
        ]);
    }
}