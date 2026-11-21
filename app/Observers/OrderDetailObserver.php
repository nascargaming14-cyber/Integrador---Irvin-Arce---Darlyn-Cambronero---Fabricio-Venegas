<?php

namespace App\Observers;

use App\Events\LowStockAlert;
use App\Models\Movement;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderDetailObserver
{
    /**
     * Se crea una línea de venta -> descuenta stock y registra la salida.
     *
     * IV-01: el descuento es una sola instrucción UPDATE con condición
     * (stock >= cantidad). Si no alcanza, no descuenta nada y se lanza una
     * ValidationException, que hace rollback de toda la transacción.
     */
    public function created(OrderDetail $detail): void
    {
        $this->descontar((int) $detail->product_id, (float) $detail->quantity);

        Movement::create([
            'product_id'      => $detail->product_id,
            'order_detail_id' => $detail->id,
            'type'            => 'salida',
            'quantity'        => $detail->quantity,
            'user_id'         => Auth::id(),
            'description'     => "Venta - Orden #{$detail->header_order_id}",
        ]);

        // Si el stock quedó por debajo del mínimo, avisa en tiempo real.
        $product = Product::find($detail->product_id);
        if ($product && $product->stock < $product->minimum_stock) {
            LowStockAlert::dispatch($product);
        }
    }

    /**
     * Cambia la cantidad (o el producto) de una línea existente
     * -> ajusta el stock y actualiza el movimiento.
     */
    public function updated(OrderDetail $detail): void
    {
        if (! $detail->isDirty(['quantity', 'product_id'])) {
            return;
        }

        $productoAnterior = (int) $detail->getOriginal('product_id');
        $productoNuevo    = (int) $detail->product_id;
        $cantidadAnterior = (float) $detail->getOriginal('quantity');
        $cantidadNueva    = (float) $detail->quantity;

        if ($productoAnterior === $productoNuevo) {
            $diferencia = $cantidadNueva - $cantidadAnterior;

            if ($diferencia > 0) {
                // Se vende más -> descuenta la diferencia (validando stock).
                $this->descontar($productoNuevo, $diferencia);
            } elseif ($diferencia < 0) {
                // Se vende menos -> devuelve la diferencia.
                Product::where('id', $productoNuevo)->increment('stock', abs($diferencia));
            }
        } else {
            // Cambió el producto: devuelve al anterior y descuenta del nuevo.
            Product::where('id', $productoAnterior)->increment('stock', $cantidadAnterior);
            $this->descontar($productoNuevo, $cantidadNueva);
        }

        Movement::where('order_detail_id', $detail->id)->update([
            'product_id' => $productoNuevo,
            'quantity'   => $cantidadNueva,
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

    /**
     * Descuento atómico y condicional: "UPDATE products SET stock = stock - X
     * WHERE id = ? AND stock >= X". Nunca deja el stock negativo.
     */
    private function descontar(int $productId, float $cantidad): void
    {
        $filas = Product::where('id', $productId)
            ->where('stock', '>=', $cantidad)
            ->decrement('stock', $cantidad);

        if ($filas === 0) {
            $nombre = Product::whereKey($productId)->value('product_name') ?? "#{$productId}";

            throw ValidationException::withMessages([
                'details' => "Stock insuficiente de {$nombre}.",
            ]);
        }
    }
}
