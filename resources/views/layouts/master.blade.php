<!DOCTYPE html>

@if (auth()->check())
    @include('layouts.admin.master')
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-3KNTJTXGCG"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-3KNTJTXGCG');
        </script>


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

        <style>
            .btn-donate {
                background-color: #b36227;
                color: #f8f7f5;
                font-weight: bold;
                border: none;
                border-radius: 20px;
                padding: 6px 12px;
                font-size: 0.9rem;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
            }

            .btn-donate i {
                font-size: 1rem;
            }

            .btn-donate:hover {
                background-color: #e74a3b;
                box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);
                color: #faf9f9;
            }
        </style>

        <style>
            .modal-header {
                background-color: #b36227;
                color: #f8f7f5;
                border-bottom: none;
            }

            .modal-title {
                font-weight: bold;
            }

            .btn-close {
                background-color: #f8f7f5;
                border-radius: 50%;
                opacity: 1;
            }

            .modal-content {
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            }

            .modal-body {
                background-color: #faf9f9;
                padding: 2rem;
            }
        </style>


        <style>
            .modal-footer {
                background-color: #faf9f9;
                border-top: none;
                padding: 1rem 1.5rem;
                border-radius: 0 0 15px 15px;
                display: flex;
                justify-content: flex-end;
                gap: 0.75rem;
            }

            .modal-footer .btn-theme {
                background-color: #b36227;
                color: #f8f7f5;
                font-weight: bold;
                border: none;
                border-radius: 20px;
                padding: 8px 18px;
                font-size: 0.9rem;
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
            }

            .modal-footer .btn-theme:hover {
                background-color: #e74a3b;
                color: #ffffff;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            }

            .modal-footer .btn-secondary {
                border-radius: 20px;
                font-weight: 500;
            }
        </style>




        {{-- <script id="usercentrics-cmp" src="https://web.cmp.usercentrics.eu/ui/loader.js" data-settings-id="2k4APU5flxrGQP" async></script> --}}



       

        @stack('custom-styles')
        {{--    @livewireStyles --}}
        <livewire:styles />
    </head>



    <body>

         {{-- <!--Start of Tawk.to Script-->
         <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/6859236152a648190fbdff1d/1iue34e6j';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script--> --}}


        <script id="chatway" async="true" src="https://cdn.chatway.app/widget.js?id=6OC9P2rVU5pW"></script>


        <!-- ======= Top Bar ======= -->
        <section id="topbar" class="d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a
                            href="mailto:info@bilta.org">{{ $contact_us->email ?? 'info@bilta.org' }}</a></i>
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
                        <li><a class="nav-link scrollto" href="{{ route('projects', '0') }}">Translation Projects</a>
                        </li>
                        <li class="dropdown"><a href="{{ route('site.home') }}#"><span>News | Updates</span> <i
                                    class="bi bi-chevron-down"></i></a>
                            <ul>
                                <li><a href="{{ route('faqs') }}">Faq's</a></li>
                                <li><a href="{{ route('gallery') }}">Gallery</a></li>
                                <li><a href="{{ route('videos') }}">Videos</a></li>
                                <li><a href="{{ route('testimonies') }}">Testimonies</a></li>
                                <li><a href="{{ route('weekly-prayer-points') }}">Weekly Prayer Points</a></li>
                                <li><a href="{{ route('audio.bible') }}">Audio Bible</a></li>
                                <li><a href="{{ route('news', '0') }}">News</a></li>
                            </ul>
                        </li>
                        <li><a class="nav-link scrollto"href="{{ route('about') }}">About us</a>
                        </li>
                        <li><a class="nav-link scrollto" href="{{ route('site.home') }}#team">Team</a></li>
                        <li><a class="nav-link scrollto" href="{{ route('site.home') }}#contact">Contact</a></li>
                        <li>
                            <div class="nav-link scrollto">
                                <button class="btn btn-warning btn-donate btn-sm   m-1" data-bs-toggle="modal"
                                    data-bs-target="#donateModal">
                                    <i class="bi bi-cash me-1"></i> Donate
                                </button>
                            </div>
                        </li>


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

        <div class="modal fade" id="donateModal" tabindex="-1" aria-labelledby="donateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="donateModalLabel">Support Us with a Donation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                        <!-- PayPal Script and Container -->
                        <div class="row">
                            <div class="col-12">

                                <script
                                    src="https://www.paypal.com/sdk/js?client-id=BAANEWBe_GCODxYELBmUPu5L9O196AdBbBAl4T6aGF_-9XsMPzPXQ6t5j7sZZCE24hFJNYC4F6jy8DSv9Q&components=hosted-buttons&disable-funding=venmo&currency=USD">
                                </script>
                                <div id="paypal-container-WP56E5J4AML4W"></div>
                                <script>
                                    paypal.HostedButtons({
                                        hostedButtonId: "WP56E5J4AML4W",
                                    }).render("#paypal-container-WP56E5J4AML4W")
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
                                    <li><i class="bx bx-chevron-right"></i> <a
                                            href="{{ route('site.home') }}">Home</a>
                                    </li>
                                    <li><i class="bx bx-chevron-right"></i> <a href="{{ route('about') }}">About
                                            us</a>
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

                                <!-- Manage Cookies Button -->
                                <div class="mt-3">
                                    <button class="btn btn-link p-0"
                                        onclick="new bootstrap.Modal(document.getElementById('cookieConsentModal')).show();">
                                        Manage Cookies
                                    </button>
                                </div>


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

        <!-- Cookie Consent Modal -->
        <!-- Cookie Consent Modal -->
        <div class="modal fade" id="cookieConsentModal" tabindex="-1" aria-labelledby="cookieConsentLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="cookieConsentLabel">Cookiebot</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-3" id="cookieTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="consent-tab" data-bs-toggle="tab"
                                    data-bs-target="#consent" type="button" role="tab" aria-controls="consent"
                                    aria-selected="true">Consent</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="details-tab" data-bs-toggle="tab"
                                    data-bs-target="#details" type="button" role="tab" aria-controls="details"
                                    aria-selected="false">Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="policy-tab" data-bs-toggle="tab"
                                    data-bs-target="#policy" type="button" role="tab" aria-controls="policy"
                                    aria-selected="false">Cookie Policy</button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="cookieTabContent">
                            <div class="tab-pane fade show active" id="consent" role="tabpanel"
                                aria-labelledby="consent-tab">
                                <p><strong>This website uses cookies to enhance your experience.</strong></p>
                                <p>Cookies are small text files stored on your device to help us analyze traffic,
                                    improve site functionality, and provide personalized content and advertising. You
                                    can choose which types of cookies to accept below.</p>

                                <form id="cookie-consent-form">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="essential"
                                            id="cookie-essential" checked disabled>
                                        <label class="form-check-label" for="cookie-essential">Essential (Always
                                            Active)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="analytics"
                                            id="cookie-analytics">
                                        <label class="form-check-label" for="cookie-analytics">Analytics</label>
                                    </div>
                                    {{-- <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="marketing" id="cookie-marketing">
                  <label class="form-check-label" for="cookie-marketing">Marketing</label>
                </div> --}}
                                </form>
                            </div>

                            <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <p><strong>Cookie Details</strong></p>
                                <p>Here you can list the specific cookies used, their purpose, expiration times, and the
                                    vendors involved.</p>
                                <ul>
                                    <li><strong>_ga (Google Analytics)</strong>: Tracks visitor behavior, expires after
                                        2 years.</li>
                                    <li><strong>_fbp (Facebook Pixel)</strong>: Tracks advertising effectiveness,
                                        expires after 3 months.</li>
                                    <!-- Add more cookie details as needed -->
                                </ul>
                            </div>

                            <div class="tab-pane fade" id="policy" role="tabpanel" aria-labelledby="policy-tab"
                                style="max-height: 400px; overflow-y: auto;">
                                <h5>Cookie Policy</h5>
                                <p><strong>Effective Date:</strong> 05/30/2025 </p>

                                <p>This Cookie Policy explains how <strong>BILTA</strong> (“we”, “us”, or “our”) uses
                                    cookies and similar technologies on our website <a href="https://www.bilta.org"
                                        target="_blank" rel="noopener noreferrer">https://www.bilta.org</a>. It
                                    describes what cookies are, the types we use, and how you can control them.</p>

                                <h6>1. What are Cookies?</h6>
                                <p>Cookies are small text files that websites store on your device (computer,
                                    smartphone, or tablet) when you visit them. They help websites remember your
                                    preferences and activity, enhancing your browsing experience and helping us
                                    understand how visitors use our site.</p>

                                <h6>2. Types of Cookies We Use</h6>
                                <ul>
                                    <li><strong>Essential Cookies:</strong> Necessary for the website to function
                                        properly. These enable basic features like page navigation and access to secure
                                        areas.</li>
                                    <li><strong>Analytics & Performance Cookies:</strong> Used to understand how
                                        visitors interact with the website by collecting anonymous data. This helps
                                        improve site performance.</li>
                                    <li><strong>Functionality Cookies:</strong> Enable the site to remember choices you
                                        make (like language or region) to provide a more personalized experience.</li>
                                    {{-- <li><strong>Advertising & Targeting Cookies:</strong> Used to deliver relevant ads and limit how often you see them. These cookies also help measure the effectiveness of campaigns.</li> --}}
                                </ul>

                                <h6>3. Third-Party Cookies</h6>
                                <p>We may allow trusted third-party partners to place cookies on your device through our
                                    site. These cookies are subject to the privacy policies of those providers.</p>

                                <h6>4. How You Can Manage Cookies</h6>
                                <p>When you visit our site, a cookie banner allows you to:</p>
                                <ul>
                                    <li>Accept all cookies</li>
                                    <li>Reject non-essential cookies</li>
                                    <li>Customize your preferences</li>
                                </ul>
                                <p>You can also manage cookies through your browser settings:</p>
                                <ul>
                                    <li><a href="https://support.google.com/chrome/answer/95647" target="_blank"
                                            rel="noopener noreferrer">Chrome</a></li>
                                    <li><a href="https://support.mozilla.org/en-US/kb/cookies-information-websites-store-on-your-computer"
                                            target="_blank" rel="noopener noreferrer">Firefox</a></li>
                                    <li><a href="https://support.apple.com/en-us/HT201265" target="_blank"
                                            rel="noopener noreferrer">Safari</a></li>
                                    <li><a href="https://support.microsoft.com/en-us/microsoft-edge/delete-cookies-in-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09"
                                            target="_blank" rel="noopener noreferrer">Edge</a></li>
                                </ul>
                                <p><em>Note: Disabling some cookies may impact site functionality.</em></p>

                                <h6>5. Changes to This Policy</h6>
                                <p>We may update this policy from time to time. Any changes will be posted here with a
                                    revised effective date.</p>

                                <h6>6. Contact Us</h6>
                                <p>If you have any questions about our use of cookies, contact us at:</p>
                                <p>
                                    📧 <strong>Email:</strong> <a href="mailto:info@bilta.org">info@bilta.org</a><br>
                                    📍 <strong>Address:</strong> {{ $contact_us->address ?? '--' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between border-0">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="denyCookies()">Deny</button>
                        <div>
                            <button type="button" class="btn btn-secondary me-2"
                                onclick="document.getElementById('cookie-consent-form').dispatchEvent(new Event('submit', {cancelable: true, bubbles: true}))">Customize</button>
                            <button type="button" class="btn btn-primary" onclick="allowAllCookies()">Allow
                                All</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <script>
            function setCookie(name, value, days) {
                const expires = new Date(Date.now() + days * 864e5).toUTCString();
                document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/`;
            }

            function getCookie(name) {
                return document.cookie.split('; ').find(row => row.startsWith(name + '='))?.split('=')[1];
            }

            function loadAnalytics() {
                const script = document.createElement('script');
                script.src = "https://www.googletagmanager.com/gtag/js?id=G-3KNTJTXGCG";
                script.async = true;
                document.head.appendChild(script);
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());
                gtag('config', 'G-3KNTJTXGCG');
            }

            function sendConsentToBackend(data) {
                fetch('/api/cookie-consent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });
            }

            function denyCookies() {
                const data = {
                    essential: true,
                    analytics: false,
                    marketing: false,
                    timestamp: new Date().toISOString()
                };
                setCookie('cookie_consent', JSON.stringify(data), 365);
                sendConsentToBackend(data);
                bootstrap.Modal.getInstance(document.getElementById('cookieConsentModal')).hide();
            }

            function allowAllCookies() {
                const data = {
                    essential: true,
                    analytics: true,
                    marketing: true,
                    timestamp: new Date().toISOString()
                };
                setCookie('cookie_consent', JSON.stringify(data), 365);
                sendConsentToBackend(data);
                loadAnalytics();
                bootstrap.Modal.getInstance(document.getElementById('cookieConsentModal')).hide();
            }


            function isJson(str) {
                try {
                    JSON.parse(str);
                    return true;
                } catch (e) {
                    return false;
                }
            }

            document.addEventListener("DOMContentLoaded", function() {
                const saved = getCookie('cookie_consent');
                if (!saved || !isJson(decodeURIComponent(saved))) {
                    new bootstrap.Modal(document.getElementById('cookieConsentModal')).show();
                } else {
                    const consent = JSON.parse(decodeURIComponent(saved));
                    if (consent.analytics) loadAnalytics();
                }

                document.getElementById('cookie-consent-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = e.target;
                    const data = {
                        essential: true,
                        analytics: form.analytics.checked,
                        marketing: form.marketing.checked,
                        timestamp: new Date().toISOString()
                    };
                    setCookie('cookie_consent', JSON.stringify(data), 365);
                    sendConsentToBackend(data);
                    if (data.analytics) loadAnalytics();
                    bootstrap.Modal.getInstance(document.getElementById('cookieConsentModal')).hide();
                });
            });
        </script>



    </body>

    </html>

@endif
