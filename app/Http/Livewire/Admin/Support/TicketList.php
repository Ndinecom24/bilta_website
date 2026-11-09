<?php

namespace App\Http\Livewire\Admin\Support;

use App\Models\Support\Ticket;
use App\Models\Support\TicketCategory;
use App\Models\Support\TicketPriority;
use App\Models\Support\TicketSystem;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Shared list of tickets. Concrete pages are MyTickets (own tickets) and
 * AllTickets (everything the user is allowed to see).
 */
class TicketList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /** 'mine' | 'all' - protected so it cannot be tampered with from the browser */
    protected $mode = 'mine';

    public $search = '';
    public $status = '';
    public $priority_id = '';
    public $category_id = '';
    public $system_id = '';
    public $assignee_id = '';
    public $date_from = '';
    public $date_to = '';
    public $overdue = false;

    protected $queryString = [
        'status' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($name)
    {
        if ($name !== 'search') {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'status', 'priority_id', 'category_id', 'system_id', 'assignee_id', 'date_from', 'date_to', 'overdue']);
        $this->resetPage();
    }

    protected function scopedQuery()
    {
        $user = auth()->user();
        $query = Ticket::visibleTo($user);

        if ($this->mode === 'mine') {
            $query->where('tickets.submitted_by', $user->id);
        }

        return $query;
    }

    private function filteredQuery()
    {
        $query = $this->scopedQuery()->with(['category', 'priority', 'system', 'submitter', 'assignee']);

        if (trim($this->search) !== '') {
            $term = '%' . str_replace(['%', '_'], ['\\%', '\\_'], trim($this->search)) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('tickets.reference', 'like', $term)
                    ->orWhere('tickets.subject', 'like', $term)
                    ->orWhere('tickets.description', 'like', $term);
            });
        }

        if ($this->status !== '' && array_key_exists($this->status, Ticket::STATUSES)) {
            $query->where('tickets.status', $this->status);
        }
        if ($this->priority_id !== '') {
            $query->where('tickets.priority_id', (int) $this->priority_id);
        }
        if ($this->category_id !== '') {
            $query->where('tickets.category_id', (int) $this->category_id);
        }
        if ($this->system_id !== '') {
            $query->where('tickets.system_id', (int) $this->system_id);
        }
        if ($this->mode === 'all' && $this->assignee_id !== '') {
            $this->assignee_id === 'none'
                ? $query->whereNull('tickets.assigned_to')
                : $query->where('tickets.assigned_to', (int) $this->assignee_id);
        }
        if ($this->date_from !== '' && strtotime($this->date_from)) {
            $query->whereDate('tickets.created_at', '>=', $this->date_from);
        }
        if ($this->date_to !== '' && strtotime($this->date_to)) {
            $query->whereDate('tickets.created_at', '<=', $this->date_to);
        }
        if ($this->overdue) {
            $query->overdue();
        }

        return $query;
    }

    public function render()
    {
        $developers = collect();
        if ($this->mode === 'all') {
            $developers = User::where('status_id', config('constants.status.active'))
                ->withPermission('work-support-tickets')
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        $summary = [
            'total' => $this->scopedQuery()->count(),
            'open' => $this->scopedQuery()->open()->count(),
            'awaiting' => $this->scopedQuery()->where('tickets.status', Ticket::STATUS_AWAITING_FEEDBACK)->count(),
            'resolved' => $this->scopedQuery()->where('tickets.status', Ticket::STATUS_RESOLVED)->count(),
            'closed' => $this->scopedQuery()->where('tickets.status', Ticket::STATUS_CLOSED)->count(),
        ];

        return view('livewire.admin.support.ticket-list', [
            'mode' => $this->mode,
            'tickets' => $this->filteredQuery()->orderByDesc('tickets.last_activity_at')->orderByDesc('tickets.id')->paginate(15),
            'summary' => $summary,
            'categories' => TicketCategory::ordered()->get(),
            'systems' => TicketSystem::ordered()->get(),
            'priorities' => TicketPriority::ordered()->get(),
            'developers' => $developers,
        ]);
    }
}
