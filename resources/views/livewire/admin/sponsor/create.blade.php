<!-- OurSponsor Modal -->
<div wire:ignore.self class="modal fade" id="createOurSponsorModal" tabindex="-1" role="dialog" aria-labelledby="sponsormessageModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="sponsormessageModalLabel">Create / Reply to Our Sponsor</h5>
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
                                <label for="sponsormessageRecipient">Sponsor Name</label>
                                <input type="sponsormessage" class="form-control" id="sponsormessageRecipient" placeholder="Enter Sponsor name" wire:model="name">
                                @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="sponsormessageSubject">Sponsor Website URL</label>
                                <input type="url" class="form-control" id="sponsormessageSubject" placeholder="Enter Sponsor Website_url" wire:model="website_url">
                                @error('website_url') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="sponsormessageBody">Sponsor Description</label>
                                <textarea rows="5" class="form-control" id="sponsormessageBody" wire:model="description" placeholder="Enter Our description here"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput10">Image</label>
                                <input type="file" class="form-control" id="contactUsFormControlInput10"
                                       placeholder="Enter Image" wire:model="sponsor_image">
                                @error('sponsor_image') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="saveOurSponsor()" class="btn btn-primary close-modal">save Sponsor</button>
                </div>
            </form>
        </div>
    </div>
</div>
