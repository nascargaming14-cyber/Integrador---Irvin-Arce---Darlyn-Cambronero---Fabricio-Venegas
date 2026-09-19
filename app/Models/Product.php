<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'product_name',
        'stock',
        'minimum_stock',
        'price_sale',
        'price_buy',
        'sub_category_id',
        'unit_id',
        'status_id',
    ];

    protected function casts(): array
    {
        return [
            'stock'         => 'decimal:2',
            'minimum_stock' => 'decimal:2',
            'price_sale'    => 'decimal:2',
            'price_buy'     => 'decimal:2',
        ];
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function unitMeasurement()
    {
        return $this->belongsTo(UnitMeasurement::class, 'unit_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_suppliers', 'product_id', 'supplier_id')
            ->withPivot('status_id')
            ->withTimestamps();
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function productSuppliers()
    {
        return $this->hasMany(ProductSupplier::class);
    }
}