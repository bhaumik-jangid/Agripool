@extends('layouts.admin')
@section('title', 'Shipments')
@section('page-title', 'Shipments')
@section('page-subtitle', 'All delivery shipments')

@section('content')

<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        TRACKING CODE
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        DESTINATION
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        DRIVER
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        STATUS
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        CREATED
                    </th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">
                        ACTION
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipments as $shipment)
                    <tr>
                        <td class="fw-bold small" style="color:#1d3557;">
                            {{ $shipment->tracking_code }}
                        </td>
                        <td class="small">
                            {{ $shipment->pool->destination_market ?? '—' }}
                        </td>
                        <td class="small fw-semibold">
                            {{ $shipment->driver->name ?? '—' }}
                        </td>
                        <td>
                            <span class="status-badge
                                  status-{{ $shipment->status }}">
                                {{ ucfirst(str_replace(
                                    '_',' ',$shipment->status)) }}
                            </span>
                        </td>
                        <td class="small text-muted">
                            {{ $shipment->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.shipments.show',
                                           $shipment) }}"
                               class="btn btn-sm btn-outline-secondary"
                               style="border-radius:8px;font-size:.75rem;">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $shipments->links() }}</div>
</div>

@endsection