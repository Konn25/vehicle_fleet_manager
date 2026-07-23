<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fleet Manager')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand" href="/">
                🚗 Fleet Manager
            </a>

            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('vehicles.index') }}">
                    Vehicles
                </a>
            </div>

        </div>
    </nav>

    <div class="container py-4">

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

<style>
    .vehicle-card {
        transition: transform .2s ease;
    }

    .vehicle-card:hover {
        transform: translateY(-5px);
    }
</style>

</html>
