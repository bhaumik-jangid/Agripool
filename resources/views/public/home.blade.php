@extends('layouts.public')
@section('title', 'AgriPool — Smart Agricultural Transport Sharing')

@section('content')

{{-- ============================================================
     PREMIUM CSS SYSTEM
============================================================ --}}
<style>
/* ── Design tokens ── */
:root {
    --g-900: #0a1628;
    --g-800: #0f2137;
    --g-700: #1a3a4a;
    --green-900: #0d2b1e;
    --green-700: #1a4731;
    --green-600: #2d6a4f;
    --green-500: #3d8b6b;
    --green-400: #52b788;
    --green-300: #74c69d;
    --green-100: #d8f3dc;
    --green-50:  #f0fdf4;
    --amber:     #f59e0b;
    --amber-light:#fef3c7;
    --text-primary:   #0f172a;
    --text-secondary: #475569;
    --text-muted:     #94a3b8;
    --border:         rgba(0,0,0,.07);
    --border-light:   rgba(255,255,255,.08);
    --ease-out: cubic-bezier(0.22,1,0.36,1);
    --ease-in-out: cubic-bezier(0.4,0,0.2,1);
    --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
    --shadow-md: 0 4px 16px rgba(0,0,0,.08), 0 2px 6px rgba(0,0,0,.04);
    --shadow-lg: 0 12px 40px rgba(0,0,0,.12), 0 4px 12px rgba(0,0,0,.06);
    --shadow-green: 0 8px 32px rgba(45,106,79,.2);
}

/* ── Reset & base ── */
*, *::before, *::after { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body {
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
    color: var(--text-primary);
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
}

/* ── ═══════════════════════════════════════════════════
   NAVBAR
═══════════════════════════════════════════════════ ── */
.nav-premium {
    position: fixed; top: 0; left: 0; right: 0;
    z-index: 1000;
    padding: 16px 0;
    transition: padding 300ms var(--ease-out),
                background 300ms var(--ease-out),
                box-shadow 300ms var(--ease-out);
}
.nav-premium.scrolled {
    padding: 10px 0;
    background: rgba(255,255,255,.88);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 1px 0 rgba(0,0,0,.06), var(--shadow-sm);
}
.nav-logo-mark {
    width: 34px; height: 34px; border-radius: 9px;
    background: linear-gradient(135deg, var(--green-600), var(--green-400));
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(45,106,79,.3);
    transition: transform 200ms var(--ease-out);
}
.nav-logo-mark:hover { transform: scale(1.05); }
.nav-brand-text {
    font-size: 1.15rem; font-weight: 800;
    color: #fff; letter-spacing: -.3px;
    transition: color 300ms ease;
}
.nav-premium.scrolled .nav-brand-text { color: var(--text-primary); }
.nav-link-item {
    color: rgba(255,255,255,.8);
    text-decoration: none;
    font-size: .875rem; font-weight: 500;
    padding: 6px 12px; border-radius: 8px;
    transition: color 200ms ease, background 200ms ease;
}
.nav-link-item:hover {
    color: #fff;
    background: rgba(255,255,255,.1);
}
.nav-premium.scrolled .nav-link-item {
    color: var(--text-secondary);
}
.nav-premium.scrolled .nav-link-item:hover {
    color: var(--green-600);
    background: var(--green-50);
}
.btn-nav-ghost {
    color: rgba(255,255,255,.9);
    border: 1.5px solid rgba(255,255,255,.25);
    background: transparent;
    border-radius: 9px;
    padding: 7px 18px;
    font-size: .875rem; font-weight: 600;
    text-decoration: none;
    transition: all 200ms var(--ease-out);
}
.btn-nav-ghost:hover {
    background: rgba(255,255,255,.1);
    border-color: rgba(255,255,255,.5);
    color: #fff;
    transform: translateY(-1px);
}
.nav-premium.scrolled .btn-nav-ghost {
    color: var(--text-secondary);
    border-color: var(--border);
}
.nav-premium.scrolled .btn-nav-ghost:hover {
    background: var(--green-50);
    color: var(--green-600);
}
.btn-nav-primary {
    background: linear-gradient(135deg, var(--green-600), var(--green-500));
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 8px 20px;
    font-size: .875rem; font-weight: 600;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(45,106,79,.25);
    transition: all 200ms var(--ease-out);
}
.btn-nav-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(45,106,79,.35);
    filter: brightness(1.05);
    color: #fff;
}
.btn-nav-primary:active {
    transform: translateY(0) scale(.98);
}

/* ── ═══════════════════════════════════════════════════
   HERO
═══════════════════════════════════════════════════ ── */
.hero {
    min-height: 100vh;
    background:
        radial-gradient(ellipse 80% 60% at 50% -20%,
            rgba(52,183,136,.18) 0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 90% 50%,
            rgba(45,106,79,.12) 0%, transparent 60%),
        linear-gradient(160deg, #0a1628 0%, #0d2b1e 40%, #0f2137 100%);
    display: flex; align-items: center;
    padding-top: 90px;
    position: relative; overflow: hidden;
}

/* Ambient blobs */
.hero-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    will-change: transform;
}
.hero-blob-1 {
    width: 600px; height: 600px;
    background: radial-gradient(circle,
        rgba(52,183,136,.12) 0%, transparent 70%);
    top: -100px; right: -100px;
    animation: blobFloat 8s ease-in-out infinite alternate;
}
.hero-blob-2 {
    width: 400px; height: 400px;
    background: radial-gradient(circle,
        rgba(245,158,11,.06) 0%, transparent 70%);
    bottom: 0; left: -50px;
    animation: blobFloat 10s ease-in-out infinite alternate-reverse;
}
@keyframes blobFloat {
    from { transform: translate(0,0) scale(1); }
    to   { transform: translate(30px,20px) scale(1.05); }
}

/* Grid lines */
.hero-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size: 80px 80px;
    pointer-events: none;
}

.hero-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(52,183,136,.12);
    border: 1px solid rgba(52,183,136,.2);
    color: var(--green-300);
    padding: 6px 14px; border-radius: 50px;
    font-size: .78rem; font-weight: 600;
    letter-spacing: .04em; text-transform: uppercase;
    margin-bottom: 24px;
}
.hero-eyebrow-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--green-400);
    animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: .5; transform: scale(.8); }
}

