<div class="modal fade impact-modal" id="sponsorModal" tabindex="-1" aria-labelledby="sponsorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sponsorModalLabel">Become a Sponsor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="summary-card">
                            <h6>Why sponsor BiLTA?</h6>
                            <ul class="summary-list">
                                <li>Support Bible translation impact</li>
                                <li>Fund literacy and discipleship resources</li>
                                <li>Partner in sustainable community mission</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @php
                            $sponsorEmail = $contact_us->email ?? 'infor@bilta.org';
                            $sponsorPhone = $contact_us->phone ?? '000-000-000';
                        @endphp
                        <div class="summary-card">
                            <h6>Start your partnership</h6>
                            @if (session('sponsor_inquiry_success'))
                                <div class="alert alert-success py-2 px-3 mb-3" role="alert">
                                    {{ session('sponsor_inquiry_success') }}
                                </div>
                            @endif
                            <p class="mb-2">
                                <strong>Email:</strong>
                                <a href="mailto:{{ $sponsorEmail }}">{{ $sponsorEmail }}</a>
                            </p>
                            <p class="mb-3">
                                <strong>Phone:</strong>
                                <a href="tel:{{ preg_replace('/[^0-9\+]/', '', $sponsorPhone) }}">{{ $sponsorPhone }}</a>
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#sponsorInquiryModal">
                                    Send Inquiry
                                </button>
                                <button type="button" class="btn btn-outline-theme"
                                    onclick="window.location.href='{{ route('site.home') }}#contact';">
                                    Open Contact Form
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade impact-modal" id="sponsorInquiryModal" tabindex="-1" aria-labelledby="sponsorInquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sponsorInquiryModalLabel">Sponsorship Inquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('sponsor.inquiry.store') }}" id="sponsorInquiryForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="sponsor_name">Name</label>
                        <input
                            type="text"
                            id="sponsor_name"
                            name="sponsor_name"
                            class="form-control @error('sponsor_name') is-invalid @enderror"
                            value="{{ old('sponsor_name') }}"
                            required>
                        @error('sponsor_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="sponsor_email">Email</label>
                        <input
                            type="email"
                            id="sponsor_email"
                            name="sponsor_email"
                            class="form-control @error('sponsor_email') is-invalid @enderror"
                            value="{{ old('sponsor_email') }}"
                            required>
                        @error('sponsor_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="sponsor_message">Message</label>
                        <textarea
                            id="sponsor_message"
                            name="sponsor_message"
                            class="form-control @error('sponsor_message') is-invalid @enderror"
                            rows="4"
                            required>{{ old('sponsor_message', 'Hello BiLTA Team, I would like to partner with BiLTA as a sponsor.') }}</textarea>
                        @error('sponsor_message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-theme" data-bs-dismiss="modal" id="sponsorInquiryCancelBtn">Cancel</button>
                        <button type="submit" class="btn btn-theme" id="sponsorInquirySubmitBtn">
                            <span class="spinner-border spinner-border-sm me-2 d-none" aria-hidden="true" id="sponsorInquirySubmitSpinner"></span>
                            <span id="sponsorInquirySubmitLabel">Submit Inquiry</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($errors->has('sponsor_name') || $errors->has('sponsor_email') || $errors->has('sponsor_message') || session('sponsor_inquiry_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inquiryModalElement = document.getElementById('sponsorInquiryModal');
            if (inquiryModalElement && typeof bootstrap !== 'undefined') {
                const inquiryModal = new bootstrap.Modal(inquiryModalElement);
                inquiryModal.show();
            }
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sponsorInquiryForm = document.getElementById('sponsorInquiryForm');
        const sponsorInquirySubmitBtn = document.getElementById('sponsorInquirySubmitBtn');
        const sponsorInquiryCancelBtn = document.getElementById('sponsorInquiryCancelBtn');
        const sponsorInquirySubmitSpinner = document.getElementById('sponsorInquirySubmitSpinner');
        const sponsorInquirySubmitLabel = document.getElementById('sponsorInquirySubmitLabel');

        if (!sponsorInquiryForm || !sponsorInquirySubmitBtn || !sponsorInquirySubmitSpinner || !sponsorInquirySubmitLabel) {
            return;
        }

        sponsorInquiryForm.addEventListener('submit', function () {
            sponsorInquirySubmitBtn.disabled = true;
            if (sponsorInquiryCancelBtn) {
                sponsorInquiryCancelBtn.disabled = true;
            }
            sponsorInquirySubmitSpinner.classList.remove('d-none');
            sponsorInquirySubmitLabel.textContent = 'Submitting...';
        });
    });
</script>

