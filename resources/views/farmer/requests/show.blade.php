@extends('layouts.farmer')
@section('title', 'Request Details')
@section('page-title', 'Request #' . $transportRequest->id)
@section('page-subtitle', 'Transport request details')

@section('content')

    <div class="row g-4">

        {{-- Main details --}}
        <div class="col-lg-8">
            <div class="content-card">

                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">{{ $transportRequest->crop_type }}</h5>
                        <span class="text-muted small">
                            Created {{ $transportRequest->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <span class="status-badge status-{{ $transportRequest->status }}"
                        style="font-size:.85rem;padding:6px 16px;">
                        {{ ucfirst(str_replace('_', ' ', $transportRequest->status)) }}
                    </span>
                </div>

                {{-- Payment section — shown after delivery --}}
                @if($transportRequest->status === 'delivered')
                    @php
                        $poolMember = $transportRequest->poolMember;
                    @endphp
                    @if($poolMember && !$poolMember->cost_paid)
                            <div class="mt-4 p-4 rounded-3" style="background:#fff8e1;border:1px solid #ffe082;">
                                <h6 class="fw-bold mb-3" style="color:#7a5f00;">
                                    💳 Payment Due
                                </h6>
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted">Your share</span>
                                    <span class="fw-bold">
                                        {{ $poolMember->share_percentage }}% of truck
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 small">
                                    <span class="text-muted">Amount to pay</span>
                                    <span class="fw-bold" style="color:#2d6a4f;font-size:1.1rem;">
                                        ₹{{ number_format($poolMember->cost_share, 2) }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route(
                            'farmer.requests.pay',
                            $transportRequest
                        ) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">
                                            Payment Method
                                        </label>
                                        <select name="payment_method" class="form-select form-select-sm">
                                            <option value="Cash">Cash to Driver</option>
                                            <option value="UPI">UPI Transfer</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn w-100 fw-bold text-white"
                                        style="background:#2d6a4f;border-radius:10px;">
                                        ✅ Confirm Payment —
                                        ₹{{ number_format($poolMember->cost_share, 2) }}
                                    </button>
                                </form>
                            </div>
                    @elseif($poolMember && $poolMember->cost_paid)
                        <div class="mt-4 p-3 rounded-3" style="background:#d4edda;border:1px solid #c3e6cb;">
                            <div class="text-center">
                                <span style="font-size:1.5rem;">✅</span>
                                <div class="fw-bold text-success mt-1">Payment Confirmed</div>
                                <div class="small text-muted">
                                    ₹{{ number_format($poolMember->cost_share, 2) }} paid
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8fffe;">
                            <div style="font-size:.75rem;color:#888;font-weight:600;
                                        text-transform:uppercase;">Crop Type</div>
                            <div class="fw-semibold mt-1">{{ $transportRequest->crop_type }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8fffe;">
                            <div style="font-size:.75rem;color:#888;font-weight:600;
                                        text-transform:uppercase;">Quantity</div>
                            <div class="fw-semibold mt-1">
                                {{ number_format($transportRequest->quantity_kg) }} kg
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8fffe;">
                            <div style="font-size:.75rem;color:#888;font-weight:600;
                                        text-transform:uppercase;">Packaging</div>
                            <div class="fw-semibold mt-1">{{ $transportRequest->packaging_type }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background:#f8fffe;">
                            <div style="font-size:.75rem;color:#888;font-weight:600;
                                        text-transform:uppercase;">Pickup Date</div>
                            <div class="fw-semibold mt-1">
                                {{ $transportRequest->preferred_pickup_date->format('d M Y') }}
                                @if($transportRequest->preferred_pickup_time)
                                    at {{ $transportRequest->preferred_pickup_time }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background:#f8fffe;">
                            <div style="font-size:.75rem;color:#888;font-weight:600;
                                        text-transform:uppercase;">Pickup Location</div>
                            <div class="fw-semibold mt-1">
                                {{ $transportRequest->pickup_location }},
                                {{ $transportRequest->pickup_district }},
                                {{ $transportRequest->pickup_state }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background:#f8fffe;">
                            <div style="font-size:.75rem;color:#888;font-weight:600;
                                        text-transform:uppercase;">Destination Market</div>
                            <div class="fw-semibold mt-1">
                                {{ $transportRequest->destination_market }},
                                {{ $transportRequest->destination_district }}
                            </div>
                        </div>
                    </div>

                    @if($transportRequest->special_instructions)
                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background:#fff8e1;">
                                <div style="font-size:.75rem;color:#888;font-weight:600;
                                                text-transform:uppercase;">Special Instructions</div>
                                <div class="mt-1">{{ $transportRequest->special_instructions }}</div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Actions sidebar --}}
        <div class="col-lg-4">
            <div class="content-card">
                <h6 class="fw-bold mb-3">Actions</h6>

                @if($transportRequest->isEditable())
                    <a href="{{ route('farmer.requests.edit', $transportRequest) }}" class="btn w-100 mb-2 fw-semibold"
                        style="background:#2d6a4f;color:#fff;border-radius:10px;">
                        ✏️ Edit Request
                    </a>

                    <form method="POST" action="{{ route('farmer.requests.destroy', $transportRequest) }}"
                        onsubmit="return confirm('Are you sure you want to cancel this request?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100" style="border-radius:10px;">
                            ❌ Cancel Request
                        </button>
                    </form>
                @else
                    <div class="alert rounded-3 small" style="background:#f0faf4;color:#2d6a4f;border:1px solid #c3e6cb;">
                        This request is <strong>{{ $transportRequest->status }}</strong>
                        and cannot be modified.
                    </div>
                @endif

                {{-- Tracking link if shipment exists --}}
                @php
                    $poolMember = $transportRequest->poolMember;
                    $pool       = $poolMember?->pool;
                    $shipment   = $pool?->shipment;
                @endphp

                @if($shipment && in_array($transportRequest->status,
                    ['assigned', 'in_transit', 'cargo_loaded', 'delivered']))
                    <div class="mb-3">
                        <a href="{{ route('farmer.track', $shipment->tracking_code) }}"
                        class="btn w-100 fw-semibold text-white"
                        style="background:#2d6a4f;border-radius:10px;">
                            📍 Track My Shipment
                        </a>
                        <div class="text-center mt-1"
                            style="font-size:.72rem;color:#888;">
                            Tracking: {{ $shipment->tracking_code }}
                        </div>
                    </div>
                @endif

                <hr>
                <a href="{{ route('farmer.requests.index') }}" class="btn btn-outline-secondary w-100"
                    style="border-radius:10px;">
                    ← Back to Requests
                </a>
            </div>
        </div>

    </div>

@endsection