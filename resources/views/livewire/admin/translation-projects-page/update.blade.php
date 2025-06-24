<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Project Item</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form>

                <div class="modal-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Title -->
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" placeholder="Enter Title" wire:model="title">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div class="form-group">
                        <label>Short Description</label>
                        <div wire:ignore>
                            <input type="hidden" id="trix-project-short-description" name="short_description">
                            <trix-editor input="trix-project-short-description"></trix-editor>
                        </div>
                        @error('short_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Project Details -->
                    <div class="form-group">
                        <label>Project Details</label>
                        <div wire:ignore>
                            <input type="hidden" id="trix-project-details" name="details">
                            <trix-editor input="trix-project-details"></trix-editor>
                        </div>
                        @error('details')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Author & Post Date -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Author</label>
                            <input type="text" class="form-control" wire:model="author">
                            @error('author')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Post Date</label>
                            <input type="date" class="form-control" wire:model="post_date">
                            @error('post_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Location & Map -->
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" wire:model="location">
                        @error('location')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Location Map</label>
                        <input type="text" class="form-control" wire:model="location_map">
                    </div>

                    <!-- Status & Category -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select class="form-control" wire:model="status_id">
                                <option>--Choose--</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Category</label>
                            <select class="form-control" wire:model="category_id">
                                <option>--Choose--</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="form-group">
                        <label>Current Image</label><br>
                        @if ($project && $project->getFirstMedia('project_title_images'))
                            <img src="{{ $project->getFirstMedia('project_title_images')->getUrl() }}"
                                style="width: 100%; height: 150px;" alt="Current Image">
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Title Image</label>
                        <input type="file" class="form-control" wire:model="title_image">
                        @error('title_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Additional Images -->
                    <div class="form-group">
                        <label>Add More Project Images</label>
                        <input type="file" class="form-control" wire:model="project_image" multiple>
                        @error('project_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Additional Files -->
                    <div class="form-group">
                        <label>Add More Project Files</label>
                        <input type="file" class="form-control" wire:model="project_file" multiple>
                        @error('project_file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Existing Media -->
                    <hr>
                    <label>Remove Project Images</label>
                    <div class="row">
                        @if ($project && $project->getMedia('project_images')->isNotEmpty())
                            @foreach ($project->getMedia('project_images') as $item)
                                <div class="col-md-8 m-1">
                                    <img src="{{ $item->getUrl() }}" style="width:100%; height: 150px;">
                                </div>
                                <div class="col-md-3 m-1 d-flex align-items-center">
                                    <button wire:click.prevent="removeImage({{ $item->id }})"
                                        class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-muted">
                                <em>No project images available.</em>
                            </div>
                        @endif
                    </div>

                    <hr>
                    <label>Remove Project Files</label>
                    <div class="row">
                        @if ($project && $project->getMedia('project_files')->isNotEmpty())
                            @foreach ($project->getMedia('project_files') as $item)
                                <div class="col-md-8 m-1">
                                    @if ($item->mime_type === 'application/pdf' || $item->getExtension() === 'pdf')
                                        <a href="{{ $item->getUrl() }}" target="_blank">
                                            <iframe src="{{ $item->getUrl() }}" height="100px"
                                                frameborder="0"></iframe>
                                        </a>
                                    @else
                                        <img src="{{ $item->getUrl() }}" style="width:100%; height: 150px;">
                                    @endif
                                </div>
                                <div class="col-md-3 m-1 d-flex align-items-center">
                                    <button wire:click.prevent="removeFile({{ $item->id }})"
                                        class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-muted">
                                <em>No project files available.</em>
                            </div>
                        @endif
                    </div>


                </div>

                <div class="modal-footer">
                    <div wire:loading>
                        <div class="spinner-border text-success" role="status"></div>
                        <span class="text-sm text-info">Loading...</span>
                    </div>
                    <button wire:click.prevent="update" class="btn btn-success">Save</button>
                    <button wire:click.prevent="cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const shortDescEditor = document.querySelector("trix-editor[input='trix-project-short-description']");
            if (shortDescEditor) {
                shortDescEditor.addEventListener('trix-change', function(event) {
                    Livewire.find('{{ $this->id }}')
                        .set('short_description', event.target.editor.getDocument().toString());
                });
            }

            const detailsEditor = document.querySelector("trix-editor[input='trix-project-details']");
            if (detailsEditor) {
                detailsEditor.addEventListener('trix-change', function(event) {
                    Livewire.find('{{ $this->id }}')
                        .set('details', event.target.editor.getDocument().toString());
                });
            }
        });

        // Optional: Populate Trix editors from Livewire
        window.addEventListener('fillTrixFields', event => {
            document.querySelector('#trix-project-short-description').value = event.detail.short_description;
            document.querySelector("trix-editor[input='trix-project-short-description']").editor.loadHTML(event
                .detail.short_description);

            document.querySelector('#trix-project-details').value = event.detail.details;
            document.querySelector("trix-editor[input='trix-project-details']").editor.loadHTML(event.detail
                .details);
        });
    </script>

</div>
