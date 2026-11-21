<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\StockReturn;
use App\Support\AuditTrail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StockReturnController extends Controller
{
    /**
     * Historial de devoluciones.
     */
    public function index(): View
    {
        $returns = StockReturn::with(['product', 'reservation', 'user'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('stock_returns.index', compact('returns'));
    }

    /**
     * Formulario: solo reservas despachadas que todavía tienen unidades
     * por devolver (despachado - ya devuelto > 0).
     */
    public function create(Request $request): View
    {
        $reservations = Reservation::with('product')
            ->withSum('returns as returned_qty', 'quantity')
            ->where('status', 'despachada')
            ->orderByDesc('id')
            ->get()
            ->filter(fn ($r) => (float) $r->quantity - (float) ($r->returned_qty ?? 0) > 0)
            ->values();

        $selected = $request->query('reservation');

        return view('stock_returns.create', compact('reservations', 'selected'));
    }

    /**
     * Registra una devolución: sube el stock, crea el movimiento de tipo
     * "devolucion" y deja el registro en audit_logs. La salida original
     * (movimiento y reserva despachada) queda intacta.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reservation_id' => 'required|integer|exists:reservations,id',
            'quantity'       => 'required|numeric|min:0.01',
            'notes'          => 'nullable|string|max:500',
        ]);

        $return = DB::transaction(function () use ($validated) {
            // Bloquear la reserva serializa las devoluciones de una misma reserva.
            $r = Reservation::lockForUpdate()->findOrFail($validated['reservation_id']);

            if ($r->status !== 'despachada') {
                throw ValidationException::withMessages([
                    'reservation_id' => 'Solo se puede devolver material de una reserva despachada.',
                ]);
            }

            $yaDevuelto = (float) StockReturn::where('reservation_id', $r->id)->sum('quantity');
            $maximo     = round((float) $r->quantity - $yaDevuelto, 2);
            $cantidad   = (float) $validated['quantity'];

            if ($cantidad > $maximo) {
                throw ValidationException::withMessages([
                    'quantity' => "Solo se pueden devolver {$maximo} unidades de la reserva #{$r->id} (despachado {$r->quantity}, ya devuelto {$yaDevuelto}).",
                ]);
            }

            $product = Product::lockForUpdate()->findOrFail($r->product_id);
            $before  = AuditTrail::snapshot($product);

            // Incremento atómico del stock físico.
            Product::where('id', $product->id)->increment('stock', $cantidad);

            $return = StockReturn::create([
                'reservation_id' => $r->id,
                'product_id'     => $product->id,
                'quantity'       => $cantidad,
                'user_id'        => Auth::id(),
                'notes'          => $validated['notes'] ?? null,
            ]);

            Movement::create([
                'product_id'  => $product->id,
                'type'        => 'devolucion',
                'quantity'    => $cantidad,
                'user_id'     => Auth::id(),
                'description' => mb_substr("Devolución #{$return->id} - Reserva #{$r->id} - Proyecto: {$r->project_name}", 0, 250),
            ]);

            $product->refresh();

            AuditTrail::log(
                'Inventario',
                $return,
                "Devolución #{$return->id} - {$product->product_name} - {$r->project_name}",
                'devolucion',
                $before,
                AuditTrail::snapshot($product)
            );

            return $return;
        });

        return redirect()
            ->route('stock-returns.index')
            ->with('success', "Devolución #{$return->id} registrada: +{$return->quantity} unidades.");
    }
}
