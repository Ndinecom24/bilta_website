<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Approval Required</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f6fb; margin: 0; padding: 24px 12px; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #fff; border-radius: 14px; border: 1px solid #d9e2ef; overflow: hidden; box-shadow: 0 10px 28px rgba(15,23,42,.08); }
        .email-header { background: linear-gradient(135deg, #0f2742, #1f3f63); color: #fff; padding: 18px 22px; }
        .email-header h2 { margin: 0; font-size: 20px; font-weight: 700; }
        .email-header p { margin: 6px 0 0; font-size: 13px; color: rgba(255,255,255,.84); }
        .email-body { padding: 20px 22px; }
        .detail-row { display: flex; padding: 8px 0; border-bottom: 1px solid #eee; }
        .detail-label { font-weight: 700; width: 140px; color: #334155; font-size: 14px; }
        .detail-value { color: #475569; font-size: 14px; }
        .btn { display: inline-block; padding: 10px 24px; background: #2563eb; color: #fff !important; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; margin-top: 16px; }
        .email-footer { background: #f8fafc; padding: 14px 22px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Leave Approval Required</h2>
            <p>Stage: {{ $stage->name }} (Step {{ $stage->stage_order }})</p>
        </div>
        <div class="email-body">
            <p style="color: #334155; font-size: 15px;">A leave application requires your review and approval.</p>

            <div class="detail-row">
                <span class="detail-label">Applicant</span>
                <span class="detail-value">{{ $application->user->name ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Leave Type</span>
                <span class="detail-value">{{ $application->leaveType->name ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Period</span>
                <span class="detail-value">{{ $application->start_date->format('d M Y') }} — {{ $application->end_date->format('d M Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Days Requested</span>
                <span class="detail-value">{{ $application->days_requested }} working day(s)</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Reason</span>
                <span class="detail-value">{{ $application->reason }}</span>
            </div>

            <p style="margin-top: 18px; color: #64748b; font-size: 13px;">
                Please log in to the admin panel to approve or reject this application.
            </p>

            <a href="{{ url('/bilta/zadmin/home/leave/applications') }}" class="btn">Review Application</a>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} BiLTA — Bible &amp; Literature Translation Association
        </div>
    </div>
</body>
</html>
