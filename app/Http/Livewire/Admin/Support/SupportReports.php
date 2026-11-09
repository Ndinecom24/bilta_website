<?php

namespace App\Http\Livewire\Admin\Support;

use App\Models\Support\TicketCategory;
use App\Models\Support\TicketPriority;
use App\Models\Support\TicketSystem;
use App\Models\User;
use App\Services\Support\SupportReportService;
use Livewire\Component;

class SupportReports extends Component
{
    public const DISPLAY_LIMIT = 300;

    public $type = 'received';
    public $from;
    public $to;
    public $category_id = '';
    public $system_id = '';
    public $priority_id = '';
    public $developer_id = '';

    public function mount()
    {
        abort_unless(auth()->user()->can('view-support-reports'), 403);

        $this->from = now()->startOfMonth()->toDateString();
        $this->to = now()->toDateString();
    }

    public function setType($type)
    {
        if (array_key_exists($type, SupportReportService::TYPES)) {
            $this->type = $type;
        }
    }

    public function thisMonth()
    {
        $this->from = now()->startOfMonth()->toDateString();
        $this->to = now()->toDateString();
    }

    public function lastMonth()
    {
        $this->from = now()->subMonthNoOverflow()->startOfMonth()->toDateString();
        $this->to = now()->subMonthNoOverflow()->endOfMonth()->toDateString();
    }

    public function thisYear()
    {
        $this->from = now()->startOfYear()->toDateString();
        $this->to = now()->toDateString();
    }

    private function filters(): array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'category_id' => $this->category_id,
            'system_id' => $this->system_id,
            'priority_id' => $this->priority_id,
            'developer_id' => $this->developer_id,
        ];
    }

    public function render()
    {
        $user = auth()->user();
        $report = app(SupportReportService::class)->build($this->type, $this->filters(), $user->can('manage-support-billing'));

        $total = count($report['rows']);
        $report['rows'] = array_slice($report['rows'], 0, self::DISPLAY_LIMIT);

        $exportQuery = array_filter($this->filters(), function ($v) {
            return $v !== '' && $v !== null;
        }) + ['type' => $this->type];

        return view('livewire.admin.support.support-reports', [
            'report' => $report,
            'totalRows' => $total,
            'limit' => self::DISPLAY_LIMIT,
            'types' => SupportReportService::TYPES,
            'exportQuery' => $exportQuery,
            'categories' => TicketCategory::ordered()->get(),
            'systems' => TicketSystem::ordered()->get(),
            'priorities' => TicketPriority::ordered()->get(),
            'developers' => User::withPermission('work-support-tickets')->orderBy('name')->get(['users.id', 'users.name']),
        ]);
    }
}
