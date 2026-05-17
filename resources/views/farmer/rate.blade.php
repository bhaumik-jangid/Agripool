@extends('layouts.farmer')
@section('title', 'Rate Your Driver')
@section('page-title', 'Rate Your Driver')
@section('page-subtitle', 'Share your experience')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-6">

    {{-- Driver card --}}
    <div class="content-card mb-4 text-center">
        <div style="width:80px;height:80px;border-radius:50%;
            background:#1d3557;color:#fff;
            display:flex;align-items:center;justify-content:center;
            font-size:2rem;font-weight:700;margin:0 auto 16px;">
            {{ strtoupper(substr($shipment->driver->name ?? 'D', 0, 2)) }}
        </div>
        <h5 class="fw-bold mb-1">
            {{ $shipment->driver->name ?? 'Driver' }}
        </h5>
        <div class="text-muted small mb-2">
            Delivered your
            <strong>{{ $myMember->transportRequest->crop_type ?? 'produce' }}</strong>
            to
            <strong>{{ $shipment->pool->destination_market }}</strong>
        </div>
        @if($shipment->delivery_time)
            <div style="font-size:.8rem;color:#aaa;">
                Delivered on
                {{ $shipment->delivery_time->format('d M Y, h:i A') }}
            </div>
        @endif
    </div>

    {{-- Rating form --}}
    <div class="content-card">
        <h6 class="fw-bold mb-4 text-center">
            How was your experience?
        </h6>

        <form method="POST"
              action="{{ route('farmer.rate.store', $shipment) }}">
            @csrf

            {{-- Star rating --}}
            <div class="mb-4 text-center">
                <div style="font-size:.85rem;color:#888;margin-bottom:12px;">
                    Tap a star to rate
                </div>
                <div id="starRating"
                     style="display:flex;justify-content:center;
                            gap:8px;font-size:2.5rem;cursor:pointer;">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star"
                              data-value="{{ $i }}"
                              style="color:#dee2e6;
                                     transition:color .15s,transform .15s;"
                              onmouseover="hoverStar({{ $i }})"
                              onmouseout="resetStars()"
                              onclick="selectStar({{ $i }})">
                            ★
                        </span>
                    @endfor
                </div>
                <input type="hidden"
                       name="rating"
                       id="ratingInput"
                       value="">
                <div id="ratingLabel"
                     class="mt-2 fw-semibold"
                     style="color:#2d6a4f;font-size:.9rem;
                            min-height:24px;">
                </div>
                @error('rating')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Quick tags --}}
            <div class="mb-4">
                <div style="font-size:.82rem;color:#888;margin-bottom:8px;">
                    What went well? (optional, tap to add)
                </div>
                <div class="d-flex flex-wrap gap-2" id="quickTags">
                    @foreach([
                        'On time pickup',
                        'Careful handling',
                        'Good communication',
                        'Clean vehicle',
                        'Professional',
                        'Friendly',
                        'Fast delivery',
                    ] as $tag)
                        <span class="badge rounded-pill"
                              style="background:#f0f0f0;color:#555;
                                     cursor:pointer;padding:7px 14px;
                                     font-size:.8rem;font-weight:500;
                                     transition:all .2s;"
                              onclick="toggleTag(this, '{{ $tag }}')">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Comment --}}
            <div class="mb-4">
                <label class="form-label fw-semibold small">
                    Additional Comments (optional)
                </label>
                <textarea name="comment"
                          id="commentBox"
                          rows="3"
                          class="form-control"
                          placeholder="Tell us more about your experience..."
                          style="border-radius:10px;">{{ old('comment') }}</textarea>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    id="submitBtn"
                    class="btn w-100 py-3 fw-bold text-white"
                    style="background:#2d6a4f;border-radius:12px;
                           font-size:1rem;"
                    disabled>
                Submit Rating
            </button>

            <div class="text-center mt-3">
                <a href="{{ route('farmer.track',
                               $shipment->tracking_code) }}"
                   class="text-muted small text-decoration-none">
                    Skip for now
                </a>
            </div>

        </form>
    </div>

</div>
</div>

@push('scripts')
<script>
const labels = {
    1: '😞 Poor — Not satisfied',
    2: '😐 Fair — Below expectations',
    3: '🙂 Good — Met expectations',
    4: '😊 Very Good — Exceeded expectations',
    5: '🤩 Excellent — Outstanding service!',
};

let selectedRating = 0;
let selectedTags   = [];

function hoverStar(value) {
    document.querySelectorAll('.star').forEach((star, i) => {
        star.style.color     = i < value ? '#f4a261' : '#dee2e6';
        star.style.transform = i < value ? 'scale(1.1)' : 'scale(1)';
    });
}

function resetStars() {
    document.querySelectorAll('.star').forEach((star, i) => {
        star.style.color     = i < selectedRating ? '#f4a261' : '#dee2e6';
        star.style.transform = i < selectedRating ? 'scale(1.1)' : 'scale(1)';
    });
}

function selectStar(value) {
    selectedRating = value;
    document.getElementById('ratingInput').value = value;
    document.getElementById('ratingLabel').textContent = labels[value] || '';
    document.getElementById('submitBtn').disabled = false;
    resetStars();
}

function toggleTag(el, tag) {
    const idx = selectedTags.indexOf(tag);
    if (idx === -1) {
        selectedTags.push(tag);
        el.style.background = '#d8f3dc';
        el.style.color      = '#2d6a4f';
    } else {
        selectedTags.splice(idx, 1);
        el.style.background = '#f0f0f0';
        el.style.color      = '#555';
    }

    // Append selected tags to comment box
    const manualComment = document.getElementById('commentBox')
        .value.split('\n---\n')[0].trim();
    const tagText = selectedTags.length > 0
        ? '\n---\n' + selectedTags.join(', ')
        : '';
    document.getElementById('commentBox').value =
        manualComment + tagText;
}
</script>
@endpush

@endsection