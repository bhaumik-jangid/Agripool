@extends('layouts.admin')
@section('title', 'Transport Requests')
@section('page-title', 'Transport Requests')
@section('page-subtitle', 'All farmer transport requests')

@section('content')

{{-- Count tabs --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    @foreach($counts as $key => $count)
        <span class="badge px-3 py-2"
              style="background:#fff;border:1px solid #dee2e6;
                     color:#555;font-size:.82rem;border-radius:50px;">
            {{ ucfirst($key) }}: <strong>{{ $count }}</strong>
        </span>
    @endforeach
</div>

<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">#</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">FARMER</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">CROP</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">DESTINATION</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">DATE</th>
                    <th style="font-size:.78rem;color:#888;font-weight:600;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                    <tr>
                        <td class="text-muted small">{{ $req->id }}</td>
                        <td class="small fw-semibold">
                            {{ $req->farmer->name ?? '—' }}
                        </td>
                        <td>
                            <div class="fw-semibold small">
                                {{ $req->crop_type }}
                            </div>
                            <div style="font-size:.72rem;color:#888;">
                                {{ number_format($req->quantity_kg) }}kg
                            </div>
                        </td>
                        <td class="small">{{ $req->destination_market }}</td>
                        <td class="small text-muted">
                            {{ $req->preferred_pickup_date->format('d M Y') }}
                        </td>
                        <td>
                            <span class="status-badge status-{{ $req->status }}">
                                {{ ucfirst(str_replace('_',' ',$req->status)) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $requests->links() }}</div>
</div>

@endsection