<?php

namespace App\Services\Support;

use App\Models\Support\Ticket;
use App\Models\Support\TicketWorkLog;
use App\Models\User;
use Carbon\Carbon;

/**
 * Builds report datasets shared by the on-screen report, the PDF and the Excel export.
 *
 * Every report returns:
 *  title, subtitle[], columns[], rows[][], totals[ [label, value] ], numeric[] (column indexes right-aligned)
 *
 * Estimated, actual and billable hours are always separate columns. Monetary amounts are only
 * included when $withAmounts is true (billing permission).
 */
class SupportReportService
{
    public const TYPES = [
        'received' => 'Tickets received',
        'resolved' => 'Tickets resolved',
        'delivered' => 'Features & enhancements delivered',
        'developer' => 'Developer performance',
        'hours' => 'Hours: estimated, actual & billable',
        'outstanding' => 'Outstanding & awaiting closure',
    ];

    /** Category slugs counted as "delivered" product work. */
    private const DELIVERY_CATEGORIES = ['feature-request', 'enhancement', 'change-request'];

    public function build(string $type, array $filters, bool $withAmounts = false): array
    {
        if (!array_key_exists($type, self::TYPES)) {
            $type = 'received';
        }

        $filters = $this->normalise($filters);
        $method = 'report' . ucfirst($type);
        $report = $this->{$method}($filters, $withAmounts);

        $report['type'] = $type;
        $report['subtitle'] = array_merge([$this->describeFilters($type, $filters)], ['Generated ' . now()->format('d M Y H:i')]);

        return $report;
    }

    public function normalise(array $f): array
    {
        $date = function ($v) {
            if (!$v) {
                return null;
            }
            try {
                return Carbon::parse($v)->toDateString();
            } catch (\Throwable $e) {
                return null;
            }
        };

        return [
            'from' => $date($f['from'] ?? null) ?: now()->startOfMonth()->toDateString(),
            'to' => $date($f['to'] ?? null) ?: now()->toDateString(),
            'category_id' => ($f['category_id'] ?? '') !== '' ? (int) $f['category_id'] : null,
            'system_id' => ($f['system_id'] ?? '') !== '' ? (int) $f['system_id'] : null,
            'priority_id' => ($f['priority_id'] ?? '') !== '' ? (int) $f['priority_id'] : null,
            'developer_id' => ($f['developer_id'] ?? '') !== '' ? (int) $f['developer_id'] : null,
        ];
    }

    private function describeFilters(string $type, array $f): string
    {
        $parts = [];
        if ($type !== 'outstanding') {
            $parts[] = 'Period: ' . Carbon::parse($f['from'])->format('d M Y') . ' - ' . Carbon::parse($f['to'])->format('d M Y');
        } else {
            $parts[] = 'Status at ' . now()->format('d M Y');
        }
        foreach (['category_id' => 'Category filter', 'system_id' => 'Module filter', 'priority_id' => 'Priority filter', 'developer_id' => 'Developer filter'] as $k => $label) {
            if ($f[$k]) {
                $parts[] = $label . ' applied';
            }
        }

        return implode(' | ', $parts);
    }

    /** Ticket query with the common (non-date) filters applied. */
    private function tickets(array $f)
    {
        $q = Ticket::query()->with(['category', 'system', 'priority', 'submitter', 'assignee']);

        foreach (['category_id', 'system_id', 'priority_id'] as $col) {
            if ($f[$col]) {
                $q->where('tickets.' . $col, $f[$col]);
            }
        }
        if ($f['developer_id']) {
            $q->where('tickets.assigned_to', $f['developer_id']);
        }

        return $q;
    }

    private function inRange($q, string $column, array $f)
    {
        return $q->whereDate($column, '>=', $f['from'])->whereDate($column, '<=', $f['to']);
    }

    private function h($n): float
    {
        return round((float) $n, 2);
    }

    /* =====================================================================
     |  Reports
     | ===================================================================== */

