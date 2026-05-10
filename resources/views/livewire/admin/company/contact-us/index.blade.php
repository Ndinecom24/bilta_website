<div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact Us Details</h1>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">

            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateContactUs ? 'Edit Contact Details' : 'Add Contact Details' }}</h5>

                    @if ($updateContactUs)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateContactUs ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold" for="contactPhone">Phone</label>
                                <input id="contactPhone" type="text" class="form-control" wire:model.defer="phone" placeholder="e.g. +260...">
                                @error('phone') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold" for="contactEmail">Email</label>
                                <input id="contactEmail" type="text" class="form-control" wire:model.defer="email" placeholder="e.g. infor@bilta.org">
                                @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="contactWhatsapp">WhatsApp Link</label>
                                <input id="contactWhatsapp" type="text" class="form-control" wire:model.defer="whatsapp_link" placeholder="https://wa.me/...">
                                @error('whatsapp_link') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="contactAddress">Address</label>
                                <textarea id="contactAddress" rows="3" class="form-control" wire:model.defer="address" placeholder="Enter full office address"></textarea>
                                @error('address') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="contactMessage">Message</label>
                                <textarea id="contactMessage" rows="3" class="form-control" wire:model.defer="message" placeholder="Short public contact message"></textarea>
                                @error('message') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="contactMaps">Google Maps Embed/Link</label>
                                <textarea id="contactMaps" rows="3" class="form-control" wire:model.defer="google_maps" placeholder="Paste google maps embed code or link"></textarea>
                                @error('google_maps') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold" for="contactYoutube">YouTube Link</label>
                                <input id="contactYoutube" type="text" class="form-control" wire:model.defer="youtube" placeholder="https://youtube.com/...">
                                @error('youtube') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold" for="contactTwitter">Twitter/X Link</label>
                                <input id="contactTwitter" type="text" class="form-control" wire:model.defer="twitter_url" placeholder="https://x.com/...">
                                @error('twitter_url') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold" for="contactLinkedIn">LinkedIn Link</label>
                                <input id="contactLinkedIn" type="text" class="form-control" wire:model.defer="linkedin_url" placeholder="https://linkedin.com/...">
                                @error('linkedin_url') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold" for="contactFacebook">Facebook Link</label>
                                <input id="contactFacebook" type="text" class="form-control" wire:model.defer="facebook_url" placeholder="https://facebook.com/...">
                                @error('facebook_url') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateContactUs ? 'Update Details' : 'Save Details' }}</button>

                            @if ($updateContactUs)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Current Contact Details</h5>

                    @if(isset($contact_details))
                        <div>
                            <button wire:click="edit({{ $contact_details->id }})" class="btn btn-primary btn-sm">Edit</button>
                            <button onclick="deleteContactUs({{ $contact_details->id }})" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    @if(isset($contact_details))
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr><th style="width:220px;">Phone</th><td>{{ $contact_details->phone ?? '-' }}</td></tr>
                                    <tr><th>Email</th><td>{{ $contact_details->email ?? '-' }}</td></tr>
                                    <tr><th>Address</th><td>{{ $contact_details->address ?? '-' }}</td></tr>
                                    <tr><th>Message</th><td>{{ $contact_details->message ?? '-' }}</td></tr>
                                    <tr><th>Google Maps</th><td>{{ $contact_details->google_maps ?? '-' }}</td></tr>
                                    <tr><th>WhatsApp</th><td>{{ $contact_details->whatsapp_link ?? '-' }}</td></tr>
                                    <tr><th>YouTube</th><td>{{ $contact_details->youtube ?? '-' }}</td></tr>
                                    <tr><th>Twitter/X</th><td>{{ $contact_details->twitter_url ?? '-' }}</td></tr>
                                    <tr><th>LinkedIn</th><td>{{ $contact_details->linkedin_url ?? '-' }}</td></tr>
                                    <tr><th>Facebook</th><td>{{ $contact_details->facebook_url ?? '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0 text-muted">No contact details found yet. Use the form above to add your first record.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteContactUs(id) {
            if (confirm("Are you sure to delete this record?")) {
                window.livewire.emit('deleteContactUs', id);
            }
        }
    </script>

</div>