.hero-title {
    font-size: clamp(2.4rem, 5.5vw, 4.2rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.08;
    letter-spacing: -1.5px;
    margin-bottom: 24px;
}
.hero-title-accent {
    background: linear-gradient(135deg, var(--green-300), var(--green-400));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-subtitle {
    font-size: 1.1rem;
    color: rgba(255,255,255,.6);
    line-height: 1.75;
    max-width: 500px;
    margin-bottom: 40px;
}

/* Hero CTA buttons */
.btn-hero-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: linear-gradient(135deg, var(--green-600), var(--green-500));
    color: #fff; border: none;
    padding: 14px 28px; border-radius: 12px;
    font-size: .95rem; font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(45,106,79,.35),
                0 0 0 1px rgba(52,183,136,.15);
    transition: all 240ms var(--ease-out);
}
.btn-hero-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(45,106,79,.45),
                0 0 0 1px rgba(52,183,136,.25);
    color: #fff;
}
.btn-hero-primary:active {
    transform: translateY(0) scale(.98);
}
.btn-hero-secondary {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.07);
    color: rgba(255,255,255,.85);
    border: 1px solid rgba(255,255,255,.12);
    padding: 14px 28px; border-radius: 12px;
    font-size: .95rem; font-weight: 600;
    text-decoration: none;
    transition: all 240ms var(--ease-out);
    backdrop-filter: blur(8px);
}
.btn-hero-secondary:hover {
    background: rgba(255,255,255,.12);
    border-color: rgba(255,255,255,.2);
    color: #fff;
    transform: translateY(-2px);
}

/* Trust row */
.trust-row {
    display: flex; align-items: center; gap: 24px;
    flex-wrap: wrap;
    margin-top: 48px;
}
.trust-item {
    display: flex; align-items: center; gap: 8px;
    color: rgba(255,255,255,.5);
    font-size: .82rem; font-weight: 500;
}
.trust-check {
    width: 18px; height: 18px; border-radius: 50%;
    background: rgba(52,183,136,.15);
    border: 1px solid rgba(52,183,136,.3);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

/* Hero glass card */
.hero-glass-card {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 24px;
    padding: 32px;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow:
        0 0 0 1px rgba(255,255,255,.04) inset,
        var(--shadow-lg);
}
.hero-stat-item {
    padding: 20px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 14px;
    transition: background 200ms ease, border-color 200ms ease;
}
.hero-stat-item:hover {
    background: rgba(255,255,255,.07);
    border-color: rgba(52,183,136,.2);
}
.hero-stat-num {
    font-size: 1.9rem; font-weight: 800;
    color: var(--green-300);
    letter-spacing: -1px; line-height: 1;
}
.hero-stat-label {
    font-size: .72rem; color: rgba(255,255,255,.45);
    font-weight: 500; margin-top: 4px;
    text-transform: uppercase; letter-spacing: .04em;
}
.hero-steps-list {
    list-style: none; padding: 0; margin: 0;
}
.hero-step {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,.05);
    transition: opacity 200ms ease;
}
.hero-step:last-child { border-bottom: none; }
.hero-step-num {
    width: 26px; height: 26px; border-radius: 8px;
    background: rgba(52,183,136,.15);
    border: 1px solid rgba(52,183,136,.25);
    color: var(--green-300);
    font-size: .72rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-top: 1px;
}
.hero-step-text {
    font-size: .87rem; color: rgba(255,255,255,.7);
    font-weight: 500; line-height: 1.5;
}

/* ── Stagger reveal ── */
.reveal {
    opacity: 0;
    transform: translateY(24px);
    transition:
        opacity 600ms var(--ease-out),
        transform 600ms var(--ease-out);
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}
.reveal-delay-1 { transition-delay: 80ms; }
.reveal-delay-2 { transition-delay: 160ms; }
.reveal-delay-3 { transition-delay: 240ms; }
.reveal-delay-4 { transition-delay: 320ms; }
.reveal-delay-5 { transition-delay: 400ms; }

/* ── ═══════════════════════════════════════════════════
   SECTION SYSTEM
═══════════════════════════════════════════════════ ── */
.section { padding: 100px 0; }
.section-sm { padding: 72px 0; }
.section-tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--green-50);
    border: 1px solid var(--green-100);
    color: var(--green-600);
    padding: 5px 14px; border-radius: 50px;
    font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    margin-bottom: 16px;
}
.section-title {
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1.15;
    letter-spacing: -1px;
}
.section-sub {
    font-size: 1.05rem;
    color: var(--text-secondary);
    line-height: 1.7;
    max-width: 540px; margin: 0 auto;
}

/* ── ═══════════════════════════════════════════════════
   HOW IT WORKS
═══════════════════════════════════════════════════ ── */
.how-section { background: #fff; }
.step-card {
    position: relative;
    padding: 36px 30px;
    border-radius: 20px;
    background: #fff;
    border: 1px solid rgba(0,0,0,.06);
    box-shadow: var(--shadow-sm);
    transition:
        box-shadow 300ms var(--ease-out),
        transform 300ms var(--ease-out),
        border-color 300ms ease;
    height: 100%;
    overflow: hidden;
}
.step-card::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg,
        rgba(45,106,79,.03) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 300ms ease;
}
.step-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-4px);
    border-color: rgba(45,106,79,.12);
}
.step-card:hover::before { opacity: 1; }
.step-number-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 44px; height: 44px; border-radius: 13px;
    background: linear-gradient(135deg, var(--green-600), var(--green-400));
    color: #fff; font-size: 1.1rem; font-weight: 800;
    box-shadow: 0 4px 12px rgba(45,106,79,.3);
    margin-bottom: 20px;
    transition: transform 200ms var(--ease-out);
}
.step-card:hover .step-number-badge {
    transform: scale(1.08) rotate(-3deg);
}
.step-icon-wrap {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--green-50);
    border: 1px solid var(--green-100);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 18px;
    transition: background 200ms ease, transform 200ms var(--ease-out);
}
.step-card:hover .step-icon-wrap {
    background: var(--green-100);
    transform: scale(1.05);
}
.step-label {
    font-size: 1.05rem; font-weight: 700;
    color: var(--text-primary); margin-bottom: 10px;
    letter-spacing: -.2px;
}
.step-desc {
    font-size: .875rem; color: var(--text-secondary);
    line-height: 1.65;
}
.step-connector {
    display: flex; align-items: center; justify-content: center;
    color: var(--green-300); opacity: .5;
    padding-top: 40px;
}

