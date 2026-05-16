@extends('layouts.farmer')
@section('title', 'Farmer Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . Auth::user()->name)

@section('content')

{{-- Stats Row --}}
<div class="row g-4 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div style="font-size:1.8rem;">📋</div>
                <span class="badge" style="background:#e8f5e9;color:#2d6a4f;">All</span>
            </div>
            <div class="stat-num" style="color:#2d6a4f;">{{ $totalRequests }}</div>
            <div class="text-muted small mt-1">Total Requests</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div style="font-size:1.8rem;">🚛</div>
                <span class="badge" style="background:#fff3cd;color:#856404;">Live</span>
            </div>
            <div class="stat-num" style="color:#f4a261;">{{ $activeRequests }}</div>
            <div class="text-muted small mt-1">Active Requests</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div style="font-size:1.8rem;">✅</div>
                <span class="badge" style="background:#d4edda;color:#155724;">Done</span>
            </div>
            <div class="stat-num" style="color:#52b788;">{{ $completedRequests }}</div>
            <div class="text-muted small mt-1">Delivered</div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div style="font-size:1.8rem;">🔔</div>
                <span class="badge bg-danger text-white">New</span>
            </div>
            <div class="stat-num" style="color:#e63946;">{{ $unreadNotifications }}</div>
            <div class="text-muted small mt-1">Notifications</div>
        </div>
    </div>

</div>

{{-- Profile incomplete warning --}}
@if(!$farmerProfile || $farmerProfile->farm_location === 'Not specified')
    <div class="alert rounded-3 mb-4 d-flex align-items-center gap-3"
         style="background:#fff8e1;border:1px solid #ffe082;color:#7a5f00;">
        <span style="font-size:1.5rem;">⚠️</span>
        <div>
            <strong>Complete your profile</strong> — Add your farm location so you can be
            matched with nearby farmers.
            <a href="{{ route('farmer.profile.index') }}"
               style="color:#2d6a4f;font-weight:600;">Update Profile →</a>
        </div>
    </div>
@endif

<div class="row g-4">

    {{-- Quick Actions --}}
    <div class="col-lg-4">
        <div class="content-card h-100">
            <h6 class="fw-bold mb-4">⚡ Quick Actions</h6>

            <a href="{{ route('farmer.requests.create') }}"
               class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2 text-decoration-none"
               style="background:#f0faf4;color:#2d6a4f;transition:all .2s;"
               onmouseover="this.style.background='#d8f3dc'"
               onmouseout="this.style.background='#f0faf4'">
                <span style="font-size:1.4rem;">➕</span>
                <div>
                    <div class="fw-semibold small">New Transport Request</div>
                    <div style="font-size:.75rem;color:#888;">Post a new crop delivery</div>
                </div>
            </a>

            <a href="{{ route('farmer.pools.index') }}"
               class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2 text-decoration-none"
               style="background:#f0faf4;color:#2d6a4f;transition:all .2s;"
               onmouseover="this.style.background='#d8f3dc'"
               onmouseout="this.style.background='#f0faf4'">
                <span style="font-size:1.4rem;">🤝</span>
                <div>
                    <div class="fw-semibold small">Browse Pools</div>
                    <div style="font-size:.75rem;color:#888;">Find farmers to share with</div>
                </div>
            </a>

            <a href="{{ route('farmer.requests.index') }}"
               class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2 text-decoration-none"
               style="background:#f0faf4;color:#2d6a4f;transition:all .2s;"
               onmouseover="this.style.background='#d8f3dc'"
               onmouseout="this.style.background='#f0faf4'">
                <span style="font-size:1.4rem;">📋</span>
                <div>
                    <div class="fw-semibold small">My Requests</div>
                    <div style="font-size:.75rem;color:#888;">View all your requests</div>
                </div>
            </a>

            <a href="{{ route('farmer.history') }}"
               class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
               style="background:#f0faf4;color:#2d6a4f;transition:all .2s;"
               onmouseover="this.style.background='#d8f3dc'"
               onmouseout="this.style.background='#f0faf4'">
                <span style="font-size:1.4rem;">📦</span>
                <div>
                    <div class="fw-semibold small">Delivery History</div>
                    <div style="font-size:.75rem;color:#888;">Past deliveries</div>
                </div>
            </a>
        </div>
    </div>

    {{-- Recent Requests --}}
    <div class="col-lg-8">
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">📋 Recent Requests</h6>
                <a href="{{ route('farmer.requests.index') }}"
                   style="color:#2d6a4f;font-size:.85rem;text-decoration:none;">
                    View All →
                </a>
            </div>

            @php
                $recentRequests = Auth::user()->transportRequests()
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp

            @forelse($recentRequests as $req)
                <div class="d-flex align-items-center justify-content-between
                            p-3 rounded-3 mb-2"
                     style="background:#fafafa;border:1px solid #f0f0f0;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:40px;height:40px;border-radius:10px;
                            background:#d8f3dc;display:flex;align-items:center;
                            justify-content:center;font-size:1.2rem;">
                            🌾
                        </div>
                        <div>
                            <div class="fw-semibold small">{{ $req->crop_type }}</div>
                            <div style="font-size:.75rem;color:#888;">
                                {{ number_format($req->quantity_kg) }} kg →
                                {{ $req->destination_market }}
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="status-badge status-{{ $req->status }}">
                            {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                        </span>
                        <div style="font-size:.7rem;color:#aaa;margin-top:3px;">
                            {{ $req->preferred_pickup_date->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <div style="font-size:3rem;">📭</div>
                    <p class="mt-2">No requests yet.</p>
                    <a href="{{ route('farmer.requests.create') }}"
                       class="btn btn-sm"
                       style="background:#2d6a4f;color:#fff;border-radius:8px;">
                        Create your first request
                    </a>
                </div>
            @endforelse

        </div>
    </div>

</div>

@endsection