{{--
    Workflow pipeline. Lists only the people who actually work on each stage
    (direct supervisor / branch-assigned approvers), never the whole role.

    Expects: $stageProgress (see LeaveApproverResolver::stageProgress), $application
--}}
<div class="d-flex flex-wrap align-items-center gap-2 my-2">
    @foreach ($stageProgress as $item)
        @php
            $stg = $item['stage'];
            switch ($item['state']) {
                case 'done':
                    $badgeClass = 'bg-success text-white'; $icon = 'fa-check-circle'; break;
                case 'rejected':
                    $badgeClass = 'bg-danger text-white'; $icon = 'fa-times-circle'; break;
                case 'current':
                    $badgeClass = 'bg-warning text-dark'; $icon = 'fa-hourglass-half'; break;
                default:
                    $badgeClass = 'bg-light text-muted border'; $icon = 'fa-circle';
            }
        @endphp
        <div class="text-center" style="min-width:120px;">
            <span class="badge {{ $badgeClass }} px-3 py-2 d-block">
                <i class="fas {{ $icon }} mr-1"></i>
                {{ $stg->stage_order }}. {{ $stg->name }}
            </span>
            <small class="text-muted d-block mt-1" style="font-size:.72rem;">
                @if ($item['actor'])
                    <span class="d-block"><i class="fas fa-user-check"></i> {{ $item['actor']->name }}</span>
                @elseif ($item['approvers']->isNotEmpty())
                    @foreach ($item['approvers'] as $approver)
                        <span class="d-block"><i class="fas fa-user"></i> {{ $approver->name }}</span>
                    @endforeach
                @elseif ($application->status === 'pending' && in_array($item['state'], ['current', 'upcoming'], true))
                    <span class="d-block text-danger"><i class="fas fa-exclamation-triangle"></i> No approver assigned</span>
                    <span class="d-block">{{ $stg->role->name ?? 'No role' }}</span>
                @elseif ($item['state'] === 'done')
                    <span class="d-block">Completed</span>
                @else
                    <span class="d-block">{{ $stg->role->name ?? 'No role' }}</span>
                @endif
            </small>
        </div>
        @if (!$loop->last)
            <i class="fas fa-arrow-right text-muted align-self-start mt-3"></i>
        @endif
    @endforeach
</div>
