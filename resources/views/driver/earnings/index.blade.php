@extends('layouts.driver')
@section('title', 'My Earnings')
@section('page-title', 'Earnings')
@section('page-subtitle', 'Your payment history')

@section('content')

{{-- Summary cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="stat-card text-center">
            <div style="font-size:2rem;">✅</div>
            <div class="stat-num text-success mt-2">
                ₹{{ number_format($totalPaid, 2) }}
            </div>
            <div class="text-muted small mt-1">Total Paid</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card text-center">
            <div style="font-size:2rem;">⏳</div>
            <div class="stat-num mt-2" style="color:#e63946;">
                ₹{{ number_format($totalPending, 2) }}
            </div>
            <div class="text-muted small mt-1">Pending Payment</div>
        </div>
    </div>
</div>

<div class="content-card">

    @if($earnings->count() > 0)

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f0f6fb;">
                    <tr>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">
                            SHIPMENT
                        </th>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">
                            DESTINATION
                        </th>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">
                            AMOUNT
                        </th>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">
                            STATUS
                        </th>
                        <th style="font-size:.8rem;color:#888;font-weight:600;">
                            DATE
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($earnings as $earning)
                        <tr>
                            <td>
                                <span class="fw-semibold small" style="color:#1d3557;">
                                    {{ $earning->shipment->tracking_code ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="small">
                                {{ $earning->shipment->pool->destination_market ?? 'N/A' }}
                            </td>
                            <td>
                                <span class="fw-bold" style="color:#2d6a4f;">
                                    ₹{{ number_format($earning->amount, 2) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $earning->status === 'paid'
                                    ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($earning->status) }}
                                </span>
                            </td>
                            <td class="small text-muted">
                                {{ $earning->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $earnings->links() }}</div>

    @else
        <div class="text-center py-5">
            <div style="font-size:4rem;">💰</div>
            <h5 class="mt-3 fw-bold">No Earnings Yet</h5>
            <p class="text-muted">Complete deliveries to start earning.</p>
        </div>
    @endif

</div>

@endsection