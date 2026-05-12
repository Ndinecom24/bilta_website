<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BiLTA') }} &mdash; @yield('page-title', 'Authentication')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: #111147;
        }

        .auth-split {
            display: flex;
            min-height: 100vh;
        }

        /* ── Left brand panel ── */
        .auth-brand {
            flex: 0 0 58%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem 3.5rem;
            overflow: hidden;
            color: #fff;
        }


        .auth-brand-bg {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(160deg, rgba(17,17,71,.88) 0%, rgba(17,17,71,.72) 50%, rgba(195,50,5,.18) 100%),
                url('{{ asset('assets/img/testimonials-bg.jpg') }}') center / cover no-repeat;
            z-index: 0;
        }

        .auth-brand-content {
            position: relative;
            z-index: 1;
            max-width: 520px;
        }

        .auth-brand-logo {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            object-fit: cover;
            box-shadow: 0 8px 32px rgba(0,0,0,.25);
            margin-bottom: 2rem;
        }

        .auth-brand-name {
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #c33205;
            margin-bottom: .75rem;
        }

        .auth-brand-headline {
            font-size: 2.6rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 1.25rem;
        }

        .auth-brand-headline span {
            color: #c33205;
        }

        .auth-brand-desc {
            font-size: 1.05rem;
            line-height: 1.85;
            color: #cbd5e1;
            margin-bottom: 2.5rem;
        }

        .auth-brand-features {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 2.5rem;
        }

        .auth-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: .95rem;
            color: #e2e8f0;
        }

        .auth-feature-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(195,50,5,.15);
            color: #c33205;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .auth-brand-footer {
            position: relative;
            z-index: 1;
            margin-top: auto;
            padding-top: 2rem;
        }

        .auth-brand-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            transition: color .2s;
        }

        .auth-brand-link:hover {
            color: #c33205;
        }

        /* ── Right form panel ── */
        .auth-form-panel {
            flex: 0 0 42%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            background: #ffffff;
            position: relative;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 440px;
        }

        .auth-form-header {
            margin-bottom: 2rem;
        }

        .auth-form-logo-mobile {
            display: none;
            width: 56px;
            height: 56px;
            border-radius: 14px;
            object-fit: cover;
            margin-bottom: 1.25rem;
        }

        .auth-form-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #111147;
            margin-bottom: .35rem;
        }

        .auth-form-subtitle {
            font-size: .95rem;
            color: #64748b;
            line-height: 1.6;
        }

        /* ── Form styling ── */
        .auth-field {
            margin-bottom: 1.25rem;
        }

        .auth-field label {
            display: block;
            font-size: .85rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .auth-field .form-control {
            height: 50px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 0 16px;
            font-size: .95rem;
            transition: all .2s;
            background: #f8fafc;
        }

        .auth-field .form-control:focus {
            border-color: #c33205;
            box-shadow: 0 0 0 3px rgba(195,50,5,.12);
            background: #fff;
        }

        .auth-field .form-control.is-invalid {
            border-color: #ef4444;
        }

        .auth-field .invalid-feedback {
            font-size: .82rem;
            margin-top: 4px;
        }

        .auth-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .auth-actions .form-check-label {
            font-size: .88rem;
            color: #475569;
        }

        .auth-actions .form-check-input:checked {
            background-color: #c33205;
            border-color: #c33205;
        }

        .auth-btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            background: linear-gradient(135deg, #111147, #1a1a6b);
            color: #fff;
            cursor: pointer;
            transition: all .25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .auth-btn:hover {
            background: linear-gradient(135deg, #1a1a6b, #2d2d8a);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(17,17,71,.18);
        }

        .auth-link {
            color: #c33205;
            text-decoration: none;
            font-weight: 600;
            font-size: .88rem;
            transition: color .2s;
        }

        .auth-link:hover {
            color: #9a2804;
        }

        .auth-footer-text {
            text-align: center;
            margin-top: 2rem;
            font-size: .85rem;
            color: #94a3b8;
        }

        .auth-alert {
            border-radius: 12px;
            font-size: .9rem;
            padding: 14px 18px;
            margin-bottom: 1.5rem;
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .auth-split { flex-direction: column; }

            .auth-brand {
                flex: none;
                padding: 2.5rem 2rem 2rem;
                min-height: auto;
            }

            .auth-brand-headline { font-size: 1.8rem; }
            .auth-brand-desc { display: none; }
            .auth-brand-features { display: none; }
            .auth-brand-footer { display: none; }

            .auth-form-panel {
                flex: 1;
                padding: 2rem 1.5rem 3rem;
            }

            .auth-form-logo-mobile { display: block; }
        }

        @media (max-width: 576px) {
            .auth-brand { padding: 2rem 1.25rem 1.5rem; }
            .auth-brand-headline { font-size: 1.5rem; }
            .auth-form-panel { padding: 1.5rem 1.25rem 2rem; }
            .auth-form-title { font-size: 1.4rem; }
        }
    </style>
</head>

<body>

    <div class="auth-split">

        {{-- ── Left brand panel ── --}}
        <div class="auth-brand">
            <div class="auth-brand-bg"></div>

            <div class="auth-brand-content">
                <img src="{{ asset('layout/images/bilta_logo_one.png') }}"
                     alt="BiLTA Logo"
                     class="auth-brand-logo">

                <div class="auth-brand-name">BiLTA Zambia</div>

                <h1 class="auth-brand-headline">
                    Translating Hope Into <span>Every Language</span>
                </h1>

                <p class="auth-brand-desc">
                    The Bible &amp; Literature Translation Association (BiLTA) is dedicated to
                    making Scripture and essential literature accessible in local Zambian languages.
                    Through Bible translation, audio recordings, literacy programs, and community
                    partnerships, we serve communities across Zambia.
                </p>

                <div class="auth-brand-features">
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="bi bi-book"></i></div>
                        <span>Bible &amp; literature translation into local languages</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="bi bi-headphones"></i></div>
                        <span>Audio Scripture for oral communities</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="bi bi-people"></i></div>
                        <span>Literacy development &amp; community training</span>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon"><i class="bi bi-globe"></i></div>
                        <span>Serving 50+ active translation projects</span>
                    </div>
                </div>
            </div>

            <div class="auth-brand-footer">
                <a href="{{ route('site.home') }}" class="auth-brand-link">
                    <i class="bi bi-arrow-left"></i>
                    Back to BiLTA Website
                </a>
            </div>
        </div>

        {{-- ── Right form panel ── --}}
        <div class="auth-form-panel">
            <div class="auth-form-wrap">

                <img src="{{ asset('layout/images/bilta_logo_one.png') }}"
                     alt="BiLTA Logo"
                     class="auth-form-logo-mobile">

                @yield('content')

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