    private function reportReceived(array $f): array
    {
        $tickets = $this->inRange($this->tickets($f), 'tickets.created_at', $f)->orderBy('tickets.created_at')->get();

        $rows = $tickets->map(function (Ticket $t) {
            return [
                $t->reference,
                $t->created_at->format('d M Y'),
                $t->subject,
                optional($t->category)->name,
                optional($t->system)->name,
                optional($t->priority)->name,
                $t->status_label,
                optional($t->submitter)->name,
                optional($t->assignee)->name ?: 'Unassigned',
            ];
        })->all();

        return [
            'title' => 'Tickets received',
            'columns' => ['Reference', 'Received', 'Subject', 'Category', 'Module', 'Priority', 'Status', 'Submitted by', 'Assigned to'],
            'rows' => $rows,
            'numeric' => [],
            'totals' => [
                ['Tickets received', $tickets->count()],
                ['Still open', $tickets->filter->isOpen()->count()],
                ['Resolved or closed', $tickets->reject->isOpen()->count()],
            ],
        ];
    }

    private function reportResolved(array $f): array
    {
        $tickets = $this->inRange($this->tickets($f)->whereNotNull('tickets.resolved_at'), 'tickets.resolved_at', $f)
            ->orderBy('tickets.resolved_at')->get();

        $totalHours = 0;
        $rows = $tickets->map(function (Ticket $t) use (&$totalHours) {
            $hours = $t->resolved_at->diffInMinutes($t->created_at) / 60;
            $totalHours += $hours;

            return [
                $t->reference,
                $t->subject,
                optional($t->category)->name,
                optional($t->priority)->name,
                optional($t->assignee)->name ?: '-',
                $t->created_at->format('d M Y'),
                $t->resolved_at->format('d M Y'),
                $this->h($hours),
                $t->due_date && $t->resolved_at->toDateString() > $t->due_date->toDateString() ? 'Late' : 'On time',
                $t->status_label,
            ];
        })->all();

        $count = $tickets->count();

        return [
            'title' => 'Tickets resolved',
            'columns' => ['Reference', 'Subject', 'Category', 'Priority', 'Resolved by', 'Received', 'Resolved', 'Hours to resolve', 'Due date', 'Status'],
            'rows' => $rows,
            'numeric' => [7],
            'totals' => [
                ['Tickets resolved', $count],
                ['Average hours to resolve', $count ? $this->h($totalHours / $count) : 0],
            ],
        ];
    }

    private function reportDelivered(array $f): array
    {
        $tickets = $this->inRange(
            $this->tickets($f)
                ->whereNotNull('tickets.resolved_at')
                ->whereIn('tickets.status', Ticket::FINAL_STATUSES)
                ->whereHas('category', function ($q) {
                    $q->whereIn('slug', self::DELIVERY_CATEGORIES);
                }),
            'tickets.resolved_at',
            $f
        )->withSum('workLogs as actual', 'hours')->orderBy('tickets.resolved_at')->get();

        $rows = $tickets->map(function (Ticket $t) {
            return [
                $t->reference,
                $t->subject,
                optional($t->category)->name,
                optional($t->system)->name,
                optional($t->assignee)->name ?: '-',
                $t->resolved_at->format('d M Y'),
                $t->resolution_notes ?: '',
                $this->h($t->actual),
            ];
        })->all();

        $totals = [['Items delivered', $tickets->count()]];
        foreach ($tickets->groupBy(function ($t) {
            return optional($t->category)->name;
        }) as $name => $group) {
            $totals[] = [$name, $group->count()];
        }

        return [
            'title' => 'Features & enhancements delivered',
            'columns' => ['Reference', 'Subject', 'Category', 'Module', 'Delivered by', 'Delivered', 'Summary of delivery', 'Hours worked'],
            'rows' => $rows,
            'numeric' => [7],
            'totals' => $totals,
        ];
    }

