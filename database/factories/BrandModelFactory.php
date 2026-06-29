<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\BrandModel;
use Faker\Provider\FakeCar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class BrandModelFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BrandModel::class;


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
            'brand_id' => Brand::factory(),
            'name' => $vehicle['model']
        ];
    }
}
