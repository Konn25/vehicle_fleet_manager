@php
    $lastFueling = $vehicle->fuelings->sortByDesc('odometer')->first();
    $lastOdometer = $lastFueling?->odometer ?? $vehicle->km;
    $lastPricePerLiter = $lastFueling?->price_per_liter;
    $defaultFuelingCurrency = old('currency', $lastFueling?->currency ?? 'HUF');
@endphp

<div class="modal fade fleet-modal" id="addFuelingModal" tabindex="-1" aria-labelledby="addFuelingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('vehicles.fuelings.store', $vehicle) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="addFuelingModalLabel">
                        <span class="fleet-modal-icon"><i class="fa-solid fa-gas-pump" aria-hidden="true"></i></span>
                        Add fueling
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fueling_date" class="form-label">Fueling date</label>
                        <input type="date" name="fueling_date" id="fueling_date" class="form-control"
                            value="{{ old('fueling_date') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="odometer" class="form-label">Odometer</label>
                        <input type="number" name="odometer" id="odometer" class="form-control"
                            min="{{ $lastOdometer }}" value="{{ old('odometer', $lastOdometer) }}" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="liters" class="form-label">Liters</label>
                            <input type="number" name="liters" id="liters" class="form-control" step="0.01"
                                min="0.01" value="{{ old('liters') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="price_per_liter" class="form-label">Price / liter</label>
                            <input type="number" name="price_per_liter" id="price_per_liter" class="form-control"
                                step="0.01" min="0" value="{{ old('price_per_liter', $lastPricePerLiter) }}" required>
                        </div>
                    </div>
                    @if ($lastPricePerLiter !== null)
                        <p class="form-text mt-2">Last price: {{ number_format($lastPricePerLiter, 2, '.', ' ') }} {{ $lastFueling->currency }}/L</p>
                    @endif
                    <div class="mt-3">
                        <label for="fueling_currency" class="form-label">Currency</label>
                        <select name="currency" id="fueling_currency" class="form-select" required>
                            @foreach (['HUF', 'EUR', 'USD', 'GBP', 'CHF'] as $currency)
                                <option value="{{ $currency }}" @selected($defaultFuelingCurrency === $currency)>{{ $currency }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="fueling_note" class="form-label">Note</label>
                        <textarea name="note" id="fueling_note" class="form-control" rows="3" placeholder="Optional note">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn fleet-btn fleet-btn--soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn fleet-btn fleet-btn--primary">
                        <i class="fa-solid fa-check" aria-hidden="true"></i> Save fueling
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
