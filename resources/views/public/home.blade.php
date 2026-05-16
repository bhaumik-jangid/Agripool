@extends('layouts.public')
@section('title', 'AgriPool — Smart Agricultural Transport Sharing')

@section('content')

{{-- ══════════════════════════════════════════════════════
     SECTION 1: HERO
══════════════════════════════════════════════════════ --}}
<section class="hero-section" id="home">

    {{-- Floating background emojis --}}
    <span class="floating-emoji" style="top:15%;left:5%;animation-delay:0s">🌾</span>
    <span class="floating-emoji" style="top:60%;left:8%;animation-delay:1s">🚛</span>
    <span class="floating-emoji" style="top:20%;right:6%;animation-delay:2s">🥕</span>
    <span class="floating-emoji" style="top:70%;right:10%;animation-delay:.5s">🌽</span>
    <span class="floating-emoji" style="top:40%;right:4%;animation-delay:1.5s">🍅</span>

    <div class="container position-relative" style="z-index:2; padding-top: 100px;">
        <div class="row align-items-center g-5">

            {{-- Left: Text --}}
            <div class="col-lg-6">
                <div class="hero-badge">🚀 Smarter Farming, Together</div>

                <h1 class="hero-title">
                    Share Transport.<br>
                    <span>Cut Costs.</span><br>
                    Reach Markets.
                </h1>

                <p class="hero-subtitle">
                    AgriPool connects farmers going to the same market,
                    so you can share a truck, split the cost, and deliver
                    your produce together — saving up to <strong style="color:#f4a261;">60% on transport.</strong>
                </p>

                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="{{ route('register') }}" class="btn btn-hero-primary">
                        🌾 Join as Farmer
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-hero-outline">
                        🚛 Join as Driver
                    </a>
                </div>

                {{-- Trust indicators --}}
                <div class="d-flex flex-wrap gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size:1.3rem;">✅</span>
                        <span style="color:rgba(255,255,255,.8);font-size:.9rem;">Free to join</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size:1.3rem;">🔒</span>
                        <span style="color:rgba(255,255,255,.8);font-size:.9rem;">Verified drivers</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span style="font-size:1.3rem;">📱</span>
                        <span style="color:rgba(255,255,255,.8);font-size:.9rem;">Real-time tracking</span>
                    </div>
                </div>
            </div>

            {{-- Right: Stats card --}}
            <div class="col-lg-6">
                <div class="hero-card">
                    <h5 class="text-white fw-bold mb-4">🌍 Platform at a Glance</h5>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:rgba(255,255,255,.1);">
                                <div class="hero-stat">2,400+</div>
                                <div style="color:rgba(255,255,255,.7);font-size:.85rem;">
                                    Farmers Registered
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:rgba(255,255,255,.1);">
                                <div class="hero-stat">380+</div>
                                <div style="color:rgba(255,255,255,.7);font-size:.85rem;">
                                    Verified Drivers
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:rgba(255,255,255,.1);">
                                <div class="hero-stat">12,000+</div>
                                <div style="color:rgba(255,255,255,.7);font-size:.85rem;">
                                    Deliveries Completed
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:rgba(255,255,255,.1);">
                                <div class="hero-stat">₹48L+</div>
                                <div style="color:rgba(255,255,255,.7);font-size:.85rem;">
                                    Saved by Farmers
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mini how-it-works --}}
                    <div style="border-top:1px solid rgba(255,255,255,.15); padding-top:20px;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span>📝</span>
                            <span style="color:rgba(255,255,255,.85);font-size:.9rem;">
                                Post your transport request
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span>🤝</span>
                            <span style="color:rgba(255,255,255,.85);font-size:.9rem;">
                                Get matched with nearby farmers
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span>🚛</span>
                            <span style="color:rgba(255,255,255,.85);font-size:.9rem;">
                                Share truck — split the cost
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span>📍</span>
                            <span style="color:rgba(255,255,255,.85);font-size:.9rem;">
                                Track your delivery live
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     SECTION 2: HOW IT WORKS
══════════════════════════════════════════════════════ --}}
<section class="py-6" id="how-it-works" style="padding: 100px 0; background:#f8fffe;">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag">Simple Process</div>
            <h2 class="section-title">How AgriPool Works</h2>
            <p class="text-muted mt-3 mx-auto" style="max-width:560px;">
                From posting your request to delivering at market —
                four simple steps is all it takes.
            </p>
        </div>

        <div class="row g-4 position-relative">

            {{-- Step 1 --}}
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-icon">📝</div>
                    <div class="step-number">1</div>
                    <h5 class="fw-bold mb-2">Post Your Request</h5>
                    <p class="text-muted small">
                        Enter your crop type, quantity, pickup location,
                        and destination market. Takes less than 2 minutes.
                    </p>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-icon">🤝</div>
                    <div class="step-number">2</div>
                    <h5 class="fw-bold mb-2">Get Matched</h5>
                    <p class="text-muted small">
                        Our system finds nearby farmers going to the same
                        market on the same date and groups you together.
                    </p>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-icon">🚛</div>
                    <div class="step-number">3</div>
                    <h5 class="fw-bold mb-2">Share the Truck</h5>
                    <p class="text-muted small">
                        A verified driver is assigned. Your produce is loaded
                        together. Everyone pays only their fair share of the cost.
                    </p>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="col-md-6 col-lg-3">
                <div class="step-card">
                    <div class="step-icon">📍</div>
                    <div class="step-number">4</div>
                    <h5 class="fw-bold mb-2">Track & Receive</h5>
                    <p class="text-muted small">
                        Track your shipment live. Get notified when it
                        arrives. Rate your driver and save for next time.
                    </p>
                </div>
            </div>

        </div>

        <div class="text-center mt-5">
            <a href="{{ route('register') }}" class="btn btn-green px-5 py-3">
                Get Started — It's Free →
            </a>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     SECTION 3: BENEFITS
