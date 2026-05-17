<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Driver Panel') — AgriPool</title>
    @vite(['resources/css/app.css', 'resources/css/premium.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        :root {
            --driver-dark: #1d3557;
            --driver-mid: #2d5282;
            --driver-light: #457b9d;
            --driver-pale: #eff6ff;
            --sidebar-w: 256px;
        }

        body {
            background: #f8fafc;
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: #0f172a;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, .06);
            text-decoration: none;
            display: block;
        }

        .sidebar-brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1d3557, #457b9d);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-brand-text {
            font-size: 1.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.3px;
        }

        .sidebar-brand-sub {
            font-size: .68rem;
            color: rgba(255, 255, 255, .35);
            font-weight: 500;
            margin-top: 1px;
        }

        .sidebar-nav {
            padding: 12px;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-section-label {
            font-size: .65rem;
            font-weight: 700;
            color: rgba(255, 255, 255, .25);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 12px 10px 5px;
        }

        .badge-notif {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            border-radius: 20px;
            padding: 1px 7px;
            font-size: .65rem;
            font-weight: 700;
        }

        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255, 255, 255, .06);
        }

        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>

    <aside class="sidebar" id="sidebar">

        <a href="{{ route('driver.dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <div class="sidebar-brand-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13" rx="2" />
                        <path d="M16 8h4l3 5v3h-7V8z" />
                        <circle cx="5.5" cy="18.5" r="2.5" />
                        <circle cx="18.5" cy="18.5" r="2.5" />
                    </svg>
                </div>
                <div>
                    <div class="sidebar-brand-text">AgriPool</div>
                    <div class="sidebar-brand-sub">Driver Portal</div>
                </div>
            </div>
        </a>

        <nav class="sidebar-nav nav-dark">

            <div class="sidebar-section-label">Overview</div>

            <a href="{{ route('driver.dashboard') }}"
                class="nav-item-custom {{ request()->routeIs('driver.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="layout-dashboard" width="16" height="16"></i>
                </span>
                Dashboard
            </a>

            <div class="sidebar-section-label">Deliveries</div>

            <a href="{{ route('driver.pools.index') }}"
                class="nav-item-custom {{ request()->routeIs('driver.pools.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="map-pin" width="16" height="16"></i>
                </span>
                Available Pools
            </a>

            <a href="{{ route('driver.deliveries.index') }}"
                class="nav-item-custom {{ request()->routeIs('driver.deliveries.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="package" width="16" height="16"></i>
                </span>
                My Deliveries
            </a>

            <div class="sidebar-section-label">Account</div>

            <a href="{{ route('driver.earnings.index') }}"
                class="nav-item-custom {{ request()->routeIs('driver.earnings.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="indian-rupee" width="16" height="16"></i>
                </span>
                Earnings
            </a>

            <a href="{{ route('driver.vehicle.index') }}"
                class="nav-item-custom {{ request()->routeIs('driver.vehicle.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="truck" width="16" height="16"></i>
                </span>
                My Vehicle
            </a>

            <a href="{{ route('driver.profile.index') }}"
                class="nav-item-custom {{ request()->routeIs('driver.profile.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="user-circle" width="16" height="16"></i>
                </span>
                My Profile
            </a>

        </nav>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="user-avatar" style="background:#1d3557;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div style="overflow:hidden;flex:1;">
                    <div style="font-size:.82rem;font-weight:600;
                    color:#fff;white-space:nowrap;
                    overflow:hidden;text-overflow:ellipsis;">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:.68rem;color:rgba(255,255,255,.35);">
                        Driver Account
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn w-100 d-flex align-items-center
                           justify-content-center gap-2" style="background:rgba(255,255,255,.06);
                           color:rgba(255,255,255,.5);
                           border:1px solid rgba(255,255,255,.08);
                           border-radius:10px;font-size:.8rem;
                           font-weight:500;padding:8px;
                           transition:all 160ms ease;" onmouseover="this.style.background='rgba(239,68,68,.15)';
                                 this.style.color='#ef4444';
                                 this.style.borderColor='rgba(239,68,68,.3)'" onmouseout="this.style.background='rgba(255,255,255,.06)';
                                this.style.color='rgba(255,255,255,.5)';
                                this.style.borderColor='rgba(255,255,255,.08)'">
                    <i data-lucide="log-out" width="14" height="14"></i>
                    Sign Out
                </button>
            </form>
        </div>

    </aside>

    <div class="main-content">

        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm d-md-none" style="background:transparent;border:1px solid #e2e8f0;
                           border-radius:8px;padding:6px 8px;" onclick="document.getElementById('sidebar')
                             .classList.toggle('open')">
                    <i data-lucide="menu" width="16" height="16"></i>
                </button>
                <div>
                    <h6 class="mb-0 fw-bold" style="color:#1a1a2e;font-size:.95rem;">
                        @yield('page-title', 'Dashboard')
                    </h6>
                    <p class="mb-0" style="font-size:.72rem;color:#94a3b8;">
                        @yield('page-subtitle', 'Driver Portal')
                    </p>
                </div>
            </div>
            <span style="font-size:.72rem;font-weight:600;color:#1d3557;
            background:#eff6ff;padding:4px 10px;border-radius:20px;
            border:1px solid rgba(29,53,87,.15);">
                Driver
            </span>
        </div>

        <div class="px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success-premium alert-premium
                            flash-message alert-dismissible d-flex
                            align-items-center gap-2 mb-3">
                    <i data-lucide="check-circle" width="16" height="16"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                        style="font-size:.7rem;"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger-premium alert-premium
                            flash-message alert-dismissible d-flex
                            align-items-center gap-2 mb-3">
                    <i data-lucide="alert-circle" width="16" height="16"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                        style="font-size:.7rem;"></button>
                </div>
            @endif
            {{-- Global validation errors summary --}}
            @if($errors->any())
                <div class="alert alert-danger-premium alert-premium flash-message
                    alert-dismissible mb-3">
                    <div class="d-flex align-items-start gap-2">
                        <i data-lucide="alert-circle" width="16" height="16" style="flex-shrink:0;margin-top:1px;"></i>
                        <div>
                            <div class="fw-semibold small mb-1">
                                Please fix the following errors:
                            </div>
                            <ul class="mb-0 ps-3" style="font-size:.82rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                        style="font-size:.7rem;"></button>
                </div>
            @endif
        </div>

        <div class="page-content">
            @yield('content')
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>

</html>