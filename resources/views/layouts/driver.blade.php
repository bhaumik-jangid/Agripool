<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Driver Panel') — AgriPool</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --driver-blue:  #1d3557;
            --driver-mid:   #457b9d;
            --driver-light: #a8dadc;
            --driver-pale:  #e8f4f8;
            --sidebar-w:    250px;
        }
        body { background:#f0f4f8; font-family:'Segoe UI',system-ui,sans-serif; }

        .sidebar {
            position:fixed; top:0; left:0;
            width:var(--sidebar-w); height:100vh;
            background:#fff;
            border-right:1px solid #e0ecf4;
            display:flex; flex-direction:column;
            z-index:100;
            box-shadow:2px 0 12px rgba(0,0,0,.05);
        }
        .sidebar-brand {
            padding:24px 20px 20px;
            border-bottom:1px solid #e0ecf4;
            font-size:1.3rem; font-weight:800;
            color:var(--driver-blue);
            text-decoration:none; display:block;
        }
        .sidebar-nav { padding:16px 12px; flex:1; overflow-y:auto; }
        .sidebar-label {
            font-size:.7rem; font-weight:700; color:#aaa;
            text-transform:uppercase; letter-spacing:1px;
            padding:12px 10px 6px;
        }
        .nav-item-custom {
            display:flex; align-items:center; gap:10px;
            padding:10px 14px; border-radius:10px;
            color:#555; text-decoration:none; font-size:.9rem;
            font-weight:500; margin-bottom:2px; transition:all .2s;
        }
        .nav-item-custom:hover,
        .nav-item-custom.active {
            background:var(--driver-pale);
            color:var(--driver-blue); font-weight:600;
        }
        .nav-icon { font-size:1.1rem; width:22px; text-align:center; }
        .sidebar-footer {
            padding:16px 12px;
            border-top:1px solid #e0ecf4;
        }
        .main-content {
            margin-left:var(--sidebar-w);
            min-height:100vh; display:flex; flex-direction:column;
        }
        .topbar {
            background:#fff; border-bottom:1px solid #e0ecf4;
            padding:14px 28px;
            display:flex; align-items:center;
            justify-content:space-between;
            position:sticky; top:0; z-index:50;
        }
        .page-content { padding:28px; flex:1; }
        .stat-card {
            background:#fff; border-radius:16px;
            padding:24px; box-shadow:0 2px 12px rgba(0,0,0,.05);
            border:1px solid #f0f0f0; transition:transform .2s;
        }
        .stat-card:hover { transform:translateY(-2px); }
        .stat-num { font-size:2.2rem; font-weight:800; line-height:1; }
        .content-card {
            background:#fff; border-radius:16px;
            padding:24px; box-shadow:0 2px 12px rgba(0,0,0,.05);
            border:1px solid #f0f0f0;
        }

        /* Shipment status timeline */
        .timeline { position:relative; padding-left:32px; }
        .timeline::before {
            content:''; position:absolute; left:11px; top:0; bottom:0;
            width:2px; background:#e0e0e0;
        }
        .timeline-item { position:relative; padding-bottom:24px; }
        .timeline-dot {
            position:absolute; left:-27px; top:2px;
            width:18px; height:18px; border-radius:50%;
            border:3px solid #e0e0e0; background:#fff;
            display:flex; align-items:center; justify-content:center;
        }
        .timeline-dot.active  { border-color:var(--driver-blue); background:var(--driver-blue); }
        .timeline-dot.done    { border-color:#52b788; background:#52b788; }

        /* Status badges */
        .status-badge {
            padding:4px 12px; border-radius:50px;
            font-size:.75rem; font-weight:700;
            text-transform:capitalize; display:inline-block;
        }
        .status-pickup_pending { background:#fff3cd; color:#856404; }
        .status-cargo_loaded   { background:#cff4fc; color:#055160; }
        .status-in_transit     { background:#d1ecf1; color:#0c5460; }
        .status-delivered      { background:#d4edda; color:#155724; }
        .status-failed         { background:#f8d7da; color:#721c24; }
        .status-open           { background:#d4edda; color:#155724; }
        .status-full           { background:#fff3cd; color:#856404; }
        .status-assigned       { background:#cff4fc; color:#055160; }
        .status-completed      { background:#d4edda; color:#155724; }

        @media(max-width:768px) {
            .sidebar { transform:translateX(-100%); transition:transform .3s; }
            .sidebar.open { transform:translateX(0); }
            .main-content { margin-left:0; }
        }
    </style>
</head>
<body>

<aside class="sidebar" id="sidebar">

    <a href="{{ route('driver.dashboard') }}" class="sidebar-brand">
        🚛 AgriPool
        <div style="font-size:.7rem;font-weight:400;color:#888;margin-top:2px;">
            Driver Portal
        </div>
    </a>

    <nav class="sidebar-nav">

        <div class="sidebar-label">Main</div>

        <a href="{{ route('driver.dashboard') }}"
           class="nav-item-custom {{ request()->routeIs('driver.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="sidebar-label">Deliveries</div>

        <a href="{{ route('driver.pools.index') }}"
           class="nav-item-custom {{ request()->routeIs('driver.pools.*') ? 'active' : '' }}">
            <span class="nav-icon">🤝</span> Available Pools
        </a>

        <a href="{{ route('driver.deliveries.index') }}"
           class="nav-item-custom {{ request()->routeIs('driver.deliveries.*') ? 'active' : '' }}">
            <span class="nav-icon">📦</span> My Deliveries
        </a>

        <div class="sidebar-label">Account</div>

        <a href="{{ route('driver.earnings.index') }}"
           class="nav-item-custom {{ request()->routeIs('driver.earnings.*') ? 'active' : '' }}">
            <span class="nav-icon">💰</span> Earnings
        </a>

        <a href="{{ route('driver.vehicle.index') }}"
           class="nav-item-custom {{ request()->routeIs('driver.vehicle.*') ? 'active' : '' }}">
            <span class="nav-icon">🚛</span> My Vehicle
        </a>

        <a href="{{ route('driver.profile.index') }}"
           class="nav-item-custom {{ request()->routeIs('driver.profile.*') ? 'active' : '' }}">
            <span class="nav-icon">👤</span> My Profile
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div style="width:36px;height:36px;border-radius:50%;
                background:var(--driver-blue);color:#fff;
                display:flex;align-items:center;justify-content:center;
                font-weight:700;font-size:.9rem;">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div style="overflow:hidden;">
                <div style="font-size:.85rem;font-weight:600;
                    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ Auth::user()->name }}
                </div>
                <div style="font-size:.7rem;color:#888;">Driver Account</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit"
                    class="btn btn-sm btn-outline-danger w-100"
                    style="border-radius:8px;font-size:.8rem;">
                🚪 Logout
            </button>
        </form>
    </div>

</aside>

<div class="main-content">

    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-md-none"
                    onclick="document.getElementById('sidebar').classList.toggle('open')">
                ☰
            </button>
            <div>
                <h6 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h6>
                <small class="text-muted">@yield('page-subtitle', 'Driver Portal')</small>
            </div>
        </div>
        <span class="badge rounded-pill"
              style="background:var(--driver-pale);color:var(--driver-blue);">
            🚛 Driver
        </span>
    </div>

    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="page-content">
        @yield('content')
    </div>

</div>
    @stack('scripts')
</body>
</html>