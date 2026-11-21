<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Escribe en audit_logs los movimientos de inventario (entrada, reserva,
 * salida de reserva y cancelación) con el estado de existencias antes y después.
 */
class AuditTrail
{
    public static function snapshot(Product $product): array
    {
        $stock    = (float) $product->stock;
        $reserved = (float) $product->reserved_stock;

        return [
            'stock'          => $stock,
            'reserved_stock' => $reserved,
            'available'      => $stock - $reserved,
        ];
    }

    public static function log(
        string $module,
        Model $model,
        string $label,
        string $action,
        ?array $before,
        ?array $after
    ): void {
        DB::table('audit_logs')->insert([
            'user_id'        => Auth::id(),
            'module'         => $module,
            'auditable_type' => get_class($model),
            'auditable_id'   => $model->getKey(),
            'record_label'   => mb_substr($label, 0, 150),
            'action'         => $action,
            'before'         => $before === null ? null : json_encode($before),
            'after'          => $after === null ? null : json_encode($after),
            'created_at'     => now(),
        ]);
    }
}