/* ── ═══════════════════════════════════════════════════
   BENEFITS
═══════════════════════════════════════════════════ ── */
.benefits-section {
    background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);
}
.benefit-card {
    padding: 32px 28px;
    border-radius: 18px;
    background: #fff;
    border: 1px solid rgba(0,0,0,.06);
    box-shadow: var(--shadow-sm);
    height: 100%;
    transition:
        box-shadow 300ms var(--ease-out),
        transform 300ms var(--ease-out),
        border-color 300ms ease;
    position: relative; overflow: hidden;
}
.benefit-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg,
        var(--green-400), var(--green-300));
    opacity: 0;
    transition: opacity 300ms ease;
}
.benefit-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-3px);
    border-color: rgba(45,106,79,.1);
}
.benefit-card:hover::after { opacity: 1; }
.benefit-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--green-50);
    border: 1px solid var(--green-100);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 20px;
    transition: transform 250ms var(--ease-out), background 200ms ease;
}
.benefit-card:hover .benefit-icon {
    transform: scale(1.08);
    background: var(--green-100);
}
.benefit-title {
    font-size: 1rem; font-weight: 700;
    color: var(--text-primary); margin-bottom: 10px;
    letter-spacing: -.2px;
}
.benefit-desc {
    font-size: .865rem;
    color: var(--text-secondary);
    line-height: 1.65;
}

/* ── ═══════════════════════════════════════════════════
   STATS
═══════════════════════════════════════════════════ ── */
.stats-section {
    background: linear-gradient(135deg, var(--green-900) 0%, var(--green-700) 100%);
    position: relative; overflow: hidden;
}
.stats-section::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
        radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
}
.stats-section::after {
    content: '';
    position: absolute;
    top: -50%; right: -10%;
    width: 500px; height: 500px; border-radius: 50%;
    background: radial-gradient(circle,
        rgba(52,183,136,.15) 0%, transparent 70%);
    pointer-events: none;
}
.stat-block {
    position: relative; text-align: center;
    padding: 32px 16px;
    z-index: 1;
}
.stat-block + .stat-block {
    border-left: 1px solid rgba(255,255,255,.08);
}
.stat-num-display {
    font-size: 3.2rem; font-weight: 900;
    color: #fff; letter-spacing: -2px;
    line-height: 1;
    background: linear-gradient(135deg, #fff, rgba(255,255,255,.8));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.stat-num-suffix {
    font-size: 2rem; font-weight: 800;
    background: linear-gradient(135deg,
        var(--green-300), var(--green-400));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.stat-label-display {
    color: rgba(255,255,255,.55);
    font-size: .82rem; font-weight: 500;
    margin-top: 8px;
    text-transform: uppercase; letter-spacing: .06em;
}
.stat-desc {
    font-size: .78rem;
    color: rgba(255,255,255,.3);
    margin-top: 4px;
}

/* ── ═══════════════════════════════════════════════════
   TESTIMONIALS
═══════════════════════════════════════════════════ ── */
.testimonials-section { background: #fff; }
.testimonial-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,.06);
    border-radius: 20px;
    padding: 36px;
    box-shadow: var(--shadow-sm);
    height: 100%;
    position: relative; overflow: hidden;
    transition:
        box-shadow 300ms var(--ease-out),
        transform 300ms var(--ease-out);
}
.testimonial-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-3px);
}
.testimonial-card::before {
    content: '\201C';
    position: absolute;
    top: 20px; right: 28px;
    font-size: 5rem; line-height: 1;
    font-family: Georgia, serif;
    color: var(--green-100);
    pointer-events: none;
}
.stars {
    display: flex; gap: 3px; margin-bottom: 18px;
}
.star {
    width: 14px; height: 14px;
    color: var(--amber);
}
.testimonial-text {
    font-size: .925rem;
    color: var(--text-secondary);
    line-height: 1.75;
    margin-bottom: 24px;
    position: relative; z-index: 1;
}
.testimonial-text strong {
    color: var(--green-600);
    font-weight: 600;
}
.testimonial-author {
    display: flex; align-items: center; gap: 14px;
}
.author-avatar {
    width: 46px; height: 46px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; font-weight: 700;
    color: #fff; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
}
.author-name {
    font-size: .9rem; font-weight: 700;
    color: var(--text-primary); letter-spacing: -.1px;
}
.author-role {
    font-size: .78rem; color: var(--text-muted);
    margin-top: 2px;
}
.featured-quote {
    background: linear-gradient(135deg, var(--green-50), #fff);
    border: 1px solid var(--green-100);
    border-radius: 20px;
    padding: 40px;
    position: relative;
    overflow: hidden;
}
.featured-quote::before {
    content: '';
    position: absolute;
    top: -20px; right: -20px;
    width: 120px; height: 120px; border-radius: 50%;
    background: radial-gradient(circle,
        rgba(45,106,79,.08) 0%, transparent 70%);
}

/* ── ═══════════════════════════════════════════════════
   CONTACT
═══════════════════════════════════════════════════ ── */
.contact-section {
    background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);
}
.contact-glass {
    background: #fff;
    border: 1px solid rgba(0,0,0,.06);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}
.contact-left {
    background: linear-gradient(160deg,
        var(--green-900) 0%, var(--green-700) 100%);
    padding: 52px 40px;
    position: relative; overflow: hidden;
}
.contact-left::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 80% 80% at 120% 50%,
        rgba(52,183,136,.15) 0%, transparent 70%);
}
.contact-left::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(52,183,136,.06);
    pointer-events: none;
}
.contact-info-block {
    display: flex; align-items: flex-start; gap: 16px;
    margin-bottom: 28px; position: relative; z-index: 1;
}
.contact-icon-box {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.08);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: background 200ms ease;
}
.contact-info-block:hover .contact-icon-box {
    background: rgba(52,183,136,.2);
}
.contact-info-label {
    font-size: .7rem; color: rgba(255,255,255,.4);
    font-weight: 600; text-transform: uppercase;
    letter-spacing: .06em; margin-bottom: 3px;
}
.contact-info-value {
    font-size: .9rem; font-weight: 600; color: #fff;
}
.contact-right {
    background: #fff; padding: 52px 40px;
}

