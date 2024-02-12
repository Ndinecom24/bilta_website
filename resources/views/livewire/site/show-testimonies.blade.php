<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="section-title mt-4">
                    <h2 data-aos="fade-up">Testimonies</h2>
                    <p data-aos="fade-up">Our testimonies from around the society</p>
                </div>
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card m-2">
                        <div class="card-body text-center">
                            <h5>Inspiring Stories</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card m-2">
                        <div class="card-body text-center">
                            <h5>Personal Experiences</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card m-2">
                        <div class="card-body text-center">
                            <h5>Transformative Journeys</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card m-2">
                        <div class="card-body text-center">
                            <h5>Profound Impact</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card m-2">
                        <div class="card-body text-center">
                            <h5>Heartfelt Testimonials</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card m-2">
                        <div class="card-body text-center">
                            <h5>Life-Changing Moments</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card m-2">
                        <div class="card-body text-center">
                            <h5>Authentic Voices</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card m-2">
                        <div class="card-body text-center">
                            <h5>Powerful Narratives</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ======= Testimonials Section ======= -->
            <section id="testimonials" class="testimonials mt-5">
                <div class="container position-relative" data-aos="fade-up">

                    <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                        <div class="swiper-wrapper">


@foreach ($testimonies as $testimony)
    
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img src="assets/img/testimonials/testimonies.jpg" class="testimonial-img"
                                        alt="">
                                    <h3> {{ $testimony->name ?? "--" }}</h3>
                                    <h4>  {{ $testimony->title ?? "--" }}</h4>
                                    <p>
                                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                       {{ $testimony->description }}
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
        </div>
    </div>

</div>
