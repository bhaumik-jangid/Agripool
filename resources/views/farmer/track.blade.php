@extends('layouts.farmer')
@section('title', 'Track Shipment')
@section('page-title', 'Shipment Tracking')
@section('page-subtitle', $shipment->tracking_code)

@section('content')

<div class="row g-4">

    {{-- Left: Timeline --}}
    <div class="col-lg-7">
        <div class="content-card">

            {{-- Header --}}
            <div class="d-flex align-items-center
                        justify-content-between mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Live Shipment Status</h5>
                    <div style="font-size:.85rem;color:#888;">
                        Tracking code:
                        <strong style="color:#2d6a4f;">
                            {{ $shipment->tracking_code }}
                        </strong>
                    </div>
                </div>
                <span class="status-badge status-{{ $shipment->status }}"
                      style="font-size:.85rem;padding:8px 18px;">
                    {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                </span>
            </div>

            {{-- Visual Timeline --}}
            <div class="position-relative ps-4 mb-4">

                {{-- Vertical line --}}
                <div style="position:absolute;left:19px;top:0;bottom:0;
                            width:2px;background:#e0e0e0;z-index:0;">
                </div>

                @foreach($timeline as $index => $step)
                    <div class="position-relative mb-4
                                {{ !$loop->last ? 'pb-2' : '' }}">

                        {{-- Step dot --}}
                        <div style="position:absolute;left:-24px;top:0;
                                    width:32px;height:32px;border-radius:50%;
                                    border:3px solid
                                    {{ $step['done']
                                       ? '#2d6a4f' : '#dee2e6' }};
                                    background:
                                    {{ $step['done']
                                       ? '#2d6a4f' : '#fff' }};
                                    display:flex;align-items:center;
                                    justify-content:center;
                                    z-index:1;font-size:.85rem;">
                            @if($step['done'])
                                <span style="color:#fff;font-size:.75rem;">
                                    ✓
                                </span>
                            @else
                                <span style="font-size:.75rem;">
                                    {{ $index + 1 }}
                                </span>
                            @endif
                        </div>

                        {{-- Step content --}}
                        <div class="ps-3 py-1">
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-size:1.2rem;">
                                    {{ $step['icon'] }}
                                </span>
                                <span class="fw-bold"
                                      style="color:{{ $step['done']
                                          ? '#2d6a4f'
                                          : ($step['active']
                                             ? '#1d3557' : '#aaa') }}">
                                    {{ $step['label'] }}
                                </span>
                                @if($step['active']
                                    && $shipment->status !== 'delivered')
                                    <span class="badge"
                                          style="background:#fff3cd;
                                                 color:#856404;
                                                 font-size:.7rem;">
                                        CURRENT
                                    </span>
                                @endif
                            </div>
                            <div style="font-size:.82rem;
                                        color:{{ $step['done']
                                            ? '#555' : '#aaa' }};
                                        margin-top:2px;">
                                {{ $step['description'] }}
                            </div>
                            @if($step['time'])
                                <div style="font-size:.72rem;
                                            color:#2d6a4f;margin-top:3px;">
                                    🕐 {{ $step['time']->format('d M Y, h:i A') }}
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach

            </div>

            {{-- Current location --}}
            @if($shipment->current_location
                && $shipment->status !== 'delivered')
                <div class="p-3 rounded-3"
                     style="background:#f0faf4;
                            border:1px solid #c3e6cb;">
                    <div style="font-size:.75rem;font-weight:700;
                                color:#2d6a4f;margin-bottom:4px;">
                        📍 LAST KNOWN LOCATION
                    </div>
                    <div class="fw-semibold">
                        {{ $shipment->current_location }}
                    </div>
                    <div style="font-size:.72rem;color:#888;margin-top:2px;">
                        Updated {{ $shipment->updated_at->diffForHumans() }}
                    </div>
                </div>
            @endif

            {{-- Delivery note --}}
            @if($shipment->status === 'delivered')
                <div class="p-4 rounded-3 text-center"
                     style="background:linear-gradient(
                                135deg,#2d6a4f,#52b788);
                            color:#fff;">
                    <div style="font-size:2.5rem;">🎉</div>
                    <h5 class="fw-bold mt-2 mb-1">Delivery Complete!</h5>
                    <p style="color:rgba(255,255,255,.85);font-size:.9rem;
                               margin:0;">
                        Your produce was successfully delivered
                        @if($shipment->delivery_time)
                            on
                            {{ $shipment->delivery_time->format('d M Y') }}
                            at
                            {{ $shipment->delivery_time->format('h:i A') }}
                        @endif
                    </p>
                </div>
            @endif

            {{-- Driver notes --}}
            @if($shipment->driver_notes)
                <div class="mt-3 p-3 rounded-3"
                     style="background:#f8f9fa;">
                    <div style="font-size:.75rem;font-weight:700;
                                color:#888;margin-bottom:4px;">
                        DRIVER NOTE
                    </div>
                    <div class="small text-muted">
                        "{{ $shipment->driver_notes }}"
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Right: Shipment details --}}
    <div class="col-lg-5">

        {{-- Driver info --}}
        <div class="content-card mb-4">
            <h6 class="fw-bold mb-3">🚛 Your Driver</h6>

            @if($shipment->driver)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:52px;height:52px;border-radius:50%;
                        background:#1d3557;color:#fff;
                        display:flex;align-items:center;
                        justify-content:center;font-size:1.2rem;
                        font-weight:700;">
                        {{ strtoupper(substr(
                            $shipment->driver->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="fw-bold">
                            {{ $shipment->driver->name }}
                        </div>
                        <div class="text-muted small">
                            📞 {{ $shipment->driver->phone ?? 'N/A' }}
                        </div>
                        @if($shipment->driver->driverProfile)
                            <div style="color:#f4a261;font-size:.82rem;">
                                ⭐
                                {{ number_format(
                                    $shipment->driver->driverProfile->rating,
                                    1) }}
                                rating
                            </div>
                        @endif
                    </div>
                </div>

                @if($shipment->driver->vehicle)
                    <div class="p-2 rounded-3"
                         style="background:#f0f6fb;font-size:.82rem;">
                        🚛 {{ $shipment->driver->vehicle->vehicle_type }}
                        · {{ $shipment->driver->vehicle->vehicle_number }}
                        · {{ $shipment->driver->vehicle->capacity_tonnes }}t
                    </div>
                @endif
            @endif
        </div>

        {{-- My cargo info --}}
        @if($myMember)
            <div class="content-card mb-4">
                <h6 class="fw-bold mb-3">🌾 Your Cargo</h6>
                <div class="small">
                    @php $myReq = $myMember->transportRequest; @endphp
                    @if($myReq)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Crop</span>
                            <span class="fw-semibold">
                                {{ $myReq->crop_type }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Quantity</span>
                            <span class="fw-semibold">
                                {{ number_format($myReq->quantity_kg) }} kg
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Packaging</span>
                            <span class="fw-semibold">
                                {{ $myReq->packaging_type }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Destination</span>
                            <span class="fw-semibold">
                                {{ $myReq->destination_market }}
                            </span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2"
                         style="border-top:1px solid #f0f0f0;padding-top:8px;
                                margin-top:8px;">
                        <span class="text-muted">Your share</span>
                        <span class="fw-bold" style="color:#2d6a4f;">
                            {{ $myMember->share_percentage }}%
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Your cost</span>
                        <span class="fw-bold" style="color:#2d6a4f;">
                            ₹{{ number_format($myMember->cost_share ?? 0, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        @endif

        {{-- All farmers in pool --}}
        <div class="content-card mb-4">
            <h6 class="fw-bold mb-3">
                👨‍🌾 Pool Members
                ({{ $shipment->pool->members->count() }})
            </h6>
            @foreach($shipment->pool->members as $member)
                <div class="d-flex align-items-center
                            justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;
                            background:#d8f3dc;color:#2d6a4f;
                            display:flex;align-items:center;
                            justify-content:center;font-size:.7rem;
                            font-weight:700;">
                            {{ strtoupper(substr(
                                $member->farmer->name ?? 'F', 0, 2)) }}
                        </div>
                        <div>
                            <div style="font-size:.82rem;font-weight:600;">
                                {{ $member->farmer->name ?? 'Farmer' }}
                                @if($member->user_id === Auth::id())
                                    <span style="font-size:.68rem;
                                                 color:#2d6a4f;">(You)</span>
                                @endif
                            </div>
                            <div style="font-size:.72rem;color:#888;">
                                {{ $member->transportRequest->crop_type ?? '' }}
                                — {{ number_format(
                                    $member->transportRequest->quantity_kg
                                    ?? 0) }}kg
                            </div>
                        </div>
                    </div>
                    <div style="font-size:.78rem;font-weight:600;
                                color:#2d6a4f;">
                        ₹{{ number_format($member->cost_share ?? 0, 0) }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Rate driver button — shown after delivery --}}
        @if($shipment->status === 'delivered' && $myMember)
            <div class="content-card"
                 style="border:2px solid #2d6a4f;">
                <h6 class="fw-bold mb-1">⭐ Rate Your Driver</h6>
                <p class="text-muted small mb-3">
                    How was your experience with
                    {{ $shipment->driver->name }}?
                </p>
                <a href="{{ route('farmer.rate',
                               $shipment->id) }}"
                   class="btn w-100 fw-bold text-white"
                   style="background:#2d6a4f;border-radius:10px;">
                    ⭐ Rate This Delivery
                </a>
            </div>
        @endif

        {{-- Back button --}}
        <a href="{{ route('farmer.history') }}"
           class="btn btn-outline-secondary w-100 mt-3"
           style="border-radius:10px;">
            ← Back to History
        </a>

    </div>

</div>

{{-- Auto refresh every 60 seconds when shipment is active --}}
@if(!in_array($shipment->status, ['delivered', 'failed']))
    @push('scripts')
    <script>
        // Auto-refresh page every 60 seconds to get live updates
        setTimeout(function() {
            window.location.reload();
        }, 60000);

        // Show countdown
        let seconds = 60;
        const counter = document.getElementById('refreshCounter');
        if (counter) {
            setInterval(function() {
                seconds--;
                counter.textContent = seconds;
                if (seconds <= 0) seconds = 60;
            }, 1000);
        }
    </script>
    @endpush

    <div class="text-center mt-3">
        <small class="text-muted">
            🔄 Page auto-refreshes in
            <span id="refreshCounter">60</span> seconds
        </small>
    </div>
@endif

@endsection