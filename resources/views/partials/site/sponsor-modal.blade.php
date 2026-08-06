<div class="modal fade impact-modal" id="sponsorModal" tabindex="-1" aria-labelledby="sponsorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header" style="background: linear-gradient(135deg, #0f2742, #1a3a5c);">
                <div class="d-flex align-items-center gap-3">
                    <div class="modal-header-icon" style="background: rgba(255,255,255,.15);">
                        <i class="bi bi-building-fill-check"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="sponsorModalLabel">Partner With BiLTA</h5>
                        <p class="mb-0 mt-1" style="font-size:.88rem; opacity:.85;">Join us in bringing God's Word to every community</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                {{-- Sponsorship Tiers --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="sponsor-tier-card">
                            <div class="sponsor-tier-icon"><i class="bi bi-bookmark-star"></i></div>
                            <h6>Translation Partner</h6>
                            <p>Fund Bible translation in a specific language project</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sponsor-tier-card featured">
                            <div class="sponsor-tier-badge">Most Popular</div>
                            <div class="sponsor-tier-icon"><i class="bi bi-journal-richtext"></i></div>
                            <h6>Ministry Partner</h6>
                            <p>Support translation, literacy and scripture engagement</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sponsor-tier-card">
                            <div class="sponsor-tier-icon"><i class="bi bi-globe-americas"></i></div>
                            <h6>Strategic Partner</h6>
                            <p>Provide comprehensive organizational support</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    {{-- Left: Why sponsor --}}
                    <div class="col-md-6">
                        <div class="summary-card h-100">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-lightning-charge-fill" style="color:#cd5b13; font-size:1.2rem;"></i>
                                <h6 class="mb-0">Why Partner With Us?</h6>
                            </div>
                            <ul class="summary-list">
                                <li>Direct impact on Bible translation projects</li>
                                <li>Fund literacy &amp; discipleship resources</li>
                                <li>Regular reporting on project progress</li>
                                <li>Join a global community of partners</li>
                                <li>Tax-deductible contributions</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Right: Contact --}}
                    <div class="col-md-6">
                        @php
                            $sponsorEmail = $contact_us->email ?? 'infor@bilta.org';
                            $sponsorPhone = $contact_us->phone ?? '000-000-000';
                        @endphp
                        <div class="summary-card h-100">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-chat-dots-fill" style="color:#cd5b13; font-size:1.1rem;"></i>
                                <h6 class="mb-0">Get In Touch</h6>
                            </div>

                            @if (session('sponsor_inquiry_success'))
                                <div class="alert alert-success py-2 px-3 mb-3" role="alert">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    {{ session('sponsor_inquiry_success') }}
                                </div>
                            @endif

                            <div class="sponsor-contact-item mb-2">
                                <div class="sponsor-contact-icon"><i class="bi bi-envelope-fill"></i></div>
                                <div>
                                    <small class="text-muted d-block">Email Us</small>
                                    <a href="mailto:{{ $sponsorEmail }}" style="color:#0f2742; font-weight:600;">{{ $sponsorEmail }}</a>
                                </div>
                            </div>

                            <div class="sponsor-contact-item mb-3">
                                <div class="sponsor-contact-icon"><i class="bi bi-telephone-fill"></i></div>
                                <div>
                                    <small class="text-muted d-block">Call Us</small>
                                    <a href="tel:{{ preg_replace('/[^0-9\+]/', '', $sponsorPhone) }}" style="color:#0f2742; font-weight:600;">{{ $sponsorPhone }}</a>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#sponsorInquiryModal">
                                    <i class="bi bi-send-fill me-2"></i>
                                    Send Partnership Inquiry
                                </button>
                                <button type="button" class="btn btn-outline-theme"
                                    onclick="window.location.href='{{ route('site.home') }}#contact';">
                                    <i class="bi bi-chat-left-text me-2"></i>
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

