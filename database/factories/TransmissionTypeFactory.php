<?php

namespace Database\Factories;

use App\Models\TransmissionType;
use Faker\Provider\FakeCar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransmissionType>
 */
class TransmissionTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new FakeCar($this->faker));
        $vehicle = $this->faker->vehicleArray();

        return [
            'name' => $this->faker->vehicleGearBoxType()
        ];
    }
}
