{{-- =========================================
    MODERN PROFESSIONAL BiLTA FOOTER
========================================= --}}

<footer class="bilta-footer-modern">

    {{-- TOP SECTION --}}
    <div class="footer-main">

        <div class="container">

            <div class="row g-5">

                {{-- BRAND / ABOUT --}}
                <div class="col-lg-4 col-md-6">

                    <div class="footer-brand">

                        <a href="{{ url('/') }}" class="footer-logo">
                            <span class="footer-logo-mark">Bi</span>LTA
                        </a>

                        <p class="footer-description">
                            {{ \Illuminate\Support\Str::limit(strip_tags($about_us->what_is ?? '--'), 220) }}
                        </p>

                        <div class="footer-socials">

                            <a href="{{ $contact_us->facebook_url ?? '#' }}"
                                target="_blank"
                                aria-label="Facebook">

                                <i class="bi bi-facebook"></i>

                            </a>

                            <a href="{{ $contact_us->linkedin_url ?? '#' }}"
                                target="_blank"
                                aria-label="LinkedIn">

                                <i class="bi bi-linkedin"></i>

                            </a>

                            <a href="{{ $contact_us->twitter_url ?? '#' }}"
                                target="_blank"
                                aria-label="Twitter">

                                <i class="bi bi-twitter-x"></i>

                            </a>

                            <a href="{{ $contact_us->youtube ?? '#' }}"
                                target="_blank"
                                aria-label="YouTube">

                                <i class="bi bi-youtube"></i>

                            </a>

                            <a href="{{ $contact_us->whatsapp_link ?? '#' }}"
                                target="_blank"
                                aria-label="WhatsApp">

                                <i class="bi bi-whatsapp"></i>

                            </a>

                        </div>

                    </div>

                </div>

                {{-- QUICK LINKS --}}
                <div class="col-lg-2 col-md-6">

                    <h5 class="footer-title">
                        Quick Links
                    </h5>

                    <ul class="footer-links">

                        <li>
                            <a href="{{ url('/') }}">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="#about">
                                About Us
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('projects', '0') }}">
                                Projects
                            </a>
                        </li>

                        <li>
                            <a href="#team">
                                Our Team
                            </a>
                        </li>

                        <li>
                            <a href="#contact">
                                Contact
                            </a>
                        </li>

                    </ul>

                </div>

                {{-- MINISTRY AREAS --}}
                <div class="col-lg-3 col-md-6">

                    <h5 class="footer-title">
                        Ministry Areas
                    </h5>

                    <ul class="footer-links">

                        <li>
                            <a href="#">
                                Bible Translation
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                Literacy Programs
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                Audio Bible
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                Community Outreach
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                Scripture Engagement
                            </a>
                        </li>

                    </ul>

                </div>

                {{-- CONTACT / NEWSLETTER --}}
                <div class="col-lg-3 col-md-6">

                    <h5 class="footer-title">
                        Stay Connected
                    </h5>

                    <p class="footer-news-text">
                        Subscribe for ministry updates, translation progress,
                        testimonies, and upcoming initiatives.
                    </p>

                    <form class="footer-newsletter">

                        <div class="newsletter-group">

                            <input type="email"
                                class="form-control"
                                placeholder="Enter your email">

                            <button type="submit">
                                <i class="bi bi-send-fill"></i>
                            </button>

                        </div>

                    </form>

                    <div class="footer-contact">

                        <div class="footer-contact-item">

                            <i class="bi bi-envelope-fill"></i>

                            <span>
                                {{ $contact_us->email ?? 'info@bilta.org' }}
                            </span>

                        </div>

                        <div class="footer-contact-item">

                            <i class="bi bi-telephone-fill"></i>

                            <span>
                                {{ $contact_us->phone ?? '--' }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- FOOTER BOTTOM --}}
    <div class="footer-bottom">

        <div class="container">

            <div class="row align-items-center gy-3">

                <div class="col-md-6">

                    <p class="copyright-text mb-0">

                        © {{ date('Y') }}
                        Bible & Literature Translation Association (BiLTA).
                        All Rights Reserved.

                    </p>

                </div>

                <div class="col-md-6 text-md-end">

                    <p class="developer-text mb-0">

                        Designed & Developed by

                        <a href="https://www.ndinecom.com"
                            target="_blank">

                            Ndinecom

                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</footer>

