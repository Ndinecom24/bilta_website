<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Too Many Requests | BiLTA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #111147 0%, #1a1a6b 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        .error-container { max-width: 500px; }
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: #cd5b13;
            line-height: 1;
            margin-bottom: 1rem;
        }
        h1 { font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; }
        p { color: #94a3b8; margin-bottom: 2rem; line-height: 1.6; }
        .btn-home {
            display: inline-block;
            background: #cd5b13;
            color: #111147;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-home:hover { background: #a34810; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">429</div>
        <h1>Too Many Requests</h1>
        <p>You've made too many requests in a short time. Please wait a moment and try again.</p>
        <a href="{{ url('/') }}" class="btn-home">Back to Home</a>
    </div>
</body>
</html>
