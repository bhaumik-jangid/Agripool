@extends('layouts.farmer')
@section('title', 'Delivery History')
@section('page-title', 'Delivery History')
@section('page-subtitle', 'Your past deliveries and cancelled requests')

@section('content')

<div class="content-card">

    @if($history->count() > 0)

        @foreach($history as $req)
            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 mb-3"
                 style="background:#fafafa;border:1px solid #f0f0f0;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:48px;height:48px;border-radius:12px;
                        background:{{ $req->status == 'delivered' ? '#d8f3dc' : '#f8d7da' }};
                        display:flex;align-items:center;justify-content:center;
                        font-size:1.4rem;">
                        {{ $req->status == 'delivered' ? '✅' : '❌' }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $req->crop_type }}</div>
                        <div class="text-muted small">
                            {{ number_format($req->quantity_kg) }} kg →
                            {{ $req->destination_market }}
                        </div>
                        <div style="font-size:.75rem;color:#aaa;">
                            {{ $req->preferred_pickup_date->format('d M Y') }}
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <span class="status-badge status-{{ $req->status }}">
                        {{ ucfirst($req->status) }}
                    </span>
                    @if($req->actual_cost)
                        <div class="small mt-1 fw-semibold" style="color:#2d6a4f;">
                            ₹{{ number_format($req->actual_cost, 2) }}
                        </div>
                    @endif
                    <a href="{{ route('farmer.requests.show', $req) }}"
                       class="btn btn-sm btn-outline-secondary mt-1"
                       style="border-radius:8px;font-size:.75rem;">
                        View
                    </a>
                </div>
            </div>
        @endforeach

        <div class="mt-3">{{ $history->links() }}</div>

    @else
        <div class="text-center py-5">
            <div style="font-size:4rem;">📦</div>
            <h5 class="mt-3 fw-bold">No Delivery History</h5>
            <p class="text-muted">Your completed and cancelled deliveries will appear here.</p>
        </div>
    @endif

</div>

@endsection