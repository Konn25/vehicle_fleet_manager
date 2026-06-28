<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Fleet System</title>

    {{-- AdminLTE --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/css/adminlte.min.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(120deg, #1e293b, #0f172a);
        }
    </style>
</head>

<body class="login-page">

    <div class="login-box">

        <div class="login-logo text-white">
            🚗 <b>Fleet</b> System
        </div>

        <div class="card shadow-lg">
            <div class="card-body login-card-body">

                <p class="login-box-msg">Jelentkezz be a rendszerbe</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>

                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Jelszó" required>

                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input">
                                <label class="form-check-label">Emlékezz rám</label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block w-100">
                                Bejelentkezés
                            </button>
                        </div>
                    </div>

                </form>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        Hibás email vagy jelszó
                    </div>
                @endif

            </div>
        </div>
    </div>

</body>

</html>
