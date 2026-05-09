<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Translation Projects</h1>
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
                    <h5 class="mb-0">{{ $updateProjectsItem ? 'Edit Project' : 'Add Project' }}</h5>

                    @if ($updateProjectsItem)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateProjectsItem ? 'update' : 'store' }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectTitle">Title</label>
                                <input id="projectTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter project title">
                                @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectDate">Post Date</label>
                                <input id="projectDate" type="date" class="form-control" wire:model.defer="post_date">
                                @error('post_date') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectShortDescription">Short Description</label>
                                <textarea id="projectShortDescription" rows="3" class="form-control" wire:model.defer="short_description" placeholder="Write a short summary"></textarea>
                                @error('short_description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectDetails">Details</label>
                                <input id="projectDetails" type="hidden" wire:model.defer="details">
                                <trix-editor input="projectDetails" class="bg-white"></trix-editor>
                                <small class="text-muted d-block mt-1">Use the editor toolbar to format headings, lists, links, and emphasis.</small>
                                @error('details') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectAuthor">Author</label>
                                <input id="projectAuthor" type="text" class="form-control" wire:model.defer="author" placeholder="Author name">
                                @error('author') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectStatus">Status</label>
                                <select id="projectStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Select Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectCategory">Category</label>
                                <select id="projectCategory" class="form-control" wire:model.defer="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectOrder">Order</label>
                                <input id="projectOrder" type="number" min="0" class="form-control" wire:model.defer="display_order" placeholder="0">
                                @error('display_order') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectLocation">Location</label>
                                <input id="projectLocation" type="text" class="form-control" wire:model.defer="location" placeholder="Project location">
                                @error('location') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectMap">Location Map URL</label>
                                <input id="projectMap" type="text" class="form-control" wire:model.defer="location_map" placeholder="Map or embed URL">
                                @error('location_map') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            @if ($updateProjectsItem && $project && $project->getFirstMedia('project_title_images'))
                                <div class="col-lg-12 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-1">Current Title Banner</p>
                                    <img src="{{ $project->getFirstMedia('project_title_images')->getUrl() }}" style="max-height: 90px;" alt="Project title banner">
                                </div>
                            @endif

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectTitleImage">Title Image</label>
                                <input id="projectTitleImage" type="file" class="form-control" wire:model="title_image">
                                @error('title_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectImages">Project Images</label>
                                <input id="projectImages" type="file" class="form-control" wire:model="project_image" multiple>
                                @error('project_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectFiles">Project Files</label>
                                <input id="projectFiles" type="file" class="form-control" wire:model="project_file" multiple>
                                @error('project_file') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            @if ($updateProjectsItem && $project)
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Existing Gallery Files</p>
                                    @forelse ($project->getMedia('project_images') as $item)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                            <span>{{ $item->name }}</span>
                                            <button wire:click.prevent="removeImage({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </div>
                                    @empty
                                        <div class="text-muted">No project images.</div>
                                    @endforelse
                                </div>

                                <div class="col-lg-6 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Existing Attachment Files</p>
                                    @forelse ($project->getMedia('project_files') as $item)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                            <span>{{ $item->name }}</span>
                                            <button wire:click.prevent="removeFile({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </div>
                                    @empty
                                        <div class="text-muted">No project files.</div>
                                    @endforelse
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <button type="submit" class="btn btn-primary">{{ $updateProjectsItem ? 'Update Project' : 'Save Project' }}</button>
                            @if ($updateProjectsItem)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                            <div wire:loading class="text-info small">Saving...</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Project Records</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 90px;">Image</th>
                                    <th style="width: 240px;">Title</th>
                                    <th>Short Description</th>
                                    <th style="width: 140px;">Post Date</th>
                                    <th style="width: 140px;">Author</th>
                                    <th style="width: 120px;">Status</th>
                                    <th style="width: 160px;">Location</th>
                                    <th style="width: 90px;">Order</th>
                                    <th style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($translation_projects as $translation_project)
                                    <tr>
                                        <td>
                                            @if ($translation_project->getFirstMedia('project_title_images'))
                                                <img src="{{ $translation_project->getFirstMedia('project_title_images')->getUrl() }}" style="height: 52px; width: 72px; object-fit: cover;" alt="Project banner">
                                            @endif
                                        </td>
                                        <td>{{ $translation_project->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($translation_project->short_description), 120) }}</td>
                                        <td>{{ $translation_project->post_date }}</td>
                                        <td>{{ $translation_project->author }}</td>
                                        <td>{{ $translation_project->status->name ?? '-' }}</td>
                                        <td>{{ $translation_project->location ?? '-' }}</td>
                                        <td>{{ $translation_project->display_order ?? 0 }}</td>
                                        <td>
                                            <button wire:click="edit({{ $translation_project->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteOurProjectsItem({{ $translation_project->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No project records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $translation_projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('trix-file-accept', function (event) {
            event.preventDefault();
        });

        function deleteOurProjectsItem(id) {
            if (confirm("Are you sure to delete this project record?")) {
                window.livewire.emit('deleteProjects', id);
            }
        }
    </script>
</div>
