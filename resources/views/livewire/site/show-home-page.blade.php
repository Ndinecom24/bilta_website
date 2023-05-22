<div>
    @push('custom-styles')
        <link href={{asset("assets/css/style.css")}} rel="stylesheet">
    @endpush
    <body>
    <main id="main">
        <!-- ======= Hero Section ======= -->
        @if( $home_intro->id ?? '00' != '00')
            <section id="hero"
                     style="background-image:url('{{ $home_intro->getFirstMedia('home_intro_images')->getUrl() ?? ""  }}')"
                     class="d-flex flex-column justify-content-center align-items-center">
                <div class="container" data-aos="fade-in">
                    <h1 >Welcome to <span style="color: #b25e1d" >BiLTA</span></h1>
                    <h2 id="bilta-intro-text" class="text-justify">A place where faith and literary
                        exploration<br>
                        intertwine to enrich our spiritual journeys.</h2>
                    <div class="d-flex align-items-center">
                        <i class="bx bxs-bible get-started-icon"></i>
                        <a href="" class="btn-get-started scrollto">Play Audio Bible</a>
                    </div>
                </div>
            </section><!-- End Hero -->
                @else
                    <section id="hero" style="background: url( {{asset('assets/img/hero-bg3.jpg')}}  )  "
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
                        </section><!-- End Hero -->
                        @endif

                    <!-- ======= Why Us Section ======= -->
                    <section id="why-us" class="why-us">
                        <div class="container">

                            <div class="row">
                                <div class="col-xl-12 col-lg-12" data-aos="fade-up">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-xl-8 col-lg-8" >
                                        <h3>{{$home_intro->name ?? "Bible and Literature Translation Association."}}</h3>
                                        <p>
                                        {{$home_intro->short_description ??  "  We hold the Scriptures in reverence, cherishing them as a divine
                                          gift that illuminates our path <br> and guides us in our spiritual journey."}}
                                      </p>
                                      <div class="text-center">
                                          <a href="#" class="more-btn"> More <i class="bx bx-chevron-right"></i></a>
                                      </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4" >
                                                <img style="  background-color: #ffffff ; "  src="{{asset('layout/images/bilta_logo_one.png')}}">
                                            </div>
                                        </div>
                                  </div>
                              </div>
                              {{--                     <div class="col-xl-8 col-lg-7 d-flex">--}}
                                {{--                      <div class="icon-boxes d-flex flex-column justify-content-center">--}}
                                {{--                        <div class="row">--}}
                                {{--                          <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">--}}
                                {{--                            <div class="icon-box mt-4 mt-xl-0">--}}
                                {{--                              <i class="bx bx-receipt"></i>--}}
                                {{--                              <h4>Corporis voluptates sit</h4>--}}
                                {{--                              <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>--}}
                                {{--                            </div>--}}
                                {{--                          </div>--}}
                                {{--                          <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">--}}
                                {{--                            <div class="icon-box mt-4 mt-xl-0">--}}
                                {{--                              <i class="bx bx-cube-alt"></i>--}}
                                {{--                              <h4>Ullamco laboris ladore pan</h4>--}}
                                {{--                              <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>--}}
                                {{--                            </div>--}}
                                {{--                          </div>--}}
                                {{--                          <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">--}}
                                {{--                            <div class="icon-box mt-4 mt-xl-0">--}}
                                {{--                              <i class="bx bx-images"></i>--}}
                                {{--                              <h4>Labore consequatur</h4>--}}
                                {{--                              <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>--}}
                                {{--                            </div>--}}
                                {{--                          </div>--}}
                                {{--                        </div>--}}
                                {{--                      </div>--}}
                                {{--                    </div>--}}
                            </div>

                        </div>
                    </section><!-- End Why Us Section -->

                    <!-- ======= About Section ======= -->
                    <section id="translation-projects" class="about section-bg">
                        <div class="container">

                            <div class="row">
                                <div
                                    class="col-xl-5 col-lg-6 d-flex justify-content-center align-items-stretch position-relative"
                                    data-aos="fade-right">
                                    <img src="assets/img/project-translation.jpg" class="img-fluid" alt="">
                                </div>

                                <div
                                    class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                                    {{-- <h4 data-aos="fade-up">Translation Projects</h4> --}}
                                    <h3 data-aos="fade-up">Translation Projects</h3>
                                    <p data-aos="fade-up">Providng you with initiatives and activities related to
                                        translating religious texts,
                                        scriptures, or other spiritual materials.</p>

                                    <div class="icon-box" data-aos="fade-up">
                                        <div class="icon"><i class="bi bi-journal-text"></i></div>
                                        <h4 class="title"><a href="">Bible Translation</a></h4>
                                        <p class="description">We support and engage in Bible translation projects,
                                            working to translate
                                            the Bible into languages that currently do not have access to a complete
                                            translation. </p>
                                    </div>

                                    <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                                        <div class="icon"><i class="bi bi-blockquote-right"></i></div>
                                        <h4 class="title"><a href="">Liturgical Texts</a></h4>
                                        <p class="description">We undertake the translation of liturgical texts, such as
                                            prayers,
                                            hymns, and worship resources.</p>
                                    </div>

                                    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                                        <div class="icon"><i class="bx bx-atom"></i></div>
                                        <h4 class="title"><a href="">Study Materials and Devotionals</a></h4>
                                        <p class="description">We develop translation projects to create study
                                            materials,
                                            devotionals, or discipleship resources. These resources can aid individuals
                                            in their
                                            spiritual growth, providing accessible materials that align with their
                                            cultural and linguistic context.</p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </section><!-- End About Section -->


                    <!-- ======= Values Section ======= -->
                    <section id="values" class="values">
                        <div class="container">
                            <div class="section-title">
                                <h2 data-aos="fade-up">Gallery</h2>
                                <p data-aos="fade-up">Magnam dolores commodi suscipit. Necessitatibus eius consequatur
                                    ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam
                                    cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis
                                    commodi quidem hic quas.</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                                    <div class="card" style="background-image: url(assets/img/values-1.jpg);">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title"><a href="">Our Mission</a></h5>
                                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor ut labore et dolore magna aliqua.</p>
                                            <div class="read-more"><a href="#"><i class="bi bi-arrow-right"></i> Read More</a></div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up"
                                     data-aos-delay="100">
                                    <div class="card" style="background-image: url(assets/img/values-2.jpg);">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title"><a href="">Our Plan</a></h5>
                                            <p class="card-text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem doloremque laudantium, totam rem.</p>
                                            <div class="read-more"><a href="#"><i class="bi bi-arrow-right"></i> Read More</a></div> --}}
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up"
                                     data-aos-delay="200">
                                    <div class="card" style="background-image: url(assets/img/values-3.jpg);">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title"><a href="">Our Vision</a></h5>
                                            <p class="card-text">Nemo enim ipsam voluptatem quia voluptas sit aut odit aut fugit, sed quia magni dolores.</p>
                                            <div class="read-more"><a href="#"><i class="bi bi-arrow-right"></i> Read More</a></div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-stretch mt-4" data-aos="fade-up"
                                     data-aos-delay="300">
                                    <div class="card" style="background-image: url(assets/img/values-4.jpg);">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title"><a href="">Our Care</a></h5>
                                            <p class="card-text">Nostrum eum sed et autem dolorum perspiciatis. Magni porro quisquam laudantium voluptatem.</p>
                                            <div class="read-more"><a href="#"><i class="bi bi-arrow-right"></i> Read More</a></div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section><!-- End Values Section -->

                    <!-- ======= Testimonials Section ======= -->
                    <section id="testimonials" class="testimonials">
                        <div class="container position-relative" data-aos="fade-up">

                            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <img src="assets/img/testimonials/testimonials-1.jpg"
                                                 class="testimonial-img" alt="">
                                            <h3>Saul Goodman</h3>
                                            <h4>Ceo &amp; Founder</h4>
                                            <p>
                                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                                Proin iaculis purus consequat sem cure digni ssim donec porttitora entum
                                                suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh
                                                et. Maecen aliquam, risus at semper.
                                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                            </p>
                                        </div>
                                    </div><!-- End testimonial item -->

                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <img src="assets/img/testimonials/testimonials-2.jpg"
                                                 class="testimonial-img" alt="">
                                            <h3>Sara Wilsson</h3>
                                            <h4>Designer</h4>
                                            <p>
                                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                                Export tempor illum tamen malis malis eram quae irure esse labore quem
                                                cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua
                                                noster fugiat irure amet legam anim culpa.
                                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                            </p>
                                        </div>
                                    </div><!-- End testimonial item -->

                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <img src="assets/img/testimonials/testimonials-3.jpg"
                                                 class="testimonial-img" alt="">
                                            <h3>Jena Karlis</h3>
                                            <h4>Store Owner</h4>
                                            <p>
                                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                                Enim nisi quem export duis labore cillum quae magna enim sint quorum
                                                nulla quem veniam duis minim tempor labore quem eram duis noster aute
                                                amet eram fore quis sint minim.
                                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                            </p>
                                        </div>
                                    </div><!-- End testimonial item -->

                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <img src="assets/img/testimonials/testimonials-4.jpg"
                                                 class="testimonial-img" alt="">
                                            <h3>Matt Brandon</h3>
                                            <h4>Freelancer</h4>
                                            <p>
                                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                                Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export
                                                minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna
                                                sunt elit fore quem dolore labore illum veniam.
                                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                            </p>
                                        </div>
                                    </div><!-- End testimonial item -->

                                    <div class="swiper-slide">
                                        <div class="testimonial-item">
                                            <img src="assets/img/testimonials/testimonials-5.jpg"
                                                 class="testimonial-img" alt="">
                                            <h3>John Larson</h3>
                                            <h4>Entrepreneur</h4>
                                            <p>
                                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                                Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam
                                                tempor noster veniam enim culpa labore duis sunt culpa nulla illum
                                                cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                            </p>
                                        </div>
                                    </div><!-- End testimonial item -->

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
                                <p data-aos="fade-up">Magnam dolores commodi suscipit. Necessitatibus eius consequatur
                                    ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam
                                    cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis
                                    commodi quidem hic quas.</p>
                            </div>

                            <div class="row">

                                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                                    <div class="member">
                                        <div class="member-img">
                                            <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                                            <div class="social">
                                                <a href=""><i class="bi bi-twitter"></i></a>
                                                <a href=""><i class="bi bi-facebook"></i></a>
                                                <a href=""><i class="bi bi-instagram"></i></a>
                                                <a href=""><i class="bi bi-linkedin"></i></a>
                                            </div>
                                        </div>
                                        <div class="member-info">
                                            <h4>Walter White</h4>
                                            <span>Chief Executive Officer</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                                     data-aos-delay="100">
                                    <div class="member">
                                        <div class="member-img">
                                            <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                                            <div class="social">
                                                <a href=""><i class="bi bi-twitter"></i></a>
                                                <a href=""><i class="bi bi-facebook"></i></a>
                                                <a href=""><i class="bi bi-instagram"></i></a>
                                                <a href=""><i class="bi bi-linkedin"></i></a>
                                            </div>
                                        </div>
                                        <div class="member-info">
                                            <h4>Sarah Jhonson</h4>
                                            <span>Product Manager</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                                     data-aos-delay="200">
                                    <div class="member">
                                        <div class="member-img">
                                            <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                                            <div class="social">
                                                <a href=""><i class="bi bi-twitter"></i></a>
                                                <a href=""><i class="bi bi-facebook"></i></a>
                                                <a href=""><i class="bi bi-instagram"></i></a>
                                                <a href=""><i class="bi bi-linkedin"></i></a>
                                            </div>
                                        </div>
                                        <div class="member-info">
                                            <h4>William Anderson</h4>
                                            <span>CTO</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                                     data-aos-delay="300">
                                    <div class="member">
                                        <div class="member-img">
                                            <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                                            <div class="social">
                                                <a href=""><i class="bi bi-twitter"></i></a>
                                                <a href=""><i class="bi bi-facebook"></i></a>
                                                <a href=""><i class="bi bi-instagram"></i></a>
                                                <a href=""><i class="bi bi-linkedin"></i></a>
                                            </div>
                                        </div>
                                        <div class="member-info">
                                            <h4>Amanda Jepson</h4>
                                            <span>Accountant</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </section><!-- End Team Section -->

                    <!-- ======= Pricing Section ======= -->
                    {{-- <section id="pricing" class="pricing">
                      <div class="container">

                        <div class="section-title">
                          <h2 data-aos="fade-up">Pricing</h2>
                          <p data-aos="fade-up">Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                        </div>

                        <div class="row">

                          <div class="col-lg-3 col-md-6" data-aos="fade-up">
                            <div class="box">
                              <h3>Free</h3>
                              <h4><sup>$</sup>0<span> / month</span></h4>
                              <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li class="na">Pharetra massa</li>
                                <li class="na">Massa ultricies mi</li>
                              </ul>
                              <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                              </div>
                            </div>
                          </div>

                          <div class="col-lg-3 col-md-6 mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="100">
                            <div class="box featured">
                              <h3>Business</h3>
                              <h4><sup>$</sup>19<span> / month</span></h4>
                              <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li>Pharetra massa</li>
                                <li class="na">Massa ultricies mi</li>
                              </ul>
                              <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                              </div>
                            </div>
                          </div>

                          <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
                            <div class="box">
                              <h3>Developer</h3>
                              <h4><sup>$</sup>29<span> / month</span></h4>
                              <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li>Pharetra massa</li>
                                <li>Massa ultricies mi</li>
                              </ul>
                              <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                              </div>
                            </div>
                          </div>

                          <div class="col-lg-3 col-md-6 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
                            <div class="box">
                              <span class="advanced">Advanced</span>
                              <h3>Ultimate</h3>
                              <h4><sup>$</sup>49<span> / month</span></h4>
                              <ul>
                                <li>Aida dere</li>
                                <li>Nec feugiat nisl</li>
                                <li>Nulla at volutpat dola</li>
                                <li>Pharetra massa</li>
                                <li>Massa ultricies mi</li>
                              </ul>
                              <div class="btn-wrap">
                                <a href="#" class="btn-buy">Buy Now</a>
                              </div>
                            </div>
                          </div>

                        </div>

                      </div>
                    </section><!-- End Pricing Section --> --}}


                    <!-- ======= Clients Section ======= -->

                    <section id="clients" class="clients">
                        <div class="text-center mb-3"><h2>Our Partners</h2></div>
                        <div class="container" data-aos="fade-up">

                            <div class="clients-slider swiper">
                                <div class="swiper-wrapper align-items-center">
                                    <div class="swiper-slide"><img src="assets/img/clients/client-1.png"
                                                                   class="img-fluid" alt=""></div>
                                    <div class="swiper-slide"><img src="assets/img/clients/client-2.png"
                                                                   class="img-fluid" alt=""></div>
                                    <div class="swiper-slide"><img src="assets/img/clients/client-3.png"
                                                                   class="img-fluid" alt=""></div>
                                    <div class="swiper-slide"><img src="assets/img/clients/client-4.png"
                                                                   class="img-fluid" alt=""></div>
                                    <div class="swiper-slide"><img src="assets/img/clients/client-5.png"
                                                                   class="img-fluid" alt=""></div>
                                    <div class="swiper-slide"><img src="assets/img/clients/client-6.png"
                                                                   class="img-fluid" alt=""></div>
                                    <div class="swiper-slide"><img src="assets/img/clients/client-7.png"
                                                                   class="img-fluid" alt=""></div>
                                    <div class="swiper-slide"><img src="assets/img/clients/client-8.png"
                                                                   class="img-fluid" alt=""></div>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>

                        </div>
                    </section><!-- End Clients Section -->

                    <!-- ======= F.A.Q Section ======= -->
                    <section id="faq" class="faq section-bg">
                        <div class="container">

                            <div class="section-title">
                                <h2 data-aos="fade-up">F.A.Q</h2>
                                <p data-aos="fade-up">Magnam dolores commodi suscipit. Necessitatibus eius consequatur
                                    ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam
                                    cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis
                                    commodi quidem hic quas.</p>
                            </div>

                            <div class="faq-list">
                                <ul>
                                    <li data-aos="fade-up">
                                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                                                                       class="collapse"
                                                                                       data-bs-target="#faq-list-1">Non
                                            consectetur a erat nam at lectus urna duis? <i
                                                class="bx bx-chevron-down icon-show"></i><i
                                                class="bx bx-chevron-up icon-close"></i></a>
                                        <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                                            <p>
                                                Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat
                                                lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla
                                                urna porttitor rhoncus dolor purus non.
                                            </p>
                                        </div>
                                    </li>

                                    <li data-aos="fade-up" data-aos-delay="100">
                                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                                                                       data-bs-target="#faq-list-2"
                                                                                       class="collapsed">Feugiat
                                            scelerisque varius morbi enim nunc? <i
                                                class="bx bx-chevron-down icon-show"></i><i
                                                class="bx bx-chevron-up icon-close"></i></a>
                                        <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                                            <p>
                                                Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi.
                                                Id interdum velit laoreet id donec ultrices. Fringilla phasellus
                                                faucibus scelerisque eleifend donec pretium. Est pellentesque elit
                                                ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa
                                                tincidunt dui.
                                            </p>
                                        </div>
                                    </li>

                                    <li data-aos="fade-up" data-aos-delay="200">
                                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                                                                       data-bs-target="#faq-list-3"
                                                                                       class="collapsed">Dolor sit amet
                                            consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i
                                                class="bx bx-chevron-up icon-close"></i></a>
                                        <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                                            <p>
                                                Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis
                                                orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam
                                                sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus
                                                urna duis convallis convallis tellus. Urna molestie at elementum eu
                                                facilisis sed odio morbi quis
                                            </p>
                                        </div>
                                    </li>

                                    <li data-aos="fade-up" data-aos-delay="300">
                                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                                                                       data-bs-target="#faq-list-4"
                                                                                       class="collapsed">Tempus quam
                                            pellentesque nec nam aliquam sem et tortor consequat? <i
                                                class="bx bx-chevron-down icon-show"></i><i
                                                class="bx bx-chevron-up icon-close"></i></a>
                                        <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                                            <p>
                                                Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim
                                                suspendisse in est ante in. Nunc vel risus commodo viverra maecenas
                                                accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida
                                                quis blandit turpis cursus in.
                                            </p>
                                        </div>
                                    </li>

                                    <li data-aos="fade-up" data-aos-delay="400">
                                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                                                                       data-bs-target="#faq-list-5"
                                                                                       class="collapsed">Tortor vitae
                                            purus faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor?
                                            <i class="bx bx-chevron-down icon-show"></i><i
                                                class="bx bx-chevron-up icon-close"></i></a>
                                        <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                                            <p>
                                                Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae
                                                ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi
                                                est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in
                                                metus vulputate eu scelerisque.
                                            </p>
                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </div>
                    </section><!-- End F.A.Q Section -->

                    <!-- ======= Contact Section ======= -->
                    <section id="contact" class="contact">
                        <div class="container">

                            <div class="section-title">
                                <h2 data-aos="fade-up">Contact</h2>
                                <p data-aos="fade-up">Magnam dolores commodi suscipit. Necessitatibus eius consequatur
                                    ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam
                                    cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis
                                    commodi quidem hic quas.</p>
                            </div>

                            <div class="row justify-content-center">

                                <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up">
                                    <div class="info-box">
                                        <i class="bx bx-map"></i>
                                        <h3>Our Address</h3>
                                        <p>A108 Adam Street, New York, NY 535022</p>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="100">
                                    <div class="info-box">
                                        <i class="bx bx-envelope"></i>
                                        <h3>Email Us</h3>
                                        <p>info@example.com<br>contact@example.com</p>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="200">
                                    <div class="info-box">
                                        <i class="bx bx-phone-call"></i>
                                        <h3>Call Us</h3>
                                        <p>+1 5589 55488 55<br>+1 6678 254445 41</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                                <div class="col-xl-9 col-lg-12 mt-4">
                                    <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <input type="text" name="name" class="form-control" id="name"
                                                       placeholder="Your Name" required>
                                            </div>
                                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                                <input type="email" class="form-control" name="email" id="email"
                                                       placeholder="Your Email" required>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <input type="text" class="form-control" name="subject" id="subject"
                                                   placeholder="Subject" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <textarea class="form-control" name="message" rows="5" placeholder="Message"
                                                      required></textarea>
                                        </div>
                                        <div class="my-3">
                                            <div class="loading">Loading</div>
                                            <div class="error-message"></div>
                                            <div class="sent-message">Your message has been sent. Thank you!</div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit">Send Message</button>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </section><!-- End Contact Section -->

    </main><!-- End #main -->


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @push('custom-scripts')

    @endpush
    </body>
</div>
