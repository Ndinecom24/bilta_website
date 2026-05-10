<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Submitted</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f6fb; margin: 0; padding: 24px 12px; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #fff; border-radius: 14px; border: 1px solid #d9e2ef; overflow: hidden; box-shadow: 0 10px 28px rgba(15,23,42,.08); }
        .email-header { background: linear-gradient(135deg, #1e4a3b, #2d6a4f); color: #fff; padding: 18px 22px; }
        .email-header h2 { margin: 0; font-size: 20px; font-weight: 700; }
        .email-header p { margin: 6px 0 0; font-size: 13px; color: rgba(255,255,255,.84); }
        .email-body { padding: 20px 22px; }
        .detail-row { display: flex; padding: 8px 0; border-bottom: 1px solid #eee; }
        .detail-label { font-weight: 700; width: 140px; color: #334155; font-size: 14px; }
        .detail-value { color: #475569; font-size: 14px; }
        .stage-badge { display: inline-block; background: #fef3c7; color: #92400e; border: 1px solid #fbbf24; padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: 13px; margin-top: 12px; }
        .info-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 14px 16px; margin-top: 16px; font-size: 14px; color: #1e40af; }
        .btn { display: inline-block; padding: 10px 24px; background: #2563eb; color: #fff !important; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; margin-top: 16px; }
        .email-footer { background: #f8fafc; padding: 14px 22px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Leave Application Submitted</h2>
            <p>Your application has been received and is being processed</p>
        </div>
        <div class="email-body">
            <p style="color: #334155; font-size: 15px;">
                Dear {{ $application->user->name }},
            </p>
            <p style="color: #475569; font-size: 14px;">
                Your leave application has been successfully submitted and is now pending approval.
            </p>

            <div class="detail-row">
                <span class="detail-label">Leave Type</span>
                <span class="detail-value">{{ $application->leaveType->name ?? '-' }}{{ $application->other_leave_type_text ? ' — '.$application->other_leave_type_text : '' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Period</span>
                <span class="detail-value">{{ $application->start_date->format('d M Y') }} — {{ $application->end_date->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Resume Date</span>
                <span class="detail-value">{{ $application->resume_date ? $application->resume_date->format('d M Y') : '—' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Days Requested</span>
                <span class="detail-value">{{ $application->days_requested }} working day(s)</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Reason</span>
                <span class="detail-value">{{ $application->reason }}</span>
            </div>
            @if ($application->acting_name)
            <div class="detail-row">
                <span class="detail-label">Acting Staff</span>
                <span class="detail-value">{{ $application->acting_name }}</span>
            </div>
            @endif

            <div class="info-box">
                <strong>Current Stage:</strong> {{ $stage->name }} (Step {{ $stage->stage_order }})
                <br>
                <span style="font-size: 13px;">The relevant approver(s) have been notified. You will receive an email update once action is taken on your application.</span>
            </div>

            <a href="{{ url('/bilta/zadmin/home/leave/my-applications') }}" class="btn">Track My Application</a>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} BiLTA — Bible &amp; Literature Translation Association
        </div>
    </div>
</body>
</html>
