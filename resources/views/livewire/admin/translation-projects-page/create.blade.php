<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="faqModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="faqModalLabel">Create Projects Item</h5>
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
            <form enctype="multipart/form-data">
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
                                    <div wire:ignore>
                                        <label for="faqFormControlInput2">Short Description</label>
                                        <input id="trix-short_description" type="hidden" name="short_description" wire:model.lazy="short_description">
                                        <trix-editor input="trix-short_description"></trix-editor>
                                    </div>
                                    @error('short_description')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <div wire:ignore>
                                        <label for="faqFormControlInput2">Project Details</label>
                                        <input id="trix-details" type="hidden" name="details" wire:model.lazy="details">
                                        <trix-editor input="trix-details"></trix-editor>
                                    </div>
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
                                        <option>--Choose--</option>
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
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInput10">Project Title Image</label>
                                    <input type="file" class="form-control" id="contactUsFormControlInput10"
                                        placeholder="Enter Image" wire:model="title_image">
                                    @error('title_image')
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInput10">Projects Images</label>
                                    <input type="file" class="form-control" id="contactUsFormControlInput11"
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
                                    <label for="contactUsFormControlInput10">Projects Files</label>
                                    <input type="file" class="form-control" id="contactUsFormControlInput11"
                                        multiple placeholder="Enter Project Images" wire:model="project_file">
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
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                   
                    <button wire:click.prevent="store()" class="btn btn-primary close-modal">Save changes</button>
                </div>

            </form>
        </div>
    </div>
</div>
