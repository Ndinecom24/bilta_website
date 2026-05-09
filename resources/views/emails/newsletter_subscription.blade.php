<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Newsletter Subscription</title>
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
        .summary-card {
            border: 1px solid #dbe4f1;
            border-radius: 10px;
            background: #f8fbff;
            padding: 14px;
            margin-bottom: 14px;
        }
        .summary-card p {
            margin: 0;
            color: #334155;
            font-size: 14px;
        }
        .summary-card .label {
            color: #0f2742;
            font-weight: 700;
            margin-right: 6px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #64748b;
            padding: 16px 22px 20px;
            border-top: 1px solid #eef2f7;
            background: #fafcff;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>New Newsletter Subscription</h2>
            <p>A new user subscribed through the website newsletter form.</p>
        </div>

        <div class="email-body">
            <div class="summary-card">
                <p><span class="label">Subscriber Email:</span> {{ $subscriber->email }}</p>
            </div>
        </div>

        <div class="footer">
            <p>This subscription was submitted via the BiLTA website footer form.</p>
        </div>
    </div>
</body>
</html>
