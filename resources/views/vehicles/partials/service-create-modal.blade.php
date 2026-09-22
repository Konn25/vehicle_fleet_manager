<div class="modal fade fleet-modal" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('vehicles.services.store', $vehicle) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="addServiceModalLabel">
                        <span class="fleet-modal-icon"><i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i></span>
                        Add service
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="service_date" class="form-label">Service date</label>
                        <input type="date" name="service_date" id="service_date" class="form-control"
                            value="{{ old('service_date') }}" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-8">
                            <label for="service_cost" class="form-label">Cost</label>
                            <input type="number" name="cost" id="service_cost" class="form-control" step="0.01"
                                min="0" value="{{ old('cost') }}" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="service_currency" class="form-label">Currency</label>
                            <select name="currency" id="service_currency" class="form-select" required>
                                @foreach (['HUF', 'EUR', 'USD', 'GBP', 'CHF'] as $currency)
                                    <option value="{{ $currency }}" @selected(old('currency', 'HUF') === $currency)>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="service_description" class="form-label">Description</label>
                        <textarea name="description" id="service_description" class="form-control" rows="4"
                            placeholder="What was done during the service?">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn fleet-btn fleet-btn--soft" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn fleet-btn fleet-btn--primary">
                        <i class="fa-solid fa-check" aria-hidden="true"></i> Save service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
