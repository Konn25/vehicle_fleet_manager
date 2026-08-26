<?php

namespace App\Http\Controllers;

use App\Models\Fueling;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FuelingController extends Controller
{
    public function store(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'fueling_date' => ['required', 'date'],
            'liters' => ['required', 'numeric', 'min:0.01'],
            'price_per_liter' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'in:HUF,EUR,USD,GBP,CHF'],
            'odometer' => ['required', 'integer', 'min:0'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $this->validateOdometer(
            $vehicle->id,
            $validated['odometer']
        );

        $validated['vehicle_id'] = $vehicle->id;

        $validated['total_cost'] = round(
            $validated['liters'] * $validated['price_per_liter'],
            2
        );


        $lastOdometer = $vehicle->fuelings()
            ->max('odometer');

        if (
            $lastOdometer !== null &&
            $validated['odometer'] <= $lastOdometer
        ) {
            throw ValidationException::withMessages([
                'odometer' =>
                'Odometer must be greater than the last recorded value (' .
                    number_format($lastOdometer) .
                    ' km).',
            ]);
        }
        Fueling::create($validated);

        return redirect()
            ->route('vehicles.show', $vehicle)
            ->with('success', 'Fueling added successfully.');
    }


    public function update(Request $request, Fueling $fueling)
    {
        $validated = $request->validate([
            'fueling_date' => ['required', 'date'],
            'liters' => ['required', 'numeric', 'min:0.01'],
            'price_per_liter' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'in:HUF,EUR,USD,GBP,CHF'],
            'odometer' => ['required', 'integer', 'min:0'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $this->validateOdometer(
            $fueling->vehicle_id,
            $validated['odometer'],
            $fueling->id
        );

        $validated['total_cost'] = round($validated['liters'] * $validated['price_per_liter'], 2);

        $fueling->update($validated);

        return redirect()
            ->route('vehicles.show', $fueling->vehicle_id)
            ->with('success', 'Fueling updated successfully.');
    }


    public function destroy(Fueling $fueling)
    {
        $vehicleId = $fueling->vehicle_id;

        $fueling->delete();

        return redirect()
            ->route('vehicles.show', $vehicleId)
            ->with('success', 'Fueling deleted successfully.');
    }


    private function validateOdometer(int $vehicleId, int $odometer, ?int $excludeFuelingId = null): void
    {
        $query = Fueling::where('vehicle_id', $vehicleId);

        if ($excludeFuelingId !== null) {
            $query->where('id', '!=', $excludeFuelingId);
        }

        $previousFueling = (clone $query)
            ->where('odometer', '<', $odometer)
            ->orderByDesc('odometer')
            ->first();

        $nextFueling = (clone $query)
            ->where('odometer', '>', $odometer)
            ->orderBy('odometer')
            ->first();

        $sameOdometer = (clone $query)
            ->where('odometer', $odometer)
            ->exists();

        if ($sameOdometer) {
            throw ValidationException::withMessages([
                'odometer' =>
                'A fueling already exists with this odometer value.',
            ]);
        }

        if (
            $previousFueling &&
            $nextFueling &&
            !(
                $odometer > $previousFueling->odometer &&
                $odometer < $nextFueling->odometer
            )
        ) {
            throw ValidationException::withMessages([
                'odometer' =>
                'Odometer must be between ' .
                    number_format($previousFueling->odometer) .
                    ' km and ' .
                    number_format($nextFueling->odometer) .
                    ' km.',
            ]);
        }
    }
}