    private function reportDeveloper(array $f, bool $withAmounts): array
    {
        $devQuery = User::withPermission('work-support-tickets')->orderBy('name');
        if ($f['developer_id']) {
            $devQuery->where('users.id', $f['developer_id']);
        }
        $developers = $devQuery->get(['users.id', 'users.name']);

        $columns = ['Developer', 'Tickets assigned', 'Resolved', 'Open now', 'Overdue now', 'Avg hours to resolve', 'Hours worked', 'Billable hours (approved)'];
        if ($withAmounts) {
            $columns[] = 'Billable amount (' . config('support.currency') . ')';
        }

        $rows = [];
        $sum = ['assigned' => 0, 'resolved' => 0, 'open' => 0, 'overdue' => 0, 'hours' => 0.0, 'billable' => 0.0, 'amount' => 0.0];

        foreach ($developers as $dev) {
            $own = function () use ($dev, $f) {
                $q = Ticket::where('assigned_to', $dev->id);
                foreach (['category_id', 'system_id', 'priority_id'] as $col) {
                    if ($f[$col]) {
                        $q->where($col, $f[$col]);
                    }
                }

                return $q;
            };

            $assigned = $this->inRange($own(), 'created_at', $f)->count();
            $resolvedQ = $this->inRange($own()->whereNotNull('resolved_at'), 'resolved_at', $f);
            $resolved = (clone $resolvedQ)->count();
            $avgMinutes = (clone $resolvedQ)->selectRaw('avg(timestampdiff(minute, created_at, resolved_at)) as m')->value('m');
            $open = $own()->open()->count();
            $overdue = $own()->overdue()->count();

            $logs = TicketWorkLog::where('developer_id', $dev->id)
                ->whereDate('work_date', '>=', $f['from'])->whereDate('work_date', '<=', $f['to'])
                ->whereHas('ticket', function ($q) use ($f) {
                    foreach (['category_id', 'system_id', 'priority_id'] as $col) {
                        if ($f[$col]) {
                            $q->where($col, $f[$col]);
                        }
                    }
                });
            $hours = (float) (clone $logs)->sum('hours');
            $approved = (clone $logs)->where('billing_status', 'approved');
            $billable = (float) (clone $approved)->sum('billable_hours');
            $amount = (float) (clone $approved)->selectRaw('sum(billable_hours * rate_applied) as a')->value('a');

            $row = [$dev->name, $assigned, $resolved, $open, $overdue, $avgMinutes !== null ? $this->h($avgMinutes / 60) : 0.0, $this->h($hours), $this->h($billable)];
            if ($withAmounts) {
                $row[] = $this->h($amount);
            }
            $rows[] = $row;

            $sum['assigned'] += $assigned;
            $sum['resolved'] += $resolved;
            $sum['open'] += $open;
            $sum['overdue'] += $overdue;
            $sum['hours'] += $hours;
            $sum['billable'] += $billable;
            $sum['amount'] += $amount;
        }

        $totals = [
            ['Tickets assigned', $sum['assigned']],
            ['Resolved', $sum['resolved']],
            ['Open now', $sum['open']],
            ['Hours worked', $this->h($sum['hours'])],
            ['Billable hours (approved)', $this->h($sum['billable'])],
        ];
        if ($withAmounts) {
            $totals[] = ['Billable amount (' . config('support.currency') . ')', $this->h($sum['amount'])];
        }

        return [
            'title' => 'Developer performance',
            'columns' => $columns,
            'rows' => $rows,
            'numeric' => range(1, count($columns) - 1),
            'totals' => $totals,
        ];
    }

