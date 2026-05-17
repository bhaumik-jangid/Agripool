@extends('layouts.farmer')
@section('title', 'New Transport Request')
@section('page-title', 'New Transport Request')
@section('page-subtitle', 'Fill in your crop transport details')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="content-card">

    <form method="POST" action="{{ route('farmer.requests.store') }}">
        @csrf

        {{-- ── SECTION 1: Crop Details ───────────────────────── --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-semibold mb-3"
                style="color:#2d6a4f;font-size:.85rem;
                       text-transform:uppercase;letter-spacing:.06em;">
                Crop Details
            </h6>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Crop Type *
                    </label>
                    <select name="crop_type"
                            class="form-select
                                   @error('crop_type') is-invalid @enderror">
                        <option value="">Select crop</option>
                        @foreach([
                            'Wheat','Rice','Cotton','Sugarcane',
                            'Maize','Soybean','Groundnut','Onion',
                            'Potato','Tomato','Mango','Banana',
                            'Vegetables (Mixed)','Other'
                        ] as $crop)
                            <option value="{{ $crop }}"
                                {{ old('crop_type') == $crop
                                   ? 'selected' : '' }}>
                                {{ $crop }}
                            </option>
                        @endforeach
                    </select>
                    @error('crop_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Quantity (kg) *
                    </label>
                    <input type="number"
                           name="quantity_kg"
                           class="form-control
                                  @error('quantity_kg') is-invalid @enderror"
                           value="{{ old('quantity_kg') }}"
                           placeholder="e.g. 500"
                           min="1"
                           max="5000">
                    <div class="form-text" style="font-size:.72rem;">
                        Maximum 5,000 kg (full truck capacity)
                    </div>
                    @error('quantity_kg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Packaging Type *
                    </label>
                    <select name="packaging_type"
                            class="form-select
                                   @error('packaging_type') is-invalid @enderror">
                        <option value="">Select packaging</option>
                        @foreach([
                            'Gunny Bags','Plastic Bags','Wooden Crates',
                            'Plastic Crates','Loose / Bulk','Boxes','Other'
                        ] as $pkg)
                            <option value="{{ $pkg }}"
                                {{ old('packaging_type') == $pkg
                                   ? 'selected' : '' }}>
                                {{ $pkg }}
                            </option>
                        @endforeach
                    </select>
                    @error('packaging_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ── SECTION 2: Pickup Details ──────────────────────── --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-semibold mb-3"
                style="color:#2d6a4f;font-size:.85rem;
                       text-transform:uppercase;letter-spacing:.06em;">
                Pickup Details
            </h6>
            <div class="row g-3">

                {{-- Village / Location --}}
                <div class="col-12">
                    <label class="form-label fw-semibold small">
                        Pickup Location / Village *
                    </label>
                    <input type="text"
                           name="pickup_location"
                           class="form-control
                                  @error('pickup_location') is-invalid @enderror"
                           value="{{ old('pickup_location') }}"
                           placeholder="Village name, landmark, address">
                    @error('pickup_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pickup State — select first --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Pickup State *
                    </label>
                    <select name="pickup_state"
                            id="pickupState"
                            class="form-select
                                   @error('pickup_state') is-invalid @enderror"
                            onchange="filterDistricts('pickup');
                                      updateCostEstimate();"
                            required>
                        <option value="">Select state</option>
                        @foreach(\App\Data\DistrictData::getStates() as $s)
                            <option value="{{ $s }}"
                                {{ old('pickup_state') == $s
                                   ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                    @error('pickup_state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pickup District — filtered by state --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Pickup District *
                    </label>
                    <select name="pickup_district"
                            id="pickupDistrict"
                            class="form-select
                                   @error('pickup_district') is-invalid @enderror"
                            onchange="updateCostEstimate()"
                            required>
                        <option value="">Select state first</option>
                        {{-- Pre-fill on validation error --}}
                        @if(old('pickup_state'))
                            @foreach(\App\Data\DistrictData::getDistrictsForState(
                                old('pickup_state')) as $d)
                                <option value="{{ $d }}"
                                    {{ old('pickup_district') == $d
                                       ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('pickup_district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pickup Date --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Preferred Pickup Date *
                    </label>
                    <input type="date"
                           name="preferred_pickup_date"
                           class="form-control
                                  @error('preferred_pickup_date')
                                      is-invalid @enderror"
                           value="{{ old('preferred_pickup_date') }}"
                           min="{{ now()->addDay()->format('Y-m-d') }}">
                    @error('preferred_pickup_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pickup Time --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Preferred Pickup Time
                    </label>
                    <select name="preferred_pickup_time" class="form-select">
                        <option value="">Any time</option>
                        @foreach([
                            '06:00 AM','07:00 AM','08:00 AM','09:00 AM',
                            '10:00 AM','11:00 AM','12:00 PM','01:00 PM',
                            '02:00 PM','03:00 PM','04:00 PM','05:00 PM'
                        ] as $t)
                            <option value="{{ $t }}"
                                {{ old('preferred_pickup_time') == $t
                                   ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        {{-- ── SECTION 3: Destination ─────────────────────────── --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-semibold mb-3"
                style="color:#2d6a4f;font-size:.85rem;
                       text-transform:uppercase;letter-spacing:.06em;">
                Destination Market
            </h6>
            <div class="row g-3">

                {{-- Market name --}}
                <div class="col-12">
                    <label class="form-label fw-semibold small">
                        Market Name *
                    </label>
                    <input type="text"
                           name="destination_market"
                           class="form-control
                                  @error('destination_market')
                                      is-invalid @enderror"
                           value="{{ old('destination_market') }}"
                           placeholder="e.g. Ahmedabad APMC Market">
                    @error('destination_market')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Destination State --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Destination State *
                    </label>
                    <select name="destination_state"
                            id="destinationState"
                            class="form-select"
                            onchange="filterDistricts('destination');
                                      updateCostEstimate();">
                        <option value="">Select state</option>
                        @foreach(\App\Data\DistrictData::getStates() as $s)
                            <option value="{{ $s }}"
                                {{ old('destination_state') == $s
                                   ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Destination District --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Destination District *
                    </label>
                    <select name="destination_district"
                            id="destinationDistrict"
                            class="form-select
                                   @error('destination_district')
                                       is-invalid @enderror"
                            onchange="updateCostEstimate()"
                            required>
                        <option value="">Select state first</option>
                        @if(old('destination_state'))
                            @foreach(\App\Data\DistrictData::getDistrictsForState(
                                old('destination_state')) as $d)
                                <option value="{{ $d }}"
                                    {{ old('destination_district') == $d
                                       ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('destination_district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ── LIVE COST ESTIMATE ──────────────────────────────── --}}
        <div id="costEstimateBox"
             class="mb-4 p-4 rounded-3"
             style="background:#f0faf4;
                    border:1px solid #86efac;
                    display:none;
                    transition:all 300ms ease;">

            <div class="fw-semibold small mb-3"
                 style="color:#14532d;display:flex;
                        align-items:center;gap:6px;">
                <svg width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
                Estimated Transport Cost
            </div>

            <div class="row g-3 text-center mb-3">
                <div class="col-4">
                    <div style="font-size:.7rem;color:#6b7280;
                                font-weight:500;text-transform:uppercase;
                                letter-spacing:.05em;">
                        Distance
                    </div>
                    <div id="estDistance"
                         class="fw-bold mt-1"
                         style="color:#2d6a4f;font-size:1.1rem;">
                        —
                    </div>
                </div>
                <div class="col-4">
                    <div style="font-size:.7rem;color:#6b7280;
                                font-weight:500;text-transform:uppercase;
                                letter-spacing:.05em;">
                        Full Truck
                    </div>
                    <div id="estFullCost"
                         class="fw-bold mt-1"
                         style="color:#2d6a4f;font-size:1.1rem;">
                        —
                    </div>
                </div>
                <div class="col-4">
                    <div style="font-size:.7rem;color:#6b7280;
                                font-weight:500;text-transform:uppercase;
                                letter-spacing:.05em;">
                        If Shared
                    </div>
                    <div id="estSharedCost"
                         class="fw-bold mt-1"
                         style="color:#16a34a;font-size:1.1rem;">
                        —
                    </div>
                </div>
            </div>

            {{-- Breakdown note --}}
            <div style="font-size:.72rem;color:#6b7280;text-align:center;
                        padding-top:10px;border-top:1px solid #bbf7d0;">
                ₹12/km · 5-tonne truck · Actual cost calculated at pool matching
            </div>

        </div>

        {{-- ── SECTION 4: Special Instructions ───────────────── --}}
        <div class="mb-4">
            <label class="form-label fw-semibold small">
                Special Instructions
                <span style="color:#94a3b8;font-weight:400;">
                    (optional)
                </span>
            </label>
            <textarea name="special_instructions"
                      rows="3"
                      class="form-control
                             @error('special_instructions') is-invalid @enderror"
                      placeholder="Any special handling, fragile items,
                                   temperature needs, or pickup notes...">{{ old('special_instructions') }}</textarea>
            @error('special_instructions')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ── SUBMIT ──────────────────────────────────────────── --}}
        <div class="d-flex gap-3 pt-2">
            <button type="submit" class="btn btn-primary-agri px-5">
                Submit Request
            </button>
            <a href="{{ route('farmer.requests.index') }}"
               class="btn btn-secondary-agri px-4">
                Cancel
            </a>
        </div>

    </form>
</div>
</div>
</div>

@push('scripts')
<script>
// Full state → districts dataset from Laravel
window.stateDistricts = @json(\App\Data\DistrictData::$stateDistricts);

/**
 * Filter districts when state changes.
 * prefix = 'pickup' or 'destination'
 */
function filterDistricts(prefix) {
    const stateEl    = document.getElementById(prefix + 'State');
    const districtEl = document.getElementById(prefix + 'District');

    if (!stateEl || !districtEl) return;

    const selectedState = stateEl.value;

    // Reset district dropdown
    districtEl.innerHTML =
        '<option value="">Select district</option>';

    if (!selectedState || !window.stateDistricts[selectedState]) {
        updateCostEstimate();
        return;
    }

    // Get districts for this state, sorted alphabetically
    const districts = Object.keys(
        window.stateDistricts[selectedState]
    ).sort();

    districts.forEach(function(district) {
        const opt       = document.createElement('option');
        opt.value       = district;
        opt.textContent = district;
        districtEl.appendChild(opt);
    });

    updateCostEstimate();
}

/**
 * Haversine formula — distance between two lat/lng points in km
 */
function haversine(lat1, lon1, lat2, lon2) {
    const R    = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a    = Math.sin(dLat / 2) ** 2
               + Math.cos(lat1 * Math.PI / 180)
               * Math.cos(lat2 * Math.PI / 180)
               * Math.sin(dLon / 2) ** 2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
}

/**
 * Calculate and display live cost estimate
 * when both pickup and destination districts are selected
 */
function updateCostEstimate() {
    const pickupState  = document.getElementById('pickupState')?.value;
    const pickupDist   = document.getElementById('pickupDistrict')?.value;
    const destState    = document.getElementById('destinationState')?.value;
    const destDist     = document.getElementById('destinationDistrict')?.value;
    const box          = document.getElementById('costEstimateBox');

    if (!box) return;

    // Need both districts selected
    if (!pickupDist || !destDist || !pickupState || !destState) {
        box.style.display = 'none';
        return;
    }

    const fromCoords =
        window.stateDistricts[pickupState]?.[pickupDist];
    const toCoords   =
        window.stateDistricts[destState]?.[destDist];

    if (!fromCoords || !toCoords) {
        box.style.display = 'none';
        return;
    }

    // Same district — minimum charge applies
    const dist = pickupDist === destDist
        ? 0
        : haversine(
            fromCoords.lat, fromCoords.lng,
            toCoords.lat,   toCoords.lng
          );

    const RATE         = 12;    // ₹ per km per tonne
    const TRUCK_TONNES = 5;     // truck capacity in tonnes
    const MIN_CHARGE   = 500;   // minimum trip cost

    const fullCost    = Math.max(dist * TRUCK_TONNES * RATE, MIN_CHARGE);
    const sharedLow   = fullCost * 0.2;  // if 5 farmers share equally
    const sharedHigh  = fullCost * 0.5;  // if 2 farmers share

    // Update display
    document.getElementById('estDistance').textContent =
        dist > 0 ? Math.round(dist) + ' km' : 'Same district';

    document.getElementById('estFullCost').textContent =
        '₹' + Math.round(fullCost).toLocaleString('en-IN');

    document.getElementById('estSharedCost').textContent =
        '~₹' + Math.round(sharedLow).toLocaleString('en-IN')
        + ' – ₹'
        + Math.round(sharedHigh).toLocaleString('en-IN');

    // Show the box with a smooth reveal
    box.style.display = 'block';
}

// On DOM ready — restore dropdowns if validation failed and
// page reloaded with old() values
document.addEventListener('DOMContentLoaded', function() {
    // Render lucide icons
    if (typeof lucide !== 'undefined') lucide.createIcons();
    updateCostEstimate();
});
</script>
@endpush

@endsection