/* Premium form inputs */
.form-field-wrap { position: relative; margin-bottom: 20px; }
.form-input-premium {
    width: 100%;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 13px 16px;
    font-size: .9rem;
    color: var(--text-primary);
    background: #fff;
    outline: none;
    transition:
        border-color 200ms ease,
        box-shadow 200ms ease,
        background 200ms ease;
    font-family: inherit;
}
.form-input-premium:focus {
    border-color: var(--green-500);
    box-shadow: 0 0 0 3px rgba(52,183,136,.12);
    background: #fafff9;
}
.form-input-premium.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,.1);
}
.form-label-premium {
    display: block; font-size: .8rem;
    font-weight: 600; color: var(--text-secondary);
    margin-bottom: 7px; letter-spacing: .01em;
}
.form-select-premium {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 40px;
    cursor: pointer;
}
.btn-contact-submit {
    width: 100%;
    background: linear-gradient(135deg, var(--green-600), var(--green-500));
    color: #fff; border: none;
    padding: 14px 24px; border-radius: 12px;
    font-size: .95rem; font-weight: 700;
    cursor: pointer; font-family: inherit;
    box-shadow: 0 4px 16px rgba(45,106,79,.25);
    transition: all 220ms var(--ease-out);
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.btn-contact-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(45,106,79,.35);
}
.btn-contact-submit:active {
    transform: translateY(0) scale(.98);
}

/* ── ═══════════════════════════════════════════════════
   CTA
═══════════════════════════════════════════════════ ── */
.cta-section {
    background: linear-gradient(135deg,
        var(--green-900) 0%, var(--green-700) 100%);
    position: relative; overflow: hidden;
}
.cta-section::before {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 800px; height: 400px; border-radius: 50%;
    background: radial-gradient(circle,
        rgba(52,183,136,.12) 0%, transparent 70%);
    pointer-events: none;
}
.cta-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 900; color: #fff;
    letter-spacing: -1px; line-height: 1.15;
}
.cta-sub {
    color: rgba(255,255,255,.55);
    font-size: 1.05rem; line-height: 1.6;
}
.btn-cta-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: #fff;
    color: var(--green-700);
    border: none; border-radius: 12px;
    padding: 15px 32px;
    font-size: .95rem; font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0,0,0,.15);
    transition: all 220ms var(--ease-out);
}
.btn-cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0,0,0,.25);
    color: var(--green-700);
}
.btn-cta-primary:active { transform: translateY(0) scale(.98); }
.btn-cta-secondary {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.08);
    color: rgba(255,255,255,.85);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 12px; padding: 14px 32px;
    font-size: .95rem; font-weight: 600;
    text-decoration: none;
    transition: all 220ms var(--ease-out);
}
.btn-cta-secondary:hover {
    background: rgba(255,255,255,.14);
    border-color: rgba(255,255,255,.25);
    color: #fff;
    transform: translateY(-2px);
}

/* ── ═══════════════════════════════════════════════════
   FOOTER
═══════════════════════════════════════════════════ ── */
.footer-premium {
    background: var(--g-900);
    padding: 72px 0 0;
}
.footer-brand-mark {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg, var(--green-600), var(--green-400));
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 16px;
}
.footer-brand-name {
    font-size: 1.1rem; font-weight: 800;
    color: #fff; letter-spacing: -.3px;
    margin-bottom: 10px;
}
.footer-tagline {
    font-size: .855rem;
    color: rgba(255,255,255,.35);
    line-height: 1.65; max-width: 240px;
}
.footer-col-title {
    font-size: .72rem; font-weight: 700;
    color: rgba(255,255,255,.35);
    text-transform: uppercase; letter-spacing: .08em;
    margin-bottom: 16px;
}
.footer-link {
    display: block; color: rgba(255,255,255,.5);
    text-decoration: none; font-size: .875rem;
    margin-bottom: 10px; font-weight: 400;
    transition: color 180ms ease, transform 180ms ease;
}
.footer-link:hover {
    color: rgba(255,255,255,.9);
    transform: translateX(3px);
}
.footer-divider {
    border: none;
    border-top: 1px solid rgba(255,255,255,.06);
    margin: 48px 0 0;
}
.footer-bottom {
    padding: 20px 0;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 12px;
}
.footer-copy {
    font-size: .8rem; color: rgba(255,255,255,.25);
}
.footer-badge {
    font-size: .78rem; color: rgba(255,255,255,.2);
    display: flex; align-items: center; gap: 6px;
}
.footer-dot {
    width: 4px; height: 4px; border-radius: 50%;
    background: rgba(52,183,136,.4);
}

/* ── Dividers ── */
.section-divider {
    height: 1px;
    background: linear-gradient(90deg,
        transparent 0%, rgba(0,0,0,.06) 30%,
        rgba(0,0,0,.06) 70%, transparent 100%);
}

/* ── Alert success ── */
.alert-premium-success {
    background: var(--green-50);
    border: 1px solid var(--green-100);
    border-left: 3px solid var(--green-400);
    border-radius: 12px;
    padding: 14px 18px;
    color: var(--green-700);
    font-size: .9rem; font-weight: 500;
    display: flex; align-items: center; gap: 10px;
}
</style>

{{-- ============================================================
     NAVBAR
============================================================ --}}
<nav class="nav-premium" id="mainNav">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">

            {{-- Brand --}}
            <a href="{{ route('home') }}"
               class="text-decoration-none d-flex align-items-center gap-2">
                <div class="nav-logo-mark">
                    <svg width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="#fff" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a10 10 0 0 1 10 10"/>
                        <path d="M12 2C6.5 2 2 6.5 2 12"/>
                        <path d="M12 22C6.5 22 2 17.5 2 12"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
                <span class="nav-brand-text">AgriPool</span>
            </a>

            {{-- Desktop nav --}}
            <div class="d-none d-lg-flex align-items-center gap-1">
                <a href="#how-it-works" class="nav-link-item">How It Works</a>
                <a href="#benefits" class="nav-link-item">Benefits</a>
                <a href="#testimonials" class="nav-link-item">Stories</a>
                <a href="#contact" class="nav-link-item">Contact</a>
            </div>

            {{-- Auth buttons --}}
            <div class="d-flex align-items-center gap-2">
                @auth
                    @if(Auth::user()->isFarmer())
                        <a href="{{ route('farmer.dashboard') }}"
                           class="btn-nav-primary">Dashboard</a>
                    @elseif(Auth::user()->isDriver())
                        <a href="{{ route('driver.dashboard') }}"
                           class="btn-nav-primary">Dashboard</a>
                    @else
                        <a href="{{ route('admin.dashboard') }}"
                           class="btn-nav-primary">Admin Panel</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-nav-ghost">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="btn-nav-primary">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ============================================================
     HERO