    private function reportHours(array $f, bool $withAmounts): array
    {
        $logs = TicketWorkLog::query()
            ->whereDate('work_date', '>=', $f['from'])
            ->whereDate('work_date', '<=', $f['to'])
            ->whereHas('ticket', function ($q) use ($f) {
                foreach (['category_id', 'system_id', 'priority_id'] as $col) {
                    if ($f[$col]) {
                        $q->where($col, $f[$col]);
                    }
                }
                if ($f['developer_id']) {
                    $q->where('assigned_to', $f['developer_id']);
                }
            })
            ->get();

        $ticketIds = $logs->pluck('ticket_id')->unique();
        $tickets = Ticket::with(['category', 'assignee'])->whereIn('id', $ticketIds)->orderBy('reference')->get();
        $byTicket = $logs->groupBy('ticket_id');

        $columns = ['Reference', 'Subject', 'Category', 'Assigned to', 'Estimated hours', 'Actual hours', 'Billable hours (approved)', 'Awaiting billing review', 'Non-billable'];
        if ($withAmounts) {
            $columns[] = 'Billable amount (' . config('support.currency') . ')';
        }

        $tot = ['est' => 0.0, 'act' => 0.0, 'bill' => 0.0, 'unrev' => 0.0, 'non' => 0.0, 'amt' => 0.0];
        $rows = [];

        foreach ($tickets as $t) {
            $g = $byTicket[$t->id];
            $actual = (float) $g->sum('hours');
            $approved = $g->where('billing_status', 'approved');
            $billable = (float) $approved->sum('billable_hours');
            $unrev = (float) $g->where('billing_status', 'unreviewed')->sum('hours');
            $non = (float) $g->where('billing_status', 'non_billable')->sum('hours');
            $amount = (float) $approved->sum(function ($l) {
                return $l->billable_hours * $l->rate_applied;
            });
            $est = (float) $t->estimated_hours;

            $row = [$t->reference, $t->subject, optional($t->category)->name, optional($t->assignee)->name ?: '-',
                $this->h($est), $this->h($actual), $this->h($billable), $this->h($unrev), $this->h($non)];
            if ($withAmounts) {
                $row[] = $this->h($amount);
            }
            $rows[] = $row;

            $tot['est'] += $est;
            $tot['act'] += $actual;
            $tot['bill'] += $billable;
            $tot['unrev'] += $unrev;
            $tot['non'] += $non;
            $tot['amt'] += $amount;
        }

        $totals = [
            ['Estimated hours', $this->h($tot['est'])],
            ['Actual hours', $this->h($tot['act'])],
            ['Billable hours (approved)', $this->h($tot['bill'])],
            ['Awaiting billing review', $this->h($tot['unrev'])],
            ['Non-billable hours', $this->h($tot['non'])],
        ];
        if ($withAmounts) {
            $totals[] = ['Billable amount (' . config('support.currency') . ')', $this->h($tot['amt'])];
        }

        return [
            'title' => 'Hours: estimated, actual & billable',
            'columns' => $columns,
            'rows' => $rows,
            'numeric' => range(4, count($columns) - 1),
            'totals' => $totals,
        ];
    }

    private function reportOutstanding(array $f): array
    {
        $tickets = $this->tickets($f)
            ->where('tickets.status', '!=', Ticket::STATUS_CLOSED)
            ->orderByRaw('tickets.due_date is null')
            ->orderBy('tickets.due_date')
            ->get();

        $rows = $tickets->map(function (Ticket $t) {
            return [
                $t->reference,
                $t->subject,
                optional($t->category)->name,
                optional($t->priority)->name,
                $t->status_label,
                optional($t->assignee)->name ?: 'Unassigned',
                $t->due_date ? $t->due_date->format('d M Y') : '',
                $t->isOverdue() ? 'Yes' : '',
                (int) $t->created_at->diffInDays(now()),
                $t->outstanding_requirements ?: '',
            ];
        })->all();

        return [
            'title' => 'Outstanding & awaiting closure',
            'columns' => ['Reference', 'Subject', 'Category', 'Priority', 'Status', 'Assigned to', 'Due', 'Overdue', 'Days open', 'Outstanding requirements'],
            'rows' => $rows,
            'numeric' => [8],
            'totals' => [
                ['Not yet closed', $tickets->count()],
                ['Awaiting closure (resolved)', $tickets->where('status', Ticket::STATUS_RESOLVED)->count()],
                ['Overdue', $tickets->filter->isOverdue()->count()],
                ['Unassigned', $tickets->whereNull('assigned_to')->count()],
            ],
        ];
    }
}
