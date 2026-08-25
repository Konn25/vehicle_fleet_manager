<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Support\Collection;

class CostService
{
    public function __construct(
        private CurrencyService $currencyService
    ) {}

    public function getServiceCosts(Vehicle $vehicle, string $currency): Collection
    {
        return $vehicle->services()
            ->orderBy('service_date')
            ->get()
            ->map(function ($service) use ($currency) {
                $cost = $this->currencyService->convert(
                    (float) $service->cost,
                    $service->currency,
                    $currency,
                    $service->service_date
                );

                return [
                    'date' => $service->service_date->format('Y-m-d'),
                    'cost' => round($cost, 2)
                ];
            })->values();
    }

    public function getFuelingCosts(
        Vehicle $vehicle,
        string $currency
    ) {
        return $vehicle->fuelings()
            ->orderBy('fueling_date')
            ->get()
            ->map(function ($fueling) use ($currency) {

                $cost = $this->currencyService->convert(
                    (float) $fueling->total_cost,
                    $fueling->currency,
                    $currency,
                    $fueling->fueling_date
                );

                return [
                    'date' => $fueling->fueling_date->format('Y-m-d'),
                    'cost' => round($cost, 2),
                ];
            })
            ->values();
    }

    public function getMonthlyCosts(Vehicle $vehicle, string $currency, int $year)
    {
        $services = $this->getServiceCosts($vehicle, $currency);
        $fuelings = $this->getFuelingCosts($vehicle, $currency);

        $monthly = [];

        foreach (range(1, 12) as $month) {
            $monthly[$month] = [
                'month' => $month,
                'service' => 0,
                'fueling' => 0,
                'total' => 0,
            ];
        }

        foreach ($services as $service) {
            $date = \Carbon\Carbon::parse($service['date']);

            if ($date->year !== $year) {
                continue;
            }

            $month = $date->month;

            $monthly[$month]['service'] += $service['cost'];
        }

        foreach ($fuelings as $fueling) {
            $date = \Carbon\Carbon::parse($fueling['date']);

            if ($date->year !== $year) {
                continue;
            }

            $month = $date->month;

            $monthly[$month]['fueling'] += $fueling['cost'];
        }

        foreach ($monthly as &$data) {
            $data['service'] = round($data['service'], 2);
            $data['fueling'] = round($data['fueling'], 2);

            $data['total'] = round($data['service'] + $data['fueling'], 2);
        }

        return array_values($monthly);
    }


    public function getYearlyCosts(Vehicle $vehicle, string $currency)
    {
        $services = $this->getServiceCosts($vehicle, $currency);
        $fuelings = $this->getFuelingCosts($vehicle, $currency);

        $yearly = [];

        foreach ($services as $service) {
            $year = \Carbon\Carbon::parse($service['date'])->year;

            $yearly[$year]['service'] =
                ($yearly[$year]['service'] ?? 0) + $service['cost'];
        }

        foreach ($fuelings as $fueling) {
            $year = \Carbon\Carbon::parse($fueling['date'])->year;

            $yearly[$year]['fueling'] =
                ($yearly[$year]['fueling'] ?? 0) + $fueling['cost'];
        }

        foreach ($yearly as $year => &$data) {
            $data['service'] = round($data['service'] ?? 0, 2);
            $data['fueling'] = round($data['fueling'] ?? 0, 2);

            $data['total'] = round($data['service'] + $data['fueling'], 2);
        }

        return $yearly;
    }

    public function getTotalCost(Vehicle $vehicle, string $currency): float
    {
        $services = $this->getServiceCosts($vehicle, $currency);
        $fuelings = $this->getFuelingCosts($vehicle, $currency);

        $serviceTotal = $services->sum('cost');
        $fuelingTotal = $fuelings->sum('cost');

        return round($serviceTotal + $fuelingTotal, 2);
    }
}
