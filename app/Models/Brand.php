<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class Brand extends Model
{
    //
    use HasFactory;

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string'
        ];
    }

    public function models(): HasMany
    {
        return $this->hasMany(BrandModel::class);
    }
}
