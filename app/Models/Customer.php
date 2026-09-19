<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'dni',
        'id_type',
        'email',
        'telephone',
        'country',
        'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function headerOrders()
    {
        return $this->hasMany(HeaderOrder::class);
    }
}
