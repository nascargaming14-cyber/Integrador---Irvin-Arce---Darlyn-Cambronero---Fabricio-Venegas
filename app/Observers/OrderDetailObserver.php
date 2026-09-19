<?php

namespace App\Observers;

use App\Events\LowStockAlert;
use App\Models\Movement;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderDetailObserver
{
    /**
     * Se crea una línea de venta -> descuenta stock y registra la salida.
     */
    public function created(OrderDetail $detail): void
    {
        $product = $detail->product;

        if (! $product) {
            return;
        }

        $product->decrement('stock', $detail->quantity);

        Movement::create([
            'product_id'      => $detail->product_id,
            'order_detail_id' => $detail->id,
            'type'            => 'salida',
            'quantity'        => $detail->quantity,
            'user_id'         => Auth::id(),
            'description'     => "Venta - Orden #{$detail->header_order_id}",
        ]);

        // Si el stock quedó por debajo del mínimo, avisa en tiempo real.
        $product->refresh();
        if ($product->stock < $product->minimum_stock) {
            LowStockAlert::dispatch($product);
        }
    }

    /**
     * Cambia la cantidad de una línea existente (ej. al editar una orden)
     * -> ajusta el stock por la diferencia y actualiza el movimiento.
     */
    public function updated(OrderDetail $detail): void
    {
        if (! $detail->isDirty('quantity')) {
            return;
        }

        $product = $detail->product;

        if (! $product) {
            return;
        }

        $cantidadAnterior = $detail->getOriginal('quantity');
        $cantidadNueva    = $detail->quantity;
        $diferencia       = $cantidadNueva - $cantidadAnterior;

        // Si la diferencia es positiva, se está vendiendo más -> descuenta más stock.
        // Si es negativa, se está vendiendo menos -> devuelve stock.
        $product->decrement('stock', $diferencia);

        Movement::where('order_detail_id', $detail->id)->update([
            'quantity' => $cantidadNueva,
        ]);
    }

    /**
     * Se elimina una línea de venta (ej. al editar o borrar una orden)
     * -> devuelve el stock reservado.
     */
    public function deleted(OrderDetail $detail): void
    {
        $product = $detail->product;

        if ($product) {
            $product->increment('stock', $detail->quantity);
        }

        Movement::where('order_detail_id', $detail->id)->delete();
    }
}