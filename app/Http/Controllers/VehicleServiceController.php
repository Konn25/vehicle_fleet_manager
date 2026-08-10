<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleService;
use Illuminate\Http\Request;

class VehicleServiceController extends Controller
{
    public function store(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'service_date' => ['required', 'date'],
            'cost' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'description' => ['nullable', 'string'],
        ]);

        $vehicle->services()->create($validated);

        return redirect()
            ->route('vehicles.show', $vehicle)
            ->with('success', 'Service was added successfully.');
    }

    public function destroy(VehicleService $vehicleService)
    {
        $vehicle = $vehicleService->vehicle;

        $vehicleService->delete();

        return redirect()
            ->route('vehicles.show', $vehicle)
            ->with('success', 'Service was deleted successfully.');
    }
}
