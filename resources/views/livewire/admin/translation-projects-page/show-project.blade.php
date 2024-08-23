<!-- Show Modal -->
<div wire:ignore.self class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="showModalLabel">Project Details</h5>
                    </div>
                    <div class="col-12">
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
                </div>
            </div>

            <div class="modal-body">
                <!-- Project Information -->
                <div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showTitle">Title</label>
                                <p id="showTitle" class="form-control-static">{{ $title }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showShortDescription">Short Description</label>
                                <p id="showShortDescription" class="form-control-static">{{ $short_description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showDetails">Details</label>
                                <p id="showDetails" class="form-control-static">{{ $details }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showAuthor">Author</label>
                                <p id="showAuthor" class="form-control-static">{{ $author }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showPostDate">Post Date</label>
                                <p id="showPostDate" class="form-control-static">{{ $post_date }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showLocation">Location</label>
                                <p id="showLocation" class="form-control-static">{{ $location }}</p>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showLocationMap">Location Map:</label>
                                <p id="showLocationMap" class="form-control-static">{{ $location_map }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showStatus">Status:</label>
                                <p id="showStatus" class="form-control-static">{{ $project->status->name ?? ""  }}</p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showCategory">Category:</label>
                                <p id="showCategory" class="form-control-static">{{ $categories->find($category_id)->name ?? "" }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Current Image Display -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showCurrentImage">Current Image</label>
                                @if (isset($project) && $project->getFirstMedia('project_title_images'))
                                    <img src="{{ $project->getFirstMedia('project_title_images')->getUrl() }}"
                                        style="width:100%; height: 150px"
                                        title="{{ $project->getFirstMedia('project_title_images')->name }}">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Additional Project Images -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showProjectImages">Additional Project Images</label>
                                @if (isset($project) && $project->getMedia('project_images'))
                                    @foreach ($project->getMedia('project_images') as $image)
                                        <img src="{{ $image->getUrl() }}" style="width:100%; height: 150px"
                                            title="{{ $image->name }}">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Additional Project Files -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="text-bold" for="showProjectFiles">Additional Project Files</label>
                                @if (isset($project) && $project->getMedia('project_files'))
                                    @foreach ($project->getMedia('project_files') as $file)
                                    @if ($file->mime_type === 'application/pdf' || $file->getExtensionAttribute() === 'pdf')
                                    <a href="{{ $file->getUrl() }}" target="_blank">
                                        <iframe src="{{ $file->getUrl() }}" height="100px" frameborder="0">
                                        </iframe>
                                        <span class="text-sm">open</span>
                                    </a>
                                @else
                                    @if ($file != null)
                                        <img src="{{ $file->getUrl() }}" style="width:100%; height: 150px "
                                            title="{{ $file->name }}">
                                    @endif
                                @endif
                                        <a href="{{ $file->getUrl() }}" target="_blank">{{ $file->name }}</a><br>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button wire:click.prevent="closeShowModal" class="btn btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>
