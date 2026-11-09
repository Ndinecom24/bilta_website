<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $headline }}</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f6fb; margin: 0; padding: 24px 12px; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #fff; border-radius: 14px; border: 1px solid #d9e2ef; overflow: hidden; box-shadow: 0 10px 28px rgba(15,23,42,.08); }
        .email-header { background: linear-gradient(135deg, #0f2742, #1f3f63); color: #fff; padding: 18px 22px; }
        .email-header h2 { margin: 0; font-size: 20px; font-weight: 700; }
        .email-header p { margin: 6px 0 0; font-size: 13px; color: rgba(255,255,255,.84); }
        .email-body { padding: 20px 22px; }
        .message { background: #f8fafc; border-left: 4px solid #2563eb; padding: 12px 14px; color: #334155; font-size: 14px; line-height: 1.5; border-radius: 4px; margin-bottom: 16px; }
        .detail-row { display: flex; padding: 8px 0; border-bottom: 1px solid #eee; }
        .detail-label { font-weight: 700; width: 120px; color: #334155; font-size: 14px; }
        .detail-value { color: #475569; font-size: 14px; }
        .btn { display: inline-block; padding: 10px 24px; background: #2563eb; color: #fff !important; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; margin-top: 18px; }
        .email-footer { background: #f8fafc; padding: 14px 22px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>{{ $headline }}</h2>
            <p>{{ $ticket->reference }} &middot; System Support</p>
        </div>
        <div class="email-body">
            @if($body)
                <div class="message">{!! nl2br(e($body)) !!}</div>
            @endif

            <div class="detail-row">
                <span class="detail-label">Reference</span>
                <span class="detail-value">{{ $ticket->reference }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Subject</span>
                <span class="detail-value">{{ $ticket->subject }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Category</span>
                <span class="detail-value">{{ $ticket->category->name ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Priority</span>
                <span class="detail-value">{{ $ticket->priority->name ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value">{{ $ticket->status_label }}</span>
            </div>
            @if($ticket->assignee)
                <div class="detail-row">
                    <span class="detail-label">Assigned to</span>
                    <span class="detail-value">{{ $ticket->assignee->name }}</span>
                </div>
            @endif

            <a href="{{ $url }}" class="btn">View Ticket</a>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} BiLTA &mdash; Bible &amp; Literature Translation Association
        </div>
    </div>
</body>
</html>
