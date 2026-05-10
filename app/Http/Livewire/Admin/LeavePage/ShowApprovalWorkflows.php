<?php

namespace App\Http\Livewire\Admin\LeavePage;

use App\Models\Bilta\ApprovalWorkflow;
use App\Models\Bilta\ApprovalWorkflowStage;
use App\Models\System\Role;
use Livewire\Component;
use Livewire\WithPagination;

class ShowApprovalWorkflows extends Component
{
    use WithPagination;

    // Workflow form
    public $workflowId, $name, $form_type = 'leave', $description, $is_active = true;
    public $editingWorkflow = false;

    // Stages
    public $stages = [];
    public $managingWorkflowId = null;

    // Stage form
    public $stage_name, $stage_role_id, $stage_order, $stage_is_start = false, $stage_is_end = false;
    public $editingStageId = null;

    protected $listeners = ['deleteWorkflow' => 'destroyWorkflow', 'deleteStage' => 'destroyStage'];

    protected function workflowRules()
    {
        return [
            'name' => 'required|string|max:255',
            'form_type' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
        ];
    }

    protected function stageRules()
    {
        return [
            'stage_name' => 'required|string|max:255',
            'stage_role_id' => 'required|exists:roles,id',
            'stage_order' => 'required|integer|min:1',
        ];
    }

    public function render()
    {
        $workflows = ApprovalWorkflow::withCount('stages')->orderBy('created_at', 'desc')->paginate(10);
        $roles = Role::orderBy('name')->get();

        $managingWorkflow = null;
        $workflowStages = collect();
        if ($this->managingWorkflowId) {
            $managingWorkflow = ApprovalWorkflow::find($this->managingWorkflowId);
            $workflowStages = ApprovalWorkflowStage::where('workflow_id', $this->managingWorkflowId)
                ->with('role')
                ->orderBy('stage_order')
                ->get();
        }

        return view('livewire.admin.leave-page.approval-workflows', compact(
            'workflows', 'roles', 'managingWorkflow', 'workflowStages'
        ));
    }

    /* =======================
       WORKFLOW CRUD
    ======================== */

