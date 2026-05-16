@extends('layouts.farmer')
@section('title', 'New Transport Request')
@section('page-title', 'New Transport Request')
@section('page-subtitle', 'Fill in the details of your crop transport need')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="content-card">

    <form method="POST" action="{{ route('farmer.requests.store') }}">
        @csrf

        {{-- Section: Crop Details --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-bold mb-3" style="color:#2d6a4f;">🌾 Crop Details</h6>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Crop Type *</label>
                    <select name="crop_type"
                            class="form-select @error('crop_type') is-invalid @enderror">
                        <option value="">Select crop</option>
                        @foreach(['Wheat','Rice','Cotton','Sugarcane','Maize','Soybean',
                                  'Groundnut','Onion','Potato','Tomato','Mango',
                                  'Banana','Vegetables (Mixed)','Other'] as $crop)
                            <option value="{{ $crop }}"
                                {{ old('crop_type') == $crop ? 'selected' : '' }}>
                                {{ $crop }}
                            </option>
                        @endforeach
                    </select>
                    @error('crop_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Quantity (kg) *</label>
                    <input type="number" name="quantity_kg"
                           class="form-control @error('quantity_kg') is-invalid @enderror"
                           value="{{ old('quantity_kg') }}"
                           placeholder="e.g. 500" min="1" max="50000">
                    @error('quantity_kg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Packaging Type *</label>
                    <select name="packaging_type"
                            class="form-select @error('packaging_type') is-invalid @enderror">
                        <option value="">Select packaging</option>
                        @foreach(['Gunny Bags','Plastic Bags','Wooden Crates',
                                  'Plastic Crates','Loose / Bulk','Boxes','Other'] as $pkg)
                            <option value="{{ $pkg }}"
                                {{ old('packaging_type') == $pkg ? 'selected' : '' }}>
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

        {{-- Section: Pickup Details --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-bold mb-3" style="color:#2d6a4f;">📍 Pickup Details</h6>
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label fw-semibold small">Pickup Location / Address *</label>
                    <input type="text" name="pickup_location"
                           class="form-control @error('pickup_location') is-invalid @enderror"
                           value="{{ old('pickup_location') }}"
                           placeholder="Village/Town, Landmark">
                    @error('pickup_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Pickup District *</label>
                    <select name="pickup_district"
                            class="form-select
                                @error('pickup_district') is-invalid @enderror"
                            id="pickupDistrict"
                            onchange="updateCostEstimate()">
                        <option value="">Select district</option>
                        @foreach(\App\Data\DistrictData::getDistrictNames() as $d)
                            <option value="{{ $d }}"
                                {{ old('pickup_district') == $d ? 'selected' : '' }}>
                                {{ $d }}
                            </option>
                        @endforeach
                    </select>
                    @error('pickup_district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Pickup State *</label>
                    <select name="pickup_state"
                            class="form-select @error('pickup_state') is-invalid @enderror">
                        <option value="">Select state</option>
                        @foreach(['Gujarat','Maharashtra','Rajasthan','Madhya Pradesh',
                                  'Uttar Pradesh','Punjab','Haryana','Karnataka',
                                  'Andhra Pradesh','Tamil Nadu','Other'] as $state)
                            <option value="{{ $state }}"
                                {{ old('pickup_state') == $state ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                    @error('pickup_state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Preferred Pickup Date *</label>
                    <input type="date" name="preferred_pickup_date"
                           class="form-control @error('preferred_pickup_date') is-invalid @enderror"
                           value="{{ old('preferred_pickup_date') }}"
                           min="{{ now()->addDay()->format('Y-m-d') }}">
                    @error('preferred_pickup_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Preferred Pickup Time</label>
                    <select name="preferred_pickup_time" class="form-select">
                        <option value="">Any time</option>
                        @foreach(['06:00 AM','07:00 AM','08:00 AM','09:00 AM',
                                  '10:00 AM','11:00 AM','12:00 PM','01:00 PM',
                                  '02:00 PM','03:00 PM','04:00 PM','05:00 PM'] as $t)
                            <option value="{{ $t }}"
                                {{ old('preferred_pickup_time') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        {{-- Section: Destination --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-bold mb-3" style="color:#2d6a4f;">🏪 Destination Market</h6>
            <div class="row g-3">

                <div class="col-md-8">
                    <label class="form-label fw-semibold small">
                        Market Name / Location *
                    </label>
                    <input type="text" name="destination_market"
                        class="form-control
                                @error('destination_market') is-invalid @enderror"
                        value="{{ old('destination_market') }}"
                        placeholder="e.g. Ahmedabad APMC Market, Surat Sabji Market">
                    @error('destination_market')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold small">
                        Destination District *
                    </label>
                    <select name="destination_district"
                            class="form-select
                                @error('destination_district') is-invalid @enderror"
                            id="destinationDistrict"
                            onchange="updateCostEstimate()">
                        <option value="">Select district</option>
                        @foreach(\App\Data\DistrictData::getDistrictNames() as $d)
                            <option value="{{ $d }}"
                                {{ old('destination_district') == $d ? 'selected' : '' }}>
                                {{ $d }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Section: Additional Notes --}}
        <div class="mb-4">
            <h6 class="fw-bold mb-3" style="color:#2d6a4f;">📝 Additional Notes</h6>
            <textarea name="special_instructions" rows="3"
                      class="form-control @error('special_instructions') is-invalid @enderror"
                      placeholder="Any special handling instructions, fragile items, temperature requirements...">{{ old('special_instructions') }}</textarea>
            @error('special_instructions')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Live cost estimate --}}
        <div id="costEstimateBox" class="mb-4 p-4 rounded-3"
            style="background:#f0faf4;border:1px solid #c3e6cb;display:none;">
            <h6 class="fw-bold mb-2" style="color:#2d6a4f;">
                💰 Estimated Transport Cost
            </h6>
            <div class="row g-3">
                <div class="col-md-4 text-center">
                    <div style="font-size:.78rem;color:#888;">Distance</div>
                    <div class="fw-bold" id="estDistance" style="color:#2d6a4f;">—</div>
                </div>
                <div class="col-md-4 text-center">
                    <div style="font-size:.78rem;color:#888;">Full Truck Cost</div>
                    <div class="fw-bold" id="estFullCost" style="color:#2d6a4f;">—</div>
                </div>
                <div class="col-md-4 text-center">
                    <div style="font-size:.78rem;color:#888;">If You Share (50%)</div>
                    <div class="fw-bold" id="estSharedCost"
                        style="color:#52b788;">—</div>
                </div>
            </div>
            <div class="mt-2 small text-muted text-center">
                ₹12/km/tonne · 5-tonne truck · Actual cost calculated at matching
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex gap-3">
            <button type="submit"
                    class="btn px-5 py-2 fw-bold text-white"
                    style="background:#2d6a4f;border-radius:10px;">
                Submit Request
            </button>
            <a href="{{ route('farmer.requests.index') }}"
               class="btn btn-outline-secondary px-4 py-2"
               style="border-radius:10px;">
                Cancel
            </a>
        </div>

    </form>
</div>
</div>
</div>

@push('scripts')
<script>
// District coordinates for client-side distance calculation
const districts = @json(\App\Data\DistrictData::$districts);
const RATE = 12.0;
const TRUCK_TONNES = 5.0;

function haversine(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2)
            + Math.cos(lat1 * Math.PI/180)
            * Math.cos(lat2 * Math.PI/180)
            * Math.sin(dLon/2) * Math.sin(dLon/2);
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

function updateCostEstimate() {
    const from = document.getElementById('pickupDistrict').value;
    const to   = document.getElementById('destinationDistrict').value;

    if (!from || !to || from === to) {
        document.getElementById('costEstimateBox').style.display = 'none';
        return;
    }

    if (!districts[from] || !districts[to]) return;

    const dist = haversine(
        districts[from].lat, districts[from].lng,
        districts[to].lat,   districts[to].lng
    );

    const fullCost   = Math.max(dist * TRUCK_TONNES * RATE, 500);
    const sharedCost = fullCost * 0.5;

    document.getElementById('estDistance').textContent =
        Math.round(dist) + ' km';
    document.getElementById('estFullCost').textContent =
        '₹' + fullCost.toFixed(0);
    document.getElementById('estSharedCost').textContent =
        '₹' + sharedCost.toFixed(0) + ' (est.)';

    document.getElementById('costEstimateBox').style.display = 'block';
}
</script>
@endpush

@endsection