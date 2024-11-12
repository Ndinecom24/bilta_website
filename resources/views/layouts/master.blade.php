<!DOCTYPE html>

@if (auth()->check())
    @include('layouts.admin.master')
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta name="google-site-verification" content="zEabVLZ5N_dEO0PcCoEhDelHwpDzMbLgc14jLRA1IRE" />
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>BiLTA</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
        <link href={{ asset('assets/css/style.css') }} rel="stylesheet">

        <!-- Google Fonts -->
        <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
            rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

        @stack('custom-styles')
        {{--    @livewireStyles --}}
        <livewire:styles />
    </head>

    <body>
        <!-- ======= Top Bar ======= -->
        <section id="topbar" class="d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a
                            href="mailto:contact@example.com">{{ $contact_us->email ?? 'info@bilta.org' }}</a></i>
                    <i
                        class="bi bi-phone d-flex align-items-center ms-4"><span>{{ $contact_us->phone ?? '000-000-000' }}</span></i>
                </div>

                {{-- <div class="cta d-none d-md-flex align-items-center">
          <a href="#about" class="scrollto">Get Started</a>
        </div> --}}
            </div>
        </section>

        <!-- ======= Header ======= -->
        <header id="header" class="d-flex align-items-center">
            <div class="container d-flex align-items-center justify-content-between">

                <div class="logo" style="display: flex ;">
                    <b> <span><a style="color: #b25e1d" href="{{ route('site.home') }}"> BiLTA</a></span></b>
                    <a href="{{ route('site.home') }}">
                        <img style="width: 150px;  background-color: #ffffff ; border-radius: 20px; margin-bottom: 4px ; margin-top: -6px ; margin-left: 6px "
                            src="{{ asset('layout/images/bilta_logo_one.png') }}">
                    </a>
                </div>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="nav-link scrollto" href="{{ route('site.home') }}">Home</a></li>
                        <li><a class="nav-link scrollto"
                                href="{{ route('projects', '0') }}">Translation Projects</a></li>
                        <li class="dropdown"><a href="{{ route('site.home') }}#"><span>News | Updates</span> <i
                                    class="bi bi-chevron-down"></i></a>
                            <ul>

                                <li><a href="{{ route('faqs') }}">Faq's</a></li>
                                <li><a href="{{ route('gallery') }}">Gallery</a></li>
                                <li><a href="{{ route('videos') }}">Videos</a></li>
                                <li><a href="{{ route('testimonies') }}">Testimonies</a></li>
                                <li><a href="{{ route('weekly-prayer-points') }}">Weekly Prayer Points</a></li>
                                {{-- <li><a href="{{ route('projects', '0') }}">Translation Projects</a></li> --}}
                                <li><a href="{{ route('news', '0') }}">News</a></li>
                            </ul>
                        </li>
                        {{-- <li><a class="nav-link scrollto" href="{{ route('about') }}">About</a></li> --}}
                        
                        <li><a class="nav-link scrollto"  href="{{ route('site.home') }}#translation-projects">About</a></li>
                        {{-- <li><a class="nav-link scrollto " href="#portfolio">Portfolio</a></li> --}}
                        <li><a class="nav-link scrollto" href="{{ route('site.home') }}#team">Team</a></li>
                        {{-- <li><a class="nav-link scrollto" href="#pricing">Pricing</a></li> --}}
                        {{-- <li><a href="blog.html">Blog</a></li> --}}

                        <li><a class="nav-link scrollto" href="{{ route('site.home') }}#contact">Contact</a></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->

            </div>
        </header><!-- End Header -->

        @if (isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif

        <!-- ======= Footer ======= -->


        @if (auth()->check())
        @else
            <footer id="footer">

                <div class="footer-top">
                    <div class="container">
                        <div class="row">

                            <div class="col-lg-3 col-md-6 footer-contact">
                                <h3>BiLTA</h3>
                                <p>
                                    {{ $contact_us->address ?? '--' }} <br><br>
                                    <strong>Phone:</strong> {{ $contact_us->phone ?? '0000-000-000' }}<br>
                                    <strong>Email:</strong> {{ $contact_us->email ?? 'info@bilta.org' }}<br>
                                </p>
                            </div>

                            <div class="col-lg-2 col-md-6 footer-links">
                                <h4>Useful Links</h4>
                                <ul>
                                    <li><i class="bx bx-chevron-right"></i> <a href="{{ route('site.home') }}">Home</a>
                                    </li>
                                    <li><i class="bx bx-chevron-right"></i> <a href="{{ route('about') }}">About us</a>
                                    </li>
                                    <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                                    <li><i class="bx bx-chevron-right"></i> <a
                                            href="{{ route('weekly-prayer-points') }}">Weekly Prayer points</a></li>
                                    <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                                </ul>
                            </div>

                            <div class="col-lg-3 col-md-6 footer-links">
                                <h4>Our Services</h4>
                                <ul>
                                    @foreach ($services as $service)
                                        <li><i class="bx bx-chevron-right"></i> <a
                                                href="#">{{ $service->title ?? '--' }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="col-lg-4 col-md-6 footer-newsletter">
                                <h4>Become a Sponsor / Join Our Newsletter</h4>
                                <p>Get the latest news, weekly prayer points, notifications and exclusive info
                                    conveniently in your inbox</p>
                                <form action="" method="post">
                                    <input type="email" name="email"><input type="submit" value="Subscribe">
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="container d-lg-flex py-4">

                    <div class="me-lg-auto text-center text-lg-start">
                        <div class="copyright">
                            &copy; Copyright {{ date('Y') }} <strong><span>BILTA</span></strong>. All Rights
                            Reserved
                            <p class="fl_right">Designed by <a target="_blank" href="https://www.ndinecom.com"
                                    title="This is a bible translation site">Ndinecom</a></p>

                        </div>
                        <div class="credits">
                            <!-- All the links in the footer should remain intact. -->
                            <!-- You can delete the links only if you purchased the pro version. -->
                            <!-- Licensing information: https://bootstrapmade.com/license/ -->
                            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexor-free-multipurpose-bootstrap-template/ -->
                            {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
                        </div>
                    </div>
                    <div class="social-links text-center text-lg-right pt-3 pt-lg-0">
                        <a href="{{ $contact_us->twitter_url ?? '#' }}" class="twitter"><i
                                class="bx bxl-twitter"></i></a>
                        <a href="{{ $contact_us->facebook_url ?? '#' }}" class="facebook"><i
                                class="bx bxl-facebook"></i></a>
                        <a href="{{ $contact_us->youtube ?? '#' }}" class="-youtube"><i
                                class="bx bxl-youtube"></i></a>
                        <a href="{{ $contact_us->whatsapp_link ?? '#' }}" class="google-plus"><i
                                class="bx bxl-whatsapp"></i></a>
                        <a href="{{ $contact_us->linkedin_url ?? '#' }}" class="linkedin"><i
                                class="bx bxl-linkedin"></i></a>
                    </div>
                </div>
            </footer><!-- End Footer -->


        @endif



        {{-- @livewireScripts --}}
        <livewire:scripts />

        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
        @stack('custom-scripts')

    </body>

    </html>

@endif
