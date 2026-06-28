<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Management</title>

    {{-- AdminLTE --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/css/adminlte.min.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        {{-- Sidebar --}}
        <nav class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand d-flex flex-column align-items-start">
                <div class="brand-text fw-light">
                    🚗 Fleet Management
                </div>

                <small class="text-secondary">
                    Welcome, {{ $data['username'] }}!
                </small>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav sidebar-menu flex-column">

                    <li class="nav-item">
                        <a href="/" class="nav-link active">
                            <i class="nav-icon fas fa-gauge"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/vehicles" class="nav-link">
                            <i class="nav-icon fas fa-car"></i>
                            <p>Vehicles</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/drivers" class="nav-link">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>Drivers</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/fuel" class="nav-link">
                            <i class="nav-icon fas fa-gas-pump"></i>
                            <p>Fueling</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/services" class="nav-link">
                            <i class="nav-icon fas fa-wrench"></i>
                            <p>Service</p>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>

        {{-- Main --}}
        <main class="app-main">

            {{-- Topbar --}}
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@yield('title', 'Dashboard')</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

        </main>

    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/js/adminlte.min.js"></script>

</body>

</html>
