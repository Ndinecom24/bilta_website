@foreach ($attachments as $attachment)
    <div class="d-inline-block mr-3 mb-1">
        <a href="{{ route('admin.support.attachment', $attachment->id) }}" target="_blank" rel="noopener">
            <i class="fas {{ $attachment->isInlineImage() ? 'fa-image' : 'fa-file' }}"></i>
            {{ $attachment->original_name }}
        </a>
        <small class="text-muted">({{ $attachment->human_size }})</small>
    </div>
@endforeach
