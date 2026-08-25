<?php

namespace App\Services;

use App\Models\Fueling;
use App\Models\Vehicle;
use Illuminate\Support\Collection;

class FuelConsumptionService
{

    public function calculate(Vehicle $vehicle): Collection
    {
        $fuelings = $vehicle->fuelings()->orderBy('odometer')->get();

        return $fuelings->skip(1)->values()
            ->map(function (Fueling $fueling, int $index) use ($fuelings) {
                $previousFueling = $fuelings[$index];

                $distance = $fueling->odometer - $previousFueling->odometer;

                if ($distance <= 0) {
                    return null;
                }

                $consumption = ((float) $fueling->liters / $distance) * 100;

                return [
                    'date' => $fueling->fueling_date->format('Y-m-d'),
                    'odometer' => $fueling->odometer,
                    'distance' => $distance,
                    'liters' => (float) $fueling->liters,
                    'consumption' => round($consumption, 2),
                ];
            })
            ->filter()
            ->values();
    }

    public function getAverageConsumption(Vehicle $vehicle): ?float
    {
        $fuelings = $vehicle->fuelings()->orderBy('odometer')->get();

        if ($fuelings->count() < 2) {
            return null;
        }

        $totalLiters = 0;
        $totalDistance = 0;

        for ($i = 1; $i < $fuelings->count(); $i++) {
            $previous = $fuelings[$i - 1];
            $current = $fuelings[$i];

            $distance = $current->odometer - $previous->odometer;

            if ($distance <= 0) {
                continue;
            }

            $totalLiters += (float) $current->liters;
            $totalDistance += $distance;
        }

        if ($totalDistance <= 0) {
            return null;
        }

        return round(($totalLiters / $totalDistance) * 100, 2);
    }
}
