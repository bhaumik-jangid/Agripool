@extends('layouts.farmer')
@section('title', 'Edit Request')
@section('page-title', 'Edit Request #' . $transportRequest->id)
@section('page-subtitle', 'Update your transport request details')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="content-card">

    <form method="POST"
          action="{{ route('farmer.requests.update', $transportRequest) }}">
        @csrf
        @method('PUT')

        {{-- Crop Details --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-semibold mb-3" style="color:#2d6a4f;font-size:.9rem;
                text-transform:uppercase;letter-spacing:.05em;">
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
                        @foreach(['Wheat','Rice','Cotton','Sugarcane',
                                  'Maize','Soybean','Groundnut','Onion',
                                  'Potato','Tomato','Mango','Banana',
                                  'Vegetables (Mixed)','Other'] as $crop)
                            <option value="{{ $crop }}"
                                {{ old('crop_type',
                                   $transportRequest->crop_type) == $crop
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
                    <input type="number" name="quantity_kg"
                           class="form-control
                                  @error('quantity_kg') is-invalid @enderror"
                           value="{{ old('quantity_kg',
                               $transportRequest->quantity_kg) }}"
                           min="1" max="50000">
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
                        @foreach(['Gunny Bags','Plastic Bags','Wooden Crates',
                                  'Plastic Crates','Loose / Bulk',
                                  'Boxes','Other'] as $pkg)
                            <option value="{{ $pkg }}"
                                {{ old('packaging_type',
                                   $transportRequest->packaging_type) == $pkg
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

        {{-- Pickup Details --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-semibold mb-3" style="color:#2d6a4f;font-size:.9rem;
                text-transform:uppercase;letter-spacing:.05em;">
                Pickup Details
            </h6>
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label fw-semibold small">
                        Pickup Location / Village *
                    </label>
                    <input type="text" name="pickup_location"
                           class="form-control
                                  @error('pickup_location') is-invalid @enderror"
                           value="{{ old('pickup_location',
                               $transportRequest->pickup_location) }}"
                           placeholder="Village name, landmark">
                    @error('pickup_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- State first, then district --}}
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
                                {{ old('pickup_state',
                                   $transportRequest->pickup_state) == $s
                                   ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                    @error('pickup_state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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
                        @php
                            $pickupState = old('pickup_state',
                                $transportRequest->pickup_state);
                        @endphp
                        @if($pickupState)
                            @foreach(\App\Data\DistrictData::getDistrictsForState(
                                $pickupState) as $d)
                                <option value="{{ $d }}"
                                    {{ old('pickup_district',
                                       $transportRequest->pickup_district) == $d
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

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Preferred Pickup Date *
                    </label>
                    <input type="date" name="preferred_pickup_date"
                           class="form-control
                                  @error('preferred_pickup_date')
                                      is-invalid @enderror"
                           value="{{ old('preferred_pickup_date',
                               $transportRequest->preferred_pickup_date
                               ->format('Y-m-d')) }}">
                    @error('preferred_pickup_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Preferred Pickup Time
                    </label>
                    <select name="preferred_pickup_time" class="form-select">
                        <option value="">Any time</option>
                        @foreach(['06:00 AM','07:00 AM','08:00 AM',
                                  '09:00 AM','10:00 AM','11:00 AM',
                                  '12:00 PM','01:00 PM','02:00 PM',
                                  '03:00 PM','04:00 PM','05:00 PM'] as $t)
                            <option value="{{ $t }}"
                                {{ old('preferred_pickup_time',
                                   $transportRequest->preferred_pickup_time)
                                   == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        {{-- Destination --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-semibold mb-3" style="color:#2d6a4f;font-size:.9rem;
                text-transform:uppercase;letter-spacing:.05em;">
                Destination Market
            </h6>
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label fw-semibold small">
                        Market Name *
                    </label>
                    <input type="text" name="destination_market"
                           class="form-control
                                  @error('destination_market')
                                      is-invalid @enderror"
                           value="{{ old('destination_market',
                               $transportRequest->destination_market) }}"
                           placeholder="e.g. Ahmedabad APMC Market">
                    @error('destination_market')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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
                            @php
                                $destState = old('destination_state',
                                    \App\Data\DistrictData::getStateForDistrict(
                                        $transportRequest->destination_district
                                    ));
                            @endphp
                            <option value="{{ $s }}"
                                {{ $destState == $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                </div>

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
                        @php
                            $destState = old('destination_state',
                                \App\Data\DistrictData::getStateForDistrict(
                                    $transportRequest->destination_district
                                ));
                        @endphp
                        @if($destState)
                            @foreach(\App\Data\DistrictData::getDistrictsForState(
                                $destState) as $d)
                                <option value="{{ $d }}"
                                    {{ old('destination_district',
                                       $transportRequest->destination_district)
                                       == $d ? 'selected' : '' }}>
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

        {{-- Cost estimate box --}}
        <div id="costEstimateBox" class="mb-4 p-4 rounded-3"
             style="background:#f0faf4;border:1px solid #c3e6cb;display:none;">
            <div class="fw-semibold small mb-2" style="color:#2d6a4f;">
                Estimated Transport Cost
            </div>
            <div class="row g-3 text-center">
                <div class="col-4">
                    <div style="font-size:.72rem;color:#888;">Distance</div>
                    <div class="fw-bold" id="estDistance"
                         style="color:#2d6a4f;">—</div>
                </div>
                <div class="col-4">
                    <div style="font-size:.72rem;color:#888;">
                        Full Truck
                    </div>
                    <div class="fw-bold" id="estFullCost"
                         style="color:#2d6a4f;">—</div>
                </div>
                <div class="col-4">
                    <div style="font-size:.72rem;color:#888;">
                        If Shared
                    </div>
                    <div class="fw-bold" id="estSharedCost"
                         style="color:#52b788;">—</div>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="mb-4">
            <label class="form-label fw-semibold small">
                Special Instructions
            </label>
            <textarea name="special_instructions" rows="3"
                      class="form-control"
                      placeholder="Any special handling instructions...">{{ old('special_instructions', $transportRequest->special_instructions) }}</textarea>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn-primary-agri btn">
                Save Changes
            </button>
            <a href="{{ route('farmer.requests.show', $transportRequest) }}"
               class="btn-secondary-agri btn">
                Cancel
            </a>
        </div>

    </form>
</div>
</div>
</div>

@push('scripts')
<script>
// Full state → districts map from PHP
window.stateDistricts = @json(\App\Data\DistrictData::$stateDistricts);

function filterDistricts(prefix) {
    const stateEl    = document.getElementById(prefix + 'State');
    const districtEl = document.getElementById(prefix + 'District');
    const state      = stateEl ? stateEl.value : '';

    districtEl.innerHTML = '<option value="">Select district</option>';
    if (!state || !window.stateDistricts[state]) return;

    const districts = Object.keys(window.stateDistricts[state]).sort();
    districts.forEach(d => {
        const opt = document.createElement('option');
        opt.value = d;
        opt.textContent = d;
        districtEl.appendChild(opt);
    });

    updateCostEstimate();
}

function haversine(lat1, lon1, lat2, lon2) {
    const R    = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a    = Math.sin(dLat/2) ** 2
               + Math.cos(lat1 * Math.PI/180)
               * Math.cos(lat2 * Math.PI/180)
               * Math.sin(dLon/2) ** 2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
}

function updateCostEstimate() {
    const from = document.getElementById('pickupDistrict')?.value;
    const to   = document.getElementById('destinationDistrict')?.value;
    const box  = document.getElementById('costEstimateBox');

    if (!from || !to || !box) { box && (box.style.display='none'); return; }

    const fd = window.stateDistricts[
        document.getElementById('pickupState')?.value
    ]?.[from];
    const td = window.stateDistricts[
        document.getElementById('destinationState')?.value
    ]?.[to];

    if (!fd || !td) { box.style.display='none'; return; }

    const dist     = haversine(fd.lat, fd.lng, td.lat, td.lng);
    const fullCost = Math.max(dist * 5 * 12, 500);

    document.getElementById('estDistance').textContent =
        Math.round(dist) + ' km';
    document.getElementById('estFullCost').textContent =
        '₹' + fullCost.toFixed(0);
    document.getElementById('estSharedCost').textContent =
        '~₹' + (fullCost * 0.3).toFixed(0)
        + ' – ₹' + (fullCost * 0.5).toFixed(0);

    box.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    updateCostEstimate();
});
</script>
@endpush

@endsection