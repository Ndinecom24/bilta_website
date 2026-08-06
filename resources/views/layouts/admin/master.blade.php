<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="BiLTA Administration Dashboard">
    <meta name="author" content="ndinecom">

    <title>BiLTA • Admin Dashboard</title>

    <!-- Fonts & Icons -->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Core Styles -->
    <link href="{{ asset('/admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/site-redesign.css') }}" rel="stylesheet">

    <!-- Trix Editor (local) -->
    <link rel="stylesheet" href="{{ asset('vendor/trix/trix.css') }}">
    <script src="{{ asset('vendor/trix/trix.umd.min.js') }}"></script>

    <style>
        :root {
            --primary: #111147;
            --primary-light: #1a1a6b;
            --secondary: #2d2d8a;

            --accent: #cd5b13;
            --accent-light: #e06b1f;

            --bg: #f6f7f9;
            --surface: rgba(255, 255, 255, 0.92);

            --text: #111147;
            --muted: #64748b;

            --border: rgba(148, 163, 184, 0.18);

            --success: #10b981;
            --danger: #ef4444;

            --shadow-lg: 0 25px 50px rgba(17, 17, 71, 0.12);
            --shadow-md: 0 10px 30px rgba(17, 17, 71, 0.08);

            --radius-xl: 24px;
            --radius-lg: 18px;
            --radius-md: 14px;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body#page-top.admin-theme {
            background: var(--bg);

            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===============================
            WRAPPER
        ================================ */

        #wrapper.admin-wrapper {
            min-height: 100vh;
        }

        #content-wrapper.admin-content-wrapper {
            background: transparent;
        }

        #content.admin-content {
            background: transparent;
        }

        /* ===============================
            PAGE CONTAINER
        ================================ */

        .admin-main-container {
            padding-top: 1rem;
            padding-bottom: 2rem;
        }

        .admin-page-surface {
            position: relative;
            overflow: hidden;

            background: var(--surface);
            backdrop-filter: blur(14px);

            border: 1px solid var(--border);
            border-radius: var(--radius-xl);

            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);

            padding: 1.8rem;
        }

        .admin-page-surface::before {
            content: '';
            position: absolute;
            inset: 0;

            background:
                linear-gradient(to right,
                    rgba(255, 255, 255, 0.02),
                    rgba(255, 255, 255, 0.08));

            pointer-events: none;
        }

        /* ===============================
            TOPBAR
        ================================ */

        .admin-topbar {
            position: sticky;
            top: 12px;
            z-index: 99;

            margin: 1rem;
            padding: .9rem 1.25rem;

            border-radius: var(--radius-lg);

            background: #ffffff;

            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);

            border: 1px solid rgba(148, 163, 184, 0.25);
        }

        .admin-topbar .nav-link,
        .admin-topbar .topbar-label {
            color: #334155 !important;
            font-weight: 500;
        }

        .admin-topbar .nav-link:hover {
            color: #111827 !important;
        }

        .admin-topbar .img-profile {
            border: 2px solid rgba(148, 163, 184, 0.45);
            box-shadow: 0 5px 16px rgba(15, 23, 42, 0.1);
            background: #fff;
        }

        /* ===============================
            SEARCH BAR
        ================================ */

        .admin-top-search {
            height: 46px;

            background: #ffffff;

            border: 1px solid rgba(203, 213, 225, 0.9);

            border-radius: 14px;

            color: #1f2937;

            transition: all .25s ease;
        }

        .admin-top-search:focus {
            background: #fff;
            border-color: rgba(107, 114, 128, 0.4);

            box-shadow:
                0 0 0 4px rgba(107, 114, 128, 0.12);

            color: #111827;
        }

        .admin-top-search::placeholder {
            color: #94a3b8;
        }

        /* ===============================
            STAT PILLS
        ================================ */

        .admin-stat-pill {
            display: inline-flex;
            align-items: center;
            gap: .45rem;

            padding: .45rem .9rem;

            border-radius: 999px;

            background: rgba(100, 116, 139, 0.08);

            border: 1px solid rgba(100, 116, 139, 0.18);

            color: #334155;

            font-size: .78rem;
            font-weight: 600;

            transition: all .25s ease;
        }

        .admin-stat-pill:hover {
            transform: translateY(-2px);
            background: rgba(100, 116, 139, 0.14);
        }

        /* ===============================
            DROPDOWNS
        ================================ */

        .dropdown-menu {
            border: 1px solid rgba(226, 232, 240, 0.7);
            border-radius: 18px;

            overflow: hidden;

            box-shadow:
                0 20px 40px rgba(15, 23, 42, 0.12);

            padding: .6rem;
        }

        .dropdown-item {
            border-radius: 12px;
            padding: .75rem .9rem;

            transition: all .2s ease;
        }

        .dropdown-item:hover {
            background: rgba(100, 116, 139, 0.1);
            color: var(--primary);
        }

        /* ===============================
            CARDS
        ================================ */

        .card {
            border: 0 !important;
            border-radius: var(--radius-lg) !important;

            background: #fff;

            box-shadow: var(--shadow-md);

            overflow: hidden;

            transition: all .25s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow:
                0 24px 45px rgba(15, 23, 42, 0.12);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(226, 232, 240, 0.65);

            padding: 1rem 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* ===============================
            TABLES
        ================================ */

        table.table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        table.table thead th {
            border: 0;
            color: var(--muted);
            font-size: .8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        table.table tbody tr {
            background: #fff;

            box-shadow:
                0 5px 14px rgba(15, 23, 42, 0.04);

            transition: all .2s ease;
        }

        table.table tbody tr:hover {
            transform: scale(1.005);
        }

        table.table td {
            border-top: 0;
            vertical-align: middle;
        }

        /* ===============================
            BUTTONS
        ================================ */

        .btn {
            border-radius: 12px;
            font-weight: 600;
            transition: all .25s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: #1a1a6b;

            border: 0;
        }

        .btn-primary:hover {
            background: #111147;
            opacity: 1;
        }

        /* ===============================
            FOOTER
        ================================ */

        .admin-footer {
            background: transparent;
            border: 0;

            padding-bottom: 1rem;
            margin-top: 1rem;
        }

        .admin-footer-inner {
            background: rgba(255, 255, 255, 0.92);

            backdrop-filter: blur(10px);

            border: 1px solid var(--border);

            border-radius: var(--radius-lg);

            padding: 1rem 1.4rem;

            color: var(--muted);

            box-shadow:
                0 10px 25px rgba(17, 17, 71, 0.06);
        }

        /* ===============================
            SCROLL TO TOP
        ================================ */

        .scroll-to-top.rounded {
            border-radius: 999px !important;

            background: #cd5b13;

            width: 52px;
            height: 52px;

            display: flex;
            align-items: center;
            justify-content: center;

            box-shadow:
                0 10px 24px rgba(17, 17, 71, 0.2);
        }

        .scroll-to-top.rounded:hover {
            transform: translateY(-4px);
        }

        /* ===============================
            SCROLLBAR
        ================================ */

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #e2e8f0;
        }

        ::-webkit-scrollbar-thumb {
            background: #9ca3af;

            border-radius: 999px;
        }

        /* ===============================
            RESPONSIVE
        ================================ */

        @media (max-width: 992px) {

            .admin-main-container {
                padding: .75rem;
            }

            .admin-page-surface {
                padding: 1rem;
                border-radius: 18px;
            }

            .admin-topbar {
                margin: .75rem;
            }

            /* Tables scroll horizontally */
            .table-responsive,
            .card-body {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table.table {
                min-width: 600px;
            }

            /* Cards don't hover-lift on touch */
            .card:hover {
                transform: none;
            }
        }

        @media (max-width: 768px) {

            .admin-topbar {
                border-radius: 16px;
                padding: .75rem;
                margin: .5rem;
                min-height: auto;
            }

            .admin-page-surface {
                border-radius: 16px;
                padding: .85rem;
            }

            .admin-main-container {
                padding: .5rem;
            }

            .admin-stat-pill {
                margin-bottom: .5rem;
            }

            /* Stack form rows */
            .row .col-lg-4,
            .row .col-lg-6,
            .row .col-lg-8 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            /* Buttons don't lift on touch */
            .btn:hover {
                transform: none;
            }

            /* Scroll-to-top smaller */
            .scroll-to-top.rounded {
                width: 42px;
                height: 42px;
                right: 12px !important;
                bottom: 12px !important;
            }

            /* Card header flex-wrap */
            .card-header {
                flex-wrap: wrap;
                gap: .5rem;
            }

            .card-header .d-flex {
                flex-wrap: wrap;
                gap: .5rem;
            }

            /* Trix editor smaller on mobile */
            trix-editor {
                min-height: 200px !important;
            }
        }

        @media (max-width: 576px) {

            .admin-topbar {
                border-radius: 14px;
                padding: .6rem;
                margin: .4rem;
            }

            .admin-page-surface {
                border-radius: 14px;
                padding: .65rem;
            }

            .admin-main-container {
                padding: .35rem;
            }

            /* Full-width buttons on very small screens */
            .d-flex.flex-wrap.gap-2 .btn,
            .d-flex.gap-2 .btn {
                flex: 1 1 auto;
                text-align: center;
            }

            /* Typography scale down */
            h1.h3, .h3 {
                font-size: 1.2rem;
            }

            h5 {
                font-size: 1rem;
            }

            /* Card body tighter padding */
            .card-body {
                padding: .85rem;
            }

            /* Pagination compact */
            .pagination {
                flex-wrap: wrap;
                gap: 4px;
            }

            .pagination .page-link {
                padding: .35rem .6rem;
                font-size: .8rem;
            }

            /* Table font smaller */
            table.table {
                font-size: .82rem;
            }

            table.table .btn-sm {
                padding: .25rem .5rem;
                font-size: .72rem;
            }

            /* Footer compact */
            .admin-footer-inner {
                padding: .75rem;
                font-size: .82rem;
                border-radius: 14px;
            }
        }
    </style>

    @stack('custom-styles')
    @livewireStyles

</head>

<body id="page-top" class="admin-theme">

    <!-- Wrapper -->
    <div id="wrapper" class="admin-wrapper">

        <!-- Sidebar -->
        @include('layouts.admin.sidebar')
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column admin-content-wrapper">

            <!-- Main Content -->
            <div id="content" class="admin-content">

                <!-- Top Navigation -->
                @include('layouts.admin.nav')
                <!-- End Top Navigation -->

                <!-- Page Content -->
                <div class="container-fluid admin-main-container">

                    <div class="admin-page-surface">

                        @if (isset($slot))
                            {{ $slot }}
                        @else
                            @yield('content')
                        @endif

                    </div>

                </div>

            </div>
            <!-- End Main Content -->

            <!-- Footer -->
            @include('layouts.admin.footer')
            <!-- End Footer -->

        </div>
        <!-- End Content Wrapper -->

    </div>
    <!-- End Wrapper -->

    <!-- Scroll Top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- Livewire -->
    @livewireScripts

    @stack('custom-scripts')

    <!-- Scripts -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

</body>

</html>
