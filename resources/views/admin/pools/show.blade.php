@extends('layouts.admin')
@section('title', 'Pool: ' . $pool->pool_code)
@section('page-title', $pool->pool_code)
@section('page-subtitle', 'Pool details')

@section('content')

<div class="row g-4">
    <div class="col-lg-5">
        <div class="content-card">
            <h6 class="fw-bold mb-4">Pool Information</h6>
            <div class="small">
                @foreach([
                    'Destination'   => $pool->destination_market,
                    'Pickup Region' => $pool->pickup_region,
                    'Pickup Date'   => $pool->pickup_date->format('d M Y'),
                    'Capacity'      => number_format($pool->used_capacity_kg)
                                       . ' / '
                                       . number_format($pool->total_capacity_kg)
                                       . ' kg',
                    'Total Cost'    => '₹' . number_format($pool->total_cost ?? 0, 2),
                    'Driver'        => $pool->driver->name ?? 'Not assigned',
                ] as $label => $value)
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">{{ $label }}</span>
                        <span class="fw-semibold">{{ $value }}</span>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Status</span>
                    <span class="status-badge status-{{ $pool->status }}">
                        {{ ucfirst($pool->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="content-card">
            <h6 class="fw-bold mb-4">
                👨‍🌾 Farmers in Pool ({{ $pool->members->count() }})
            </h6>
            @foreach($pool->members as $member)
                <div class="d-flex justify-content-between
                            align-items-center p-3 rounded-3 mb-2"
                     style="background:#fafafa;border:1px solid #f0f0f0;">
                    <div>
                        <div class="fw-semibold small">
                            {{ $member->farmer->name ?? '—' }}
                        </div>
                        <div style="font-size:.75rem;color:#888;">
                            {{ $member->transportRequest->crop_type ?? '' }}
                            — {{ number_format(
                                $member->transportRequest->quantity_kg ?? 0) }}kg
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold small" style="color:#2d6a4f;">
                            ₹{{ number_format($member->cost_share ?? 0, 2) }}
                        </div>
                        <div style="font-size:.7rem;color:#aaa;">
                            {{ $member->share_percentage ?? 0 }}% share
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection