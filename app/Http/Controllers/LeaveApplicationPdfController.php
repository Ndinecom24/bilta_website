<?php

namespace App\Http\Controllers;

use App\Models\Bilta\LeaveApplication;
use App\Services\Leave\LeaveApproverResolver;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LeaveApplicationPdfController extends Controller
{
    public function download(Request $request, $id)
    {
        $application = LeaveApplication::with([
            'user.departmentRelation',
            'user.supervisor',
            'leaveType',
            'workflow.stages.role',
            'approvalHistory.actor',
            'approvalHistory.stage',
        ])->findOrFail($id);

        $actor = $request->user();
        $isApplicant = (int) $application->user_id === (int) $actor->id;
        $isManager = $actor->can('manage-leave-applications')
            || $actor->can('view-all-leave-applications')
            || $actor->hasRole('senior-executive');
        $resolver = app(LeaveApproverResolver::class);
        $isSupervisorOfApplicant = $resolver->isDirectSupervisor($actor, $application->user);
        $isBranchApprover = $actor->can('approve-reject-leave')
            && $resolver->isBranchApproverFor($actor, $application->user);
        $teamDepartmentIds = collect([$actor->department_id])
            ->merge($actor->departmentResponsibilities()->pluck('departments.id'))
            ->filter()
            ->unique();
        $isTeamMemberApplication = $actor->can('approve-reject-leave')
            && $teamDepartmentIds->isNotEmpty()
            && ($teamDepartmentIds->contains($application->user->department_id)
                || $application->user->departmentResponsibilities()->whereIn('departments.id', $teamDepartmentIds)->exists());
        $isAssignedApprover = $resolver->canAct($actor, $application);

        abort_unless($isApplicant || $isManager || $isSupervisorOfApplicant || $isBranchApprover || $isTeamMemberApplication || $isAssignedApprover, 403);
        abort_unless(in_array($application->status, ['approved', 'rejected', 'cancelled'], true), 404, 'The application is not yet complete.');

        $pdf = Pdf::loadView('pdf.leave-application', compact('application'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('leave-application-' . $application->id . '.pdf');
    }
}
