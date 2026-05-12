<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="60">
    <title>We'll Be Right Back | BiLTA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #111147;
            color: #fff;
            overflow: hidden;
            position: relative;
        }

        /* Animated background */
        .bg-pattern {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(195,50,5,.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(195,50,5,.05) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(26,26,107,.6) 0%, transparent 60%);
            z-index: 0;
        }

        .bg-pattern::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 48px,
                rgba(195,50,5,.02) 48px,
                rgba(195,50,5,.02) 49px
            ),
            repeating-linear-gradient(
                90deg,
                transparent,
                transparent 48px,
                rgba(195,50,5,.02) 48px,
                rgba(195,50,5,.02) 49px
            );
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(48px, 48px); }
        }

        .maintenance-wrap {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 580px;
            padding: 2rem;
        }

        /* Logo */
        .maintenance-logo {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0 8px 32px rgba(0,0,0,.3);
            margin-bottom: 2rem;
        }

        /* Animated gear icon */
        .maintenance-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(195,50,5,.1);
            border: 2px solid rgba(195,50,5,.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #c33205;
            margin-bottom: 2rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(195,50,5,.2); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 16px rgba(195,50,5,0); }
        }

        .maintenance-icon i {
            animation: spin 4s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .maintenance-badge {
            display: inline-block;
            background: rgba(195,50,5,.12);
            color: #c33205;
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 600;
            font-size: .82rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .maintenance-title {
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .maintenance-title span {
            color: #c33205;
        }

        .maintenance-desc {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #94a3b8;
            margin-bottom: 2.5rem;
            max-width: 460px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Features / what we do */
        .maintenance-features {
            display: flex;
            justify-content: center;
            gap: 28px;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }

        .maintenance-feat {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .88rem;
            color: #cbd5e1;
        }

        .maintenance-feat-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(195,50,5,.1);
            color: #c33205;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
            flex-shrink: 0;
        }

        /* Progress bar */
        .maintenance-progress {
            max-width: 320px;
            margin: 0 auto 2rem;
        }

        .maintenance-progress-label {
            display: flex;
            justify-content: space-between;
            font-size: .8rem;
            color: #64748b;
            margin-bottom: 8px;
        }

        .maintenance-progress-bar {
            height: 6px;
            border-radius: 3px;
            background: rgba(255,255,255,.08);
            overflow: hidden;
        }

        .maintenance-progress-fill {
            height: 100%;
            border-radius: 3px;
            background: linear-gradient(90deg, #c33205, #e04a1f);
            animation: progress 3s ease-in-out infinite;
            width: 65%;
        }

        @keyframes progress {
            0%   { width: 30%; }
            50%  { width: 80%; }
            100% { width: 30%; }
        }

        /* Button */
        .maintenance-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #c33205, #9a2804);
            color: #111147;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: .95rem;
            transition: all .25s;
            box-shadow: 0 4px 16px rgba(195,50,5,.25);
        }

        .maintenance-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(195,50,5,.35);
        }

        .maintenance-footer {
            margin-top: 3rem;
            font-size: .82rem;
            color: #475569;
        }

        .maintenance-footer a {
            color: #c33205;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .maintenance-title { font-size: 1.7rem; }
            .maintenance-desc { font-size: .95rem; }
            .maintenance-features { flex-direction: column; align-items: center; gap: 14px; }
            .maintenance-icon { width: 80px; height: 80px; font-size: 2rem; }
        }
    </style>
</head>
<body>

    <div class="bg-pattern"></div>

    <div class="maintenance-wrap">

        <img src="{{ asset('layout/images/bilta_logo_one.png') }}"
             alt="BiLTA Logo"
             class="maintenance-logo"
             onerror="this.style.display='none'">

        <div class="maintenance-icon">
            <i class="bi bi-gear"></i>
        </div>

        <div class="maintenance-badge">Scheduled Maintenance</div>

        <h1 class="maintenance-title">
            We'll Be <span>Right Back</span>
        </h1>

        <p class="maintenance-desc">
            We're performing some updates to bring you a better experience.
            BiLTA's website will be back online shortly. Thank you for your patience!
        </p>

        <div class="maintenance-features">
            <div class="maintenance-feat">
                <div class="maintenance-feat-icon"><i class="bi bi-book"></i></div>
                <span>Bible Translation</span>
            </div>
            <div class="maintenance-feat">
                <div class="maintenance-feat-icon"><i class="bi bi-headphones"></i></div>
                <span>Audio Scripture</span>
            </div>
            <div class="maintenance-feat">
                <div class="maintenance-feat-icon"><i class="bi bi-people"></i></div>
                <span>Literacy &amp; Training</span>
            </div>
        </div>

        <div class="maintenance-progress">
            <div class="maintenance-progress-label">
                <span>Working on it...</span>
                <span>Almost there</span>
            </div>
            <div class="maintenance-progress-bar">
                <div class="maintenance-progress-fill"></div>
            </div>
        </div>

        <a href="{{ url('/') }}" class="maintenance-btn">
            <i class="bi bi-arrow-clockwise"></i>
            Try Again
        </a>

        <div class="maintenance-footer">
            <p>&copy; {{ date('Y') }} BiLTA &mdash; Bible &amp; Literature Translation Association</p>
            <p style="margin-top: 6px;">
                Questions? Email us at <a href="mailto:infor@bilta.org">infor@bilta.org</a>
            </p>
        </div>

    </div>

</body>
</html>