============================================================ --}}
<section class="hero" id="home">
    <div class="hero-grid"></div>
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>

    <div class="container position-relative" style="z-index:2;padding:80px 0;">
        <div class="row align-items-center g-5">

            {{-- Left --}}
            <div class="col-lg-6">

                <div class="hero-eyebrow reveal">
                    <span class="hero-eyebrow-dot"></span>
                    Smart Transport Sharing
                </div>

                <h1 class="hero-title reveal reveal-delay-1">
                    Share the Road.<br>
                    <span class="hero-title-accent">Split the Cost.</span><br>
                    Reach Markets.
                </h1>

                <p class="hero-subtitle reveal reveal-delay-2">
                    AgriPool connects farmers going to the same market
                    so you can share a truck, cut transport costs by up to
                    <strong style="color:rgba(255,255,255,.85);">60%</strong>,
                    and track your produce every step of the way.
                </p>

                <div class="d-flex flex-wrap gap-3 reveal reveal-delay-3">
                    <a href="{{ route('register') }}"
                       class="btn-hero-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12l7 7 7-7"/>
                        </svg>
                        Start for Free
                    </a>
                    <a href="#how-it-works" class="btn-hero-secondary">
                        See How It Works
                    </a>
                </div>

                <div class="trust-row reveal reveal-delay-4">
                    <div class="trust-item">
                        <div class="trust-check">
                            <svg width="10" height="10" viewBox="0 0 24 24"
                                 fill="none" stroke="#52b788" stroke-width="3"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                        </div>
                        Free to join
                    </div>
                    <div class="trust-item">
                        <div class="trust-check">
                            <svg width="10" height="10" viewBox="0 0 24 24"
                                 fill="none" stroke="#52b788" stroke-width="3"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                        </div>
                        Verified drivers
                    </div>
                    <div class="trust-item">
                        <div class="trust-check">
                            <svg width="10" height="10" viewBox="0 0 24 24"
                                 fill="none" stroke="#52b788" stroke-width="3"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                        </div>
                        Live tracking
                    </div>
                </div>
            </div>

            {{-- Right — glass panel --}}
            <div class="col-lg-6 reveal reveal-delay-2">
                <div class="hero-glass-card">

                    {{-- Platform stats --}}
                    <div style="font-size:.7rem;color:rgba(255,255,255,.35);
                                font-weight:700;text-transform:uppercase;
                                letter-spacing:.08em;margin-bottom:14px;">
                        Platform Overview
                    </div>
                    <div class="row g-2 mb-4">
                        @foreach([
                            ['2,400+', 'Registered Farmers'],
                            ['380+',   'Verified Drivers'],
                            ['12,000+','Deliveries Done'],
                            ['₹48L+',  'Saved by Farmers'],
                        ] as $stat)
                            <div class="col-6">
                                <div class="hero-stat-item">
                                    <div class="hero-stat-num">
                                        {{ $stat[0] }}
                                    </div>
                                    <div class="hero-stat-label">
                                        {{ $stat[1] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Divider --}}
                    <div style="height:1px;background:rgba(255,255,255,.06);
                                margin-bottom:20px;"></div>

                    {{-- Quick steps --}}
                    <div style="font-size:.7rem;color:rgba(255,255,255,.35);
                                font-weight:700;text-transform:uppercase;
                                letter-spacing:.08em;margin-bottom:14px;">
                        How It Works
                    </div>
                    <ul class="hero-steps-list">
                        @foreach([
                            'Post your crop transport request',
                            'Get matched with nearby farmers',
                            'Share truck — pay only your share',
                            'Track delivery to market live',
                        ] as $i => $step)
                            <li class="hero-step">
                                <div class="hero-step-num">
                                    {{ $i + 1 }}
                                </div>
                                <div class="hero-step-text">
                                    {{ $step }}
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     HOW IT WORKS
============================================================ --}}
<section class="section how-section" id="how-it-works">
    <div class="container">

        <div class="text-center mb-5 reveal">
            <div class="section-tag">Simple Process</div>
            <h2 class="section-title mt-2">How AgriPool Works</h2>
            <p class="section-sub mt-3">
                From posting your request to deliver at market —
                four clear steps, zero confusion.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">

            @php
                $steps = [
                    [
                        'num'   => '01',
                        'icon'  => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10,9 9,9 8,9"/>',
                        'label' => 'Post Your Request',
                        'desc'  => 'Enter crop type, quantity, pickup location, and destination market. Takes under 2 minutes.',
                    ],
                    [
                        'num'   => '02',
                        'icon'  => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                        'label' => 'Get Matched',
                        'desc'  => 'Our system finds farmers going to the same market on the same date and groups you into a shared pool.',
                    ],
                    [
                        'num'   => '03',
                        'icon'  => '<rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
                        'label' => 'Share the Truck',
                        'desc'  => 'A verified driver accepts your pool. Each farmer pays only for the space their cargo uses.',
                    ],
                    [
                        'num'   => '04',
                        'icon'  => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
                        'label' => 'Track and Deliver',
                        'desc'  => 'Follow your shipment live from pickup to market. Rate your driver and confirm payment on delivery.',
                    ],
                ];
            @endphp

            @foreach($steps as $i => $step)
                <div class="col-sm-6 col-lg-3 reveal reveal-delay-{{ $i + 1 }}">
                    <div class="step-card">
                        <div style="display:flex;align-items:center;
                                    justify-content:space-between;
                                    margin-bottom:20px;">
                            <div class="step-number-badge">
                                {{ $step['num'] }}
                            </div>
                            <div style="font-size:2rem;font-weight:900;
                                        color:rgba(45,106,79,.06);
                                        letter-spacing:-2px;
                                        font-variant-numeric:tabular-nums;">
                                {{ $step['num'] }}
                            </div>
                        </div>
                        <div class="step-icon-wrap">
                            <svg width="22" height="22" viewBox="0 0 24 24"
                                 fill="none" stroke="#2d6a4f" stroke-width="1.75"
                                 stroke-linecap="round" stroke-linejoin="round">
                                {!! $step['icon'] !!}
                            </svg>
                        </div>
                        <div class="step-label">{{ $step['label'] }}</div>
                        <div class="step-desc">{{ $step['desc'] }}</div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="text-center mt-5 reveal">
            <a href="{{ route('register') }}"
               style="display:inline-flex;align-items:center;gap:8px;
                      background:linear-gradient(135deg,#2d6a4f,#3d8b6b);
                      color:#fff;border-radius:12px;padding:14px 32px;
                      font-weight:700;font-size:.95rem;text-decoration:none;
                      box-shadow:0 4px 20px rgba(45,106,79,.25);
                      transition:all 220ms cubic-bezier(0.22,1,0.36,1);"
               onmouseover="this.style.transform='translateY(-2px)';
                            this.style.boxShadow='0 8px 28px rgba(45,106,79,.35)'"
               onmouseout="this.style.transform='translateY(0)';
                           this.style.boxShadow='0 4px 20px rgba(45,106,79,.25)'">
                Create Your First Request
                <svg width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</section>

<div class="section-divider"></div>

{{-- ============================================================
     BENEFITS
============================================================ --}}
<section class="section benefits-section" id="benefits">
    <div class="container">

        <div class="text-center mb-5 reveal">
            <div class="section-tag">Why AgriPool</div>
            <h2 class="section-title mt-2">Built for Farmers, by Design</h2>
            <p class="section-sub mt-3">
                Every feature was shaped around one goal —
                getting your produce to market cheaper and faster.
            </p>
        </div>

        @php
            $benefits = [
                [
                    'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
                    'title'=> 'Save Up to 60% on Transport',
                    'desc' => 'Pay only for the truck space your cargo actually uses. Farmers who share save thousands every season.',
                ],
                [
                    'icon' => '<polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
                    'title'=> 'Faster Market Access',
                    'desc' => 'Stop waiting to fill a full truck on your own. Pool with nearby farmers and go on your preferred date.',
                ],
                [
                    'icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                    'title'=> 'Verified, Trusted Drivers',
                    'desc' => 'Every driver is license-checked, vehicle-verified, and admin-approved before they handle your produce.',
                ],
                [
                    'icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
                    'title'=> 'Real-Time Shipment Tracking',
                    'desc' => 'Know exactly where your produce is at every step — from cargo loaded to market delivered.',
                ],
                [
                    'icon' => '<circle cx="18" cy="18" r="3"/><circle cx="6" cy="6" r="3"/><path d="M13 6h3a2 2 0 0 1 2 2v7"/><path d="M11 18H8a2 2 0 0 1-2-2V9"/>',
                    'title'=> 'Smart Pool Matching',
                    'desc' => 'Our algorithm finds farmers with matching destination, pickup region, and date — pooling happens automatically.',
                ],
                [
                    'icon' => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
                    'title'=> 'Complete Delivery History',
                    'desc' => 'Every delivery, every cost, every rating — all recorded so you can plan smarter every season.',
                ],
            ];
        @endphp

        <div class="row g-4">
            @foreach($benefits as $i => $b)
                <div class="col-md-6 col-lg-4 reveal reveal-delay-{{ ($i % 3) + 1 }}">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24"
                                 fill="none" stroke="#2d6a4f" stroke-width="1.75"
                                 stroke-linecap="round" stroke-linejoin="round">
                                {!! $b['icon'] !!}
                            </svg>
                        </div>
                        <div class="benefit-title">{{ $b['title'] }}</div>
                        <div class="benefit-desc">{{ $b['desc'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ============================================================
     STATS
============================================================ --}}
<section class="stats-section section-sm" id="stats">
    <div class="container">
        <div class="row g-0">
            @php
                $stats = [
                    ['2400',  '+', 'Registered Farmers',  'Across Gujarat'],
                    ['380',   '+', 'Active Drivers',       'Admin verified'],
                    ['12000', '+', 'Deliveries Completed', 'And counting'],
                    ['60',    '%', 'Average Cost Saving',  'Per delivery'],
                ];
            @endphp
            @foreach($stats as $i => $s)
                <div class="col-6 col-md-3">
                    <div class="stat-block reveal reveal-delay-{{ $i + 1 }}">
                        <div class="stat-num-display">
                            <span class="count-up" data-target="{{ $s[0] }}">
                                0
                            </span><span class="stat-num-suffix">{{ $s[1] }}</span>
                        </div>
                        <div class="stat-label-display">{{ $s[2] }}</div>
                        <div class="stat-desc">{{ $s[3] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     TESTIMONIALS
============================================================ --}}
<section class="section testimonials-section" id="testimonials">
    <div class="container">

        <div class="text-center mb-5 reveal">
            <div class="section-tag">Real Stories</div>
            <h2 class="section-title mt-2">Farmers and Drivers Trust AgriPool</h2>
            <p class="section-sub mt-3">
                Hear from the people who move India's food.
            </p>
        </div>

        <div class="row g-4">

            {{-- Featured large testimonial --}}
            <div class="col-lg-5 reveal reveal-delay-1">
                <div class="featured-quote h-100">
                    <div class="stars mb-3">
                        @for($i=0;$i<5;$i++)
                            <svg class="star" viewBox="0 0 24 24"
                                 fill="#f59e0b" stroke="none">
                                <polygon points="12,2 15.09,8.26 22,9.27
                                                 17,14.14 18.18,21.02 12,17.77
                                                 5.82,21.02 7,14.14 2,9.27
                                                 8.91,8.26"/>
                            </svg>
                        @endfor
                    </div>
                    <p style="font-size:1.08rem;color:#334155;line-height:1.8;
                               margin-bottom:28px;font-weight:400;">
                        "Earlier I used to spend
                        <strong style="color:#2d6a4f;">₹4,500</strong>
                        for a truck to take my wheat to Ahmedabad market.
                        Now with AgriPool I share with 3 other farmers
                        and pay only
                        <strong style="color:#2d6a4f;">₹1,200</strong>.
                        That savings goes back into my land."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar"
                             style="background:linear-gradient(
                                135deg,#2d6a4f,#52b788);">
                            RP
                        </div>
                        <div>
                            <div class="author-name">Ramesh Patel</div>
                            <div class="author-role">
                                Wheat Farmer · Anand, Gujarat
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stacked regular testimonials --}}
            <div class="col-lg-7">
                <div class="row g-4">

                    <div class="col-12 reveal reveal-delay-2">
                        <div class="testimonial-card">
                            <div class="stars mb-3">
                                @for($i=0;$i<5;$i++)
                                    <svg class="star" viewBox="0 0 24 24"
                                         fill="#f59e0b" stroke="none">
                                        <polygon points="12,2 15.09,8.26 22,9.27
                                                         17,14.14 18.18,21.02
                                                         12,17.77 5.82,21.02
                                                         7,14.14 2,9.27
                                                         8.91,8.26"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="testimonial-text">
                                "As a driver, AgriPool gives me consistent work.
                                Instead of waiting around for one full load,
                                I get matched with multiple farmers and my truck
                                is always full. My earnings went up by
                                <strong>40%</strong> in the first month."
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar"
                                     style="background:linear-gradient(
                                        135deg,#1d3557,#457b9d);">
                                    MS
                                </div>
                                <div>
                                    <div class="author-name">Mohan Singh</div>
                                    <div class="author-role">
                                        Transport Driver · Anand, Gujarat
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 reveal reveal-delay-3">
                        <div class="testimonial-card">
                            <div class="stars mb-3">
                                @for($i=0;$i<4;$i++)
                                    <svg class="star" viewBox="0 0 24 24"
                                         fill="#f59e0b" stroke="none">
                                        <polygon points="12,2 15.09,8.26
                                                         22,9.27 17,14.14
                                                         18.18,21.02 12,17.77
                                                         5.82,21.02 7,14.14
                                                         2,9.27 8.91,8.26"/>
                                    </svg>
                                @endfor
                                <svg class="star" viewBox="0 0 24 24"
                                     fill="none" stroke="#f59e0b"
                                     stroke-width="1.5">
                                    <polygon points="12,2 15.09,8.26
                                                     22,9.27 17,14.14
                                                     18.18,21.02 12,17.77
                                                     5.82,21.02 7,14.14
                                                     2,9.27 8.91,8.26"/>
                                </svg>
                            </div>
                            <p class="testimonial-text">
                                "The tracking feature changed how I work.
                                I can see exactly when my vegetables
                                are loaded and when they reach market.
                                No more waiting by the phone all day."
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar"
                                     style="background:linear-gradient(
                                        135deg,#e76f51,#f4a261);">
                                    SD
                                </div>
                                <div>
                                    <div class="author-name">Sunita Devi</div>
                                    <div class="author-role">
                                        Vegetable Farmer · Borsad
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 reveal reveal-delay-4">
                        <div class="testimonial-card">
                            <div class="stars mb-3">
                                @for($i=0;$i<5;$i++)
                                    <svg class="star" viewBox="0 0 24 24"
                                         fill="#f59e0b" stroke="none">
                                        <polygon points="12,2 15.09,8.26
                                                         22,9.27 17,14.14
                                                         18.18,21.02 12,17.77
                                                         5.82,21.02 7,14.14
                                                         2,9.27 8.91,8.26"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="testimonial-text">
                                "Pool matching is the best part.
                                I posted my onion request and within
                                minutes I was matched with two other
                                farmers going to Ahmedabad. Saved ₹2,800."
                            </p>
                            <div class="testimonial-author">
                                <div class="author-avatar"
                                     style="background:linear-gradient(
                                        135deg,#7c3aed,#a78bfa);">
                                    PS
                                </div>
                                <div>
                                    <div class="author-name">Priya Sharma</div>
                                    <div class="author-role">
                                        Onion Farmer · Mehsana
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<div class="section-divider"></div>