{{-- Sponsor Inquiry Sub-Modal --}}
<div class="modal fade impact-modal" id="sponsorInquiryModal" tabindex="-1" aria-labelledby="sponsorInquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,.2);">

            {{-- Header with decorative accent --}}
            <div class="modal-header" style="background: linear-gradient(135deg, #0f2742, #1a3a5c); padding: 24px 28px; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; border-radius: 50%; background: rgba(205,91,19,.15);"></div>
                <div style="position: absolute; bottom: -30px; right: 40px; width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,.05);"></div>
                <div class="d-flex align-items-center gap-3" style="position: relative; z-index: 2;">
                    <div style="width: 46px; height: 46px; border-radius: 14px; background: linear-gradient(135deg, #cd5b13, #e8732e); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(205,91,19,.35);">
                        <i class="bi bi-send-fill" style="color: #fff; font-size: 1.15rem;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="sponsorInquiryModalLabel" style="font-weight: 800; font-size: 1.15rem;">Partnership Inquiry</h5>
                        <p class="mb-0" style="font-size: .8rem; opacity: .75; color: #fff;">We'd love to hear from you</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: relative; z-index: 2;"></button>
            </div>

            <div class="modal-body" style="padding: 28px;">
                <form method="POST" action="{{ route('sponsor.inquiry.store') }}" id="sponsorInquiryForm">
                    @csrf

                    {{-- Honeypot --}}
                    <div style="position:absolute;left:-9999px;" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <input type="hidden" name="_form_loaded_at" value="{{ now()->timestamp }}">

                    {{-- Intro hint --}}
                    <div class="d-flex align-items-start gap-2 mb-4" style="background: linear-gradient(135deg, #fef9f5, #fff5ed); border: 1px solid #fde0c4; border-radius: 14px; padding: 14px 16px;">
                        <i class="bi bi-lightbulb-fill" style="color: #cd5b13; font-size: 1rem; margin-top: 1px; flex-shrink: 0;"></i>
                        <p class="mb-0" style="font-size: .84rem; color: #7c4a1e; line-height: 1.5;">
                            Fill out the form below and our partnerships team will respond within <strong>2 business days</strong>.
                        </p>
                    </div>

                    {{-- Name & Email row --}}
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="sponsor_name" style="font-weight: 700; font-size: .85rem; color: #334155; margin-bottom: 6px;">
                                <i class="bi bi-person-fill me-1" style="color: #94a3b8;"></i> Full Name
                            </label>
                            <div style="position: relative;">
                                <input type="text" id="sponsor_name" name="sponsor_name"
                                    class="form-control @error('sponsor_name') is-invalid @enderror"
                                    value="{{ old('sponsor_name') }}" placeholder="John Doe" required
                                    style="border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 12px 16px; font-size: .92rem; transition: all .2s ease;"
                                    onfocus="this.style.borderColor='#cd5b13'; this.style.boxShadow='0 0 0 3px rgba(205,91,19,.1)';"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                @error('sponsor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="sponsor_email" style="font-weight: 700; font-size: .85rem; color: #334155; margin-bottom: 6px;">
                                <i class="bi bi-envelope-fill me-1" style="color: #94a3b8;"></i> Email Address
                            </label>
                            <div style="position: relative;">
                                <input type="email" id="sponsor_email" name="sponsor_email"
                                    class="form-control @error('sponsor_email') is-invalid @enderror"
                                    value="{{ old('sponsor_email') }}" placeholder="you@example.com" required
                                    style="border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 12px 16px; font-size: .92rem; transition: all .2s ease;"
                                    onfocus="this.style.borderColor='#cd5b13'; this.style.boxShadow='0 0 0 3px rgba(205,91,19,.1)';"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                @error('sponsor_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sponsorship interest selector --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: 700; font-size: .85rem; color: #334155; margin-bottom: 6px;">
                            <i class="bi bi-bookmark-star-fill me-1" style="color: #94a3b8;"></i> Partnership Interest
                        </label>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $interests = [
                                    ['value' => 'Translation Partner', 'icon' => 'bi-bookmark-star', 'color' => '#2563eb'],
                                    ['value' => 'Ministry Partner', 'icon' => 'bi-journal-richtext', 'color' => '#cd5b13'],
                                    ['value' => 'Strategic Partner', 'icon' => 'bi-globe-americas', 'color' => '#059669'],
                                ];
                            @endphp
                            @foreach ($interests as $interest)
                                <label style="cursor: pointer;">
                                    <input type="radio" name="sponsor_interest" value="{{ $interest['value'] }}" class="d-none sponsor-interest-radio"
                                        {{ old('sponsor_interest') == $interest['value'] ? 'checked' : '' }}>
                                    <span class="sponsor-interest-chip d-inline-flex align-items-center gap-1"
                                          style="padding: 8px 16px; border-radius: 50px; border: 1.5px solid #e2e8f0; background: #fff; font-size: .82rem; font-weight: 600; color: #64748b; transition: all .2s ease;"
                                          data-color="{{ $interest['color'] }}">
                                        <i class="bi {{ $interest['icon'] }}" style="font-size: .85rem;"></i>
                                        {{ $interest['value'] }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Message --}}
                    <div class="mb-4">
                        <label class="form-label" for="sponsor_message" style="font-weight: 700; font-size: .85rem; color: #334155; margin-bottom: 6px;">
                            <i class="bi bi-chat-left-text-fill me-1" style="color: #94a3b8;"></i> Your Message
                        </label>
                        <textarea id="sponsor_message" name="sponsor_message"
                            class="form-control @error('sponsor_message') is-invalid @enderror"
                            rows="4" placeholder="Tell us about your partnership interest, your organisation, and how you'd like to partner with BiLTA..."
                            required
                            style="border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 12px 16px; font-size: .92rem; resize: vertical; transition: all .2s ease;"
                            onfocus="this.style.borderColor='#cd5b13'; this.style.boxShadow='0 0 0 3px rgba(205,91,19,.1)';"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">{{ old('sponsor_message') }}</textarea>
                        @error('sponsor_message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="d-flex justify-content-end mt-1">
                            <small style="color: #94a3b8; font-size: .75rem;" id="sponsorMsgCharCount">0 / 1000</small>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <hr style="border-color: #f1f5f9; margin: 0 0 16px;">

                    {{-- Actions --}}
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-1" style="color: #94a3b8; font-size: .78rem;">
                            <i class="bi bi-shield-lock-fill" style="font-size: .85rem;"></i>
                            <span>Secure & private</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-theme" data-bs-dismiss="modal" id="sponsorInquiryCancelBtn"
                                    style="border-radius: 12px; padding: 10px 20px; font-weight: 600; font-size: .88rem;">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-theme" id="sponsorInquirySubmitBtn"
                                    style="border-radius: 12px; padding: 10px 24px; font-weight: 700; font-size: .88rem; box-shadow: 0 4px 14px rgba(205,91,19,.25);">
                                <span class="spinner-border spinner-border-sm me-2 d-none" aria-hidden="true" id="sponsorInquirySubmitSpinner"></span>
                                <i class="bi bi-send-fill me-1" id="sponsorInquirySubmitIcon"></i>
                                <span id="sponsorInquirySubmitLabel">Send Inquiry</span>
                            </button>
                        </div>
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
        const sponsorInquirySubmitIcon = document.getElementById('sponsorInquirySubmitIcon');

        if (!sponsorInquiryForm || !sponsorInquirySubmitBtn || !sponsorInquirySubmitSpinner || !sponsorInquirySubmitLabel) {
            return;
        }

        sponsorInquiryForm.addEventListener('submit', function () {
            sponsorInquirySubmitBtn.disabled = true;
            if (sponsorInquiryCancelBtn) {
                sponsorInquiryCancelBtn.disabled = true;
            }
            sponsorInquirySubmitSpinner.classList.remove('d-none');
            if (sponsorInquirySubmitIcon) {
                sponsorInquirySubmitIcon.classList.add('d-none');
            }
            sponsorInquirySubmitLabel.textContent = 'Sending...';
        });

        // Interest chip selector
        document.querySelectorAll('.sponsor-interest-radio').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.querySelectorAll('.sponsor-interest-chip').forEach(function (chip) {
                    chip.style.borderColor = '#e2e8f0';
                    chip.style.background = '#fff';
                    chip.style.color = '#64748b';
                });
                if (radio.checked) {
                    var chip = radio.nextElementSibling;
                    var color = chip.getAttribute('data-color');
                    chip.style.borderColor = color;
                    chip.style.background = color + '0d';
                    chip.style.color = color;
                }
            });
            // Init checked state
            if (radio.checked) radio.dispatchEvent(new Event('change'));
        });

        // Character counter for message
        var msgField = document.getElementById('sponsor_message');
        var msgCount = document.getElementById('sponsorMsgCharCount');
        if (msgField && msgCount) {
            function updateCount() {
                var len = msgField.value.length;
                msgCount.textContent = len + ' / 1000';
                msgCount.style.color = len > 900 ? '#dc3545' : '#94a3b8';
            }
            msgField.addEventListener('input', updateCount);
            msgField.setAttribute('maxlength', '1000');
            updateCount();
        }
    });
</script>

