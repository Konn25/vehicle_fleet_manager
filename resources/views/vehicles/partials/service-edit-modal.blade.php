<div class="modal fade" id="editService{{ $service->id }}" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{ route('vehicles.services.update', $service) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="modal-header bg-warning">

                    <h5 class="modal-title">
                        <i class="fas fa-edit"></i>
                        Edit Service
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Service Date
                        </label>

                        <input type="date" name="service_date" class="form-control"
                            value="{{ $service->service_date->format('Y-m-d') }}" required>

                    </div>

                    <div class="row">

                        <div class="col-md-8">

                            <div class="mb-3">

                                <label class="form-label">
                                    Cost
                                </label>

                                <input type="number" name="cost" class="form-control" step="0.01" min="0"
                                    value="{{ $service->cost }}" required>

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="mb-3">

                                <label class="form-label">
                                    Currency
                                </label>

                                <select name="currency" class="form-select" required>

                                    @foreach (['HUF', 'EUR', 'USD', 'GBP', 'CHF'] as $currency)
                                        <option value="{{ $currency }}"
                                            {{ $service->currency === $currency ? 'selected' : '' }}>
                                            {{ $currency }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea name="description" class="form-control" rows="4">{{ $service->description }}</textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-warning">

                        <i class="fas fa-save"></i>
                        Save Changes

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
