<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'status_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
