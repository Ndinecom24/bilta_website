<div class="site-shell py-5">
    <div class="container">

        {{-- Hero --}}
        <section class="page-hero">
            <h2 class="mb-2" style="font-weight: 800;">Weekly Prayer Points</h2>
            <p class="lead mb-0" style="opacity: .88;">Stay aligned with our prayer focus and intercede for ongoing translation work.</p>
        </section>

        {{-- Prayer Points Grid --}}
        <section class="news-section">
            <div class="row g-4">
                @forelse ($dataset as $item)
                    @php
                        $bannerImage = $item->getFirstMedia('prayer_banner_images');
                        $attachments = $item->getMedia('prayer_attachments');
                        $hasAttachments = $attachments->count() > 0;
                        $publishDate = \Carbon\Carbon::parse($item->post_date);
                    @endphp
                    <div class="col-md-6 col-xl-4" data-aos="fade-up">
                        <article style="background: #fff; border-radius: 16px; border: 1px solid #e8ecf1; overflow: hidden; height: 100%; display: flex; flex-direction: column; transition: box-shadow .25s ease, transform .25s ease;"
                                 onmouseover="this.style.boxShadow='0 8px 30px rgba(15,39,66,.1)'; this.style.transform='translateY(-3px)';"
                                 onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';">

                            {{-- Card Image --}}
                            @if ($bannerImage)
                                <div style="position: relative; overflow: hidden;">
                                    <img src="{{ $bannerImage->getUrl() }}"
                                         alt="{{ $item->title }}"
                                         style="width: 100%; height: 200px; object-fit: cover; display: block;">
                                </div>
                            @else
                                <div style="height: 200px; background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%); display: flex; align-items: center; justify-content: center;">
                                    <div style="text-align: center;">
                                        <i class="fas fa-praying-hands" style="font-size: 2rem; color: #b0bec5;"></i>
                                        <div style="font-size: .75rem; color: #94a3b8; font-weight: 600; margin-top: 6px;">{{ $publishDate->format('M Y') }}</div>
                                    </div>
                                </div>
                            @endif

                            {{-- Card Body --}}
                            <div style="padding: 22px 24px 24px; display: flex; flex-direction: column; flex: 1;">

                                {{-- Date & Attachment badge --}}
                                <div class="d-flex align-items-center flex-wrap mb-2" style="gap: 10px;">
                                    <span style="font-size: .78rem; color: #64748b; font-weight: 600;">
                                        <i class="fas fa-calendar-alt me-1" style="color: #94a3b8;"></i>
                                        {{ $publishDate->format('d M Y') }}
                                    </span>
                                    @if ($hasAttachments)
                                        <span style="font-size: .72rem; font-weight: 700; color: #2563eb; background: #eff6ff; border: 1px solid #bfdbfe; padding: 2px 10px; border-radius: 50px; letter-spacing: .2px;">
                                            <i class="fas fa-paperclip me-1"></i>{{ $attachments->count() }} file{{ $attachments->count() > 1 ? 's' : '' }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Title --}}
                                <h5 style="font-weight: 700; color: #0f172a; font-size: 1.05rem; line-height: 1.4; margin-bottom: 8px;">
                                    {{ $item->title }}
                                </h5>

                                {{-- Details --}}
                                @if ($item->details)
                                    <p style="font-size: .88rem; color: #64748b; line-height: 1.6; margin-bottom: 6px;">
                                        {{ Str::limit(strip_tags($item->details), 110, '...') }}
                                    </p>
                                @endif

                                {{-- Scriptures --}}
                                @if ($item->scriptures)
                                    <div style="font-size: .82rem; color: #92400e; background: #fffbeb; border: 1px solid #fde68a; padding: 8px 14px; border-radius: 10px; margin-bottom: 0; font-style: italic;">
                                        <i class="fas fa-book-bible me-1" style="color: #d97706;"></i>
                                        {{ Str::limit($item->scriptures, 80, '...') }}
                                    </div>
                                @endif

                                {{-- Attachments --}}
                                @if ($hasAttachments)
                                    <div class="mt-auto pt-3 d-flex flex-wrap" style="gap: 8px;">
                                        @foreach ($attachments as $media)
                                            @php
                                                $isPdf = str_contains($media->mime_type, 'pdf');
                                            @endphp
                                            <a href="{{ $media->getUrl() }}"
                                               target="_blank"
                                               style="display: inline-flex; align-items: center; gap: 6px; font-size: .82rem; font-weight: 600; color: {{ $isPdf ? '#dc2626' : '#0f2742' }}; text-decoration: none; padding: 8px 14px; border: 1.5px solid {{ $isPdf ? '#fecaca' : '#d1d9e3' }}; border-radius: 10px; transition: all .2s ease;"
                                               onmouseover="this.style.background='{{ $isPdf ? '#fef2f2' : '#f0f4f8' }}';"
                                               onmouseout="this.style.background='transparent';">
                                                <i class="fas {{ $isPdf ? 'fa-file-pdf' : 'fa-image' }}" style="font-size: .8rem;"></i>
                                                {{ Str::limit($media->name, 18, '...') }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                            <i class="fas fa-praying-hands" style="font-size: 2.5rem; margin-bottom: 16px; display: block; opacity: .5;"></i>
                            <h5 style="color: #475569; font-weight: 700;">No Prayer Points Available</h5>
                            <p style="max-width: 380px; margin: 0 auto; font-size: .92rem;">There are currently no prayer points to display. Check back soon.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($dataset->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $dataset->links() }}
                </div>
            @endif
        </section>
    </div>
</div>
