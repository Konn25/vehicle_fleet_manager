<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),

            'service_date' => fake()
                ->dateTimeBetween('-2 years', 'now')
                ->format('Y-m-d'),

            'cost' => fake()->randomFloat(
                2,
                10000,
                300000
            ),

            'currency' => 'HUF',

            'exchange_rate' => 1.000000,

            'description' => fake()->randomElement([
                'Oil change',
                'Brake service',
                'Tire change',
                'Engine service',
                'Transmission service',
                'Battery replacement',
                'Annual inspection',
                'General maintenance',
            ]),
        ];
    }
}
