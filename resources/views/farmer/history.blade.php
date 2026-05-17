@extends('layouts.farmer')
@section('title', 'Delivery History')
@section('page-title', 'Delivery History')
@section('page-subtitle', 'Your completed and cancelled deliveries')

@section('content')

<div class="content-card">

    @if($history->count() > 0)

        @foreach($history as $req)
            @php
                $shipment = $req->poolMember?->pool?->shipment;
                $driver   = $req->poolMember?->pool?->driver;
                $member   = $req->poolMember;
            @endphp

            <div class="p-4 rounded-3 mb-3"
                 style="background:#fafafa;border:1px solid #f0f0f0;">

                <div class="d-flex align-items-start
                            justify-content-between gap-3">

                    {{-- Left: Delivery info --}}
                    <div class="d-flex align-items-start gap-3 flex-grow-1">
                        <div style="width:48px;height:48px;border-radius:12px;
                            background:{{ $req->status === 'delivered'
                                ? '#d8f3dc' : '#f8d7da' }};
                            display:flex;align-items:center;
                            justify-content:center;font-size:1.4rem;
                            flex-shrink:0;">
                            {{ $req->status === 'delivered' ? '✅' : '❌' }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $req->crop_type }}</div>
                            <div class="text-muted small">
                                {{ number_format($req->quantity_kg) }} kg
                                → {{ $req->destination_market }}
                            </div>
                            <div style="font-size:.75rem;color:#aaa;margin-top:2px;">
                                📅 {{ $req->preferred_pickup_date->format('d M Y') }}
                                @if($driver)
                                    · 🚛 {{ $driver->name }}
                                @endif
                            </div>

                            {{-- Cost info --}}
                            @if($member && $member->cost_share)
                                <div class="mt-2 d-flex gap-3"
                                     style="font-size:.78rem;">
                                    <span style="color:#2d6a4f;">
                                        💰 Your share:
                                        <strong>
                                            ₹{{ number_format($member->cost_share, 2) }}
                                        </strong>
                                    </span>
                                    <span class="{{ $member->cost_paid
                                        ? 'text-success' : 'text-danger' }}">
                                        {{ $member->cost_paid
                                           ? '✅ Paid' : '⏳ Payment pending' }}
                                    </span>
                                </div>
                            @endif

                            {{-- Tracking code --}}
                            @if($shipment)
                                <div class="mt-1"
                                     style="font-size:.72rem;color:#aaa;">
                                    🔍 {{ $shipment->tracking_code }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Right: Actions --}}
                    <div class="d-flex flex-column gap-2 flex-shrink-0">
                        <span class="status-badge status-{{ $req->status }}">
                            {{ ucfirst($req->status) }}
                        </span>

                        <a href="{{ route('farmer.requests.show', $req) }}"
                           class="btn btn-sm btn-outline-secondary"
                           style="border-radius:8px;font-size:.75rem;">
                            View
                        </a>

                        @if($shipment && $req->status === 'delivered')
                            <a href="{{ route('farmer.track',
                                           $shipment->tracking_code) }}"
                               class="btn btn-sm"
                               style="background:#2d6a4f;color:#fff;
                                      border-radius:8px;font-size:.75rem;">
                                📍 Track
                            </a>
                        @endif
                    </div>

                </div>

            </div>
        @endforeach

        <div class="mt-3">{{ $history->links() }}</div>

    @else
        <div class="text-center py-5">
            <div style="font-size:4rem;">📦</div>
            <h5 class="mt-3 fw-bold">No Delivery History</h5>
            <p class="text-muted">
                Completed and cancelled deliveries appear here.
            </p>
        </div>
    @endif

</div>

@endsection