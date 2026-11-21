<?php

namespace App\Http\Controllers;

use App\Events\LowStockAlert;
use App\Models\Movement;
use App\Models\Product;
use App\Models\Reservation;
use App\Support\AuditTrail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = Reservation::with(['product', 'user'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function create(): View
    {
        // Solo productos con unidades disponibles (stock - reservado > 0).
        $products = Product::whereRaw('stock - reserved_stock > 0')
            ->orderBy('product_name')
            ->get();

        return view('reservations.create', compact('products'));
    }

    /**
     * Reserva material para un proyecto: baja el disponible y sube el
     * comprometido. No toca el stock físico.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id'   => 'required|integer|exists:products,id',
            'project_name' => 'required|string|max:150',
            'quantity'     => 'required|numeric|min:0.01',
            'notes'        => 'nullable|string|max:500',
        ]);

        $reservation = DB::transaction(function () use ($validated) {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);
            $before  = AuditTrail::snapshot($product);

            // UPDATE condicional: solo reserva si alcanza el disponible.
            $filas = Product::where('id', $product->id)
                ->whereRaw('stock - reserved_stock >= ?', [$validated['quantity']])
                ->increment('reserved_stock', $validated['quantity']);

            if ($filas === 0) {
                $disponible = (float) $product->stock - (float) $product->reserved_stock;

                throw ValidationException::withMessages([
                    'quantity' => "Disponible insuficiente de {$product->product_name}: disponible {$disponible}, solicitado {$validated['quantity']}.",
                ]);
            }

            $reservation = Reservation::create($validated + [
                'status'  => 'activa',
                'user_id' => Auth::id(),
            ]);

            $product->refresh();

            AuditTrail::log(
                'Inventario',
                $reservation,
                "Reserva #{$reservation->id} - {$product->product_name} - {$reservation->project_name}",
                'reserva',
                $before,
                AuditTrail::snapshot($product)
            );

            return $reservation;
        });

        return redirect()
            ->route('reservations.index')
            ->with('success', "Reserva #{$reservation->id} creada para el proyecto {$reservation->project_name}.");
    }

    /**
     * Registra la salida de una reserva: baja el stock físico y libera lo
     * comprometido en el mismo UPDATE; crea el movimiento de "salida".
     */
    public function despachar(Reservation $reservation): RedirectResponse
    {
        DB::transaction(function () use ($reservation) {
            $r = Reservation::lockForUpdate()->findOrFail($reservation->id);

            if ($r->status !== 'activa') {
                throw ValidationException::withMessages([
                    'reservation' => 'Esa reserva ya no está activa.',
                ]);
            }

            $product = Product::lockForUpdate()->findOrFail($r->product_id);
            $before  = AuditTrail::snapshot($product);
            $cantidad = (float) $r->quantity;

            $filas = Product::where('id', $product->id)
                ->where('reserved_stock', '>=', $cantidad)
                ->where('stock', '>=', $cantidad)
                ->decrement('stock', $cantidad, [
                    'reserved_stock' => DB::raw('reserved_stock - ' . $cantidad),
                ]);

            if ($filas === 0) {
                throw ValidationException::withMessages([
                    'reservation' => 'Las existencias no coinciden con la reserva. Revise el inventario.',
                ]);
            }

            Movement::create([
                'product_id'  => $product->id,
                'type'        => 'salida',
                'quantity'    => $cantidad,
                'user_id'     => Auth::id(),
                'description' => mb_substr("Salida de reserva #{$r->id} - Proyecto: {$r->project_name}", 0, 250),
            ]);

            $r->update([
                'status'        => 'despachada',
                'dispatched_at' => now(),
            ]);

            $product->refresh();

            AuditTrail::log(
                'Inventario',
                $r,
                "Salida de reserva #{$r->id} - {$product->product_name} - {$r->project_name}",
                'salida',
                $before,
                AuditTrail::snapshot($product)
            );

            if ($product->stock < $product->minimum_stock) {
                LowStockAlert::dispatch($product);
            }
        });

        return redirect()
            ->route('reservations.index')
            ->with('success', "Salida de la reserva #{$reservation->id} registrada.");
    }

    /**
     * Cancela una reserva activa: libera lo comprometido, el stock no cambia.
     */
    public function cancelar(Reservation $reservation): RedirectResponse
    {
        DB::transaction(function () use ($reservation) {
            $r = Reservation::lockForUpdate()->findOrFail($reservation->id);

            if ($r->status !== 'activa') {
                throw ValidationException::withMessages([
                    'reservation' => 'Esa reserva ya no está activa.',
                ]);
            }

            $product = Product::lockForUpdate()->findOrFail($r->product_id);
            $before  = AuditTrail::snapshot($product);
            $cantidad = (float) $r->quantity;

            $filas = Product::where('id', $product->id)
                ->where('reserved_stock', '>=', $cantidad)
                ->decrement('reserved_stock', $cantidad);

            if ($filas === 0) {
                throw ValidationException::withMessages([
                    'reservation' => 'Las existencias no coinciden con la reserva. Revise el inventario.',
                ]);
            }

            $r->update([
                'status'       => 'cancelada',
                'cancelled_at' => now(),
            ]);

            $product->refresh();

            AuditTrail::log(
                'Inventario',
                $r,
                "Cancelacion de reserva #{$r->id} - {$product->product_name} - {$r->project_name}",
                'cancelar',
                $before,
                AuditTrail::snapshot($product)
            );
        });

        return redirect()
            ->route('reservations.index')
            ->with('success', "Reserva #{$reservation->id} cancelada.");
    }
}
