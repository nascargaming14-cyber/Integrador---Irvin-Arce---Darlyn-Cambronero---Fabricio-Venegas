<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'header_order_id',
        'product_id',
        'quantity',
        'barcode',
        'product_name',
        'price',
        'subtotal',
        'iva',
        'status_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'price'    => 'decimal:2',
            'subtotal' => 'decimal:2',
            'iva'      => 'decimal:2',
        ];
    }

    public function headerOrder()
    {
        return $this->belongsTo(HeaderOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
