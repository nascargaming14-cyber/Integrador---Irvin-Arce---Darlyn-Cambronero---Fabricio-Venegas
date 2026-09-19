<?php

namespace App\Console\Commands;

use App\Models\HeaderOrder;
use Illuminate\Console\Command;

class RecalculateOrderTotals extends Command
{
    protected $signature = 'orders:recalculate-totals';

    protected $description = 'Recalcula el total de todas las órdenes existentes aplicando IVA (Monto + IVA - Descuento)';

    public function handle(): int
    {
        $orders = HeaderOrder::with('orderDetails')->get();

        $this->info("Recalculando {$orders->count()} órdenes...");

        $bar = $this->output->createProgressBar($orders->count());
        $bar->start();

        foreach ($orders as $order) {
            $ivaTotal = $order->orderDetails->sum('iva');
            $newTotal = max(((float) $order->order_amount) + $ivaTotal - ((float) $order->discount), 0);

            $order->update(['total' => $newTotal]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('¡Listo! Todos los totales fueron recalculados.');

        return self::SUCCESS;
    }
}
