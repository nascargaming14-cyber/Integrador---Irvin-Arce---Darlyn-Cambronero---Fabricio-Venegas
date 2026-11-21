<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'product_id',
        'project_name',
        'quantity',
        'status',
        'user_id',
        'notes',
        'dispatched_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity'      => 'decimal:2',
            'dispatched_at' => 'datetime',
            'cancelled_at'  => 'datetime',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function returns()
    {
        return $this->hasMany(StockReturn::class);
    }
}
