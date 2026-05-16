@extends('layouts.farmer')
@section('title', 'Browse Pools')
@section('page-title', 'Available Pools')
@section('page-subtitle', 'Your request is auto-matched. Browse here to switch to a different pool.')

@section('content')

@if($myPendingRequests->isEmpty())
    <div class="alert rounded-3 mb-4"
         style="background:#fff8e1;border:1px solid #ffe082;color:#7a5f00;">
        ⚠️ You need a <strong>pending transport request</strong> before you can join a pool.
        <a href="{{ route('farmer.requests.create') }}"
           style="color:#2d6a4f;font-weight:600;">Create one now →</a>
    </div>
@endif

@if($pools->count() > 0)

    <div class="row g-4">
        @foreach($pools as $pool)

            @php
                $alreadyJoined = in_array($pool->id, $myPoolIds);
                $capacityPct = $pool->total_capacity_kg > 0
                    ? ($pool->used_capacity_kg / $pool->total_capacity_kg) * 100
                    : 0;
            @endphp

            <div class="col-md-6 col-lg-4">
                <div class="content-card h-100 d-flex flex-column"
                     style="border-top: 3px solid #2d6a4f;">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="fw-bold">{{ $pool->destination_market }}</div>
                            <div class="text-muted small">{{ $pool->pickup_region }}</div>
                        </div>
                        <span class="status-badge status-{{ $pool->status }}">
                            {{ ucfirst($pool->status) }}
                        </span>
                    </div>

                    {{-- Details --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">📅 Pickup Date</span>
                            <span class="fw-semibold">
                                {{ $pool->pickup_date->format('d M Y') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">👨‍🌾 Farmers</span>
                            <span class="fw-semibold">
                                {{ $pool->members()->count() }} / {{ $pool->max_farmers }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">📦 Available Space</span>
                            <span class="fw-semibold">
                                {{ number_format($pool->availableCapacity()) }} kg
                            </span>
                        </div>

                        {{-- Capacity bar --}}
                        <div class="progress" style="height:6px;border-radius:50px;">
                            <div class="progress-bar"
                                 style="width:{{ $capacityPct }}%;
                                        background:#2d6a4f;border-radius:50px;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1"
                             style="font-size:.7rem;color:#aaa;">
                            <span>{{ number_format($pool->used_capacity_kg) }} kg used</span>
                            <span>{{ number_format($pool->total_capacity_kg) }} kg total</span>
                        </div>
                    </div>

                    <div class="mt-auto">

                        @if($alreadyJoined)
                            {{-- Already in pool --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small fw-semibold"
                                      style="color:#2d6a4f;">✅ You've joined</span>
                                <form method="POST"
                                      action="{{ route('farmer.pools.leave', $pool) }}"
                                      onsubmit="return confirm('Leave this pool?')">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger"
                                            style="border-radius:8px;font-size:.78rem;">
                                        Leave Pool
                                    </button>
                                </form>
                            </div>

                        @elseif(!$myPendingRequests->isEmpty() && $pool->isOpen())
                            {{-- Join form --}}
                            <form method="POST"
                                  action="{{ route('farmer.pools.join', $pool) }}">
                                @csrf
                                <div class="mb-2">
                                    <select name="transport_request_id"
                                            class="form-select form-select-sm"
                                            style="border-radius:8px;font-size:.82rem;">
                                        <option value="">Select your request</option>
                                        @foreach($myPendingRequests as $req)
                                            <option value="{{ $req->id }}">
                                                {{ $req->crop_type }} —
                                                {{ number_format($req->quantity_kg) }} kg
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit"
                                        class="btn btn-sm w-100 fw-semibold text-white"
                                        style="background:#2d6a4f;border-radius:8px;">
                                    🤝 Join This Pool
                                </button>
                            </form>

                        @else
                            <button class="btn btn-sm w-100 btn-outline-secondary" disabled
                                    style="border-radius:8px;">
                                Pool Unavailable
                            </button>
                        @endif

                    </div>
                </div>
            </div>

        @endforeach
    </div>

    <div class="mt-4">{{ $pools->links() }}</div>

@else
    <div class="content-card text-center py-5">
        <div style="font-size:4rem;">🤝</div>
        <h5 class="mt-3 fw-bold">No Open Pools Right Now</h5>
        <p class="text-muted">
            No pools are available for your region yet.
            Create a transport request and we'll notify you when a match is found.
        </p>
        <a href="{{ route('farmer.requests.create') }}"
           class="btn px-4 py-2 fw-semibold text-white"
           style="background:#2d6a4f;border-radius:10px;">
            ➕ Create Transport Request
        </a>
    </div>
@endif

@endsection