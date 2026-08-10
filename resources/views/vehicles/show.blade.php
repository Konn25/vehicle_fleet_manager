@extends('layouts.app')

@section('title', 'Vehicle Details')

@section('content')

    <div class="container">

        <div class="d-flex gap-2">
            <h2>
                <i class="fas fa-car"></i>
                {{ $vehicle->license_plate }}
            </h2>

            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editVehicle{{ $vehicle->id }}">

                <i class="fas fa-edit"></i>
                Edit

            </button>

            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteVehicle{{ $vehicle->id }}">

                <i class="fas fa-trash"></i>
                Delete

            </button>

        </div>
        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                Vehicle Information
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <table class="table">

                            <tr>
                                <th>Brand</th>
                                <td>{{ $vehicle->brand->name }}</td>
                            </tr>

                            <tr>
                                <th>License Plate</th>
                                <td>{{ $vehicle->license_plate }}</td>
                            </tr>

                            <tr>
                                <th>Year</th>
                                <td>{{ $vehicle->year }}</td>
                            </tr>

                            <tr>
                                <th>Fuel Type</th>
                                <td>{{ $vehicle->fuelType->name }}</td>
                            </tr>

                            <tr>
                                <th>Engine</th>
                                <td>{{ $vehicle->engine_type }}</td>
                            </tr>

                            <tr>
                                <th>Tank Capacity</th>
                                <td>{{ $vehicle->tank_capacity }} L</td>
                            </tr>

                        </table>

                    </div>

                    <div class="col-md-6">

                        <table class="table">

                            <tr>
                                <th>KM</th>
                                <td>{{ number_format($vehicle->km) }} km</td>
                            </tr>

                            <tr>
                                <th>Consumption</th>
                                <td>{{ $vehicle->avarage_consumption }} L/100km</td>
                            </tr>

                            <tr>
                                <th>Insurance</th>
                                <td>{{ $vehicle->insurance_expiration }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-success">
                                        {{ ucfirst($vehicle->state) }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Created</th>
                                <td>{{ $vehicle->created_at }}</td>
                            </tr>

                            <tr>
                                <th>Updated</th>
                                <td>{{ $vehicle->updated_at }}</td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow mt-4">

        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="fas fa-tools"></i>
                Service History
            </h5>

            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceModal">

                <i class="fas fa-plus"></i>
                Add Service

            </button>

        </div>

        <div class="card-body">

            @if ($vehicle->services->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Cost</th>
                                <th>Currency</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($vehicle->services->sortByDesc('service_date') as $service)
                                <tr>

                                    <td>
                                        {{ $service->service_date->format('Y-m-d') }}
                                    </td>

                                    <td>
                                        {{ number_format($service->cost, 2, '.', ' ') }}
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $service->currency }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $service->description ?? '-' }}
                                    </td>

                                    <td class="text-end">

                                        <form action="{{ route('vehicles.services.destroy', $service) }}" method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this service?')">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            @else
                <div class="text-center text-muted py-4">

                    <i class="fas fa-tools fa-2x mb-2"></i>

                    <p class="mb-0">
                        No service records found.
                    </p>

                </div>

            @endif

        </div>

    </div>

    <div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('vehicles.services.store', $vehicle) }}" method="POST">

                    @csrf

                    <div class="modal-header bg-secondary text-white">

                        <h5 class="modal-title">
                            <i class="fas fa-tools"></i>
                            Add Service
                        </h5>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label for="service_date" class="form-label">
                                Service Date
                            </label>

                            <input type="date" name="service_date" id="service_date" class="form-control"
                                value="{{ old('service_date') }}" required>

                        </div>

                        <div class="row">

                            <div class="col-md-8">

                                <div class="mb-3">

                                    <label for="cost" class="form-label">
                                        Cost
                                    </label>

                                    <input type="number" name="cost" id="cost" class="form-control" step="0.01"
                                        min="0" value="{{ old('cost') }}" required>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label for="currency" class="form-label">
                                        Currency
                                    </label>

                                    <select name="currency" id="currency" class="form-select" required>

                                        <option value="HUF">HUF</option>
                                        <option value="EUR">EUR</option>
                                        <option value="USD">USD</option>
                                        <option value="GBP">GBP</option>
                                        <option value="CHF">CHF</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="description" class="form-label">
                                Description
                            </label>

                            <textarea name="description" id="description" class="form-control" rows="4"
                                placeholder="What was done during the service?">{{ old('description') }}</textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit" class="btn btn-success">

                            <i class="fas fa-save"></i>
                            Save Service

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    @include('vehicles.partials.edit-modal')
@endsection
