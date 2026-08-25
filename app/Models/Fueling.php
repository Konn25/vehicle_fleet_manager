<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fueling extends Model
{
    /** @use HasFactory<\Database\Factories\FuelingFactory> */
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'fueling_date',
        'liters',
        'price_per_liter',
        'total_cost',
        'currency',
        'odometer',
        'note',
    ];

    protected $casts = [
        'id' => 'integer',
        'vehicle_id' => 'integer',
        'fueling_date' => 'date',
        'liters' => 'decimal:2',
        'price_per_liter' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'odometer' => 'integer',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
