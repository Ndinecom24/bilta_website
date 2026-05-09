<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">News Item Details</h1>
            <p class="text-muted mb-0">Review and update this news record, including media assets.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
    
        <div class="col-md-4 mb-3">
            @if ($our_news_item->getFirstMedia('news_title_images'))
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Title Image</h5>
                    </div>
                    <div class="card-body">
                        <img src="{{ $our_news_item->getFirstMedia('news_title_images')->getUrl() }}"
                             style="width:100%; max-height:300px; object-fit:cover;"
                             alt="{{ $our_news_item->title }}"
                             class="img-fluid rounded">
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Additional Images</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($our_news_item->getMedia('news_images') as $item)
                            <div class="col-md-6 mb-2">
                                <img src="{{ $item->getUrl() }}"
                                     style="width:100%; height:120px; object-fit:cover;"
                                     alt="{{ $item->name }}"
                                     class="img-thumbnail">
                            </div>
                        @empty
                            <div class="col-12 text-muted">No additional images.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-3">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $our_news_item->title }}</h5>
                    <span class="badge badge-light">{{ $our_news_item->status->name ?? '-' }}</span>
                </div>
                <div class="card-body">
                    <p><strong>Author:</strong> {{ $our_news_item->author }}</p>
                    <p><strong>Post Date:</strong> {{ $our_news_item->post_date }}</p>
                    <p><strong>Category:</strong> {{ $our_news_item->category->name ?? '-' }}</p>
                    <hr>
                    <p class="mb-1"><strong>Short Description</strong></p>
                    <p>{{ $our_news_item->short_description }}</p>
                    <p class="mb-1"><strong>Details</strong></p>
                    <div>{!! $our_news_item->details !!}</div>
                </div>
                <div class="card-footer d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.page.item.news') }}" class="btn btn-secondary">Back to News List</a>
                    <button wire:click="edit({{ $our_news_item->id }})" class="btn btn-primary">Edit</button>
                    <button onclick="deleteOurNewsItem({{ $our_news_item->id }})" class="btn btn-danger">Delete</button>
                </div>
            </div>

            @if ($updateNewsItem)
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit News Item</h5>
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Close Editor</button>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="update" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="newsTitle">Title</label>
                                    <input id="newsTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter title">
                                    @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="newsAuthor">Author</label>
                                    <input id="newsAuthor" type="text" class="form-control" wire:model.defer="author" placeholder="Enter author">
                                    @error('author') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="newsShortDescription">Short Description</label>
                                    <textarea id="newsShortDescription" rows="3" class="form-control" wire:model.defer="short_description" placeholder="Enter short description"></textarea>
                                    @error('short_description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="newsDetails">Details</label>
                                    <textarea id="newsDetails" rows="6" class="form-control" wire:model.defer="details" placeholder="Enter details"></textarea>
                                    @error('details') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="newsPostDate">Post Date</label>
                                    <input id="newsPostDate" type="date" class="form-control" wire:model.defer="post_date">
                                    @error('post_date') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="font-weight-bold" for="newsStatus">Status</label>
                                    <select id="newsStatus" class="form-control" wire:model.defer="status_id">
                                        <option value="">-- Choose --</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="font-weight-bold" for="newsCategory">Category</label>
                                    <select id="newsCategory" class="form-control" wire:model.defer="category_id">
                                        <option value="">-- Choose --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="newsTitleImage">Replace Title Image (optional)</label>
                                    <input id="newsTitleImage" type="file" class="form-control" wire:model="news_title_image">
                                    @error('news_title_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="newsImages">Add More News Images</label>
                                    <input id="newsImages" type="file" class="form-control" wire:model="news_image" multiple>
                                    @error('news_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Remove Existing Additional Images</p>
                                    <div class="row">
                                        @forelse ($our_news_item->getMedia('news_images') as $item)
                                            <div class="col-md-4 mb-3">
                                                <img src="{{ $item->getUrl() }}" class="img-fluid rounded mb-2" style="height: 120px; width: 100%; object-fit: cover;" alt="{{ $item->name }}">
                                                <button wire:click.prevent="removeImage({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                                            </div>
                                        @empty
                                            <div class="col-12 text-muted">No additional images to remove.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function deleteOurNewsItem(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.livewire.emit('deleteNews', id);
            }
        }
    </script>

</div>
