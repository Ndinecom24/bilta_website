<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="faqModalLabel">Update Project Item</h5>
                    </div>
                    <div class="col-12">
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

            <form>

                <div class="modal-body">

                    <div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput1">Title</label>
                                    <input type="text" class="form-control" id="faqFormControlInput1"
                                        placeholder="Enter Title" wire:model="title">
                                    @error('title')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput2">Short Description</label>
                                    <textarea rows="3" class="form-control" id="faqFormControlInput2" placeholder="Enter Short_description"
                                        wire:model="short_description"></textarea>
                                    @error('short_description')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput3">Details</label>
                                    <textarea rows="4" class="form-control" id="faqFormControlInput3" placeholder="Enter Details"
                                        wire:model="details"></textarea>
                                    @error('details')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput4">Author</label>
                                    <input type="text" class="form-control" id="faqFormControlInput4"
                                        placeholder="Enter Author" wire:model="author">
                                    @error('author')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput5">Post Date</label>
                                    <input type="date" class="form-control" id="faqFormControlInput5"
                                        placeholder="Enter Post Date" wire:model="post_date">
                                    @error('post_date')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput14">Location</label>
                                    <input type="text" class="form-control" id="faqFormControlInput14"
                                        placeholder="Enter Author" wire:model="location">
                                    @error('location')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput15">Location Map</label>
                                    <input type="text" class="form-control" id="faqFormControlInput15"
                                        placeholder="Enter Post Date" wire:model="location_map">
                                    @error('location')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="faqFormControlInput6">Status</label>
                                    <select required class="form-control" id="faqFormControlInput6"
                                        wire:model="status_id">
                                        <option>--Choose--</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <span class="form-check-label text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInput7">Category </label>
                                    <select required class="form-control" id="faqFormControlInput7"
                                        wire:model="category_id">
                                        <option>--Choose</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInput10">Current Image</label>
                                    @if (isset($project))
                                        @if ($project->getFirstMedia('project_title_images') != null)
                                            <img src="{{ $project->getFirstMedia('project_title_images')->getUrl() }}"
                                                style="width:100%; height: 150px "
                                                title="{{ $project->getFirstMedia('project_title_images')->name }}">
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInputprojectImage">Title Image</label>
                                    <input type="file" class="form-control"
                                        id="contactUsFormControlInputprojectImage" placeholder="Enter Image"
                                        wire:model="title_image">
                                    @error('title_image')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInput121">Add More Projects Images</label>
                                    <input type="file" class="form-control" id="contactUsFormControlInput121"
                                        multiple placeholder="Enter Project Images" wire:model="project_image">
                                    @error('project_image')
                                        <span class="text-danger "> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInput133">Add More Projects Files</label>
                                    <input type="file" class="form-control" id="contactUsFormControlInput133"
                                        multiple placeholder="Enter Project File" wire:model="project_file">
                                    @error('project_file')
                                        <span class="text-danger "> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

                <div class="modal-footer">
                    <div wire:loading>
                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span class="text-sm text-info">Loading...</span>
                    </div>
                    <button wire:click.prevent="update()" class="btn btn-success ">Save</button>

                    <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
                </div>

            </form>

            <div class="card card-body">


                <div class="row">
                    <label for="ew">Remove Projects Images</label>
                </div>
                <div class="row">
                    @if (isset($project))
                        @foreach ($project->getMedia('project_images') as $item)
                            <div class="col-lg-8 col-md-8 col-sm-12 m-1">
                                @if ($item != null)
                                    <img src="{{ $item->getUrl() }}" style="width:100%; height: 150px "
                                        title="{{ $item->name }}">
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 m-1">
                                <div class="modal-footer">


                                    <button wire:click.prevent="removeImage({{ $item->id }})"
                                        class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    @endif


                </div>

                <div class="row mt-3">
                    <label for="ew">Remove Projects Files</label>
                    <hr>
                </div>
                <div class="row">
                    @if (isset($project))
                        @foreach ($project->getMedia('project_files') as $item)
                            <div class="col-lg-8 col-md-8 col-sm-12 m-1">
                                @if ($item != null)
                                    @if ($item->mime_type === 'application/pdf' || $project_file->getExtensionAttribute() === 'pdf')
                                        <a href="{{ $item->getUrl() }}" target="_blank">
                                            <iframe src="{{ $item->getUrl() }}" height="100px" frameborder="0">
                                            </iframe>
                                            <span class="text-sm">open</span>
                                        </a>
                                    @else
                                        @if ($item != null)
                                            <img src="{{ $item->getUrl() }}" style="width:100%; height: 150px "
                                                title="{{ $item->name }}">
                                        @endif
                                    @endif
                                @endif
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 m-1">
                                <div class="modal-footer">


                                    <button wire:click.prevent="removeFile({{ $item->id }})"
                                        class="btn btn-sm btn-outline-danger">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    @endif


                </div>

            </div>
        </div>
    </div>
</div>
