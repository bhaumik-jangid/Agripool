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
        .header { background:linear-gradient(135deg,#1d3557,#457b9d);
                  padding:40px 32px;text-align:center;color:#fff; }
        .header h1 { margin:12px 0 4px;font-size:1.8rem;font-weight:800; }
        .body { padding:36px 32px;color:#333; }
        .info-card { background:#e8f4f8;border:1px solid #b8daff;
                     border-radius:12px;padding:20px 24px;margin:20px 0; }
        .info-row { display:flex;justify-content:space-between;
                    margin-bottom:10px;font-size:.9rem; }
        .info-label { color:#888; }
        .info-value { font-weight:600;color:#333; }
        .tracking-box { background:#1d3557;color:#fff;border-radius:12px;
                        padding:20px;text-align:center;margin:20px 0; }
        .tracking-code { font-size:1.6rem;font-weight:800;
                         letter-spacing:2px;color:#a8dadc; }
        .btn { display:inline-block;background:#1d3557;color:#fff !important;
               text-decoration:none;padding:14px 32px;border-radius:50px;
               font-weight:700;font-size:1rem; }
        .footer { background:#f8f9fa;padding:24px 32px;text-align:center;
                  color:#aaa;font-size:.8rem;border-top:1px solid #eee; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <div style="font-size:2.5rem;">🚛</div>
        <h1>Driver Assigned!</h1>
        <p style="color:rgba(255,255,255,.8);">
            Your shipment is ready to go
        </p>
    </div>

    <div class="body">
        <p>Hello <strong>{{ $farmer->name }}</strong>,</p>
        <p>
            A verified driver has been assigned to your pool.
            Your produce will be picked up as scheduled.
        </p>

        <div class="tracking-box">
            <div style="font-size:.85rem;color:rgba(255,255,255,.7);
                        margin-bottom:6px;">
                YOUR TRACKING CODE
            </div>
            <div class="tracking-code">
                {{ $shipment->tracking_code }}
            </div>
            <div style="font-size:.78rem;color:rgba(255,255,255,.6);
                        margin-top:6px;">
                Use this code to track your shipment
            </div>
        </div>

        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Driver Name</span>
                <span class="info-value">
                    {{ $shipment->driver->name ?? 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Driver Phone</span>
                <span class="info-value">
                    {{ $shipment->driver->phone ?? 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Driver Rating</span>
                <span class="info-value">
                    ⭐ {{ number_format(
                        $shipment->driver->driverProfile->rating ?? 0, 1) }}
                    / 5
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Vehicle</span>
                <span class="info-value">
                    {{ $shipment->driver->vehicle->vehicle_type ?? 'N/A' }}
                    —
                    {{ $shipment->driver->vehicle->vehicle_number ?? 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Destination</span>
                <span class="info-value">
                    {{ $shipment->pool->destination_market ?? 'N/A' }}
                </span>
            </div>
            <div class="info-row" style="margin-bottom:0;">
                <span class="info-label">Pickup Date</span>
                <span class="info-value">
                    {{ $shipment->pool->pickup_date->format('d M Y') ?? 'N/A' }}
                </span>
            </div>
        </div>

        <div style="text-align:center;margin-top:28px;">
            <a href="{{ config('app.url') }}/farmer/track/{{ $shipment->tracking_code }}"
               class="btn">
                📍 Track My Shipment →
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