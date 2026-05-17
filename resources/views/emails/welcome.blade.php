<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f6f9;
            margin: 0; padding: 0;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
        }
        .header {
            background: linear-gradient(135deg, #1b4332, #2d6a4f);
            padding: 40px 32px;
            text-align: center;
            color: #fff;
        }
        .header h1 {
            margin: 12px 0 4px;
            font-size: 1.8rem;
            font-weight: 800;
        }
        .header p {
            margin: 0;
            color: rgba(255,255,255,.8);
            font-size: .95rem;
        }
        .body { padding: 36px 32px; color: #333; }
        .body h2 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d6a4f;
            margin-bottom: 12px;
        }
        .body p {
            line-height: 1.7;
            color: #555;
            margin-bottom: 16px;
        }
        .info-card {
            background: #f0faf4;
            border: 1px solid #c3e6cb;
            border-radius: 12px;
            padding: 20px 24px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: .9rem;
        }
        .info-label { color: #888; }
        .info-value { font-weight: 600; color: #333; }
        .btn {
            display: inline-block;
            background: #2d6a4f;
            color: #fff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            margin: 8px 0;
        }
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 16px 0;
        }
        .feature-list li {
            padding: 6px 0;
            color: #555;
            font-size: .9rem;
        }
        .footer {
            background: #f8f9fa;
            padding: 24px 32px;
            text-align: center;
            color: #aaa;
            font-size: .8rem;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <div style="font-size:2.5rem;">🌾</div>
        <h1>Welcome to AgriPool</h1>
        <p>Agricultural Transport Sharing Platform</p>
    </div>

    <div class="body">
        <h2>Hello, {{ $user->name }}! 👋</h2>
        <p>
            Your AgriPool account has been successfully created.
            You are now part of a community of farmers and drivers
            working together to reduce transport costs and get
            produce to market efficiently.
        </p>

        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Name</span>
                <span class="info-value">{{ $user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Role</span>
                <span class="info-value">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            <div class="info-row" style="margin-bottom:0;">
                <span class="info-label">Member Since</span>
                <span class="info-value">
                    {{ $user->created_at->format('d M Y') }}
                </span>
            </div>
        </div>

        @if($user->isFarmer())
            <p>As a <strong>Farmer</strong> on AgriPool you can:</p>
            <ul class="feature-list">
                <li>✅ Create transport requests for your crops</li>
                <li>✅ Get automatically matched with nearby farmers</li>
                <li>✅ Share truck space and split transport costs</li>
                <li>✅ Track your shipment in real time</li>
                <li>✅ Save up to 60% on transport costs</li>
            </ul>
        @elseif($user->isDriver())
            <p>As a <strong>Driver</strong> on AgriPool you can:</p>
            <ul class="feature-list">
                <li>✅ Browse available transport pools</li>
                <li>✅ Accept deliveries on your route</li>
                <li>✅ Always drive with a full truck</li>
                <li>✅ Track and update shipment status</li>
                <li>✅ Build your reputation with farmer ratings</li>
            </ul>
            <p style="color:#856404;background:#fff8e1;padding:12px 16px;
                       border-radius:8px;font-size:.9rem;">
                ⚠️ Your account is pending admin approval.
                You will receive another email once approved.
            </p>
        @endif

        <div style="text-align:center;margin-top:28px;">
            <a href="{{ config('app.url') }}/login" class="btn">
                Sign In to AgriPool →
            </a>
        </div>
    </div>

    <div class="footer">
        <p style="margin:0 0 4px;">
            © {{ date('Y') }} AgriPool. All rights reserved.
        </p>
        <p style="margin:0;">
            If you did not create this account, please ignore this email.
        </p>
    </div>

</div>
</body>
</html>