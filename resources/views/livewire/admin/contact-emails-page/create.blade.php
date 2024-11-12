<!-- Email Modal -->
<div wire:ignore.self class="modal fade" id="createEmailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="emailModalLabel">Create / Reply to Email</h5>
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
                                <label for="emailRecipient">Recipient</label>
                                <input type="email" class="form-control" id="emailRecipient" placeholder="Enter Recipient Email" wire:model="recipient">
                                @error('recipient') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="emailSubject">Subject</label>
                                <input type="text" class="form-control" id="emailSubject" placeholder="Enter Email Subject" wire:model="subject">
                                @error('subject') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="emailBody">Message</label>
                                <textarea rows="5" class="form-control" id="emailBody" wire:model="message" placeholder="Enter your message here"></textarea>
                                @error('message') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="sendEmail()" class="btn btn-primary close-modal">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>
