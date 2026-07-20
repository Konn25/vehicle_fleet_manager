<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstNameMale(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'age' => fake()->numberBetween(18, 56),
            'actual_vehicle' => fake()->numberBetween(1, 44)
        ];
    }
}
