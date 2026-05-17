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
        .header { background:#1b1b2f;padding:32px;
                  text-align:center;color:#fff; }
        .body { padding:36px 32px;color:#333; }
        .info-card { background:#f8f9fa;border-radius:10px;
                     padding:20px 24px;margin:20px 0; }
        .info-row { margin-bottom:12px;font-size:.9rem; }
        .info-label { color:#888;font-size:.78rem;
                      text-transform:uppercase;font-weight:700; }
        .info-value { font-weight:600;color:#333;margin-top:2px; }
        .message-box { background:#f0faf4;border-left:4px solid #2d6a4f;
                       padding:16px 20px;border-radius:0 8px 8px 0;
                       margin:16px 0; }
        .footer { background:#f8f9fa;padding:20px;text-align:center;
                  color:#aaa;font-size:.8rem;border-top:1px solid #eee; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <div style="font-size:2rem;">⚙️</div>
        <h2 style="margin:8px 0 0;font-size:1.3rem;">
            New Contact Form Submission
        </h2>
        <p style="color:rgba(255,255,255,.6);font-size:.85rem;margin:4px 0 0;">
            AgriPool Support
        </p>
    </div>

    <div class="body">
        <div class="info-card">
            <div class="info-row">
                <div class="info-label">From</div>
                <div class="info-value">{{ $senderName }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $senderEmail }}</div>
            </div>
            <div class="info-row" style="margin-bottom:0;">
                <div class="info-label">Subject</div>
                <div class="info-value">{{ $subject }}</div>
            </div>
        </div>

        <div class="info-label" style="margin-bottom:8px;">Message</div>
        <div class="message-box">
            {{ $messageBody }}
        </div>
    </div>

    <div class="footer">
        Received {{ now()->format('d M Y, h:i A') }}
        · AgriPool Contact System
    </div>

</div>
</body>
</html>