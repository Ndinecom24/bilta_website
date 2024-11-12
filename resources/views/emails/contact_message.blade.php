<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #333;
        }
        .divider {
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
        .website {
            font-size: 14px;
            color: #007BFF;
        }
        .website a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>New Contact Message</h2>

        <p><span class="label">Name:</span> {{ $contactMessage->name }}</p>
        <p><span class="label">Email:</span> {{ $contactMessage->email }}</p>
        <p><span class="label">Subject:</span> {{ $contactMessage->subject }}</p>

        <div class="divider"></div>

        <p><span class="label">Message:</span></p>
        <p>{{ $contactMessage->message }}</p>

        <div class="footer">
            <p>Thank you for your message. We will get back to you as soon as possible.</p>
            <p class="website">This message was sent via the <a href="https://bilta.org" target="_blank">Bilta.org Contact Us</a> form.</p>
        </div>
    </div>
</body>
</html>
