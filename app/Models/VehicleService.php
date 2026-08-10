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
        'description',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'vehicle_id' => 'integer',
            'service_date' => 'date',
            'cost' => 'decimal:2',
        ];
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
