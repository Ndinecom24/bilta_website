<!-- Update OurSponsor Modal -->
<div wire:ignore.self class="modal fade" id="updateOurSponsorModal" tabindex="-1" role="dialog" aria-labelledby="updateOurSponsorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="updateOurSponsorModalLabel">Update Our Sponsor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="cancel">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Alert messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                @endif

                {{-- View Section --}}
                @if(!$showEditSection)
                    <div>
                        @if ($oursponsor && $oursponsor->getFirstMedia('sponsor_image'))
                        <img 
                            src="{{ $oursponsor->getFirstMedia('sponsor_image')->getUrl() }}"
                            style="width:100%; height:60px"
                            website_url="{{ $oursponsor->getFirstMedia('sponsor_image')->name }}">
                    @endif
                        <p><strong>Name:</strong> {{ $name }}</p>
                        <p><strong>Title:</strong> {{ $website_url }}</p>
                        <p><strong>Sponsor:</strong></p>
                        <div class="border p-2 bg-light">{{ $description }}</div>
                        <p><strong>Status:</strong> {{ optional($statuses->firstWhere('id', $status_id))->name }}</p>
                    </div>
                @endif

                {{-- Edit Section --}}
                @if($showEditSection)
                    <form>
                        

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label for="contactUsFormControlInput10">Image</label>
                                    <input type="file" class="form-control" id="contactUsFormControlInput10"
                                           placeholder="Enter Image" wire:model="sponsor_image_update">
                                    @error('sponsor_image_update') <span class="text-danger ">{{ $description }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="recipient">Name</label>
                            <input type="chairmansmessage" class="form-control" id="recipient" wire:model="name">
                            @error('recipient') <span class="text-danger">{{ $description }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="subject">Website URL</label>
                            <input type="text" class="form-control" id="subject" wire:model="website_url">
                            @error('subject') <span class="text-danger">{{ $description }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="message">Description</label>
                            <textarea rows="5" class="form-control" id="message" wire:model="description"></textarea>
                            @error('message') <span class="text-danger">{{ $description }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="status_id">Status</label>
                            <select class="form-control" id="status_id" wire:model="status_id">
                                <option value="">-- Select Status --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id') <span class="text-danger">{{ $description }}</span> @enderror
                        </div>

                        
                    </form>
                @endif
            </div>

            <div class="modal-footer">
                @if(!$showEditSection)
                    <button wire:click.prevent="enableEditSection" class="btn btn-primary">Edit</button>
                    <button wire:click.prevent="cancel" data-dismiss="modal" class="btn btn-secondary">Close</button>
                @else
                    <button wire:click.prevent="updateOurSponsor" class="btn btn-success">Save</button>
                    <button wire:click.prevent="disableEditSection" class="btn btn-danger">Cancel Edit</button>
                @endif
            </div>

        </div>
    </div>
</div>
