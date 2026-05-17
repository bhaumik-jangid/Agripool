<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AgriPool — Smart transport sharing platform for farmers. Share trucks, split costs, deliver produce to markets together.">
    <title>@yield('title', 'AgriPool — Agricultural Transport Sharing')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/premium.css'])
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        :root {
            --green-dark:  #2d6a4f;
            --green-mid:   #40916c;
            --green-light: #52b788;
            --green-pale:  #d8f3dc;
            --yellow:      #f4a261;
            --orange:      #e76f51;
            --dark:        #1b1b2f;
            --gray:        #6c757d;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: #333;
            overflow-x: hidden;
        }

        /* ── Navbar ── */
        .navbar-agripool {
            background: rgba(45, 106, 79, 0.97);
            backdrop-filter: blur(10px);
            padding: 14px 0;
            transition: all .3s ease;
        }
        .navbar-agripool.scrolled {
            padding: 8px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,.15);
        }
        .navbar-brand-text {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff !important;
            letter-spacing: -0.5px;
        }

        /* ── Hero ── */
        .hero-section {
            background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 50%, #40916c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            color: #fff;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 24px;
        }
        .hero-title span { color: #f4a261; }
        .hero-subtitle {
            font-size: 1.15rem;
            color: rgba(255,255,255,.85);
            line-height: 1.7;
            margin-bottom: 36px;
        }
        .hero-card {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 20px;
            padding: 28px;
            backdrop-filter: blur(10px);
            color: #fff;
        }
        .hero-stat { font-size: 2rem; font-weight: 800; color: #f4a261; }
        .floating-emoji {
            position: absolute;
            font-size: 3rem;
            opacity: .15;
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%,100% { transform: translateY(0) rotate(0deg); }
            50%      { transform: translateY(-20px) rotate(5deg); }
        }

        /* ── Section titles ── */
        .section-tag {
            display: inline-block;
            background: var(--green-pale);
            color: var(--green-dark);
            padding: 4px 16px;
            border-radius: 50px;
            font-size: .8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }
        .section-title {
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800;
            color: var(--dark);
            line-height: 1.2;
        }

        /* ── Step cards ── */
        .step-card {
            position: relative;
            padding: 36px 28px;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            transition: transform .3s, box-shadow .3s;
            height: 100%;
        }
        .step-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(0,0,0,.12);
        }
        .step-number {
            width: 52px; height: 52px;
            border-radius: 50%;
            background: var(--green-dark);
            color: #fff;
            font-size: 1.4rem;
            font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
        }
        .step-icon { font-size: 2.4rem; margin-bottom: 12px; }
        .step-connector {
            position: absolute;
            top: 52px; right: -30px;
            width: 60px; height: 2px;
            background: linear-gradient(90deg, var(--green-dark), var(--green-light));
            z-index: 1;
        }

        /* ── Benefit cards ── */
        .benefit-card {
            padding: 32px 24px;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 2px 16px rgba(0,0,0,.06);
            transition: transform .3s;
            height: 100%;
            border-top: 4px solid var(--green-light);
        }
        .benefit-card:hover { transform: translateY(-4px); }
        .benefit-icon {
            width: 60px; height: 60px;
            border-radius: 14px;
            background: var(--green-pale);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 18px;
        }

        /* ── Stats ── */
        .stats-section {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
        }
        .stat-item { padding: 20px; }
        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            color: #fff;
        }
        .stat-label { color: rgba(255,255,255,.75); font-size: .95rem; }

        /* ── Testimonials ── */
        .testimonial-card {
            background: #fff;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            height: 100%;
            position: relative;
        }
        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: 16px; left: 24px;
            font-size: 5rem;
            color: var(--green-pale);
            font-family: Georgia, serif;
            line-height: 1;
        }
        .avatar-circle {
            width: 52px; height: 52px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
        }
        .stars { color: #f4a261; font-size: 1rem; }

        /* ── Contact ── */
        .contact-card {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0,0,0,.12);
        }
        .contact-left {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
            padding: 48px 36px;
            color: #fff;
        }
        .contact-right { background: #fff; padding: 48px 36px; }
        .contact-info-item {
            display: flex; gap: 14px; align-items: flex-start;
            margin-bottom: 24px;
        }
        .contact-icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: rgba(255,255,255,.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0;
        }

        /* ── Footer ── */
        .footer-main {
            background: #0f2318;
            padding: 60px 0 30px;
            color: rgba(255,255,255,.7);
        }
        .footer-brand { font-size: 1.5rem; font-weight: 800; color: #fff; }
        .footer-link {
            color: rgba(255,255,255,.6);
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: color .2s;
        }
        .footer-link:hover { color: var(--green-light); }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.08);
            padding-top: 24px; margin-top: 40px;
        }

        /* ── Buttons ── */
        .btn-hero-primary {
            background: #f4a261;
            color: #fff;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            transition: all .3s;
        }
        .btn-hero-primary:hover {
            background: #e76f51;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(231,111,81,.4);
        }
        .btn-hero-outline {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255,255,255,.6);
            padding: 13px 32px;
            border-radius: 50px;
            font-weight: 600;
            transition: all .3s;
        }
        .btn-hero-outline:hover {
            background: rgba(255,255,255,.1);
            color: #fff;
            border-color: #fff;
        }
        .btn-green {
            background: var(--green-dark);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 700;
            transition: all .3s;
        }
        .btn-green:hover {
            background: var(--green-mid);
            color: #fff;
            transform: translateY(-2px);
        }

        /* ── Form ── */
        .form-control:focus, .form-select:focus {
            border-color: var(--green-light);
            box-shadow: 0 0 0 3px rgba(82,183,136,.2);
        }
    </style>
</head>
<body>

    {{-- ══════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════ --}}
    <nav class="navbar navbar-expand-lg navbar-agripool fixed-top" id="mainNavbar">
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
    </nav>

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