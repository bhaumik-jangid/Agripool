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
                {{ strtoupper(substr($user->name,0,2)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small">{{ $user->email }}</p>
            <p class="text-muted small">📞 {{ $user->phone ?? '—' }}</p>

            @php
                $approval = $user->driverProfile->approval_status ?? 'pending';
            @endphp
            <span class="status-badge status-{{ $approval }} mb-3"
                  style="font-size:.85rem;padding:6px 16px;">
                {{ ucfirst($approval) }}
            </span>

            {{-- Approve button --}}
            @if($approval === 'pending' || $approval === 'rejected')
                <form method="POST"
                      action="{{ route('admin.drivers.approve', $user) }}"
                      class="mb-2">
                    @csrf
                    <button class="btn btn-success w-100"
                            style="border-radius:10px;">
                        ✅ Approve Driver
                    </button>
                </form>
            @endif

            {{-- Reject form --}}
            @if($approval !== 'rejected')
                <form method="POST"
                      action="{{ route('admin.drivers.reject', $user) }}"
                      id="rejectForm">
                    @csrf
                    <div class="mb-2" id="rejectReasonDiv"
                         style="display:none;">
                        <textarea name="rejection_reason"
                                  class="form-control form-control-sm mb-2"
                                  rows="2"
                                  placeholder="Reason for rejection (required)"
                                  style="border-radius:8px;"></textarea>
                    </div>
                    <button type="button"
                            class="btn btn-outline-danger w-100"
                            style="border-radius:10px;"
                            onclick="toggleReject()">
                        ❌ Reject Driver
                    </button>
                    <button type="submit"
                            id="submitReject"
                            class="btn btn-danger w-100 mt-2"
                            style="border-radius:10px;display:none;">
                        Confirm Rejection
                    </button>
                </form>
            @endif
        </div>

        {{-- Vehicle --}}
        @if($user->vehicle)
            <div class="content-card">
                <h6 class="fw-bold mb-3">🚛 Vehicle</h6>
                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Number</span>
                        <span class="fw-bold">
                            {{ $user->vehicle->vehicle_number }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Type</span>
                        <span>{{ $user->vehicle->vehicle_type }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Capacity</span>
                        <span>{{ $user->vehicle->capacity_tonnes }} tonnes</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Verified</span>
                        <span class="badge {{ $user->vehicle->is_verified
                            ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $user->vehicle->is_verified
                               ? 'Yes' : 'Pending' }}
                        </span>
                    </div>
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
                                <td class="fw-semibold small"
                                    style="color:#1d3557;">
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
                                            '_',' ',$shipment->status)) }}
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    {{ $shipment->created_at
                                         ->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="text-center text-muted py-4 small">
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