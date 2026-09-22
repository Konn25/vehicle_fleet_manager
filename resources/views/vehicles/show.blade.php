@extends('layouts.app')

@section('title', $vehicle->license_plate . ' · Vehicle Details')

@section('content')
    @php
        $state = strtolower($vehicle->state ?? 'unknown');
        $stateConfig = match ($state) {
            'active' => ['label' => 'Active', 'icon' => 'fa-circle-check', 'class' => 'active'],
            'service' => ['label' => 'Service', 'icon' => 'fa-screwdriver-wrench', 'class' => 'service'],
            'inactive' => ['label' => 'Inactive', 'icon' => 'fa-circle-pause', 'class' => 'inactive'],
            default => ['label' => ucfirst($vehicle->state ?? 'Unknown'), 'icon' => 'fa-circle-question', 'class' => 'unknown'],
        };

        $insuranceDate = filled($vehicle->insurance_expiration)
            ? \Carbon\Carbon::parse($vehicle->insurance_expiration)->startOfDay()
            : null;
        $insuranceDays = $insuranceDate ? now()->startOfDay()->diffInDays($insuranceDate, false) : null;
        $insuranceTone = $insuranceDays === null ? 'neutral' : ($insuranceDays < 0 ? 'danger' : ($insuranceDays <= 30 ? 'warning' : 'success'));
        $fuelings = $vehicle->fuelings->sortBy('odometer')->values();
        $services = $vehicle->services->sortByDesc('service_date');
    @endphp

    <main class="fleet-page fleet-show-page">
        <nav class="fleet-breadcrumb mb-3" aria-label="Breadcrumb">
            <a href="{{ route('vehicles.index') }}">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                All vehicles
            </a>
        </nav>

        <section class="vehicle-detail-hero mb-4" aria-labelledby="vehicle-title">
            <div class="vehicle-detail-hero__pattern" aria-hidden="true"></div>
            <div class="position-relative d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
                <div class="d-flex align-items-center gap-3 gap-md-4 min-w-0">
                    <span class="vehicle-detail-hero__icon">
                        <i class="fa-solid fa-car-side" aria-hidden="true"></i>
                    </span>
                    <div class="min-w-0">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <span class="fleet-eyebrow">Vehicle details</span>
                            <span class="fleet-status fleet-status--{{ $stateConfig['class'] }}">
                                <i class="fa-solid {{ $stateConfig['icon'] }}" aria-hidden="true"></i>
                                {{ $stateConfig['label'] }}
                            </span>
                        </div>
                        <h1 id="vehicle-title" class="vehicle-detail-hero__title mb-1 text-truncate">
                            {{ $vehicle->license_plate }}
                        </h1>
                        <p class="vehicle-detail-hero__subtitle mb-0">
                            {{ $vehicle->brand->name ?? 'Unknown brand' }}
                            <span aria-hidden="true">·</span>
                            {{ $vehicle->year ?? 'Year not set' }}
                        </p>
                    </div>
                </div>

                <div class="vehicle-detail-actions">
                    <button type="button" class="btn fleet-btn fleet-btn--hero" data-bs-toggle="modal"
                        data-bs-target="#editVehicle{{ $vehicle->id }}">
                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                        Edit
                    </button>
                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn fleet-btn fleet-btn--hero-danger"
                            onclick="return confirm('Are you sure you want to delete this vehicle?')">
                            <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </section>

        @if ($errors->any())
            <div class="alert fleet-alert fleet-alert--danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2" aria-hidden="true"></i>
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert fleet-alert fleet-alert--success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2" aria-hidden="true"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="detail-metrics mb-4" aria-label="Vehicle summary">
            <article class="detail-metric">
                <span class="detail-metric__icon detail-metric__icon--blue"><i class="fa-solid fa-gauge-high" aria-hidden="true"></i></span>
                <span><small>Mileage</small><strong>{{ number_format($vehicle->km ?? 0, 0, ',', ' ') }} km</strong></span>
            </article>
            <article class="detail-metric">
                <span class="detail-metric__icon detail-metric__icon--cyan"><i class="fa-solid fa-droplet" aria-hidden="true"></i></span>
                <span>
                    <small>Avg. consumption</small>
                    <strong>{{ $averageConsumption !== null ? number_format($averageConsumption, 2) . ' L/100 km' : 'No data' }}</strong>
                </span>
            </article>
            <article class="detail-metric">
                <span class="detail-metric__icon detail-metric__icon--amber"><i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i></span>
                <span><small>Service records</small><strong>{{ $vehicle->services->count() }}</strong></span>
            </article>
            <article class="detail-metric">
                <span class="detail-metric__icon detail-metric__icon--green"><i class="fa-solid fa-gas-pump" aria-hidden="true"></i></span>
                <span><small>Fueling records</small><strong>{{ $vehicle->fuelings->count() }}</strong></span>
            </article>
        </section>

        <section class="fleet-panel mb-4" aria-labelledby="vehicle-information-title">
            <header class="fleet-panel__header">
                <div>
                    <span class="fleet-section-label">Profile</span>
                    <h2 id="vehicle-information-title" class="fleet-panel__title">Vehicle information</h2>
                </div>
            </header>
            <div class="fleet-panel__body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-item__icon"><i class="fa-solid fa-tag" aria-hidden="true"></i></span>
                        <span><small>Brand</small><strong>{{ $vehicle->brand->name ?? '—' }}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-item__icon"><i class="fa-solid fa-id-card" aria-hidden="true"></i></span>
                        <span><small>License plate</small><strong>{{ $vehicle->license_plate }}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-item__icon"><i class="fa-regular fa-calendar" aria-hidden="true"></i></span>
                        <span><small>Year</small><strong>{{ $vehicle->year ?? '—' }}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-item__icon"><i class="fa-solid fa-gas-pump" aria-hidden="true"></i></span>
                        <span><small>Fuel type</small><strong>{{ $vehicle->fuelType->name ?? '—' }}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-item__icon"><i class="fa-solid fa-gears" aria-hidden="true"></i></span>
                        <span><small>Engine</small><strong>{{ $vehicle->engine_type ?: '—' }}</strong></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-item__icon"><i class="fa-solid fa-oil-can" aria-hidden="true"></i></span>
                        <span><small>Tank capacity</small><strong>{{ $vehicle->tank_capacity ? $vehicle->tank_capacity . ' L' : '—' }}</strong></span>
                    </div>
                    <div class="detail-item detail-item--{{ $insuranceTone }}">
                        <span class="detail-item__icon"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></span>
                        <span>
                            <small>Insurance expiration</small>
                            <strong>
                                @if (!$insuranceDate)
                                    —
                                @elseif ($insuranceDays < 0)
                                    {{ $insuranceDate->format('M j, Y') }} · Expired
                                @elseif ($insuranceDays <= 30)
                                    {{ $insuranceDate->format('M j, Y') }} · {{ $insuranceDays }} days left
                                @else
                                    {{ $insuranceDate->format('M j, Y') }}
                                @endif
                            </strong>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-item__icon"><i class="fa-regular fa-clock" aria-hidden="true"></i></span>
                        <span><small>Last updated</small><strong>{{ $vehicle->updated_at?->format('M j, Y · H:i') ?? '—' }}</strong></span>
                    </div>
                </div>
            </div>
        </section>

        <section class="fleet-panel mb-4" aria-labelledby="service-history-title">
            <header class="fleet-panel__header">
                <div>
                    <span class="fleet-section-label">Maintenance</span>
                    <h2 id="service-history-title" class="fleet-panel__title">Service history</h2>
                </div>
                <button type="button" class="btn fleet-btn fleet-btn--soft" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Add service
                </button>
            </header>

            @if ($services->count())
                <div class="table-responsive fleet-table-wrap">
                    <table class="table fleet-table fleet-data-table align-middle mb-0">
                        <thead>
                            <tr><th>Date</th><th>Cost</th><th>Currency</th><th>Description</th><th class="text-end">Actions</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td data-label="Date"><strong>{{ $service->service_date->format('M j, Y') }}</strong></td>
                                    <td data-label="Cost">{{ number_format($service->cost, 2, '.', ' ') }}</td>
                                    <td data-label="Currency"><span class="fleet-currency">{{ $service->currency }}</span></td>
                                    <td data-label="Description" class="fleet-table__description">{{ $service->description ?? '—' }}</td>
                                    <td data-label="Actions" class="text-end">
                                        <div class="fleet-row-actions">
                                            <button type="button" class="btn fleet-icon-btn" data-bs-toggle="modal"
                                                data-bs-target="#editService{{ $service->id }}" aria-label="Edit service">
                                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                            </button>
                                            <form action="{{ route('vehicles.services.destroy', $service) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn fleet-icon-btn fleet-icon-btn--danger" aria-label="Delete service"
                                                    onclick="return confirm('Are you sure you want to delete this service?')">
                                                    <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="fleet-panel-empty">
                    <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i>
                    <p>No service records yet.</p>
                </div>
            @endif
        </section>

        <section class="fleet-panel mb-4" aria-labelledby="fueling-history-title">
            <header class="fleet-panel__header">
                <div>
                    <span class="fleet-section-label">Fuel log</span>
                    <h2 id="fueling-history-title" class="fleet-panel__title">Fueling history</h2>
                </div>
                <button type="button" class="btn fleet-btn fleet-btn--soft" data-bs-toggle="modal" data-bs-target="#addFuelingModal">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Add fueling
                </button>
            </header>

            @if ($fuelings->count())
                <div class="table-responsive fleet-table-wrap">
                    <table class="table fleet-table fleet-data-table align-middle mb-0">
                        <thead>
                            <tr><th>Date</th><th>Odometer</th><th>Distance</th><th>Liters</th><th>Price / L</th><th>Total</th><th>Consumption</th><th class="text-end">Actions</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($fuelings as $index => $fueling)
                                @php
                                    $previousFueling = $index > 0 ? $fuelings[$index - 1] : null;
                                    $distance = $previousFueling ? $fueling->odometer - $previousFueling->odometer : null;
                                    $consumption = $distance && $distance > 0 ? ($fueling->liters / $distance) * 100 : null;
                                @endphp
                                <tr>
                                    <td data-label="Date"><strong>{{ $fueling->fueling_date->format('M j, Y') }}</strong></td>
                                    <td data-label="Odometer">{{ number_format($fueling->odometer, 0, ',', ' ') }} km</td>
                                    <td data-label="Distance">{{ $distance ? number_format($distance, 0, ',', ' ') . ' km' : '—' }}</td>
                                    <td data-label="Liters">{{ number_format($fueling->liters, 2, '.', ' ') }} L</td>
                                    <td data-label="Price / L">{{ number_format($fueling->price_per_liter, 2, '.', ' ') }} {{ $fueling->currency }}</td>
                                    <td data-label="Total"><strong>{{ number_format($fueling->total_cost, 2, '.', ' ') }} {{ $fueling->currency }}</strong></td>
                                    <td data-label="Consumption">
                                        @if ($consumption)
                                            <span class="fleet-consumption">{{ number_format($consumption, 2) }} L/100 km</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td data-label="Actions" class="text-end">
                                        <div class="fleet-row-actions">
                                            <button type="button" class="btn fleet-icon-btn" data-bs-toggle="modal"
                                                data-bs-target="#editFueling{{ $fueling->id }}" aria-label="Edit fueling">
                                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                            </button>
                                            <form action="{{ route('fuelings.destroy', $fueling) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn fleet-icon-btn fleet-icon-btn--danger" aria-label="Delete fueling"
                                                    onclick="return confirm('Are you sure you want to delete this fueling?')">
                                                    <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="fleet-panel-empty">
                    <i class="fa-solid fa-gas-pump" aria-hidden="true"></i>
                    <p>No fueling records yet.</p>
                </div>
            @endif
        </section>

        <section class="row g-4" aria-label="Vehicle cost analytics">
            <div class="col-12 col-xl-8">
                <article class="fleet-panel h-100">
                    <header class="fleet-panel__header fleet-panel__header--controls">
                        <div>
                            <span class="fleet-section-label">Analytics</span>
                            <h2 class="fleet-panel__title">Vehicle costs</h2>
                            <p class="fleet-panel__meta mb-0">Total: <strong id="totalVehicleCost">0</strong></p>
                        </div>
                        <div class="fleet-selects">
                            <label><span>Year</span><select id="costYearSelect" class="form-select form-select-sm">
                                @for ($year = now()->year; $year >= now()->year - 5; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select></label>
                            <label><span>Currency</span><select id="currencySelect" class="form-select form-select-sm">
                                @foreach (['HUF', 'EUR', 'USD', 'GBP'] as $currency)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                            </select></label>
                        </div>
                    </header>
                    <div class="fleet-panel__body"><div class="fleet-chart"><canvas id="serviceCostChart"></canvas></div></div>
                </article>
            </div>

            <div class="col-12 col-xl-4">
                <article class="fleet-panel h-100">
                    <header class="fleet-panel__header fleet-panel__header--controls">
                        <div>
                            <span class="fleet-section-label">Breakdown</span>
                            <h2 class="fleet-panel__title">Cost summary</h2>
                            <p id="summaryPeriodLabel" class="fleet-panel__meta mb-0">Monthly costs</p>
                        </div>
                        <div class="fleet-selects fleet-selects--summary">
                            <label><span>Period</span><select id="summaryPeriod" class="form-select form-select-sm">
                                <option value="monthly">Monthly</option><option value="yearly">Yearly</option>
                            </select></label>
                            <label><span>Year</span><select id="summaryYear" class="form-select form-select-sm">
                                @for ($year = now()->year; $year >= now()->year - 5; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select></label>
                        </div>
                    </header>
                    <div class="fleet-summary-table">
                        <table class="table fleet-table align-middle mb-0">
                            <thead><tr><th>Period</th><th class="text-end">Cost</th></tr></thead>
                            <tbody id="costSummaryBody"><tr><td colspan="2" class="text-center text-muted py-4">Loading...</td></tr></tbody>
                            <tfoot><tr><td>Total</td><td id="summaryTotal" class="text-end">0</td></tr></tfoot>
                        </table>
                    </div>
                </article>
            </div>
        </section>
    </main>

    @include('vehicles.partials.fueling-create-modal')
    @include('vehicles.partials.service-create-modal')
    @include('vehicles.partials.edit-modal')

    @foreach ($services as $service)
        @include('vehicles.partials.service-edit-modal', ['service' => $service])
    @endforeach
    @foreach ($fuelings as $fueling)
        @include('vehicles.partials.fueling-edit-modal', ['fueling' => $fueling])
    @endforeach
@endsection

@push('styles')
    @include('vehicles.partials.page-styles')
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('vehicles.partials.cost-scripts')
@endpush
