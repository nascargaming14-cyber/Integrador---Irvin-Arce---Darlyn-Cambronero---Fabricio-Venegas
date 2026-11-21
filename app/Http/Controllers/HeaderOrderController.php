<?php

namespace App\Http\Controllers;

use App\Events\NewOrderCreated;
use App\Models\Customer;
use App\Models\HeaderOrder;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class HeaderOrderController extends Controller
{
    /**
     * Estados de producto que se consideran "vendibles".
     * Agotado, Descontinuado, Inactivo y Eliminado quedan fuera.
     */
    private const AVAILABLE_PRODUCT_STATUSES = ['Activo', 'Disponible'];

    public function index(): View
    {
        $orders = HeaderOrder::with(['customer', 'status'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function invoice(string $id)
    {
        $order = HeaderOrder::with([
            'customer',
            'status',
            'orderDetails.product',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('orders.invoice-pdf', compact('order'))
            ->setPaper('letter', 'portrait');

        $filename = 'factura-orden-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }

    public function create(): View
    {
        $customers = Customer::orderBy('customer_name')->get();

        // Solo productos activos/disponibles y con stock para poder venderlos.
        $products = $this->availableProductsQuery()->get();

        $statuses  = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Pendiente', 'En revisión',
            'Completado', 'Cancelado', 'Rechazado', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('orders.create', compact('customers', 'products', 'statuses'));
    }

    /**
     * IV-01 (concurrencia): la orden se guarda en una transacción que
     * bloquea los productos (lockForUpdate) y valida el stock antes de
     * descontarlo. Si dos órdenes piden la última unidad, la segunda espera,
     * ve el stock en 0 y se rechaza con un mensaje claro.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateOrder($request);

        try {
            $order = DB::transaction(function () use ($validated) {
                return $this->saveOrderWithDetails($validated);
            });
        } catch (ValidationException $e) {
            return $this->stockRejection($e);
        }

        NewOrderCreated::dispatch($order->load('customer'));

        return redirect()
            ->route('orders.index')
            ->with('success', "Orden #{$order->id} creada exitosamente.");
    }

    public function show(string $id): View
    {
        $order = HeaderOrder::with([
            'customer',
            'status',
            'orderDetails.product',
        ])->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function edit(string $id): View
    {
        $order = HeaderOrder::with('orderDetails')->findOrFail($id);
        $customers = Customer::orderBy('customer_name')->get();

        // 1) Productos vendibles ahora mismo (activo/disponible + stock).
        $availableProducts = $this->availableProductsQuery()->get();

        // 2) Productos que YA están en las líneas de esta orden pero que
        //    quedaron fuera del filtro (agotados, descontinuados, etc).
        //    Los agregamos aparte para no perder esas líneas al editar.
        $usedProductIds = $order->orderDetails->pluck('product_id')->unique();
        $missingIds = $usedProductIds->diff($availableProducts->pluck('id'));

        $unavailableProducts = $missingIds->isNotEmpty()
            ? Product::with(['unitMeasurement', 'status'])->whereIn('id', $missingIds)->get()
            : collect();

        $products = $availableProducts->concat($unavailableProducts);

        $statuses  = Status::whereIn('status_name', [
            'Activo', 'Inactivo', 'Pendiente', 'En revisión',
            'Completado', 'Cancelado', 'Rechazado', 'Eliminado',
        ])->orderBy('status_name')->get();

        return view('orders.edit', compact('order', 'customers', 'products', 'statuses'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $order = HeaderOrder::findOrFail($id);
        $validated = $this->validateOrder($request);

        try {
            DB::transaction(function () use ($order, $validated) {
                // Bloquear primero TODOS los productos involucrados (los de las
                // líneas actuales y los de las nuevas), ordenados por id, para
                // evitar deadlocks con otras órdenes en paralelo.
                $this->lockProducts(
                    $order->orderDetails()->pluck('product_id')
                        ->merge(collect($validated['details'])->pluck('product_id'))
                );

                foreach ($order->orderDetails as $detail) {
                    $detail->delete();
                }

                $this->saveOrderWithDetails($validated, $order);
            });
        } catch (ValidationException $e) {
            return $this->stockRejection($e);
        }

        return redirect()
            ->route('orders.index')
            ->with('success', "Orden #{$order->id} actualizada exitosamente.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $order = HeaderOrder::findOrFail($id);

        try {
            DB::transaction(function () use ($order) {
                foreach ($order->orderDetails as $detail) {
                    $detail->delete();
                }

                $order->delete();
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('orders.index')
                ->with('error', 'No se pudo eliminar la orden.');
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Orden eliminada exitosamente.');
    }

    /**
     * Query base de productos que se pueden ofrecer en una orden nueva:
     * status Activo/Disponible y con stock disponible.
     */
    private function availableProductsQuery()
    {
        return Product::with(['unitMeasurement', 'status'])
            ->whereHas('status', function ($q) {
                $q->whereIn('status_name', self::AVAILABLE_PRODUCT_STATUSES);
            })
            ->whereRaw('stock - reserved_stock > 0')
            ->orderBy('product_name');
    }

    private function validateOrder(Request $request): array
    {
        return $request->validate([
            'customer_id'              => 'required|integer|exists:customers,id',
            'order_status'             => 'nullable|string|max:50',
            'status_id'                => 'required|integer|exists:status,id',
            'discount'                 => 'nullable|numeric|min:0',
            'details'                  => 'required|array|min:1',
            'details.*.product_id'     => 'required|integer|exists:products,id',
            'details.*.quantity'       => 'required|numeric|min:0.01',
            'details.*.price'          => 'required|numeric|min:0',
            'details.*.iva_percent'    => 'nullable|numeric|min:0',
        ]);
    }

    /**
     * Bloquea las filas de productos (SELECT ... FOR UPDATE), ordenadas por id.
     * Debe llamarse dentro de una transacción. Devuelve los productos con el
     * stock ya actualizado, indexados por id.
     */
    private function lockProducts($ids)
    {
        $ids = collect($ids)->unique()->sort()->values();

        return Product::whereIn('id', $ids)
            ->orderBy('id')
            ->lockForUpdate()
            ->get()
            ->keyBy('id');
    }

    /**
     * Respuesta cuando se rechaza una orden por falta de stock.
     */
    private function stockRejection(ValidationException $e): RedirectResponse
    {
        $mensaje = collect($e->errors())->flatten()->first();

        return redirect()
            ->back()
            ->withInput()
            ->withErrors($e->errors())
            ->with('error', $mensaje);
    }

    private function saveOrderWithDetails(array $validated, ?HeaderOrder $order = null): HeaderOrder
    {
        $amount   = 0;
        $ivaTotal = 0;
        $lines    = [];

        // 1. Bloquear los productos y leer su stock actual.
        $products = $this->lockProducts(
            collect($validated['details'])->pluck('product_id')
        );

        // 2. Validar stock sumando las cantidades por producto
        //    (por si el mismo producto viene repetido en varias líneas).
        $pedido = collect($validated['details'])
            ->groupBy('product_id')
            ->map(fn ($lineas) => $lineas->sum(fn ($d) => (float) $d['quantity']));

        foreach ($pedido as $productId => $cantidad) {
            $p = $products[$productId];
            $disponible = (float) $p->stock - (float) $p->reserved_stock;

            if ($disponible < $cantidad) {
                throw ValidationException::withMessages([
                    'details' => "Stock insuficiente de {$p->product_name}: disponible {$disponible} (reservado para proyectos: {$p->reserved_stock}), solicitado {$cantidad}.",
                ]);
            }
        }

        // 3. Armar las líneas.
        foreach ($validated['details'] as $detail) {
            $product   = $products[$detail['product_id']];
            $quantity  = (float) $detail['quantity'];
            $price     = (float) $detail['price'];
            $ivaPct    = (float) ($detail['iva_percent'] ?? 0);
            $subtotal  = round($quantity * $price, 2);
            $iva       = round($subtotal * ($ivaPct / 100), 2);

            $amount   += $subtotal;
            $ivaTotal += $iva;

            $lines[] = [
                'product_id'   => $product->id,
                'quantity'     => $quantity,
                'barcode'      => $product->barcode,
                'product_name' => $product->product_name,
                'price'        => $price,
                'subtotal'     => $subtotal,
                'iva'          => $iva,
                'status_id'    => $validated['status_id'],
            ];
        }

        $discount = (float) ($validated['discount'] ?? 0);
        $total    = max($amount + $ivaTotal - $discount, 0);

        $orderData = [
            'customer_id'  => $validated['customer_id'],
            'order_status' => $validated['order_status'] ?? 'pendiente',
            'order_amount' => $amount,
            'discount'     => $discount,
            'total'        => $total,
            'status_id'    => $validated['status_id'],
        ];

        if ($order) {
            $order->update($orderData);
        } else {
            $orderData['order_date'] = now();
            $order = HeaderOrder::create($orderData);
        }

        // 4. Crear las líneas. El OrderDetailObserver descuenta el stock
        //    (con descuento condicional, nunca deja stock negativo).
        foreach ($lines as $line) {
            $line['header_order_id'] = $order->id;
            OrderDetail::create($line);
        }

        return $order;
    }
}
