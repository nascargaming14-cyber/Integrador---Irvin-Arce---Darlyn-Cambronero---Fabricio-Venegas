<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role_name', 'status_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
