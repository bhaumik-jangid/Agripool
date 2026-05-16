@extends('layouts.driver')
@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage your driver account')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-7">
<div class="content-card">

    <form method="POST" action="{{ route('driver.profile.update') }}">
        @csrf
        @method('PUT')

        {{-- Personal Info --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-bold mb-3" style="color:#1d3557;">👤 Personal Information</h6>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Full Name *</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Phone *</label>
                    <input type="text" name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Email</label>
                    <input type="email" class="form-control"
                           value="{{ $user->email }}" disabled>
                </div>

            </div>
        </div>

        {{-- License Info --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-bold mb-3" style="color:#1d3557;">📄 License Information</h6>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">License Number *</label>
                    <input type="text" name="license_number"
                           class="form-control @error('license_number') is-invalid @enderror"
                           value="{{ old('license_number',
                               $driverProfile->license_number ?? '') }}"
                           placeholder="GJ01-2020-0123456">
                    @error('license_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">License Expiry *</label>
                    <input type="text" name="license_expiry"
                           class="form-control @error('license_expiry') is-invalid @enderror"
                           value="{{ old('license_expiry',
                               $driverProfile->license_expiry ?? '') }}"
                           placeholder="YYYY-MM-DD">
                    @error('license_expiry')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Location --}}
        <div class="mb-4">
            <h6 class="fw-bold mb-3" style="color:#1d3557;">📍 Location</h6>
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label fw-semibold small">Current Location</label>
                    <input type="text" name="current_location" class="form-control"
                           value="{{ old('current_location',
                               $driverProfile->current_location ?? '') }}"
                           placeholder="City / Town where you are based">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">District</label>
                    <input type="text" name="district" class="form-control"
                           value="{{ old('district', $driverProfile->district ?? '') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">State</label>
                    <select name="state" class="form-select">
                        @foreach(['Gujarat','Maharashtra','Rajasthan',
                                  'Madhya Pradesh','Uttar Pradesh','Punjab',
                                  'Haryana','Karnataka','Other'] as $state)
                            <option value="{{ $state }}"
                                {{ old('state', $driverProfile->state ?? '') == $state
                                   ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <button type="submit"
                class="btn px-5 py-2 fw-bold text-white"
                style="background:#1d3557;border-radius:10px;">
            Save Profile
        </button>

    </form>
</div>
</div>
</div>

@endsection