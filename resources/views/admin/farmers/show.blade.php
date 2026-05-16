@extends('layouts.admin')
@section('title', 'Farmer: ' . $user->name)
@section('page-title', $user->name)
@section('page-subtitle', 'Farmer details and history')

@section('content')

<div class="row g-4">

    {{-- Profile card --}}
    <div class="col-lg-4">
        <div class="content-card text-center">
            <div style="width:72px;height:72px;border-radius:50%;
                background:#2d6a4f;color:#fff;
                display:flex;align-items:center;justify-content:center;
                font-size:1.8rem;font-weight:800;margin:0 auto 16px;">
                {{ strtoupper(substr($user->name,0,2)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-3">{{ $user->email }}</p>

            <span class="badge {{ $user->is_active
                ? 'bg-success' : 'bg-danger' }} mb-3">
                {{ $user->is_active ? 'Active' : 'Suspended' }}
            </span>

            <div class="row g-2 mt-2">
                <div class="col-6">
                    <div class="p-2 rounded-3" style="background:#f0faf4;">
                        <div class="fw-bold" style="color:#2d6a4f;">
                            {{ $stats['total'] }}
                        </div>
                        <div style="font-size:.7rem;color:#888;">Total</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 rounded-3" style="background:#f0faf4;">
                        <div class="fw-bold text-success">
                            {{ $stats['delivered'] }}
                        </div>
                        <div style="font-size:.7rem;color:#888;">Delivered</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 rounded-3" style="background:#f0faf4;">
                        <div class="fw-bold text-warning">
                            {{ $stats['active'] }}
                        </div>
                        <div style="font-size:.7rem;color:#888;">Active</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 rounded-3" style="background:#f0faf4;">
                        <div class="fw-bold text-danger">
                            {{ $stats['cancelled'] }}
                        </div>
                        <div style="font-size:.7rem;color:#888;">Cancelled</div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                @if($user->is_active)
                    <form method="POST"
                          action="{{ route('admin.users.suspend', $user) }}"
                          onsubmit="return confirm('Suspend this farmer?')">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger w-100"
                                style="border-radius:8px;">
                            Suspend Account
                        </button>
                    </form>
                @else
                    <form method="POST"
                          action="{{ route('admin.users.activate', $user) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-success w-100"
                                style="border-radius:8px;">
                            Reactivate Account
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Farm profile --}}
        @if($user->farmerProfile)
            <div class="content-card mt-4">
                <h6 class="fw-bold mb-3">🌾 Farm Details</h6>
                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Farm Name</span>
                        <span class="fw-semibold">
                            {{ $user->farmerProfile->farm_name ?? '—' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Location</span>
                        <span class="fw-semibold">
                            {{ $user->farmerProfile->farm_location }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">District</span>
                        <span class="fw-semibold">
                            {{ $user->farmerProfile->district }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">State</span>
                        <span class="fw-semibold">
                            {{ $user->farmerProfile->state }}
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Requests history --}}
    <div class="col-lg-8">
        <div class="content-card">
            <h6 class="fw-bold mb-4">📋 Transport Requests</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th style="font-size:.78rem;color:#888;">CROP</th>
                            <th style="font-size:.78rem;color:#888;">QTY</th>
                            <th style="font-size:.78rem;color:#888;">DESTINATION</th>
                            <th style="font-size:.78rem;color:#888;">DATE</th>
                            <th style="font-size:.78rem;color:#888;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr>
                                <td class="fw-semibold small">
                                    {{ $req->crop_type }}
                                </td>
                                <td class="small">
                                    {{ number_format($req->quantity_kg) }}kg
                                </td>
                                <td class="small">
                                    {{ $req->destination_market }}
                                </td>
                                <td class="small text-muted">
                                    {{ $req->preferred_pickup_date
                                         ->format('d M Y') }}
                                </td>
                                <td>
                                    <span class="status-badge
                                          status-{{ $req->status }}">
                                        {{ ucfirst(str_replace(
                                            '_',' ',$req->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center
                                              text-muted py-4 small">
                                    No requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $requests->links() }}</div>
        </div>
    </div>

</div>

@endsection