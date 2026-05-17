<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Farmer Panel') — AgriPool</title>
    @vite(['resources/css/app.css', 'resources/css/premium.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        :root {
            --green-dark: #2d6a4f;
            --green-mid: #40916c;
            --green-light: #52b788;
            --green-pale: #f0faf4;
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
            background: #fff;
            border-right: 1px solid rgba(0, 0, 0, .06);
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(0, 0, 0, .06);
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
            background: linear-gradient(135deg, #2d6a4f, #52b788);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-brand-text {
            font-size: 1.1rem;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: -.3px;
        }

        .sidebar-brand-sub {
            font-size: .68rem;
            color: #94a3b8;
            font-weight: 500;
            margin-top: 1px;
        }

        .sidebar-nav {
            padding: 12px 12px;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-section-label {
            font-size: .65rem;
            font-weight: 700;
            color: #94a3b8;
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
            border-top: 1px solid rgba(0, 0, 0, .06);
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

        <a href="{{ route('farmer.dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <div class="sidebar-brand-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a10 10 0 0 1 10 10" />
                        <path d="M12 2C6.5 2 2 6.5 2 12" />
                        <path d="M12 22C6.5 22 2 17.5 2 12" />
                        <path d="M12 6v6l4 2" />
                    </svg>
                </div>
                <div>
                    <div class="sidebar-brand-text">AgriPool</div>
                    <div class="sidebar-brand-sub">Farmer Portal</div>
                </div>
            </div>
        </a>

        <nav class="sidebar-nav">

            <div class="sidebar-section-label">Overview</div>

            <a href="{{ route('farmer.dashboard') }}"
                class="nav-item-custom {{ request()->routeIs('farmer.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="layout-dashboard" width="16" height="16"></i>
                </span>
                Dashboard
                @php
                    $unpaidDashboard = Auth::user()->transportRequests()
                        ->where('status', 'delivered')
                        ->whereHas('poolMember', fn($q) => $q->where('cost_paid', false))
                        ->count();
                @endphp
                @if($unpaidDashboard > 0)
                    <span class="badge-notif">₹</span>
                @endif
            </a>

            <div class="sidebar-section-label">Transport</div>

            <a href="{{ route('farmer.requests.index') }}"
                class="nav-item-custom {{ request()->routeIs('farmer.requests.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="file-text" width="16" height="16"></i>
                </span>
                My Requests
            </a>

            <a href="{{ route('farmer.requests.create') }}"
                class="nav-item-custom {{ request()->routeIs('farmer.requests.create') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="plus-circle" width="16" height="16"></i>
                </span>
                New Request
            </a>

            <a href="{{ route('farmer.pools.index') }}"
                class="nav-item-custom {{ request()->routeIs('farmer.pools.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="users" width="16" height="16"></i>
                </span>
                Browse Pools
            </a>

            <a href="{{ route('farmer.history') }}"
                class="nav-item-custom {{ request()->routeIs('farmer.history') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="package" width="16" height="16"></i>
                </span>
                Delivery History
            </a>

            <div class="sidebar-section-label">Account</div>

            <a href="{{ route('farmer.notifications.index') }}"
                class="nav-item-custom {{ request()->routeIs('farmer.notifications.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="bell" width="16" height="16"></i>
                </span>
                Notifications
                @php
                    $unread = Auth::user()->notifications()
                        ->where('is_read', false)->count();
                @endphp
                @if($unread > 0)
                    <span class="badge-notif">{{ $unread }}</span>
                @endif
            </a>

            <a href="{{ route('farmer.profile.index') }}"
                class="nav-item-custom {{ request()->routeIs('farmer.profile.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <i data-lucide="user-circle" width="16" height="16"></i>
                </span>
                My Profile
            </a>

        </nav>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="user-avatar" style="background:#2d6a4f;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div style="overflow:hidden;flex:1;">
                    <div style="font-size:.82rem;font-weight:600;
                    color:#1a1a2e;white-space:nowrap;
                    overflow:hidden;text-overflow:ellipsis;">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:.68rem;color:#94a3b8;">
                        Farmer Account
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn w-100 d-flex align-items-center
                           justify-content-center gap-2" style="background:#f8fafc;color:#64748b;
                           border:1px solid #e2e8f0;border-radius:10px;
                           font-size:.8rem;font-weight:500;padding:8px;
                           transition:all 160ms ease;" onmouseover="this.style.background='#fee2e2';
                                 this.style.color='#dc2626';
                                 this.style.borderColor='#fca5a5'" onmouseout="this.style.background='#f8fafc';
                                this.style.color='#64748b';
                                this.style.borderColor='#e2e8f0'">
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
                        @yield('page-subtitle', 'Welcome back')
                    </p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('farmer.notifications.index') }}" class="position-relative text-decoration-none"
                    style="color:#64748b;transition:color 160ms ease;" onmouseover="this.style.color='#2d6a4f'"
                    onmouseout="this.style.color='#64748b'">
                    <i data-lucide="bell" width="18" height="18"></i>
                    @if(isset($unread) && $unread > 0)
                        <span style="position:absolute;top:-4px;right:-4px;
                                width:8px;height:8px;border-radius:50%;
                                background:#ef4444;border:2px solid #fff;">
                        </span>
                    @endif
                </a>
                <div style="width:1px;height:20px;background:#e2e8f0;"></div>
                <span style="font-size:.72rem;font-weight:600;color:#2d6a4f;
                background:#f0faf4;padding:4px 10px;border-radius:20px;
                border:1px solid rgba(45,106,79,.15);">
                    Farmer
                </span>
            </div>

            {{-- Language switcher --}}
            <div class="dropdown">
                <button class="btn btn-sm dropdown-toggle" style="background:transparent;border:1px solid #e2e8f0;
                   border-radius:8px;font-size:.75rem;color:#64748b;
                   padding:5px 10px;" data-bs-toggle="dropdown">
                    {{ strtoupper(app()->getLocale()) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="border-radius:10px;font-size:.82rem;">
                    <li>
                        <a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">
                            English
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('locale.switch', 'hi') }}">
                            हिंदी
                        </a>
                    </li>
                </ul>
            </div>
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