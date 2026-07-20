<!DOCTYPE html>
<html>

<head>
    <title>Vehicles</title>
</head>

<body>

    <h1>Vehicle List</h1>

    @foreach ($vehicles as $vehicle)
        <h2>{{ $vehicle->brand->name ?? 'No brand' }}</h2>

        <ul>
            <li>ID: {{ $vehicle->id }}</li>
            <li>Year: {{ $vehicle->year }}</li>
            <li>Fuel Type: {{ $vehicle->fuelType->name ?? 'Not specified' }}</li>
            <li>Engine: {{ $vehicle->engine_type }}</li>
            <li>Tank Capacity: {{ $vehicle->tank_capacity }} liters</li>
            <li>Mileage: {{ $vehicle->km }} km</li>
            <li>License Plate: {{ $vehicle->license_plate }}</li>
            <li>Status: {{ $vehicle->state }}</li>
            <li>Insurance Expiration: {{ $vehicle->insurance_expiration }}</li>
            <li>Average Consumption: {{ $vehicle->avarage_consumption }} l/100km</li>
        </ul>

        <hr>
    @endforeach

</body>

</html>
