<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitMeasurement extends Model
{
    use HasFactory;

    protected $table = 'unit_measurement';

    protected $fillable = ['unit_name', 'status_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'unit_id');
    }
}