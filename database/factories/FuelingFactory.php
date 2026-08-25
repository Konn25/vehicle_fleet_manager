<?php

namespace Database\Factories;

use App\Models\Fueling;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fueling>
 */
class FuelingFactory extends Factory
{
    protected $model = Fueling::class;

    public function definition(): array
    {
        $liters = fake()->randomFloat(2, 30, 55);
        $pricePerLiter = fake()->randomFloat(2, 580, 650);

        return [
            'vehicle_id' => null,
            'fueling_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'liters' => $liters,
            'price_per_liter' => $pricePerLiter,
            'total_cost' => round($liters * $pricePerLiter, 2),
            'currency' => 'HUF',
            'odometer' => null,
            'note' => fake()->optional()->sentence(),
        ];
    }
}
