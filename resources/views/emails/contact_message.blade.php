<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Us Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f6fb;
            margin: 0;
            padding: 24px 12px;
        }
        .email-container {
            max-width: 600px;
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
            padding: 18px 22px;
        }
        .email-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }
        .email-header p {
            margin: 6px 0 0;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.84);
        }
        .email-body {
            padding: 20px 22px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .data-table td {
            padding: 9px 0;
            border-bottom: 1px solid #eef2f7;
            font-size: 14px;
            color: #334155;
            vertical-align: top;
        }
        .data-table td:first-child {
            width: 120px;
            font-weight: bold;
            color: #0f2742;
        }
        .message-label {
            margin: 0 0 8px;
            color: #0f2742;
            font-size: 14px;
            font-weight: 700;
        }
        .message-box {
            border: 1px solid #dbe4f1;
            border-radius: 10px;
            background: #f8fbff;
            padding: 14px;
            font-size: 14px;
            color: #334155;
            line-height: 1.65;
            white-space: pre-line;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #64748b;
            padding: 16px 22px 20px;
            border-top: 1px solid #eef2f7;
            background: #fafcff;
        }
        .website {
            font-size: 12px;
            color: #64748b;
        }
        .website a {
            color: #1d4ed8;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>New Contact Us Message</h2>
            <p>You received a new message from the website contact form.</p>
        </div>

        <div class="email-body">
            <table class="data-table" role="presentation">
                <tr>
                    <td>Name</td>
                    <td>{{ $contactMessage->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $contactMessage->email }}</td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td>{{ $contactMessage->subject }}</td>
                </tr>
            </table>

            <p class="message-label">Message</p>
            <div class="message-box">{{ $contactMessage->message }}</div>
        </div>

        <div class="footer">
            <p class="website">This message was sent via the <a href="{{   route('site.home') }}" target="_blank">bilta.org Contact Us</a> form.</p>
        </div>
    </div>
</body>
</html>