    public function storeWorkflow()
    {
        $this->validate($this->workflowRules());

        try {
            ApprovalWorkflow::create([
                'name' => $this->name,
                'form_type' => $this->form_type,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('success', 'Workflow created successfully!');
            $this->resetWorkflowForm();
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating workflow.');
        }
    }

    public function editWorkflow($id)
    {
        $w = ApprovalWorkflow::findOrFail($id);
        $this->workflowId = $w->id;
        $this->name = $w->name;
        $this->form_type = $w->form_type;
        $this->description = $w->description;
        $this->is_active = $w->is_active;
        $this->editingWorkflow = true;
    }

    public function updateWorkflow()
    {
        $this->validate($this->workflowRules());

        try {
            $w = ApprovalWorkflow::findOrFail($this->workflowId);
            $w->update([
                'name' => $this->name,
                'form_type' => $this->form_type,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            session()->flash('success', 'Workflow updated successfully!');
            $this->resetWorkflowForm();
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating workflow.');
        }
    }

    public function destroyWorkflow($id)
    {
        try {
            ApprovalWorkflow::find($id)?->delete();
            if ($this->managingWorkflowId == $id) {
                $this->managingWorkflowId = null;
            }
            session()->flash('success', 'Workflow deleted.');
        } catch (\Exception $e) {
            session()->flash('error', 'Cannot delete workflow with active applications.');
        }
    }

    public function toggleActive($id)
    {
        $w = ApprovalWorkflow::findOrFail($id);
        $w->update(['is_active' => !$w->is_active]);
    }

    public function resetWorkflowForm()
    {
        $this->workflowId = null;
        $this->name = '';
        $this->form_type = 'leave';
        $this->description = '';
        $this->is_active = true;
        $this->editingWorkflow = false;
    }

    /* =======================
       STAGE MANAGEMENT
    ======================== */

    public function manageStages($workflowId)
    {
        $this->managingWorkflowId = $workflowId;
        $this->resetStageForm();
    }

    public function closeStages()
    {
        $this->managingWorkflowId = null;
        $this->resetStageForm();
    }

    public function storeStage()
    {
        $this->validate($this->stageRules());

        // Check unique stage_order within workflow
        $exists = ApprovalWorkflowStage::where('workflow_id', $this->managingWorkflowId)
            ->where('stage_order', $this->stage_order)
            ->when($this->editingStageId, fn($q) => $q->where('id', '!=', $this->editingStageId))
            ->exists();

        if ($exists) {
            $this->addError('stage_order', 'A stage with this order already exists in this workflow.');
            return;
        }

        try {
            ApprovalWorkflowStage::create([
                'workflow_id' => $this->managingWorkflowId,
                'name' => $this->stage_name,
                'role_id' => $this->stage_role_id,
                'stage_order' => $this->stage_order,
                'is_start' => $this->stage_is_start,
                'is_end' => $this->stage_is_end,
            ]);

            $this->autoFixStartEnd();
            session()->flash('success', 'Stage added successfully!');
            $this->resetStageForm();
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding stage.');
        }
    }

    public function editStage($id)
    {
        $s = ApprovalWorkflowStage::findOrFail($id);
        $this->editingStageId = $s->id;
        $this->stage_name = $s->name;
        $this->stage_role_id = $s->role_id;
        $this->stage_order = $s->stage_order;
        $this->stage_is_start = $s->is_start;
        $this->stage_is_end = $s->is_end;
    }

    public function updateStage()
    {
        $this->validate($this->stageRules());

        $exists = ApprovalWorkflowStage::where('workflow_id', $this->managingWorkflowId)
            ->where('stage_order', $this->stage_order)
            ->where('id', '!=', $this->editingStageId)
            ->exists();

        if ($exists) {
            $this->addError('stage_order', 'A stage with this order already exists in this workflow.');
            return;
        }

        try {
            $s = ApprovalWorkflowStage::findOrFail($this->editingStageId);
            $s->update([
                'name' => $this->stage_name,
                'role_id' => $this->stage_role_id,
                'stage_order' => $this->stage_order,
                'is_start' => $this->stage_is_start,
                'is_end' => $this->stage_is_end,
            ]);

            $this->autoFixStartEnd();
            session()->flash('success', 'Stage updated!');
            $this->resetStageForm();
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating stage.');
        }
    }

    public function destroyStage($id)
    {
        try {
            ApprovalWorkflowStage::find($id)?->delete();
            $this->autoFixStartEnd();
            session()->flash('success', 'Stage deleted.');
        } catch (\Exception $e) {
            session()->flash('error', 'Cannot delete stage with existing approvals.');
        }
    }

    public function resetStageForm()
    {
        $this->editingStageId = null;
        $this->stage_name = '';
        $this->stage_role_id = '';
        $this->stage_order = '';
        $this->stage_is_start = false;
        $this->stage_is_end = false;
    }

    /**
     * Auto-fix: ensure only one start and one end stage.
     * If a stage is marked as start, unmark all others as start.
     * Same for end.
     */
    private function autoFixStartEnd()
    {
        if (!$this->managingWorkflowId) return;

        $stages = ApprovalWorkflowStage::where('workflow_id', $this->managingWorkflowId)
            ->orderBy('stage_order')->get();

        if ($stages->isEmpty()) return;

        // If no start is marked, mark the first
        if (!$stages->where('is_start', true)->count()) {
            $stages->first()->update(['is_start' => true]);
        }
        // If multiple starts, keep only the lowest order
        $starts = $stages->where('is_start', true);
        if ($starts->count() > 1) {
            foreach ($starts->skip(1) as $s) {
                $s->update(['is_start' => false]);
            }
        }

        // If no end is marked, mark the last
        if (!$stages->where('is_end', true)->count()) {
            $stages->last()->update(['is_end' => true]);
        }
        // If multiple ends, keep only the highest order
        $ends = $stages->where('is_end', true);
        if ($ends->count() > 1) {
            foreach ($ends->reverse()->skip(1) as $s) {
                $s->update(['is_end' => false]);
            }
        }
    }

    public function cancelEditWorkflow()
    {
        $this->resetWorkflowForm();
    }

    public function cancelEditStage()
    {
        $this->resetStageForm();
    }
}
