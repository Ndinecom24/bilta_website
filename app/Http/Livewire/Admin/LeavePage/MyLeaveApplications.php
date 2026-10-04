<?php

namespace App\Http\Livewire\Admin\LeavePage;

use App\Mail\LeaveApprovalRequestMail;
use App\Mail\LeaveStatusUpdateMail;
use App\Mail\LeaveSubmissionConfirmationMail;
use App\Models\Bilta\ApprovalHistory;
use App\Models\Bilta\ApprovalWorkflow;
use App\Models\Bilta\LeaveApplication;
use App\Models\Bilta\LeaveBalance;
use App\Models\Bilta\LeaveType;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MyLeaveApplications extends Component
{
    use WithPagination, WithFileUploads;

    // Leave form fields
    public $leave_type_id, $other_leave_type_text;
    public $start_date, $end_date, $resume_date;
    public $days_requested = 0;
    public $reason, $document;

    // Acting arrangement
    public $acting_user_id, $acting_name, $acting_cell, $acting_position;

    // UI state
    public $showForm = false;
    public $viewingId = null;

    // Review state
    public $reviewComment = '';
    public $reviewAction = '';
    public $signatureData = '';
    public $applicantSignatureData = '';

    protected $rules = [
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'resume_date' => 'nullable|date|after:end_date',
        'reason' => 'required|string|min:10|max:1000',
        'document' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,doc,docx',
        'other_leave_type_text' => 'nullable|string|max:255',
        'acting_user_id' => 'nullable|exists:users,id',
        'acting_name' => 'nullable|string|max:255',
        'acting_cell' => 'nullable|string|max:20',
        'acting_position' => 'nullable|string|max:100',
        'applicantSignatureData' => 'required|string|max:1000000',
    ];

    public function render()
    {
        $applications = LeaveApplication::where('user_id', auth()->id())
            ->with(['leaveType', 'currentStage', 'workflow.stages', 'approvalHistory.actor', 'approvalHistory.stage'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $leaveTypes = LeaveType::where('status_id', 1)->get();

        $balances = LeaveBalance::where('user_id', auth()->id())
            ->where('year', date('Y'))
            ->with('leaveType')
            ->get();

        $viewingApplication = null;
        if ($this->viewingId) {
            $viewingApplication = LeaveApplication::with([
                'user.supervisor', 'user.departmentRelation', 'leaveType',
                'currentStage.role.users', 'workflow.stages.role.users',
                'approvalHistory.actor', 'approvalHistory.stage',
            ])->find($this->viewingId);
        }

        $allUsers = User::orderBy('name')->select('id', 'name', 'position', 'phone')->get();

        return view('livewire.admin.leave-page.my-leave-applications', compact(
            'applications', 'leaveTypes', 'balances', 'viewingApplication', 'allUsers'
        ));
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetFields();
        }
    }

    public function resetFields()
    {
        $this->leave_type_id = '';
        $this->other_leave_type_text = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->resume_date = '';
        $this->reason = '';
        $this->document = null;
        $this->days_requested = 0;
        $this->acting_user_id = '';
        $this->acting_name = '';
        $this->acting_cell = '';
        $this->acting_position = '';
        $this->applicantSignatureData = '';
    }

    public function updatedStartDate() { $this->calculateDays(); $this->calculateResumeDate(); }
    public function updatedEndDate()   { $this->calculateDays(); $this->calculateResumeDate(); }

    private function calculateDays()
    {
        if ($this->start_date && $this->end_date && $this->end_date >= $this->start_date) {
            $this->days_requested = LeaveApplication::calculateWorkingDays($this->start_date, $this->end_date);
        } else {
            $this->days_requested = 0;
        }
    }

    private function calculateResumeDate()
    {
        if ($this->end_date) {
            $resume = \Carbon\Carbon::parse($this->end_date)->addDay();
            // Skip weekends
            while ($resume->isWeekend()) {
                $resume->addDay();
            }
            $this->resume_date = $resume->format('Y-m-d');
        }
    }

    public function store()
    {
        $this->validate();
        $applicantSignaturePath = $this->storeSignatureData($this->applicantSignatureData, 'applicantSignatureData');

        // Require "Others" specification
        $selectedType = LeaveType::find($this->leave_type_id);
        if ($selectedType && $selectedType->slug === 'others' && empty($this->other_leave_type_text)) {
            $this->addError('other_leave_type_text', 'Please specify the leave type.');
            return;
        }

        // Check for active workflow
        $workflow = ApprovalWorkflow::activeForLeave();
        if (!$workflow || $workflow->stages()->count() === 0) {
            session()->flash('error', 'No active approval workflow is configured. Please contact your administrator.');
            return;
        }

        $startStage = $workflow->startStage();
        if (!$startStage) {
            session()->flash('error', 'Approval workflow has no start stage configured.');
            return;
        }

        try {
            $documentPath = null;
            if ($this->document) {
                $documentPath = $this->document->store('leave-documents', 'public');
            }

            $application = LeaveApplication::create([
                'user_id' => auth()->id(),
                'leave_type_id' => $this->leave_type_id,
                'other_leave_type_text' => $this->other_leave_type_text,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'resume_date' => $this->resume_date ?: null,
                'days_requested' => $this->days_requested,
                'reason' => $this->reason,
                'document_path' => $documentPath,
                'applicant_signature_path' => $applicantSignaturePath,
                'applicant_signed_at' => now(),
                'acting_name' => $this->acting_user_id ? (User::find($this->acting_user_id)->name ?? $this->acting_name) : ($this->acting_name ?: null),
                'acting_cell' => $this->acting_cell ?: null,
                'acting_position' => $this->acting_position ?: null,
                'status' => 'pending',
                'workflow_id' => $workflow->id,
                'current_stage_id' => $startStage->id,
            ]);

            // Notify approvers for first stage
            $this->notifyStageApprovers($application, $startStage);

            // Send submission confirmation to the applicant
            $this->notifyApplicantSubmission($application, $startStage);

            session()->flash('success', 'Leave application submitted successfully! It is now at: ' . $startStage->name);
            $this->resetFields();
            $this->showForm = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Error submitting leave application.');
        }
    }

    public function cancelApplication($id)
    {
        $application = LeaveApplication::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$application) {
            session()->flash('error', 'Cannot cancel this application.');
            return;
        }

        $application->update(['status' => 'cancelled']);
        session()->flash('success', 'Leave application cancelled.');
    }

    public function viewApplication($id)
    {
        $application = LeaveApplication::with('currentStage.role', 'user')->findOrFail($id);
        if ((int) $application->user_id !== (int) auth()->id() && !$this->canActOnApplication($application)) {
            abort(403, 'You are not assigned to review this leave application.');
        }
        $this->viewingId = $id;
    }

    public function closeView()
    {
        $this->viewingId = null;
        $this->reviewComment = '';
        $this->reviewAction = '';
        $this->signatureData = '';
    }

    /**
     * Check if the current user can act on the viewed application at its current stage.
     */
    public function canActOnApplication(LeaveApplication $application): bool
    {
        $actor = auth()->user();
        if (!$actor || (int) $application->user_id === (int) $actor->id || !$actor->can('approve-reject-leave') || $application->status !== 'pending' || !$application->currentStage) {
            return false;
        }

        $stageRole = $application->currentStage->role;
        if (!$stageRole || !$actor->roles->contains('id', $stageRole->id)) {
            return false;
        }

        if (strtolower($stageRole->slug) === 'supervisor') {
            return $actor->hasRole('supervisor') && (int) $application->user->supervisor_id === (int) $actor->id;
        }

        return true;
    }

    /**
     * Submit an approval or rejection from the detail view.
     */
    public function submitReview($action)
    {
        if (!in_array($action, ['approved', 'rejected'], true)) {
            abort(422, 'Invalid review action.');
        }

        $this->reviewAction = $action;

        $this->validate([
            'reviewComment' => 'required|string|min:3|max:1000',
            'signatureData' => 'nullable|string|max:1000000',
        ], [
            'reviewComment.required' => 'Please provide a reason for your decision.',
            'reviewComment.min' => 'The reason must be at least 3 characters.',
        ]);

        $application = LeaveApplication::with(['currentStage', 'user', 'leaveType'])->findOrFail($this->viewingId);

        if ($application->status !== 'pending') {
            session()->flash('error', 'This application has already been finalized.');
            return;
        }

        if (!$this->canActOnApplication($application)) {
            session()->flash('error', 'You do not have the required role for this approval stage.');
            return;
        }

        $currentStage = $application->currentStage;
        $actorName = auth()->user()->name;
        $signaturePath = $this->storeSignature();

        // Record approval history
        ApprovalHistory::create([
            'leave_application_id' => $application->id,
            'stage_id' => $currentStage->id,
            'acted_by' => auth()->id(),
            'action' => $action,
            'comment' => $this->reviewComment,
            'signature_path' => $signaturePath,
        ]);

        if ($action === 'rejected') {
            $application->update([
                'status' => 'rejected',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'review_comment' => $this->reviewComment,
            ]);

            $this->notifyApplicant($application, 'rejected', $this->reviewComment, $actorName, $currentStage->name);
            session()->flash('success', 'Leave application rejected at "' . $currentStage->name . '".');

        } elseif ($action === 'approved') {
            $nextStage = $currentStage->nextStage();

            if ($currentStage->is_end || !$nextStage) {
                $application->update([
                    'status' => 'approved',
                    'current_stage_id' => null,
                    'reviewed_by' => auth()->id(),
                    'reviewed_at' => now(),
                    'review_comment' => $this->reviewComment,
                ]);

                $balance = LeaveBalance::firstOrCreate(
                    [
                        'user_id' => $application->user_id,
                        'leave_type_id' => $application->leave_type_id,
                        'year' => $application->start_date->year,
                    ],
                    [
                        'total_days' => LeaveType::find($application->leave_type_id)->default_days ?? 0,
                        'used_days' => 0,
                        'carried_over' => 0,
                    ]
                );
                $balance->increment('used_days', $application->days_requested);

                $this->notifyApplicant($application, 'approved', $this->reviewComment, $actorName, $currentStage->name);
                session()->flash('success', 'Leave application FULLY APPROVED (final stage: "' . $currentStage->name . '").');

            } else {
                $application->update([
                    'current_stage_id' => $nextStage->id,
                ]);

                $this->notifyApplicant($application, 'approved', $this->reviewComment, $actorName, $currentStage->name);
                $this->notifyStageApprovers($application, $nextStage);

                session()->flash('success', 'Approved at "' . $currentStage->name . '". Application moved to: "' . $nextStage->name . '".');
            }
        }

        $this->reviewComment = '';
        $this->reviewAction = '';
        $this->signatureData = '';
        $this->viewingId = null;
    }

    private function storeSignature(): ?string
    {
        return $this->storeSignatureData($this->signatureData, 'signatureData');
    }

    private function storeSignatureData(?string $data, string $field): ?string
    {
        if (!$data) {
            return null;
        }

        if (!preg_match('/^data:image\/png;base64,([A-Za-z0-9+\/=]+)$/', $data, $matches)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $field => 'The signature image is invalid. Please sign again or clear it.',
            ]);
        }

        $image = base64_decode($matches[1], true);
        $imageInfo = $image === false ? false : @getimagesizefromstring($image);
        if ($image === false || strlen($image) > 500000 || !$imageInfo || $imageInfo['mime'] !== 'image/png') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $field => 'The signature must be a valid PNG under 500 KB.',
            ]);
        }

        $path = 'leave-signatures/' . auth()->id() . '/' . Str::uuid() . '.png';
        Storage::disk('local')->put($path, $image);

        return $path;
    }

    /**
     * Send status update email to the applicant.
     */
    private function notifyApplicant(LeaveApplication $application, string $action, ?string $comment, string $actorName, string $stageName)
    {
        try {
            Mail::to($application->user->email)->send(
                new LeaveStatusUpdateMail($application, $action, $comment, $actorName, $stageName)
            );
        } catch (\Exception $e) {
            // Silently fail
        }
    }

    /**
     * Send submission confirmation email to the applicant.
     */
    private function notifyApplicantSubmission(LeaveApplication $application, $stage)
    {
        try {
            $application->load(['user', 'leaveType']);
            Mail::to($application->user->email)->send(
                new LeaveSubmissionConfirmationMail($application, $stage)
            );
        } catch (\Exception $e) {
            // Silently fail — don't block the workflow
        }
    }

    /**
     * Send approval request emails to all users having the role assigned to the stage.
     */
    private function notifyStageApprovers(LeaveApplication $application, $stage)
    {
        try {
            $stage->loadMissing('role');
            if ($stage->role && strtolower($stage->role->slug) === 'supervisor') {
                $supervisorId = $application->user()->value('supervisor_id');
                $approvers = $supervisorId
                    ? User::whereKey($supervisorId)->whereHas('roles', function ($query) {
                        $query->where('roles.slug', 'supervisor');
                    })->get()->filter(function ($user) {
                        return $user->can('approve-reject-leave');
                    })
                    : collect();
            } else {
                $approvers = User::whereHas('roles', function ($query) use ($stage) {
                    $query->where('roles.id', $stage->role_id);
                })->get()->filter(function ($user) {
                    return $user->can('approve-reject-leave');
                });
            }

            foreach ($approvers as $approver) {
                Mail::to($approver->email)->send(new LeaveApprovalRequestMail($application, $stage));
            }
        } catch (\Exception $e) {
            // Silently fail email — don't block the workflow
        }
    }
}
