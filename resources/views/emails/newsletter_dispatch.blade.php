<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $newsletter->title }}</title>
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
        .pdf-list {
            margin: 16px 0;
            padding: 14px;
            background: #f8fbff;
            border: 1px solid #dbe4f1;
            border-radius: 10px;
        }
        .pdf-list p {
            margin: 0 0 8px;
            font-weight: 700;
            font-size: 14px;
            color: #0f2742;
        }
        .pdf-list ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .pdf-list li {
            padding: 4px 0;
        }
        .pdf-list li a {
            color: #1f3f63;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $newsletter->title }}</h1>
            @if ($newsletter->publish_date)
                <p>{{ \Carbon\Carbon::parse($newsletter->publish_date)->format('F d, Y') }}</p>
            @endif
        </div>

        <div class="email-body">
            {!! $newsletter->content !!}

            @if ($newsletter->getMedia('newsletter_pdfs')->count() > 0)
                <div class="pdf-list">
                    <p>📎 Attached Files</p>
                    <ul>
                        @foreach ($newsletter->getMedia('newsletter_pdfs') as $media)
                            <li>
                                <a href="{{ $media->getUrl() }}">{{ $media->name }} ({{ round($media->size / 1024) }} KB)</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="email-footer">
            <p>
                You are receiving this because you subscribed to the BiLTA newsletter.<br>
                &copy; {{ date('Y') }} Bible and Literature Translation Association (BiLTA)
            </p>
        </div>
    </div>
</body>
</html>
