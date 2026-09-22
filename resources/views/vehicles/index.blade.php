@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
    @php
        $vehicleCount = $vehicles->count();
        $activeCount = $vehicles->where('state', 'active')->count();
        $serviceCount = $vehicles->where('state', 'service')->count();
        $inactiveCount = $vehicles->where('state', 'inactive')->count();
    @endphp

    <main class="fleet-page fleet-index-page">
        <section class="fleet-hero mb-4" aria-labelledby="fleet-page-title">
            <div class="fleet-hero__glow fleet-hero__glow--one"></div>
            <div class="fleet-hero__glow fleet-hero__glow--two"></div>

            <div class="position-relative d-flex flex-column flex-lg-row align-items-lg-end justify-content-between gap-4">
                <div>
                    <span class="fleet-eyebrow">
                        <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                        Fleet overview
                    </span>
                    <h1 id="fleet-page-title" class="fleet-hero__title mt-3 mb-2">Vehicle Fleet</h1>
                    <p class="fleet-hero__subtitle mb-0">
                        Keep every vehicle, deadline and operating detail in one clear view.
                    </p>
                </div>

                <button class="btn fleet-btn fleet-btn--light" type="button" data-bs-toggle="modal"
                    data-bs-target="#createVehicleModal">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    <span>Add vehicle</span>
                </button>
            </div>

            <div class="fleet-stats mt-4">
                <div class="fleet-stat">
                    <span class="fleet-stat__icon fleet-stat__icon--blue">
                        <i class="fa-solid fa-car-side" aria-hidden="true"></i>
                    </span>
                    <span><strong>{{ $vehicleCount }}</strong><small>Total vehicles</small></span>
                </div>
                <div class="fleet-stat">
                    <span class="fleet-stat__icon fleet-stat__icon--green">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    </span>
                    <span><strong>{{ $activeCount }}</strong><small>Active</small></span>
                </div>
                <div class="fleet-stat">
                    <span class="fleet-stat__icon fleet-stat__icon--amber">
                        <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i>
                    </span>
                    <span><strong>{{ $serviceCount }}</strong><small>In service</small></span>
                </div>
                <div class="fleet-stat">
                    <span class="fleet-stat__icon fleet-stat__icon--slate">
                        <i class="fa-solid fa-circle-pause" aria-hidden="true"></i>
                    </span>
                    <span><strong>{{ $inactiveCount }}</strong><small>Inactive</small></span>
                </div>
            </div>
        </section>

        @if ($errors->any())
            <div class="alert fleet-alert fleet-alert--danger alert-dismissible fade show" role="alert">
                <div class="d-flex gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-1" aria-hidden="true"></i>
                    <div>
                        <strong>Please check the vehicle details.</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
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

        <section class="fleet-toolbar mb-4" aria-label="Vehicle filters">
            <div class="fleet-search">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <label for="vehicleSearch" class="visually-hidden">Search vehicles</label>
                <input id="vehicleSearch" type="search" class="form-control"
                    placeholder="Search by brand, plate or engine..." autocomplete="off">
            </div>

            <div class="fleet-filter-group" role="group" aria-label="Filter by status">
                <button type="button" class="fleet-filter is-active" data-vehicle-filter="all">All</button>
                <button type="button" class="fleet-filter" data-vehicle-filter="active">Active</button>
                <button type="button" class="fleet-filter" data-vehicle-filter="service">Service</button>
                <button type="button" class="fleet-filter" data-vehicle-filter="inactive">Inactive</button>
            </div>
        </section>

        @if ($vehicles->count() > 0)
            <section id="vehicleGrid" class="row g-4" aria-live="polite">
                @foreach ($vehicles as $vehicle)
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
                        $daysLeft = $insuranceDate ? now()->startOfDay()->diffInDays($insuranceDate, false) : null;
                        $insuranceClass = $daysLeft === null ? 'neutral' : ($daysLeft < 0 ? 'danger' : ($daysLeft <= 30 ? 'warning' : 'success'));
                        $searchText = strtolower(collect([
                            $vehicle->brand->name ?? '',
                            $vehicle->license_plate,
                            $vehicle->engine_type,
                            $vehicle->fuelType->name ?? '',
                        ])->join(' '));
                    @endphp

                    <div class="col-12 col-md-6 col-xl-4 vehicle-grid-item" data-state="{{ $state }}"
                        data-search="{{ $searchText }}">
                        <article class="vehicle-card h-100">
                            <div class="vehicle-card__topline vehicle-card__topline--{{ $stateConfig['class'] }}"></div>
                            <div class="vehicle-card__body">
                                <div class="d-flex align-items-start justify-content-between gap-3">
                                    <div class="d-flex align-items-center gap-3 min-w-0">
                                        <span class="vehicle-card__avatar">
                                            <i class="fa-solid fa-car-side" aria-hidden="true"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="vehicle-card__brand mb-1 text-truncate">{{ $vehicle->brand->name ?? 'Unknown brand' }}</p>
                                            <h2 class="vehicle-card__plate mb-0 text-truncate">{{ $vehicle->license_plate }}</h2>
                                        </div>
                                    </div>
                                    <span class="fleet-status fleet-status--{{ $stateConfig['class'] }}">
                                        <i class="fa-solid {{ $stateConfig['icon'] }}" aria-hidden="true"></i>
                                        {{ $stateConfig['label'] }}
                                    </span>
                                </div>

                                <div class="vehicle-specs my-4">
                                    <div class="vehicle-spec">
                                        <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                        <span><small>Year</small><strong>{{ $vehicle->year ?? '—' }}</strong></span>
                                    </div>
                                    <div class="vehicle-spec">
                                        <i class="fa-solid fa-gas-pump" aria-hidden="true"></i>
                                        <span><small>Fuel</small><strong>{{ $vehicle->fuelType->name ?? '—' }}</strong></span>
                                    </div>
                                    <div class="vehicle-spec">
                                        <i class="fa-solid fa-gauge-high" aria-hidden="true"></i>
                                        <span><small>Mileage</small><strong>{{ number_format($vehicle->km ?? 0, 0, ',', ' ') }} km</strong></span>
                                    </div>
                                    <div class="vehicle-spec">
                                        <i class="fa-solid fa-gears" aria-hidden="true"></i>
                                        <span><small>Engine</small><strong>{{ $vehicle->engine_type ?: '—' }}</strong></span>
                                    </div>
                                </div>

                                <div class="vehicle-card__insights">
                                    <div class="vehicle-insight">
                                        <span class="vehicle-insight__icon"><i class="fa-solid fa-droplet" aria-hidden="true"></i></span>
                                        <span>
                                            <small>Average consumption</small>
                                            <strong>
                                                @if (($consumptions[$vehicle->id] ?? null) !== null)
                                                    {{ number_format($consumptions[$vehicle->id], 2, '.', ' ') }} L/100 km
                                                @else
                                                    No data yet
                                                @endif
                                            </strong>
                                        </span>
                                    </div>
                                    <div class="vehicle-insight vehicle-insight--{{ $insuranceClass }}">
                                        <span class="vehicle-insight__icon"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></span>
                                        <span>
                                            <small>Insurance</small>
                                            <strong>
                                                @if ($daysLeft === null)
                                                    No date set
                                                @elseif ($daysLeft < 0)
                                                    Expired {{ abs($daysLeft) }} days ago
                                                @elseif ($daysLeft <= 30)
                                                    {{ $daysLeft }} days remaining
                                                @else
                                                    {{ $insuranceDate->format('M j, Y') }}
                                                @endif
                                            </strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <footer class="vehicle-card__footer">
                                <a href="{{ route('vehicles.show', $vehicle) }}" class="btn fleet-btn fleet-btn--primary flex-grow-1">
                                    View details <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                </a>
                                <button type="button" class="btn fleet-icon-btn" data-bs-toggle="modal"
                                    data-bs-target="#editVehicle{{ $vehicle->id }}" aria-label="Edit {{ $vehicle->license_plate }}"
                                    title="Edit vehicle">
                                    <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                </button>
                                <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn fleet-icon-btn fleet-icon-btn--danger"
                                        aria-label="Delete {{ $vehicle->license_plate }}" title="Delete vehicle"
                                        onclick="return confirm('Are you sure you want to delete this vehicle?')">
                                        <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </footer>
                        </article>
                    </div>

                    @include('vehicles.partials.edit-modal')
                @endforeach
            </section>

            <div id="vehicleNoResults" class="fleet-empty d-none" role="status">
                <span class="fleet-empty__icon"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></span>
                <h2>No matching vehicles</h2>
                <p>Try another search term or select a different status.</p>
                <button type="button" class="btn fleet-btn fleet-btn--primary" id="clearVehicleFilters">Clear filters</button>
            </div>
        @else
            <section class="fleet-empty">
                <span class="fleet-empty__icon"><i class="fa-solid fa-car-side" aria-hidden="true"></i></span>
                <h2>Your fleet is ready to grow</h2>
                <p>Add your first vehicle to start tracking mileage, costs and insurance.</p>
                <button type="button" class="btn fleet-btn fleet-btn--primary" data-bs-toggle="modal"
                    data-bs-target="#createVehicleModal">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Add first vehicle
                </button>
            </section>
        @endif
    </main>

    @include('vehicles.partials.create-modal')
