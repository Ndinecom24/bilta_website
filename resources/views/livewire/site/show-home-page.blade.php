
<div>
{{--    @push('custom-styles')--}}
{{--    <link href={{asset("assets/css/style.css")}} rel="stylesheet">--}}
{{--    @endpush--}}
{{--     --}}

          <main id="main">

              <!-- ======= Hero Section ======= -->
              @if( $home_intro->getFirstMedia('home_intro_images') ?? '00' != '00')
                  <section id="hero"
                           style="background-image:url('{{ $home_intro->getFirstMedia('home_intro_images')->getUrl() ?? ""  }}')"
                           class="d-flex flex-column justify-content-center align-items-center">
                      <div class="container" data-aos="fade-in">
                          <h1 >Welcome to <span style="color: #b25e1d" >BiLTA</span></h1>
                          <h2 id="bilta-intro-text" class="text-justify">A place where faith and literary
                              exploration<br>
                              intertwine to enrich our spiritual journeys.</h2>
                          <div class="d-flex align-items-center mb-3">
                              <i class="bx bxs-bible get-started-icon"></i>
                              <a href="" class="btn-get-started scrollto">Play Audio Bible</a>
                          </div>
                      </div>
                  </section> <!-- End Hero -->
              @else
                  <section id="hero" style="background: url( {{asset('assets/img/biblee017c8414_1920.png')}}  )  "
                           class="d-flex flex-column justify-content-center align-items-center">
                      <div class="container" data-aos="fade-in">
                          <h1>Welcome to BiLTA</h1>
                          <h2 id="bilta-intro-text" class="text-justify">A place where faith and literary
                              exploration<br>
                              intertwine to enrich our spiritual journeys.</h2>
                          <div class="d-flex align-items-center">
                              <i class="bx bxs-bible get-started-icon"></i>
                              <a href="" class="btn-get-started scrollto">Play Audio Bible</a>
                          </div>
                      </div>
                  </section> <!-- End Hero -->
              @endif

           <!-- ======= Why Us Section ======= -->
            <section id="why-us" class="why-us">
              <div class="container">

                <div class="row">
                  <div class="col-xl-12 col-lg-12" data-aos="fade-up">
                    <div class="content">
                      <h3>Bible and Literature Translation Association.</h3>
                      <p>
                        We hold the Scriptures in reverence, cherishing them as a divine
                        gift that illuminates our path <br> and guides us in our spiritual journey.
                      </p>
                      {{-- <div class="text-center">
                        <a href="#" class="more-btn">Learn More <i class="bx bx-chevron-right"></i></a>
                      </div> --}}
                    </div>
                  </div>
                  {{-- <div class="col-xl-8 col-lg-7 d-flex">
                    <div class="icon-boxes d-flex flex-column justify-content-center">
                      <div class="row">
                        <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                          <div class="icon-box mt-4 mt-xl-0">
                            <i class="bx bx-receipt"></i>
                            <h4>Corporis voluptates sit</h4>
                            <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                          </div>
                        </div>
                        <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                          <div class="icon-box mt-4 mt-xl-0">
                            <i class="bx bx-cube-alt"></i>
                            <h4>Ullamco laboris ladore pan</h4>
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                          </div>
                        </div>
                        <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                          <div class="icon-box mt-4 mt-xl-0">
                            <i class="bx bx-images"></i>
                            <h4>Labore consequatur</h4>
                            <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> --}}
                </div>

              </div>
            </section><!-- End Why Us Section -->

            <!-- ======= About Section ======= -->
            <section id="translation-projects" class="about section-bg">
              <div class="container">

                <div class="row">
                  <div class="col-xl-5 col-lg-6 d-flex justify-content-center align-items-stretch position-relative" data-aos="fade-right">
                    <img src="assets/img/project-translation.jpg" class="img-fluid" alt="">
                  </div>

                  <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                    {{-- <h4 data-aos="fade-up">Translation Projects</h4> --}}
                    <h3 data-aos="fade-up">Translation Projects</h3>
                    <p data-aos="fade-up">Providng you with initiatives and activities related to translating religious texts,
                      scriptures, or other spiritual materials.</p>

                    <div class="icon-box" data-aos="fade-up">
                      <div class="icon"><i class="bi bi-journal-text"></i></div>
                      <h4 class="title"><a href="">Bible Translation</a></h4>
                      <p class="description">We support and engage in Bible translation projects, working to translate
                        the Bible into languages that currently do not have access to a complete translation. </p>
                    </div>

                    <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                      <div class="icon"><i class="bi bi-blockquote-right"></i></div>
                      <h4 class="title"><a href="">Liturgical Texts</a></h4>
                      <p class="description">We undertake the translation of liturgical texts, such as prayers,
                        hymns, and worship resources.</p>
                    </div>

                    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                      <div class="icon"><i class="bx bx-atom"></i></div>
                      <h4 class="title"><a href="">Study Materials and Devotionals</a></h4>
                      <p class="description">We develop translation projects to create study materials,
                        devotionals, or discipleship resources. These resources can aid individuals in their
                        spiritual growth, providing accessible materials that align with their cultural and linguistic context.</p>
                    </div>

                  </div>
                </div>

              </div>
            </section><!-- End About Section -->


            <!-- ======= Testimonials Section ======= -->
            <section id="testimonials" class="testimonials">
              <div class="container position-relative" data-aos="fade-up">

                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                  <div class="swiper-wrapper">

                      @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                      <div class="testimonial-item">
                        <img src="assets/img/testimonials/testimonies.jpg" class="testimonial-img" alt="">
                        <h3>{{$testimonial->name ?? "--" }}</h3>
                        <h4> {{$testimonial->title ?? "--" }} </h4>
                        <p>
                          <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                            {{$testimonial->testimonial ?? "--" }}
                          <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                        </p>
                      </div>
                    </div><!-- End testimonial item -->
                      @endforeach
                  </div>
                  <div class="swiper-pagination"></div>
                </div>

              </div>
            </section><!-- End Testimonials Section -->



            <!-- ======= Team Section ======= -->
            <section id="team" class="team section-bg">
              <div class="container">

                <div class="section-title">
                  <h2 data-aos="fade-up">Team</h2>
                  <p data-aos="fade-up">"Welcome to our team! At BiLTA, we are proud to have a diverse and talented group of individuals working together to
                     achieve our goals.<br> Our team is made up of passionate professionals who bring a wealth of experience and expertise to the table.</p>
                </div>

                <div class="row">
                    @foreach($our_teams as $our_team)
                  <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="member">
                      <div class="member-img">
                          <img class="img-fluid" src="{{ $our_team->getFirstMedia('team_images')->getUrl()  }}"
                                title="{{ $our_team->getFirstMedia('team_images')->name }}">

                          <div class="social">
                              <a href=""><i class="bi bi-twitter"></i></a>
                              <a href=""><i class="bi bi-facebook"></i></a>
                              <a href=""><i class="bi bi-instagram"></i></a>
                              <a href=""><i class="bi bi-linkedin"></i></a>
                          </div>
                      </div>
                      <div class="member-info">
                        <h4>{{$our_team->name ?? "--"}}</h4>
                        <span>{{$our_team->position ?? "--"}}</span>
                      </div>
                        <div class="member-info">
                            <div class="row">
                                <div class="col-12">
                                    {{$our_team->details ?? "--"}}
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                    @endforeach
                </div>

              </div>
            </section><!-- End Team Section -->


