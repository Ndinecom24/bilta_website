<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
        }

        .split {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .left-pane {
            flex: 1;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                url('{{ asset('layout/images/bilta_group.jpg') }}') center center no-repeat;
            background-size: cover;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            text-align: center;
        }

        .left-pane h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .left-pane p {
            font-size: 1.1rem;
            margin-top: 1rem;
        }

        .right-pane {
            flex: 1;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 768px) {
            .split {
                flex-direction: column;
            }

            .left-pane {
                height: 40vh;
                background-size: cover;
            }

            .right-pane {
                height: 60vh;
                padding: 2rem 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="split">
        <div class="left-pane">
            <h1 class="mb-3">Welcome Back</h1>
            <p class="mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                Thank you for standing with us as we bring light and hope through translation.
            </p>
            <p>
                <a href="{{ route('site.home') }}" class="btn btn-outline-light">
                    <strong>{{ config('app.name', 'Laravel') }}</strong>
                </a>
            </p>
        </div>
        
        <div class="right-pane">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
