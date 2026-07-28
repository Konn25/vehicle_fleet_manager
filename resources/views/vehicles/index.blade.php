@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold">
                🚗 Vehicle Fleet
            </h1>
            <p class="text-muted">
                Manage your company vehicles
            </p>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createVehicleModal">

            <i class="fas fa-plus"></i>

            Add Vehicle

        </button>

    </div>

    @push('scripts')
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    let modal = new bootstrap.Modal(
                        document.getElementById('createVehicleModal')
                    );

                    modal.show();

                });
            </script>
        @endif
    @endpush

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>
    @endif


    <div class="row">

        @if ($vehicles->count() > 0)

            @foreach ($vehicles as $vehicle)
                <div class="col-xl-4 col-lg-6 mb-4">

                    <div class="card shadow-sm h-100 vehicle-card">

                        <div class="card-header d-flex justify-content-between align-items-center">

                            <h5 class="mb-0 fw-bold">
                                {{ $vehicle->brand->name ?? 'Unknown Brand' }}
                            </h5>


                            @switch(strtolower($vehicle->state))
                                @case('active')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i>
                                        Active
                                    </span>
                                @break

                                @case('service')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-tools"></i>
                                        Service
                                    </span>
                                @break

                                @case('inactive')
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-ban"></i>
                                        Inactive
                                    </span>
                                @break

                                @default
                                    <span class="badge bg-danger">
                                        {{ $vehicle->state }}
                                    </span>
                            @endswitch

                        </div>


                        <div class="card-body">


                            <div class="text-center mb-3">

                                <i class="fas fa-car fa-4x text-primary"></i>

                                <h4 class="mt-2">
                                    {{ $vehicle->license_plate }}
                                </h4>

                            </div>



                            <div class="row text-center">


                                <div class="col-6 mb-3">

                                    <small class="text-muted">
                                        Year
                                    </small>

                                    <div class="fw-bold">
                                        {{ $vehicle->year }}
                                    </div>

                                </div>


                                <div class="col-6 mb-3">

                                    <small class="text-muted">
                                        Fuel
                                    </small>

                                    <div class="fw-bold">
                                        {{ $vehicle->fuelType->name ?? '-' }}
                                    </div>

                                </div>


                                <div class="col-6 mb-3">

                                    <small class="text-muted">
                                        Mileage
                                    </small>

                                    <div class="fw-bold">
                                        {{ number_format($vehicle->km, 0, ',', ' ') }} km
                                    </div>

                                </div>


                                <div class="col-6 mb-3">

                                    <small class="text-muted">
                                        Engine
                                    </small>

                                    <div class="fw-bold">
                                        {{ $vehicle->engine_type }}
                                    </div>

                                </div>


                            </div>



                            <hr>


                            <div class="mb-2">

                                <i class="fas fa-gas-pump text-primary"></i>

                                Consumption:

                                <strong>
                                    {{ $vehicle->avarage_consumption }}
                                    L/100km
                                </strong>

                            </div>

                            @php
                                $insuranceDate = \Carbon\Carbon::parse($vehicle->insurance_expiration)->startOfDay();
                                $today = now()->startOfDay();

                                $daysLeft = $today->diffInDays($insuranceDate, false);
                            @endphp


                            <div>

                                @if ($daysLeft < 0)
                                    <i class="fas fa-shield-alt text-danger"></i>

                                    Insurance:

                                    <strong class="text-danger">
                                        Expired ({{ abs($daysLeft) }} days ago)
                                    </strong>
                                @elseif($daysLeft <= 30)
                                    <i class="fas fa-shield-alt text-warning"></i>

                                    Insurance:

                                    <strong class="text-warning">
                                        {{ $vehicle->insurance_expiration }}
                                        ({{ $daysLeft }} days left)
                                    </strong>
                                @else
                                    <i class="fas fa-shield-alt text-success"></i>

                                    Insurance:

                                    <strong class="text-success">
                                        {{ $vehicle->insurance_expiration }}
                                    </strong>
                                @endif

                            </div>


                        </div>



                        <div class="card-footer text-end">


                            <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>


                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editVehicle{{ $vehicle->id }}">

                                <i class="fas fa-edit"></i>

                            </button>



                            <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this vehicle?')">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>


                        </div>


                    </div>

                </div>
                <div class="modal fade" id="editVehicle{{ $vehicle->id }}" tabindex="-1">

                    <div class="modal-dialog">

                        <div class="modal-content">


                            <div class="modal-header">

                                <h5 class="modal-title">
                                    Edit {{ $vehicle->license_plate }}
                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>

                            </div>


                            <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">

                                @csrf
                                @method('PUT')


                                <div class="modal-body">


                                    <div class="mb-3">

                                        <label class="form-label">
                                            Engine
                                        </label>

                                        <input type="text" name="engine_type" class="form-control"
                                            value="{{ old('engine_type') }}">

                                    </div>



                                    <div class="mb-3">

                                        <label class="form-label">
                                            Mileage
                                        </label>

                                        <input type="number" name="km" class="form-control"
                                            value="{{ old('km') }}">

                                    </div>



                                    <div class="mb-3">

                                        <label class="form-label">
                                            Tank capacity
                                        </label>

                                        <input type="number" name="tank_capacity" class="form-control"
                                            value="{{ old('tank_capacity') }}">

                                    </div>



                                    <div class="mb-3">

                                        <label class="form-label">
                                            Consumption
                                        </label>

                                        <input type="number" step="0.1" name="avarage_consumption"
                                            class="form-control" value="{{ old('avarage_consumption') }}">

                                    </div>


                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>


                                    <button type="submit" class="btn btn-primary">
                                        Save changes
                                    </button>

                                </div>


                            </form>


                        </div>

                    </div>

                </div>
            @endforeach
        @else
            <div class="col-12">

                <div class="alert alert-info text-center">
                    No vehicles found.
                </div>

            </div>

        @endif


    </div>


    <div class="modal fade" id="createVehicleModal" tabindex="-1">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <form action="{{ route('vehicles.store') }}" method="POST">

                    @csrf

                    <div class="modal-header bg-primary text-white">

                        <h5 class="modal-title">
                            <i class="fas fa-car"></i>
                            Add New Vehicle
                        </h5>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Brand</label>

                                    <select name="brand_id" class="form-select" required>

                                        <option value="">Select brand</option>

                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="mb-3">

                                    <label class="form-label">License Plate</label>

                                    <input type="text" name="license_plate" class="form-control" required
                                        value="{{ old('license_plate') }}">

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">Fuel Type</label>

                                    <select name="fuel_type_id" class="form-select" required>

                                        <option value="">Select fuel</option>

                                        @foreach ($fuelTypes as $fuel)
                                            <option value="{{ $fuel->id }}">
                                                {{ $fuel->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">Engine</label>

                                    <input type="text" name="engine_type" class="form-control"
                                        value="{{ old('engine_type') }}">

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">Year</label>

                                    <input type="number" name="year" class="form-control" min="1910"
                                        max="{{ date('Y') }}"
                                        value="{{ old('year') }}>

                                </div>

                            </div>

                            <div class="col-md-6">

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Kilometer (km)
                                        </label>

                                        <input type="number" name="km" class="form-control"
                                            value="{{ old('km') }}>

                                </div>

                                <div class="mb-3">

                                        <label class="form-label">
                                            Tank Capacity (L)
                                        </label>

                                        <input type="number" name="tank_capacity" class="form-control"
                                            value="{{ old('tank_capacity') }}>

                                </div>

                                <div class="mb-3">

                                        <label class="form-label">
                                            Average Consumption
                                        </label>

                                        <input type="number" step="0.1" name="avarage_consumption"
                                            class="form-control" value="{{ old('avarage_consumption') }}">

                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Insurance Expiration
                                        </label>

                                        <input type="date" name="insurance_expiration" class="form-control"
                                            value="{{ old('insurance_expiration') }}">

                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Status
                                        </label>

                                        <select name="state" class="form-select">

                                            <option value="active">Active</option>
                                            <option value="service">Service</option>
                                            <option value="inactive">Inactive</option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-secondary" data-bs-dismiss="modal">

                                Cancel

                            </button>

                            <button class="btn btn-success">

                                <i class="fas fa-save"></i>

                                Save Vehicle

                            </button>

                        </div>

                </form>

            </div>

        </div>

    </div>


@endsection


@push('styles')
    <style>
        .vehicle-card {
            transition: transform .2s ease;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
        }
    </style>
@endpush
