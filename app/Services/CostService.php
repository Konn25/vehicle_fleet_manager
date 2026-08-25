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
                    'cost' => $cost,
                ];
            });
    }

    public function getMonthlyCosts(Vehicle $vehicle, string $currency, int $year): Collection
    {
        return $this->getServiceCosts($vehicle, $currency)
            ->filter(function ($service) use ($year) {
                return substr($service['date'], 0, 4) == $year;
            })
            ->groupBy(function ($service) {
                return substr($service['date'], 0, 7);
            })
            ->map(function ($services) {
                return round(
                    $services->sum('cost'),
                    2
                );
            });
    }


    public function getYearlyCosts(Vehicle $vehicle, string $currency): Collection
    {
        return $this->getServiceCosts($vehicle, $currency)->groupBy(function ($service) {
            return substr($service['date'], 0, 4);
        })->map(function ($services) {
            return round($services->sum('cost'), 2);
        });
    }

    public function getTotalCost(Vehicle $vehicle, string $currency): float
    {
        return round($this->getServiceCosts($vehicle, $currency)->sum('cost'), 2);
    }
}
