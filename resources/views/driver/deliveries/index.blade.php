@extends('layouts.driver')
@section('title', 'My Deliveries')
@section('page-title', 'My Deliveries')
@section('page-subtitle', 'All your accepted and completed deliveries')

@section('content')

<div class="content-card">

    @if($shipments->count() > 0)

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f0f6fb;">
                    <tr>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">TRACKING CODE</th>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">DESTINATION</th>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">PICKUP DATE</th>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">FARMERS</th>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">STATUS</th>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shipments as $shipment)
                        <tr>
                            <td>
                                <span class="fw-bold" style="color:#1d3557;font-size:.9rem;">
                                    {{ $shipment->tracking_code }}
                                </span>
                            </td>
                            <td class="small fw-semibold">
                                {{ $shipment->pool->destination_market ?? 'N/A' }}
                            </td>
                            <td class="small">
                                {{ $shipment->pool->pickup_date->format('d M Y') ?? 'N/A' }}
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $shipment->pool->members->count() ?? 0 }} farmers
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $shipment->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('driver.deliveries.show', $shipment) }}"
                                   class="btn btn-sm text-white"
                                   style="background:#1d3557;border-radius:8px;font-size:.78rem;">
                                    Manage
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $shipments->links() }}</div>

    @else
        <div class="text-center py-5">
            <div style="font-size:4rem;">📭</div>
            <h5 class="mt-3 fw-bold">No Deliveries Yet</h5>
            <p class="text-muted">Accept a pool to start your first delivery.</p>
            <a href="{{ route('driver.pools.index') }}"
               class="btn text-white px-4 fw-semibold"
               style="background:#1d3557;border-radius:10px;">
                Browse Pools
            </a>
        </div>
    @endif

</div>

@endsection