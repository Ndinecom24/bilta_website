<!-- ChairmansMessage Modal -->
<div wire:ignore.self class="modal fade" id="createChairmansMessageModal" tabindex="-1" role="dialog" aria-labelledby="chairmansmessageModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="chairmansmessageModalLabel">Create / Reply to Chairmans Message</h5>
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
                                <label for="chairmansmessageRecipient">Chaimans Name</label>
                                <input type="chairmansmessage" class="form-control" id="chairmansmessageRecipient" placeholder="Enter Chairmans name" wire:model="name">
                                @error('recipient') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="chairmansmessageSubject">Chairmans Message Title</label>
                                <input type="text" class="form-control" id="chairmansmessageSubject" placeholder="Enter Message Title" wire:model="title">
                                @error('subject') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="chairmansmessageBody">Chairmans Message</label>
                                <textarea rows="5" class="form-control" id="chairmansmessageBody" wire:model="message" placeholder="Enter Chairmans message here"></textarea>
                                @error('message') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="contactUsFormControlInput10">Image</label>
                                <input type="file" class="form-control" id="contactUsFormControlInput10"
                                       placeholder="Enter Image" wire:model="intro_image">
                                @error('intro_image') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="saveChairmansMessage()" class="btn btn-primary close-modal">save Message</button>
                </div>
            </form>
        </div>
    </div>
</div>
