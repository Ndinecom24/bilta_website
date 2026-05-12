<div class="site-shell py-5">
  <div class="container">
    <section class="page-hero">
      <h1 class="mb-3">About BiLTA</h1>
      <p class="lead mb-0">
        We build language communities, train local translators, and make Scripture and essential literature accessible in heart languages.
      </p>
    </section>

    <section class="page-section mb-4">
      <h2 class="site-section-title">Who We Are</h2>
      <p class="site-section-subtitle">Bible and Literature Translation Association focused on sustainable translation impact.</p>

      <div class="row g-4">
        <div class="col-md-6">
          <div class="site-card"><div class="card-body"><h5>Vision</h5><p class="mb-0">{{ $about_us_details->vision ?? 'To make available the word of God and essential literature in local languages.' }}</p></div></div>
        </div>
        <div class="col-md-6">
          <div class="site-card"><div class="card-body"><h5>Mission</h5><p class="mb-0">{{ $about_us_details->mission ?? 'To build the capacity of local people to translate the Bible and essential literature into their heart languages.' }}</p></div></div>
        </div>
        <div class="col-md-6">
          <div class="site-card"><div class="card-body"><h5>Objective</h5><div class="mb-0">{!! $about_us_details->objective ?? '<ul class="mb-0"><li>Mobilise and build capacity of local people for Bible translation.</li><li>Promote use of local languages in disseminating the word of God.</li><li>Promote literacy and education through local language resources.</li></ul>' !!}</div></div></div>
        </div>
        <div class="col-md-6">
          <div class="site-card"><div class="card-body"><h5>Description</h5><p class="mb-0">{{ $about_us_details->description ?? 'BiLTA is a charitable organization empowering communities to translate the word of God and other literature into their languages.' }}</p></div></div>
        </div>
        <div class="col-md-6">
          <div class="site-card"><div class="card-body"><h5>What is BiLTA?</h5><p class="mb-0">{{ $about_us_details->what_is ?? 'BiLTA stands for Bible and Literature Translation Association and serves broader language groups.' }}</p></div></div>
        </div>
        <div class="col-md-6">
          <div class="site-card"><div class="card-body"><h5>Who We Are</h5><p class="mb-0">{{ $about_us_details->who_we_are ?? 'A dedicated translation association committed to advancing local-language access to Scripture and literature.' }}</p></div></div>
        </div>
      </div>
    </section>

    <section class="contact-section-modern" id="contact">
    <div class="container-fluid-custom">

        <!-- Section Heading -->
        <div class="section-heading text-center">
            <span class="section-badge">
                <i class="bi bi-geo-alt"></i>
                Get In Touch
            </span>

            <h2 class="section-title">
                Find Us & Contact
            </h2>

            <p class="section-subtitle">
                Reach out for partnerships, translation initiatives,
                literacy programs and community collaboration.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">

            <!-- Map & Address -->
            <div class="col-lg-5">
                <div class="contact-card-modern h-100 overflow-hidden">

                    <div class="map-wrapper">
                        <iframe
                            src="https://www.google.com/maps?q=Chelston,+Lusaka,+Zambia&output=embed"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="BiLTA Location Map">
                        </iframe>
                    </div>

                    <div class="contact-card-body">
                        <div class="contact-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>

                        <div>
                            <h5>Office Address</h5>

                            <p class="mb-0">
                                {!! nl2br(e($contact_us_details->address ?? 'Address not provided')) !!}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-lg-4">
                <div class="contact-card-modern h-100">

                    <div class="contact-card-header">
                        <h4>
                            <i class="bi bi-person-lines-fill"></i>
                            Contact Information
                        </h4>
                    </div>

                    <div class="contact-info-stack">

                        <!-- Phone -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>

                            <div>
                                <span class="info-label">Phone</span>

                                <p class="info-text">
                                    {{ $contact_us_details->phone ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-envelope-open-fill"></i>
                            </div>

                            <div>
                                <span class="info-label">Email Address</span>

                                <p class="info-text">
                                    <a href="mailto:{{ $contact_us_details->email ?? '#' }}">
                                        {{ $contact_us_details->email ?? 'Not available' }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-globe2"></i>
                            </div>

                            <div>
                                <span class="info-label">Website</span>

                                <p class="info-text">
                                    <a href="{{ $contact_us_details->website ?? '#' }}"
                                       target="_blank">
                                        Visit Website
                                    </a>
                                </p>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="social-wrapper">

                            <span class="info-label d-block mb-3">
                                Follow Us
                            </span>

                            <div class="social-links-modern">

                                <a href="{{ $contact_us_details->facebook_url ?? '#' }}"
                                   target="_blank"
                                   class="social-btn facebook"
                                   aria-label="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>

                                <a href="{{ $contact_us_details->linkedin_url ?? '#' }}"
                                   target="_blank"
                                   class="social-btn linkedin"
                                   aria-label="LinkedIn">
                                    <i class="bi bi-linkedin"></i>
                                </a>

                                <a href="{{ $contact_us_details->youtube ?? '#' }}"
                                   target="_blank"
                                   class="social-btn youtube"
                                   aria-label="YouTube">
                                    <i class="bi bi-youtube"></i>
                                </a>

                                <a href="{{ $contact_us_details->whatsapp_link ?? '#' }}"
                                   target="_blank"
                                   class="social-btn whatsapp"
                                   aria-label="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>

                                <a href="{{ $contact_us_details->website ?? '#' }}"
                                   target="_blank"
                                   class="social-btn website"
                                   aria-label="Website">
                                    <i class="bi bi-globe2"></i>
                                </a>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3">
                <div class="quick-links-card h-100">

                    <div class="quick-links-header">
                        <i class="bi bi-lightning-charge-fill"></i>
                        Quick Navigation
                    </div>

                    <ul class="quick-links-list">

                        <li>
                            <a href="{{ route('gallery') }}">
                                <span>
                                    <i class="bi bi-images"></i>
                                    View Gallery
                                </span>

                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('projects', '0') }}">
                                <span>
                                    <i class="bi bi-diagram-3"></i>
                                    Explore Projects
                                </span>

                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('site.home') }}#contact">
                                <span>
                                    <i class="bi bi-send"></i>
                                    Contact Form
                                </span>

                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>

                    </ul>

                    <div class="quick-links-footer">
                        <p>
                            Partner with us in transforming communities through
                            literacy, translation and outreach.
                        </p>

                        <a href="#"
                           class="btn-modern btn-primary-modern w-100">
                            Support Our Mission
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<style>
    .contact-section-modern {
        padding: 100px 0;
        position: relative;
        background:
            radial-gradient(circle at top left,
                rgba(205, 91, 19, 0.10),
                transparent 28%),
            linear-gradient(180deg, #efefff 0%, #fff 100%);
    }

    .section-heading {
        max-width: 760px;
        margin: 0 auto 70px;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 18px;
        background: rgba(205, 91, 19, 0.12);
        color: #cd5b13;
        border-radius: 999px;
        font-weight: 700;
        margin-bottom: 22px;
    }

    .section-title {
        font-size: clamp(2.3rem, 5vw, 4rem);
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 18px;
    }

    .section-subtitle {
        color: #6b7280;
        font-size: 18px;
        line-height: 1.8;
    }

    .contact-card-modern,
    .quick-links-card {
        background: rgba(255, 255, 255, 0.96);
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 18px 45px rgba(0,0,0,0.08);
        transition: all .35s ease;
    }

    .contact-card-modern:hover,
    .quick-links-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 60px rgba(0,0,0,0.12);
    }

    .map-wrapper {
        height: 340px;
        overflow: hidden;
    }

    .contact-card-body {
        padding: 28px;
        display: flex;
        gap: 18px;
        align-items: flex-start;
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        min-width: 60px;
        border-radius: 18px;
        background: linear-gradient(to left, #f59e0b, #cd5b13);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
    }

    .contact-card-body h5 {
        font-weight: 700;
        margin-bottom: 10px;
        color: #1f2937;
    }

    .contact-card-body p {
        color: #6b7280;
        line-height: 1.8;
    }

    .contact-card-header {
        padding: 28px 28px 0;
    }

    .contact-card-header h4 {
        font-weight: 800;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .contact-info-stack {
        padding: 28px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .info-item {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        padding-bottom: 22px;
        border-bottom: 1px solid #f1f1f1;
    }

    .info-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        background: rgba(205, 91, 19, 0.12);
        color: #cd5b13;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .info-label {
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        color: #9ca3af;
    }

    .info-text {
        margin: 6px 0 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .info-text a {
        color: #cd5b13;
        text-decoration: none;
    }

    .info-text a:hover {
        color: #a34810;
    }

    .social-wrapper {
        padding-top: 5px;
    }

    .social-links-modern {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .social-btn {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        transition: all .35s ease;
        text-decoration: none;
    }

    .social-btn:hover {
        transform: translateY(-4px) scale(1.05);
        color: white;
    }

    .facebook {
        background: #1877f2;
    }

    .twitter {
        background: #000000;
    }

    .linkedin {
        background: #0a66c2;
    }

    .youtube {
        background: #ff0000;
    }

    .whatsapp {
        background: #25d366;
    }

    .website {
        background: linear-gradient(to left, #f59e0b, #cd5b13);
    }

    .quick-links-header {
        padding: 28px;
        font-size: 20px;
        font-weight: 800;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #f3f4f6;
    }

    .quick-links-list {
        list-style: none;
        margin: 0;
        padding: 18px;
    }

    .quick-links-list li {
        margin-bottom: 12px;
    }

    .quick-links-list li a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 18px 20px;
        border-radius: 18px;
        background: #efefff;
        color: #1f2937;
        text-decoration: none;
        font-weight: 600;
        transition: all .3s ease;
    }

    .quick-links-list li a:hover {
        background: linear-gradient(to left, #f59e0b, #cd5b13);
        color: white;
        transform: translateX(5px);
    }

    .quick-links-footer {
        padding: 10px 28px 28px;
    }

    .quick-links-footer p {
        color: #6b7280;
        line-height: 1.7;
        margin-bottom: 22px;
    }

    @media (max-width: 991px) {
        .contact-section-modern {
            padding: 70px 0;
        }

        .section-heading {
            margin-bottom: 50px;
        }
    }

    @media (max-width: 768px) {
        .section-title {
            font-size: 2.3rem;
        }

        .contact-card-body,
        .contact-info-stack,
        .quick-links-header,
        .quick-links-footer {
            padding: 22px;
        }

        .map-wrapper {
            height: 280px;
        }
    }

    @media (max-width: 576px) {
        .contact-section-modern {
            padding: 40px 0;
        }

        .section-heading {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.7rem;
        }

        .section-subtitle {
            font-size: 15px;
        }

        .info-icon {
            width: 42px;
            height: 42px;
            font-size: 17px;
        }

        .social-btn {
            width: 42px;
            height: 42px;
            font-size: 16px;
        }

        .social-links-modern {
            justify-content: center;
        }

        .contact-card-body {
            flex-direction: column;
            gap: 12px;
            padding: 18px;
        }

        .contact-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
        }

        .map-wrapper {
            height: 200px;
        }

        .quick-links-list li a {
            padding: 14px 16px;
        }
    }
</style>
  </div>
</div>

