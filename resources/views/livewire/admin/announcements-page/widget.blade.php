{{-- Dashboard Widget: Latest Announcements --}}
<div class="card shadow border-0 mb-4" style="border-radius: 12px; overflow: hidden;">
    <div class="card-header bg-light py-2 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 font-weight-bold text-gray-700">
            <i class="fas fa-bullhorn text-primary mr-1"></i> Latest Announcements
        </h6>
        @if ($unreadCount > 0)
            <span class="badge badge-danger px-2 py-1" style="border-radius: 50px; font-size: .7rem;">
                {{ $unreadCount }} new
            </span>
        @endif
    </div>
    <div class="card-body p-0">
        @forelse ($latestAnnouncements as $item)
            <div class="d-flex align-items-center px-3 py-2 border-bottom {{ !$item->isReadBy(auth()->id()) ? 'bg-light' : '' }}">
                <div class="mr-3">
                    @if ($item->priority === 'high')
                        <i class="fas fa-exclamation-circle text-danger" style="font-size: 1.1rem;"></i>
                    @elseif ($item->type === 'memo')
                        <i class="fas fa-file-alt text-info" style="font-size: 1.1rem;"></i>
                    @else
                        <i class="fas fa-bullhorn text-success" style="font-size: 1.1rem;"></i>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <a href="{{ route('employee.announcements') }}" class="text-gray-800 font-weight-bold small d-block text-decoration-none">
                        {{ \Illuminate\Support\Str::limit($item->title, 45) }}
                    </a>
                    <small class="text-muted">{{ $item->publish_date->format('d M Y') }}</small>
                </div>
                <span class="badge badge-{{ $item->priority_badge }} px-2" style="border-radius: 4px; font-size: .65rem;">
                    {{ ucfirst($item->priority) }}
                </span>
            </div>
        @empty
            <div class="text-center py-3">
                <small class="text-muted">No announcements</small>
            </div>
        @endforelse
    </div>
    @if ($latestAnnouncements->count())
        <div class="card-footer bg-white text-center py-2">
            <a href="{{ route('employee.announcements') }}" class="small text-primary font-weight-bold">
                View All Announcements <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    @endif
</div>
