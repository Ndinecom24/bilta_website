<div class="site-shell py-5">
    <div class="container">

        {{-- Hero --}}
        <section class="page-hero">
            <h2 class="mb-2" style="font-weight: 800;">Newsletters</h2>
            <p class="lead mb-0" style="opacity: .88;">Stay informed with our latest updates, stories, and resources from BiLTA.</p>
        </section>

        {{-- Newsletter Grid --}}
        <section class="news-section">
            <div class="row g-4">
                @forelse ($newsletters as $item)
                    @php
                        $hasPdf = $item->getMedia('newsletter_pdfs')->count() > 0;
                        $headerImage = $item->getFirstMedia('newsletter_header_images');
                        $pdfCount = $item->getMedia('newsletter_pdfs')->count();
                        $publishDate = \Carbon\Carbon::parse($item->publish_date);
                    @endphp
                    <div class="col-md-6 col-xl-4" data-aos="fade-up">
                        <article style="background: #fff; border-radius: 16px; border: 1px solid #e8ecf1; overflow: hidden; height: 100%; display: flex; flex-direction: column; transition: box-shadow .25s ease, transform .25s ease;"
                                 onmouseover="this.style.boxShadow='0 8px 30px rgba(15,39,66,.1)'; this.style.transform='translateY(-3px)';"
                                 onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';">

                            {{-- Card Image --}}
                            @if ($headerImage)
                                <div style="position: relative; overflow: hidden;">
                                    <img src="{{ $headerImage->getUrl() }}"
                                         alt="{{ $item->title }}"
                                         style="width: 100%; height: 200px; object-fit: cover; display: block;">
                                </div>
                            @else
                                <div style="height: 200px; background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%); display: flex; align-items: center; justify-content: center;">
                                    <div style="text-align: center;">
                                        <i class="fas fa-newspaper" style="font-size: 2rem; color: #b0bec5;"></i>
                                        <div style="font-size: .75rem; color: #94a3b8; font-weight: 600; margin-top: 6px;">{{ $publishDate->format('M Y') }}</div>
                                    </div>
                                </div>
                            @endif

                            {{-- Card Body --}}
                            <div style="padding: 22px 24px 24px; display: flex; flex-direction: column; flex: 1;">

                                {{-- Date & PDF badge --}}
                                <div class="d-flex align-items-center flex-wrap mb-2" style="gap: 10px;">
                                    <span style="font-size: .78rem; color: #64748b; font-weight: 600;">
                                        <i class="fas fa-calendar-alt me-1" style="color: #94a3b8;"></i>
                                        {{ $publishDate->format('d M Y') }}
                                    </span>
                                    {{-- @if ($hasPdf)
                                        <span style="font-size: .72rem; font-weight: 700; color: #dc3545; background: #fef2f2; border: 1px solid #fecaca; padding: 2px 10px; border-radius: 50px; letter-spacing: .2px;">
                                            <i class="fas fa-file-pdf me-1"></i>PDF
                                        </span>
                                    @endif --}}
                                </div>

                                {{-- Title --}}
                                <h5 style="font-weight: 700; color: #0f172a; font-size: 1.05rem; line-height: 1.4; margin-bottom: 8px;">
                                    {{ $item->title }}
                                </h5>

                                {{-- Description --}}
                                @if ($item->short_description)
                                    <p style="font-size: .88rem; color: #64748b; line-height: 1.6; margin-bottom: 0;">
                                        {{ Str::limit(strip_tags($item->short_description), 110, '...') }}
                                    </p>
                                @endif

                                {{-- Action --}}
                                @if ($hasPdf)
                                    <div class="mt-auto pt-3">
                                        <a href="{{ $item->getFirstMedia('newsletter_pdfs')->getUrl() }}"
                                           target="_blank"
                                           style="display: inline-flex; align-items: center; gap: 8px; font-size: .85rem; font-weight: 600; color: #0f2742; text-decoration: none; padding: 9px 18px; border: 1.5px solid #d1d9e3; border-radius: 10px; transition: all .2s ease;"
                                           onmouseover="this.style.background='#0f2742'; this.style.color='#fff'; this.style.borderColor='#0f2742';"
                                           onmouseout="this.style.background='transparent'; this.style.color='#0f2742'; this.style.borderColor='#d1d9e3';">
                                            <i class="fas fa-download" style="font-size: .8rem;"></i>
                                            Read More
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div style="text-align: center; padding: 60px 20px; color: #94a3b8;">
                            <i class="fas fa-envelope-open-text" style="font-size: 2.5rem; margin-bottom: 16px; display: block; opacity: .5;"></i>
                            <h5 style="color: #475569; font-weight: 700;">No Newsletters Yet</h5>
                            <p style="max-width: 380px; margin: 0 auto; font-size: .92rem;">We haven't published any newsletters yet. Check back soon for updates.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($newsletters->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $newsletters->links() }}
                </div>
            @endif
        </section>
    </div>
</div>
