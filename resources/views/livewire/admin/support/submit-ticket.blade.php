<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Submit a Support Ticket</h1>
        <a href="{{ route('admin.support.my') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"></i> My Tickets
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-life-ring mr-1"></i> Tell us what you need</h6></div>
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="form-group">
                            <label class="font-weight-bold" for="subject">Subject <span class="text-danger">*</span></label>
                            <input type="text" id="subject" class="form-control @error('subject') is-invalid @enderror"
                                   wire:model.defer="subject" maxlength="200" placeholder="Short summary of the issue or request">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold" for="category_id">Category <span class="text-danger">*</span></label>
                                <select id="category_id" class="form-control @error('category_id') is-invalid @enderror" wire:model.defer="category_id">
                                    <option value="">Select category...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold" for="system_id">System / Module</label>
                                <select id="system_id" class="form-control @error('system_id') is-invalid @enderror" wire:model.defer="system_id">
                                    <option value="">Not sure / not applicable</option>
                                    @foreach ($systems as $system)
                                        <option value="{{ $system->id }}">{{ $system->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold" for="priority_id">Priority <span class="text-danger">*</span></label>
                            <select id="priority_id" class="form-control @error('priority_id') is-invalid @enderror" wire:model.defer="priority_id">
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->name }} &mdash; target {{ $priority->resolution_target_hours >= 48 ? round($priority->resolution_target_hours / 24) . ' days' : $priority->resolution_target_hours . ' hours' }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">The support team may adjust the priority after reviewing your ticket.</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold" for="description">Description <span class="text-danger">*</span></label>
                            <textarea id="description" rows="7" class="form-control @error('description') is-invalid @enderror"
                                      wire:model.defer="description" maxlength="10000"
                                      placeholder="What happened? What did you expect? Which page were you on? Steps to reproduce..."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold" for="attachments">Attachments</label>
                            <input type="file" id="attachments" class="form-control-file" wire:model="attachments" multiple>
                            <div wire:loading wire:target="attachments" class="small text-muted mt-1">Uploading...</div>
                            @if (count($attachments))
                                <ul class="list-unstyled small mt-2 mb-1">
                                    @foreach ($attachments as $file)
                                        <li><i class="fas fa-paperclip text-muted"></i> {{ $file->getClientOriginalName() }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn btn-sm btn-link text-danger p-0" wire:click="clearAttachments">Remove all</button>
                            @endif
                            <small class="form-text text-muted">
                                Up to {{ config('support.attachments.max_files') }} files, {{ round(config('support.attachments.max_kb') / 1024) }} MB each.
                                Allowed: {{ strtoupper(implode(', ', config('support.attachments.mimes'))) }}.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="submit,attachments">
                            <span wire:loading.remove wire:target="submit"><i class="fas fa-paper-plane"></i> Submit Ticket</span>
                            <span wire:loading wire:target="submit"><i class="fas fa-spinner fa-spin"></i> Submitting...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-lightbulb mr-1"></i> Tips for a quick fix</h6></div>
                <div class="card-body small">
                    <ul class="pl-3 mb-0">
                        <li>Say exactly where the problem happens (page or menu).</li>
                        <li>Include the steps that lead to the problem.</li>
                        <li>Attach a screenshot or the error message when you can.</li>
                        <li>Never include passwords in a ticket.</li>
                        <li>You will receive an email each time the status changes.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
