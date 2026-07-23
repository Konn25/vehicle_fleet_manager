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

        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add Vehicle
        </a>

    </div>


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

                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this vehicle?')">

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
                                            value="{{ $vehicle->engine_type }}">

                                    </div>



                                    <div class="mb-3">

                                        <label class="form-label">
                                            Mileage
                                        </label>

                                        <input type="number" name="km" class="form-control"
                                            value="{{ $vehicle->km }}">

                                    </div>



                                    <div class="mb-3">

                                        <label class="form-label">
                                            Tank capacity
                                        </label>

                                        <input type="number" name="tank_capacity" class="form-control"
                                            value="{{ $vehicle->tank_capacity }}">

                                    </div>



                                    <div class="mb-3">

                                        <label class="form-label">
                                            Consumption
                                        </label>

                                        <input type="number" step="0.1" name="avarage_consumption" class="form-control"
                                            value="{{ $vehicle->avarage_consumption }}">

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
