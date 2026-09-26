<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use LogsActivity;

    protected $fillable = [
        'code',
        'label',
        'sort_order',
        'name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function jobs()
    {
        return $this->hasMany(CalendarJob::class);
    }
}
