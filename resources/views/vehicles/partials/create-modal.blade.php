<div class="modal fade fleet-modal" id="createVehicleModal" tabindex="-1" aria-labelledby="createVehicleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form action="{{ route('vehicles.store') }}" method="POST">

                @csrf
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="createVehicleModalLabel">
                        <span class="fleet-modal-icon"><i class="fa-solid fa-car-side" aria-hidden="true"></i></span>
                        Add new vehicle
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">Enter the vehicle's core details. Required fields are marked with an asterisk.</p>
                    @include('vehicles.partials.form', ['formIdPrefix' => 'create'])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn fleet-btn fleet-btn--soft" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn fleet-btn fleet-btn--primary">
                        <i class="fa-solid fa-check" aria-hidden="true"></i>
                        Save vehicle
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
