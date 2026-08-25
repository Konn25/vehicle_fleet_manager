<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\FuelType;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Services\CostService;
use App\Services\FuelConsumptionService;


class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FuelConsumptionService $fuelConsumptionService)
    {
        $vehicles = Vehicle::with(['brand', 'fuelType', 'fuelings'])->get();

        $brands = Brand::orderBy('name')->get();
        $fuelTypes = FuelType::orderBy('name')->get();

        $consumptions = [];

        foreach ($vehicles as $vehicle) {
            $consumptions[$vehicle->id] = $fuelConsumptionService->getAverageConsumption($vehicle);
        }

        return view('vehicles.index', compact(
            'vehicles',
            'brands',
            'fuelTypes',
            'consumptions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'license_plate' => 'required|max:20|unique:vehicles',
            'year' => 'required|integer',
            'engine_type' => 'required',
            'tank_capacity' => 'required|numeric',
            'km' => 'required|integer',
            'state' => 'required',
            'insurance_expiration' => 'required|date',
        ]);

        Vehicle::create($request->all());

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle,  FuelConsumptionService $fuelConsumptionService)
    {

        $vehicle->load(['brand', 'fuelType', 'services', 'fuelings']);

        $brands = Brand::orderBy('name')->get();
        $fuelTypes = FuelType::orderBy('name')->get();

        $services = $vehicle->services->sortBy('service_date')->map(function ($service) {
            return [
                'date' => $service->service_date->format('Y-m-d'),
                'cost' => (float) $service->cost,
                'currency' => $service->currency,
                'exchange_rate' => (float) $service->exchange_rate,
                'cost_huf' => $service->cost_in_huf,
            ];
        })->values();


        $averageConsumption = $fuelConsumptionService->getAverageConsumption($vehicle);

        return view('vehicles.show', compact(
            'vehicle',
            'brands',
            'fuelTypes',
            'services',
            'averageConsumption'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'engine_type' => ['required'],
            'tank_capacity' => ['required'],
            'km' => ['required'],
            'avarage_consumption' => ['required'],
        ]);


        $vehicle->update($validated);


        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }


    public function serviceCosts(Vehicle $vehicle, Request $request, CostService $costService)
    {
        $currency = strtoupper(
            $request->input('currency', 'HUF')
        );

        $allowedCurrencies = [
            'HUF',
            'EUR',
            'USD',
            'GBP',
        ];

        if (!in_array($currency, $allowedCurrencies)) {
            return response()->json([
                'message' => 'Unsupported currency.'
            ], 422);
        }

        $services = $costService->getServiceCosts(
            $vehicle,
            $currency
        );

        $fuelings = $costService->getFuelingCosts(
            $vehicle,
            $currency
        );

        $year = (int) $request->input(
            'year',
            now()->year
        );

        return response()->json([
            'currency' => $currency,
            'services' => $services,
            'fuelings' => $fuelings,
            'monthly' => $costService->getMonthlyCosts(
                $vehicle,
                $currency,
                $year
            ),
        ]);
    }


    public function serviceCostSummary(
        Vehicle $vehicle,
        Request $request,
        CostService $costService
    ) {
        $currency = strtoupper(
            $request->input('currency', 'HUF')
        );

        $allowedCurrencies = [
            'HUF',
            'EUR',
            'USD',
            'GBP',
        ];

        if (!in_array($currency, $allowedCurrencies)) {
            return response()->json([
                'message' => 'Unsupported currency.'
            ], 422);
        }

        $year = (int) $request->input(
            'year',
            now()->year
        );

        return response()->json([
            'currency' => $currency,
            'year' => $year,

            'monthly' => $costService->getMonthlyCosts(
                $vehicle,
                $currency,
                $year
            ),

            'yearly' => $costService->getYearlyCosts(
                $vehicle,
                $currency
            ),

            'total' => $costService->getTotalCost(
                $vehicle,
                $currency
            ),
        ]);
    }
}
