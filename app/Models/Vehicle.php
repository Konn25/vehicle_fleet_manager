<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'fuel_type_id',
        'year',
        'engine_type',
        'tank_capacity',
        'km',
        'license_plate',
        'state',
        'insurance_expiration',
        'avarage_consumption',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'brand_id' => 'integer',
            'year' => 'integer',
            'fuel_type_id' => 'integer',
            'engine_type' => 'string',
            'tank_capacity' => 'integer',
            'km' => 'integer',
            'license_plate' => 'string',
            'state' => 'string',
            'insurance_expiration' => 'string',
            'avarage_consumption' => 'double',
            'vehicle_picture_id' => 'integer',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function picture(): HasMany
    {
        return $this->hasMany(VehiclePhoto::class, 'vehicle_id');
    }
}
