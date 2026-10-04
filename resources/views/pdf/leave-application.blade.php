<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Leave Application #{{ $application->id }}</title>
    <style>
        @page { margin: 28px 34px; }
        body { font-family: DejaVu Sans, sans-serif; color: #20253a; font-size: 11px; }
        h1 { color: #bd510f; font-size: 20px; margin: 0 0 5px; }
        h2 { color: #bd510f; font-size: 13px; border-bottom: 1px solid #e8a36d; padding-bottom: 5px; margin: 22px 0 10px; }
        .muted { color: #656b78; }
        .top { border-bottom: 2px solid #bd510f; padding-bottom: 12px; }
        .status { display: inline-block; padding: 4px 8px; border: 1px solid #aaa; border-radius: 3px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; }
        td, th { text-align: left; vertical-align: top; border: 1px solid #d9dce2; padding: 7px; }
        th { background: #f3f4f6; }
        .details td { width: 25%; }
        .label { display: block; color: #747987; font-size: 9px; margin-bottom: 4px; }
        .comment { white-space: pre-wrap; }
        .signature { height: 48px; max-width: 180px; }
        .footer { color: #777; font-size: 9px; margin-top: 22px; border-top: 1px solid #ddd; padding-top: 8px; }
    </style>
</head>
<body>
    <div class="top">
        <h1>Leave Application</h1>
        <div>Reference #{{ $application->id }} &nbsp; <span class="status">{{ ucfirst($application->status) }}</span></div>
        <div class="muted">Submitted {{ optional($application->created_at)->format('d M Y H:i') }}</div>
    </div>

    <h2>Employee information</h2>
    <table class="details">
        <tr>
            <td><span class="label">Name</span>{{ $application->user->name ?? '—' }}</td>
            <td><span class="label">Position</span>{{ $application->user->position ?? '—' }}</td>
            <td><span class="label">Department</span>{{ optional(optional($application->user)->departmentRelation)->name ?? ($application->user->department ?? '—') }}</td>
            <td><span class="label">Employee ID</span>{{ $application->user->employee_id ?? '—' }}</td>
        </tr>
        <tr>
            <td><span class="label">Email</span>{{ $application->user->email ?? '—' }}</td>
            <td><span class="label">Phone</span>{{ $application->user->phone ?? '—' }}</td>
            <td><span class="label">NRC</span>{{ $application->user->nrc ?? '—' }}</td>
            <td><span class="label">MAN Number</span>{{ $application->user->man_number ?? '—' }}</td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">Supervisor</span>{{ optional(optional($application->user)->supervisor)->name ?? '—' }}</td>
            <td colspan="2"><span class="label">Contract type</span>{{ ucfirst($application->user->contract_type ?? '—') }}</td>
        </tr>
    </table>

    <h2>Leave details</h2>
    <table class="details">
        <tr>
            <td><span class="label">Leave type</span>{{ $application->leaveType->name ?? '—' }}{{ $application->other_leave_type_text ? ' — '.$application->other_leave_type_text : '' }}</td>
            <td><span class="label">Start date</span>{{ optional($application->start_date)->format('d M Y') ?? '—' }}</td>
            <td><span class="label">End date</span>{{ optional($application->end_date)->format('d M Y') ?? '—' }}</td>
            <td><span class="label">Working days</span>{{ $application->days_requested }}</td>
        </tr>
        <tr>
            <td><span class="label">Resume work</span>{{ optional($application->resume_date)->format('d M Y') ?? '—' }}</td>
            <td colspan="3"><span class="label">Acting arrangement</span>{{ $application->acting_name ?? '—' }}{{ $application->acting_cell ? ' — '.$application->acting_cell : '' }}{{ $application->acting_position ? ' — '.$application->acting_position : '' }}</td>
        </tr>
        <tr><td colspan="4"><span class="label">Reason / purpose</span><div class="comment">{{ $application->reason }}</div></td></tr>
    </table>

    <h2>Applicant declaration</h2>
    <p>I wish to apply for leave as stated above. The information provided is accurate and I understand this application will follow the organisation's approval workflow.</p>
    <table>
        <tr>
            <td><span class="label">Signed by (Applicant)</span>{{ $application->user->name ?? '—' }}</td>
            <td><span class="label">Date</span>{{ optional($application->applicant_signed_at)->format('d M Y H:i') ?? '—' }}</td>
            <td>
                <span class="label">Electronic signature</span>
                @if ($application->applicant_signature_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($application->applicant_signature_path))
                    <img class="signature" src="data:image/png;base64,{{ base64_encode(\Illuminate\Support\Facades\Storage::disk('local')->get($application->applicant_signature_path)) }}" alt="Applicant electronic signature">
                @else
                    Not provided
                @endif
            </td>
        </tr>
    </table>

    <h2>Approval record</h2>
    @if ($application->approvalHistory->isNotEmpty())
        <table>
            <thead><tr><th>Stage</th><th>Decision</th><th>Approver</th><th>Comment</th><th>Signed at</th><th>Electronic signature</th></tr></thead>
            <tbody>
                @foreach ($application->approvalHistory as $history)
                    <tr>
                        <td>{{ $history->stage->name ?? '—' }}</td>
                        <td>{{ ucfirst($history->action) }}</td>
                        <td>{{ $history->actor->name ?? '—' }}</td>
                        <td class="comment">{{ $history->comment ?? '—' }}</td>
                        <td>{{ optional($history->created_at)->format('d M Y H:i') }}</td>
                        <td>
                            @if ($history->signature_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($history->signature_path))
                                <img class="signature" src="data:image/png;base64,{{ base64_encode(\Illuminate\Support\Facades\Storage::disk('local')->get($history->signature_path)) }}" alt="Electronic signature">
                            @else
                                Not provided
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No approval actions are recorded.</p>
    @endif

    @if ($application->document_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($application->document_path))
        <p class="footer">Supporting document: {{ basename($application->document_path) }} (downloaded separately; not embedded in this application PDF).</p>
    @endif

    <div class="footer">Generated {{ now()->format('d M Y H:i') }}. Electronic signatures and decisions are recorded in the application audit history.</div>
</body>
</html>
