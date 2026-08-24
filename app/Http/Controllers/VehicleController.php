<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\FuelType;
use App\Models\Vehicle;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::with(['brand', 'fuelType'])->get();

        $brands = Brand::orderBy('name')->get();
        $fuelTypes = FuelType::orderBy('name')->get();

        return view('vehicles.index', compact(
            'vehicles',
            'brands',
            'fuelTypes'
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
            'avarage_consumption' => 'required|numeric',
        ]);

        Vehicle::create($request->all());

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle, CurrencyService $currencyService)
    {

        $vehicle->load(['brand', 'fuelType', 'services']);

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




        return view('vehicles.show', compact(
            'vehicle',
            'brands',
            'fuelTypes',
            'services'
        ));


        // return view('vehicles.show', compact('vehicle'));
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


    public function serviceCosts(
        Vehicle $vehicle,
        Request $request,
        CurrencyService $currencyService
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

        $services = $vehicle->services()
            ->orderBy('service_date')
            ->get();

        $data = $services->map(function ($service) use (
            $currency,
            $currencyService
        ) {
            $cost = $currencyService->convert(
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

        return response()->json([
            'currency' => $currency,
            'data' => $data,
        ]);
    }
}
