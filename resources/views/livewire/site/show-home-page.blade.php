<div>
    {{--    @push('custom-styles') --}}
    {{--    <link href={{asset("assets/css/style.css")}} rel="stylesheet"> --}}
    {{--    @endpush --}}
    {{--     --}}

    <main id="main">

        <!-- ======= Hero Section ======= -->
        @if ($home_intro->getFirstMedia('home_intro_images') ?? '00' != '00')
            <section id="hero"
                style="background-image:url('{{ $home_intro->getFirstMedia('home_intro_images')->getUrl() ?? '' }}')"
                class="d-flex flex-column justify-content-center align-items-center">
                <div class="container" data-aos="fade-in">
                    <h1>Welcome to <span style="color: #b25e1d">BiLTA</span></h1>
                    <h2 id="bilta-intro-text" class="text-justify">Called to empower our people to translate <br>
                        the word of God into their own languages.</h2>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bx bxs-bible get-started-icon"></i>
                        <a href="#" class="btn-get-started scrollto" data-bs-toggle="modal"
                            data-bs-target="#audioModal">Play Audio Bible</a>
                    </div>
                </div>
            </section>
        @else
            <section id="hero" style="background: url( {{ asset('assets/img/biblee017c8414_1920.png') }} )"
                class="d-flex flex-column justify-content-center align-items-center">
                <div class="container" data-aos="fade-in">
                    <h1>Welcome to BiLTA</h1>
                    <h2 id="bilta-intro-text" class="text-justify">Called to empower our people to translate <br>
                        the word of God into their own languages.</h2>
                    <div class="d-flex align-items-center">
                        <i class="bx bxs-bible get-started-icon"></i>
                        <a href="#" class="btn-get-started scrollto" data-bs-toggle="modal"
                            data-bs-target="#audioModal">Play Audio Bible</a>
                    </div>
                </div>
            </section>
        @endif

        <!-- Audio Modal -->
        <div wire:ignore.self class="modal fade" id="audioModal" tabindex="-1" aria-labelledby="audioModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="audioModalLabel">Select an Audio File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <input type="text" class="form-control mb-3" placeholder="Search audio files..."
                                wire:model="search" wire:loading.attr="disabled">

                            <div wire:loading class="text-primary mb-2">
                                Loading audio files...
                            </div>

                            <ul class="list-group">
                                @forelse ($audioFiles as $audio)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $audio->title }}</strong><br>
                                            <small>Project| {{ $audio->project->myCategory->name ?? '' }} :
                                                {{ $audio->project->title ?? '' }}</small>
                                        </div>
                                        <div>
                                            @if ($audio && $audio->getFirstMediaUrl('audio_files'))
                                                <audio controls aria-label="Play audio">
                                                    <source src="{{ $audio->getFirstMediaUrl('audio_files') }}"
                                                        type="audio/mpeg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            @else
                                                <p class="text-muted mb-0">No audio file available.</p>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center text-muted">
                                        No audio files found.
                                    </li>
                                @endforelse
                            </ul>

                            <div class="mt-3">
                                {{ $audioFiles->links() }}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>



       


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

                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Why Us Section -->


         <!-- ======= Chairman's Message Section ======= -->
         <section id="chairman-message" class="about">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Chairperson's Message</h2>
                </div>
                <div class="row content">
                    <div class="col-lg-4 text-center" data-aos="fade-right">
                        @if ($chairman && $chairman->getFirstMediaUrl('chairman_photo'))
                        <img loading="lazy" 
                        src="{{ $chairman->getFirstMediaUrl('chairman_photo') }}"
                        class="img-fluid rounded mb-3"
                        style="width: 300px; height: 300px; object-fit: cover;"
                        alt="{{ $chairman->name ?? 'Chairperson' }}">
                        @endif
                        <h4>{{ $chairman->name ?? 'Chairperson' }}</h4>
                        <p><em>{{ $chairman->title ?? '' }}</em></p>
                    </div>
                    <div class="col-lg-8 pt-4 pt-lg-0" data-aos="fade-left">
                        <div style="font-family: 'Open Sans', sans-serif; font-size: 18px; line-height: 1.8; color: #333;">
                            {!! $chairman->message ?? '<p>No message provided yet.</p>' !!}
                        </div>
                    </div>
                    {{-- <div class="col-lg-8 pt-4 pt-lg-0" data-aos="fade-left">
                        <div style="font-family: 'Times New Roman', serif; font-size: 16px; line-height: 1.6; color: #000;">
                            {!! $chairman->message ?? '<p>No message provided yet.</p>' !!}
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
        <!-- End Chairman's Message Section -->



        <!-- ======= About Section ======= -->
        <section id="translation-projects" class="about section-bg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 d-flex justify-content-center align-items-stretch position-relative"
                        data-aos="fade-right">
                        <img loading="lazy" src="assets/img/project-translation.jpg" class="img-fluid" alt="">
                    </div>

                    <div
                        class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
                        {{-- <h4 data-aos="fade-up">Translation Projects</h4> --}}
                        <h3 data-aos="fade-up">Translation Projects</h3>
                        <p data-aos="fade-up">Providng you with initiatives and activities related to translating
                            religious texts,
                            scriptures, or other spiritual materials.</p>

                        <div class="icon-box" data-aos="fade-up">
                            <div class="icon"><i class="bi bi-journal-text"></i></div>
                            <h4 class="title"><a href="">Bible Translation</a></h4>
                            <p class="description">We support and engage in Bible translation projects, working to
                                translate
                                the Bible into languages that currently do not have access to a complete translation.
                            </p>
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
                                spiritual growth, providing accessible materials that align with their cultural and
                                linguistic context.</p>
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

                        @foreach ($testimonials as $testimonial)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <img loading="lazy" src="assets/img/testimonials/testimonies.jpg"
                                        class="testimonial-img" alt="">
                                    <h3>{{ $testimonial->name ?? '--' }}</h3>
                                    <h4> {{ $testimonial->title ?? '--' }} </h4>
                                    <p>
                                        <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                        {{ $testimonial->testimonial ?? '--' }}
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
                    <p data-aos="fade-up">"Welcome to our team! At BiLTA, we are proud to have a diverse and talented
                        group of individuals working together to achieve our goals.<br> Our team is made up of
                        passionate professionals who bring a wealth of experience and expertise to the table.</p>
                </div>

                <div class="row">
                    @foreach ($our_teams as $our_team)
                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                            <div class="member">
                                <div class="member-img">
                                    <img loading="lazy" class="img-fluid"
                                        src="{{ $our_team->getFirstMedia('team_images')->getUrl() }}"
                                        style="height: 350px; width: 100%; object-fit: cover;"
                                        title="{{ $our_team->getFirstMedia('team_images')->name }}">

                                    <div class="social">
                                        <a href=""><i class="bi bi-twitter"></i></a>
                                        <a href=""><i class="bi bi-facebook"></i></a>
                                        <a href=""><i class="bi bi-instagram"></i></a>
                                        <a href=""><i class="bi bi-linkedin"></i></a>
                                    </div>
                                </div>
                                <div class="member-info">
                                    <h4>{{ $our_team->name ?? '--' }}</h4>
                                    <span>{{ $our_team->position ?? '--' }}</span>
                                </div>
                                <div class="member-info">
                                    <div class="row">
                                        <div class="col-12">
                                            <!-- The checkbox used to toggle details -->
                                            <input type="checkbox" id="toggleDetails{{ $our_team->id }}"
                                                class="toggle-details" style="display: none;">
                                            <!-- Label for the 'More' button -->
                                            <label for="toggleDetails{{ $our_team->id }}"
                                                class="btn btn-sm btn-outline-secondary more-btn"></label>

                                            <!-- The details content that will be shown/hidden based on the checkbox -->
                                            <div class="details-content">
                                                {{ $our_team->details ?? '--' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section><!-- End Team Section -->

        <!-- Add this CSS for the toggle effect -->
        <style>
            /* Initially hide the details */
            .details-content {
                display: none;
            }

            /* When the checkbox is checked, show the details */
            .toggle-details:checked+label+.details-content {
                display: block;
            }

            /* Optional: Change the 'More' button text when the checkbox is checked */
            .toggle-details:checked+label::after {
                content: ' Less';
                /* Change button text to 'Less' when checked */
            }

            /* Change appearance of the label (button) */
            .more-btn::after {
                content: ' More';
                /* Button text */
            }
        </style>



        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">

                <div class="section-title">
                    <h2 data-aos="fade-up">Contact</h2>
                    <p data-aos="fade-up">We value open communication and are always eager to connect with our clients,
                        partners, and stakeholders. If you have any questions,<br>
                        inquiries, or would like to discuss a potential collaboration, our team is here to assist you.
                    </p>
                </div>

                <div class="row justify-content-center">

                    <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up">
                        <div class="info-box">
                            <i class="bx bx-map"></i>
                            <h3>Our Address</h3>
                            <p>{{ $contact_us->address ?? '--' }}</p>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="info-box">
                            <i class="bx bx-envelope"></i>
                            <h3>Email Us</h3>
                            <p>{{ $contact_us->email ?? 'info@bilta.org' }}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 mt-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="info-box">
                            <i class="bx bx-phone-call"></i>
                            <h3>Call Us</h3>
                            <p>{{ $contact_us->phone ?? '000-000-000' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="col-xl-9 col-lg-12 mt-4">
                        <form action="{{ route('contact.store') }}" method="post" role="form"
                            class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Your Name" required>
                                    <input type="text" name="website" style="display: none;">
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
                                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                            </div>
                            <div class="my-3">
                                <!-- Loading indicator -->
                                <div class="loading1" style="display: none;">Loading...</div>

                                <!-- Success message, hidden by default -->
                                <div class="sent-message1" style="color: green; display: none;"></div>

                                <!-- Error message, hidden by default -->
                                <div class="error-message1" style="color: red; display: none;"></div>
                            </div>

                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.php-email-form').on('submit', function(e) {
                e.preventDefault();

                // Show the loading indicator
                $('.loading1').show();

                $.ajax({
                    url: "{{ route('contact.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        // Hide the loading indicator
                        $('.loading1').hide();

                        // Show the success message and hide the error message
                        if (response.success) {
                            $('.sent-message1').text(response.success).show();
                            $('.error-message1').hide(); // Hide error message if successful
                        }
                    },
                    error: function(xhr, status, error) {
                        // Hide the loading indicator
                        $('.loading1').hide();

                        // Handle error response
                        let errorText = 'An unexpected error occurred. Please try again later.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Collect and display validation errors
                            let errors = xhr.responseJSON.errors;
                            errorText = "";
                            for (let key in errors) {
                                errorText += errors[key][0] +
                                "<br>"; // Display first error message for each field
                            }
                        } else if (xhr.responseJSON && xhr.responseJSON.error) {
                            // Display general error message
                            errorText = xhr.responseJSON.error;
                        }

                        // Show the error message and hide the success message
                        $('.error-message1').html(errorText).show();
                        $('.sent-message1').hide(); // Hide success message if there's an error
                    }
                });
            });
        });
    </script>



</div>
