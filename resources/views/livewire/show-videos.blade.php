

<!-- ======= Values Section ======= -->
<section id="values" class="values">
    <div class="container">
      <div class="section-title">
        <h2 data-aos="fade-up">Videos</h2>

        <p data-aos="fade-up">  Here, we invite you to dive into a captivating collection of videos that showcase our organization's commitment to the <br> translation and
            dissemination of literary works, including the Bible, across diverse languages and cultures.</p>
      </p>
      </div>


              <div class="row">
                  @foreach( $video_items as $video)
                      <div class="col-md-6 col-sm-12 d-flex align-items-stretch" data-aos="fade-up">
                          <div class="card">
                      <a href="https://www.youtube.com/embed/{{$video->video_link}}" class="media-1 m-2" data-fancybox="gallery">

                          <iframe width="560" height="315"
                                  src="https://www.youtube.com/embed/{{$video->video_link}}" frameborder="0" allowfullscreen></iframe>

                          <div class="media-1-content">
                              <h2>{{$video->name}}</h2>
                              <span class="category">{{$video->description}}   </span>
                          </div>
                      </a>
                  </div>
                      </div>
                  @endforeach
              </div>


    </div>
  </section><!-- End Values Section -->
