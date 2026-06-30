<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransmissionType extends Model
{
    /** @use HasFactory<\Database\Factories\TransmissionTypeFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string'
        ];
    }
}
