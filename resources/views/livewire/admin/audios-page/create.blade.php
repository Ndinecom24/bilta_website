<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="faqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="faqModalLabel">Create Audio Item</h5>
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
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <form>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput10">Audio File</label>
                                <input type="file" class="form-control" id="contactUsFormControlInput10" accept="audio/*" wire:model.defer="file_url">
                                @error('file_url') <span class="text-danger">{{ $message }}</span>@enderror
                                
                                <!-- Spinner for file upload -->
                                <div wire:loading wire:target="file_url" class="mt-2">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Uploading...</span>
                                    </div>
                                    <span>Uploading file...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput1">Title</label>
                                <input type="text" class="form-control" id="faqFormControlInput1" placeholder="Enter Title" wire:model.defer="title">
                                @error('title') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput2">Description</label>
                                <textarea rows="3" class="form-control" id="faqFormControlInput2" wire:model.defer="description" placeholder="Enter Description"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="project_id">Project</label>
                                <select class="form-control" id="project_id" wire:model.defer="project_id">
                                    <option>--Choose--</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                                @error('project_id') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="status_id">Status</label>
                                <select class="form-control" id="status_id" wire:model.defer="status_id">
                                    <option>--Choose--</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="store()" class="btn btn-primary close-modal">
                        Save changes
                        <!-- Spinner for form submission -->
                        <div wire:loading wire:target="store" class="spinner-border spinner-border-sm ml-2" role="status">
                            <span class="sr-only">Saving...</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
