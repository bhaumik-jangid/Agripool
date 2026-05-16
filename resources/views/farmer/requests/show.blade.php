@extends('layouts.farmer')
@section('title', 'Request Details')
@section('page-title', 'Request #' . $transportRequest->id)
@section('page-subtitle', 'Transport request details')

@section('content')

<div class="row g-4">

    {{-- Main details --}}
    <div class="col-lg-8">
        <div class="content-card">

            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h5 class="fw-bold mb-1">{{ $transportRequest->crop_type }}</h5>
                    <span class="text-muted small">
                        Created {{ $transportRequest->created_at->diffForHumans() }}
                    </span>
                </div>
                <span class="status-badge status-{{ $transportRequest->status }}"
                      style="font-size:.85rem;padding:6px 16px;">
                    {{ ucfirst(str_replace('_', ' ', $transportRequest->status)) }}
                </span>
            </div>

            <div class="row g-3">

                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background:#f8fffe;">
                        <div style="font-size:.75rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Crop Type</div>
                        <div class="fw-semibold mt-1">{{ $transportRequest->crop_type }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background:#f8fffe;">
                        <div style="font-size:.75rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Quantity</div>
                        <div class="fw-semibold mt-1">
                            {{ number_format($transportRequest->quantity_kg) }} kg
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background:#f8fffe;">
                        <div style="font-size:.75rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Packaging</div>
                        <div class="fw-semibold mt-1">{{ $transportRequest->packaging_type }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 rounded-3" style="background:#f8fffe;">
                        <div style="font-size:.75rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Pickup Date</div>
                        <div class="fw-semibold mt-1">
                            {{ $transportRequest->preferred_pickup_date->format('d M Y') }}
                            @if($transportRequest->preferred_pickup_time)
                                at {{ $transportRequest->preferred_pickup_time }}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 rounded-3" style="background:#f8fffe;">
                        <div style="font-size:.75rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Pickup Location</div>
                        <div class="fw-semibold mt-1">
                            {{ $transportRequest->pickup_location }},
                            {{ $transportRequest->pickup_district }},
                            {{ $transportRequest->pickup_state }}
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="p-3 rounded-3" style="background:#f8fffe;">
                        <div style="font-size:.75rem;color:#888;font-weight:600;
                                    text-transform:uppercase;">Destination Market</div>
                        <div class="fw-semibold mt-1">
                            {{ $transportRequest->destination_market }},
                            {{ $transportRequest->destination_district }}
                        </div>
                    </div>
                </div>

                @if($transportRequest->special_instructions)
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background:#fff8e1;">
                            <div style="font-size:.75rem;color:#888;font-weight:600;
                                        text-transform:uppercase;">Special Instructions</div>
                            <div class="mt-1">{{ $transportRequest->special_instructions }}</div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Actions sidebar --}}
    <div class="col-lg-4">
        <div class="content-card">
            <h6 class="fw-bold mb-3">Actions</h6>

            @if($transportRequest->isEditable())
                <a href="{{ route('farmer.requests.edit', $transportRequest) }}"
                   class="btn w-100 mb-2 fw-semibold"
                   style="background:#2d6a4f;color:#fff;border-radius:10px;">
                    ✏️ Edit Request
                </a>

                <form method="POST"
                      action="{{ route('farmer.requests.destroy', $transportRequest) }}"
                      onsubmit="return confirm('Are you sure you want to cancel this request?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-outline-danger w-100"
                            style="border-radius:10px;">
                        ❌ Cancel Request
                    </button>
                </form>
            @else
                <div class="alert rounded-3 small"
                     style="background:#f0faf4;color:#2d6a4f;border:1px solid #c3e6cb;">
                    This request is <strong>{{ $transportRequest->status }}</strong>
                    and cannot be modified.
                </div>
            @endif

            <hr>
            <a href="{{ route('farmer.requests.index') }}"
               class="btn btn-outline-secondary w-100"
               style="border-radius:10px;">
                ← Back to Requests
            </a>
        </div>
    </div>

</div>

@endsection