<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleService;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class VehicleServiceController extends Controller
{
    public function store(Request $request, Vehicle $vehicle, CurrencyService $currencyService)
    {
        $validated = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'service_date' => ['required', 'date'],
            'cost' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['currency'] = strtoupper($validated['currency']);

        $validated['exchange_rate'] = $currencyService->getRate(
            $validated['currency'],
            'HUF',
            $validated['service_date']
        );

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

    public function update(
        Request $request,
        VehicleService $vehicleService,
        CurrencyService $currencyService
    ) {
        $validated = $request->validate([
            'service_date' => ['required', 'date'],
            'cost' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['currency'] = strtoupper($validated['currency']);

        $currencyChanged = $vehicleService->currency !== $validated['currency'];

        $dateChanged = $vehicleService->service_date->format('Y-m-d')
            !== date('Y-m-d', strtotime($validated['service_date']));

        if ($currencyChanged || $dateChanged) {
            $validated['exchange_rate'] = $currencyService->getRate(
                $validated['currency'],
                'HUF',
                $validated['service_date']
            );
        }

        $vehicleService->update($validated);

        return redirect()
            ->route('vehicles.show', $vehicleService->vehicle)
            ->with('success', 'Service was updated successfully.');
    }
}
