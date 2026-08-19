<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">News Items</h1>
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
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateNewsItem ? 'Edit News Item' : 'Add News Item' }}</h5>

                    @if ($updateNewsItem)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateNewsItem ? 'update' : 'store' }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsTitle">Title</label>
                                <input id="newsTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter news title">
                                @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsDate">Post Date</label>
                                <input id="newsDate" type="date" class="form-control" wire:model.defer="post_date">
                                @error('post_date') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsShortDescription">Short Description</label>
                                <textarea id="newsShortDescription" rows="3" class="form-control" wire:model.defer="short_description" placeholder="Write a short summary"></textarea>
                                @error('short_description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsDetails">Details</label>
                                <input id="newsDetails" type="hidden" wire:model.defer="details">
                                <div wire:ignore>
                                    <trix-editor input="newsDetails" class="bg-white" style="min-height: 350px;"></trix-editor>
                                </div>
                                <small class="text-muted d-block mt-1">Use the editor toolbar to format headings, lists, links, and emphasis.</small>
                                @error('details') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsAuthor">Author</label>
                                <input id="newsAuthor" type="text" class="form-control" wire:model.defer="author" placeholder="Author name">
                                @error('author') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsStatus">Status</label>
                                <select id="newsStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Select Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsCategory">Category</label>
                                <select id="newsCategory" class="form-control" wire:model.defer="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsOrder">Order</label>
                                <input id="newsOrder" type="number" min="0" class="form-control" wire:model.defer="display_order" placeholder="0">
                                @error('display_order') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsTitleImage">Title Image <span class="text-muted font-weight-normal">(optional)</span></label>
                                <input id="newsTitleImage" type="file" class="form-control" wire:model="news_title_image" accept="image/*">
                                <small class="text-muted">Max 5 MB.</small>
                                @error('news_title_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsImages">Additional Images <span class="text-muted font-weight-normal">(optional)</span></label>
                                <input id="newsImages" type="file" class="form-control" wire:model="news_image" multiple accept="image/*">
                                <small class="text-muted">Max 5 MB per image.</small>
                                @error('news_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                @error('news_image.*') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="newsPdfs">PDF Files <span class="text-muted font-weight-normal">(optional)</span></label>
                                <input id="newsPdfs" type="file" class="form-control" wire:model="news_pdf" multiple accept=".pdf">
                                <small class="text-muted">Max 10 MB per file.</small>
                                @error('news_pdf') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                @error('news_pdf.*') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            @if ($updateNewsItem && $news)
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Existing Images</p>
                                    @forelse ($news->getMedia('news_images') as $item)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                            <span>{{ $item->name }}</span>
                                            <button wire:click.prevent="removeImage({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </div>
                                    @empty
                                        <div class="text-muted">No additional images.</div>
                                    @endforelse
                                </div>

                                <div class="col-lg-6 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Existing PDF Files</p>
                                    @forelse ($news->getMedia('news_pdfs') as $item)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                            <div>
                                                <i class="fas fa-file-pdf text-danger mr-1"></i>
                                                <a href="{{ $item->getUrl() }}" target="_blank">{{ $item->name }}</a>
                                                <small class="text-muted ml-1">({{ round($item->size / 1024) }} KB)</small>
                                            </div>
                                            <button wire:click.prevent="removeFile({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </div>
                                    @empty
                                        <div class="text-muted">No PDF files.</div>
                                    @endforelse
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateNewsItem ? 'Update News Item' : 'Save News Item' }}</button>
                            @if ($updateNewsItem)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">News Records</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 90px;">Image</th>
                                    <th style="width: 240px;">Title</th>
                                    <th>Short Description</th>
                                    <th style="width: 130px;">Post Date</th>
                                    <th style="width: 130px;">Author</th>
                                    <th style="width: 120px;">Status</th>
                                    <th style="width: 140px;">Category</th>
                                    <th style="width: 90px;">Order</th>
                                    <th style="width: 130px;">More Images</th>
                                    <th style="width: 90px;">PDFs</th>
                                    <th style="width: 240px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($our_news_items as $our_news_item)
                                    <tr>
                                        <td>
                                            @if ($our_news_item->getFirstMedia('news_title_images'))
                                                <img src="{{ $our_news_item->getFirstMedia('news_title_images')->getUrl() }}" style="height: 52px; width: 72px; object-fit: cover;" alt="News banner">
                                            @endif
                                        </td>
                                        <td>{{ $our_news_item->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($our_news_item->short_description), 120) }}</td>
                                        <td>{{ $our_news_item->post_date }}</td>
                                        <td>{{ $our_news_item->author }}</td>
                                        <td>{{ $our_news_item->status->name ?? '-' }}</td>
                                        <td>{{ $our_news_item->category->name ?? '-' }}</td>
                                        <td>{{ $our_news_item->display_order ?? 0 }}</td>
                                        <td>{{ sizeOf($our_news_item->getMedia('news_images')) }}</td>
                                        <td>{{ sizeOf($our_news_item->getMedia('news_pdfs')) }}</td>
                                        <td>
                                            <button wire:click="edit({{ $our_news_item->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <a href="{{ route('admin.page.item.news.details', $our_news_item->id) }}" class="btn btn-outline-primary btn-sm">Details</a>
                                            <button onclick="deleteOurNewsItem({{ $our_news_item->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No news records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $our_news_items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('trix-file-accept', function (event) {
            event.preventDefault();
        });

        // Sync Trix editor content to Livewire (deferred — no re-render)
        document.addEventListener('trix-change', function (event) {
            var input = event.target.inputElement;
            if (input && input.id === 'newsDetails') {
                @this.set('details', input.value, true);
            }
        });

        // Populate Trix editor when editing an existing news item
        window.addEventListener('load-trix-content', function (event) {
            var editor = document.querySelector('trix-editor[input="newsDetails"]');
            if (editor && editor.editor) {
                editor.editor.loadHTML(event.detail.content || '');
            }
        });

        function deleteOurNewsItem(id) {
            if (confirm("Are you sure to delete this news record?")) {
                window.livewire.emit('deleteNews', id);
            }
        }
    </script>
</div>
