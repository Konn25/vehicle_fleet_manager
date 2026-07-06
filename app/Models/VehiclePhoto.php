<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Hidden;

#[Hidden(['path'])]
class VehiclePhoto extends Model
{
    /** @use HasFactory<\Database\Factories\VehiclePhotoFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'vehicle_images' => 'string',
            'path' => 'string',
            'vehicle_id' => 'integer',
        ];
    }
}
