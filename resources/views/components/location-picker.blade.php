{{--
    Props:
    $prefix         = 'pickup' or 'destination'
    $labelPrefix    = 'Pickup' or 'Destination'
    $oldState       = old value for state
    $oldDistrict    = old value for district
    $showMarket     = true/false (show market name input)
    $oldMarket      = old value for market name
--}}

@php
    $states    = \App\Data\DistrictData::getStates();
    $stateData = \App\Data\DistrictData::$stateDistricts;
    sort($states);
@endphp

@if($showMarket ?? false)
    <div class="col-md-8">
        <label class="form-label fw-semibold small">
            Market Name *
        </label>
        <input type="text"
               name="{{ $prefix }}_market"
               class="form-control
                      @error($prefix . '_market') is-invalid @enderror"
               value="{{ $oldMarket ?? old($prefix . '_market') }}"
               placeholder="e.g. Ahmedabad APMC Market">
        @error($prefix . '_market')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold small">State *</label>
        <select name="{{ $prefix }}_state"
                id="{{ $prefix }}State"
                class="form-select
                       @error($prefix . '_state') is-invalid @enderror"
                onchange="filterDistricts('{{ $prefix }}')"
                required>
            <option value="">Select state</option>
            @foreach($states as $s)
                <option value="{{ $s }}"
                    {{ ($oldState ?? old($prefix . '_state')) == $s
                       ? 'selected' : '' }}>
                    {{ $s }}
                </option>
            @endforeach
        </select>
        @error($prefix . '_state')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold small">
            District *
        </label>
        <select name="{{ $prefix }}_district"
                id="{{ $prefix }}District"
                class="form-select
                       @error($prefix . '_district') is-invalid @enderror"
                onchange="{{ $prefix === 'pickup'
                    ? 'updateCostEstimate()' : 'updateCostEstimate()' }}"
                required>
            <option value="">Select state first</option>
            @if($oldState ?? old($prefix . '_state'))
                @foreach(\App\Data\DistrictData::getDistrictsForState(
                    $oldState ?? old($prefix . '_state')
                ) as $d)
                    <option value="{{ $d }}"
                        {{ ($oldDistrict ?? old($prefix . '_district'))
                           == $d ? 'selected' : '' }}>
                        {{ $d }}
                    </option>
                @endforeach
            @endif
        </select>
        @error($prefix . '_district')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@else
    <div class="col-md-6">
        <label class="form-label fw-semibold small">State *</label>
        <select name="{{ $prefix }}_state"
                id="{{ $prefix }}State"
                class="form-select
                       @error($prefix . '_state') is-invalid @enderror"
                onchange="filterDistricts('{{ $prefix }}')"
                required>
            <option value="">Select state</option>
            @foreach($states as $s)
                <option value="{{ $s }}"
                    {{ ($oldState ?? old($prefix . '_state')) == $s
                       ? 'selected' : '' }}>
                    {{ $s }}
                </option>
            @endforeach
        </select>
        @error($prefix . '_state')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold small">District *</label>
        <select name="{{ $prefix }}_district"
                id="{{ $prefix }}District"
                class="form-select
                       @error($prefix . '_district') is-invalid @enderror"
                onchange="updateCostEstimate()"
                required>
            <option value="">Select state first</option>
            @if($oldState ?? old($prefix . '_state'))
                @foreach(\App\Data\DistrictData::getDistrictsForState(
                    $oldState ?? old($prefix . '_state')
                ) as $d)
                    <option value="{{ $d }}"
                        {{ ($oldDistrict ?? old($prefix . '_district'))
                           == $d ? 'selected' : '' }}>
                        {{ $d }}
                    </option>
                @endforeach
            @endif
        </select>
        @error($prefix . '_district')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endif