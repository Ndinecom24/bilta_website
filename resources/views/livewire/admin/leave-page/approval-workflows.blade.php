<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Approval Workflows</h1>
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

        {{-- Workflow Form --}}
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $editingWorkflow ? 'Edit Workflow' : 'Create Workflow' }}</h5>
                    @if ($editingWorkflow)
                        <button wire:click="cancelEditWorkflow" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $editingWorkflow ? 'updateWorkflow' : 'storeWorkflow' }}">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Workflow Name</label>
                                <input type="text" class="form-control" wire:model.defer="name" placeholder="e.g. Leave Approval Workflow">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Form Type</label>
                                <select class="form-control" wire:model.defer="form_type">
                                    <option value="leave">Leave Application</option>
                                </select>
                                @error('form_type') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Status</label>
                                <select class="form-control" wire:model.defer="is_active">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label class="font-weight-bold">Description</label>
                                <textarea rows="2" class="form-control" wire:model.defer="description" placeholder="Optional description"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ $editingWorkflow ? 'Update' : 'Save Workflow' }}</button>
                        @if ($editingWorkflow)
                            <button wire:click.prevent="cancelEditWorkflow" class="btn btn-outline-danger">Cancel</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- Workflows Table --}}
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Workflows</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Form Type</th>
                                    <th>Stages</th>
                                    <th>Status</th>
                                    <th style="width: 280px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($workflows as $wf)
                                    <tr>
                                        <td>
                                            <strong>{{ $wf->name }}</strong>
                                            @if ($wf->description)
                                                <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($wf->description, 80) }}</small>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-info text-white">{{ ucfirst($wf->form_type) }}</span></td>
                                        <td><span class="badge bg-primary text-white">{{ $wf->stages_count }} stages</span></td>
                                        <td>
                                            @if ($wf->is_active)
                                                <span class="badge bg-success text-white">Active</span>
                                            @else
                                                <span class="badge bg-secondary text-white">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="manageStages({{ $wf->id }})" class="btn btn-info btn-sm">
                                                <i class="fas fa-cogs"></i> Stages
                                            </button>
                                            <button wire:click="editWorkflow({{ $wf->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button wire:click="toggleActive({{ $wf->id }})" class="btn btn-{{ $wf->is_active ? 'warning' : 'success' }} btn-sm">
                                                {{ $wf->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                            <button onclick="deleteWorkflow({{ $wf->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No workflows defined yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $workflows->links() }}</div>
                </div>
            </div>
        </div>

        {{-- Stage Manager --}}
        @if ($managingWorkflow)
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-project-diagram"></i> Stages for: {{ $managingWorkflow->name }}</h5>
                    <button wire:click="closeStages" class="btn btn-sm btn-light">Close</button>
                </div>
                <div class="card-body">

                    {{-- Visual Pipeline --}}
                    @if ($workflowStages->count())
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-muted mb-2">Approval Pipeline</h6>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary text-white px-3 py-2">Applicant Submits</span>
                            </div>
                            @foreach ($workflowStages as $stg)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-arrow-right text-muted mx-2"></i>
                                    <span class="badge px-3 py-2 {{ $stg->is_start ? 'bg-info text-white' : ($stg->is_end ? 'bg-success text-white' : 'bg-warning text-dark') }}">
                                        {{ $stg->stage_order }}. {{ $stg->name }}
                                        <small>({{ $stg->role->name ?? '-' }})</small>
                                        @if ($stg->is_start) <i class="fas fa-play-circle ml-1"></i> @endif
                                        @if ($stg->is_end) <i class="fas fa-flag-checkered ml-1"></i> @endif
                                    </span>
                                </div>
                            @endforeach
                            <div class="d-flex align-items-center">
                                <i class="fas fa-arrow-right text-muted mx-2"></i>
                                <span class="badge bg-success text-white px-3 py-2"><i class="fas fa-check-double"></i> Fully Approved</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Stage Form --}}
                    <div class="border rounded bg-light p-3 mb-3">
                        <h6 class="font-weight-bold">{{ $editingStageId ? 'Edit Stage' : 'Add Stage' }}</h6>
                        <form wire:submit.prevent="{{ $editingStageId ? 'updateStage' : 'storeStage' }}">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="font-weight-bold small">Stage Name</label>
                                    <input type="text" class="form-control form-control-sm" wire:model.defer="stage_name" placeholder="e.g. Line Manager Approval">
                                    @error('stage_name') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-3 col-md-6 mb-2">
                                    <label class="font-weight-bold small">Approving Role</label>
                                    <select class="form-control form-control-sm" wire:model.defer="stage_role_id">
                                        <option value="">-- Select Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('stage_role_id') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-2 col-md-4 mb-2">
                                    <label class="font-weight-bold small">Order</label>
                                    <input type="number" class="form-control form-control-sm" wire:model.defer="stage_order" min="1">
                                    @error('stage_order') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-2 col-md-4 mb-2">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" wire:model.defer="stage_is_start" id="stageStart">
                                        <label class="form-check-label font-weight-bold small" for="stageStart">Start Stage</label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 mb-2">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" wire:model.defer="stage_is_end" id="stageEnd">
                                        <label class="form-check-label font-weight-bold small" for="stageEnd">Final Stage</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-1">{{ $editingStageId ? 'Update Stage' : 'Add Stage' }}</button>
                            @if ($editingStageId)
                                <button wire:click.prevent="cancelEditStage" class="btn btn-sm btn-outline-danger mt-1">Cancel</button>
                            @endif
                        </form>
                    </div>

                    {{-- Stages Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Stage Name</th>
                                    <th>Approving Role</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th style="width: 140px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($workflowStages as $stg)
                                    <tr>
                                        <td><span class="badge bg-primary text-white">{{ $stg->stage_order }}</span></td>
                                        <td>{{ $stg->name }}</td>
                                        <td>{{ $stg->role->name ?? '-' }}</td>
                                        <td>{!! $stg->is_start ? '<span class="badge bg-info text-white">START</span>' : '-' !!}</td>
                                        <td>{!! $stg->is_end ? '<span class="badge bg-success text-white">FINAL</span>' : '-' !!}</td>
                                        <td>
                                            <button wire:click="editStage({{ $stg->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteStage({{ $stg->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No stages defined. Add at least one stage.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        function deleteWorkflow(id) {
            if (confirm("Delete this workflow and all its stages?"))
                window.livewire.emit('deleteWorkflow', id);
        }
        function deleteStage(id) {
            if (confirm("Delete this stage?"))
                window.livewire.emit('deleteStage', id);
        }
    </script>
</div>
