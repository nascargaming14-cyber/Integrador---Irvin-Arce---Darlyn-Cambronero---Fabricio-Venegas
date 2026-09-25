<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_suppliers'
        )->withPivot('status_id')
         ->withTimestamps();
    }

    public function productSuppliers()
    {
        return $this->hasMany(ProductSupplier::class);
    }

}