{{-- ============================================================
     CONTACT
============================================================ --}}
<section class="section contact-section" id="contact">
    <div class="container">

        <div class="text-center mb-5 reveal">
            <div class="section-tag">Support</div>
            <h2 class="section-title mt-2">We're Here to Help</h2>
            <p class="section-sub mt-3">
                Have a question? Send us a message and our team
                will respond within 24 hours on business days.
            </p>
        </div>

        <div class="row justify-content-center">
        <div class="col-lg-10">
        <div class="contact-glass reveal">
            <div class="row g-0">

                {{-- Left info --}}
                <div class="col-lg-4">
                    <div class="contact-left">
                        <h5 class="fw-bold mb-2"
                            style="color:#fff;position:relative;z-index:1;">
                            Contact Information
                        </h5>
                        <p style="color:rgba(255,255,255,.45);font-size:.875rem;
                                   margin-bottom:36px;position:relative;z-index:1;">
                            Fill out the form and we'll be in touch.
                        </p>

                        @foreach([
                            ['M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3-8.63A2 2 0 0 1 3.08 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z', 'Phone', '+91 90000 00001'],
                            ['M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z M22,6l-10,7L2,6', 'Email', 'support@agripool.com'],
                            ['M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z M12 10m-3 0a3 3 0 1 0 6 0 3 3 0 0 0-6 0', 'Office', 'Anand, Gujarat — 388001'],
                            ['M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z M12 10m-3 0a3 3 0 1 0 6 0 3 3 0 0 0-6 0', 'Hours', 'Mon–Sat: 9 AM – 6 PM'],
                        ] as [$icon, $label, $value])
                            <div class="contact-info-block">
                                <div class="contact-icon-box">
                                    <svg width="16" height="16"
                                         viewBox="0 0 24 24" fill="none"
                                         stroke="rgba(255,255,255,.7)"
                                         stroke-width="1.75"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="{{ $icon }}"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="contact-info-label">
                                        {{ $label }}
                                    </div>
                                    <div class="contact-info-value">
                                        {{ $value }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right form --}}
                <div class="col-lg-8">
                    <div class="contact-right">

                        @if(session('success'))
                            <div class="alert-premium-success mb-4">
                                <svg width="16" height="16"
                                     viewBox="0 0 24 24" fill="none"
                                     stroke="#2d6a4f" stroke-width="2.5"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22,4 12,14.01 9,11.01"/>
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST"
                              action="{{ route('contact.submit') }}">
                            @csrf

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label-premium">
                                        Your Name
                                    </label>
                                    <input type="text"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Ramesh Patel"
                                           class="form-input-premium
                                                  @error('name')
                                                      is-invalid @enderror">
                                    @error('name')
                                        <div style="font-size:.78rem;
                                                    color:#ef4444;
                                                    margin-top:5px;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-premium">
                                        Email Address
                                    </label>
                                    <input type="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="you@example.com"
                                           class="form-input-premium
                                                  @error('email')
                                                      is-invalid @enderror">
                                    @error('email')
                                        <div style="font-size:.78rem;
                                                    color:#ef4444;
                                                    margin-top:5px;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-premium">
                                    Subject
                                </label>
                                <select name="subject"
                                        class="form-input-premium
                                               form-select-premium
                                               @error('subject')
                                                   is-invalid @enderror">
                                    <option value="">
                                        Select a topic
                                    </option>
                                    @foreach([
                                        'General Inquiry',
                                        'Driver Registration',
                                        'Shipment Issue',
                                        'Billing / Payment',
                                        'Technical Support',
                                        'Partnership',
                                    ] as $opt)
                                        <option value="{{ $opt }}"
                                            {{ old('subject') == $opt
                                               ? 'selected' : '' }}>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject')
                                    <div style="font-size:.78rem;
                                                color:#ef4444;
                                                margin-top:5px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label-premium">
                                    Message
                                </label>
                                <textarea name="message"
                                          rows="5"
                                          placeholder="Tell us how we can help..."
                                          class="form-input-premium
                                                 @error('message')
                                                     is-invalid @enderror"
                                          style="resize:vertical;">{{ old('message') }}</textarea>
                                @error('message')
                                    <div style="font-size:.78rem;
                                                color:#ef4444;
                                                margin-top:5px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit"
                                    class="btn-contact-submit">
                                <svg width="16" height="16"
                                     viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <line x1="22" y1="2" x2="11" y2="13"/>
                                    <polygon points="22,2 15,22 11,13 2,9"/>
                                </svg>
                                Send Message
                            </button>

                        </form>
                    </div>
                </div>

            </div>
        </div>
        </div>
        </div>

    </div>