@endsection

@push('styles')
    @include('vehicles.partials.page-styles')
@endpush

@push('scripts')
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('createVehicleModal')).show();
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('vehicleSearch');
            const filterButtons = [...document.querySelectorAll('[data-vehicle-filter]')];
            const vehicleItems = [...document.querySelectorAll('.vehicle-grid-item')];
            const noResults = document.getElementById('vehicleNoResults');
            const clearButton = document.getElementById('clearVehicleFilters');
            let activeFilter = 'all';

            if (!searchInput || vehicleItems.length === 0) return;

            const applyFilters = () => {
                const query = searchInput.value.trim().toLocaleLowerCase();
                let visibleCount = 0;

                vehicleItems.forEach((item) => {
                    const matchesSearch = item.dataset.search.includes(query);
                    const matchesState = activeFilter === 'all' || item.dataset.state === activeFilter;
                    const isVisible = matchesSearch && matchesState;
                    item.classList.toggle('d-none', !isVisible);
                    if (isVisible) visibleCount += 1;
                });

                noResults?.classList.toggle('d-none', visibleCount !== 0);
            };

            searchInput.addEventListener('input', applyFilters);
            filterButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    activeFilter = button.dataset.vehicleFilter;
                    filterButtons.forEach((item) => item.classList.toggle('is-active', item === button));
                    applyFilters();
                });
            });
            clearButton?.addEventListener('click', () => {
                searchInput.value = '';
                activeFilter = 'all';
                filterButtons.forEach((item) => item.classList.toggle('is-active', item.dataset.vehicleFilter === 'all'));
                applyFilters();
                searchInput.focus();
            });
        });
    </script>
@endpush
