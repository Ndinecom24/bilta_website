<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Audio Detail</h2>
            <p class="lead mb-0">Listen and engage with the content, then contribute in the discussion.</p>
        </section>

        <section class="page-section mb-4">
            @if ($project && $project->getFirstMedia('audio_file'))
                <audio controls class="w-100 mb-3">
                    <source src="{{ $project->getFirstMedia('audio_file')->getUrl() }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            @endif

            <h3 class="site-section-title mb-1">{{ $project->title ?? 'Untitled Audio' }}</h3>
            <p class="text-muted small mb-3">Post Date: {{ $project->post_date ?? '-' }} · Author: {{ $project->author ?? '-' }}</p>
            <div class="site-detail-content">{!! $project->description ?? '' !!}</div>
        </section>

        <section class="page-section">
            <h4 class="site-section-title">Comments</h4>
            @if (session()->has('success'))
                <div class="alert alert-success py-2">{{ session('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger py-2">{{ session('error') }}</div>
            @endif

            <div class="site-stacked mb-4">
                @forelse ($comments as $comment)
                    <div class="site-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>
                                <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mb-0">{{ $comment->body }}</p>
                        </div>
                    </div>
                @empty
                    <div class="site-empty">No comments yet. Be the first to comment.</div>
                @endforelse
            </div>

            <div class="mb-3">{{ $comments->links() }}</div>

            @auth
                <form wire:submit.prevent="submitComment" class="d-flex gap-2 flex-wrap">
                    <textarea wire:model.defer="newComment" class="form-control" rows="3" placeholder="Write your comment..."></textarea>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Post Comment</button>
                </form>
                @error('newComment') <div class="text-danger mt-2 small">{{ $message }}</div> @enderror
            @else
                <div class="text-muted">Please <a href="{{ route('login') }}">login</a> to comment.</div>
            @endauth
        </section>
    </div>
</div>
