<div class="modal fade fleet-modal" id="editVehicle{{ $vehicle->id }}" tabindex="-1"
    aria-labelledby="editVehicleLabel{{ $vehicle->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="editVehicleLabel{{ $vehicle->id }}">
                        <span class="fleet-modal-icon"><i class="fa-solid fa-pen" aria-hidden="true"></i></span>
                        <span>Edit vehicle <small class="d-block text-muted fw-normal mt-1">{{ $vehicle->license_plate }}</small></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @include('vehicles.partials.form', [
                        'vehicle' => $vehicle,
                        'formIdPrefix' => 'edit-' . $vehicle->id,
                    ])
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn fleet-btn fleet-btn--soft" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn fleet-btn fleet-btn--primary">
                        <i class="fa-solid fa-check" aria-hidden="true"></i>
                        Save changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
