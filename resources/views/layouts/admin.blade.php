<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — AgriPool</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --admin-dark:  #1b1b2f;
            --admin-mid:   #2d2d44;
            --admin-accent:#f4a261;
            --admin-pale:  #fff8f0;
            --sidebar-w:   260px;
        }
        body { background:#f4f6f9; font-family:'Segoe UI',system-ui,sans-serif; }

        /* ── Sidebar ── */
        .sidebar {
            position:fixed; top:0; left:0;
            width:var(--sidebar-w); height:100vh;
            background:var(--admin-dark);
            display:flex; flex-direction:column;
            z-index:100;
        }
        .sidebar-brand {
            padding:24px 20px;
            font-size:1.2rem; font-weight:800;
            color:#fff; text-decoration:none; display:block;
            border-bottom:1px solid rgba(255,255,255,.08);
        }
        .sidebar-nav { padding:16px 12px; flex:1; overflow-y:auto; }
        .sidebar-label {
            font-size:.68rem; font-weight:700;
            color:rgba(255,255,255,.3);
            text-transform:uppercase; letter-spacing:1.2px;
            padding:14px 10px 6px;
        }
        .nav-item-custom {
            display:flex; align-items:center; gap:10px;
            padding:10px 14px; border-radius:10px;
            color:rgba(255,255,255,.65);
            text-decoration:none; font-size:.88rem;
            font-weight:500; margin-bottom:2px; transition:all .2s;
        }
        .nav-item-custom:hover,
        .nav-item-custom.active {
            background:rgba(244,162,97,.15);
            color:#f4a261;
        }
        .nav-icon { font-size:1rem; width:20px; text-align:center; }
        .badge-nav {
            margin-left:auto; background:#e63946;
            color:#fff; border-radius:50px;
            padding:1px 7px; font-size:.68rem; font-weight:700;
        }
        .sidebar-footer {
            padding:16px; border-top:1px solid rgba(255,255,255,.08);
        }

        /* ── Main ── */
        .main-content {
            margin-left:var(--sidebar-w);
            min-height:100vh; display:flex; flex-direction:column;
        }
        .topbar {
            background:#fff; border-bottom:1px solid #eee;
            padding:14px 28px;
            display:flex; align-items:center;
            justify-content:space-between;
            position:sticky; top:0; z-index:50;
            box-shadow:0 1px 8px rgba(0,0,0,.05);
        }
        .page-content { padding:28px; flex:1; }

        /* ── Cards ── */
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
            border:1px solid #f0f0f0; margin-bottom:24px;
        }

        /* ── Status badges ── */
        .status-badge {
            padding:4px 12px; border-radius:50px;
            font-size:.75rem; font-weight:700;
            text-transform:capitalize; display:inline-block;
        }
        .status-pending      { background:#fff3cd; color:#856404; }
        .status-pooled       { background:#cff4fc; color:#055160; }
        .status-assigned     { background:#d1ecf1; color:#0c5460; }
        .status-in_transit   { background:#d4edda; color:#155724; }
        .status-delivered    { background:#d4edda; color:#155724; }
        .status-cancelled    { background:#f8d7da; color:#721c24; }
        .status-open         { background:#d4edda; color:#155724; }
        .status-full         { background:#fff3cd; color:#856404; }
        .status-completed    { background:#d4edda; color:#155724; }
        .status-approved     { background:#d4edda; color:#155724; }
        .status-rejected     { background:#f8d7da; color:#721c24; }
        .status-pickup_pending { background:#fff3cd; color:#856404; }
        .status-cargo_loaded { background:#cff4fc; color:#055160; }

        @media(max-width:768px) {
            .sidebar { transform:translateX(-100%); transition:transform .3s; }
            .sidebar.open { transform:translateX(0); }
            .main-content { margin-left:0; }
        }
    </style>
</head>
<body>

<aside class="sidebar" id="sidebar">

    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        ⚙️ AgriPool Admin
        <div style="font-size:.68rem;font-weight:400;
                    color:rgba(255,255,255,.4);margin-top:2px;">
            Management Panel
        </div>
    </a>

    <nav class="sidebar-nav">

        <div class="sidebar-label">Overview</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-item-custom
               {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="sidebar-label">Users</div>

        <a href="{{ route('admin.farmers.index') }}"
           class="nav-item-custom
               {{ request()->routeIs('admin.farmers.*') ? 'active' : '' }}">
            <span class="nav-icon">🌾</span> Farmers
        </a>

        <a href="{{ route('admin.drivers.index') }}"
           class="nav-item-custom
               {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
            <span class="nav-icon">🚛</span> Drivers
            @php
                $pendingCount = \App\Models\DriverProfile
                    ::where('approval_status','pending')->count();
            @endphp
            @if($pendingCount > 0)
                <span class="badge-nav">{{ $pendingCount }}</span>
            @endif
        </a>

        <div class="sidebar-label">Operations</div>

        <a href="{{ route('admin.requests.index') }}"
           class="nav-item-custom
               {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
            <span class="nav-icon">📋</span> Transport Requests
        </a>

        <a href="{{ route('admin.pools.index') }}"
           class="nav-item-custom
               {{ request()->routeIs('admin.pools.*') ? 'active' : '' }}">
            <span class="nav-icon">🤝</span> Pools
        </a>

        <a href="{{ route('admin.shipments.index') }}"
           class="nav-item-custom
               {{ request()->routeIs('admin.shipments.*') ? 'active' : '' }}">
            <span class="nav-icon">📦</span> Shipments
        </a>

        <div class="sidebar-label">Support</div>

        <a href="{{ route('admin.feedback.index') }}"
           class="nav-item-custom
               {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
            <span class="nav-icon">💬</span> Feedback
            @php
                $openFeedback = \App\Models\Feedback
                    ::where('status','open')->count();
            @endphp
            @if($openFeedback > 0)
                <span class="badge-nav">{{ $openFeedback }}</span>
            @endif
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2 mb-3">
            <div style="width:34px;height:34px;border-radius:50%;
                background:#f4a261;color:#fff;
                display:flex;align-items:center;
                justify-content:center;font-weight:700;font-size:.85rem;">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div>
                <div style="font-size:.82rem;font-weight:600;color:#fff;">
                    {{ Auth::user()->name }}
                </div>
                <div style="font-size:.68rem;color:rgba(255,255,255,.4);">
                    Administrator
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="btn btn-sm w-100"
                    style="background:rgba(255,255,255,.08);
                           color:rgba(255,255,255,.7);
                           border:1px solid rgba(255,255,255,.1);
                           border-radius:8px;font-size:.8rem;">
                🚪 Logout
            </button>
        </form>
    </div>

</aside>

<div class="main-content">

    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-md-none"
                    onclick="document.getElementById('sidebar')
                             .classList.toggle('open')">☰</button>
            <div>
                <h6 class="mb-0 fw-bold">
                    @yield('page-title', 'Dashboard')
                </h6>
                <small class="text-muted">
                    @yield('page-subtitle', 'Admin Panel')
                </small>
            </div>
        </div>
        <span class="badge"
              style="background:#fff8f0;color:#f4a261;
                     border:1px solid #f4a261;font-size:.8rem;
                     padding:5px 12px;">
            ⚙️ Admin
        </span>
    </div>

    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible
                        fade show rounded-3">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible
                        fade show rounded-3">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert"></button>
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