<?php

namespace Database\Factories;

use App\Models\VehiclePhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VehiclePhoto>
 */
class VehiclePhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_images' => fake()->colorName(),
            'path' => fake()->streetName(),
            'vehicle_id' => fake()->numberBetween(10, 55),
        ];
    }
}
