<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';

    protected $fillable = ['subcategory_name', 'category_id', 'status_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }
    public function allowedUnits()
    {
        return $this->belongsToMany(
            UnitMeasurement::class,
            'sub_category_unit_measurement',
            'sub_category_id',
            'unit_id'
        );
    }
}
