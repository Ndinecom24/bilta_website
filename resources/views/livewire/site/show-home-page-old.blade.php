
@push('custom-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="style.css" />

@endpush

<div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->


    @if( $home_intro->id ?? '00' != '00')
    <div class="bgded overlay" style="background-image:url('{{ $home_intro->getFirstMedia('home_intro_images')->getUrl()  }}')">

        <div id="pageintro" class="hoc clear">

            <!-- ################################################################################################ -->
            <article>
                <h3 class="heading" style="color: #e79217">{{$home_intro->name ?? "Bible and Literature Translation Association."}}</h3>
                <p>{{$home_intro->short_description ??  "" }}</p>
            </article>
            <!-- ################################################################################################ -->
        </div>
    </div>
    @else
        <div class="bgded overlay" style="background-image:url('{{asset('layout/images/demo/backgrounds/01.png')}}')">

            <div id="pageintro" class="hoc clear">

                <!-- ################################################################################################ -->
                <article>
                    <h3 class="heading" style="color: #e79217">Bible and Literature Translation Association.</h3>
                    <p>In nibh nullam egestas velit laoreet nullam elementum ipsum pharetra suscipit leo augue pretium felis
                        nisl vitae ipsum curabitur quis libero.</p>
                    {{--                <footer><a class="btn" href="#">Audio Bible</a></footer>--}}
                </article>
                <!-- ################################################################################################ -->
            </div>
        </div>
    @endif


    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="wrapper row3">
        <main class="hoc container clear">
            <!-- main body -->
            <!-- ################################################################################################ -->
            <section id="introblocks">
                <ul class="nospace group btmspace-80 elements elements-four">
                    <li class="one_quarter">
                        <article><a href="#"><i class="fas fa-hand-rock"></i></a>
                            <h6 class="heading">Bible Translation</h6>
                            <p>Ac orci proin porttitor lacus eget mi pellentesque non.</p>
                        </article>
                    </li>
                    <li class="one_quarter">
                        <article><a href="#"><i class="fas fa-dove"></i></a>
                            <h6 class="heading">Literature Translation</h6>
                            <p>Sapien sed metus congue sodales vivamus scelerisque.</p>
                        </article>
                    </li>
                    <li class="one_quarter">
                        <article><a href="#"><i class="fas fa-history"></i></a>
                            <h6 class="heading">Audio Bible</h6>
                            <p>Et interdum vulputate purus nisl fringilla sapien quis.</p>
                        </article>
                    </li>
                    <li class="one_quarter">
                        <article><a href="#"><i class="fas fa-heartbeat"></i></a>
                            <h6 class="heading">Gospel Film</h6>
                            <p>Sollicitudin dui mauris dui nunc lorem tortor pharetra.</p>
                        </article>
                    </li>
                </ul>
            </section>
            <!-- ################################################################################################ -->
            <section class="group shout">
                @foreach($our_values as $key=>$values)
                <figure class="one_half @if( $key % 2 === 0) first @endif" >
                    <figcaption class="heading"><a href="#">{{$values->title}}</a></figcaption>
                </figure>
                @endforeach
            </section>
            <!-- ################################################################################################ -->
            <!-- / main body -->
            <div class="clear"></div>
        </main>
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="bgded overlay light"
         style="background-image:url('{{asset('layout/images/demo/backgrounds/01.png')}}');">
        <section id="services" class="hoc container clear">
            <!-- ################################################################################################ -->
            <div class="sectiontitle">
                <p class="nospace font-xs">Gallery</p>
                <h6 class="heading font-x2">Justo mauris tempus pharetra</h6>
            </div>
            <ul class="nospace group elements elements-three">
                <li class="one_third">
                    <article><a href="#"><i class="fas fa-hourglass-half"></i></a>
                        <h6 class="heading">Sociis natoque penatibus</h6>
                        <p>Interdum at congue semper purus nullam quis odio id justo accumsan ullamcorper maecenas vel
                            arcu nulla tincidunt elit ornare.</p>
                    </article>
                </li>
                <li class="one_third">
                    <article><a href="#"><i class="fas fa-paw"></i></a>
                        <h6 class="heading">Magnis parturient montes</h6>
                        <p>Urna proin venenatis eros viverra ultrices fringilla lectus urna consequat erat eget
                            scelerisque ligula felis nec neque nam.</p>
                    </article>
                </li>
                <li class="one_third">
                    <article><a href="#"><i class="fas fa-sliders-h"></i></a>
                        <h6 class="heading">Nascetur ridiculus aenean</h6>
                        <p>Vitae ipsum vitae velit porttitor aliquam in quam aliquam ullamcorper sem a auctor dapibus
                            nisi nunc vehicula nunc quis mattis.</p>
                    </article>
                </li>
                <li class="one_third">
                    <article><a href="#"><i class="fas fa-tty"></i></a>
                        <h6 class="heading">Ullamcorper neque phasellus</h6>
                        <p>Pede turpis at elit nunc at urna sed ligula vivamus vel erat at diam imperdiet pharetra
                            quisque justo turpis mattis ut vitae.</p>
                    </article>
                </li>
                <li class="one_third">
                    <article><a href="#"><i class="fas fa-table"></i></a>
                        <h6 class="heading">Aliquet lacus nulla erat</h6>
                        <p>Tortor aenean leo ipsum elementum non cursus eu interdum ut risus proin risus nibh viverra
                            eget lobortis feugiat egestas in nisl.</p>
                    </article>
                </li>
                <li class="one_third">
                    <article><a href="#"><i class="fas fa-hand-holding-usd"></i></a>
                        <h6 class="heading">Aliquam volutpat curabitur</h6>
                        <p>Fusce dignissim neque vitae justo aenean ac urna et leo posuere pretium nunc bibendum enim
                            quis imperdiet elementum dui dolor.</p>
                    </article>
                </li>
            </ul>
            <!-- ################################################################################################ -->
        </section>
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="wrapper gradient">
        <div class="hoc container clear">
            <!-- ################################################################################################ -->
            <div class="sectiontitle">
                <p class="nospace font-xs">Our Team</p>
                <h6 class="heading font-x2">Meet Our Executive Committee</h6>
            </div>
            <ul class="nospace group team">
                @foreach($our_teams as $key=>$our_team)
                <li class="one_third @if($key==0) first @endif">
                    <figure><a class="imgover" href="#">
                            <img  src="{{ $our_team->getFirstMedia('team_images')->getUrl()  }}"
                                                               title="{{ $our_team->getFirstMedia('team_images')->name }}"></a>
                        <figcaption><strong>{{$our_team->name ?? "--"}}</strong> <em>{{$our_team->position ?? "--"}}</em></figcaption>
                    </figure>
                </li>
                @endforeach
            </ul>
            <!-- ################################################################################################ -->
        </div>
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="wrapper coloured">
        <section id="testimonials" class="hoc container clear">
            <!-- ################################################################################################ -->
            <div class="sectiontitle">
                <p class="nospace font-xs">Testimonials</p>
                <h6 class="heading font-x2">Stories from around the world</h6>
            </div>

            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $key=>$testimonial)
                        <div class="swiper-slide card">
                        <article class="one_half  first ">
                            <figure class="clear"><img  src="https://tinypic.host/images/2022/12/19/img_avatar.png" alt="">
                                <figcaption>
                                    <h6 class="heading">{{$testimonial->name}}</h6>
                                    <em>{{$testimonial->title}}</em></figcaption>
                            </figure>
                            <blockquote>{{$testimonial->testimonial}}
                            </blockquote>
                        </article>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>

            <!-- ################################################################################################ -->
        </section>




    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="wrapper row3">
        <section id="testimonies" class="hoc container clear">
            <!-- ################################################################################################ -->
            <div class="sectiontitle">
                <p class="nospace font-xs">Latest News</p>
                <h6 class="heading font-x2">Imperdiet massa maecenas</h6>
            </div>
            <ul id="latest" class="nospace group">
                <li class="one_third first">
                    <article><a class="imgover" href="#"><img src="{{asset('layout/images/demo/348x261.png')}}" alt=""></a>
                        <ul class="nospace meta clear">
                            <li><i class="fas fa-user"></i> <a href="#">Admin</a></li>
                            <li><i class="fas fa-comments"></i> <a href="#">Comments (3)</a></li>
                        </ul>
                        <div class="excerpt">
                            <time datetime="2045-04-05T08:15+00:00">05 Apr 2045</time>
                            <p class="heading"><a href="#">Quam justo suscipit at blandit at blandit vitae tellus
                                    maecenas</a></p>
                        </div>
                    </article>
                </li>
                <li class="one_third">
                    <article><a class="imgover" href="#"><img src="{{asset('layout/images/demo/348x261.png')}}" alt=""></a>
                        <ul class="nospace meta clear">
                            <li><i class="fas fa-user"></i> <a href="#">Admin</a></li>
                            <li><i class="fas fa-comments"></i> <a href="#">Comments (6)</a></li>
                        </ul>
                        <div class="excerpt">
                            <time datetime="2045-04-04T08:15+00:00">04 Apr 2045</time>
                            <p class="heading"><a href="#">Commodo mauris a semper posuere sem arcu cursus felis non
                                    cursus</a></p>
                        </div>
                    </article>
                </li>
                <li class="one_third">
                    <article><a class="imgover" href="#"><img src="{{asset('layout/images/demo/348x261.png')}}" alt=""></a>
                        <ul class="nospace meta clear">
                            <li><i class="fas fa-user"></i> <a href="#">Admin</a></li>
                            <li><i class="fas fa-comments"></i> <a href="#">Comments (10)</a></li>
                        </ul>
                        <div class="excerpt">
                            <time datetime="2045-04-03T08:15+00:00">03 Apr 2045</time>
                            <p class="heading"><a href="#">Enim odio in odio suspendisse commodo suscipit nisi nam
                                    tellus</a></p>
                        </div>
                    </article>
                </li>
            </ul>
            <!-- ################################################################################################ -->
        </section>
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="wrapper row2">
        <section id="ctdetails" class="hoc container clear">
            <!-- ################################################################################################ -->
            <div class="sectiontitle">
                <p class="nospace font-xs">Contact Us</p>
                <h6 class="heading font-x2">We would love to hear from you</h6>
            </div>
            <figure class="one_half first">
                <ul class="nospace clear">
                    <li class="block clear"><a href="#"><i class="fas fa-phone"></i></a>
                        <span><strong>Give us a call:</strong> {{$contact_us->phone ?? "000-000-000"}}</span></li>
                    <li class="block clear"><a href="#"><i class="fas fa-envelope"></i></a> <span><strong>Send us a mail:</strong> {{$contact_us->email ?? "support@bilta.org"}}</span>
                    </li>
                    <li class="block clear"><a href="#"><i class="fas fa-map-marker-alt"></i></a> <span><strong>Come visit us:</strong> Directions to <a
                                href="#">our location</a></span></li>
                </ul>
            </figure>
            <article class="one_half">
                <h6 class="heading">Send us a message</h6>
                <p class="nospace btmspace-15">{{$contact_us->message ?? "Do you have any questions about our projects or our site in general? Do you have any comments or ideas you would like to share with us? or you would love to make a donation? Please feel free to send us a message."}} </p>
                <form action="#" method="post">
                    <fieldset>
                        <legend>Newsletter:</legend>
                        <input type="text" value="" placeholder="Name">
                        <input type="text" value="" placeholder="Email">
                        <button type="submit" value="submit">Submit</button>
                    </fieldset>
                </form>
            </article>
            <!-- ################################################################################################ -->
        </section>
    </div>

</div>

@push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <script>
        let swiper = new Swiper(".swiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                600: {
                    slidesPerView: 2,
                },
            },
        });
    </script>

@endpush