══════════════════════════════════════════════════════ --}}
<section style="padding: 100px 0; background:#fff;" id="benefits">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag">Why AgriPool</div>
            <h2 class="section-title">Benefits for Every Stakeholder</h2>
        </div>

        <div class="row g-4">

            <div class="col-md-6 col-lg-4">
                <div class="benefit-card">
                    <div class="benefit-icon">💰</div>
                    <h5 class="fw-bold mb-2">Save Up to 60% on Transport</h5>
                    <p class="text-muted small">
                        By sharing truck space with neighbouring farmers, everyone
                        pays only for the space they use. No more paying for an
                        empty half-truck.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="benefit-card">
                    <div class="benefit-icon">⚡</div>
                    <h5 class="fw-bold mb-2">Faster Market Access</h5>
                    <p class="text-muted small">
                        Get your produce to market on your preferred date.
                        No waiting for a full truck load on your own — we
                        fill it together.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="benefit-card">
                    <div class="benefit-icon">🔒</div>
                    <h5 class="fw-bold mb-2">Verified, Trusted Drivers</h5>
                    <p class="text-muted small">
                        Every driver on AgriPool is background-checked,
                        license-verified, and admin-approved before they
                        can accept deliveries.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="benefit-card">
                    <div class="benefit-icon">📱</div>
                    <h5 class="fw-bold mb-2">Real-Time Shipment Tracking</h5>
                    <p class="text-muted small">
                        Know exactly where your produce is at every step —
                        from cargo loaded to market delivered —
                        with live status updates.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="benefit-card">
                    <div class="benefit-icon">🌐</div>
                    <h5 class="fw-bold mb-2">Smart Pool Matching</h5>
                    <p class="text-muted small">
                        Our algorithm automatically finds farmers with matching
                        destination, pickup region, and date — so pooling
                        happens effortlessly.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="benefit-card">
                    <div class="benefit-icon">📊</div>
                    <h5 class="fw-bold mb-2">Complete Delivery History</h5>
                    <p class="text-muted small">
                        Every delivery, every cost, every rating —
                        all recorded. Build your reputation and
                        improve your transport decisions over time.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     SECTION 4: STATS BANNER
══════════════════════════════════════════════════════ --}}
<section class="stats-section" style="padding: 70px 0;">
    <div class="container">
        <div class="row text-center g-4">

            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">2,400+</div>
                    <div class="stat-label">Registered Farmers</div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">380+</div>
                    <div class="stat-label">Active Drivers</div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">12,000+</div>
                    <div class="stat-label">Deliveries Completed</div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">60%</div>
                    <div class="stat-label">Average Cost Saving</div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     SECTION 5: TESTIMONIALS
