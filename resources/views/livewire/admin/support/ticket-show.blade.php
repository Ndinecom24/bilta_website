<div>
    @php
        $eventLabels = [
            'created' => ['fa-plus-circle', 'Ticket submitted'],
            'status_changed' => ['fa-exchange-alt', 'Status changed'],
            'assigned' => ['fa-user-check', 'Assigned'],
            'comment' => ['fa-comment', 'Comment added'],
            'internal_note' => ['fa-user-secret', 'Internal note'],
            'clarification_requested' => ['fa-question-circle', 'Clarification requested'],
            'priority_changed' => ['fa-flag', 'Priority changed'],
            'due_date_changed' => ['fa-calendar-alt', 'Due date changed'],
            'estimate_changed' => ['fa-hourglass-half', 'Estimate changed'],
            'documentation_updated' => ['fa-file-alt', 'Documentation updated'],
            'work_logged' => ['fa-clock', 'Work logged'],
            'attachment_added' => ['fa-paperclip', 'File attached'],
            'billing_reviewed' => ['fa-file-invoice-dollar', 'Billing reviewed'],
        ];
    @endphp

    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <div>
            <a href="{{ $isStaff ? route('admin.support.all') : route('admin.support.my') }}" class="small text-muted">
                <i class="fas fa-arrow-left"></i> Back to tickets
            </a>
            <h1 class="h3 mb-0 text-gray-800 mt-1">
                {{ $ticket->reference }}
                <span class="badge bg-{{ $ticket->status_color }} text-white align-middle" style="font-size: .5em;">{{ $ticket->status_label }}</span>
                @if ($ticket->isOverdue())
                    <span class="badge bg-danger text-white align-middle" style="font-size: .5em;">Overdue</span>
                @endif
                @if ($ticket->reopen_count > 0)
                    <span class="badge bg-secondary text-white align-middle" style="font-size: .5em;">Reopened {{ $ticket->reopen_count }}x</span>
                @endif
            </h1>
        </div>
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
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <div class="row">
        {{-- ============ LEFT: ticket + conversation ============ --}}
        <div class="col-lg-8">

            {{-- Ticket --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0 font-weight-bold">{{ $ticket->subject }}</h5>
                    <small class="text-muted">
                        Submitted by {{ $ticket->submitter->name ?? 'a removed user' }} on {{ $ticket->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
                <div class="card-body">
                    <div style="white-space: pre-wrap; word-break: break-word;">{{ $ticket->description }}</div>

                    @if ($initialAttachments->count())
                        <hr>
                        <div class="small font-weight-bold mb-1"><i class="fas fa-paperclip"></i> Attachments</div>
                        @include('livewire.admin.support.partials.attachments', ['attachments' => $initialAttachments])
                    @endif
                </div>
            </div>

            {{-- Resolution --}}
            @if ($ticket->resolution_notes && in_array($ticket->status, ['resolved', 'closed']))
                <div class="card border-left-success shadow-sm mb-4">
                    <div class="card-body">
                        <div class="font-weight-bold text-success mb-1"><i class="fas fa-check-circle"></i> Resolution</div>
                        <div style="white-space: pre-wrap; word-break: break-word;">{{ $ticket->resolution_notes }}</div>
                        @if ($ticket->resolved_at)
                            <small class="text-muted d-block mt-2">Resolved {{ $ticket->resolved_at->format('d M Y, H:i') }}</small>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Owner confirmation --}}
            @if ($canClose || $canReopen)
                <div class="card border-left-warning shadow-sm mb-4">
                    <div class="card-body">
                        @if ($ticket->status === 'resolved')
                            <div class="font-weight-bold mb-2">Is your issue resolved?</div>
                            <p class="small text-muted mb-3">Please confirm to close this ticket, or reopen it if the problem is not fixed.</p>
                        @else
                            <div class="font-weight-bold mb-2">This ticket is closed</div>
                            <p class="small text-muted mb-3">You can reopen it if the problem came back.</p>
                        @endif

                        <div class="d-flex flex-wrap align-items-start">
                            @if ($canClose)
                                <button class="btn btn-success mr-3 mb-2" wire:click="closeTicket" wire:loading.attr="disabled">
                                    <i class="fas fa-check"></i> Confirm &amp; Close
                                </button>
                            @endif
                            @if ($canReopen)
                                <div class="flex-grow-1" style="min-width: 260px;">
                                    <textarea class="form-control mb-2" rows="2" wire:model.defer="reopenReason" placeholder="Why does this need to be reopened?"></textarea>
                                    <button class="btn btn-outline-danger btn-sm" wire:click="reopenTicket" wire:loading.attr="disabled">
                                        <i class="fas fa-undo"></i> Reopen Ticket
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Conversation --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-comments mr-1"></i> Conversation ({{ $comments->count() }})</h6></div>
                <div class="card-body">
                    @forelse ($comments as $comment)
                        @php
                            $mine = (int) $comment->user_id === (int) auth()->id();
                            $border = $comment->is_internal ? 'warning' : ($comment->is_clarification_request ? 'info' : ($mine ? 'primary' : 'secondary'));
                        @endphp
                        <div class="mb-3 p-3 rounded border-left border-{{ $border }}" style="border-left-width: 4px !important; background: {{ $comment->is_internal ? '#fff8e6' : '#f8f9fc' }};">
                            <div class="d-flex justify-content-between">
                                <div class="font-weight-bold">
                                    {{ $comment->author->name ?? 'Removed user' }}
                                    @if ($comment->is_internal)
                                        <span class="badge bg-warning text-dark">Internal note</span>
                                    @endif
                                    @if ($comment->is_clarification_request)
                                        <span class="badge bg-info text-white">Clarification requested</span>
                                    @endif
                                </div>
                                <small class="text-muted" title="{{ $comment->created_at->format('d M Y, H:i') }}">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="mt-1" style="white-space: pre-wrap; word-break: break-word;">{{ $comment->body }}</div>
                            @if ($comment->attachments->count())
                                <div class="mt-2">
                                    @include('livewire.admin.support.partials.attachments', ['attachments' => $comment->attachments])
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted mb-0">No messages yet.</p>
                    @endforelse

                    @if ($canComment)
                        <hr>
                        <form wire:submit.prevent="postComment">
                            @if ($isStaff)
                                <div class="mb-2">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ct-public" class="custom-control-input" value="public" wire:model="commentType">
                                        <label class="custom-control-label" for="ct-public">Reply to submitter</label>
                                    </div>
                                    @if ($canWork)
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="ct-clar" class="custom-control-input" value="clarification" wire:model="commentType">
                                            <label class="custom-control-label" for="ct-clar">Request clarification</label>
                                        </div>
                                    @endif
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="ct-int" class="custom-control-input" value="internal" wire:model="commentType">
                                        <label class="custom-control-label" for="ct-int">Internal note (staff only)</label>
                                    </div>
                                </div>
                            @endif

                            <textarea class="form-control mb-2" rows="3" wire:model.defer="commentBody" maxlength="10000"
                                      placeholder="{{ $commentType === 'internal' ? 'Only support staff can read this note...' : ($commentType === 'clarification' ? 'What information do you need from the submitter?' : 'Write a message...') }}"></textarea>

                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="mb-2">
                                    <input type="file" class="form-control-file" wire:model="commentFiles" multiple>
                                    <div wire:loading wire:target="commentFiles" class="small text-muted">Uploading...</div>
                                    @if (count($commentFiles))
                                        <div class="small mt-1">
                                            @foreach ($commentFiles as $f)
                                                <div><i class="fas fa-paperclip text-muted"></i> {{ $f->getClientOriginalName() }}</div>
                                            @endforeach
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0" wire:click="clearCommentFiles">Remove all</button>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary mb-2" wire:loading.attr="disabled" wire:target="postComment,commentFiles">
                                    <i class="fas fa-paper-plane"></i> {{ $commentType === 'clarification' ? 'Send request' : ($commentType === 'internal' ? 'Add note' : 'Send') }}
                                </button>
                            </div>
                        </form>
                    @else
                        <hr>
                        <p class="small text-muted mb-0">This ticket is closed. Reopen it to continue the conversation.</p>
                    @endif
                </div>
            </div>

            {{-- Work log (staff only) --}}
            @if ($isStaff)
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bold"><i class="fas fa-clock mr-1"></i> Work Log</h6>
                        <small class="text-muted">
                            Estimated {{ $estimated !== null ? rtrim(rtrim(number_format($estimated, 2), '0'), '.') . 'h' : '-' }}
                            &middot; Actual {{ rtrim(rtrim(number_format($actual, 2), '0'), '.') ?: '0' }}h
                            &middot; Billable (approved) {{ rtrim(rtrim(number_format($billable, 2), '0'), '.') ?: '0' }}h
                        </small>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="thead-light">
                                <tr><th>Date</th><th>Developer</th><th>Type</th><th class="text-right">Hours</th><th>Description</th><th>Billing</th></tr>
                            </thead>
                            <tbody>
                                @forelse ($workLogs as $log)
                                    <tr>
                                        <td class="text-nowrap">{{ $log->work_date->format('d M Y') }}</td>
                                        <td>{{ $log->developer->name ?? '-' }}</td>
                                        <td>{{ $log->work_type_label }}</td>
                                        <td class="text-right">{{ rtrim(rtrim(number_format($log->hours, 2), '0'), '.') }}</td>
                                        <td style="white-space: pre-wrap; word-break: break-word;">{{ $log->description }}</td>
                                        <td class="text-nowrap">
                                            @if ($log->billing_status === 'approved')
                                                <span class="badge bg-success text-white">Approved {{ rtrim(rtrim(number_format($log->billable_hours, 2), '0'), '.') }}h</span>
                                            @elseif ($log->billing_status === 'non_billable')
                                                <span class="badge bg-secondary text-white">Non-billable</span>
                                            @else
                                                <span class="badge bg-light text-dark border">Unreviewed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-3">No work logged yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        {{-- ============ RIGHT: details + actions + history ============ --}}
        <div class="col-lg-4">

            <div class="card shadow-sm mb-4">
                <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-info-circle mr-1"></i> Details</h6></div>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Status</span><span class="badge bg-{{ $ticket->status_color }} text-white">{{ $ticket->status_label }}</span></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Priority</span><span class="badge bg-{{ $ticket->priority->color ?? 'secondary' }} text-white">{{ $ticket->priority->name ?? '-' }}</span></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Category</span><span>{{ $ticket->category->name ?? '-' }}</span></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Module</span><span>{{ $ticket->system->name ?? '-' }}</span></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Submitted by</span><span>{{ $ticket->submitter->name ?? '-' }}</span></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Assigned to</span><span>{{ $ticket->assignee->name ?? 'Unassigned' }}</span></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Due date</span><span class="{{ $ticket->isOverdue() ? 'text-danger font-weight-bold' : '' }}">{{ $ticket->due_date ? $ticket->due_date->format('d M Y') : '-' }}</span></li>
                    <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Created</span><span>{{ $ticket->created_at->format('d M Y') }}</span></li>
                    @if ($ticket->acknowledged_at)<li class="list-group-item d-flex justify-content-between"><span class="text-muted">Acknowledged</span><span>{{ $ticket->acknowledged_at->format('d M Y') }}</span></li>@endif
                    @if ($ticket->started_at)<li class="list-group-item d-flex justify-content-between"><span class="text-muted">Work started</span><span>{{ $ticket->started_at->format('d M Y') }}</span></li>@endif
                    @if ($ticket->resolved_at)<li class="list-group-item d-flex justify-content-between"><span class="text-muted">Resolved</span><span>{{ $ticket->resolved_at->format('d M Y') }}</span></li>@endif
                    @if ($ticket->closed_at)<li class="list-group-item d-flex justify-content-between"><span class="text-muted">Closed</span><span>{{ $ticket->closed_at->format('d M Y') }}</span></li>@endif
                </ul>
            </div>

            {{-- Staff: accept / assign --}}
            @if ($canAccept || $canAssign)
                <div class="card shadow-sm mb-4">
                    <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-user-check mr-1"></i> Assignment</h6></div>
                    <div class="card-body">
                        @if ($canAccept)
                            <button class="btn btn-success btn-block mb-2" wire:click="acceptTicket" wire:loading.attr="disabled">
                                <i class="fas fa-hand-paper"></i> Accept this ticket
                            </button>
                        @endif
                        @if ($canAssign)
                            <label class="small font-weight-bold mb-1">{{ $ticket->assigned_to ? 'Reassign to' : 'Assign to' }}</label>
                            <div class="input-group">
                                <select class="custom-select" wire:model.defer="assigneeId">
                                    <option value="">Select developer...</option>
                                    @foreach ($developers as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" wire:click="assignTicket" wire:loading.attr="disabled">Assign</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Developer workspace --}}
            @if ($canWork)
                <div class="card shadow-sm mb-4">
                    <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-tools mr-1"></i> Developer Actions</h6></div>
                    <div class="card-body">

                        @if (count($manualStatuses))
                            <label class="small font-weight-bold mb-1">Change status</label>
                            <select class="custom-select custom-select-sm mb-2" wire:model.defer="newStatus">
                                <option value="">Select new status...</option>
                                @foreach ($manualStatuses as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control form-control-sm mb-2" wire:model.defer="statusNote" placeholder="Note / reason (required for On Hold)" maxlength="2000">
                            <button class="btn btn-sm btn-outline-primary mb-3" wire:click="changeStatus" wire:loading.attr="disabled">Update status</button>
                            <hr class="mt-0">
                        @endif

                        <div class="small font-weight-bold mb-1">Planning</div>
                        <div class="form-group mb-2">
                            <label class="small mb-0">Priority</label>
                            <select class="custom-select custom-select-sm" wire:model.defer="priority_id">
                                @foreach ($priorities as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6 mb-2">
                                <label class="small mb-0">Due date</label>
                                <input type="date" class="form-control form-control-sm" wire:model.defer="due_date">
                            </div>
                            <div class="form-group col-6 mb-2">
                                <label class="small mb-0">Estimate (hours)</label>
                                <input type="number" step="0.25" min="0" class="form-control form-control-sm" wire:model.defer="estimated_hours">
                            </div>
                        </div>

                        <div class="small font-weight-bold mb-1 mt-2">Documentation</div>
                        <div class="form-group mb-2">
                            <label class="small mb-0">Technical findings <span class="text-muted">(staff only)</span></label>
                            <textarea class="form-control form-control-sm" rows="3" wire:model.defer="technical_findings"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small mb-0">Resolution notes <span class="text-muted">(visible to submitter)</span></label>
                            <textarea class="form-control form-control-sm" rows="3" wire:model.defer="resolution_notes"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small mb-0">Outstanding requirements <span class="text-muted">(staff only)</span></label>
                            <textarea class="form-control form-control-sm" rows="2" wire:model.defer="outstanding_requirements"></textarea>
                        </div>

                        <button class="btn btn-sm btn-primary" wire:click="saveDetails" wire:loading.attr="disabled">
                            <i class="fas fa-save"></i> Save details
                        </button>
                        @if ($canResolve)
                            <button class="btn btn-sm btn-success" wire:click="resolveTicket" wire:loading.attr="disabled"
                                    onclick="if (!confirm('Mark this ticket as resolved? The submitter will be asked to confirm.')) { event.stopImmediatePropagation(); }">
                                <i class="fas fa-check-circle"></i> Mark resolved
                            </button>
                        @endif
                    </div>
                </div>

                @if ($canLogWork)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-stopwatch mr-1"></i> Log Work</h6></div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-6 mb-2">
                                    <label class="small mb-0">Date</label>
                                    <input type="date" class="form-control form-control-sm" wire:model.defer="work_date" max="{{ now()->toDateString() }}">
                                </div>
                                <div class="form-group col-6 mb-2">
                                    <label class="small mb-0">Hours</label>
                                    <input type="number" class="form-control form-control-sm" step="{{ config('support.hours_step') }}" min="{{ config('support.hours_step') }}" max="24" wire:model.defer="work_hours" placeholder="e.g. 1.5">
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label class="small mb-0">Type of work</label>
                                <select class="custom-select custom-select-sm" wire:model.defer="work_type">
                                    @foreach ($workTypes as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label class="small mb-0">What was done</label>
                                <textarea class="form-control form-control-sm" rows="2" wire:model.defer="work_description" maxlength="2000"></textarea>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="work_billable" wire:model.defer="work_billable">
                                <label class="custom-control-label small" for="work_billable">Proposed as billable</label>
                            </div>
                            <button class="btn btn-sm btn-primary" wire:click="logWork" wire:loading.attr="disabled">
                                <i class="fas fa-plus"></i> Add entry
                            </button>
                            <small class="d-block text-muted mt-2">Billing is reviewed separately and does not change the hours recorded.</small>
                        </div>
                    </div>
                @endif
            @endif

            {{-- History --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-history mr-1"></i> History</h6></div>
                <div class="card-body small" style="max-height: 460px; overflow-y: auto;">
                    @foreach ($events->reverse() as $event)
                        @php
                            $meta = $eventLabels[$event->event] ?? ['fa-circle', ucfirst(str_replace('_', ' ', $event->event))];
                        @endphp
                        <div class="d-flex mb-3">
                            <div class="mr-2 text-primary" style="width: 18px;"><i class="fas {{ $meta[0] }}"></i></div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold">
                                    {{ $meta[1] }}
                                    @if ($event->from_value !== null || $event->to_value !== null)
                                        <span class="font-weight-normal">
                                            @if ($event->event === 'status_changed')
                                                {{ \App\Models\Support\Ticket::STATUSES[$event->from_value]['label'] ?? $event->from_value }}
                                                &rarr;
                                                {{ \App\Models\Support\Ticket::STATUSES[$event->to_value]['label'] ?? $event->to_value }}
                                            @elseif ($event->event === 'work_logged')
                                                {{ $event->to_value }}h
                                            @else
                                                {{ $event->from_value ?? '-' }} &rarr; {{ $event->to_value ?? '-' }}
                                            @endif
                                        </span>
                                    @endif
                                </div>
                                @if ($event->note)
                                    <div class="text-muted" style="word-break: break-word;">{{ \Illuminate\Support\Str::limit($event->note, 160) }}</div>
                                @endif
                                <div class="text-muted">{{ $event->actor->name ?? 'System' }} &middot; {{ $event->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
