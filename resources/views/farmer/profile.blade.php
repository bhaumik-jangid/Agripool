@extends('layouts.farmer')
@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage your account information')

@section('content')

<div class="row g-4 justify-content-center">
<div class="col-lg-8">
<div class="content-card">

    <form method="POST" action="{{ route('farmer.profile.update') }}">
        @csrf
        @method('PUT')

        {{-- Account Info --}}
        <div class="mb-4 pb-4" style="border-bottom:1px solid #f0f0f0;">
            <h6 class="fw-bold mb-3" style="color:#2d6a4f;">👤 Account Information</h6>
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
                    <label class="form-label fw-semibold small">Phone Number *</label>
                    <input type="text" name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $user->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Email Address</label>
                    <input type="email" class="form-control"
                           value="{{ $user->email }}" disabled>
                    <div class="form-text">Email cannot be changed here.</div>
                </div>

            </div>
        </div>

        {{-- Farm Info --}}
        <div class="mb-4">
            <h6 class="fw-bold mb-3" style="color:#2d6a4f;">🌾 Farm Information</h6>
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Farm Name</label>
                    <input type="text" name="farm_name" class="form-control"
                           value="{{ old('farm_name', $farmerProfile->farm_name ?? '') }}"
                           placeholder="e.g. Patel Green Farm">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Farm Location / Village *</label>
                    <input type="text" name="farm_location"
                           class="form-control @error('farm_location') is-invalid @enderror"
                           value="{{ old('farm_location', $farmerProfile->farm_location ?? '') }}"
                           placeholder="Village or town name">
                    @error('farm_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold small">District *</label>
                    <input type="text" name="district"
                           class="form-control @error('district') is-invalid @enderror"
                           value="{{ old('district', $farmerProfile->district ?? '') }}">
                    @error('district')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold small">State *</label>
                    <select name="state"
                            class="form-select @error('state') is-invalid @enderror">
                        @foreach(['Gujarat','Maharashtra','Rajasthan','Madhya Pradesh',
                                  'Uttar Pradesh','Punjab','Haryana','Karnataka',
                                  'Andhra Pradesh','Tamil Nadu','Other'] as $state)
                            <option value="{{ $state }}"
                                {{ old('state', $farmerProfile->state ?? '') == $state
                                   ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Pincode</label>
                    <input type="text" name="pincode" class="form-control"
                           value="{{ old('pincode', $farmerProfile->pincode ?? '') }}"
                           placeholder="6-digit pincode">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Bio / About</label>
                    <textarea name="bio" rows="3" class="form-control"
                              placeholder="Brief description about your farm and crops...">{{ old('bio', $farmerProfile->bio ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <button type="submit"
                class="btn px-5 py-2 fw-bold text-white"
                style="background:#2d6a4f;border-radius:10px;">
            Save Profile
        </button>

    </form>
</div>
</div>
</div>

@endsection