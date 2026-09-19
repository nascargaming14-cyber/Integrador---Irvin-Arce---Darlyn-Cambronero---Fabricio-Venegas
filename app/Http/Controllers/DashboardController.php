<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Movement;
use App\Models\HeaderOrder;
use App\Models\Supplier;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ---- Tarjetas resumen ----
        $totalProductos = Product::count();

        $alertasActivas = Product::whereColumn('stock', '<', 'minimum_stock')->count();

        // Ajusta 'created_at' si HeaderOrder usa otro campo de fecha (ej. 'order_date')
        $ventasDelMes = HeaderOrder::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Proveedores activos, según status_name = 'Activo' (tabla status)
        $proveedoresActivos = Supplier::whereHas('status', function ($q) {
            $q->where('status_name', 'Activo');
        })->count();

        // ---- Movimientos recientes (últimos 5) ----
        $movimientosRecientes = Movement::with(['product', 'user'])
            ->latest('created_at')
            ->take(5)
            ->get();

        // ---- Productos con stock bajo (para el panel de alertas) ----
        $productosStockBajo = Product::with('unitMeasurement')
            ->whereColumn('stock', '<', 'minimum_stock')
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // ---- Ventas de las últimas 6 semanas (para el gráfico) ----
        $ventasSemanales = [];
        for ($i = 5; $i >= 0; $i--) {
            $inicioSemana = now()->subWeeks($i)->startOfWeek();
            $finSemana = now()->subWeeks($i)->endOfWeek();

            $ventasSemanales[] = [
                'label' => 'S' . (6 - $i),
                'total' => HeaderOrder::whereBetween('created_at', [$inicioSemana, $finSemana])->count(),
            ];
        }

        return view('dashboard', compact(
            'totalProductos',
            'alertasActivas',
            'ventasDelMes',
            'proveedoresActivos',
            'movimientosRecientes',
            'productosStockBajo',
            'ventasSemanales'
        ));
    }
}