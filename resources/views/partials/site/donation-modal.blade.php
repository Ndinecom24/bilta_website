<div class="modal fade impact-modal" id="donateModal" tabindex="-1" aria-labelledby="donateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="donateModalLabel">Support BiLTA With a Donation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-lg-5">
                        <div class="summary-card">
                            <h6>Your gift helps us:</h6>
                            <ul class="summary-list">
                                <li>Train local translators</li>
                                <li>Publish scripture resources</li>
                                <li>Expand audio Bible access</li>
                                <li>Strengthen language communities</li>
                            </ul>
                            <p class="mt-3 mb-0">Thank you for partnering with BiLTA mission work.</p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="summary-card">
                            <h6 class="mb-3">Secure Donation (PayPal)</h6>
                            <div id="paypal-container-WP56E5J4AML4W"></div>
                            <small id="paypal-loading-text" class="d-block text-muted">Loading secure donation option...</small>
                            <small id="paypal-error-text" class="d-none text-danger">PayPal did not load. You can still donate using the direct link below.</small>
                            <div class="mt-3">
                                <a
                                    class="btn btn-outline-theme"
                                    href="https://www.paypal.com/donate/?hosted_button_id=WP56E5J4AML4W"
                                    target="_blank"
                                    rel="noopener noreferrer">
                                    Open PayPal Donation Page
                                </a>
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
