<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to BiLTA</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f6fb; margin: 0; padding: 24px 12px; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #fff; border-radius: 14px; border: 1px solid #d9e2ef; overflow: hidden; box-shadow: 0 10px 28px rgba(15,23,42,.08); }
        .email-header { background: linear-gradient(135deg, #0f172a, #1d4ed8); color: #fff; padding: 18px 22px; }
        .email-header h2 { margin: 0; font-size: 20px; font-weight: 700; }
        .email-header p { margin: 6px 0 0; font-size: 13px; color: rgba(255,255,255,.84); }
        .email-body { padding: 20px 22px; color: #334155; }
        .credential-box { margin-top: 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; }
        .credential-row { display: flex; border-bottom: 1px solid #e2e8f0; padding: 8px 0; }
        .credential-row:last-child { border-bottom: 0; }
        .label { width: 170px; font-weight: 700; color: #1e293b; }
        .value { color: #475569; word-break: break-all; }
        .note { margin-top: 14px; font-size: 13px; color: #b45309; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 10px 12px; }
        .btn { display: inline-block; margin-top: 16px; padding: 10px 22px; border-radius: 8px; background: #2563eb; color: #fff !important; text-decoration: none; font-weight: 600; }
        .email-footer { background: #f8fafc; padding: 14px 22px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h2>Welcome to BiLTA</h2>
        <p>Your account has been created successfully.</p>
    </div>

    <div class="email-body">
        <p>Hello {{ $user->name }},</p>
        <p>Your account is ready and has been assigned the default <strong>Viewer</strong> role.</p>

        <div class="credential-box">
            <div class="credential-row">
                <span class="label">Login Email</span>
                <span class="value">{{ $user->email }}</span>
            </div>
            <div class="credential-row">
                <span class="label">One-time Password</span>
                <span class="value">{{ $temporaryPassword }}</span>
            </div>
        </div>

        <div class="note">
            For security, please sign in and change this password immediately.
        </div>

        <a href="{{ url('/login') }}" class="btn">Go to Login</a>
    </div>

    <div class="email-footer">
        &copy; {{ date('Y') }} BiLTA — Bible &amp; Literature Translation Association
    </div>
</div>
</body>
</html>
