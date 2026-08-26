<div class="modal fade" id="editFueling{{ $fueling->id }}" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{ route('fuelings.update', $fueling) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="modal-header bg-warning">

                    <h5 class="modal-title">
                        <i class="fas fa-gas-pump"></i>
                        Edit Fueling
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Fueling Date
                        </label>

                        <input type="date" name="fueling_date" class="form-control"
                            value="{{ $fueling->fueling_date->format('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Odometer
                        </label>

                        <input type="number" name="odometer" class="form-control" value="{{ $fueling->odometer }}"
                            required>
                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="mb-3">

                                <label class="form-label">
                                    Liters
                                </label>

                                <input type="number" name="liters" class="form-control" step="0.01" min="0.01"
                                    value="{{ $fueling->liters }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="mb-3">

                                <label class="form-label">
                                    Price / Liter
                                </label>

                                <input type="number" name="price_per_liter" class="form-control" step="0.01"
                                    min="0" value="{{ $fueling->price_per_liter }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Currency
                        </label>

                        <select name="currency" class="form-select" required>

                            <option value="HUF" @selected($fueling->currency === 'HUF')>HUF</option>
                            <option value="EUR" @selected($fueling->currency === 'EUR')>EUR</option>
                            <option value="USD" @selected($fueling->currency === 'USD')>USD</option>
                            <option value="GBP" @selected($fueling->currency === 'GBP')>GBP</option>
                            <option value="CHF" @selected($fueling->currency === 'CHF')>CHF</option>

                        </select>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Note
                        </label>

                        <textarea name="note" class="form-control" rows="3">{{ $fueling->note }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit" class="btn btn-warning">

                        <i class="fas fa-save"></i>
                        Update Fueling
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
