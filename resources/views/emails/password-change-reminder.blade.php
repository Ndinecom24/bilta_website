<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiLTA account reminder</title>
</head>
<body style="margin:0;padding:24px 12px;background:#f3f6fb;font-family:Arial,sans-serif;color:#334155;">
    <div style="max-width:600px;margin:0 auto;background:#fff;border:1px solid #d9e2ef;border-radius:14px;overflow:hidden;">
        <div style="padding:20px 24px;background:#1d4ed8;color:#fff;">
            <h1 style="margin:0;font-size:21px;">Complete your BiLTA account setup</h1>
        </div>
        <div style="padding:24px;line-height:1.6;">
            <p>Hello {{ $user->name }},</p>
            <p>Your BiLTA account is waiting for you to set a personal password. Sign in using the temporary password from your account-creation or password-reset email, then choose a new password.</p>
            <p><strong>Login email:</strong> {{ $user->email }}</p>
            <p>This reminder does not include or change your password. If you no longer have the temporary password, use the password reset link on the sign-in page or contact your administrator.</p>
            <p style="margin:24px 0;"><a href="{{ url('/login') }}" style="display:inline-block;padding:11px 20px;background:#2563eb;color:#fff;text-decoration:none;border-radius:8px;font-weight:bold;">Sign in to BiLTA</a></p>
            <p style="font-size:13px;color:#64748b;">If you believe you received this message by mistake, contact your administrator.</p>
        </div>
        <div style="padding:14px 24px;background:#f8fafc;border-top:1px solid #e2e8f0;text-align:center;font-size:12px;color:#94a3b8;">&copy; {{ date('Y') }} BiLTA</div>
    </div>
</body>
</html>
