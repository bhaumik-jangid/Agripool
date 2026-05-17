@extends('layouts.farmer')
@section('title', 'Browse Pools')
@section('page-title', 'Available Pools')
@section('page-subtitle', 'Find a pool to share transport costs')

@section('content')

@if($myPendingRequests->isEmpty())
    <div class="alert rounded-3 mb-4"
         style="background:#fff8e1;border:1px solid #ffe082;color:#7a5f00;">
        ⚠️ You need a <strong>pending transport request</strong>
        before joining a pool.
        <a href="{{ route('farmer.requests.create') }}"
           style="color:#2d6a4f;font-weight:600;">Create one →</a>
    </div>
@endif

@if($pools->count() > 0)

    <div class="row g-4">
        @foreach($pools as $pool)

        @php
            $alreadyJoined = in_array($pool->id, $myPoolIds);
            $usedPct = $pool->total_capacity_kg > 0
                ? ($pool->used_capacity_kg / $pool->total_capacity_kg) * 100
                : 0;

            // Collect crops already in this pool
            $cropsInPool = $pool->members->map(function($m) {
                return $m->transportRequest;
            })->filter();
        @endphp

        <div class="col-md-6 col-lg-4">
            <div class="content-card h-100 d-flex flex-column"
                 style="border-top:3px solid #2d6a4f;">

                {{-- Header --}}
                <div class="d-flex justify-content-between
                            align-items-start mb-3">
                    <div>
                        <div class="fw-bold">
                            {{ $pool->destination_market }}
                        </div>
                        <div class="text-muted small">
                            📍 From {{ $pool->pickup_region }}
                        </div>
                    </div>
                    <span class="status-badge status-{{ $pool->status }}">
                        {{ ucfirst($pool->status) }}
                    </span>
                </div>

                {{-- Key info --}}
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
                            {{ $pool->members->count() }}
                            / {{ $pool->max_farmers }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">📦 Space Left</span>
                        <span class="fw-semibold">
                            {{ number_format($pool->availableCapacity()) }} kg
                        </span>
                    </div>

                    {{-- PRICE — full cost + farmer's individual estimate --}}
                    <div class="mb-2">
                        {{-- Full truck cost --}}
                        <div class="d-flex justify-content-between align-items-center
                                    p-2 rounded-3 mb-1"
                            style="background:#f8fafc;border:1px solid #e2e8f0;">
                            <span style="font-size:.72rem;color:#94a3b8;font-weight:500;">
                                Full Truck Cost
                            </span>
                            <span style="font-size:.85rem;font-weight:700;color:#64748b;">
                                ₹{{ number_format($pool->total_cost ?? 0, 0) }}
                            </span>
                        </div>

                        {{-- Farmer's estimated share --}}
                        @if($myPendingRequests->isNotEmpty())
                            @foreach($myPendingRequests->take(1) as $myReq)
                                @php
                                    $newUsed   = $pool->used_capacity_kg + $myReq->quantity_kg;
                                    $myPct     = $newUsed > 0
                                        ? ($myReq->quantity_kg / $newUsed) * 100 : 0;
                                    $myCost    = ($myPct / 100) * ($pool->total_cost ?? 0);
                                    $fits      = $pool->availableCapacity() >= $myReq->quantity_kg;
                                @endphp
                                @if($fits)
                                    <div class="p-2 rounded-3 text-center"
                                        style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);
                                                border:1px solid #86efac;">
                                        <div style="font-size:.68rem;color:#14532d;
                                                    font-weight:600;text-transform:uppercase;
                                                    letter-spacing:.05em;">
                                            You Pay (estimated)
                                        </div>
                                        <div style="font-size:1.3rem;font-weight:800;
                                                    color:#15803d;letter-spacing:-.5px;">
                                            ₹{{ number_format($myCost, 0) }}
                                        </div>
                                        <div style="font-size:.68rem;color:#16a34a;">
                                            {{ round($myPct, 1) }}% of truck
                                            · {{ number_format($myReq->quantity_kg) }}kg
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    {{-- Capacity bar --}}
                    <div class="progress"
                         style="height:6px;border-radius:50px;">
                        <div class="progress-bar"
                             style="width:{{ $usedPct }}%;
                                    background:#2d6a4f;
                                    border-radius:50px;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-1"
                         style="font-size:.7rem;color:#aaa;">
                        <span>
                            {{ number_format($pool->used_capacity_kg) }}kg used
                        </span>
                        <span>
                            {{ number_format($pool->total_capacity_kg) }}kg total
                        </span>
                    </div>
                </div>

                {{-- CROPS BEING TRANSPORTED — key feature --}}
                @if($cropsInPool->count() > 0)
                    <div class="mb-3 p-3 rounded-3"
                         style="background:#fafafa;border:1px solid #f0f0f0;">
                        <div style="font-size:.72rem;font-weight:700;
                                    color:#888;margin-bottom:8px;
                                    text-transform:uppercase;">
                            🌾 Crops in This Pool
                        </div>
                        @foreach($cropsInPool as $req)
                            <div class="d-flex align-items-center
                                        justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:28px;height:28px;
                                        border-radius:8px;background:#d8f3dc;
                                        display:flex;align-items:center;
                                        justify-content:center;font-size:.85rem;">
                                        🌾
                                    </div>
                                    <div>
                                        <div style="font-size:.82rem;
                                                    font-weight:600;">
                                            {{ $req->crop_type }}
                                        </div>
                                        <div style="font-size:.7rem;
                                                    color:#888;">
                                            {{ $req->packaging_type }}
                                        </div>
                                    </div>
                                </div>
                                <span style="font-size:.78rem;
                                             font-weight:600;
                                             color:#2d6a4f;">
                                    {{ number_format($req->quantity_kg) }}kg
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Your estimated cost if you join --}}
                @if(!$alreadyJoined && $myPendingRequests->isNotEmpty())
                    <div class="mb-3 p-2 rounded-3"
                         style="background:#fff8e1;border:1px solid #ffe082;">
                        <div style="font-size:.72rem;color:#7a5f00;
                                    font-weight:600;">
                            💰 Your estimated cost if you join:
                        </div>
                        @foreach($myPendingRequests as $myReq)
                            @php
                                $newUsed = $pool->used_capacity_kg
                                           + $myReq->quantity_kg;
                                $myShare = $newUsed > 0
                                    ? ($myReq->quantity_kg / $newUsed) * 100
                                    : 0;
                                $myCost = ($myShare / 100)
                                          * ($pool->total_cost ?? 0);
                                $fits = $pool->availableCapacity()
                                        >= $myReq->quantity_kg;
                            @endphp
                            <div class="d-flex justify-content-between
                                        align-items-center mt-1"
                                 style="font-size:.78rem;">
                                <span style="color:#555;">
                                    {{ $myReq->crop_type }}
                                    ({{ number_format($myReq->quantity_kg) }}kg)
                                </span>
                                @if($fits)
                                    <span class="fw-bold"
                                          style="color:#2d6a4f;">
                                        ₹{{ number_format($myCost, 0) }}
                                    </span>
                                @else
                                    <span class="text-danger"
                                          style="font-size:.72rem;">
                                        ❌ Not enough space
                                        ({{ number_format($pool->availableCapacity()) }}kg left)
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Action --}}
                <div class="mt-auto">

                    @if($alreadyJoined)
                        <div class="d-flex justify-content-between
                                    align-items-center">
                            <span class="small fw-semibold"
                                  style="color:#2d6a4f;">
                                ✅ You are in this pool
                            </span>
                            <form method="POST"
                                  action="{{ route('farmer.pools.leave',
                                                 $pool) }}"
                                  onsubmit="return confirm(
                                      'Leave this pool?')">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger"
                                        style="border-radius:8px;
                                               font-size:.78rem;">
                                    Leave Pool
                                </button>
                            </form>
                        </div>

                    @elseif(!$myPendingRequests->isEmpty()
                            && $pool->isOpen())

                        {{-- Check if any pending request fits --}}
                        @php
                            $fittingRequests = $myPendingRequests->filter(
                                fn($r) => $pool->availableCapacity()
                                          >= $r->quantity_kg
                            );
                        @endphp

                        @if($fittingRequests->isNotEmpty())
                            <form method="POST"
                                  action="{{ route('farmer.pools.join',
                                                 $pool) }}">
                                @csrf
                                <div class="mb-2">
                                    <select name="transport_request_id"
                                            class="form-select form-select-sm"
                                            style="border-radius:8px;
                                                   font-size:.82rem;">
                                        <option value="">
                                            Select your request to join
                                        </option>
                                        @foreach($fittingRequests as $req)
                                            <option value="{{ $req->id }}">
                                                {{ $req->crop_type }}
                                                — {{ number_format($req->quantity_kg) }}kg
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit"
                                        class="btn w-100 fw-semibold
                                               text-white"
                                        style="background:#2d6a4f;
                                               border-radius:10px;">
                                    🤝 Join This Pool
                                </button>
                            </form>
                        @else
                            <div class="text-center p-2 rounded-3"
                                 style="background:#f8d7da;">
                                <div style="font-size:.8rem;color:#721c24;">
                                    ❌ Your cargo is too large for this pool
                                </div>
                                <div style="font-size:.72rem;color:#721c24;">
                                    Only
                                    {{ number_format($pool->availableCapacity()) }}kg
                                    space left
                                </div>
                            </div>
                        @endif

                    @else
                        <button class="btn btn-sm w-100
                                       btn-outline-secondary"
                                disabled style="border-radius:8px;">
                            {{ $pool->isOpen()
                               ? 'No pending requests to join with'
                               : 'Pool not accepting members' }}
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
            No pools available in your area yet.
            Create a transport request and we will find or create one for you.
        </p>
        <a href="{{ route('farmer.requests.create') }}"
           class="btn px-4 py-2 fw-semibold text-white"
           style="background:#2d6a4f;border-radius:10px;">
            ➕ Create Transport Request
        </a>
    </div>
@endif

@endsection