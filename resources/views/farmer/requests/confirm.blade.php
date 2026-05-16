@extends('layouts.farmer')
@section('title', 'Pool Match Found!')
@section('page-title', 'Pool Match Found')
@section('page-subtitle', 'Choose how you want to transport your produce')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-9">

    {{-- Match found banner --}}
    <div class="text-center mb-4 p-4 rounded-4"
         style="background:linear-gradient(135deg,#2d6a4f,#52b788);color:#fff;">
        <div style="font-size:2.5rem;">🎉</div>
        <h4 class="fw-bold mt-2 mb-1">A Matching Pool Was Found!</h4>
        <p style="color:rgba(255,255,255,.85);margin:0;">
            Farmers going to <strong>{{ $match['destination'] }}</strong>
            on <strong>{{ $match['pickup_date'] }}</strong> are already in a pool.
            Choose your preferred option below.
        </p>
    </div>

    {{-- Current pool info --}}
    <div class="content-card mb-4">
        <h6 class="fw-bold mb-3" style="color:#2d6a4f;">📦 Current Pool Details</h6>
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="text-center p-3 rounded-3" style="background:#f0faf4;">
                    <div class="fw-bold" style="color:#2d6a4f;font-size:1.3rem;">
                        {{ $match['farmers_count'] }}
                    </div>
                    <div class="text-muted small">Farmers Already In</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center p-3 rounded-3" style="background:#f0faf4;">
                    <div class="fw-bold" style="color:#2d6a4f;font-size:1.3rem;">
                        {{ number_format($match['pool_used_kg']) }} kg
                    </div>
                    <div class="text-muted small">Cargo Already In</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center p-3 rounded-3" style="background:#f0faf4;">
                    <div class="fw-bold" style="color:#2d6a4f;font-size:1.3rem;">
                        {{ number_format($match['farmer_kg']) }} kg
                    </div>
                    <div class="text-muted small">Your Cargo</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="text-center p-3 rounded-3" style="background:#f0faf4;">
                    <div class="fw-bold" style="color:#2d6a4f;font-size:1.3rem;">
                        ₹{{ number_format($match['full_cost'], 0) }}
                    </div>
                    <div class="text-muted small">Full Truck Cost</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Two option cards --}}
    <div class="row g-4 mb-4">

        {{-- Option A: Join Shared Pool --}}
        <div class="col-md-6">
            <div class="h-100 rounded-4 p-4"
                 style="border:2px solid #2d6a4f;background:#fff;
                        box-shadow:0 4px 24px rgba(45,106,79,.1);">

                <div class="text-center mb-3">
                    <div style="font-size:2.5rem;">🤝</div>
                    <h5 class="fw-bold mt-2" style="color:#2d6a4f;">
                        Join Shared Pool
                    </h5>
                    <span class="badge"
                          style="background:#d8f3dc;color:#2d6a4f;
                                 font-size:.8rem;padding:5px 14px;">
                        RECOMMENDED
                    </span>
                </div>

                {{-- Cost breakdown --}}
                <div class="p-3 rounded-3 mb-3"
                     style="background:#f0faf4;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Your space used</span>
                        <span class="fw-semibold small">
                            {{ $match['share_percent'] }}% of truck
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">You pay</span>
                        <span class="fw-bold"
                              style="color:#2d6a4f;font-size:1.1rem;">
                            ₹{{ number_format($match['shared_cost'], 2) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small text-muted">You save</span>
                        <span class="fw-bold text-success">
                            ₹{{ number_format($match['saving'], 2) }}
                        </span>
                    </div>

                    {{-- Visual progress bar --}}
                    <div class="mt-3">
                        <div class="d-flex justify-content-between"
                             style="font-size:.72rem;color:#888;margin-bottom:4px;">
                            <span>Truck space</span>
                            <span>{{ $match['share_percent'] }}% yours</span>
                        </div>
                        <div class="progress" style="height:10px;border-radius:50px;">
                            <div class="progress-bar"
                                 style="width:{{ min($match['pool_used_kg'] / 50, 100) }}%;
                                        background:#aaa;border-radius:50px 0 0 50px;">
                            </div>
                            <div class="progress-bar"
                                 style="width:{{ min($match['share_percent'], 100) }}%;
                                        background:#2d6a4f;border-radius:0 50px 50px 0;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1"
                             style="font-size:.7rem;color:#aaa;">
                            <span>Others: {{ number_format($match['pool_used_kg']) }}kg</span>
                            <span>You: {{ number_format($match['farmer_kg']) }}kg</span>
                        </div>
                    </div>
                </div>

                <ul class="list-unstyled small text-muted mb-4">
                    <li class="mb-1">✅ Pay only for space you use</li>
                    <li class="mb-1">✅ {{ $match['farmers_count'] }} other farmer(s) already confirmed</li>
                    <li class="mb-1">✅ Same destination and date</li>
                    <li class="mb-1">✅ Driver assigned sooner</li>
                </ul>

                <form method="POST"
                      action="{{ route('farmer.requests.processConfirm') }}">
                    @csrf
                    <input type="hidden" name="choice" value="shared">
                    <input type="hidden" name="request_id"
                           value="{{ $match['request_id'] }}">
                    <input type="hidden" name="pool_id"
                           value="{{ $match['pool_id'] }}">
                    <button type="submit"
                            class="btn w-100 py-3 fw-bold text-white"
                            style="background:#2d6a4f;border-radius:12px;
                                   font-size:1rem;">
                        🤝 Join Shared Pool
                        <div style="font-size:.78rem;font-weight:400;opacity:.9;">
                            Pay ₹{{ number_format($match['shared_cost'], 2) }}
                            — Save ₹{{ number_format($match['saving'], 2) }}
                        </div>
                    </button>
                </form>

            </div>
        </div>

        {{-- Option B: Go Solo --}}
        <div class="col-md-6">
            <div class="h-100 rounded-4 p-4"
                 style="border:2px solid #dee2e6;background:#fff;
                        box-shadow:0 4px 24px rgba(0,0,0,.06);">

                <div class="text-center mb-3">
                    <div style="font-size:2.5rem;">🚛</div>
                    <h5 class="fw-bold mt-2 text-dark">Go Solo</h5>
                    <span class="badge"
                          style="background:#f8f9fa;color:#6c757d;
                                 font-size:.8rem;padding:5px 14px;">
                        FULL TRUCK FOR YOU
                    </span>
                </div>

                {{-- Cost breakdown --}}
                <div class="p-3 rounded-3 mb-3"
                     style="background:#f8f9fa;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Truck reserved</span>
                        <span class="fw-semibold small">100% for you</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">You pay</span>
                        <span class="fw-bold text-dark" style="font-size:1.1rem;">
                            ₹{{ number_format($match['full_cost'], 2) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small text-muted">Extra cost vs shared</span>
                        <span class="fw-bold text-danger">
                            +₹{{ number_format($match['saving'], 2) }}
                        </span>
                    </div>

                    {{-- Full truck bar --}}
                    <div class="mt-3">
                        <div class="d-flex justify-content-between"
                             style="font-size:.72rem;color:#888;margin-bottom:4px;">
                            <span>Truck space</span>
                            <span>100% yours</span>
                        </div>
                        <div class="progress" style="height:10px;border-radius:50px;">
                            <div class="progress-bar"
                                 style="width:{{ min(($match['farmer_kg']/5000)*100, 100) }}%;
                                        background:#1d3557;border-radius:50px;">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1"
                             style="font-size:.7rem;color:#aaa;">
                            <span>Your cargo: {{ number_format($match['farmer_kg']) }}kg</span>
                            <span>Truck: 5000kg</span>
                        </div>
                    </div>
                </div>

                <ul class="list-unstyled small text-muted mb-4">
                    <li class="mb-1">✅ Full truck privacy — only your crops</li>
                    <li class="mb-1">✅ No waiting for other farmers</li>
                    <li class="mb-1">✅ Pickup on your exact schedule</li>
                    <li class="mb-1">❌ Pay full truck price</li>
                </ul>

                <form method="POST"
                      action="{{ route('farmer.requests.processConfirm') }}">
                    @csrf
                    <input type="hidden" name="choice" value="solo">
                    <input type="hidden" name="request_id"
                           value="{{ $match['request_id'] }}">
                    <input type="hidden" name="pool_id"
                           value="{{ $match['pool_id'] }}">
                    <button type="submit"
                            class="btn w-100 py-3 fw-bold btn-outline-dark"
                            style="border-radius:12px;font-size:1rem;">
                        🚛 Book Full Truck
                        <div style="font-size:.78rem;font-weight:400;opacity:.8;">
                            Pay ₹{{ number_format($match['full_cost'], 2) }} — Full truck
                        </div>
                    </button>
                </form>

            </div>
        </div>

    </div>

    {{-- Cancel option --}}
    <div class="text-center">
        <form method="POST"
              action="{{ route('farmer.requests.processConfirm') }}"
              onsubmit="return confirm(
                  'Cancel this request? It will be deleted.')">
            @csrf
            <input type="hidden" name="choice" value="solo">
            <input type="hidden" name="request_id"
                   value="{{ $match['request_id'] }}">
            <small class="text-muted">
                Changed your mind?
                <a href="{{ route('farmer.requests.index') }}"
                   class="text-danger text-decoration-none fw-semibold"
                   onclick="return cancelRequest({{ $match['request_id'] }})">
                   Cancel this request
                </a>
            </small>
        </form>
    </div>

</div>
</div>

@endsection

@push('scripts')
<script>
function cancelRequest(id) {
    if (confirm('Are you sure you want to cancel this request?')) {
        fetch('/farmer/requests/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                'Content-Type': 'application/json',
            }
        }).then(() => {
            window.location.href = '/farmer/requests';
        });
    }
    return false;
}
</script>
@endpush