</section>

{{-- ============================================================
     CTA
============================================================ --}}
<section class="cta-section section" id="cta">
    <div class="container position-relative" style="z-index:1;">
        <div class="text-center">

            <div class="section-tag reveal"
                 style="background:rgba(52,183,136,.12);
                        border-color:rgba(52,183,136,.2);
                        color:var(--green-300);">
                Ready to Save?
            </div>

            <h2 class="cta-title reveal reveal-delay-1 mt-3">
                Join Thousands of Farmers<br>
                Already Saving with AgriPool
            </h2>

            <p class="cta-sub reveal reveal-delay-2 mt-3 mb-5">
                Register today and create your first transport request
                in under 2 minutes.
            </p>

            <div class="d-flex justify-content-center
                        gap-3 flex-wrap reveal reveal-delay-3">
                <a href="{{ route('register') }}"
                   class="btn-cta-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Register as Farmer
                </a>
                <a href="{{ route('register') }}"
                   class="btn-cta-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13" rx="2"/>
                        <path d="M16 8h4l3 5v3h-7V8z"/>
                        <circle cx="5.5" cy="18.5" r="2.5"/>
                        <circle cx="18.5" cy="18.5" r="2.5"/>
                    </svg>
                    Drive with AgriPool
                </a>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     FOOTER
