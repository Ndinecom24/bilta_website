<?php

namespace App\Http\Livewire\Admin\Support;

use App\Models\Support\Ticket;
use App\Models\Support\TicketWorkLog;
use App\Services\Support\TicketService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DeveloperWorkspace extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $tab = 'mine';

    protected $queryString = ['tab' => ['except' => 'mine']];

    private const TABS = [
        'unassigned' => ['Unassigned queue', 'fa-inbox'],
        'mine' => ['My open tickets', 'fa-user'],
        'feedback' => ['Awaiting feedback', 'fa-question-circle'],
        'hold' => ['On hold', 'fa-pause-circle'],
        'overdue' => ['Overdue', 'fa-exclamation-triangle'],
        'resolved' => ['Awaiting closure', 'fa-check-circle'],
    ];

    public function mount()
    {
        abort_unless(auth()->user()->can('work-support-tickets'), 403);

        if (!array_key_exists($this->tab, self::TABS)) {
            $this->tab = 'mine';
        }
    }

    public function setTab($tab)
    {
        if (array_key_exists($tab, self::TABS)) {
            $this->tab = $tab;
            $this->resetPage();
        }
    }

    public function accept($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        app(TicketService::class)->accept($ticket, auth()->user());

        session()->flash('success', 'You accepted ' . $ticket->reference . '.');
    }

    private function queryFor(string $tab)
    {
        $me = auth()->id();
        $query = Ticket::query();

        switch ($tab) {
            case 'unassigned':
                $query->whereNull('tickets.assigned_to')->open();
                break;
            case 'feedback':
                $query->where('tickets.assigned_to', $me)->where('tickets.status', Ticket::STATUS_AWAITING_FEEDBACK);
                break;
            case 'hold':
                $query->where('tickets.assigned_to', $me)->where('tickets.status', Ticket::STATUS_ON_HOLD);
                break;
            case 'overdue':
                $query->where('tickets.assigned_to', $me)->overdue();
                break;
            case 'resolved':
                $query->where('tickets.assigned_to', $me)->where('tickets.status', Ticket::STATUS_RESOLVED);
                break;
            default: // mine
                $query->where('tickets.assigned_to', $me)->open();
        }

        return $query;
    }

    public function render()
    {
        $me = auth()->id();

        $counts = [];
        foreach (array_keys(self::TABS) as $key) {
            $counts[$key] = $this->queryFor($key)->count();
        }

        $tickets = $this->queryFor($this->tab)
            ->with(['category', 'priority', 'system', 'submitter', 'assignee'])
            ->withSum('workLogs as logged_hours', 'hours')
            ->orderByDesc(DB::raw('(select level from ticket_priorities where ticket_priorities.id = tickets.priority_id)'))
            ->orderByRaw('tickets.due_date is null')
            ->orderBy('tickets.due_date')
            ->orderBy('tickets.id')
            ->paginate(15);

        $weekStart = now()->startOfWeek()->toDateString();

        $workload = [
            'open_estimate' => (float) Ticket::where('assigned_to', $me)->open()->sum('estimated_hours'),
            'week_hours' => (float) TicketWorkLog::where('developer_id', $me)->where('work_date', '>=', $weekStart)->sum('hours'),
            'resolved_30d' => Ticket::where('assigned_to', $me)->whereNotNull('resolved_at')->where('resolved_at', '>=', now()->subDays(30))->count(),
        ];

        return view('livewire.admin.support.developer-workspace', [
            'tabs' => self::TABS,
            'counts' => $counts,
            'tickets' => $tickets,
            'workload' => $workload,
        ]);
    }
}
