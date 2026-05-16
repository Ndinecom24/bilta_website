@php
    $headerImage = $newsletter->getFirstMedia('newsletter_header_images');
    $pdfs = $newsletter->getMedia('newsletter_pdfs');
    $hasPdfs = $pdfs->count() > 0;
@endphp

<div class="site-shell py-5">
    <div class="container">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol style="list-style: none; display: flex; align-items: center; gap: 8px; padding: 0; margin: 0; font-size: .88rem;">
                <li>
                    <a href="{{ route('newsletters') }}" style="color: #cd5b13; font-weight: 600; text-decoration: none;">
                        <i class="fas fa-newspaper me-1"></i> Newsletters
                    </a>
                </li>
                <li style="color: #94a3b8;"><i class="fas fa-chevron-right" style="font-size: .65rem;"></i></li>
                <li style="color: #64748b; font-weight: 500;">{{ Str::limit($newsletter->title, 50) }}</li>
            </ol>
        </nav>

        {{-- Hero Banner --}}
        @if ($headerImage)
            <div style="position: relative; border-radius: 22px; overflow: hidden; margin-bottom: 32px; box-shadow: 0 20px 50px rgba(0,0,0,.15);">
                <img src="{{ $headerImage->getUrl() }}"
                     alt="{{ $newsletter->title }}"
                     style="width: 100%; height: 340px; object-fit: cover; display: block;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(15,39,66,.85) 0%, rgba(15,39,66,.3) 50%, transparent 100%);"></div>
                <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 36px 40px; z-index: 2;">
                    <div class="d-flex align-items-center mb-2" style="gap: 12px;">
                        <span style="background: rgba(255,255,255,.18); backdrop-filter: blur(6px); color: #fff; padding: 5px 16px; border-radius: 50px; font-size: .78rem; font-weight: 700; letter-spacing: .3px;">
                            NEWSLETTER
                        </span>
                        <span style="color: rgba(255,255,255,.8); font-size: .85rem;">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($newsletter->publish_date)->format('F d, Y') }}
                        </span>
                    </div>
                    <h1 style="color: #fff; font-weight: 800; font-size: 2rem; line-height: 1.25; margin: 0; text-shadow: 0 2px 10px rgba(0,0,0,.2);">
                        {{ $newsletter->title }}
                    </h1>
                </div>
            </div>
        @else
            <section class="page-hero" style="position: relative; overflow: hidden;">
                <div style="position: relative; z-index: 2;">
                    <div class="d-flex align-items-center mb-2" style="gap: 12px;">
                        <span style="background: rgba(255,255,255,.18); color: #fff; padding: 5px 16px; border-radius: 50px; font-size: .78rem; font-weight: 700; letter-spacing: .3px;">
                            NEWSLETTER
                        </span>
                        <span style="color: rgba(255,255,255,.8); font-size: .85rem;">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($newsletter->publish_date)->format('F d, Y') }}
                        </span>
                    </div>
                    <h2 class="mb-0" style="font-weight: 800;">{{ $newsletter->title }}</h2>
                    @if ($newsletter->short_description)
                        <p class="lead mt-2 mb-0">{{ $newsletter->short_description }}</p>
                    @endif
                </div>
                <div style="position: absolute; top: -30px; right: -30px; width: 140px; height: 140px; border-radius: 50%; background: rgba(255,255,255,.06);"></div>
            </section>
        @endif

        <div class="row g-4">

            {{-- Main Content --}}
            <div class="col-lg-8">

                {{-- Newsletter Body --}}
                @if ($newsletter->content)
                    <div style="background: #fff; border-radius: 22px; border: 1px solid #e5e7eb; box-shadow: 0 12px 35px rgba(0,0,0,.06); overflow: hidden;">
                        <div style="padding: 36px 40px;">
                            <div style="line-height: 1.9; font-size: 1.05rem; color: #334155;">
                                {!! $newsletter->content !!}
                            </div>
                        </div>
                    </div>
                @endif

                {{-- PDF Attachments Section --}}
                @if ($hasPdfs)
                    <div style="background: #fff; border-radius: 22px; border: 1px solid #e5e7eb; box-shadow: 0 12px 35px rgba(0,0,0,.06); overflow: hidden; margin-top: 24px;">
                        <div style="padding: 28px 36px;">
                            <div class="d-flex align-items-center mb-3" style="gap: 12px;">
                                <div style="width: 42px; height: 42px; border-radius: 14px; background: linear-gradient(135deg, #fef2f2, #fee2e2); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-file-pdf" style="color: #dc3545; font-size: 1.1rem;"></i>
                                </div>
                                <div>
                                    <h5 style="margin: 0; font-weight: 700; color: #0f172a; font-size: 1.1rem;">
                                        PDF Downloads
                                    </h5>
                                    <small style="color: #64748b;">{{ $pdfs->count() }} file{{ $pdfs->count() > 1 ? 's' : '' }} available</small>
                                </div>
                            </div>

                            @foreach ($pdfs as $media)
                                <div class="d-flex align-items-center justify-content-between"
                                     style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 16px 20px; margin-bottom: 10px; transition: all .2s ease;"
                                     onmouseover="this.style.borderColor='#dc3545'; this.style.boxShadow='0 4px 16px rgba(220,53,69,.1)';"
                                     onmouseout="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';">
                                    <div class="d-flex align-items-center" style="gap: 14px; min-width: 0;">
                                        <div style="width: 44px; height: 44px; border-radius: 12px; background: #dc3545; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="fas fa-file-pdf" style="color: #fff; font-size: 1.1rem;"></i>
                                        </div>
                                        <div style="min-width: 0;">
                                            <div style="font-weight: 700; color: #0f172a; font-size: .92rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $media->name }}
                                            </div>
                                            <small style="color: #94a3b8;">
                                                {{ round($media->size / 1024) > 1024 ? round($media->size / 1048576, 1) . ' MB' : round($media->size / 1024) . ' KB' }}
                                                &bull; PDF Document
                                            </small>
                                        </div>
                                    </div>
                                    <div class="d-flex" style="gap: 8px; flex-shrink: 0;">
                                        <a href="{{ $media->getUrl() }}" target="_blank"
                                           style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 12px; background: #f1f5f9; color: #475569; text-decoration: none; transition: all .2s ease;"
                                           title="Open in new tab"
                                           onmouseover="this.style.background='#e2e8f0';"
                                           onmouseout="this.style.background='#f1f5f9';">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <a href="{{ $media->getUrl() }}" download
                                           class="news-btn"
                                           style="padding: 10px 20px; font-size: .85rem; border-radius: 12px;">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Quick Info Card --}}
                <div class="modern-sidebar">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <div class="sidebar-title">About This Issue</div>
                            <div class="sidebar-subtitle">Newsletter details</div>
                        </div>
                    </div>

                    <div class="category-list">
                        {{-- Publish Date --}}
                        <div class="category-item" style="cursor: default;">
                            <div class="category-content">
                                <div class="category-dot"></div>
                                <div>
                                    <small style="color: #94a3b8; font-weight: 600; font-size: .72rem; text-transform: uppercase; letter-spacing: .5px;">Published</small>
                                    <div class="category-name" style="font-size: .88rem;">
                                        {{ \Carbon\Carbon::parse($newsletter->publish_date)->format('F d, Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="category-count" style="background: #f0fdf4; border-color: #bbf7d0; color: #16a34a;">
                                <i class="fas fa-calendar-check" style="font-size: .75rem;"></i>
                            </div>
                        </div>

                        {{-- PDF Count --}}
                        @if ($hasPdfs)
                            <div class="category-item" style="cursor: default;">
                                <div class="category-content">
                                    <div class="category-dot" style="background: linear-gradient(to left, #dc3545, #b02a37);"></div>
                                    <div>
                                        <small style="color: #94a3b8; font-weight: 600; font-size: .72rem; text-transform: uppercase; letter-spacing: .5px;">Attachments</small>
                                        <div class="category-name" style="font-size: .88rem;">
                                            {{ $pdfs->count() }} PDF file{{ $pdfs->count() > 1 ? 's' : '' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="category-count" style="background: #fef2f2; border-color: #fecaca; color: #dc2626;">
                                    <i class="fas fa-file-pdf" style="font-size: .75rem;"></i>
                                </div>
                            </div>
                        @endif

                        {{-- Content Available --}}
                        @if ($newsletter->content)
                            <div class="category-item" style="cursor: default;">
                                <div class="category-content">
                                    <div class="category-dot" style="background: linear-gradient(to left, #3b82f6, #2563eb);"></div>
                                    <div>
                                        <small style="color: #94a3b8; font-weight: 600; font-size: .72rem; text-transform: uppercase; letter-spacing: .5px;">Content</small>
                                        <div class="category-name" style="font-size: .88rem;">
                                            Full article available
                                        </div>
                                    </div>
                                </div>
                                <div class="category-count" style="background: #eff6ff; border-color: #bfdbfe; color: #2563eb;">
                                    <i class="fas fa-check" style="font-size: .75rem;"></i>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Quick Download --}}
                    @if ($hasPdfs)
                        <div style="margin-top: 22px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
                            <a href="{{ $pdfs->first()->getUrl() }}" target="_blank" class="news-btn d-flex justify-content-center" style="width: 100%; padding: 14px; border-radius: 14px;">
                                <i class="fas fa-file-pdf me-2"></i> Open Latest PDF
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Share Card --}}
                <div style="background: #fff; border-radius: 22px; border: 1px solid #e5e7eb; padding: 24px; margin-top: 20px; box-shadow: 0 8px 25px rgba(0,0,0,.04);">
                    <h6 style="font-weight: 700; color: #0f172a; margin-bottom: 14px; font-size: .95rem;">
                        <i class="fas fa-share-alt me-2" style="color: #cd5b13;"></i> Share This Newsletter
                    </h6>
                    <div class="d-flex" style="gap: 10px;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                           target="_blank"
                           style="width: 44px; height: 44px; border-radius: 14px; background: #f0f4ff; display: flex; align-items: center; justify-content: center; color: #1877f2; font-size: 1.1rem; text-decoration: none; transition: all .2s ease;"
                           onmouseover="this.style.background='#1877f2'; this.style.color='#fff';"
                           onmouseout="this.style.background='#f0f4ff'; this.style.color='#1877f2';"
                           title="Share on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($newsletter->title) }}"
                           target="_blank"
                           style="width: 44px; height: 44px; border-radius: 14px; background: #f0f9ff; display: flex; align-items: center; justify-content: center; color: #1da1f2; font-size: 1.1rem; text-decoration: none; transition: all .2s ease;"
                           onmouseover="this.style.background='#1da1f2'; this.style.color='#fff';"
                           onmouseout="this.style.background='#f0f9ff'; this.style.color='#1da1f2';"
                           title="Share on Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($newsletter->title . ' - ' . request()->url()) }}"
                           target="_blank"
                           style="width: 44px; height: 44px; border-radius: 14px; background: #f0fdf4; display: flex; align-items: center; justify-content: center; color: #25d366; font-size: 1.1rem; text-decoration: none; transition: all .2s ease;"
                           onmouseover="this.style.background='#25d366'; this.style.color='#fff';"
                           onmouseout="this.style.background='#f0fdf4'; this.style.color='#25d366';"
                           title="Share on WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="mailto:?subject={{ urlencode($newsletter->title) }}&body={{ urlencode('Check out this newsletter: ' . request()->url()) }}"
                           style="width: 44px; height: 44px; border-radius: 14px; background: #fef3c7; display: flex; align-items: center; justify-content: center; color: #d97706; font-size: 1.1rem; text-decoration: none; transition: all .2s ease;"
                           onmouseover="this.style.background='#d97706'; this.style.color='#fff';"
                           onmouseout="this.style.background='#fef3c7'; this.style.color='#d97706';"
                           title="Share via Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>

                {{-- Back Link --}}
                <div style="margin-top: 20px;">
                    <a href="{{ route('newsletters') }}"
                       style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 24px; border-radius: 14px; background: #f8fafc; border: 1px solid #e2e8f0; color: #475569; font-weight: 600; font-size: .92rem; text-decoration: none; transition: all .2s ease;"
                       onmouseover="this.style.borderColor='#cd5b13'; this.style.color='#cd5b13'; this.style.background='#fff8f3';"
                       onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#475569'; this.style.background='#f8fafc';">
                        <i class="fas fa-arrow-left"></i>
                        Back to All Newsletters
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
