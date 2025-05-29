<div>
  <!-- ======= FAQ Section Redesigned ======= -->
  <section id="faq" class="faq section-bg py-5">
    <div class="container">

      <div class="section-title text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold">Frequently Asked Questions</h2>
        <p class="text-muted mx-auto" style="max-width: 700px;">
          Welcome to the FAQ page of the Bible and Literature Translation Association! Here, we provide clear answers to common questions about our organization and translation work. Reach out anytime for more info.
        </p>
      </div>

      <div class="faq-list">
        <ul class="list-unstyled">
          @foreach($faqs as $key => $faq)
          <li class="mb-3 shadow-sm rounded" data-aos="fade-up" data-aos-delay="{{$key}}00">
            <button class="faq-question d-flex justify-content-between align-items-center w-100 p-3 bg-white border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#faq-list-{{$key}}" aria-expanded="{{ $key === 0 ? 'true' : 'false' }}" aria-controls="faq-list-{{$key}}">
              <span class="fw-semibold">{{$faq->question ?? ""}}</span>
              <span class="faq-icon fs-4">+</span>
            </button>
            <div id="faq-list-{{$key}}" class="collapse {{ $key === 0 ? 'show' : '' }} bg-light p-3 rounded-bottom" data-bs-parent=".faq-list">
              <p class="mb-0 text-secondary">{!! $faq->answer ?? "" !!}</p>
            </div>
          </li>
          @endforeach
        </ul>
      </div>

    </div>
  </section>
</div>

<style>
  .faq-question {
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .faq-question:hover {
    background-color: #f0f8ff;
  }
  .faq-icon {
    transition: transform 0.3s ease;
    user-select: none;
  }
  .collapse.show + .faq-question .faq-icon,
  .faq-question[aria-expanded="true"] .faq-icon {
    transform: rotate(45deg);
  }
</style>

<script>
  // Toggle + / - sign on collapse show/hide
  document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
      const icon = button.querySelector('.faq-icon');
      const expanded = button.getAttribute('aria-expanded') === 'true';
      icon.textContent = expanded ? '+' : '−';
    });
  });
</script>
