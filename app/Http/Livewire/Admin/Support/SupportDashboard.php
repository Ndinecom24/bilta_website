<?php

namespace App\Http\Livewire\Admin\Support;

use App\Models\Support\Ticket;
use App\Models\Support\TicketCategory;
use App\Models\Support\TicketPriority;
use App\Models\Support\TicketSystem;
use App\Models\Support\TicketWorkLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SupportDashboard extends Component
{
    public $period = '30';       // all | 7 | 30 | 90 | year
    public $category_id = '';
    public $priority_id = '';
    public $developer_id = '';

    public function mount()
    {
        abort_unless(auth()->user()->can('view-support-dashboard'), 403);
    }

    public function resetFilters()
    {
        $this->period = '30';
        $this->category_id = '';
        $this->priority_id = '';
        $this->developer_id = '';
    }

    /** First day of the selected period, or null for "all time". */
    private function from()
    {
        switch ($this->period) {
            case '7':
                return now()->subDays(7)->startOfDay();
            case '30':
                return now()->subDays(30)->startOfDay();
            case '90':
                return now()->subDays(90)->startOfDay();
            case 'year':
                return now()->startOfYear();
            default:
                return null;
        }
    }

    private function base()
    {
        $q = Ticket::query();

        if ($from = $this->from()) {
            $q->where('tickets.created_at', '>=', $from);
        }
        if ($this->category_id !== '') {
            $q->where('tickets.category_id', (int) $this->category_id);
        }
        if ($this->priority_id !== '') {
            $q->where('tickets.priority_id', (int) $this->priority_id);
        }
        if ($this->developer_id !== '') {
            $this->developer_id === 'none'
                ? $q->whereNull('tickets.assigned_to')
                : $q->where('tickets.assigned_to', (int) $this->developer_id);
        }

        return $q;
    }

    /** @return array<string,int> id => count for a grouping column, optionally open tickets only */
    private function groupCounts(string $column, bool $openOnly = false): array
    {
        $q = $this->base();
        if ($openOnly) {
            $q->open();
        }

        return $q->select($column, DB::raw('count(*) as c'))
            ->groupBy($column)
            ->pluck('c', $column)
            ->all();
    }

    public function render()
    {
        $byStatus = $this->base()->select('status', DB::raw('count(*) as c'))->groupBy('status')->pluck('c', 'status')->all();
        $get = function ($s) use ($byStatus) {
            return (int) ($byStatus[$s] ?? 0);
        };

        $total = array_sum($byStatus);

        $cards = [
            'total' => $total,
            'new' => $get('new'),
            'unassigned' => $this->base()->whereNull('tickets.assigned_to')->open()->count(),
            'in_progress' => $get('in_progress') + $get('assigned') + $get('acknowledged'),
            'awaiting' => $get('awaiting_feedback'),
            'on_hold' => $get('on_hold'),
            'reopened' => $get('reopened'),
            'resolved' => $get('resolved'),
            'closed' => $get('closed'),
            'overdue' => $this->base()->overdue()->count(),
        ];

        $avgResolution = $this->base()->whereNotNull('resolved_at')
            ->selectRaw('avg(timestampdiff(minute, tickets.created_at, tickets.resolved_at)) as m')
            ->value('m');

        $withDue = $this->base()->whereNotNull('resolved_at')->whereNotNull('due_date')->count();
        $onTime = $this->base()->whereNotNull('resolved_at')->whereNotNull('due_date')
            ->whereRaw('date(tickets.resolved_at) <= tickets.due_date')->count();

        // Breakdowns
        $priorities = TicketPriority::ordered()->get();
        $priorityOpen = $this->groupCounts('tickets.priority_id', true);

        $categories = TicketCategory::ordered()->get();
        $categoryAll = $this->groupCounts('tickets.category_id');
        $categoryOpen = $this->groupCounts('tickets.category_id', true);

        $systems = TicketSystem::ordered()->get();
        $systemAll = $this->groupCounts('tickets.system_id');
        $systemOpen = $this->groupCounts('tickets.system_id', true);

        // Developer workload
        $developers = User::where('status_id', config('constants.status.active'))
            ->withPermission('work-support-tickets')
            ->orderBy('name')
            ->get(['id', 'name']);

        $from = $this->from();
        $workload = [];
        foreach ($developers as $dev) {
            $own = Ticket::where('assigned_to', $dev->id);
            $logged = TicketWorkLog::where('developer_id', $dev->id)
                ->when($from, function ($q) use ($from) {
                    $q->where('work_date', '>=', $from->toDateString());
                })->sum('hours');

            $workload[] = [
                'name' => $dev->name,
                'open' => (clone $own)->open()->count(),
                'overdue' => (clone $own)->overdue()->count(),
                'resolved' => (clone $own)->whereIn('status', Ticket::FINAL_STATUSES)
                    ->when($from, function ($q) use ($from) {
                        $q->where('resolved_at', '>=', $from);
                    })->count(),
                'hours' => (float) $logged,
            ];
        }

        $overdueTickets = $this->base()->overdue()
            ->with(['priority', 'assignee'])
            ->orderBy('tickets.due_date')
            ->limit(10)
            ->get();

        // Hours (kept separate: estimated vs actual vs approved billable)
        $ids = $this->base()->pluck('tickets.id');
        $hours = [
            'estimated' => (float) Ticket::whereIn('id', $ids)->sum('estimated_hours'),
            'actual' => (float) TicketWorkLog::whereIn('ticket_id', $ids)->sum('hours'),
            'billable' => (float) TicketWorkLog::whereIn('ticket_id', $ids)->where('billing_status', 'approved')->sum('billable_hours'),
            'unreviewed' => (float) TicketWorkLog::whereIn('ticket_id', $ids)->where('billing_status', 'unreviewed')->sum('hours'),
        ];

        return view('livewire.admin.support.support-dashboard', [
            'cards' => $cards,
            'avgResolutionHours' => $avgResolution !== null ? round($avgResolution / 60, 1) : null,
            'onTimePct' => $withDue > 0 ? round($onTime / $withDue * 100) : null,
            'priorities' => $priorities,
            'priorityOpen' => $priorityOpen,
            'categories' => $categories,
            'categoryAll' => $categoryAll,
            'categoryOpen' => $categoryOpen,
            'systems' => $systems,
            'systemAll' => $systemAll,
            'systemOpen' => $systemOpen,
            'developers' => $developers,
            'workload' => $workload,
            'overdueTickets' => $overdueTickets,
            'hours' => $hours,
        ]);
    }
}
