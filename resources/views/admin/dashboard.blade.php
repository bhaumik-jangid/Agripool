@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Platform overview — ' . now()->format('d M Y'))

@section('content')

    {{-- Pending approvals alert --}}
    @if($pendingApprovals > 0)
        <div class="alert rounded-3 mb-4 d-flex align-items-center gap-3"
            style="background:#fff8e1;border:1px solid #ffe082;color:#7a5f00;">
            <span style="font-size:1.5rem;">⚠️</span>
            <div>
                <strong>{{ $pendingApprovals }} driver(s) waiting for approval.</strong>
                Review and approve them so they can start accepting deliveries.
                <a href="{{ route('admin.drivers.index') }}" style="color:#1b1b2f;font-weight:700;">Review Now →</a>
            </div>
        </div>
    @endif

    {{-- Stats row --}}
    <div class="row g-4 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span style="font-size:1.8rem;">🌾</span>
                    <a href="{{ route('admin.farmers.index') }}" style="font-size:.78rem;color:#f4a261;
                              text-decoration:none;">View →</a>
                </div>
                <div class="stat-num" style="color:#2d6a4f;">
                    {{ $totalFarmers }}
                </div>
                <div class="text-muted small mt-1">Total Farmers</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span style="font-size:1.8rem;">🚛</span>
                    <a href="{{ route('admin.drivers.index') }}" style="font-size:.78rem;color:#f4a261;
                              text-decoration:none;">View →</a>
                </div>
                <div class="stat-num" style="color:#1d3557;">
                    {{ $totalDrivers }}
                </div>
                <div class="text-muted small mt-1">Total Drivers</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span style="font-size:1.8rem;">📋</span>
                    <a href="{{ route('admin.requests.index') }}" style="font-size:.78rem;color:#f4a261;
                              text-decoration:none;">View →</a>
                </div>
                <div class="stat-num" style="color:#f4a261;">
                    {{ $totalRequests }}
                </div>
                <div class="text-muted small mt-1">Transport Requests</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span style="font-size:1.8rem;">✅</span>
                    <a href="{{ route('admin.shipments.index') }}" style="font-size:.78rem;color:#f4a261;
                              text-decoration:none;">View →</a>
                </div>
                <div class="stat-num" style="color:#52b788;">
                    {{ $completedDeliveries }}
                </div>
                <div class="text-muted small mt-1">Completed Deliveries</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span style="font-size:1.8rem;">🤝</span>
                    <a href="{{ route('admin.pools.index') }}" style="font-size:.78rem;color:#f4a261;
                              text-decoration:none;">View →</a>
                </div>
                <div class="stat-num" style="color:#457b9d;">
                    {{ $activePools }}
                </div>
                <div class="text-muted small mt-1">Active Pools</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span style="font-size:1.8rem;">💰</span>
                </div>
                <div class="stat-num" style="color:#2d6a4f;">
                    ₹{{ number_format($totalEarnings, 0) }}
                </div>
                <div class="text-muted small mt-1">Total Paid to Drivers</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span style="font-size:1.8rem;">⏳</span>
                    <a href="{{ route('admin.drivers.index') }}" style="font-size:.78rem;color:#e63946;
                              text-decoration:none;">Approve →</a>
                </div>
                <div class="stat-num" style="color:#e63946;">
                    {{ $pendingApprovals }}
                </div>
                <div class="text-muted small mt-1">Pending Driver Approvals</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span style="font-size:1.8rem;">💬</span>
                    <a href="{{ route('admin.feedback.index') }}" style="font-size:.78rem;color:#f4a261;
                              text-decoration:none;">View →</a>
                </div>
                <div class="stat-num" style="color:#f4a261;">
                    {{ $openFeedback }}
                </div>
                <div class="text-muted small mt-1">Open Feedback</div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        {{-- Pending driver approvals --}}
        <div class="col-lg-5">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0">⏳ Pending Driver Approvals</h6>
                    <a href="{{ route('admin.drivers.index') }}"
                        style="font-size:.82rem;color:#f4a261;text-decoration:none;">
                        View All →
                    </a>
                </div>

                @forelse($pendingDriversList as $driver)
                            <div class="d-flex align-items-center
                                            justify-content-between p-3 rounded-3 mb-2"
                                style="background:#fafafa;border:1px solid #f0f0f0;">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:38px;height:38px;border-radius:50%;
                                            background:#1d3557;color:#fff;
                                            display:flex;align-items:center;
                                            justify-content:center;font-weight:700;
                                            font-size:.85rem;">
                                        {{ strtoupper(substr($driver->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">
                                            {{ $driver->name }}
                                        </div>
                                        <div style="font-size:.72rem;color:#888;">
                                            {{ $driver->email }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <form method="POST" action="{{ route(
                        'admin.drivers.approve',
                        $driver
                    ) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success"
                                            style="border-radius:8px;font-size:.75rem;">
                                            ✅
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.drivers.show', $driver) }}" class="btn btn-sm btn-outline-secondary"
                                        style="border-radius:8px;font-size:.75rem;">
                                        View
                                    </a>
                                </div>
                            </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <div style="font-size:2rem;">✅</div>
                        <p class="small mt-2">No pending approvals</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent transport requests --}}
        <div class="col-lg-7">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0">📋 Recent Transport Requests</h6>
                    <a href="{{ route('admin.requests.index') }}"
                        style="font-size:.82rem;color:#f4a261;text-decoration:none;">
                        View All →
                    </a>
                </div>

                @forelse($recentRequests as $req)
                    <div class="d-flex align-items-center
                                    justify-content-between p-3 rounded-3 mb-2"
                        style="background:#fafafa;border:1px solid #f0f0f0;">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:36px;height:36px;border-radius:10px;
                                    background:#f0faf4;display:flex;align-items:center;
                                    justify-content:center;font-size:1rem;">
                                🌾
                            </div>
                            <div>
                                <div class="fw-semibold small">
                                    {{ $req->crop_type }}
                                    — {{ number_format($req->quantity_kg) }}kg
                                </div>
                                <div style="font-size:.72rem;color:#888;">
                                    {{ $req->farmer->name ?? 'N/A' }}
                                    → {{ $req->destination_market }}
                                </div>
                            </div>
                        </div>
                        <span class="status-badge status-{{ $req->status }}">
                            {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">
                        No requests yet.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Activity chart --}}
        <div class="col-12">
            <div class="content-card">
                <h6 class="fw-bold mb-4">
                    📈 Transport Requests — Last 7 Days
                </h6>
                <div style="display:flex;align-items:flex-end;gap:12px;
                        height:160px;padding-bottom:8px;">
                    @foreach($chartData as $day)
                        @php
                            $height = $day['count'] > 0
                                ? max(($day['count'] / $maxChartCount) * 120, 8)
                                : 4;
                        @endphp
                        <div style="flex:1;display:flex;flex-direction:column;
                                    align-items:center;gap:6px;">
                            <div style="font-size:.75rem;font-weight:700;color:#2d6a4f;">
                                {{ $day['count'] ?: '' }}
                            </div>
                            <div style="width:100%;height:{{ $height }}px;
                                        background:linear-gradient(180deg,#52b788,#2d6a4f);
                                        border-radius:6px 6px 0 0;min-height:4px;">
                            </div>
                            <div style="font-size:.72rem;color:#aaa;white-space:nowrap;">
                                {{ $day['date'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection