@extends('layouts.admin')
@section('title', 'Driver: ' . $user->name)
@section('page-title', $user->name)
@section('page-subtitle', 'Driver profile and deliveries')

@section('content')

    <div class="row g-4">

        {{-- Profile --}}
        <div class="col-lg-4">
            <div class="content-card text-center mb-4">
                <div style="width:72px;height:72px;border-radius:50%;
                        background:#1d3557;color:#fff;
                        display:flex;align-items:center;justify-content:center;
                        font-size:1.8rem;font-weight:800;margin:0 auto 16px;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small">{{ $user->email }}</p>
                <p class="text-muted small">📞 {{ $user->phone ?? '—' }}</p>

                @php
                    $approval = $user->driverProfile->approval_status ?? 'pending';
                @endphp
                <span class="status-badge status-{{ $approval }} mb-3" style="font-size:.85rem;padding:6px 16px;">
                    {{ ucfirst($approval) }}
                </span>

                {{-- Approve button --}}
                @if($approval === 'pending' || $approval === 'rejected')
                    <form method="POST" action="{{ route('admin.drivers.approve', $user) }}" class="mb-2">
                        @csrf
                        <button class="btn btn-success w-100" style="border-radius:10px;">
                            ✅ Approve Driver
                        </button>
                    </form>
                @endif

                {{-- Reject form --}}
                @if($approval !== 'rejected')
                    <form method="POST" action="{{ route('admin.drivers.reject', $user) }}" id="rejectForm">
                        @csrf
                        <div class="mb-2" id="rejectReasonDiv" style="display:none;">
                            <textarea name="rejection_reason" class="form-control form-control-sm mb-2" rows="2"
                                placeholder="Reason for rejection (required)" style="border-radius:8px;"></textarea>
                        </div>
                        <button type="button" class="btn btn-outline-danger w-100" style="border-radius:10px;"
                            onclick="toggleReject()">
                            ❌ Reject Driver
                        </button>
                        <button type="submit" id="submitReject" class="btn btn-danger w-100 mt-2"
                            style="border-radius:10px;display:none;">
                            Confirm Rejection
                        </button>
                    </form>
                @endif
            </div>

            {{-- Vehicle --}}
            @if($user->vehicle)
                <div class="content-card">
                    <h6 class="fw-bold mb-3">🚛 Vehicle Details</h6>
                    <div class="small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Registration</span>
                            <span class="fw-bold">
                                {{ $user->vehicle->vehicle_number }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Type</span>
                            <span>{{ $user->vehicle->vehicle_type }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Model</span>
                            <span>{{ $user->vehicle->vehicle_model ?? '—' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Capacity</span>
                            <span>{{ $user->vehicle->capacity_tonnes }} tonnes</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Insurance Expiry</span>
                            <span>
                                {{ $user->vehicle->insurance_expiry ?? '—' }}
                            </span>
                        </div>

                        {{-- Verification status + button --}}
                        <div class="d-flex justify-content-between align-items-center
                                        p-2 rounded-3" style="background:#f8f9fa;">
                            <span class="text-muted">Verified</span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge
                                          {{ $user->vehicle->is_verified
                ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $user->vehicle->is_verified
                ? '✅ Verified' : '⏳ Pending' }}
                                </span>
                                @if(!$user->vehicle->is_verified)
                                                    <form method="POST" action="{{ route(
                                        'admin.vehicles.verify',
                                        $user->vehicle
                                    ) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" style="border-radius:8px;
                                                                                                   font-size:.75rem;padding:3px 10px;">
                                                            Verify Now
                                                        </button>
                                                    </form>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @else
                <div class="content-card">
                    <div class="text-center py-3 text-muted small">
                        <div style="font-size:2rem;">🚛</div>
                        <p class="mt-2">No vehicle registered yet.</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Shipments --}}
        <div class="col-lg-8">
            <div class="content-card">
                <h6 class="fw-bold mb-4">📦 Delivery History</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#f8f9fa;">
                            <tr>
                                <th style="font-size:.78rem;color:#888;">
                                    TRACKING
                                </th>
                                <th style="font-size:.78rem;color:#888;">
                                    DESTINATION
                                </th>
                                <th style="font-size:.78rem;color:#888;">
                                    STATUS
                                </th>
                                <th style="font-size:.78rem;color:#888;">
                                    DATE
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shipments as $shipment)
                                                    <tr>
                                                        <td class="fw-semibold small" style="color:#1d3557;">
                                                            {{ $shipment->tracking_code }}
                                                        </td>
                                                        <td class="small">
                                                            {{ $shipment->pool->destination_market
                                    ?? '—' }}
                                                        </td>
                                                        <td>
                                                            <span class="status-badge
                                                                                                  status-{{ $shipment->status }}">
                                                                {{ ucfirst(str_replace(
                                    '_',
                                    ' ',
                                    $shipment->status
                                )) }}
                                                            </span>
                                                        </td>
                                                        <td class="small text-muted">
                                                            {{ $shipment->created_at
                                    ->format('d M Y') }}
                                                        </td>
                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4 small">
                                        No deliveries yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $shipments->links() }}</div>
            </div>
        </div>

        {{-- Recent Ratings --}}
        <div class="content-card mt-4">
            <h6 class="fw-bold mb-4">⭐ Recent Ratings from Farmers</h6>

            @php
                // Get all pool members who rated this driver
                $ratings = \App\Models\PoolMember::whereHas('pool', function ($q) use ($user) {
                    $q->where('driver_id', $user->id);
                })
                    ->where('has_rated', true)
                    ->whereNotNull('driver_rating')
                    ->with('farmer', 'transportRequest')
                    ->orderBy('updated_at', 'desc')
                    ->take(10)
                    ->get();
            @endphp

            @if($ratings->count() > 0)

                {{-- Average summary --}}
                <div class="p-3 rounded-3 mb-4 text-center" style="background:#fff8e1;">
                    <div style="font-size:2.5rem;font-weight:800;color:#f4a261;">
                        {{ number_format($user->driverProfile->rating ?? 0, 1) }}
                    </div>
                    <div style="font-size:1.2rem;color:#f4a261;">
                        @for($i = 1; $i <= 5; $i++)
                                {{ $i <= round($user->driverProfile->rating ?? 0)
                            ? '★' : '☆' }}
                        @endfor
                    </div>
                    <div class="text-muted small mt-1">
                        Based on {{ $ratings->count() }} rating(s)
                    </div>
                </div>

                @foreach($ratings as $rating)
                    <div class="p-3 rounded-3 mb-2" style="background:#fafafa;border:1px solid #f0f0f0;">
                        <div class="d-flex justify-content-between
                                        align-items-start">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px;height:32px;border-radius:50%;
                                        background:#2d6a4f;color:#fff;
                                        display:flex;align-items:center;
                                        justify-content:center;font-size:.78rem;
                                        font-weight:700;">
                                    {{ strtoupper(substr(
                        $rating->farmer->name ?? 'F',
                        0,
                        2
                    )) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">
                                        {{ $rating->farmer->name ?? 'Farmer' }}
                                    </div>
                                    <div style="font-size:.72rem;color:#888;">
                                        {{ $rating->transportRequest->crop_type ?? '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div style="color:#f4a261;">
                                    @for($i = 1; $i <= 5; $i++)
                                                <span style="font-size:.9rem;">
                                                    {{ $i <= $rating->driver_rating
                                        ? '★' : '☆' }}
                                                </span>
                                    @endfor
                                </div>
                                <div style="font-size:.7rem;color:#aaa;">
                                    {{ $rating->updated_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        @if($rating->rating_comment)
                            <div class="mt-2 small text-muted" style="font-style:italic;">
                                "{{ $rating->rating_comment }}"
                            </div>
                        @endif
                    </div>
                @endforeach

            @else
                <div class="text-center py-4 text-muted small">
                    <div style="font-size:2rem;">⭐</div>
                    <p class="mt-2">No ratings received yet.</p>
                </div>
            @endif

        </div>

    </div>

    @push('scripts')
        <script>
            function toggleReject() {
                const div = document.getElementById('rejectReasonDiv');
                const btn = document.getElementById('submitReject');
                div.style.display = div.style.display === 'none' ? 'block' : 'none';
                btn.style.display = btn.style.display === 'none' ? 'block' : 'none';
            }
        </script>
    @endpush

@endsection