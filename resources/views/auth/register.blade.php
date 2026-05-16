@extends('layouts.guest')

@section('title', 'Register')

@section('content')

<h4 class="fw-bold text-center mb-1">Create Account</h4>
<p class="text-muted text-center small mb-4">Join AgriPool as a Farmer or Driver</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Name --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Full Name</label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}"
               placeholder="Enter your full name"
               required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Email Address</label>
        <input type="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}"
               placeholder="you@example.com"
               required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Phone --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Phone Number</label>
        <input type="text"
               name="phone"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone') }}"
               placeholder="10-digit mobile number"
               required>
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Role Selection --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">I am registering as</label>
        <div class="row g-2">

            {{-- Farmer option --}}
            <div class="col-6">
                <input type="radio" class="btn-check" name="role"
                       id="role_farmer" value="farmer"
                       {{ old('role', 'farmer') === 'farmer' ? 'checked' : '' }}
                       required>
                <label class="btn btn-outline-success w-100 py-3" for="role_farmer">
                    🌾<br><strong>Farmer</strong>
                    <div class="small text-muted">I grow crops</div>
                </label>
            </div>

            {{-- Driver option --}}
            <div class="col-6">
                <input type="radio" class="btn-check" name="role"
                       id="role_driver" value="driver"
                       {{ old('role') === 'driver' ? 'checked' : '' }}>
                <label class="btn btn-outline-primary w-100 py-3" for="role_driver">
                    🚛<br><strong>Driver</strong>
                    <div class="small text-muted">I transport goods</div>
                </label>
            </div>

        </div>
        @error('role')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Password</label>
        <input type="password"
               name="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Min. 8 characters"
               required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="mb-4">
        <label class="form-label fw-semibold">Confirm Password</label>
        <input type="password"
               name="password_confirmation"
               class="form-control"
               placeholder="Repeat password"
               required>
    </div>

    {{-- Submit --}}
    <button type="submit"
            class="btn w-100 py-2 fw-bold text-white"
            style="background-color: #2d6a4f;">
        Create Account
    </button>

</form>

<div class="text-center mt-3">
    <small class="text-muted">
        Already have an account?
        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold"
           style="color: #2d6a4f;">Sign In</a>
    </small>
</div>

@endsection