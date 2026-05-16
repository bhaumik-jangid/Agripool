@extends('layouts.farmer')
@section('title', 'My Transport Requests')
@section('page-title', 'My Requests')
@section('page-subtitle', 'Manage all your transport requests')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div></div>
        <a href="{{ route('farmer.requests.create') }}" class="btn fw-semibold text-white px-4"
            style="background:#2d6a4f;border-radius:10px;">
            ➕ New Request
        </a>
    </div>

    <div class="content-card">

        @if($requests->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8fffe;">
                        <tr>
                            <th style="font-size:.8rem;color:#888;font-weight:600;">#</th>
                            <th style="font-size:.8rem;color:#888;font-weight:600;">CROP</th>
                            <th style="font-size:.8rem;color:#888;font-weight:600;">QUANTITY</th>
                            <th style="font-size:.8rem;color:#888;font-weight:600;">DESTINATION</th>
                            <th style="font-size:.8rem;color:#888;font-weight:600;">PICKUP DATE</th>
                            <th style="font-size:.8rem;color:#888;font-weight:600;">STATUS</th>
                            <th style="font-size:.8rem;color:#888;font-weight:600;">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                            <tr>
                                <td style="font-size:.85rem;color:#888;">
                                    #{{ $req->id }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="font-size:1.2rem;">🌾</span>
                                        <div>
                                            <div class="fw-semibold small">{{ $req->crop_type }}</div>
                                            <div style="font-size:.75rem;color:#888;">
                                                {{ $req->packaging_type }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ number_format($req->quantity_kg) }} kg
                                    </span>
                                </td>
                                <td>
                                    <div class="small fw-semibold">{{ $req->destination_market }}</div>
                                    <div style="font-size:.75rem;color:#888;">
                                        {{ $req->destination_district }}
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        {{ $req->preferred_pickup_date->format('d M Y') }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $req->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                    </span>
                                    @if($req->status === 'pooled' && $req->poolMember)
                                        <div style="font-size:.7rem;color:#2d6a4f;margin-top:3px;">
                                            Pool: {{ $req->poolMember->pool->pool_code ?? '' }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('farmer.requests.show', $req) }}" class="btn btn-sm btn-outline-secondary"
                                            style="border-radius:8px;font-size:.75rem;">
                                            View
                                        </a>
                                        @if($req->isEditable())
                                            <a href="{{ route('farmer.requests.edit', $req) }}" class="btn btn-sm btn-outline-primary"
                                                style="border-radius:8px;font-size:.75rem;">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('farmer.requests.destroy', $req) }}"
                                                onsubmit="return confirm('Cancel this request?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    style="border-radius:8px;font-size:.75rem;">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $requests->links() }}
            </div>

        @else
            <div class="text-center py-5">
                <div style="font-size:4rem;">📭</div>
                <h5 class="mt-3 fw-bold">No Requests Yet</h5>
                <p class="text-muted">Create your first transport request to get started.</p>
                <a href="{{ route('farmer.requests.create') }}" class="btn px-4 py-2 fw-semibold text-white"
                    style="background:#2d6a4f;border-radius:10px;">
                    ➕ Create Request
                </a>
            </div>
        @endif

    </div>

@endsection