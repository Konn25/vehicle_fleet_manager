@extends('layouts.app')

@section('title', 'Vehicle Details')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between mb-4">
            <h2>
                <i class="fas fa-car"></i>
                {{ $vehicle->license_plate }}
            </h2>

            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
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

@endsection
