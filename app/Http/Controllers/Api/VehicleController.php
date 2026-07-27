<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    public function index()
    {
        return Vehicle::with([
            'brand',
            'fuelType',
        ])->get();
    }

    public function show(Vehicle $vehicle)
    {
        return $vehicle->load([
            'brand',
            'fuelType',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_id' => ['required', 'exists:brands,id'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . now()->year],
            'fuel_type_id' => ['required', 'exists:fuel_types,id'],
            'engine_type' => ['required', 'string'],
            'tank_capacity' => ['required', 'integer', 'min:0'],
            'km' => ['required', 'integer', 'min:0'],
            'license_plate' => ['required', 'string', 'max:20'],
            'state' => ['required', 'string'],
            'insurance_expiration' => ['required', 'date'],
            'avarage_consumption' => ['required', 'numeric']
        ]);

        $vehicle = Vehicle::create($validated);

        return response()->json(
            $vehicle->load(['brand', 'fuelType', 'picture']),
            201
        );
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'brand_id' => ['sometimes', 'exists:brands,id'],
            'year' => ['sometimes', 'integer', 'min:1900', 'max:' . now()->year],
            'fuel_type_id' => ['sometimes', 'exists:fuel_types,id'],
            'engine_type' => ['sometimes', 'string'],
            'tank_capacity' => ['sometimes', 'integer', 'min:0'],
            'km' => ['sometimes', 'integer', 'min:0'],
            'license_plate' => ['sometimes', 'string', 'max:20'],
            'state' => ['sometimes', 'string'],
            'insurance_expiration' => ['sometimes', 'date'],
            'avarage_consumption' => ['sometimes', 'numeric'],
        ]);

        $vehicle->update($validated);

        return response()->json(
            $vehicle->load(['brand', 'fuelType', 'picture'])
        );
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->json([
            'message' => 'Vehicle deleted successfully.'
        ]);
    }
}
