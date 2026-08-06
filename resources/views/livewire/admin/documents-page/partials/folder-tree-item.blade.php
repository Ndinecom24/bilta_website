{{-- Recursive folder tree item --}}
@php $isActive = ($folder->id == ($currentFolderId ?? null)); @endphp

<div style="padding-left: {{ $depth * 14 }}px;" class="mb-1">
    <a href="#" wire:click.prevent="navigateToFolder({{ $folder->id }})"
       class="d-flex align-items-center py-1 px-2 rounded text-decoration-none {{ $isActive ? 'bg-primary text-white' : 'text-gray-700' }}"
       style="border-radius: 6px; font-size: .82rem; transition: background .15s;">
        <i class="fas {{ $folder->children->count() ? 'fa-folder-open' : 'fa-folder' }} mr-2 {{ $isActive ? 'text-white' : 'text-warning' }}" style="font-size: .9rem;"></i>
        <span class="font-weight-bold text-truncate" style="max-width: 120px;">{{ $folder->name }}</span>
        @if ($folder->visibility !== 'everyone')
            <i class="{{ $folder->visibility_icon }} ml-auto" style="font-size: .55rem; opacity: .7;"></i>
        @endif
    </a>

    @if ($folder->children->count())
        @foreach ($folder->children as $child)
            @include('livewire.admin.documents-page.partials.folder-tree-item', ['folder' => $child, 'depth' => $depth + 1])
        @endforeach
    @endif
</div>
