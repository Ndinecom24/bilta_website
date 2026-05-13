<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">FAQs</h1>
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
                    <h5 class="mb-0">{{ $updateFAQs ? 'Edit FAQ' : 'Add FAQ' }}</h5>
                    @if ($updateFAQs)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateFAQs ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 mb-3">
                                <label class="font-weight-bold" for="faqQuestion">Question</label>
                                <input id="faqQuestion" type="text" class="form-control" wire:model.defer="question" placeholder="Enter question">
                                @error('question') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            @if ($supportsStatusColumn)
                                <div class="col-lg-4 col-md-12 mb-3">
                                    <label class="font-weight-bold" for="faqStatus">Status</label>
                                    <select id="faqStatus" class="form-control" wire:model.defer="status_id">
                                        <option value="">-- Select Status --</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="faqAnswer">Answer</label>
                                <textarea id="faqAnswer" rows="4" class="form-control" wire:model.defer="answer" placeholder="Enter answer"></textarea>
                                @error('answer') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateFAQs ? 'Update FAQ' : 'Save FAQ' }}</button>
                            @if ($updateFAQs)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Frequently Asked Questions</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:300px;">Question</th>
                                    <th>Answer</th>
                                    @if ($supportsStatusColumn)
                                        <th style="width:130px;">Status</th>
                                    @endif
                                    <th style="width:160px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($faqs as $faq)
                                    <tr>
                                        <td>{{ $faq->question }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($faq->answer, 220) }}</td>
                                        @if ($supportsStatusColumn)
                                            <td>{{ $faq->status->name ?? '-' }}</td>
                                        @endif
                                        <td>
                                            <button wire:click="edit({{ $faq->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteFAQ({{ $faq->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $supportsStatusColumn ? 4 : 3 }}" class="text-center">No FAQs found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $faqs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        function deleteFAQ(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteFAQ', id);
        }
    </script>



</div>
