@php($formIdPrefix = $formIdPrefix ?? 'vehicle')

<div class="row g-3">

    {{-- Left Column --}}
    <div class="col-md-6">

        <div class="mb-3">
            <label for="{{ $formIdPrefix }}-brand_id" class="form-label">
                Brand <span class="text-danger">*</span>
            </label>

            <select name="brand_id" id="{{ $formIdPrefix }}-brand_id"
                class="form-select @error('brand_id') is-invalid @enderror" required>

                <option value="">Select brand...</option>

                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}"
                        {{ old('brand_id', $vehicle->brand_id ?? '') == $brand->id ? 'selected' : '' }}>

                        {{ $brand->name }}

                    </option>
                @endforeach

            </select>

            @error('brand_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>
        <div class="mb-3">
            <label for="{{ $formIdPrefix }}-license_plate" class="form-label">
                License Plate <span class="text-danger">*</span>
            </label>

            <input type="text" id="{{ $formIdPrefix }}-license_plate" name="license_plate"
                class="form-control @error('license_plate') is-invalid @enderror"
                value="{{ old('license_plate', $vehicle->license_plate ?? '') }}" required>

            @error('license_plate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">

            <label for="{{ $formIdPrefix }}-fuel_type_id" class="form-label">
                Fuel Type <span class="text-danger">*</span>
            </label>

            <select name="fuel_type_id" id="{{ $formIdPrefix }}-fuel_type_id"
                class="form-select @error('fuel_type_id') is-invalid @enderror" required>

                <option value="">Select fuel type...</option>

                @foreach ($fuelTypes as $fuel)
                    <option value="{{ $fuel->id }}"
                        {{ old('fuel_type_id', $vehicle->fuel_type_id ?? '') == $fuel->id ? 'selected' : '' }}>

                        {{ $fuel->name }}

                    </option>
                @endforeach
            </select>

            @error('fuel_type_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>

        <div class="mb-3">

            <label for="{{ $formIdPrefix }}-year" class="form-label">
                Year
            </label>

            <input type="number" id="{{ $formIdPrefix }}-year" name="year" class="form-control" min="1910"
                max="{{ now()->year }}" value="{{ old('year', $vehicle->year ?? '') }}">

        </div>

        <div class="mb-3">
            <label for="{{ $formIdPrefix }}-engine_type" class="form-label">
                Engine
            </label>

            <input type="text" id="{{ $formIdPrefix }}-engine_type" name="engine_type" class="form-control"
                value="{{ old('engine_type', $vehicle->engine_type ?? '') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">

            <label for="{{ $formIdPrefix }}-km" class="form-label">
                Mileage
            </label>

            <input type="number" id="{{ $formIdPrefix }}-km" name="km" class="form-control" min="0"
                value="{{ old('km', $vehicle->km ?? '') }}">

        </div>

        <div class="mb-3">

            <label for="{{ $formIdPrefix }}-tank_capacity" class="form-label">
                Tank Capacity (L)
            </label>

            <input type="number" id="{{ $formIdPrefix }}-tank_capacity" name="tank_capacity" class="form-control" min="0"
                value="{{ old('tank_capacity', $vehicle->tank_capacity ?? '') }}">

        </div>

        <div class="mb-3">

            <label for="{{ $formIdPrefix }}-avarage_consumption" class="form-label">
                Average Consumption (L/100km)
            </label>

            <input type="number" step="0.1" min="0" id="{{ $formIdPrefix }}-avarage_consumption" name="avarage_consumption"
                class="form-control" value="{{ old('avarage_consumption', $vehicle->avarage_consumption ?? '') }}">

        </div>

        <div class="mb-3">

            <label for="{{ $formIdPrefix }}-insurance_expiration" class="form-label">
                Insurance Expiration
            </label>

            <input type="date" id="{{ $formIdPrefix }}-insurance_expiration" name="insurance_expiration" class="form-control"
                value="{{ old('insurance_expiration', $vehicle->insurance_expiration ?? '') }}">

        </div>

        <div class="mb-3">

            <label for="{{ $formIdPrefix }}-state" class="form-label">
                Status
            </label>

            <select name="state" id="{{ $formIdPrefix }}-state" class="form-select">
                <option value="active" {{ old('state', $vehicle->state ?? '') == 'active' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="service" {{ old('state', $vehicle->state ?? '') == 'service' ? 'selected' : '' }}>
                    Service
                </option>

                <option value="inactive" {{ old('state', $vehicle->state ?? '') == 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>

        </div>

    </div>

</div>
