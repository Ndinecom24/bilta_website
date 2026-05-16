{{-- =========================================================
    GDPR / UK PECR COOKIE CONSENT BANNER
    Compliant with UK PECR, EU GDPR, and ICO guidelines
========================================================= --}}

{{-- Cookie Banner (bottom bar) --}}
<div id="cookieBanner" class="cookie-banner" role="dialog" aria-label="Cookie consent" aria-describedby="cookieBannerDesc" style="display:none;">
    <div class="container">
        <div class="cookie-banner-inner">
            <div class="cookie-banner-content">
                <div class="cookie-banner-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div>
                    <h6 class="cookie-banner-title" id="cookieBannerDesc">We value your privacy</h6>
                    <p class="cookie-banner-text">
                        We use cookies to enhance your browsing experience, analyse site traffic, and serve relevant content.
                        You can choose which cookies to accept below. For more information, see our
                        <a href="#" data-bs-toggle="modal" data-bs-target="#cookiePolicyModal" class="cookie-link">Cookie Policy</a>.
                    </p>
                </div>
            </div>
            <div class="cookie-banner-actions">
                <button type="button" class="btn cookie-btn-settings" id="cookieSettingsBtn">
                    <i class="bi bi-gear me-1"></i>
                    Manage Preferences
                </button>
                <button type="button" class="btn cookie-btn-reject" id="cookieRejectBtn">
                    Reject All
                </button>
                <button type="button" class="btn cookie-btn-accept" id="cookieAcceptBtn">
                    <i class="bi bi-check-lg me-1"></i>
                    Accept All
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Cookie Preferences Modal (granular control) --}}
<div class="modal fade" id="cookieSettingsModal" tabindex="-1" aria-labelledby="cookieSettingsLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content cookie-modal-content">

            <div class="cookie-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="cookie-modal-icon">
                        <i class="bi bi-sliders"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="cookieSettingsLabel">Cookie Preferences</h5>
                        <p class="mb-0 mt-1" style="font-size:.85rem; opacity:.8;">Choose which cookies you'd like to allow</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="cookie-modal-body">

                {{-- Essential Cookies (always on) --}}
                <div class="cookie-category">
                    <div class="cookie-category-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="cookie-cat-icon essential">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Essential Cookies</h6>
                                <small class="text-muted">Required for the website to function</small>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked disabled id="cookieEssential">
                            <label class="form-check-label" for="cookieEssential">
                                <span class="badge bg-secondary">Always On</span>
                            </label>
                        </div>
                    </div>
                    <div class="cookie-category-desc">
                        These cookies are necessary for core functionality such as security, session management, and accessibility. They cannot be disabled.
                        <div class="cookie-examples mt-2">
                            <span class="cookie-example-tag">Session ID</span>
                            <span class="cookie-example-tag">CSRF Token</span>
                            <span class="cookie-example-tag">Cookie Consent</span>
                        </div>
                    </div>
                </div>

                {{-- Analytics Cookies --}}
                <div class="cookie-category">
                    <div class="cookie-category-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="cookie-cat-icon analytics">
                                <i class="bi bi-bar-chart-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Analytics Cookies</h6>
                                <small class="text-muted">Help us understand how visitors use our site</small>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="cookieAnalytics">
                            <label class="form-check-label" for="cookieAnalytics"><span class="visually-hidden">Toggle analytics cookies</span></label>
                        </div>
                    </div>
                    <div class="cookie-category-desc">
                        We use analytics cookies to understand how visitors interact with our website. This helps us improve content and user experience. Data is collected anonymously.
                        <div class="cookie-examples mt-2">
                            <span class="cookie-example-tag">Google Analytics</span>
                            <span class="cookie-example-tag">Page Views</span>
                            <span class="cookie-example-tag">Traffic Source</span>
                        </div>
                    </div>
                </div>

                {{-- Marketing Cookies --}}
                <div class="cookie-category">
                    <div class="cookie-category-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="cookie-cat-icon marketing">
                                <i class="bi bi-megaphone-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Marketing Cookies</h6>
                                <small class="text-muted">Used for personalised messaging</small>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="cookieMarketing">
                            <label class="form-check-label" for="cookieMarketing"><span class="visually-hidden">Toggle marketing cookies</span></label>
                        </div>
                    </div>
                    <div class="cookie-category-desc">
                        These cookies help us show relevant content, share on social media, and measure the effectiveness of our outreach campaigns.
                        <div class="cookie-examples mt-2">
                            <span class="cookie-example-tag">Facebook Pixel</span>
                            <span class="cookie-example-tag">YouTube</span>
                            <span class="cookie-example-tag">Social Embeds</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="cookie-modal-footer">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <small class="text-muted me-auto">
                        <i class="bi bi-info-circle me-1"></i>
                        Your preferences are saved for 365 days
                    </small>
                    <button type="button" class="btn cookie-btn-reject" id="cookieModalRejectBtn">Reject All</button>
                    <button type="button" class="btn cookie-btn-save" id="cookieSaveBtn">
                        <i class="bi bi-check-lg me-1"></i>
                        Save My Preferences
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Cookie Policy Modal --}}
<div class="modal fade" id="cookiePolicyModal" tabindex="-1" aria-labelledby="cookiePolicyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content cookie-modal-content">

            <div class="cookie-modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="cookie-modal-icon">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <h5 class="modal-title mb-0" id="cookiePolicyLabel">Cookie Policy</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="cookie-modal-body" style="max-height:60vh; overflow-y:auto;">
                <h6>What Are Cookies?</h6>
                <p>Cookies are small text files stored on your device when you visit a website. They serve various purposes such as remembering your preferences, enabling core features, and helping us understand how visitors use our site.</p>

                <h6>How We Use Cookies</h6>
                <p><strong>Bible &amp; Literature Translation Association (BiLTA)</strong> uses cookies in accordance with the UK Privacy and Electronic Communications Regulations (PECR) and the EU General Data Protection Regulation (GDPR).</p>

                <h6>Types of Cookies We Use</h6>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th>Purpose</th>
                                <th>Duration</th>
                                <th>Required?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Essential</strong></td>
                                <td>Site functionality, security, session management</td>
                                <td>Session / 2 hrs</td>
                                <td>Yes</td>
                            </tr>
                            <tr>
                                <td><strong>Analytics</strong></td>
                                <td>Understanding visitor behaviour, page views, traffic sources</td>
                                <td>Up to 2 years</td>
                                <td>No</td>
                            </tr>
                            <tr>
                                <td><strong>Marketing</strong></td>
                                <td>Social media integration, campaign measurement</td>
                                <td>Up to 1 year</td>
                                <td>No</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h6>Your Rights</h6>
                <p>Under GDPR and UK data protection law, you have the right to:</p>
                <ul>
                    <li>Accept or reject non-essential cookies</li>
                    <li>Change your cookie preferences at any time</li>
                    <li>Request information about what data we collect</li>
                    <li>Have your data deleted upon request</li>
                </ul>

                <h6>Managing Cookies</h6>
                <p>You can change your cookie preferences at any time by clicking the cookie icon at the bottom of the page. You can also manage cookies through your browser settings.</p>

                <h6>Contact Us</h6>
                <p>If you have questions about our cookie practices, contact us at <a href="mailto:{{ $contact_us->email ?? 'infor@bilta.org' }}">{{ $contact_us->email ?? 'infor@bilta.org' }}</a>.</p>

                <p class="text-muted"><small>Last updated: {{ now()->format('F Y') }}</small></p>
            </div>

            <div class="cookie-modal-footer">
                <button type="button" class="btn cookie-btn-save" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Floating Cookie Settings Button (always visible after consent) --}}
