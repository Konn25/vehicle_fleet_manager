@extends('layouts.app')

@section('title', 'Vehicle Details')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

                                    @include('vehicles.partials.service-edit-modal', [
                                        'service' => $service,
                                    ])

                                    <td class="text-end">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editService{{ $service->id }}">

                                            <i class="fas fa-edit"></i>

                                        </button>

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

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="card-title mb-1">
                    Service Costs
                </h3>

                <div class="text-muted small">
                    Total:
                    <strong id="totalServiceCost">0</strong>
                </div>
            </div>


            <select id="currencySelect" class="form-select form-select-sm" style="width: 100px;">
                <option value="HUF">HUF</option>
                <option value="EUR">EUR</option>
                <option value="USD">USD</option>
                <option value="GBP">GBP</option>
            </select>
        </div>

        <div class="card-body">
            <canvas id="serviceCostChart"></canvas>
        </div>
    </div>

    <div class="card mt-4 shadow">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <div>
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar"></i>
                    Cost Summary
                </h5>

                <small id="summaryPeriodLabel">
                    Monthly costs
                </small>
            </div>

            <div class="d-flex gap-2">

                <select id="summaryPeriod" class="form-select form-select-sm">
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>

                <select id="summaryYear" class="form-select form-select-sm">
                    @for ($year = now()->year; $year >= now()->year - 5; $year--)
                        <option value="{{ $year }}">
                            {{ $year }}
                        </option>
                    @endfor
                </select>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Period</th>
                            <th class="text-end">Cost</th>
                        </tr>
                    </thead>

                    <tbody id="costSummaryBody">

                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                Loading...
                            </td>
                        </tr>

                    </tbody>

                    <tfoot>

                        <tr class="fw-bold">

                            <td>
                                Total
                            </td>

                            <td id="summaryTotal" class="text-end">
                                0
                            </td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>

    </div>

    <script>
        const chartCanvas = document.getElementById('serviceCostChart');
        const currencySelect = document.getElementById('currencySelect');

        let serviceCostChart = null;

        const currencyConfig = {
            HUF: {
                locale: 'hu-HU',
                currency: 'HUF'
            },
            EUR: {
                locale: 'de-DE',
                currency: 'EUR'
            },
            USD: {
                locale: 'en-US',
                currency: 'USD'
            },
            GBP: {
                locale: 'en-GB',
                currency: 'GBP'
            }
        };

        function formatCurrency(value, currency) {
            const config = currencyConfig[currency];

            return new Intl.NumberFormat(config.locale, {
                style: 'currency',
                currency: config.currency,
                maximumFractionDigits: 2
            }).format(value);
        }

        async function loadServiceCosts(currency) {
            try {
                const url = "{{ route('vehicles.service-costs', $vehicle) }}" +
                    `?currency=${encodeURIComponent(currency)}`;

                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error('Unable to load service costs.');
                }

                const result = await response.json();

                const labels = result.data.map(item => item.date);
                const costs = result.data.map(item => item.cost);
                const totalCost = costs.reduce((sum, cost) => sum + Number(cost), 0);

                document.getElementById('totalServiceCost').textContent = formatCurrency(totalCost, result.currency);


                if (serviceCostChart) {
                    serviceCostChart.destroy();
                }

                serviceCostChart = new Chart(chartCanvas, {
                    type: 'line',

                    data: {
                        labels: labels,

                        datasets: [{
                            label: `Service costs (${result.currency})`,
                            data: costs,

                            borderWidth: 2,
                            tension: 0.3,

                            fill: false,

                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },

                    options: {
                        responsive: true,

                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },

                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return formatCurrency(
                                            context.parsed.y,
                                            result.currency
                                        );
                                    }
                                }
                            }
                        },

                        scales: {
                            y: {
                                beginAtZero: true,

                                ticks: {
                                    callback: function(value) {
                                        return formatCurrency(
                                            value,
                                            result.currency
                                        );
                                    }
                                }
                            },

                            x: {
                                ticks: {
                                    callback: function(value) {
                                        const date = this.getLabelForValue(value);

                                        return new Date(date)
                                            .toLocaleDateString('hu-HU');
                                    }
                                }
                            }
                        }
                    }
                });

            } catch (error) {
                console.error(error);
            }
        }


        loadServiceCosts('HUF');

        currencySelect.addEventListener('change', function() {
            loadServiceCosts(this.value);
        });


        const summaryPeriod = document.getElementById('summaryPeriod');
        const summaryYear = document.getElementById('summaryYear');
        const summaryBody = document.getElementById('costSummaryBody');
        const summaryTotal = document.getElementById('summaryTotal');
        const summaryPeriodLabel = document.getElementById('summaryPeriodLabel');

        async function loadCostSummary() {

            const currency = currencySelect.value;
            const period = summaryPeriod.value;
            const year = summaryYear.value;

            try {

                const url =
                    "{{ route('vehicles.service-cost-summary', $vehicle) }}" +
                    `?currency=${encodeURIComponent(currency)}` +
                    `&year=${encodeURIComponent(year)}`;

                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error('Unable to load cost summary.');
                }

                const result = await response.json();

                summaryBody.innerHTML = '';

                if (period === 'monthly') {

                    summaryPeriodLabel.textContent =
                        `Monthly costs - ${result.year}`;

                    const monthly = result.monthly;

                    Object.entries(monthly).forEach(([month, cost]) => {

                        const row = document.createElement('tr');

                        const date = new Date(`${month}-01`);

                        const monthName = date.toLocaleDateString(
                            'en-US', {
                                month: 'long'
                            }
                        );

                        row.innerHTML = `
                    <td>
                        ${monthName}
                    </td>

                    <td class="text-end fw-semibold">
                        ${formatCurrency(cost, result.currency)}
                    </td>
                `;

                        summaryBody.appendChild(row);

                    });

                } else {

                    summaryPeriodLabel.textContent =
                        'Yearly costs';

                    const yearly = result.yearly;

                    Object.entries(yearly).forEach(([year, cost]) => {

                        const row = document.createElement('tr');

                        row.innerHTML = `
                    <td>
                        ${year}
                    </td>

                    <td class="text-end fw-semibold">
                        ${formatCurrency(cost, result.currency)}
                    </td>
                `;

                        summaryBody.appendChild(row);

                    });
                }

                summaryTotal.textContent =
                    formatCurrency(result.total, result.currency);

                if (summaryBody.children.length === 0) {

                    summaryBody.innerHTML = `
                <tr>
                    <td colspan="2" class="text-center text-muted py-3">
                        No service costs found.
                    </td>
                </tr>
            `;
                }

            } catch (error) {

                console.error(error);

                summaryBody.innerHTML = `
            <tr>
                <td colspan="2" class="text-center text-danger">
                    Unable to load cost summary.
                </td>
            </tr>
        `;
            }
        }

        summaryPeriod.addEventListener(
            'change',
            loadCostSummary
        );

        summaryYear.addEventListener(
            'change',
            loadCostSummary
        );

        currencySelect.addEventListener(
            'change',
            loadCostSummary
        );

        loadCostSummary();
    </script>

    @include('vehicles.partials.edit-modal')
@endsection
