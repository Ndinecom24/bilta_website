<div>
    <!-- ======= Videos Section ======= -->
    <section id="videos" class="videos py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 data-aos="fade-up">Videos</h2>
                <p data-aos="fade-up">
                    Dive into a captivating collection of videos that showcase our organization's commitment to the
                    translation and dissemination of literary works, including the Bible, across diverse languages and cultures.
                </p>
            </div>

            <div class="row">
                @foreach ($video_items as $video)
                    @php
                        // Extract YouTube video ID from full URL
                        preg_match("/(?:youtube\.com\/(?:[^\/]+\/.+|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/\s]{11})/", $video->video_link, $matches);
                        $videoId = $matches[1] ?? null;
                    @endphp

                    @if ($videoId)
                        <div class="col-lg-6 col-md-12 mb-4" data-aos="fade-up">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $videoId }}"
                                        title="{{ $video->name }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $video->name }}</h5>
                                    <p class="card-text text-muted">{{ $video->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
</div>
