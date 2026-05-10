<div>
    {{-- BiLTA Form Custom Styles --}}
    <style>
        .bilta-form-header {
            background: linear-gradient(135deg, #d27a22 0%, #7f5224 100%);
            color: white;
            padding: 1.2rem 1.5rem;
            text-align: center;
            border-radius: 12px 12px 0 0;
            border-bottom: 4px solid #f3b33d;
        }
        .bilta-form-header h2 { font-size: 1.3rem; font-weight: 700; margin-bottom: 0.15rem; }
        .bilta-form-header .tagline {
            font-style: italic; font-weight: 500;
            background: rgba(255,255,240,0.15);
            display: inline-block; padding: 0.15rem 0.8rem;
            border-radius: 40px; font-size: 0.8rem;
        }
        .bilta-form-header .address { font-size: 0.72rem; margin-top: 8px; opacity: 0.9; }
        .bilta-section {
            border: 1px solid #e2e8f0; border-radius: 14px;
            padding: 1rem 1.2rem 1.5rem; margin-bottom: 1.2rem;
            background: #fff;
        }
        .bilta-section-title {
            font-size: 1.05rem; font-weight: 700; color: #1e4a3b;
            border-left: 5px solid #f3b33d; padding-left: 12px;
            margin-bottom: 1rem;
        }
        .bilta-entitlement-grid {
            background: #f9fafb; padding: 0.8rem 1rem;
            border-radius: 12px; margin-bottom: 0.8rem;
        }
        .bilta-acting-section {
            background-color: #fef9e8;
            border-left: 4px solid #f3b33d;
            border-radius: 12px; padding: 1rem 1.2rem;
        }
        .bilta-note {
            background: #f1f5f9; padding: 0.8rem 1rem;
            border-radius: 10px; font-size: 0.78rem; color: #2d3e50;
        }
        .bilta-leave-check { display: inline-flex; align-items: center; gap: 0.4rem; margin-right: 1rem; margin-bottom: 0.5rem; }
        .bilta-leave-check input[type="radio"] { accent-color: #1e4a3b; width: 1rem; height: 1rem; }
        .bilta-leave-check label { font-weight: 500; font-size: 0.85rem; cursor: pointer; margin-bottom: 0; }
    </style>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Leave Applications</h1>
        <button wire:click="toggleForm" class="btn btn-{{ $showForm ? 'outline-secondary' : 'primary' }}">
            <i class="fas fa-{{ $showForm ? 'times' : 'plus' }}"></i>
            {{ $showForm ? 'Close Form' : 'Apply for Leave' }}
        </button>
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

        {{-- Leave Balances Summary --}}
        @if ($balances->count())
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">My Leave Balance ({{ date('Y') }})</h5></div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($balances as $balance)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                            <div class="card border-left-{{ $balance->remaining > 0 ? 'success' : 'danger' }} h-100">
                                <div class="card-body py-2 px-3">
                                    <div class="font-weight-bold text-primary small">{{ $balance->leaveType->name ?? '-' }}</div>
                                    <div class="h5 mb-0">{{ $balance->remaining }} <small class="text-muted">/ {{ $balance->total_days + $balance->carried_over }} days</small></div>
                                    <small class="text-muted">Used: {{ $balance->used_days }} | Carried: {{ $balance->carried_over }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ============================================================
             BiLTA LEAVE APPLICATION FORM (matches physical form)
        ============================================================= --}}
        @if ($showForm)
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm" style="border-radius: 14px; overflow: hidden;">
                <div class="bilta-form-header">
                    <h2>BIBLE AND LITERATURE TRANSLATION ASSOCIATION</h2>
                    <div class="tagline">(BiLTA) — Leave Days Application Form</div>
                    <div class="address">
                        Plot 324, Flat No.2 Bauhinia Avenue, Off Great-East Rd - Chelstone |
                        www.bilta.org | P.O.BOX G27 LUSAKA, ZAMBIA
                    </div>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <form wire:submit.prevent="store">

                        {{-- SECTION 1: Employee Information (read-only from profile) --}}
                        <div class="bilta-section">
                            <h5 class="bilta-section-title"><i class="fas fa-user"></i> EMPLOYEE INFORMATION</h5>
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <label class="font-weight-bold small">EMPLOYEE NAME</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <label class="font-weight-bold small">POSITION</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->position ?? '—' }}" readonly>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <label class="font-weight-bold small">DEPARTMENT</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->department_name }}" readonly>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="font-weight-bold small">PHONE NUMBER</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->phone ?? '—' }}" readonly>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="font-weight-bold small">NRC #</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->nrc ?? '—' }}" readonly>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="font-weight-bold small">MAN NUMBER</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->man_number ?? '—' }}" readonly>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="font-weight-bold small">EMAIL</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->email }}" readonly>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="font-weight-bold small">SUPERVISOR</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->supervisor->name ?? '—' }}" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 2: Leave Application & Entitlement --}}
                        <div class="bilta-section">
                            <h5 class="bilta-section-title"><i class="fas fa-calendar-alt"></i> LEAVE APPLICATION & ENTITLEMENT</h5>
                            <div class="bilta-entitlement-grid">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 mb-2">
                                        <label class="font-weight-bold small">START DATE *</label>
                                        <input type="date" class="form-control" wire:model="start_date">
                                        @error('start_date') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 mb-2">
                                        <label class="font-weight-bold small">END DATE *</label>
                                        <input type="date" class="form-control" wire:model="end_date">
                                        @error('end_date') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 mb-2">
                                        <label class="font-weight-bold small">NO. OF WORKING DAYS</label>
                                        <input type="text" class="form-control bg-light font-weight-bold" value="{{ $days_requested }}" readonly>
                                    </div>
                                    <div class="col-lg-3 col-md-6 mb-2">
                                        <label class="font-weight-bold small">RESUME WORK ON</label>
                                        <input type="date" class="form-control" wire:model.defer="resume_date">
                                        <small class="text-muted">Auto-calculated, adjustable</small>
                                    </div>
                                </div>
                            </div>
                            {{-- Entitlement summary from balances --}}
                            @if ($balances->count())
                            <div class="bilta-entitlement-grid mt-2">
                                <div class="row">
                                    @foreach ($balances as $bal)
                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-1">
                                        <small class="font-weight-bold text-muted">{{ $bal->leaveType->name ?? '-' }}</small>
                                        <div>
                                            <span class="badge bg-primary text-white">Total: {{ $bal->total_days + $bal->carried_over }}</span>
                                            <span class="badge bg-warning text-dark">Taken: {{ $bal->used_days }}</span>
                                            <span class="badge bg-{{ $bal->remaining > 0 ? 'success' : 'danger' }} text-white">Balance: {{ $bal->remaining }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- SECTION 3: Leave Type (radio selection matching physical form) --}}
                        <div class="bilta-section">
                            <h5 class="bilta-section-title"><i class="fas fa-clipboard-list"></i> LEAVE TYPE (tick where applicable) *</h5>
                            <div class="d-flex flex-wrap align-items-start">
                                @foreach ($leaveTypes as $type)
                                    <div class="bilta-leave-check">
                                        <input type="radio" wire:model="leave_type_id" value="{{ $type->id }}" id="lt_{{ $type->id }}">
                                        <label for="lt_{{ $type->id }}">{{ strtoupper($type->name) }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('leave_type_id') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror

                            {{-- Show "specify" field if "Others" is selected --}}
                            @php
                                $othersType = $leaveTypes->firstWhere('slug', 'others');
                            @endphp
                            @if ($othersType && $leave_type_id == $othersType->id)
                            <div class="mt-2" style="max-width: 400px;">
                                <label class="font-weight-bold small">Please specify leave type:</label>
                                <input type="text" class="form-control form-control-sm" wire:model.defer="other_leave_type_text" placeholder="e.g. Family event, Conference">
                                @error('other_leave_type_text') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                            </div>
                            @endif

                            {{-- Document requirement hint --}}
                            @php $selectedType = $leaveTypes->firstWhere('id', $leave_type_id); @endphp
                            @if ($selectedType && $selectedType->requires_document)
                            <div class="bilta-note mt-2">
                                <i class="fas fa-info-circle text-warning"></i>
                                <strong>{{ $selectedType->name }}</strong> requires a supporting document (medical certificate, sick note, etc.).
                            </div>
                            @endif
                        </div>

                        {{-- SECTION 4: Reason / Purpose --}}
                        <div class="bilta-section">
                            <h5 class="bilta-section-title"><i class="fas fa-pen"></i> PURPOSE / REASON FOR LEAVE *</h5>
                            <textarea class="form-control" wire:model.defer="reason" rows="3" placeholder="State your reason for leave application (min 10 characters)"></textarea>
                            @error('reason') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                        </div>

                        {{-- SECTION 5: Acting Arrangement --}}
                        <div class="bilta-section bilta-acting-section">
                            <h5 class="bilta-section-title"><i class="fas fa-exchange-alt"></i> ACTING ARRANGEMENT</h5>
                            <p class="small text-muted mb-2">If you are a Team Leader (TA) or Deputy Team Leader (D/TA), please designate the staff who will act on your behalf during your absence.</p>
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <label class="font-weight-bold small">NAME OF ACTING STAFF</label>
                                    <select class="form-control" wire:model.defer="acting_user_id"
                                            onchange="let u = this.options[this.selectedIndex]; document.getElementById('actingCell').value = u.dataset.phone || ''; @this.set('acting_cell', u.dataset.phone || ''); @this.set('acting_name', u.dataset.name || '');">
                                        <option value="">— Select Staff —</option>
                                        @foreach ($allUsers as $u)
                                            <option value="{{ $u->id }}" data-phone="{{ $u->phone }}" data-name="{{ $u->name }}">{{ $u->name }}{{ $u->position ? ' — '.$u->position : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <label class="font-weight-bold small">PHONE (ACTING)</label>
                                    <input type="tel" id="actingCell" class="form-control" wire:model.defer="acting_cell" placeholder="0977xxxxxx">
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <label class="font-weight-bold small">ACTING POSITION</label>
                                    <select class="form-control" wire:model.defer="acting_position">
                                        <option value="">— Not Applicable —</option>
                                        <option value="Team Leader (TA)">Team Leader (TA)</option>
                                        <option value="Deputy Team Leader (D/TA)">Deputy Team Leader (D/TA)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 6: Supporting Documents --}}
                        <div class="bilta-section">
                            <h5 class="bilta-section-title"><i class="fas fa-paperclip"></i> SUPPORTING DOCUMENTS</h5>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 mb-2">
                                    <label class="font-weight-bold small">Attach medical certificate / sick note / supporting document:</label>
                                    <input type="file" class="form-control" wire:model="document">
                                    <small class="text-muted">PDF, JPG, PNG, DOC — max 5MB</small>
                                    @error('document') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                    <div wire:loading wire:target="document" class="text-info small mt-1">Uploading...</div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 7: Declaration --}}
                        <div class="bilta-section" style="background: #f8faf9;">
                            <h5 class="bilta-section-title"><i class="fas fa-check-double"></i> APPLICANT DECLARATION</h5>
                            <p class="small mb-2">I wish to apply for leave as stated above. The information provided is accurate and I understand this application will follow the organisation's approval workflow.</p>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="font-weight-bold small">SIGNED BY (Applicant)</label>
                                    <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="font-weight-bold small">DATE</label>
                                    <input type="text" class="form-control bg-light" value="{{ date('d M Y') }}" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Important Notes --}}
                        <div class="bilta-note mb-3">
                            <strong><i class="fas fa-exclamation-triangle text-warning"></i> IMPORTANT:</strong><br>
                            &bull; This application must be endorsed by your immediate supervisor before submitting to HR.<br>
                            &bull; All forms must be submitted at least <strong>3 working days</strong> before the leave start date.<br>
                            &bull; Please attach medical certificates or sick notes for Sick Leave / Hospitalisation Leave.<br>
                            &bull; The application will follow the configured approval workflow automatically.
                        </div>

                        {{-- Submit --}}
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <button wire:click.prevent="toggleForm" type="button" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <button type="submit" class="btn text-white" style="background: #1e4a3b; font-weight: 700; border-radius: 40px; padding: 0.6rem 2rem;" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="store"><i class="fas fa-paper-plane"></i> Submit Leave Application</span>
                                <span wire:loading wire:target="store"><i class="fas fa-spinner fa-spin"></i> Submitting...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- My Applications Table --}}
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">My Applications</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Resume</th>
                                    <th>Days</th>
                                    <th>Current Stage</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($applications as $app)
                                    <tr>
                                        <td>
                                            {{ $app->leaveType->name ?? '-' }}
                                            @if ($app->other_leave_type_text)
                                                <br><small class="text-muted">({{ $app->other_leave_type_text }})</small>
                                            @endif
                                        </td>
                                        <td>{{ $app->start_date->format('d M Y') }}</td>
                                        <td>{{ $app->end_date->format('d M Y') }}</td>
                                        <td>{{ $app->resume_date ? $app->resume_date->format('d M Y') : '—' }}</td>
                                        <td>{{ $app->days_requested }}</td>
                                        <td>
                                            @if ($app->currentStage)
                                                <span class="badge bg-info text-white">{{ $app->currentStage->name }}</span>
                                            @elseif ($app->status === 'approved')
                                                <span class="badge bg-success text-white">All stages complete</span>
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
                                            @if ($app->status === 'pending')
                                                <button wire:click="cancelApplication({{ $app->id }})" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Cancel this application?')">Cancel</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">You have no leave applications yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $applications->links() }}</div>
                </div>
            </div>
        </div>

        {{-- ============================================================
             APPLICATION DETAIL + WORKFLOW PROGRESS + AUDIT TRAIL
        ============================================================= --}}
        @if ($viewingApplication)
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm" style="border-radius: 14px; overflow: hidden;">
                <div class="bilta-form-header" style="text-align: left; padding: 1rem 1.5rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 style="font-size: 1.1rem;">Leave Application Details</h2>
                            <span class="tagline" style="font-size: 0.75rem;">Ref #{{ $viewingApplication->id }} — {{ $viewingApplication->created_at->format('d M Y') }}</span>
                        </div>
                        <button wire:click="closeView" class="btn btn-sm btn-light">Close</button>
                    </div>
                </div>
                <div class="card-body" style="padding: 1.5rem;">

                    {{-- Employee Info --}}
                    <div class="bilta-section">
                        <h5 class="bilta-section-title"><i class="fas fa-user"></i> EMPLOYEE INFORMATION</h5>
                        <div class="row">
                            <div class="col-md-4 mb-1"><small class="text-muted">Name</small><div class="font-weight-bold">{{ $viewingApplication->user->name ?? '-' }}</div></div>
                            <div class="col-md-4 mb-1"><small class="text-muted">Position</small><div>{{ $viewingApplication->user->position ?? '—' }}</div></div>
                            <div class="col-md-4 mb-1"><small class="text-muted">Department</small><div>{{ $viewingApplication->user->department_name ?? '—' }}</div></div>
                            <div class="col-md-3 mb-1"><small class="text-muted">Phone</small><div>{{ $viewingApplication->user->phone ?? '—' }}</div></div>
                            <div class="col-md-3 mb-1"><small class="text-muted">NRC #</small><div>{{ $viewingApplication->user->nrc ?? '—' }}</div></div>
                            <div class="col-md-3 mb-1"><small class="text-muted">MAN Number</small><div>{{ $viewingApplication->user->man_number ?? '—' }}</div></div>
                            <div class="col-md-3 mb-1"><small class="text-muted">Email</small><div>{{ $viewingApplication->user->email ?? '—' }}</div></div>
                        </div>
                    </div>

                    {{-- Leave Details --}}
                    <div class="bilta-section">
                        <h5 class="bilta-section-title"><i class="fas fa-calendar-alt"></i> LEAVE DETAILS</h5>
                        <div class="row">
                            <div class="col-md-3 mb-1"><small class="text-muted">Leave Type</small><div class="font-weight-bold">{{ $viewingApplication->leaveType->name ?? '-' }}</div>
                                @if ($viewingApplication->other_leave_type_text)
                                    <small class="text-muted">({{ $viewingApplication->other_leave_type_text }})</small>
                                @endif
                            </div>
                            <div class="col-md-2 mb-1"><small class="text-muted">Start Date</small><div>{{ $viewingApplication->start_date->format('d M Y') }}</div></div>
                            <div class="col-md-2 mb-1"><small class="text-muted">End Date</small><div>{{ $viewingApplication->end_date->format('d M Y') }}</div></div>
                            <div class="col-md-2 mb-1"><small class="text-muted">Working Days</small><div class="font-weight-bold">{{ $viewingApplication->days_requested }}</div></div>
                            <div class="col-md-3 mb-1"><small class="text-muted">Resume Work On</small><div>{{ $viewingApplication->resume_date ? $viewingApplication->resume_date->format('d M Y') : '—' }}</div></div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">Reason</small>
                            <div class="border rounded bg-light p-2 mt-1">{{ $viewingApplication->reason }}</div>
                        </div>
                        @if ($viewingApplication->document_path)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $viewingApplication->document_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-paperclip"></i> View Attached Document
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- Acting Arrangement --}}
                    @if ($viewingApplication->acting_name)
                    <div class="bilta-section bilta-acting-section">
                        <h5 class="bilta-section-title"><i class="fas fa-exchange-alt"></i> ACTING ARRANGEMENT</h5>
                        <div class="row">
                            <div class="col-md-4 mb-1"><small class="text-muted">Acting Staff</small><div>{{ $viewingApplication->acting_name }}</div></div>
                            <div class="col-md-4 mb-1"><small class="text-muted">Phone</small><div>{{ $viewingApplication->acting_cell ?? '—' }}</div></div>
                            <div class="col-md-4 mb-1"><small class="text-muted">Position</small><div>{{ $viewingApplication->acting_position ?? '—' }}</div></div>
                        </div>
                    </div>
                    @endif

                    {{-- Status --}}
                    <div class="bilta-section">
                        <h5 class="bilta-section-title"><i class="fas fa-info-circle"></i> STATUS</h5>
                        <p>
                            @if ($viewingApplication->status === 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2">Pending Approval</span>
                            @elseif ($viewingApplication->status === 'approved')
                                <span class="badge bg-success text-white px-3 py-2">Fully Approved</span>
                            @elseif ($viewingApplication->status === 'rejected')
                                <span class="badge bg-danger text-white px-3 py-2">Rejected</span>
                            @else
                                <span class="badge bg-secondary text-white px-3 py-2">Cancelled</span>
                            @endif
                        </p>
                    </div>

                    {{-- Workflow Pipeline --}}
                    @if ($viewingApplication->workflow)
                    <div class="bilta-section">
                        <h5 class="bilta-section-title"><i class="fas fa-project-diagram"></i> APPROVAL WORKFLOW — {{ $viewingApplication->workflow->name }}</h5>
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
                            <p class="text-muted small mt-1">Currently awaiting: <strong>{{ $viewingApplication->currentStage->name }}</strong></p>
                        @endif
                    </div>
                    @endif

                    {{-- Approval Audit Trail --}}
                    @if ($viewingApplication->approvalHistory->count())
                    <div class="bilta-section">
                        <h5 class="bilta-section-title"><i class="fas fa-history"></i> APPROVAL HISTORY (Audit Trail)</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Stage</th>
                                        <th>Action</th>
                                        <th>By</th>
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

                    {{-- ===== APPROVE / REJECT ACTION PANEL ===== --}}

                    
                    @if ($viewingApplication->status === 'pending' && $viewingApplication->currentStage && auth()->user()->roles->contains('id', $viewingApplication->currentStage->role_id))
                    <div class="bilta-section" style="border: 2px solid #1e4a3b; background: #f0fdf4;">
                        <h5 class="bilta-section-title"><i class="fas fa-gavel"></i> YOUR ACTION REQUIRED — {{ $viewingApplication->currentStage->name }}</h5>
                        <p class="small text-muted mb-2">You have the role <strong>{{ $viewingApplication->currentStage->role->name ?? '-' }}</strong> required to act on this application at the current stage. Please review all details above before making your decision.</p>

                        <div class="mb-3">
                            <label class="font-weight-bold small">REASON / COMMENT FOR YOUR DECISION *</label>
                            <textarea class="form-control" wire:model.defer="reviewComment" rows="3" placeholder="Provide your reason for approving or rejecting this application (required)"></textarea>
                            @error('reviewComment') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button wire:click="submitReview('approved')" class="btn btn-success px-4"
                                    onclick="return confirm('Are you sure you want to APPROVE this leave application?')">
                                <i class="fas fa-check-circle"></i> Approve Application
                            </button>
                            <button wire:click="submitReview('rejected')" class="btn btn-danger px-4"
                                    onclick="return confirm('Are you sure you want to REJECT this leave application?')">
                                <i class="fas fa-times-circle"></i> Reject Application
                            </button>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @endif
    </div>
</div>
