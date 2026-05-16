@extends('layouts.driver')
@section('title', 'Delivery: ' . $shipment->tracking_code)
@section('page-title', $shipment->tracking_code)
@section('page-subtitle', 'Manage this delivery')

@section('content')

<div class="row g-4">

    {{-- Left: Shipment details --}}
    <div class="col-lg-7">

        {{-- Pool info --}}
        <div class="content-card mb-4">
            <h6 class="fw-bold mb-4">📦 Delivery Details</h6>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background:#f0f6fb;">
                        <div style="font-size:.72rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Destination</div>
                        <div class="fw-semibold mt-1">
                            {{ $shipment->pool->destination_market }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background:#f0f6fb;">
                        <div style="font-size:.72rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Pickup Date</div>
                        <div class="fw-semibold mt-1">
                            {{ $shipment->pool->pickup_date->format('d M Y') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background:#f0f6fb;">
                        <div style="font-size:.72rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Total Cargo</div>
                        <div class="fw-semibold mt-1">
                            {{ number_format($shipment->pool->used_capacity_kg) }} kg
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background:#f0f6fb;">
                        <div style="font-size:.72rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Trip Earnings</div>
                        <div class="fw-semibold mt-1" style="color:#2d6a4f;">
                            ₹{{ number_format($shipment->pool->total_cost ?? 0, 2) }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Farmers in this pool --}}
            <h6 class="fw-bold mb-3">👨‍🌾 Farmers in This Pool</h6>
            @foreach($shipment->pool->members as $member)
                <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2"
                     style="background:#fafafa;border:1px solid #f0f0f0;">
                    <div style="width:40px;height:40px;border-radius:10px;
                        background:#d8f3dc;display:flex;align-items:center;
                        justify-content:center;font-weight:700;color:#2d6a4f;">
                        {{ strtoupper(substr($member->farmer->name ?? 'F', 0, 2)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">
                            {{ $member->farmer->name ?? 'Farmer' }}
                        </div>
                        <div style="font-size:.75rem;color:#888;">
                            {{ $member->transportRequest->crop_type ?? '' }} —
                            {{ number_format($member->transportRequest->quantity_kg ?? 0) }} kg
                        </div>
                        <div style="font-size:.72rem;color:#aaa;">
                            Pickup: {{ $member->transportRequest->pickup_location ?? 'N/A' }}
                        </div>
                    </div>
                    <div style="font-size:.75rem;text-align:right;">
                        <div class="fw-semibold" style="color:#2d6a4f;">
                            ₹{{ number_format($member->cost_share ?? 0, 2) }}
                        </div>
                        <div style="color:#aaa;">share</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Shipment Timeline --}}
        <div class="content-card">
            <h6 class="fw-bold mb-4">📍 Shipment Timeline</h6>

            @php
                $statuses = [
                    'pickup_pending' => ['label' => 'Pickup Pending',
                                         'icon'  => '📋',
                                         'desc'  => 'Waiting to pick up cargo'],
                    'cargo_loaded'   => ['label' => 'Cargo Loaded',
                                         'icon'  => '📦',
                                         'desc'  => 'All cargo loaded onto truck'],
                    'in_transit'     => ['label' => 'In Transit',
                                         'icon'  => '🚛',
                                         'desc'  => 'Truck is on the way'],
                    'delivered'      => ['label' => 'Delivered',
                                         'icon'  => '✅',
                                         'desc'  => 'Successfully delivered to market'],
                ];
                $statusOrder = array_keys($statuses);
                $currentIdx  = array_search($shipment->status, $statusOrder);
            @endphp

            <div class="timeline">
                @foreach($statuses as $key => $step)
                    @php
                        $stepIdx = array_search($key, $statusOrder);
                        $isDone  = $stepIdx < $currentIdx;
                        $isNow   = $key === $shipment->status;
                    @endphp
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $isDone ? 'done' : ($isNow ? 'active' : '') }}">
                        </div>
                        <div class="ps-2">
                            <div class="fw-semibold small
                                {{ $isDone ? 'text-success' :
                                   ($isNow ? 'text-primary' : 'text-muted') }}">
                                {{ $step['icon'] }} {{ $step['label'] }}
                            </div>
                            <div style="font-size:.78rem;color:#aaa;">
                                {{ $step['desc'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- Right: Update status --}}
    <div class="col-lg-5">

        @if(!in_array($shipment->status, ['delivered', 'failed']))

            <div class="content-card mb-4">
                <h6 class="fw-bold mb-4">🔄 Update Shipment Status</h6>

                <form method="POST"
                      action="{{ route('driver.deliveries.status', $shipment) }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">New Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="">Select new status</option>

                            @if($shipment->status === 'pickup_pending')
                                <option value="cargo_loaded">📦 Cargo Loaded</option>
                            @endif

                            @if($shipment->status === 'cargo_loaded')
                                <option value="in_transit">🚛 In Transit</option>
                            @endif

                            @if($shipment->status === 'in_transit')
                                <option value="delivered">✅ Delivered</option>
                                <option value="failed">❌ Failed</option>
                            @endif

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Current Location
                        </label>
                        <input type="text" name="current_location"
                               class="form-control"
                               value="{{ $shipment->current_location }}"
                               placeholder="e.g. Nadiad Bypass, Gujarat">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small">
                            Driver Notes
                        </label>
                        <textarea name="driver_notes" rows="3" class="form-control"
                                  placeholder="Any notes about this delivery...">{{ $shipment->driver_notes }}</textarea>
                    </div>

                    <button type="submit"
                            class="btn w-100 fw-bold text-white"
                            style="background:#1d3557;border-radius:10px;padding:12px;">
                        Update Status
                    </button>

                </form>
            </div>

        @else

            <div class="content-card mb-4">
                <div class="text-center py-4">
                    <div style="font-size:3rem;">
                        {{ $shipment->status === 'delivered' ? '✅' : '❌' }}
                    </div>
                    <h6 class="fw-bold mt-3">
                        Delivery {{ ucfirst($shipment->status) }}
                    </h6>
                    @if($shipment->delivery_time)
                        <p class="text-muted small">
                            Completed {{ $shipment->delivery_time->diffForHumans() }}
                        </p>
                    @endif
                </div>
            </div>

        @endif

        {{-- Current status card --}}
        <div class="content-card">
            <h6 class="fw-bold mb-3">📊 Current Status</h6>
            <div class="text-center py-3">
                <span class="status-badge status-{{ $shipment->status }}"
                      style="font-size:.95rem;padding:10px 24px;">
                    {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                </span>
                @if($shipment->current_location)
                    <p class="text-muted small mt-3">
                        📍 {{ $shipment->current_location }}
                    </p>
                @endif
                @if($shipment->driver_notes)
                    <p class="text-muted small">
                        📝 {{ $shipment->driver_notes }}
                    </p>
                @endif
            </div>
            <hr>
            <a href="{{ route('driver.deliveries.index') }}"
               class="btn btn-outline-secondary w-100"
               style="border-radius:10px;">
                ← Back to Deliveries
            </a>
        </div>

    </div>

</div>

@endsection