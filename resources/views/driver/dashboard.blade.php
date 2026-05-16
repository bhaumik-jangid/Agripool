@extends('layouts.driver')
@section('title', 'Driver Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . Auth::user()->name)

@section('content')

{{-- Approval banner --}}
@if($driverProfile && $driverProfile->approval_status === 'pending')
    <div class="alert rounded-3 mb-4 d-flex align-items-center gap-3"
         style="background:#fff8e1;border:1px solid #ffe082;color:#7a5f00;">
        <span style="font-size:1.5rem;">⏳</span>
        <div>
            <strong>Account Under Review</strong> — Admin is verifying your profile.
            You can set up your vehicle while you wait.
            <a href="{{ route('driver.vehicle.index') }}"
               style="color:#1d3557;font-weight:600;">Add Vehicle →</a>
        </div>
    </div>
@elseif($driverProfile && $driverProfile->approval_status === 'rejected')
    <div class="alert alert-danger rounded-3 mb-4">
        ❌ <strong>Account Rejected.</strong>
        {{ $driverProfile->rejection_reason ?? 'Please contact support.' }}
    </div>
@endif

{{-- Stats --}}
<div class="row g-4 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:1.8rem;">📦</span>
                <span class="badge" style="background:#e8f4f8;color:#1d3557;">All</span>
            </div>
            <div class="stat-num" style="color:#1d3557;">{{ $totalDeliveries }}</div>
            <div class="text-muted small mt-1">Total Deliveries</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:1.8rem;">🚛</span>
                <span class="badge" style="background:#fff3cd;color:#856404;">Live</span>
            </div>
            <div class="stat-num" style="color:#f4a261;">{{ $activeDeliveries }}</div>
            <div class="text-muted small mt-1">Active Deliveries</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:1.8rem;">💰</span>
                <span class="badge" style="background:#d4edda;color:#155724;">Paid</span>
            </div>
            <div class="stat-num" style="color:#52b788;">
                ₹{{ number_format($totalEarnings, 0) }}
            </div>
            <div class="text-muted small mt-1">Total Earnings</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:1.8rem;">⏳</span>
                <span class="badge" style="background:#f8d7da;color:#721c24;">Pending</span>
            </div>
            <div class="stat-num" style="color:#e63946;">
                ₹{{ number_format($pendingEarnings, 0) }}
            </div>
            <div class="text-muted small mt-1">Pending Payment</div>
        </div>
    </div>

</div>

<div class="row g-4">

    {{-- Quick Actions --}}
    <div class="col-lg-4">
        <div class="content-card h-100">
            <h6 class="fw-bold mb-4">⚡ Quick Actions</h6>

            @php
                $actions = [
                    ['route' => 'driver.pools.index',
                     'icon'  => '🤝',
                     'label' => 'Available Pools',
                     'sub'   => $availablePools . ' pools waiting'],
                    ['route' => 'driver.deliveries.index',
                     'icon'  => '📦',
                     'label' => 'My Deliveries',
                     'sub'   => $activeDeliveries . ' active'],
                    ['route' => 'driver.earnings.index',
                     'icon'  => '💰',
                     'label' => 'Earnings',
                     'sub'   => '₹' . number_format($pendingEarnings) . ' pending'],
                    ['route' => 'driver.vehicle.index',
                     'icon'  => '🚛',
                     'label' => 'My Vehicle',
                     'sub'   => $vehicle ? $vehicle->vehicle_number : 'Not added'],
                ];
            @endphp

            @foreach($actions as $action)
                <a href="{{ route($action['route']) }}"
                   class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2
                          text-decoration-none"
                   style="background:#f0f6fb;color:#1d3557;transition:all .2s;"
                   onmouseover="this.style.background='#dbeaf5'"
                   onmouseout="this.style.background='#f0f6fb'">
                    <span style="font-size:1.4rem;">{{ $action['icon'] }}</span>
                    <div>
                        <div class="fw-semibold small">{{ $action['label'] }}</div>
                        <div style="font-size:.75rem;color:#888;">{{ $action['sub'] }}</div>
                    </div>
                </a>
            @endforeach

        </div>
    </div>

    {{-- Recent Deliveries --}}
    <div class="col-lg-8">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">📦 Recent Deliveries</h6>
                <a href="{{ route('driver.deliveries.index') }}"
                   style="color:#1d3557;font-size:.85rem;text-decoration:none;">
                    View All →
                </a>
            </div>

            @forelse($recentShipments as $shipment)
                <div class="d-flex align-items-center justify-content-between
                            p-3 rounded-3 mb-2"
                     style="background:#fafafa;border:1px solid #f0f0f0;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:40px;height:40px;border-radius:10px;
                            background:#e8f4f8;display:flex;align-items:center;
                            justify-content:center;font-size:1.2rem;">
                            🚛
                        </div>
                        <div>
                            <div class="fw-semibold small">
                                {{ $shipment->tracking_code }}
                            </div>
                            <div style="font-size:.75rem;color:#888;">
                                → {{ $shipment->pool->destination_market ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="status-badge status-{{ $shipment->status }}">
                            {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                        </span>
                        <div style="font-size:.7rem;color:#aaa;margin-top:3px;">
                            {{ $shipment->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <div style="font-size:3rem;">📭</div>
                    <p class="mt-2">No deliveries yet.</p>
                    <a href="{{ route('driver.pools.index') }}"
                       class="btn btn-sm text-white"
                       style="background:#1d3557;border-radius:8px;">
                        Browse Available Pools
                    </a>
                </div>
            @endforelse

        </div>
    </div>

</div>

@endsection