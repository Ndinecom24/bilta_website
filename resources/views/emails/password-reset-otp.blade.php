<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f6fb; margin: 0; padding: 24px 12px; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #fff; border-radius: 14px; border: 1px solid #d9e2ef; overflow: hidden; box-shadow: 0 10px 28px rgba(15,23,42,.08); }
        .email-header { background: linear-gradient(135deg, #0f172a, #dc2626); color: #fff; padding: 18px 22px; }
        .email-header h2 { margin: 0; font-size: 20px; font-weight: 700; }
        .email-header p { margin: 6px 0 0; font-size: 13px; color: rgba(255,255,255,.84); }
        .email-body { padding: 20px 22px; color: #334155; }
        .otp-box { margin: 18px 0; text-align: center; background: #fef2f2; border: 2px dashed #fca5a5; border-radius: 12px; padding: 20px; }
        .otp-code { font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #dc2626; font-family: 'Courier New', monospace; }
        .credential-box { margin-top: 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; }
        .credential-row { display: flex; border-bottom: 1px solid #e2e8f0; padding: 8px 0; }
        .credential-row:last-child { border-bottom: 0; }
        .label { width: 170px; font-weight: 700; color: #1e293b; }
        .value { color: #475569; word-break: break-all; }
        .note { margin-top: 14px; font-size: 13px; color: #b45309; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 10px 12px; }
        .warning { margin-top: 14px; font-size: 13px; color: #991b1b; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 10px 12px; }
        .btn { display: inline-block; margin-top: 16px; padding: 10px 22px; border-radius: 8px; background: #dc2626; color: #fff !important; text-decoration: none; font-weight: 600; }
        .email-footer { background: #f8fafc; padding: 14px 22px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h2>Password Reset</h2>
        <p>Your password has been reset by an administrator.</p>
    </div>

    <div class="email-body">
        <p>Hello {{ $user->name }},</p>
        <p>Your account password has been reset by <strong>{{ $resetBy }}</strong>. Use the one-time password below to log in:</p>

        <div class="otp-box">
            <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 2px; color: #6b7280; margin-bottom: 8px; font-weight: 600;">Your One-Time Password</div>
            <div class="otp-code">{{ $otp }}</div>
        </div>

        <div class="credential-box">
            <div class="credential-row">
                <span class="label">Login Email</span>
                <span class="value">{{ $user->email }}</span>
            </div>
            <div class="credential-row">
                <span class="label">Temporary Password</span>
                <span class="value">{{ $otp }}</span>
            </div>
        </div>

        <div class="warning">
            <strong>Important:</strong> You will be required to set a new password immediately after logging in. This one-time password expires in 72 hours.
        </div>

        <div class="note">
            If you did not expect this reset, please contact your administrator immediately.
        </div>

        <a href="{{ url('/login') }}" class="btn">Go to Login</a>
    </div>

    <div class="email-footer">
        &copy; {{ date('Y') }} BiLTA &mdash; Bible &amp; Literature Translation Association
    </div>
</div>
</body>
</html>
