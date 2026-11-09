<?php

namespace App\Http\Livewire\Admin\Support;

use App\Models\Support\TicketBillingRate;
use App\Models\Support\TicketCategory;
use App\Models\Support\TicketPriority;
use App\Models\Support\TicketSystem;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;

/**
 * Support lookups (categories, modules, priorities) and billing rates.
 * Lookups can only be deactivated, never deleted, so old tickets keep their labels.
 */
class SupportSettings extends Component
{
    public $tab = 'categories';
    public $editingId = null;

    // categories / modules / priorities
    public $name = '';
    public $sort_order = 0;
    public $is_active = true;
    public $level = 1;
    public $target_hours = 72;
    public $color = 'secondary';

    // billing rates
    public $hourly_rate = '';
    public $currency = '';
    public $developer_id = '';
    public $effective_from = '';
    public $effective_to = '';

    public const COLORS = ['success', 'info', 'primary', 'warning', 'danger', 'secondary', 'dark'];

    public function mount()
    {
        $user = auth()->user();
        abort_unless($user->can('manage-support-settings') || $user->can('manage-support-billing'), 403);

        $this->tab = $user->can('manage-support-settings') ? 'categories' : 'rates';
        $this->currency = config('support.currency');
        $this->effective_from = now()->toDateString();
    }

    private function canSettings(): bool
    {
        return auth()->user()->can('manage-support-settings');
    }

    private function canBilling(): bool
    {
        return auth()->user()->can('manage-support-billing');
    }

    private function authorizeTab(string $tab): void
    {
        abort_unless($tab === 'rates' ? $this->canBilling() : $this->canSettings(), 403);
    }

    public function setTab($tab)
    {
        if (!in_array($tab, ['categories', 'systems', 'priorities', 'rates'], true)) {
            return;
        }
        $this->authorizeTab($tab);
        $this->tab = $tab;
        $this->cancel();
    }

    public function cancel()
    {
        $this->resetErrorBag();
        $this->editingId = null;
        $this->name = '';
        $this->sort_order = 0;
        $this->is_active = true;
        $this->level = 1;
        $this->target_hours = 72;
        $this->color = 'secondary';
        $this->hourly_rate = '';
        $this->currency = config('support.currency');
        $this->developer_id = '';
        $this->effective_from = now()->toDateString();
        $this->effective_to = '';
    }

    private function modelFor(string $tab): string
    {
        return [
            'categories' => TicketCategory::class,
            'systems' => TicketSystem::class,
            'priorities' => TicketPriority::class,
            'rates' => TicketBillingRate::class,
        ][$tab];
    }

    public function edit($id)
    {
        $this->authorizeTab($this->tab);
        $row = ($this->modelFor($this->tab))::findOrFail($id);

        $this->cancel();
        $this->editingId = $row->id;
        $this->is_active = (bool) $row->is_active;

        if ($this->tab === 'rates') {
            $this->name = $row->name;
            $this->hourly_rate = $row->hourly_rate;
            $this->currency = $row->currency;
            $this->developer_id = $row->developer_id ?: '';
            $this->effective_from = $row->effective_from->toDateString();
            $this->effective_to = $row->effective_to ? $row->effective_to->toDateString() : '';
        } else {
            $this->name = $row->name;
            if ($this->tab === 'priorities') {
                $this->level = $row->level;
                $this->target_hours = $row->resolution_target_hours;
                $this->color = $row->color;
            } else {
                $this->sort_order = $row->sort_order;
            }
        }
    }

    public function toggleActive($id)
    {
        $this->authorizeTab($this->tab);
        $row = ($this->modelFor($this->tab))::findOrFail($id);
        $row->update(['is_active' => !$row->is_active]);
    }

    private function uniqueSlug(string $model, string $name): string
    {
        $base = Str::slug($name) ?: 'item';
        $slug = $base;
        $i = 2;
        while ($model::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function save()
    {
        $this->authorizeTab($this->tab);

        if ($this->tab === 'rates') {
            return $this->saveRate();
        }

        $rules = ['name' => 'required|string|max:' . ($this->tab === 'priorities' ? 50 : 100)];
        if ($this->tab === 'priorities') {
            $rules += [
                'level' => 'required|integer|min:1|max:10',
                'target_hours' => 'required|integer|min:1|max:8760',
                'color' => 'required|in:' . implode(',', self::COLORS),
            ];
        } else {
            $rules['sort_order'] = 'required|integer|min:0|max:65000';
        }
        $this->validate($rules);

        $model = $this->modelFor($this->tab);
        $data = ['name' => trim($this->name), 'is_active' => (bool) $this->is_active];

        if ($this->tab === 'priorities') {
            $data += ['level' => (int) $this->level, 'resolution_target_hours' => (int) $this->target_hours, 'color' => $this->color];
        } else {
            $data['sort_order'] = (int) $this->sort_order;
        }

        if ($this->editingId) {
            $model::findOrFail($this->editingId)->update($data);
        } else {
            $model::create($data + ['slug' => $this->uniqueSlug($model, $this->name)]);
        }

        $this->cancel();
        session()->flash('success', 'Saved.');
    }

    private function saveRate()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'hourly_rate' => 'required|numeric|min:0|max:100000',
            'currency' => 'required|alpha|size:3',
            'developer_id' => 'nullable|exists:users,id',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $data = [
            'name' => trim($this->name),
            'hourly_rate' => $this->hourly_rate,
            'currency' => strtoupper($this->currency),
            'developer_id' => $this->developer_id ?: null,
            'effective_from' => $this->effective_from,
            'effective_to' => $this->effective_to ?: null,
            'is_active' => (bool) $this->is_active,
        ];

        if ($this->editingId) {
            TicketBillingRate::findOrFail($this->editingId)->update($data);
        } else {
            TicketBillingRate::create($data);
        }

        $this->cancel();
        session()->flash('success', 'Rate saved. Existing approved work keeps the rate it was approved with.');
    }

    public function render()
    {
        $rows = collect();
        switch ($this->tab) {
            case 'categories':
                $rows = TicketCategory::withCount('tickets')->ordered()->get();
                break;
            case 'systems':
                $rows = TicketSystem::withCount('tickets')->ordered()->get();
                break;
            case 'priorities':
                $rows = TicketPriority::withCount('tickets')->ordered()->get();
                break;
            case 'rates':
                $rows = TicketBillingRate::with('developer')->orderByDesc('effective_from')->get();
                break;
        }

        return view('livewire.admin.support.support-settings', [
            'rows' => $rows,
            'canSettings' => $this->canSettings(),
            'canBilling' => $this->canBilling(),
            'colors' => self::COLORS,
            'developers' => User::withPermission('work-support-tickets')->orderBy('name')->get(['users.id', 'users.name']),
        ]);
    }
}