============================================================ --}}
<footer class="footer-premium">
    <div class="container">
        <div class="row g-5">

            {{-- Brand --}}
            <div class="col-lg-4">
                <div class="footer-brand-mark">
                    <svg width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="#fff" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a10 10 0 0 1 10 10"/>
                        <path d="M12 2C6.5 2 2 6.5 2 12"/>
                        <path d="M12 22C6.5 22 2 17.5 2 12"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
                <div class="footer-brand-name">AgriPool</div>
                <p class="footer-tagline">
                    Empowering Indian farmers with smart, affordable,
                    cooperative transport solutions for agricultural
                    produce.
                </p>
            </div>

            {{-- Links --}}
            <div class="col-6 col-lg-2">
                <div class="footer-col-title">Platform</div>
                <a href="#how-it-works" class="footer-link">How It Works</a>
                <a href="#benefits" class="footer-link">Benefits</a>
                <a href="{{ route('register') }}" class="footer-link">
                    Register
                </a>
                <a href="{{ route('login') }}" class="footer-link">
                    Sign In
                </a>
            </div>

            <div class="col-6 col-lg-2">
                <div class="footer-col-title">Farmers</div>
                <a href="{{ route('register') }}" class="footer-link">
                    Create Account
                </a>
                <a href="#how-it-works" class="footer-link">
                    Post Request
                </a>
                <a href="#" class="footer-link">Find Pool</a>
                <a href="#" class="footer-link">Track Shipment</a>
            </div>

            <div class="col-6 col-lg-2">
                <div class="footer-col-title">Drivers</div>
                <a href="{{ route('register') }}" class="footer-link">
                    Drive with Us
                </a>
                <a href="#" class="footer-link">View Routes</a>
                <a href="#" class="footer-link">Earnings</a>
                <a href="#" class="footer-link">Requirements</a>
            </div>

            <div class="col-6 col-lg-2">
                <div class="footer-col-title">Support</div>
                <a href="{{ route('contact') }}" class="footer-link">
                    Contact Us
                </a>
                <a href="#" class="footer-link">Help Center</a>
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms of Use</a>
            </div>

        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">
            <div class="footer-copy">
                &copy; {{ date('Y') }} AgriPool.
                All rights reserved. Built for Indian Farmers 🇮🇳
            </div>
            <div class="footer-badge">
                <span class="footer-dot"></span>
                Laravel {{ app()->version() }}
            </div>
        </div>

    </div>
</footer>

{{-- ============================================================
     JAVASCRIPT
============================================================ --}}
<script>
(function() {
    'use strict';

    /* ── Navbar scroll ── */
    const nav = document.getElementById('mainNav');
    let lastScroll = 0;

    window.addEventListener('scroll', function() {
        const y = window.scrollY;
        nav.classList.toggle('scrolled', y > 40);
        lastScroll = y;
    }, { passive: true });

    /* ── Scroll reveal (Intersection Observer) ── */
    const revealEls = document.querySelectorAll('.reveal');
    const revealObs = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -48px 0px' });

    revealEls.forEach(function(el) { revealObs.observe(el); });

    /* Trigger hero reveals immediately */
    document.querySelectorAll('.hero .reveal').forEach(function(el) {
        setTimeout(function() {
            el.classList.add('visible');
        }, 100);
    });

    /* ── Count-up animation ── */
    function countUp(el, target, duration) {
        const start   = performance.now();
        const isFloat = target !== Math.floor(target);

        function step(now) {
            const progress = Math.min((now - start) / duration, 1);
            /* ease out cubic */
            const ease = 1 - Math.pow(1 - progress, 3);
            const val  = Math.floor(ease * target);
            el.textContent = val.toLocaleString('en-IN');
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    const statsObs = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const el     = entry.target;
                const target = parseInt(el.dataset.target, 10);
                countUp(el, target, 1800);
                statsObs.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.count-up').forEach(function(el) {
        statsObs.observe(el);
    });

    /* ── Smooth anchor scroll ── */
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (!target) return;
            e.preventDefault();
            const offset = 72;
            const top = target.getBoundingClientRect().top
                      + window.pageYOffset - offset;
            window.scrollTo({ top: top, behavior: 'smooth' });
        });
    });

    /* ── Contact form: smooth focus ring ── */
    document.querySelectorAll('.form-input-premium').forEach(function(input) {
        input.addEventListener('focus', function() {
            this.parentElement.style.zIndex = '1';
        });
        input.addEventListener('blur', function() {
            this.parentElement.style.zIndex = '';
        });
    });

})();
</script>

@endsection