{{--            <!-- ======= Clients Section ======= -->--}}

{{--            <section id="clients" class="clients">--}}
{{--              <div class="text-center mb-3">--}}
{{--                <h2 data-aos="fade-up">Our Partners</h2>--}}
{{--            </div>--}}
{{--               <div class="container" data-aos="fade-up">--}}

{{--                 <div class="clients-slider swiper">--}}
{{--                   <div class="swiper-wrapper align-items-center">--}}
{{--                     <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid" alt=""></div>--}}
{{--                     <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>--}}
{{--                     <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>--}}
{{--                     <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>--}}
{{--                     <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>--}}
{{--                     <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>--}}
{{--                     <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>--}}
{{--                     <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div>--}}
{{--                   </div>--}}
{{--                   <div class="swiper-pagination"></div>--}}
{{--                 </div>--}}

{{--               </div>--}}
{{--             </section><!-- End Clients Section -->--}}


            <!-- ======= Contact Section ======= -->
            <section id="contact" class="contact">
              <div class="container">

                <div class="section-title">
                  <h2 data-aos="fade-up">Contact</h2>
                  <p data-aos="fade-up">We value open communication and are always eager to connect with our clients,
                    partners, and stakeholders. If you have any questions,<br>
                    inquiries, or would like to discuss a potential collaboration, our team is here to assist you.</p>
                </div>

                <div class="row justify-content-center">

                  <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up">
                    <div class="info-box">
                      <i class="bx bx-map"></i>
                      <h3>Our Address</h3>
                      <p>{{$contact_us->address ?? "--"}}</p>
                    </div>
                  </div>

                  <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="info-box">
                      <i class="bx bx-envelope"></i>
                      <h3>Email Us</h3>
                      <p>{{$contact_us->email ?? "info@bilta.org"}}</p>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="info-box">
                      <i class="bx bx-phone-call"></i>
                      <h3>Call Us</h3>
                      <p>{{$contact_us->phone ?? "000-000-000"}}</p>
                    </div>
                  </div>
                </div>

                <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                  <div class="col-xl-9 col-lg-12 mt-4">
                    <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                      <div class="row">
                        <div class="col-md-6 form-group">
                          <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                          <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                        </div>
                      </div>
                      <div class="form-group mt-3">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                      </div>
                      <div class="form-group mt-3">
                        <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                      </div>
                      <div class="my-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>
                      </div>
{{--                      <div class="text-center"><button type="submit">Send Message</button></div>--}}
                    </form>
                  </div>

                </div>

              </div>
            </section><!-- End Contact Section -->

          </main><!-- End #main -->

          <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  </div>
