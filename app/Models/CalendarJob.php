<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class CalendarJob extends Model
{
    use LogsActivity;

    protected $fillable = [
        'crew_id',
        'product_id',
        'work_date',
        'client_name',
        'location',
        'area_m2',
        'material_type',
        'notes',
        'completed',
        'confirmed',
        'stock_deducted',
        'confirmed_by',
        'confirmed_at',
    ];

    protected $casts = [
        'work_date'      => 'date',
        'completed'      => 'boolean',
        'confirmed'      => 'boolean',
        'stock_deducted' => 'boolean',
        'confirmed_at'   => 'datetime',
    ];

    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}
