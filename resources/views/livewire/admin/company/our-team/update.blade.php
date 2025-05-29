<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content border-0 shadow rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="updateModalLabel">Update Team Member</h5>
                <button type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <form wire:submit.prevent="update" enctype="multipart/form-data">
                <div class="modal-body p-4">

                    {{-- Alerts --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
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

                    {{-- Name and Email --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" wire:model.defer="name" placeholder="Full Name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" wire:model.defer="email" placeholder="Email">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    {{-- Phone and Position --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" wire:model.defer="phone" placeholder="Phone Number">
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" wire:model.defer="position" placeholder="Position">
                            @error('position') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    {{-- From and To --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Position From</label>
                            <input type="text" class="form-control" wire:model.defer="from" placeholder="From Year/Date">
                            @error('from') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Position To</label>
                            <input type="text" class="form-control" wire:model.defer="to" placeholder="To Year/Date">
                            @error('to') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="mb-3">
                        <label class="form-label">Details</label>
                        <textarea rows="3" class="form-control" wire:model.defer="details" placeholder="Details about the team member"></textarea>
                        @error('details') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Social Media Links --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Twitter URL</label>
                            <input type="text" class="form-control" wire:model.defer="twitter_url" placeholder="Twitter link">
                            @error('twitter_url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">LinkedIn URL</label>
                            <input type="text" class="form-control" wire:model.defer="linkedin_url" placeholder="LinkedIn link">
                            @error('linkedin_url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Facebook URL</label>
                            <input type="text" class="form-control" wire:model.defer="facebook_url" placeholder="Facebook link">
                            @error('facebook_url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    {{-- Current Image + Upload New --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Current Image</label> <br>
                            @if ($team && $team->getFirstMedia('team_images'))
                                <img src="{{ optional($team->getFirstMedia('team_images'))->getUrl() }}" class="img-fluid rounded" style="max-height: 180px;">
                            @else
                                <p class="text-muted">No image uploaded.</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Upload New Image</label>
                            <input type="file" class="form-control" wire:model="user_image">
                            @error('user_image') <small class="text-danger">{{ $message }}</small> @enderror

                            @if ($user_image)
                                <div class="mt-2">
                                    <strong>Preview:</strong><br>
                                    <img src="{{ $user_image->temporaryUrl() }}" class="img-fluid rounded mt-1" style="max-height: 180px;">
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="cancel">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
