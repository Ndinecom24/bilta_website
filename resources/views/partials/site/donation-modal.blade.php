<div class="modal fade impact-modal" id="donateModal" tabindex="-1" aria-labelledby="donateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            {{-- Header with gradient and icon --}}
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="modal-header-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="donateModalLabel">Make a Difference Today</h5>
                        <p class="mb-0 mt-1" style="font-size:.88rem; opacity:.85;">Your generosity transforms lives through God's Word</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                {{-- Impact Stats Row --}}
                <div class="row g-3 mb-4">
                    <div class="col-4">
                        <div class="impact-stat-card text-center">
                            <div class="impact-stat-icon"><i class="bi bi-translate"></i></div>
                            <div class="impact-stat-number">20+</div>
                            <div class="impact-stat-label">Languages</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="impact-stat-card text-center">
                            <div class="impact-stat-icon"><i class="bi bi-people-fill"></i></div>
                            <div class="impact-stat-number">1000s</div>
                            <div class="impact-stat-label">Lives Reached</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="impact-stat-card text-center">
                            <div class="impact-stat-icon"><i class="bi bi-book-half"></i></div>
                            <div class="impact-stat-number">50+</div>
                            <div class="impact-stat-label">Resources</div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    {{-- Left: Impact --}}
                    <div class="col-lg-5">
                        <div class="summary-card h-100">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-stars" style="color:#cd5b13; font-size:1.2rem;"></i>
                                <h6 class="mb-0">Your Gift Enables</h6>
                            </div>
                            <ul class="summary-list">
                                <li>Training of local Bible translators</li>
                                <li>Publishing scripture in local languages</li>
                                <li>Expanding audio Bible access</li>
                                <li>Strengthening language communities</li>
                                <li>Supporting literacy programs</li>
                            </ul>
                            <div class="impact-verse mt-3">
                                <i class="bi bi-quote" style="font-size:1.4rem; color:#cd5b13; opacity:.5;"></i>
                                <p class="mb-0 fst-italic" style="font-size:.88rem; color:#445658;">
                                    "How beautiful are the feet of those who bring good news!"
                                </p>
                                <small class="text-muted">— Romans 10:15</small>
                            </div>
                        </div>
                    </div>

                    {{-- Right: PayPal --}}
                    <div class="col-lg-7">
                        <div class="summary-card h-100">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-shield-lock-fill" style="color:#10b981; font-size:1.1rem;"></i>
                                <h6 class="mb-0">Secure Donation</h6>
                            </div>

                            <div class="paypal-wrapper">
                                <div id="paypal-container-WP56E5J4AML4W"></div>
                                <small id="paypal-loading-text" class="d-block text-muted mt-2">
                                    <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                    Loading secure payment options...
                                </small>
                                <small id="paypal-error-text" class="d-none text-danger mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    PayPal did not load. Please use the direct link below.
                                </small>
                            </div>

                            <div class="separator-or my-3">
                                <span>or</span>
                            </div>

                            <a class="btn btn-donate-direct w-100"
                                href="https://www.paypal.com/donate/?hosted_button_id=WP56E5J4AML4W"
                                target="_blank"
                                rel="noopener noreferrer">
                                <i class="bi bi-box-arrow-up-right me-2"></i>
                                Donate via PayPal Directly
                            </a>

                            <div class="text-center mt-3">
                                <div class="d-flex align-items-center justify-content-center gap-2" style="font-size:.78rem; color:#94a3b8;">
                                    <i class="bi bi-lock-fill"></i>
                                    <span>256-bit SSL Encrypted &bull; Powered by PayPal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const donateModal = document.getElementById('donateModal');
        const paypalContainerSelector = '#paypal-container-WP56E5J4AML4W';
        const loadingText = document.getElementById('paypal-loading-text');
        const errorText = document.getElementById('paypal-error-text');
        const hostedButtonId = 'WP56E5J4AML4W';
        const sdkId = 'paypal-hosted-buttons-sdk';

        if (!donateModal) {
            return;
        }

        let isRendering = false;

        function markLoaded() {
            if (loadingText) {
                loadingText.classList.add('d-none');
            }
            if (errorText) {
                errorText.classList.add('d-none');
            }
        }

        function markFailed() {
            if (loadingText) {
                loadingText.classList.add('d-none');
            }
            if (errorText) {
                errorText.classList.remove('d-none');
            }
        }

        function renderHostedButton() {
            if (donateModal.dataset.paypalRendered === '1' || isRendering) {
                return;
            }

            if (!window.paypal || !window.paypal.HostedButtons) {
                markFailed();
                return;
            }

            isRendering = true;
            window.paypal.HostedButtons({
                hostedButtonId: hostedButtonId,
            }).render(paypalContainerSelector).then(function () {
                donateModal.dataset.paypalRendered = '1';
                isRendering = false;
                markLoaded();
            }).catch(function () {
                isRendering = false;
                markFailed();
            });
        }

        function loadPayPalSdkAndRender() {
            if (window.paypal && window.paypal.HostedButtons) {
                renderHostedButton();
                return;
            }

            let sdkScript = document.getElementById(sdkId);

            if (!sdkScript) {
                sdkScript = document.createElement('script');
                sdkScript.id = sdkId;
                sdkScript.src = 'https://www.paypal.com/sdk/js?client-id=BAANEWBe_GCODxYELBmUPu5L9O196AdBbBAl4T6aGF_-9XsMPzPXQ6t5j7sZZCE24hFJNYC4F6jy8DSv9Q&components=hosted-buttons&disable-funding=venmo&currency=USD';
                sdkScript.async = true;
                sdkScript.onload = renderHostedButton;
                sdkScript.onerror = markFailed;
                document.body.appendChild(sdkScript);
                return;
            }

            sdkScript.addEventListener('load', renderHostedButton, { once: true });
            sdkScript.addEventListener('error', markFailed, { once: true });
        }

        donateModal.addEventListener('shown.bs.modal', function () {
            if (loadingText && donateModal.dataset.paypalRendered !== '1') {
                loadingText.classList.remove('d-none');
            }
            loadPayPalSdkAndRender();
        });
    });
</script>
