<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Driver;
use App\Models\FuelType;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehiclePhoto;
use App\Models\VehicleService;
use App\Models\TransmissionType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@testuser.com',
            'password' => '123456',
            'admin' => 1
        ]);


        // Brands
        $bmw = Brand::factory()->create([
            'name' => 'BMW',
        ]);

        $bmw->models()->create([
            'name' => '325i',
        ]);

        Brand::factory()->count(10)->create();


        // Fuel types
        FuelType::insert([
            ['name' => 'Petrol'],
            ['name' => 'Diesel'],
            ['name' => 'Electric'],
            ['name' => 'Hybrid'],
        ]);


        // Vehicles
        $vehicle = Vehicle::factory()->create([
            'brand_id' => $bmw->id,
            'fuel_type_id' => FuelType::where('name', 'Petrol')->first()->id,
            'year' => fake()->numberBetween(1985, now()->year),
            'engine_type' => 2.5,
            'tank_capacity' => fake()->numberBetween(40, 80),
            'km' => fake()->numberBetween(0, 300000),
            'license_plate' => strtoupper(fake()->bothify('???-###')),
            'state' => fake()->randomElement(['active', 'inactive']),
            'insurance_expiration' => fake()->dateTimeBetween('-2 years', '+2 years'),
            'avarage_consumption' => fake()->randomFloat(1, 4, 10)
        ]);

        Vehicle::factory()->count(10)->create();


        // Drivers
        Driver::factory()->create([
            'name' => fake()->firstNameMale(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'age' => fake()->numberBetween(18, 56),
            'actual_vehicle' => $vehicle->id
        ]);


        // Vehicle photos
        VehiclePhoto::factory()->create([
            'vehicle_images' => fake()->colorName(),
            'path' => fake()->streetName(),
            'vehicle_id' => $vehicle->id
        ]);


        // Transmission types
        TransmissionType::insert([
            ['name' => 'Manual'],
            ['name' => 'Automatic']
        ]);


        // Vehicle services
        Vehicle::all()->each(function (Vehicle $vehicle) {

            VehicleService::factory()
                ->count(fake()->numberBetween(1, 5))
                ->create([
                    'vehicle_id' => $vehicle->id,
                ]);
        });
    }
}
