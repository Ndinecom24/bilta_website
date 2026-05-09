<div class="site-shell py-5">
  <div class="container">
    <section class="page-hero">
      <h2 class="mb-2">Frequently Asked Questions</h2>
      <p class="lead mb-0">Clear answers to common questions about BiLTA’s mission, translation process, and community engagement.</p>
    </section>

    <section class="page-section">
      <div class="accordion" id="faqAccordion">
        @forelse($faqs as $key => $faq)
          <div class="accordion-item border-0 mb-3 site-card">
            <h2 class="accordion-header" id="faqHeading{{ $key }}">
              <button class="accordion-button {{ $key === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $key }}" aria-expanded="{{ $key === 0 ? 'true' : 'false' }}" aria-controls="faqCollapse{{ $key }}">
                {{ $faq->question ?? '' }}
              </button>
            </h2>
            <div id="faqCollapse{{ $key }}" class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}" aria-labelledby="faqHeading{{ $key }}" data-bs-parent="#faqAccordion">
              <div class="accordion-body">{!! $faq->answer ?? '' !!}</div>
            </div>
          </div>
        @empty
          <div class="site-empty">No FAQs available right now.</div>
        @endforelse
      </div>
    </section>
  </div>
</div>