══════════════════════════════════════════════════════ --}}
<section style="padding: 100px 0; background: #f8fffe;" id="testimonials">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag">Real Stories</div>
            <h2 class="section-title">What Our Users Say</h2>
        </div>

        <div class="row g-4">

            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="stars mb-3">★★★★★</div>
                    <p class="text-muted mb-4" style="font-size:.95rem; line-height:1.7; padding-top:10px;">
                        "Earlier I used to spend ₹4,500 for a truck to take my wheat to Ahmedabad market.
                        Now with AgriPool I share with 3 other farmers and pay only ₹1,200.
                        That money I save goes back into my farm."
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-circle" style="background:#2d6a4f;">RP</div>
                        <div>
                            <div class="fw-bold small">Ramesh Patel</div>
                            <div class="text-muted" style="font-size:.8rem;">
                                Wheat Farmer, Anand, Gujarat
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="stars mb-3">★★★★★</div>
                    <p class="text-muted mb-4" style="font-size:.95rem; line-height:1.7; padding-top:10px;">
                        "As a driver, AgriPool gives me consistent work.
                        Instead of waiting around for one full load, I get matched
                        with multiple farmers and my truck is always full.
                        My earnings went up by 40% in the first month."
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-circle" style="background:#1d3557;">MS</div>
                        <div>
                            <div class="fw-bold small">Mohan Singh</div>
                            <div class="text-muted" style="font-size:.8rem;">
                                Truck Driver, Anand, Gujarat
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="stars mb-3">★★★★☆</div>
                    <p class="text-muted mb-4" style="font-size:.95rem; line-height:1.7; padding-top:10px;">
                        "The tracking feature is my favourite part.
                        I can see exactly when my vegetables are loaded,
                        when the truck is moving, and when it reaches
                        the market. No more waiting by the phone all day."
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-circle" style="background:#e76f51;">SD</div>
                        <div>
                            <div class="fw-bold small">Sunita Devi</div>
                            <div class="text-muted" style="font-size:.8rem;">
                                Vegetable Farmer, Borsad, Gujarat
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     SECTION 6: CONTACT
══════════════════════════════════════════════════════ --}}
<section style="padding: 100px 0; background:#fff;" id="contact">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag">Get In Touch</div>
            <h2 class="section-title">We're Here to Help</h2>
            <p class="text-muted mt-2">
                Have a question? Send us a message and we'll get back to you within 24 hours.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="contact-card">
                    <div class="row g-0">

                        {{-- Left info panel --}}
                        <div class="col-lg-4 contact-left">
                            <h4 class="fw-bold mb-2">Contact Information</h4>
                            <p style="color:rgba(255,255,255,.7);font-size:.9rem;" class="mb-4">
                                Fill out the form and our team will respond as soon as possible.
                            </p>

                            <div class="contact-info-item">
                                <div class="contact-icon">📞</div>
                                <div>
                                    <div style="font-size:.8rem;color:rgba(255,255,255,.6);">Phone</div>
                                    <div class="fw-semibold">+91 90000 00001</div>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-icon">✉️</div>
                                <div>
                                    <div style="font-size:.8rem;color:rgba(255,255,255,.6);">Email</div>
                                    <div class="fw-semibold">support@agripool.com</div>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-icon">📍</div>
                                <div>
                                    <div style="font-size:.8rem;color:rgba(255,255,255,.6);">Office</div>
                                    <div class="fw-semibold">Anand, Gujarat — 388001</div>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-icon">🕐</div>
                                <div>
                                    <div style="font-size:.8rem;color:rgba(255,255,255,.6);">Hours</div>
                                    <div class="fw-semibold">Mon–Sat: 9AM – 6PM</div>
                                </div>
                            </div>
                        </div>

                        {{-- Right form --}}
                        <div class="col-lg-8 contact-right">

                            @if(session('success'))
                                <div class="alert alert-success rounded-3 mb-4">
                                    ✅ {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('contact.submit') }}">
                                @csrf

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Your Name</label>
                                        <input type="text" name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}"
                                               placeholder="Ramesh Patel">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Email Address</label>
                                        <input type="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}"
                                               placeholder="you@example.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Subject</label>
                                    <select name="subject"
                                            class="form-select @error('subject') is-invalid @enderror">
                                        <option value="">Select a topic</option>
                                        <option value="General Inquiry"
                                            {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>
                                            General Inquiry
                                        </option>
                                        <option value="Driver Registration"
                                            {{ old('subject') == 'Driver Registration' ? 'selected' : '' }}>
                                            Driver Registration
                                        </option>
                                        <option value="Shipment Issue"
                                            {{ old('subject') == 'Shipment Issue' ? 'selected' : '' }}>
                                            Shipment Issue
                                        </option>
                                        <option value="Billing / Payment"
                                            {{ old('subject') == 'Billing / Payment' ? 'selected' : '' }}>
                                            Billing / Payment
                                        </option>
                                        <option value="Technical Support"
                                            {{ old('subject') == 'Technical Support' ? 'selected' : '' }}>
                                            Technical Support
                                        </option>
                                        <option value="Partnership"
                                            {{ old('subject') == 'Partnership' ? 'selected' : '' }}>
                                            Partnership
                                        </option>
                                    </select>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold small">Message</label>
                                    <textarea name="message" rows="5"
                                              class="form-control @error('message') is-invalid @enderror"
                                              placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-green px-5 py-2 fw-bold">
                                    Send Message →
                                </button>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     SECTION 7: CTA BANNER
══════════════════════════════════════════════════════ --}}
<section style="padding:80px 0;
    background: linear-gradient(135deg, #1b4332, #2d6a4f);">
    <div class="container text-center">
        <h2 class="fw-bold text-white mb-3" style="font-size:2.2rem;">
            Ready to Save on Transport Costs?
        </h2>
        <p style="color:rgba(255,255,255,.8);font-size:1.1rem;" class="mb-4">
            Join thousands of farmers already using AgriPool across Gujarat.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-hero-primary px-5 py-3">
                🌾 Register as Farmer
            </a>
            <a href="{{ route('register') }}" class="btn btn-hero-outline px-5 py-3">
                🚛 Register as Driver
            </a>
        </div>
    </div>
</section>

@endsection