<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderOrder extends Model
{
    use HasFactory;

    protected $table = 'header_orders';

    protected $fillable = [
        'customer_id',
        'order_status',
        'order_date',
        'order_amount',
        'discount',
        'total',
        'status_id',
    ];

    protected function casts(): array
    {
        return [
            'order_date'   => 'datetime',
            'order_amount' => 'decimal:2',
            'discount'     => 'decimal:2',
            'total'        => 'decimal:2',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Porcentaje pagado según el estado del pedido (order_status).
     * pendiente = 0% | en proceso = 50% | completado / cancelado = 100%
     */
    public function getPaymentPercentAttribute(): int
    {
        return match (strtolower($this->order_status ?? '')) {
            'completado', 'cancelado' => 100,
            'en proceso'              => 50,
            default                   => 0,
        };
    }

    /**
     * Monto ya pagado, calculado sobre el total (que ya incluye IVA - descuento).
     */
    public function getPaymentPaidAttribute(): float
    {
        return round(((float) $this->total) * $this->payment_percent / 100, 2);
    }

    /**
     * Monto pendiente por pagar.
     */
    public function getPaymentDueAttribute(): float
    {
        return round(((float) $this->total) - $this->payment_paid, 2);
    }
}
