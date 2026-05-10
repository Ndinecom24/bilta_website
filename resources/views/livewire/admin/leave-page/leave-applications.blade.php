<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Leave Applications</h1>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        {{-- Stats Cards --}}
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Approved ({{ date('Y') }})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Rejected ({{ date('Y') }})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total ({{ date('Y') }})</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-2">
                            <label class="font-weight-bold">Status</label>
                            <select class="form-control" wire:model="filterStatus">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="font-weight-bold">Year</label>
                            <select class="form-control" wire:model="filterYear">
                                <option value="">All Years</option>
                                @for ($y = date('Y'); $y >= date('Y') - 3; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="font-weight-bold">Employee</label>
                            <select class="form-control" wire:model="filterUser">
                                <option value="">All Employees</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button wire:click="clearFilters" class="btn btn-outline-secondary btn-block">Clear Filters</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      
        {{-- View Detail --}}
        @if ($viewingApplication)
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: #0b3b2f; color: white;">
                    <h5 class="mb-0" style="color: white;"><i class="fas fa-file-alt"></i> Application Details — Ref #{{ $viewingApplication->id }}</h5>
                    <button wire:click="closeView" class="btn btn-sm btn-light">Close</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Employee Information --}}
                        <div class="col-md-12 mb-3">
                            <h6 class="font-weight-bold" style="color: #1e4a3b; border-left: 4px solid #f3b33d; padding-left: 10px;">
                                <i class="fas fa-user"></i> EMPLOYEE INFORMATION
                            </h6>
                            <div class="row mt-2">
                                <div class="col-md-3 mb-1"><small class="text-muted">Name</small><div class="font-weight-bold">{{ $viewingApplication->user->name ?? '-' }}</div></div>
                                <div class="col-md-3 mb-1"><small class="text-muted">Position</small><div>{{ $viewingApplication->user->position ?? '—' }}</div></div>
                                <div class="col-md-3 mb-1"><small class="text-muted">Department</small><div>{{ $viewingApplication->user->department_name ?? '—' }}</div></div>
                                <div class="col-md-3 mb-1"><small class="text-muted">Email</small><div>{{ $viewingApplication->user->email ?? '-' }}</div></div>
                                <div class="col-md-3 mb-1"><small class="text-muted">Phone</small><div>{{ $viewingApplication->user->phone ?? '—' }}</div></div>
                                <div class="col-md-3 mb-1"><small class="text-muted">NRC #</small><div>{{ $viewingApplication->user->nrc ?? '—' }}</div></div>
                                <div class="col-md-3 mb-1"><small class="text-muted">MAN Number</small><div>{{ $viewingApplication->user->man_number ?? '—' }}</div></div>
                            </div>
                        </div>
                        <div class="col-md-12"><hr class="mt-0"></div>

                        {{-- Leave Details --}}
                        <div class="col-md-12 mb-3">
                            <h6 class="font-weight-bold" style="color: #1e4a3b; border-left: 4px solid #f3b33d; padding-left: 10px;">
                                <i class="fas fa-calendar-alt"></i> LEAVE DETAILS
                            </h6>
                            <div class="row mt-2">
                                <div class="col-md-3 mb-1">
                                    <small class="text-muted">Leave Type</small>
                                    <div class="font-weight-bold">{{ $viewingApplication->leaveType->name ?? '-' }}</div>
                                    @if ($viewingApplication->other_leave_type_text)
                                        <small class="text-muted">({{ $viewingApplication->other_leave_type_text }})</small>
                                    @endif
                                </div>
                                <div class="col-md-2 mb-1"><small class="text-muted">Start Date</small><div>{{ $viewingApplication->start_date->format('d M Y') }}</div></div>
                                <div class="col-md-2 mb-1"><small class="text-muted">End Date</small><div>{{ $viewingApplication->end_date->format('d M Y') }}</div></div>
                                <div class="col-md-2 mb-1"><small class="text-muted">Working Days</small><div class="font-weight-bold">{{ $viewingApplication->days_requested }}</div></div>
                                <div class="col-md-3 mb-1"><small class="text-muted">Resume Work On</small><div>{{ $viewingApplication->resume_date ? $viewingApplication->resume_date->format('d M Y') : '—' }}</div></div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-12 mb-2">
                            <p><strong>Status:</strong>
                                @if ($viewingApplication->status === 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2">Pending Approval</span>
                                @elseif ($viewingApplication->status === 'approved')
                                    <span class="badge bg-success text-white px-3 py-2">Fully Approved</span>
                                @elseif ($viewingApplication->status === 'rejected')
                                    <span class="badge bg-danger text-white px-3 py-2">Rejected</span>
                                @else
                                    <span class="badge bg-secondary text-white px-3 py-2">Cancelled</span>
                                @endif
                                &nbsp; <small class="text-muted">Submitted: {{ $viewingApplication->created_at->format('d M Y H:i') }}</small>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p><strong>Reason:</strong></p>
                            <div class="border rounded bg-light p-3 mb-2">{{ $viewingApplication->reason }}</div>
                        </div>

                        {{-- Acting Arrangement --}}
                        @if ($viewingApplication->acting_name)
                        <div class="col-md-12 mb-3">
                            <hr>
                            <h6 class="font-weight-bold" style="color: #1e4a3b; border-left: 4px solid #f3b33d; padding-left: 10px;">
                                <i class="fas fa-exchange-alt"></i> ACTING ARRANGEMENT
                            </h6>
                            <div class="row mt-2" style="background: #fef9e8; border-radius: 10px; padding: 10px;">
                                <div class="col-md-4 mb-1"><small class="text-muted">Acting Staff</small><div>{{ $viewingApplication->acting_name }}</div></div>
                                <div class="col-md-4 mb-1"><small class="text-muted">Phone</small><div>{{ $viewingApplication->acting_cell ?? '—' }}</div></div>
                                <div class="col-md-4 mb-1"><small class="text-muted">Position</small><div>{{ $viewingApplication->acting_position ?? '—' }}</div></div>
                            </div>
                        </div>
                        @endif

                        @if ($viewingApplication->document_path)
                        <div class="col-md-12 mb-2">
                            <p><strong>Attached Document:</strong>
                                <a href="{{ asset('storage/' . $viewingApplication->document_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i> View Document
                                </a>
                            </p>
                        </div>
                        @endif

                        {{-- Workflow Progress --}}
                        @if ($viewingApplication->workflow)
                        <div class="col-md-12 mt-3">
                            <hr>
                            <h6 class="font-weight-bold"><i class="fas fa-project-diagram"></i> Workflow Progress — {{ $viewingApplication->workflow->name }}</h6>
                            <div class="d-flex flex-wrap align-items-center gap-2 my-2">
                                @foreach ($viewingApplication->workflow->stages as $stg)
                                    @php
                                        $historyForStage = $viewingApplication->approvalHistory->where('stage_id', $stg->id)->last();
                                        $isCurrent = $viewingApplication->current_stage_id == $stg->id;
                                        if ($historyForStage && $historyForStage->action === 'approved') {
                                            $badgeClass = 'bg-success text-white';
                                            $icon = 'fa-check-circle';
                                        } elseif ($historyForStage && $historyForStage->action === 'rejected') {
                                            $badgeClass = 'bg-danger text-white';
                                            $icon = 'fa-times-circle';
                                        } elseif ($isCurrent) {
                                            $badgeClass = 'bg-warning text-dark';
                                            $icon = 'fa-hourglass-half';
                                        } else {
                                            $badgeClass = 'bg-light text-muted border';
                                            $icon = 'fa-circle';
                                        }
                                    @endphp
                                    <div class="text-center" style="min-width:120px;">
                                        <span class="badge {{ $badgeClass }} px-3 py-2 d-block">
                                            <i class="fas {{ $icon }} mr-1"></i>
                                            {{ $stg->stage_order }}. {{ $stg->name }}
                                        </span>
                                        <small class="text-muted d-block mt-1" style="font-size:.72rem;">
                                            @if ($historyForStage)
                                                <i class="fas fa-user-check"></i> {{ $historyForStage->actor->name ?? 'Unknown' }}
                                            @elseif ($stg->role && $stg->role->users->count())
                                                @foreach ($stg->role->users as $approver)
                                                    <span class="d-block"><i class="fas fa-user"></i> {{ $approver->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">{{ $stg->role->name ?? 'No role' }}</span>
                                            @endif
                                        </small>
                                    </div>
                                    @if (!$loop->last)
                                        <i class="fas fa-arrow-right text-muted align-self-start mt-3"></i>
                                    @endif
                                @endforeach
                            </div>

                            @if ($viewingApplication->currentStage)
                                <p class="text-muted small">Currently at: <strong>{{ $viewingApplication->currentStage->name }}</strong> ({{ $viewingApplication->currentStage->role->name ?? '-' }})</p>
                            @endif
                        </div>
                        @endif

                        {{-- Approval Audit Trail --}}
                        @if ($viewingApplication->approvalHistory->count())
                        <div class="col-md-12 mt-3">
                            <hr>
                            <h6 class="font-weight-bold"><i class="fas fa-history"></i> Approval History</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Stage</th>
                                            <th>Action</th>
                                            <th>Acted By</th>
                                            <th>Comment</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($viewingApplication->approvalHistory as $hist)
                                            <tr>
                                                <td>{{ $hist->stage->name ?? '-' }}</td>
                                                <td>
                                                    @if ($hist->action === 'approved')
                                                        <span class="badge bg-success text-white">Approved</span>
                                                    @elseif ($hist->action === 'rejected')
                                                        <span class="badge bg-danger text-white">Rejected</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">{{ ucfirst($hist->action) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $hist->actor->name ?? '-' }}</td>
                                                <td>{{ $hist->comment ?? '—' }}</td>
                                                <td>{{ $hist->created_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        @if ($viewingApplication->reviewed_by && !$viewingApplication->workflow)
                        <div class="col-md-12">
                            <hr>
                            <p><strong>Reviewed By:</strong> {{ $viewingApplication->reviewer->name ?? '-' }}</p>
                            <p><strong>Reviewed At:</strong> {{ $viewingApplication->reviewed_at?->format('d M Y H:i') ?? '-' }}</p>
                            @if ($viewingApplication->review_comment)
                            <p><strong>Comment:</strong> {{ $viewingApplication->review_comment }}</p>
                            @endif
                        </div>
                        @endif

                       
                    </div>


  @if ($viewingApplication->status === 'pending' && $viewingApplication->currentStage && auth()->user()->roles->contains('id', $viewingApplication->currentStage->role_id))
                                                <button wire:click="startReview({{ $viewingApplication->id }}, 'approved')" class="btn btn-success btn-sm">Approve</button>
                                                <button wire:click="startReview({{ $viewingApplication->id }}, 'rejected')" class="btn btn-danger btn-sm">Reject</button>
                                            @endif 

          

                </div>
            </div>
        </div>

                    {{-- Review Modal --}}
        @if ($reviewingId)
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-{{ $reviewAction === 'approved' ? 'success' : 'danger' }}">
                <div class="card-header bg-{{ $reviewAction === 'approved' ? 'success' : 'danger' }} text-white">
                    <h5 class="mb-0">{{ $reviewAction === 'approved' ? 'Approve' : 'Reject' }} Leave Application #{{ $reviewingId }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="font-weight-bold">Comment (optional)</label>
                        <textarea class="form-control" wire:model.defer="reviewComment" rows="3" placeholder="Add a comment for the applicant..."></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button wire:click="submitReview" class="btn btn-{{ $reviewAction === 'approved' ? 'success' : 'danger' }}  m-1" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submitReview">Confirm {{ ucfirst($reviewAction) }}</span>
                            <span wire:loading wire:target="submitReview"><i class="fas fa-spinner fa-spin"></i> Processing...</span>
                        </button>
                        <button wire:click="cancelReview" class="btn btn-outline-secondary m-1" wire:loading.attr="disabled" wire:target="submitReview">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @endif

        {{-- Applications Table --}}
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">All Leave Applications</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Leave Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Days</th>
                                    <th>Current Stage</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th style="width: 250px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($applications as $app)
                                    <tr>
                                        <td>{{ $app->user->name ?? '-' }}</td>
                                        <td>{{ $app->leaveType->name ?? '-' }}</td>
                                        <td>{{ $app->start_date->format('d M Y') }}</td>
                                        <td>{{ $app->end_date->format('d M Y') }}</td>
                                        <td>{{ $app->days_requested }}</td>
                                        <td>
                                            @if ($app->currentStage)
                                                <span class="badge bg-info text-white">{{ $app->currentStage->name }}</span>
                                                <br><small class="text-muted">{{ $app->currentStage->role->name ?? '' }}</small>
                                            @elseif ($app->status === 'approved')
                                                <span class="badge bg-success text-white">Completed</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($app->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif ($app->status === 'approved')
                                                <span class="badge bg-success text-white">Approved</span>
                                            @elseif ($app->status === 'rejected')
                                                <span class="badge bg-danger text-white">Rejected</span>
                                            @else
                                                <span class="badge bg-secondary text-white">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>{{ $app->created_at->format('d M Y') }}</td>
                                        <td>
                                            <button wire:click="viewApplication({{ $app->id }})" class="btn btn-info btn-sm">View</button>
                                           
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Leave Applications Found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $applications->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteLeaveApplication(id) {
            if (confirm("Are you sure you want to delete this application?"))
                window.livewire.emit('deleteLeaveApplication', id);
        }
    </script>
</div>
