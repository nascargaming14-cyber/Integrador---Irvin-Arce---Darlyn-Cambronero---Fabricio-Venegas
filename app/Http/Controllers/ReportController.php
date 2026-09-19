<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Formulario con filtros para el reporte de ventas.
     */
    public function salesForm(): View
    {
        $customers = Customer::orderBy('customer_name')->get();
        $products  = Product::orderBy('product_name')->get();

        return view('reports.sales-form', compact('customers', 'products'));
    }

    // RF-015: Reporte de ventas por período, cliente y producto
    public function salesReport(Request $request)
    {
        $query = OrderDetail::with(['headerOrder.customer', 'product']);

        $query->whereHas('headerOrder', function ($q) use ($request) {
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $q->whereBetween('order_date', [
                    $request->fecha_inicio . ' 00:00:00',
                    $request->fecha_fin . ' 23:59:59',
                ]);
            }
            if ($request->filled('customer_id')) {
                $q->where('customer_id', $request->customer_id);
            }
        });

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $detalles = $query->get();

        $totalVentas = $detalles->sum('subtotal');

        $pdf = Pdf::loadView('reports.sales-pdf', [
            'detalles'    => $detalles,
            'totalVentas' => $totalVentas,
            'fechaInicio' => $request->fecha_inicio,
            'fechaFin'    => $request->fecha_fin,
        ])->setPaper('letter', 'landscape');

        return $pdf->download('reporte-ventas.pdf');
    }

    /**
     * Formulario con filtro de reporte de inventario.
     */
    public function inventoryForm(): View
    {
        return view('reports.inventory-form');
    }

    // RF-016: Reporte de inventario y productos con bajo stock
    public function inventoryReport(Request $request)
    {
        $productos = Product::with('unitMeasurement')
            ->orderBy('stock', 'asc')
            ->get();

        // Bajo stock real: comparando contra el minimum_stock de cada producto,
        // igual que en el Dashboard.
        $bajoStock = $productos->filter(fn ($p) => $p->stock < $p->minimum_stock);

        $pdf = Pdf::loadView('reports.inventory-pdf', [
            'productos' => $productos,
            'bajoStock' => $bajoStock,
        ])->setPaper('letter', 'portrait');

        return $pdf->download('reporte-inventario.pdf');
    }
}