{{-- =========================================
    MODERN FOOTER CSS
========================================= --}}

<style>

.bilta-footer-modern{
    background:
        linear-gradient(
            135deg,
            #0f172a 0%,
            #111827 50%,
            #1e293b 100%
        );
    color:#cbd5e1;
    position:relative;
    overflow:hidden;
}

.footer-main{
    padding:90px 0 60px;
}

.footer-logo{
    font-size:2.4rem;
    font-weight:800;
    text-decoration:none;
    color:#ffffff;
    display:inline-block;
    margin-bottom:22px;
}

.footer-logo-mark{
    color:#f59e0b;
}

.footer-description{
    line-height:1.9;
    color:#94a3b8;
    font-size:.98rem;
    max-width:360px;
}

.footer-socials{
    display:flex;
    gap:14px;
    margin-top:28px;
}

.footer-socials a{
    width:46px;
    height:46px;
    border-radius:14px;
    background:rgba(255,255,255,.06);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#ffffff;
    text-decoration:none;
    transition:.35s ease;
    font-size:1rem;
}

.footer-socials a:hover{
    background:#f59e0b;
    transform:translateY(-5px);
}

.footer-title{
    color:#ffffff;
    font-size:1.2rem;
    font-weight:700;
    margin-bottom:28px;
    position:relative;
}

.footer-title::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-12px;
    width:45px;
    height:3px;
    border-radius:50px;
    background:#f59e0b;
}

.footer-links{
    list-style:none;
    padding:0;
    margin:0;
}

.footer-links li{
    margin-bottom:15px;
}

.footer-links a{
    color:#94a3b8;
    text-decoration:none;
    transition:.3s ease;
    font-size:.96rem;
}

.footer-links a:hover{
    color:#ffffff;
    padding-left:6px;
}

.footer-news-text{
    color:#94a3b8;
    line-height:1.8;
    margin-bottom:22px;
}

.newsletter-group{
    display:flex;
    overflow:hidden;
    border-radius:16px;
    background:rgba(255,255,255,.08);
    margin-bottom:25px;
}

.newsletter-group input{
    background:transparent;
    border:none;
    color:white;
    padding:15px 18px;
    flex:1;
}

.newsletter-group input::placeholder{
    color:#94a3b8;
}

.newsletter-group input:focus{
    outline:none;
    box-shadow:none;
    background:transparent;
    color:white;
}

.newsletter-group button{
    width:60px;
    border:none;
    background:#f59e0b;
    color:#111827;
    transition:.3s;
}

.newsletter-group button:hover{
    background:#ffffff;
}

.footer-contact-item{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:14px;
    color:#cbd5e1;
    font-size:.95rem;
}

.footer-contact-item i{
    color:#f59e0b;
}

.footer-bottom{
    border-top:1px solid rgba(255,255,255,.08);
    padding:24px 0;
}

.copyright-text,
.developer-text{
    color:#94a3b8;
    font-size:.92rem;
}

.developer-text a{
    color:#f59e0b;
    text-decoration:none;
    font-weight:600;
}

.developer-text a:hover{
    color:#ffffff;
}

@media(max-width:991px){

    .footer-main{
        text-align:center;
    }

    .footer-description{
        margin:auto;
    }

    .footer-socials{
        justify-content:center;
    }

    .footer-title::after{
        left:50%;
        transform:translateX(-50%);
    }

    .footer-contact-item{
        justify-content:center;
    }

}

</style>