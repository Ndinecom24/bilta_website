<div>

    {{-- PAGE HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-bullhorn text-primary mr-2"></i>Company Announcements
            </h1>
            <p class="mb-0 text-muted small">Stay updated with the latest company news and memos.</p>
        </div>
        @if ($unreadCount > 0)
            <span class="px-3 py-2 rounded-pill text-white font-weight-bold" style="background: linear-gradient(135deg, #e74a3b, #be2617); font-size: .85rem;">
                <i class="fas fa-bell mr-1"></i> {{ $unreadCount }} unread
            </span>
        @endif
    </div>

    {{-- Viewing Single Announcement --}}
    @if ($viewingAnnouncement)
        <div class="card shadow border-0 mb-4" style="border-radius: 16px; overflow: hidden;">
            <div class="card-header py-3" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border: none;">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-white font-weight-bold">{{ $viewingAnnouncement->title }}</h5>
                    <button wire:click="closeView" class="btn btn-sm btn-light rounded-pill px-3 font-weight-bold">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </button>
                </div>
            </div>
            <div class="card-body p-4">
                {{-- Meta --}}
                <div class="d-flex flex-wrap mb-3" style="gap: 12px;">
                    <span class="badge badge-{{ $viewingAnnouncement->type_badge }} px-2 py-1" style="border-radius: 6px;">
                        <i class="fas fa-{{ $viewingAnnouncement->type === 'memo' ? 'file-alt' : 'bullhorn' }} mr-1"></i>
                        {{ ucfirst($viewingAnnouncement->type) }}
                    </span>
                    <span class="badge badge-{{ $viewingAnnouncement->priority_badge }} px-2 py-1" style="border-radius: 6px;">
                        <i class="fas fa-flag mr-1"></i> {{ ucfirst($viewingAnnouncement->priority) }} Priority
                    </span>
                    <small class="text-muted">
                        <i class="fas fa-calendar mr-1"></i> {{ $viewingAnnouncement->publish_date->format('d M Y') }}
                    </small>
                    <small class="text-muted">
                        <i class="fas fa-user mr-1"></i> {{ $viewingAnnouncement->creator->name ?? 'Unknown' }}
                    </small>
                </div>

                {{-- Content --}}
                <div class="border rounded-lg p-3 mb-3" style="border-radius: 10px !important; min-height: 100px;">
                    {!! $viewingAnnouncement->content !!}
                </div>

                {{-- Attachments --}}
                @php $files = $viewingAnnouncement->getMedia('announcement_attachments'); @endphp
                @if ($files->count())
                    <h6 class="font-weight-bold text-gray-700 mt-4 mb-2"><i class="fas fa-paperclip mr-1"></i> Attachments</h6>
                    @foreach ($files as $media)
                        <div class="d-flex align-items-center justify-content-between bg-light border rounded-lg p-2 mb-2" style="border-radius: 10px !important;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file text-muted mr-2"></i>
                                <div>
                                    <small class="font-weight-bold text-gray-700 d-block">{{ $media->file_name }}</small>
                                    <small class="text-muted">{{ round($media->size / 1024) }} KB</small>
                                </div>
                            </div>
                            <a href="{{ $media->getUrl() }}" target="_blank" download class="btn btn-sm btn-outline-success rounded-pill px-3">
                                <i class="fas fa-download mr-1"></i> Download
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @else

        {{-- Filters --}}
        <div class="row mb-3">
            <div class="col-lg-4 col-md-6 mb-2">
                <input type="text" class="form-control" style="border-radius: 10px;" wire:model.debounce.300ms="search" placeholder="Search announcements...">
            </div>
            <div class="col-lg-2 col-md-3 mb-2">
                <select class="form-control" style="border-radius: 10px;" wire:model="filterType">
                    <option value="">All Types</option>
                    <option value="memo">Memos</option>
                    <option value="announcement">Announcements</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-3 mb-2">
                <select class="form-control" style="border-radius: 10px;" wire:model="filterPriority">
                    <option value="">All Priorities</option>
                    <option value="high">High</option>
                    <option value="normal">Normal</option>
                    <option value="low">Low</option>
                </select>
            </div>
        </div>

        {{-- Announcements List --}}
        @forelse ($announcements as $item)
            @php $isUnread = !$this->isRead($item->id); @endphp
            <div class="card shadow-sm border-0 mb-3 {{ $isUnread ? 'border-left-primary' : '' }}" style="border-radius: 12px; overflow: hidden; {{ $isUnread ? 'border-left: 4px solid #4e73df !important;' : '' }}">
                <div class="card-body p-3">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-1" style="gap: 8px;">
                                @if ($isUnread)
                                    <span class="badge badge-primary px-2 py-1" style="border-radius: 4px; font-size: .65rem;">NEW</span>
                                @endif
                                <span class="badge badge-{{ $item->type_badge }} px-2 py-1" style="border-radius: 4px; font-size: .7rem;">
                                    {{ ucfirst($item->type) }}
                                </span>
                                <span class="badge badge-{{ $item->priority_badge }} px-2 py-1" style="border-radius: 4px; font-size: .7rem;">
                                    {{ ucfirst($item->priority) }}
                                </span>
                            </div>
                            <h6 class="font-weight-bold text-gray-800 mb-1">{{ $item->title }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-user mr-1"></i> {{ $item->creator->name ?? 'Admin' }}
                                &bull; <i class="fas fa-calendar mr-1"></i> {{ $item->publish_date->format('d M Y') }}
                                @if ($item->getMedia('announcement_attachments')->count())
                                    &bull; <i class="fas fa-paperclip mr-1"></i> {{ $item->getMedia('announcement_attachments')->count() }} file(s)
                                @endif
                            </small>
                        </div>
                        <button wire:click="viewAnnouncement({{ $item->id }})" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="fas fa-eye mr-1"></i> View
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-bullhorn text-muted mb-3" style="font-size: 2.5rem; opacity: .3;"></i>
                <p class="text-muted mb-0 font-weight-bold">No announcements available</p>
                <small class="text-muted">Check back later for company updates.</small>
            </div>
        @endforelse

        @if ($announcements->hasPages())
            <div class="mt-3">{{ $announcements->links() }}</div>
        @endif
    @endif
</div>
