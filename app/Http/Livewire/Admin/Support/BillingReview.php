<?php

namespace App\Http\Livewire\Admin\Support;

use App\Models\Support\TicketBillingRate;
use App\Models\Support\TicketWorkLog;
use App\Models\User;
use App\Services\Support\TicketService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Review work logs for billing. Approving snapshots the rate; nothing is invoiced automatically.
 */
class BillingReview extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $status = 'unreviewed';
    public $developer_id = '';
    public $from = '';
    public $to = '';
    public $search = '';

    /** work_log_id => billable hours typed by the reviewer */
    public $billable = [];
    public $selected = [];

    public function mount()
    {
        abort_unless(auth()->user()->can('manage-support-billing'), 403);
    }

    public function updated($name)
    {
        if (!str_starts_with($name, 'billable') && !str_starts_with($name, 'selected')) {
            $this->resetPage();
            $this->selected = [];
        }
    }

    private function log($id): TicketWorkLog
    {
        return TicketWorkLog::with('ticket')->findOrFail($id);
    }

    public function approve($id)
    {
        $log = $this->log($id);
        $hours = isset($this->billable[$id]) && $this->billable[$id] !== '' ? (float) $this->billable[$id] : null;

        app(TicketService::class)->reviewBilling($log, auth()->user(), 'approve', $hours);
        unset($this->billable[$id]);
        session()->flash('success', 'Approved ' . $log->ticket->reference . ' work for billing.');
    }

    public function markNonBillable($id)
    {
        app(TicketService::class)->reviewBilling($this->log($id), auth()->user(), 'non_billable');
        session()->flash('success', 'Marked as non-billable.');
    }

    public function undoReview($id)
    {
        app(TicketService::class)->reviewBilling($this->log($id), auth()->user(), 'reset');
        session()->flash('success', 'Moved back to review.');
    }

    public function approveSelected()
    {
        $ids = array_filter($this->selected);
        if (!$ids) {
            session()->flash('error', 'Select at least one entry.');

            return;
        }

        $ok = 0;
        $failed = [];
        foreach (TicketWorkLog::with('ticket')->whereIn('id', $ids)->where('billing_status', 'unreviewed')->get() as $log) {
            try {
                app(TicketService::class)->reviewBilling($log, auth()->user(), 'approve');
                $ok++;
            } catch (ValidationException $e) {
                $failed[] = $log->ticket->reference . ': ' . collect($e->errors())->flatten()->first();
            }
        }

        $this->selected = [];
        session()->flash('success', $ok . ' entries approved.' . ($failed ? ' Skipped: ' . implode(' | ', $failed) : ''));
    }

    private function query()
    {
        $q = TicketWorkLog::query()->with(['ticket', 'developer']);

        if (in_array($this->status, ['unreviewed', 'approved', 'non_billable'], true)) {
            $q->where('billing_status', $this->status);
        }
        if ($this->developer_id !== '') {
            $q->where('developer_id', (int) $this->developer_id);
        }
        if ($this->from !== '' && strtotime($this->from)) {
            $q->whereDate('work_date', '>=', $this->from);
        }
        if ($this->to !== '' && strtotime($this->to)) {
            $q->whereDate('work_date', '<=', $this->to);
        }
        if (trim($this->search) !== '') {
            $term = '%' . trim($this->search) . '%';
            $q->whereHas('ticket', function ($t) use ($term) {
                $t->where('reference', 'like', $term)->orWhere('subject', 'like', $term);
            });
        }

        return $q;
    }

    public function render()
    {
        $logs = $this->query()->orderByDesc('work_date')->orderByDesc('id')->paginate(20);

        $rates = [];
        foreach ($logs as $log) {
            $rates[$log->id] = TicketBillingRate::resolve($log->developer_id, $log->work_date);
        }

        $summary = [
            'unreviewed' => (float) TicketWorkLog::where('billing_status', 'unreviewed')->sum('hours'),
            'approved' => (float) TicketWorkLog::where('billing_status', 'approved')->sum('billable_hours'),
            'non_billable' => (float) TicketWorkLog::where('billing_status', 'non_billable')->sum('hours'),
        ];

        return view('livewire.admin.support.billing-review', [
            'logs' => $logs,
            'rates' => $rates,
            'summary' => $summary,
            'developers' => User::withPermission('work-support-tickets')->orderBy('name')->get(['users.id', 'users.name']),
            'currency' => config('support.currency'),
        ]);
    }
}