<button type="button" class="cookie-floating-btn" id="cookieFloatingBtn" title="Cookie Preferences" aria-label="Manage cookie preferences" style="display:none;">
    <i class="bi bi-shield-lock"></i>
</button>

{{-- Cookie Consent JavaScript --}}
<script>
(function(){
    'use strict';

    var COOKIE_NAME      = 'bilta_cookie_consent';
    var COOKIE_DAYS       = 365;
    var API_ENDPOINT      = '/api/cookie-consent';
    var CSRF_TOKEN        = document.querySelector('meta[name="csrf-token"]');

    // ─── Cookie Helpers ───────────────────────────────────────────
    function setCookie(name, value, days){
        var d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = name + '=' + encodeURIComponent(JSON.stringify(value)) +
            ';expires=' + d.toUTCString() +
            ';path=/;SameSite=Lax;Secure';
    }

    function getCookie(name){
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if(match){
            try{ return JSON.parse(decodeURIComponent(match[2])); }
            catch(e){ return null; }
        }
        return null;
    }

    function deleteCookiesByPrefix(prefixes){
        document.cookie.split(';').forEach(function(c){
            var cookieName = c.split('=')[0].trim();
            prefixes.forEach(function(prefix){
                if(cookieName.indexOf(prefix) === 0){
                    document.cookie = cookieName + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/';
                    document.cookie = cookieName + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/;domain=' + window.location.hostname;
                }
            });
        });
    }

    // ─── DOM Elements ─────────────────────────────────────────────
    var banner       = document.getElementById('cookieBanner');
    var acceptBtn    = document.getElementById('cookieAcceptBtn');
    var rejectBtn    = document.getElementById('cookieRejectBtn');
    var settingsBtn  = document.getElementById('cookieSettingsBtn');
    var saveBtn      = document.getElementById('cookieSaveBtn');
    var modalReject  = document.getElementById('cookieModalRejectBtn');
    var floatingBtn  = document.getElementById('cookieFloatingBtn');
    var analyticsChk = document.getElementById('cookieAnalytics');
    var marketingChk = document.getElementById('cookieMarketing');
    var settingsModal;

    // ─── Apply Consent ────────────────────────────────────────────
    function applyConsent(consent){
        // Analytics: load Google Analytics if opted in
        if(consent.analytics){
            loadAnalytics();
        } else {
            deleteCookiesByPrefix(['_ga', '_gid', '_gat']);
        }

        // Marketing: enable/disable marketing scripts
        if(!consent.marketing){
            deleteCookiesByPrefix(['_fbp', '_fbc']);
        }
    }

    function loadAnalytics(){
        // Placeholder: add your GA4 measurement ID here
        // var GA_ID = 'G-XXXXXXXXXX';
        // if(document.getElementById('ga-script')) return;
        // var s = document.createElement('script');
        // s.id = 'ga-script';
        // s.async = true;
        // s.src = 'https://www.googletagmanager.com/gtag/js?id=' + GA_ID;
        // document.head.appendChild(s);
        // window.dataLayer = window.dataLayer || [];
        // function gtag(){ dataLayer.push(arguments); }
        // gtag('js', new Date());
        // gtag('config', GA_ID, { anonymize_ip: true });
    }

    // ─── Save Consent ─────────────────────────────────────────────
    function saveConsent(analytics, marketing){
        var consent = {
            essential: true,
            analytics: analytics,
            marketing: marketing,
            timestamp: new Date().toISOString()
        };

        setCookie(COOKIE_NAME, consent, COOKIE_DAYS);
        applyConsent(consent);

        // Send to server for audit trail
        if(CSRF_TOKEN){
            var xhr = new XMLHttpRequest();
            xhr.open('POST', API_ENDPOINT, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', CSRF_TOKEN.getAttribute('content'));
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.send(JSON.stringify({
                analytics: analytics,
                marketing: marketing
            }));
        }

        hideBanner();
        showFloatingBtn();
    }

    // ─── UI Functions ─────────────────────────────────────────────
    function showBanner(){
        if(banner) banner.style.display = 'block';
    }

    function hideBanner(){
        if(banner){
            banner.style.opacity = '0';
            banner.style.transform = 'translateY(100%)';
            setTimeout(function(){ banner.style.display = 'none'; }, 300);
        }
    }

    function showFloatingBtn(){
        if(floatingBtn) floatingBtn.style.display = 'flex';
    }

    function hideFloatingBtn(){
        if(floatingBtn) floatingBtn.style.display = 'none';
    }

    function openSettingsModal(){
        if(typeof bootstrap !== 'undefined'){
            if(!settingsModal){
                settingsModal = new bootstrap.Modal(document.getElementById('cookieSettingsModal'));
            }
            // Pre-fill from existing consent
            var existing = getCookie(COOKIE_NAME);
            if(existing){
                if(analyticsChk) analyticsChk.checked = existing.analytics || false;
                if(marketingChk) marketingChk.checked = existing.marketing || false;
            }
            settingsModal.show();
        }
    }

    function closeSettingsModal(){
        if(settingsModal) settingsModal.hide();
    }

    // ─── Event Listeners ──────────────────────────────────────────
    if(acceptBtn){
        acceptBtn.addEventListener('click', function(){
            saveConsent(true, true);
        });
    }

    if(rejectBtn){
        rejectBtn.addEventListener('click', function(){
            saveConsent(false, false);
        });
    }

    if(settingsBtn){
        settingsBtn.addEventListener('click', function(){
            openSettingsModal();
        });
    }

    if(saveBtn){
        saveBtn.addEventListener('click', function(){
            saveConsent(
                analyticsChk ? analyticsChk.checked : false,
                marketingChk ? marketingChk.checked : false
            );
            closeSettingsModal();
        });
    }

    if(modalReject){
        modalReject.addEventListener('click', function(){
            saveConsent(false, false);
            closeSettingsModal();
        });
    }

    if(floatingBtn){
        floatingBtn.addEventListener('click', function(){
            openSettingsModal();
        });
    }

    // ─── Init: Check Existing Consent ─────────────────────────────
    var existingConsent = getCookie(COOKIE_NAME);

    if(existingConsent && existingConsent.timestamp){
        // User has already given consent — apply and show floating btn
        applyConsent(existingConsent);
        showFloatingBtn();
    } else {
        // No consent yet — show the banner
        showBanner();
    }

})();
</script>
