<?php

namespace App\Http\Livewire\Admin\Support;

use App\Models\Support\Ticket;
use App\Models\Support\TicketCategory;
use App\Models\Support\TicketPriority;
use App\Models\Support\TicketSystem;
use App\Services\Support\TicketService;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubmitTicket extends Component
{
    use WithFileUploads;

    public $subject = '';
    public $description = '';
    public $category_id = '';
    public $system_id = '';
    public $priority_id = '';
    public $attachments = [];

    public function mount()
    {
        abort_unless(auth()->user()->can('create', Ticket::class), 403);

        $default = TicketPriority::active()->where('slug', 'medium')->first();
        $this->priority_id = $default ? $default->id : '';
    }

    protected function rules()
    {
        $cfg = config('support.attachments');

        return [
            'subject' => 'required|string|min:5|max:200',
            'description' => 'required|string|min:10|max:10000',
            'category_id' => 'required|exists:ticket_categories,id',
            'system_id' => 'nullable|exists:ticket_systems,id',
            'priority_id' => 'required|exists:ticket_priorities,id',
            'attachments' => 'array|max:' . $cfg['max_files'],
            'attachments.*' => 'file|max:' . $cfg['max_kb'] . '|mimes:' . implode(',', $cfg['mimes']),
        ];
    }

    protected $messages = [
        'attachments.max' => 'You can attach at most :max files.',
        'attachments.*.max' => 'Each attachment must be smaller than 10 MB.',
        'attachments.*.mimes' => 'Attachments must be images (png, jpg, webp), PDF, text/log/csv, Word or Excel files.',
        'category_id.required' => 'Please choose a category.',
        'priority_id.required' => 'Please choose a priority.',
    ];

    public function updatedAttachments()
    {
        try {
            $this->validate(Arr::only($this->rules(), ['attachments', 'attachments.*']));
        } catch (ValidationException $e) {
            $this->attachments = [];
            throw $e;
        }
    }

    public function clearAttachments()
    {
        $this->attachments = [];
    }

    public function submit()
    {
        abort_unless(auth()->user()->can('create', Ticket::class), 403);

        $this->validate();

        $ticket = app(TicketService::class)->create(auth()->user(), [
            'subject' => $this->subject,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'system_id' => $this->system_id,
            'priority_id' => $this->priority_id,
        ], $this->attachments);

        session()->flash('success', 'Ticket ' . $ticket->reference . ' was submitted. The support team has been notified.');

        return redirect()->route('admin.support.show', $ticket->id);
    }

    public function render()
    {
        return view('livewire.admin.support.submit-ticket', [
            'categories' => TicketCategory::active()->ordered()->get(),
            'systems' => TicketSystem::active()->ordered()->get(),
            'priorities' => TicketPriority::active()->ordered()->get(),
        ]);
    }
}
