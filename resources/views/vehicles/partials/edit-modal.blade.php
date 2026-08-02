<div class="modal fade" id="editVehicle{{ $vehicle->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-edit"></i>
                        Edit Vehicle
                        <small class="text-muted">
                            {{ $vehicle->license_plate }}
                        </small>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">
                    @include('vehicles.partials.form', [
                        'vehicle' => $vehicle,
                    ])
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
