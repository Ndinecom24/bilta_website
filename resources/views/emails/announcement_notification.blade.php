<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f6fb;
            margin: 0;
            padding: 24px 12px;
        }
        .email-container {
            max-width: 640px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 14px;
            border: 1px solid #d9e2ef;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
        }
        .email-header {
            background: linear-gradient(135deg, #0f2742, #1f3f63);
            color: #ffffff;
            padding: 24px 28px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }
        .email-header .type-badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 8px;
        }
        .email-header .type-memo {
            background: rgba(54, 185, 204, 0.25);
            color: #a8ecf7;
        }
        .email-header .type-announcement {
            background: rgba(28, 200, 138, 0.25);
            color: #a8f0d4;
        }
        .email-header .priority-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-left: 6px;
        }
        .email-header .priority-high {
            background: rgba(231, 74, 59, 0.3);
            color: #ffc1bb;
        }
        .email-header .priority-normal {
            background: rgba(78, 115, 223, 0.25);
            color: #b3c7f7;
        }
        .email-header .priority-low {
            background: rgba(133, 135, 150, 0.25);
            color: #c8c9d1;
        }
        .email-header p {
            margin: 8px 0 0;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.84);
        }
        .email-body {
            padding: 28px;
            color: #334155;
            line-height: 1.7;
            font-size: 15px;
        }
        .email-body h2,
        .email-body h3 {
            color: #0f2742;
        }
        .email-body img {
            max-width: 100%;
            height: auto;
        }
        .email-meta {
            margin: 0 28px 20px;
            padding: 14px 16px;
            background: #f8fbff;
            border: 1px solid #dbe4f1;
            border-radius: 10px;
            font-size: 13px;
            color: #475569;
        }
        .email-meta table {
            width: 100%;
        }
        .email-meta td {
            padding: 4px 0;
        }
        .email-meta .label {
            font-weight: 700;
            color: #0f2742;
            width: 120px;
        }
        .cta-button {
            display: inline-block;
            margin: 16px 0;
            padding: 12px 28px;
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
        }
        .email-footer {
            background: #f1f5f9;
            padding: 16px 28px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        .email-footer a {
            color: #0f2742;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        {{-- Header --}}
        <div class="email-header">
            <h1>{{ $announcement->title }}</h1>
            <div style="margin-top: 10px;">
                <span class="type-badge type-{{ $announcement->type }}">
                    {{ ucfirst($announcement->type) }}
                </span>
                <span class="priority-badge priority-{{ $announcement->priority }}">
                    {{ ucfirst($announcement->priority) }} Priority
                </span>
            </div>
            @if ($announcement->publish_date)
                <p>{{ $announcement->publish_date->format('F d, Y') }}</p>
            @endif
        </div>

        {{-- Meta info --}}
        <div class="email-meta">
            <table>
                <tr>
                    <td class="label">From:</td>
                    <td>{{ $announcement->creator->name ?? 'Administration' }}</td>
                </tr>
                @if ($announcement->expiry_date)
                    <tr>
                        <td class="label">Valid Until:</td>
                        <td>{{ $announcement->expiry_date->format('F d, Y') }}</td>
                    </tr>
                @endif
            </table>
        </div>

        {{-- Body --}}
        <div class="email-body">
            {!! $announcement->content !!}

            {{-- CTA --}}
            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ url('/my-announcements') }}" class="cta-button">
                    View in Portal &rarr;
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p>
                This is an internal {{ $announcement->type }} from BiLTA.<br>
                Please do not reply to this email.<br>
                &copy; {{ date('Y') }} Bible and Literature Translation Association (BiLTA)
            </p>
        </div>
    </div>
</body>
</html>
