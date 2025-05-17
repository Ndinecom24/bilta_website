<div>
    <style>
        .section-header {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d2d2d;
            border-bottom: 2px solid #eee;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
        }

        .card-light {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .audio-player {
            width: 100%;
            margin-bottom: 1rem;
        }

        .comment-section {
            margin-top: 2rem;
        }

        .comment-form {
            display: flex;
            align-items: center;
            gap: 1rem;
            border-top: 1px solid #eee;
            padding-top: 1rem;
        }

        .comment-form textarea {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 0.75rem;
            resize: none;
            font-size: 0.9rem;
            height: 60px;
        }

        .comment-form button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .comments-feed {
            margin-top: 1.5rem;
        }

        .comment-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ccc;
            flex-shrink: 0;
        }

        .comment-content {
            background-color: #f5f5f5;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            max-width: 100%;
        }

        .comment-content .comment-author {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .comment-content .comment-time {
            font-size: 0.75rem;
            color: #777;
            margin-left: 0.5rem;
        }

        .comment-content .comment-text {
            margin-top: 0.25rem;
            font-size: 0.9rem;
            color: #333;
        }
    </style>

    <section class="section-bg py-5">
        <div class="container">
            <div class="section-header">Audio Details</div>

            <div class="card-light">
                <!-- Audio Player -->
                @if ($project->getFirstMedia('audio_file'))
                    <audio controls class="audio-player">
                        <source src="{{ $project->getFirstMedia('audio_file')->getUrl() }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                @endif

                <h2 class="project-title">{{ $project->title ?? 'Untitled Audio' }}</h2>
                <div class="project-meta">
                    Post Date: {{ $project->post_date ?? '-' }} | Author: {{ $project->author ?? '-' }}
                </div>
                <div class="project-details">{!! $project->description ?? '' !!}</div>
            </div>

            <!-- Comment Section -->
            <div class="card-light comment-section">
                <h3 class="section-header">Comments</h3>

                <!-- Flash Messages -->
                @if (session()->has('success'))
                    <div class="text-green-600 mb-2">{{ session('success') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="text-red-600 mb-2">{{ session('error') }}</div>
                @endif

                <!-- Previous Comments -->
                <div class="comments-feed">
                    @forelse ($comments as $comment)
                        <div class="comment-item">
                            <div class="comment-avatar"></div>
                            <div class="comment-content">
                                <div>
                                    <span class="comment-author">{{ $comment->user->name ?? 'Anonymous' }}</span>
                                    <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="comment-text">{{ $comment->body }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No comments yet. Be the first to comment!</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $comments->links() }}
                    </div>
                </div>

                <!-- New Comment Form -->
                @auth
                    <form wire:submit.prevent="submitComment" class="comment-form mt-4">
                        <textarea wire:model.defer="newComment" placeholder="Write your comment..."></textarea>
                        <button type="submit" wire:loading.attr="disabled">Post</button>
                    </form>
                    @error('newComment') <div class="text-red-500 mt-2 text-sm">{{ $message }}</div> @enderror
                @else
                    <div class="text-muted mt-4">Please <a href="{{ route('login') }}">login</a> to comment.</div>
                @endauth
            </div>
        </div>
    </section>
</div>
