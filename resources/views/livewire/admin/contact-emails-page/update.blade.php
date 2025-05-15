<!-- Update Email Modal -->
<div wire:ignore.self class="modal fade" id="updateEmailModal" tabindex="-1" role="dialog" aria-labelledby="updateEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="updateEmailModalLabel">Update Email</h5>
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
                        <p><strong>Email:</strong> {{ $email }}</p>
                        <p><strong>Recipient:</strong> {{ $recipient }}</p>
                        <p><strong>Subject:</strong> {{ $subject }}</p>
                        <p><strong>Message:</strong></p>
                        <div class="border p-2 bg-light">{{ $message }}</div>
                        <p><strong>Spam:</strong> {{ $spam ? 'Yes' : 'No' }}</p>
                        <p><strong>Status:</strong> {{ optional($statuses->firstWhere('id', $status_id))->name }}</p>
                    </div>
                @endif

                {{-- Edit Section --}}
                @if($showEditSection)
                    <form>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" wire:model="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="recipient">Recipient</label>
                            <input type="email" class="form-control" id="recipient" wire:model="recipient">
                            @error('recipient') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" wire:model="subject">
                            @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea rows="5" class="form-control" id="message" wire:model="message"></textarea>
                            @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="status_id">Status</label>
                            <select class="form-control" id="status_id" wire:model="status_id">
                                <option value="">-- Select Status --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="spam">Spam</label>
                            <select class="form-control" id="spam" wire:model="spam">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            @error('spam') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </form>
                @endif
            </div>

            <div class="modal-footer">
                @if(!$showEditSection)
                    <button wire:click.prevent="enableEditSection" class="btn btn-primary">Edit</button>
                    <button wire:click.prevent="cancel" data-dismiss="modal" class="btn btn-secondary">Close</button>
                @else
                    <button wire:click.prevent="updateEmail" class="btn btn-success">Save</button>
                    <button wire:click.prevent="disableEditSection" class="btn btn-danger">Cancel Edit</button>
                @endif
            </div>

        </div>
    </div>
</div>
