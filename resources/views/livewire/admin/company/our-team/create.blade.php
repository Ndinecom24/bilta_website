<!-- Create Team Member Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-sm border-0 rounded-3">
            <form enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createModalLabel">Create Team Member</h5>
                    <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Flash Messages -->
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Basic Info -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" wire:model.defer="name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Enter email" wire:model.defer="email">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" placeholder="Enter phone number" wire:model.defer="phone">
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Position</label>
                            <input type="text" class="form-control" placeholder="Enter position" wire:model.defer="position">
                            @error('position') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Position From</label>
                            <input type="date" class="form-control" wire:model.defer="from">
                            @error('from') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Details</label>
                            <textarea class="form-control" rows="3" placeholder="Enter details" wire:model.defer="details"></textarea>
                            @error('details') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Social Media Links -->
                    <h6 class="text-primary">Social Media Links</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Twitter</label>
                            <input type="text" class="form-control" placeholder="Enter Twitter URL" wire:model.defer="twitter_url">
                            @error('twitter_url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">LinkedIn</label>
                            <input type="text" class="form-control" placeholder="Enter LinkedIn URL" wire:model.defer="linkedin_url">
                            @error('linkedin_url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Facebook</label>
                            <input type="text" class="form-control" placeholder="Enter Facebook URL" wire:model.defer="facebook_url">
                            @error('facebook_url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="form-label">User Image <span class="text-muted">(Only image files allowed)</span></label>
                        <input type="file" class="form-control" accept="image/*" wire:model="user_image">
                        <small class="text-muted">Max size: 3MB | Only images allowed</small>
                        @error('user_image') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="store()" type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
