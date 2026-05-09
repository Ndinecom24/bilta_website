<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact Emails</h1>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateEmail ? 'View / Update Email' : 'Send / Reply Email' }}</h5>
                    @if ($updateEmail)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    @if ($updateEmail && !$showEditSection)
                        <div class="border rounded p-3 mb-3 bg-light">
                            <p class="mb-2"><strong>Email:</strong> {{ $email }}</p>
                            <p class="mb-2"><strong>Recipient:</strong> {{ $recipient }}</p>
                            <p class="mb-2"><strong>Subject:</strong> {{ $subject }}</p>
                            <p class="mb-2"><strong>Message:</strong></p>
                            <div class="border rounded bg-white p-2 mb-2">{{ $message }}</div>
                            <p class="mb-2"><strong>Spam:</strong> {{ $spam ? 'Yes' : 'No' }}</p>
                            <p class="mb-0"><strong>Status:</strong> {{ optional($statuses->firstWhere('id', $status_id))->name }}</p>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button wire:click.prevent="enableEditSection" class="btn btn-primary" type="button">Edit</button>
                            <button wire:click.prevent="cancel" class="btn btn-outline-danger" type="button">Close</button>
                        </div>
                    @else
                        <form wire:submit.prevent="{{ $updateEmail ? 'updateEmail' : 'sendEmail' }}">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <label class="font-weight-bold" for="contactRecipient">Recipient</label>
                                    <input id="contactRecipient" type="email" class="form-control" wire:model.defer="recipient" placeholder="Enter recipient email">
                                    @error('recipient') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-6 col-md-12 mb-3">
                                    <label class="font-weight-bold" for="contactSubject">Subject</label>
                                    <input id="contactSubject" type="text" class="form-control" wire:model.defer="subject" placeholder="Enter subject">
                                    @error('subject') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-12 col-md-12 mb-3">
                                    <label class="font-weight-bold" for="contactMessage">Message</label>
                                    <textarea id="contactMessage" rows="4" class="form-control" wire:model.defer="message" placeholder="Enter message"></textarea>
                                    @error('message') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                @if ($updateEmail)
                                    <div class="col-lg-6 col-md-12 mb-3">
                                        <label class="font-weight-bold" for="contactEmail">Email</label>
                                        <input id="contactEmail" type="email" class="form-control" wire:model.defer="email">
                                        @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label class="font-weight-bold" for="contactStatus">Status</label>
                                        <select id="contactStatus" class="form-control" wire:model.defer="status_id">
                                            <option value="">-- Select Status --</option>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-lg-3 col-md-12 mb-3">
                                        <label class="font-weight-bold" for="contactSpam">Spam</label>
                                        <select id="contactSpam" class="form-control" wire:model.defer="spam">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                        @error('spam') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">{{ $updateEmail ? 'Save Email Changes' : 'Send Email' }}</button>
                                @if ($updateEmail)
                                    <button wire:click.prevent="disableEditSection" type="button" class="btn btn-outline-warning">Cancel Edit</button>
                                    <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Close</button>
                                @endif
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Contact Emails</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Received At</th>
                                    <th style="width: 170px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($emails) > 0)
                                    @foreach ($emails as $emailRow)
                                        <tr>
                                            <td>
                                                @if ($emailRow->spam)
                                                    <span class="badge bg-danger text-white">Spam</span>
                                                @else
                                                    <span class="badge bg-success text-white">Okay</span>
                                                @endif
                                            </td>
                                            <td>{{ $emailRow->name }}</td>
                                            <td>{{ $emailRow->email }}</td>
                                            <td>{{ $emailRow->subject }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($emailRow->message, 140) }}</td>
                                            <td>{{ $emailRow->created_at }}</td>
                                            <td>
                                                <button wire:click="edit({{ $emailRow->id }})" class="btn btn-primary btn-sm">View</button>
                                                <button onclick="deleteEmail({{ $emailRow->id }})" class="btn btn-danger btn-sm">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No Emails Found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $emails->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteEmail(id) {
            if (confirm("Are you sure to delete this email?"))
                window.livewire.emit('deleteEmail', id);
        }
    </script>
</div>
