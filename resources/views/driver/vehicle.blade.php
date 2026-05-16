@extends('layouts.driver')
@section('title', 'My Vehicle')
@section('page-title', 'My Vehicle')
@section('page-subtitle', 'Your vehicle registration details')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-7">

@if($vehicle)

    {{-- Vehicle card --}}
    <div class="content-card mb-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h5 class="fw-bold mb-1">{{ $vehicle->vehicle_number }}</h5>
                <p class="text-muted small mb-0">{{ $vehicle->vehicle_model }}</p>
            </div>
            <span class="badge {{ $vehicle->is_verified ? 'bg-success' : 'bg-warning text-dark' }}
                          fs-6 px-3 py-2">
                {{ $vehicle->is_verified ? '✅ Verified' : '⏳ Pending Verification' }}
            </span>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="p-3 rounded-3" style="background:#f0f6fb;">
                    <div style="font-size:.72rem;color:#888;font-weight:600;
                                text-transform:uppercase;">Type</div>
                    <div class="fw-semibold mt-1">{{ $vehicle->vehicle_type }}</div>
                </div>
            </div>
            <div class="col-6">
                <div class="p-3 rounded-3" style="background:#f0f6fb;">
                    <div style="font-size:.72rem;color:#888;font-weight:600;
                                text-transform:uppercase;">Capacity</div>
                    <div class="fw-semibold mt-1">{{ $vehicle->capacity_tonnes }} tonnes</div>
                </div>
            </div>
            <div class="col-6">
                <div class="p-3 rounded-3" style="background:#f0f6fb;">
                    <div style="font-size:.72rem;color:#888;font-weight:600;
                                text-transform:uppercase;">Year</div>
                    <div class="fw-semibold mt-1">
                        {{ $vehicle->manufacture_year ?? 'N/A' }}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="p-3 rounded-3" style="background:#f0f6fb;">
                    <div style="font-size:.72rem;color:#888;font-weight:600;
                                text-transform:uppercase;">Insurance Expiry</div>
                    <div class="fw-semibold mt-1">
                        {{ $vehicle->insurance_expiry ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit form --}}
        <h6 class="fw-bold mb-3">Update Vehicle Details</h6>
        <form method="POST" action="{{ route('driver.vehicle.update', $vehicle) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Vehicle Type *</label>
                    <select name="vehicle_type" class="form-select" required>
                        @foreach(['Mini Truck','Tata Ace','Pickup Truck',
                                  'Medium Truck','Large Truck','Tempo'] as $type)
                            <option value="{{ $type }}"
                                {{ $vehicle->vehicle_type == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Vehicle Model</label>
                    <input type="text" name="vehicle_model" class="form-control"
                           value="{{ old('vehicle_model', $vehicle->vehicle_model) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Capacity (tonnes) *
                    </label>
                    <input type="number" name="capacity_tonnes"
                           class="form-control" step="0.1" min="0.1"
                           value="{{ old('capacity_tonnes', $vehicle->capacity_tonnes) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Manufacture Year</label>
                    <input type="number" name="manufacture_year" class="form-control"
                           value="{{ old('manufacture_year', $vehicle->manufacture_year) }}"
                           min="2000" max="{{ date('Y') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Insurance Number</label>
                    <input type="text" name="insurance_number" class="form-control"
                           value="{{ old('insurance_number', $vehicle->insurance_number) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Insurance Expiry</label>
                    <input type="text" name="insurance_expiry" class="form-control"
                           value="{{ old('insurance_expiry', $vehicle->insurance_expiry) }}"
                           placeholder="MM/YYYY">
                </div>
            </div>

            <button type="submit"
                    class="btn mt-4 px-5 fw-bold text-white"
                    style="background:#1d3557;border-radius:10px;">
                Save Changes
            </button>
        </form>
    </div>

@else

    {{-- Add vehicle form --}}
    <div class="content-card">
        <div class="text-center mb-4">
            <div style="font-size:3rem;">🚛</div>
            <h5 class="fw-bold mt-2">Add Your Vehicle</h5>
            <p class="text-muted small">
                Register your vehicle so admin can verify it
                and you can start accepting deliveries.
            </p>
        </div>

        <form method="POST" action="{{ route('driver.vehicle.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Vehicle Type *</label>
                    <select name="vehicle_type"
                            class="form-select @error('vehicle_type') is-invalid @enderror">
                        <option value="">Select type</option>
                        @foreach(['Mini Truck','Tata Ace','Pickup Truck',
                                  'Medium Truck','Large Truck','Tempo'] as $type)
                            <option value="{{ $type }}"
                                {{ old('vehicle_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Vehicle Registration Number *
                    </label>
                    <input type="text" name="vehicle_number"
                           class="form-control @error('vehicle_number') is-invalid @enderror"
                           value="{{ old('vehicle_number') }}"
                           placeholder="GJ01AB1234">
                    @error('vehicle_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Vehicle Model</label>
                    <input type="text" name="vehicle_model" class="form-control"
                           value="{{ old('vehicle_model') }}"
                           placeholder="e.g. Tata Ace Gold">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">
                        Capacity (tonnes) *
                    </label>
                    <input type="number" name="capacity_tonnes"
                           class="form-control @error('capacity_tonnes') is-invalid @enderror"
                           value="{{ old('capacity_tonnes') }}"
                           step="0.1" min="0.1" placeholder="e.g. 1.5">
                    @error('capacity_tonnes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Manufacture Year</label>
                    <input type="number" name="manufacture_year" class="form-control"
                           value="{{ old('manufacture_year') }}"
                           min="2000" max="{{ date('Y') }}"
                           placeholder="{{ date('Y') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Insurance Number</label>
                    <input type="text" name="insurance_number" class="form-control"
                           value="{{ old('insurance_number') }}"
                           placeholder="Policy number">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Insurance Expiry</label>
                    <input type="text" name="insurance_expiry" class="form-control"
                           value="{{ old('insurance_expiry') }}"
                           placeholder="MM/YYYY">
                </div>
            </div>

            <button type="submit"
                    class="btn mt-4 px-5 fw-bold text-white"
                    style="background:#1d3557;border-radius:10px;">
                Register Vehicle
            </button>

        </form>
    </div>

@endif
</div>
</div>

@endsection