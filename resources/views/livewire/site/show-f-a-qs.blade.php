<div>
    {{-- In work, do what you enjoy. --}}
      <!-- ======= F.A.Q Section ======= -->
  <section id="faq" class="faq section-bg">
    <div class="container">

      <div class="section-title">
        <h2 data-aos="fade-up">F.A.Q</h2>
        <p data-aos="fade-up">Welcome to the FAQ page of the Bible and Literature Translation Association! Here, we have
            compiled a list of frequently asked questions to provide you with quick and informative answers about our
            organization and our work in translating and promoting
            literary texts. If you have any further inquiries, feel free to reach out to us directly.</p>
      </div>

      <div class="faq-list">
        <ul>
            @foreach($faqs as $key=>$faq)
                <li data-aos="fade-up" data-aos-delay="{{$key}}00">
                    <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-{{$key}}">
                        {{$faq->question ?? ""}}
                            <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i>
                      </a>
                    <div id="faq-list-{{$key}}" class="collapse @if($key === 0)show @endif" data-bs-parent=".faq-list">
                        <p>
                            {{$faq->answer ?? ""}}
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
      </div>

    </div>
  </section><!-- End F.A.Q Section -->

</div>
