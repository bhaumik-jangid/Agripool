<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AgriPool — Smart transport sharing for farmers.">
    <title>@yield('title', 'AgriPool — Agricultural Transport Sharing')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>

    {{-- ══════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════ --}}
    <!-- <nav class="navbar navbar-expand-lg navbar-agripool fixed-top" id="mainNavbar">
        <div class="container">

            <a class="navbar-brand navbar-brand-text text-decoration-none" href="{{ route('home') }}">
                🌾 AgriPool
            </a>

            <button class="navbar-toggler border-0" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-500" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#benefits">Benefits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#contact">Contact</a>
                    </li>
                </ul>

                <div class="d-flex gap-2 align-items-center">
                    @auth
                        @if(Auth::user()->isFarmer())
                            <a href="{{ route('farmer.dashboard') }}"
                               class="btn btn-hero-primary btn-sm px-4">Dashboard</a>
                        @elseif(Auth::user()->isDriver())
                            <a href="{{ route('driver.dashboard') }}"
                               class="btn btn-hero-primary btn-sm px-4">Dashboard</a>
                        @else
                            <a href="{{ route('admin.dashboard') }}"
                               class="btn btn-hero-primary btn-sm px-4">Admin Panel</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="btn btn-hero-outline btn-sm px-4">Sign In</a>
                        <a href="{{ route('register') }}"
                           class="btn btn-hero-primary btn-sm px-4">Join Free</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav> -->

    {{-- Page content --}}
    @yield('content')

    {{-- ══════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════ --}}
    <footer class="footer-main">
        <div class="container">
            <div class="row g-4">

                {{-- Brand column --}}
                <div class="col-lg-4">
                    <div class="footer-brand mb-3">🌾 AgriPool</div>
                    <p style="color:rgba(255,255,255,.55); font-size:.95rem; line-height:1.7;">
                        Empowering Indian farmers with smart, affordable,
                        and cooperative transport solutions for agricultural produce.
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <span style="font-size:1.5rem;">📘</span>
                        <span style="font-size:1.5rem;">🐦</span>
                        <span style="font-size:1.5rem;">📸</span>
                        <span style="font-size:1.5rem;">▶️</span>
                    </div>
                </div>

                {{-- Quick links --}}
                <div class="col-lg-2 col-6">
                    <h6 class="text-white fw-bold mb-3">Platform</h6>
                    <a href="#how-it-works" class="footer-link">How It Works</a>
                    <a href="#benefits" class="footer-link">Benefits</a>
                    <a href="{{ route('register') }}" class="footer-link">Register</a>
                    <a href="{{ route('login') }}" class="footer-link">Sign In</a>
                </div>

                <div class="col-lg-2 col-6">
                    <h6 class="text-white fw-bold mb-3">For Farmers</h6>
                    <a href="{{ route('register') }}" class="footer-link">Create Account</a>
                    <a href="#how-it-works" class="footer-link">Post Request</a>
                    <a href="#" class="footer-link">Find Pool</a>
                    <a href="#" class="footer-link">Track Shipment</a>
                </div>

                <div class="col-lg-2 col-6">
                    <h6 class="text-white fw-bold mb-3">For Drivers</h6>
                    <a href="{{ route('register') }}" class="footer-link">Drive with Us</a>
                    <a href="#" class="footer-link">View Routes</a>
                    <a href="#" class="footer-link">Earnings</a>
                    <a href="#" class="footer-link">Requirements</a>
                </div>

                <div class="col-lg-2 col-6">
                    <h6 class="text-white fw-bold mb-3">Support</h6>
                    <a href="{{ route('contact') }}" class="footer-link">Contact Us</a>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">Terms of Use</a>
                </div>

            </div>

            <div class="footer-bottom d-flex flex-wrap justify-content-between align-items-center">
                <p class="mb-0" style="font-size:.9rem;">
                    &copy; {{ date('Y') }} AgriPool. All rights reserved.
                    Built for Indian Farmers 🇮🇳
                </p>
                <p class="mb-0" style="font-size:.85rem; color:rgba(255,255,255,.4);">
                    Powered by Laravel {{ app()->version() }}
                </p>
            </div>
        </div>
    </footer>

    {{-- Navbar scroll effect --}}
    <script>
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('mainNavbar');
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });
    </script>

    @stack('scripts')
</body>
</html>