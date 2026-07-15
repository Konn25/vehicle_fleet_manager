<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\FuelType;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'fuel_type_id' => FuelType::factory(),
            'year' => fake()->numberBetween(2000, now()->year),
            'engine_type' => fake()->randomElement(['1.6', '2.0', 'Hybrid']),
            'tank_capacity' => fake()->numberBetween(40, 80),
            'km' => fake()->numberBetween(0, 300000),
            'license_plate' => strtoupper(fake()->bothify('???-###')),
            'state' => fake()->randomElement(['active', 'inactive']),
            'insurance_expiration' => fake()->date(),
            'avarage_consumption' => fake()->randomFloat(1, 4, 10),
        ];
    }
}
