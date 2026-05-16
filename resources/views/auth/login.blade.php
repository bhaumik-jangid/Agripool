@extends('layouts.guest')

@section('title', 'Login')

@section('content')

<h4 class="fw-bold text-center mb-1">Welcome Back</h4>
<p class="text-muted text-center small mb-4">Sign in to your AgriPool account</p>

{{-- Session status (e.g. password reset confirmation) --}}
@if (session('status'))
    <div class="alert alert-success small">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Email Address</label>
        <input type="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}"
               placeholder="you@example.com"
               required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Password</label>
        <input type="password"
               name="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Your password"
               required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Remember me + Forgot password --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small" for="remember">Remember me</label>
        </div>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="small text-decoration-none"
               style="color: #2d6a4f;">Forgot password?</a>
        @endif
    </div>

    {{-- Submit --}}
    <button type="submit"
            class="btn w-100 py-2 fw-bold text-white"
            style="background-color: #2d6a4f;">
        Sign In
    </button>

</form>

<div class="text-center mt-3">
    <small class="text-muted">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold"
           style="color: #2d6a4f;">Register here</a>
    </small>
</div>

{{-- Test credentials hint for development --}}
<div class="mt-4 p-3 bg-light rounded small text-muted">
    <strong>Test Accounts:</strong><br>
    Admin: admin@agripool.com / password<br>
    Farmer: ramesh@farmer.com / password<br>
    Driver: mohan@driver.com / password
</div>

@endsection