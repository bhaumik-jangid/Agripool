<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Farmer Panel') — AgriPool</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --green-dark:  #2d6a4f;
            --green-mid:   #40916c;
            --green-light: #52b788;
            --green-pale:  #d8f3dc;
            --sidebar-w:   250px;
        }
        body { background: #f0f4f1; font-family: 'Segoe UI', system-ui, sans-serif; }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: #fff;
            border-right: 1px solid #e8f5e9;
            display: flex; flex-direction: column;
            z-index: 100;
            box-shadow: 2px 0 12px rgba(0,0,0,.05);
        }
        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid #e8f5e9;
            font-size: 1.3rem; font-weight: 800;
            color: var(--green-dark);
            text-decoration: none;
            display: block;
        }
        .sidebar-nav { padding: 16px 12px; flex: 1; overflow-y: auto; }
        .sidebar-label {
            font-size: .7rem; font-weight: 700; color: #aaa;
            text-transform: uppercase; letter-spacing: 1px;
            padding: 12px 10px 6px;
        }
        .nav-item-custom {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px; border-radius: 10px;
            color: #555; text-decoration: none; font-size: .9rem;
            font-weight: 500; margin-bottom: 2px;
            transition: all .2s;
        }
        .nav-item-custom:hover,
        .nav-item-custom.active {
            background: var(--green-pale);
            color: var(--green-dark);
            font-weight: 600;
        }
        .nav-item-custom .nav-icon { font-size: 1.1rem; width: 22px; text-align: center; }
        .badge-notif {
            margin-left: auto;
            background: #e63946; color: #fff;
            border-radius: 50px; padding: 1px 7px;
            font-size: .7rem; font-weight: 700;
        }
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid #e8f5e9;
        }

        /* ── Main content ── */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e8f5e9;
            padding: 14px 28px;
            display: flex; align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .page-content { padding: 28px; flex: 1; }

        /* ── Cards ── */
        .stat-card {
            background: #fff; border-radius: 16px;
            padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,.05);
            border: 1px solid #f0f0f0;
            transition: transform .2s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card .stat-num {
            font-size: 2.2rem; font-weight: 800; line-height: 1;
        }
        .content-card {
            background: #fff; border-radius: 16px;
            padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,.05);
            border: 1px solid #f0f0f0;
        }

        /* ── Status badges ── */
        .status-pending   { background:#fff3cd; color:#856404; }
        .status-pooled    { background:#cff4fc; color:#055160; }
        .status-assigned  { background:#d1ecf1; color:#0c5460; }
        .status-in_transit{ background:#d4edda; color:#155724; }
        .status-delivered { background:#d4edda; color:#155724; }
        .status-cancelled { background:#f8d7da; color:#721c24; }
        .status-badge {
            padding: 4px 12px; border-radius: 50px;
            font-size: .75rem; font-weight: 700;
            text-transform: capitalize;
            display: inline-block;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform .3s; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

{{-- ── SIDEBAR ─────────────────────────────────── --}}
<aside class="sidebar" id="sidebar">

    <a href="{{ route('farmer.dashboard') }}" class="sidebar-brand">
        🌾 AgriPool
        <div style="font-size:.7rem;font-weight:400;color:#888;margin-top:2px;">
            Farmer Portal
        </div>
    </a>

    <nav class="sidebar-nav">

        <div class="sidebar-label">Main</div>

        <a href="{{ route('farmer.dashboard') }}"
           class="nav-item-custom {{ request()->routeIs('farmer.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="sidebar-label">Transport</div>

        <a href="{{ route('farmer.requests.index') }}"
           class="nav-item-custom {{ request()->routeIs('farmer.requests.*') ? 'active' : '' }}">
            <span class="nav-icon">📋</span> My Requests
        </a>

        <a href="{{ route('farmer.requests.create') }}"
           class="nav-item-custom {{ request()->routeIs('farmer.requests.create') ? 'active' : '' }}">
            <span class="nav-icon">➕</span> New Request
        </a>

        <a href="{{ route('farmer.pools.index') }}"
           class="nav-item-custom {{ request()->routeIs('farmer.pools.*') ? 'active' : '' }}">
            <span class="nav-icon">🤝</span> Browse Pools
        </a>

        <a href="{{ route('farmer.history') }}"
           class="nav-item-custom {{ request()->routeIs('farmer.history') ? 'active' : '' }}">
            <span class="nav-icon">📦</span> Delivery History
        </a>

        <div class="sidebar-label">Account</div>

        <a href="{{ route('farmer.notifications.index') }}"
           class="nav-item-custom {{ request()->routeIs('farmer.notifications.*') ? 'active' : '' }}">
            <span class="nav-icon">🔔</span> Notifications
            @php
                $unread = Auth::user()->notifications()->where('is_read', false)->count();
            @endphp
            @if($unread > 0)
                <span class="badge-notif">{{ $unread }}</span>
            @endif
        </a>

        <a href="{{ route('farmer.profile.index') }}"
           class="nav-item-custom {{ request()->routeIs('farmer.profile.*') ? 'active' : '' }}">
            <span class="nav-icon">👤</span> My Profile
        </a>

    </nav>

    {{-- Sidebar footer: user info --}}
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div style="width:36px;height:36px;border-radius:50%;
                background:var(--green-dark);color:#fff;
                display:flex;align-items:center;justify-content:center;
                font-weight:700;font-size:.9rem;">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div style="overflow:hidden;">
                <div style="font-size:.85rem;font-weight:600;
                    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ Auth::user()->name }}
                </div>
                <div style="font-size:.7rem;color:#888;">Farmer Account</div>
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

{{-- ── MAIN CONTENT ─────────────────────────────── --}}
<div class="main-content">

    {{-- Top bar --}}
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            {{-- Mobile menu toggle --}}
            <button class="btn btn-sm btn-outline-secondary d-md-none"
                    onclick="document.getElementById('sidebar').classList.toggle('open')">
                ☰
            </button>
            <div>
                <h6 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h6>
                <small class="text-muted">@yield('page-subtitle', 'Welcome back')</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('farmer.notifications.index') }}"
               class="position-relative text-decoration-none text-dark">
                🔔
                @if(isset($unread) && $unread > 0)
                    <span class="position-absolute top-0 start-100 translate-middle
                          badge rounded-pill bg-danger" style="font-size:.6rem;">
                        {{ $unread }}
                    </span>
                @endif
            </a>
            <span class="badge rounded-pill"
                  style="background:var(--green-pale);color:var(--green-dark);">
                🌾 Farmer
            </span>
        </div>
    </div>

    {{-- Flash messages --}}
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- Page content --}}
    <div class="page-content">
        @yield('content')
    </div>

</div>

</body>
</html>