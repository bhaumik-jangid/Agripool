<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family:'Segoe UI',Arial,sans-serif;
               background:#f4f6f9;margin:0;padding:0; }
        .wrapper { max-width:600px;margin:40px auto;background:#fff;
                   border-radius:16px;overflow:hidden;
                   box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .header { background:linear-gradient(135deg,#1b4332,#2d6a4f);
                  padding:40px 32px;text-align:center;color:#fff; }
        .header h1 { margin:12px 0 4px;font-size:1.8rem;font-weight:800; }
        .body { padding:36px 32px;color:#333; }
        .info-card { background:#f0faf4;border:1px solid #c3e6cb;
                     border-radius:12px;padding:20px 24px;margin:20px 0; }
        .info-row { display:flex;justify-content:space-between;
                    margin-bottom:10px;font-size:.9rem; }
        .info-label { color:#888; }
        .info-value { font-weight:600;color:#333; }
        .highlight { background:#fff3cd;border:1px solid #ffe082;
                     border-radius:10px;padding:16px 20px;margin:20px 0; }
        .btn { display:inline-block;background:#2d6a4f;color:#fff !important;
               text-decoration:none;padding:14px 32px;border-radius:50px;
               font-weight:700;font-size:1rem; }
        .footer { background:#f8f9fa;padding:24px 32px;text-align:center;
                  color:#aaa;font-size:.8rem;border-top:1px solid #eee; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <div style="font-size:2.5rem;">🤝</div>
        <h1>Pool Matched!</h1>
        <p style="color:rgba(255,255,255,.8);">
            Your transport is being arranged
        </p>
    </div>

    <div class="body">
        <p>Hello <strong>{{ $user->name }}</strong>,</p>
        <p>
            Great news! Your transport request for
            <strong>{{ $transportRequest->crop_type }}</strong>
            has been matched to a pool.
            A driver will be assigned soon.
        </p>

        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Crop</span>
                <span class="info-value">
                    {{ $transportRequest->crop_type }}
                    ({{ number_format($transportRequest->quantity_kg) }}kg)
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Pool Code</span>
                <span class="info-value">{{ $pool->pool_code }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Destination</span>
                <span class="info-value">
                    {{ $pool->destination_market }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Pickup Date</span>
                <span class="info-value">
                    {{ $pool->pickup_date->format('d M Y') }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Farmers in Pool</span>
                <span class="info-value">
                    {{ $pool->members()->count() }}
                </span>
            </div>
            <div class="info-row" style="margin-bottom:0;">
                <span class="info-label">Your Cost Share</span>
                <span class="info-value"
                      style="color:#2d6a4f;font-size:1.1rem;">
                    ₹{{ number_format($costShare, 2) }}
                </span>
            </div>
        </div>

        <div class="highlight">
            💡 <strong>What happens next?</strong><br>
            <span style="font-size:.9rem;color:#7a5f00;">
                A verified driver will accept your pool and
                you will receive another email with driver details
                and your tracking code.
            </span>
        </div>

        <div style="text-align:center;margin-top:28px;">
            <a href="{{ config('app.url') }}/farmer/requests"
               class="btn">
                View My Requests →
            </a>
        </div>
    </div>

    <div class="footer">
        <p style="margin:0;">
            © {{ date('Y') }} AgriPool. All rights reserved.
        </p>
    </div>

</div>
</body>
</html>