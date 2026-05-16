@extends('layouts.driver')
@section('title', 'Available Pools')
@section('page-title', 'Available Pools')
@section('page-subtitle', 'Accept a pool to start a delivery')

@section('content')

@if($pools->count() > 0)

    <div class="row g-4">
        @foreach($pools as $pool)

        @php
            $memberCount = $pool->members->count();
            $capacityPct = $pool->total_capacity_kg > 0
                ? ($pool->used_capacity_kg / $pool->total_capacity_kg) * 100
                : 0;
        @endphp

        <div class="col-md-6 col-lg-4">
            <div class="content-card h-100 d-flex flex-column"
                 style="border-top:3px solid #1d3557;">

                {{-- Pool header --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="fw-bold">{{ $pool->destination_market }}</div>
                        <div class="text-muted small">📍 {{ $pool->pickup_region }}</div>
                    </div>
                    <span class="status-badge status-{{ $pool->status }}">
                        {{ ucfirst($pool->status) }}
                    </span>
                </div>

                {{-- Pool info --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">📅 Pickup Date</span>
                        <span class="fw-semibold">
                            {{ $pool->pickup_date->format('d M Y') }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">👨‍🌾 Farmers</span>
                        <span class="fw-semibold">{{ $memberCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">📦 Cargo</span>
                        <span class="fw-semibold">
                            {{ number_format($pool->used_capacity_kg) }} kg
                        </span>
                    </div>

                    @if($pool->total_cost)
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="text-muted">💰 Trip Cost</span>
                            <span class="fw-bold" style="color:#2d6a4f;">
                                ₹{{ number_format($pool->total_cost, 2) }}
                            </span>
                        </div>
                    @endif

                    {{-- Capacity bar --}}
                    <div class="progress" style="height:6px;border-radius:50px;">
                        <div class="progress-bar"
                             style="width:{{ $capacityPct }}%;
                                    background:#1d3557;border-radius:50px;">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-1"
                         style="font-size:.7rem;color:#aaa;">
                        <span>{{ number_format($pool->used_capacity_kg) }} kg loaded</span>
                        <span>{{ number_format($pool->total_capacity_kg) }} kg capacity</span>
                    </div>
                </div>

                {{-- Farmers list --}}
                @if($pool->members->count() > 0)
                    <div class="mb-3 p-2 rounded-3" style="background:#f8fffe;">
                        <div style="font-size:.75rem;font-weight:600;
                                    color:#888;margin-bottom:6px;">
                            FARMERS IN POOL
                        </div>
                        @foreach($pool->members->take(3) as $member)
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div style="width:24px;height:24px;border-radius:50%;
                                    background:#2d6a4f;color:#fff;
                                    display:flex;align-items:center;
                                    justify-content:center;font-size:.7rem;
                                    font-weight:700;">
                                    {{ strtoupper(substr($member->farmer->name ?? 'F', 0, 1)) }}
                                </div>
                                <span style="font-size:.8rem;">
                                    {{ $member->farmer->name ?? 'Farmer' }}
                                </span>
                            </div>
                        @endforeach
                        @if($pool->members->count() > 3)
                            <div style="font-size:.75rem;color:#888;">
                                +{{ $pool->members->count() - 3 }} more farmers
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Accept button --}}
                <div class="mt-auto">
                    <form method="POST"
                          action="{{ route('driver.pools.accept', $pool) }}"
                          onsubmit="return confirm(
                            'Accept this pool? A shipment will be created and
                             farmers will be notified.')">
                        @csrf
                        <button type="submit"
                                class="btn w-100 fw-semibold text-white"
                                style="background:#1d3557;border-radius:10px;">
                            🚛 Accept This Pool
                        </button>
                    </form>
                </div>

            </div>
        </div>

        @endforeach
    </div>

    <div class="mt-4">{{ $pools->links() }}</div>

@else
    <div class="content-card text-center py-5">
        <div style="font-size:4rem;">🤝</div>
        <h5 class="mt-3 fw-bold">No Pools Available</h5>
        <p class="text-muted">
            No pools are ready for pickup in your area right now.
            Check back later or wait for farmers to post requests.
        </p>
    </div>
@endif

@endsection