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
        .header { background:linear-gradient(135deg,#1b4332,#52b788);
                  padding:40px 32px;text-align:center;color:#fff; }
        .header h1 { margin:12px 0 4px;font-size:1.8rem;font-weight:800; }
        .body { padding:36px 32px;color:#333; }
        .info-card { background:#f0faf4;border:1px solid #c3e6cb;
                     border-radius:12px;padding:20px 24px;margin:20px 0; }
        .info-row { display:flex;justify-content:space-between;
                    margin-bottom:10px;font-size:.9rem; }
        .info-label { color:#888; }
        .info-value { font-weight:600;color:#333; }
        .payment-box { background:#fff3cd;border:2px solid #ffc107;
                       border-radius:12px;padding:24px;
                       text-align:center;margin:20px 0; }
        .payment-amount { font-size:2.2rem;font-weight:800;
                          color:#2d6a4f;margin:8px 0; }
        .btn { display:inline-block;background:#2d6a4f;
               color:#fff !important;text-decoration:none;
               padding:14px 32px;border-radius:50px;
               font-weight:700;font-size:1rem; }
        .btn-rate { display:inline-block;background:#f4a261;
                    color:#fff !important;text-decoration:none;
                    padding:14px 32px;border-radius:50px;
                    font-weight:700;font-size:1rem;margin-left:12px; }
        .footer { background:#f8f9fa;padding:24px 32px;
                  text-align:center;color:#aaa;font-size:.8rem;
                  border-top:1px solid #eee; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <div style="font-size:2.5rem;">🎉</div>
        <h1>Delivery Complete!</h1>
        <p style="color:rgba(255,255,255,.8);">
            Your produce has reached the market
        </p>
    </div>

    <div class="body">
        <p>Hello <strong>{{ $farmer->name }}</strong>,</p>
        <p>
            Your delivery has been successfully completed!
            Your
            <strong>
                {{ $member->transportRequest->crop_type ?? 'produce' }}
            </strong>
            has been delivered to
            <strong>
                {{ $shipment->pool->destination_market ?? 'the market' }}
            </strong>.
        </p>

        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Tracking Code</span>
                <span class="info-value">
                    {{ $shipment->tracking_code }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Driver</span>
                <span class="info-value">
                    {{ $shipment->driver->name ?? 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Delivered On</span>
                <span class="info-value">
                    {{ $shipment->delivery_time
                       ? $shipment->delivery_time->format('d M Y, h:i A')
                       : 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Your Cargo</span>
                <span class="info-value">
                    {{ $member->transportRequest->crop_type ?? 'N/A' }}
                    —
                    {{ number_format(
                        $member->transportRequest->quantity_kg ?? 0) }}kg
                </span>
            </div>
            <div class="info-row" style="margin-bottom:0;">
                <span class="info-label">Your Share</span>
                <span class="info-value">
                    {{ $member->share_percentage ?? 0 }}% of truck
                </span>
            </div>
        </div>

        {{-- Payment reminder --}}
        <div class="payment-box">
            <div style="font-size:.9rem;color:#7a5f00;font-weight:600;">
                💳 PAYMENT DUE
            </div>
            <div class="payment-amount">
                ₹{{ number_format($member->cost_share ?? 0, 2) }}
            </div>
            <div style="font-size:.85rem;color:#856404;margin-bottom:4px;">
                Please pay your driver promptly
            </div>
            <div style="font-size:.78rem;color:#856404;">
                Payment method: Cash / UPI / Bank Transfer
            </div>
        </div>

        <div style="text-align:center;margin-top:28px;">
            <a href="{{ config('app.url') }}/farmer/requests/{{ $member->transport_request_id }}"
               class="btn">
                💳 Confirm Payment
            </a>
            <a href="{{ config('app.url') }}/farmer/rate/{{ $shipment->id }}"
               class="btn-rate">
                ⭐ Rate Driver
            </a>
        </div>
    </div>

    <div class="footer">
        <p style="margin:0 0 4px;">
            © {{ date('Y') }} AgriPool. All rights reserved.
        </p>
        <p style="margin:0;">
            Thank you for using AgriPool!
        </p>
    </div>

</div>
</body>
</html>