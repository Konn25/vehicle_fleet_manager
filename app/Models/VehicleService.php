<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class VehicleService extends Model
{

    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'service_date',
        'cost',
        'currency',
        'exchange_rate',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'vehicle_id' => 'integer',
            'service_date' => 'date',
            'cost' => 'decimal:2',
            'exchange_rate' => 'decimal:6',
        ];
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getCostInHufAttribute(): float
    {

        $rate = $this->exchange_rate ?? 1;

        return round(
            (float) $this->cost * (float) $rate,
            2
        );
    }
}
