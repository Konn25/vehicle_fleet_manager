<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fleet Manager')</title>

    <script>
        (() => {
            try {
                const savedTheme = localStorage.getItem('fleet-theme');
                const preferredTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                document.documentElement.dataset.bsTheme = savedTheme || preferredTheme;
            } catch (error) {
                document.documentElement.dataset.bsTheme = 'light';
            }
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .app-navbar {
            padding-block: .8rem;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: #111a2e !important;
            box-shadow: 0 6px 20px rgba(16, 24, 40, .1);
        }

        .app-navbar .navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: .7rem;
            font-weight: 750;
            letter-spacing: -.02em;
        }

        .app-navbar__logo {
            display: grid;
            width: 2.2rem;
            height: 2.2rem;
            place-items: center;
            border-radius: 10px;
            background: linear-gradient(135deg, #5f7df2, #3157d5);
            font-size: .85rem;
            box-shadow: 0 6px 14px rgba(49, 87, 213, .28);
        }

        .app-navbar .nav-link {
            border-radius: 9px;
            color: rgba(255, 255, 255, .68);
            font-size: .9rem;
            font-weight: 650;
        }

        .app-navbar .nav-link:hover,
        .app-navbar .nav-link.active {
            background: rgba(255, 255, 255, .08);
            color: #fff;
        }

        .app-navbar .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, .18);
            box-shadow: none;
        }

        .theme-toggle {
            display: inline-flex;
            min-height: 2.35rem;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .45rem .75rem;
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 10px;
            background: rgba(255, 255, 255, .06);
            color: rgba(255, 255, 255, .78);
            font-size: .82rem;
            font-weight: 650;
            transition: background .18s ease, color .18s ease, border-color .18s ease;
        }

        .theme-toggle:hover {
            border-color: rgba(255, 255, 255, .24);
            background: rgba(255, 255, 255, .12);
            color: #fff;
        }

        .theme-toggle__sun,
        [data-bs-theme="dark"] .theme-toggle__moon { display: none; }
        [data-bs-theme="dark"] .theme-toggle__sun { display: inline-block; }

        @media (max-width: 991.98px) {
            .app-navbar .navbar-nav { padding-top: .75rem; }
            .app-navbar .nav-link { padding: .65rem .75rem; }
            .theme-toggle { width: 100%; margin-top: .5rem; }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark app-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('vehicles.index') }}">
                <span class="app-navbar__logo"><i class="fa-solid fa-car-side" aria-hidden="true"></i></span>
                <span>Fleet Manager</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#appNavigation"
                aria-controls="appNavigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="appNavigation">
                <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}"
                        href="{{ route('vehicles.index') }}">
                        <i class="fa-solid fa-car me-1" aria-hidden="true"></i>
                        Vehicles
                    </a>

                    <button type="button" class="theme-toggle" id="themeToggle" aria-pressed="false">
                        <i class="fa-solid fa-moon theme-toggle__moon" aria-hidden="true"></i>
                        <i class="fa-solid fa-sun theme-toggle__sun" aria-hidden="true"></i>
                        <span id="themeToggleLabel">Dark mode</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const toggle = document.getElementById('themeToggle');
            const label = document.getElementById('themeToggleLabel');

            if (!toggle || !label) return;

            const updateToggle = () => {
                const isDark = document.documentElement.dataset.bsTheme === 'dark';
                toggle.setAttribute('aria-pressed', String(isDark));
                toggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
                label.textContent = isDark ? 'Light mode' : 'Dark mode';
            };

            toggle.addEventListener('click', () => {
                const nextTheme = document.documentElement.dataset.bsTheme === 'dark' ? 'light' : 'dark';
                document.documentElement.dataset.bsTheme = nextTheme;

                try {
                    localStorage.setItem('fleet-theme', nextTheme);
                } catch (error) {
                    // The selected theme still applies for the current page.
                }

                updateToggle();
                window.dispatchEvent(new CustomEvent('fleet:theme-changed', { detail: { theme: nextTheme } }));
            });

            updateToggle();
        })();
    </script>
    @stack('scripts')
</body>

</html>
