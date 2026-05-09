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

    <section class="page-section">
      <h2 class="site-section-title">Find Us & Contact</h2>
      <p class="site-section-subtitle">Reach out for partnerships, translation initiatives, and community collaboration.</p>
      <div class="row g-4 align-items-stretch">
        <div class="col-lg-5">
          <div class="site-card h-100">
            <iframe
              src="https://www.google.com/maps?q=Chelston,+Lusaka,+Zambia&output=embed"
              width="100%"
              height="340"
              style="border:0; border-radius: 12px 12px 0 0;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="BiLTA Location Map"></iframe>
            <div class="card-body">
              <h6 class="mb-2">Address</h6>
              <p class="mb-0">{!! nl2br(e($contact_us_details->address ?? 'Address not provided')) !!}</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="site-card h-100"><div class="card-body site-stacked">
            <div><h6 class="mb-1">Phone</h6><p class="mb-0">{{ $contact_us_details->phone ?? 'N/A' }}</p></div>
            <div><h6 class="mb-1">Email</h6><p class="mb-0"><a href="mailto:{{ $contact_us_details->email ?? '#' }}">{{ $contact_us_details->email ?? 'Not available' }}</a></p></div>
            <div><h6 class="mb-1">Web & Social</h6><p class="mb-0"><a href="{{ $contact_us_details->website ?? '#' }}" target="_blank">Website</a> · <a href="{{ $contact_us_details->facebook_url ?? '#' }}" target="_blank">Facebook</a> · <a href="{{ $contact_us_details->twitter_url ?? '#' }}" target="_blank">Twitter</a> · <a href="{{ $contact_us_details->linkedin_url ?? '#' }}" target="_blank">LinkedIn</a></p></div>
          </div></div>
        </div>
        <div class="col-lg-3">
          <div class="site-sidebar h-100">
            <div class="sidebar-title">Quick Links</div>
            <ul class="site-list-clean">
              <li><a href="{{ route('gallery') }}">View Gallery</a></li>
              <li><a href="{{ route('projects', '0') }}">Explore Projects</a></li>
              <li><a href="{{ route('site.home') }}#contact">Contact Form</a></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

