@extends('layouts.admin')
@section('title', 'Shipment: ' . $shipment->tracking_code)
@section('page-title', $shipment->tracking_code)
@section('page-subtitle', 'Shipment details')

@section('content')

<div class="row g-4">
    <div class="col-lg-5">
        <div class="content-card">
            <h6 class="fw-bold mb-4">Shipment Information</h6>
            <div class="small">
                @foreach([
                    'Tracking Code' => $shipment->tracking_code,
                    'Driver'        => $shipment->driver->name ?? '—',
                    'Destination'   => $shipment->pool->destination_market ?? '—',
                    'Pickup Time'   => $shipment->pickup_time
                                       ? $shipment->pickup_time->format('d M Y H:i')
                                       : 'Not yet',
                    'Delivery Time' => $shipment->delivery_time
                                       ? $shipment->delivery_time->format('d M Y H:i')
                                       : 'Not yet',
                    'Location'      => $shipment->current_location ?? '—',
                ] as $label => $value)
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">{{ $label }}</span>
                        <span class="fw-semibold">{{ $value }}</span>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Status</span>
                    <span class="status-badge status-{{ $shipment->status }}">
                        {{ ucfirst(str_replace('_',' ',$shipment->status)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="content-card">
            <h6 class="fw-bold mb-4">Farmers in This Shipment</h6>
            @foreach($shipment->pool->members as $member)
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
                    <span class="status-badge
                          status-{{ $member->transportRequest->status ?? 'pending' }}">
                        {{ ucfirst(str_replace('_',' ',
                            $member->transportRequest->status ?? '—')) }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection