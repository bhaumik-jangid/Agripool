@extends('layouts.public')
@section('title', 'Contact Us — AgriPool')

@section('content')

<div style="padding-top: 100px; padding-bottom: 80px; background:#f8fffe; min-height:100vh;">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag">Support</div>
            <h2 class="section-title">Contact Our Team</h2>
            <p class="text-muted mt-2">
                We respond to all messages within 24 hours on business days.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="contact-card">
                    <div class="row g-0">

                        <div class="col-lg-4 contact-left">
                            <h4 class="fw-bold mb-2">Contact Information</h4>
                            <p style="color:rgba(255,255,255,.7);font-size:.9rem;" class="mb-4">
                                Reach us through any of these channels.
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
                                    <div style="font-size:.8rem;color:rgba(255,255,255,.6);">Location</div>
                                    <div class="fw-semibold">Anand, Gujarat — 388001</div>
                                </div>
                            </div>

                            <div class="mt-4 p-3 rounded-3" style="background:rgba(255,255,255,.1);">
                                <div class="fw-bold small mb-1">Office Hours</div>
                                <div style="font-size:.85rem;color:rgba(255,255,255,.7);">
                                    Monday – Saturday<br>9:00 AM – 6:00 PM IST
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 contact-right">

                            @if(session('success'))
                                <div class="alert alert-success rounded-3 mb-4">
                                    ✅ {{ session('success') }}
                                </div>
                            @endif

                            <h5 class="fw-bold mb-4">Send Us a Message</h5>

                            <form method="POST" action="{{ route('contact.submit') }}">
                                @csrf

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Name</label>
                                        <input type="text" name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}" placeholder="Your name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small">Email</label>
                                        <input type="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}" placeholder="you@example.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Subject</label>
                                    <select name="subject"
                                            class="form-select @error('subject') is-invalid @enderror">
                                        <option value="">Choose a topic</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Driver Registration">Driver Registration</option>
                                        <option value="Shipment Issue">Shipment Issue</option>
                                        <option value="Billing / Payment">Billing / Payment</option>
                                        <option value="Technical Support">Technical Support</option>
                                        <option value="Partnership">Partnership</option>
                                    </select>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold small">Message</label>
                                    <textarea name="message" rows="6"
                                              class="form-control @error('message') is-invalid @enderror"
                                              placeholder="Describe your issue or question in detail...">{{ old('message') }}</textarea>
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
</div>

@endsection