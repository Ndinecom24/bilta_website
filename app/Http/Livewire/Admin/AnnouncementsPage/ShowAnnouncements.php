<?php

namespace App\Http\Livewire\Admin\AnnouncementsPage;

use App\Mail\AnnouncementNotificationMail;
use App\Models\Bilta\Announcement;
use App\Models\Bilta\Department;
use App\Models\System\Status;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShowAnnouncements extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Form fields
    public $announcement_id;
    public $title;
    public $type = 'announcement';
    public $content;
    public $publish_date;
    public $expiry_date;
    public $priority = 'normal';
    public $visibility = 'all';
    public $selectedDepartments = [];
    public $selectedUsers = [];
    public $sendEmail = false;
    public $status_id;
    public $attachments = [];

    // UI state
    public $updateItem = false;
    public $announcement;
    public $search = '';
    public $filterType = '';
    public $filterPriority = '';
    public $filterVisibility = '';
    public $filterStatus = '';
    public $showArchived = false;

    protected $listeners = ['deleteAnnouncement' => 'destroy'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'type' => 'required|in:memo,announcement',
        'content' => 'nullable',
        'publish_date' => 'required|date',
        'expiry_date' => 'nullable|date|after_or_equal:publish_date',
        'priority' => 'required|in:low,normal,high',
        'visibility' => 'required|in:all,department,specific',
        'status_id' => 'required|exists:statuses,id',
        'attachments' => 'nullable|array',
        'attachments.*' => 'file|max:20480', // 20MB per file
        'selectedDepartments' => 'nullable|array',
        'selectedUsers' => 'nullable|array',
    ];

    public function updatedVisibility($value)
    {
        // Reset selections when visibility changes
        if ($value === 'all') {
            $this->selectedDepartments = [];
            $this->selectedUsers = [];
        } elseif ($value === 'department') {
            $this->selectedUsers = [];
        } elseif ($value === 'specific') {
            $this->selectedDepartments = [];
        }
    }

    public function render()
    {
        $query = Announcement::query()
            ->with('creator')
            ->withCount('reads');

        if ($this->showArchived) {
            $query->where('is_archived', true);
        } else {
            $query->where('is_archived', false);
        }

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        if ($this->filterPriority) {
            $query->where('priority', $this->filterPriority);
        }

        if ($this->filterVisibility) {
            $query->where('visibility', $this->filterVisibility);
        }

        if ($this->filterStatus) {
            $query->where('status_id', $this->filterStatus);
        }

        $announcements = $query->orderBy('publish_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $statuses = Status::get();
        $departments = Department::orderBy('name')->get();
        $users = User::where('status_id', config('constants.status.active'))
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'position', 'department_id']);

        return view('livewire.admin.announcements-page.index', compact('announcements', 'statuses', 'departments', 'users'));
    }

    /**
     * Get the list of users who should receive this announcement.
     */
    private function getTargetUsers(): \Illuminate\Support\Collection
    {
        if ($this->visibility === 'all') {
            return User::where('status_id', config('constants.status.active'))
                ->whereNotNull('email')
                ->get();
        }

        if ($this->visibility === 'department') {
            return User::where('status_id', config('constants.status.active'))
                ->whereIn('department_id', $this->selectedDepartments)
                ->whereNotNull('email')
                ->get();
        }

        if ($this->visibility === 'specific') {
            return User::where('status_id', config('constants.status.active'))
                ->whereIn('id', $this->selectedUsers)
                ->whereNotNull('email')
                ->get();
        }

        return collect();
    }

    /**
     * Send email notifications to targeted users.
     */
    private function sendAnnouncementEmails(Announcement $announcement)
    {
        if (!$this->sendEmail) {
            return;
        }

        $recipients = $this->getTargetUsers();

        foreach ($recipients as $user) {
            if ($user->email) {
                try {
                    Mail::to($user->email)->queue(new AnnouncementNotificationMail($announcement));
                } catch (\Exception $e) {
                    \Log::error("Failed to send announcement email to {$user->email}: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Build the visible_to JSON payload.
     */
    private function buildVisibleTo(): ?array
    {
        if ($this->visibility === 'department' && !empty($this->selectedDepartments)) {
            return ['department_ids' => array_map('intval', $this->selectedDepartments)];
        }

        if ($this->visibility === 'specific' && !empty($this->selectedUsers)) {
            return ['user_ids' => array_map('intval', $this->selectedUsers)];
        }

        return null;
    }

    public function store()
    {
        $this->validate();

        // Extra validation for targeted visibility
        if ($this->visibility === 'department' && empty($this->selectedDepartments)) {
            $this->addError('selectedDepartments', 'Please select at least one department.');
            return;
        }
        if ($this->visibility === 'specific' && empty($this->selectedUsers)) {
            $this->addError('selectedUsers', 'Please select at least one employee.');
            return;
        }

        try {
            $announcement = Announcement::create([
                'title' => $this->title,
                'type' => $this->type,
                'content' => $this->content,
                'publish_date' => $this->publish_date,
                'expiry_date' => $this->expiry_date,
                'priority' => $this->priority,
                'visibility' => $this->visibility,
                'visible_to' => $this->buildVisibleTo(),
                'status_id' => $this->status_id,
                'created_by' => auth()->id(),
            ]);

            $this->saveAttachments($announcement);
            $this->sendAnnouncementEmails($announcement);

            $emailMsg = $this->sendEmail ? ' Email notifications queued.' : '';
            session()->flash('success', 'Announcement created successfully!' . $emailMsg);
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating announcement: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Announcement::findOrFail($id);
        $this->announcement = $item;
        $this->announcement_id = $item->id;
        $this->title = $item->title;
        $this->type = $item->type;
        $this->content = $item->content;
        $this->publish_date = $item->publish_date?->format('Y-m-d');
        $this->expiry_date = $item->expiry_date?->format('Y-m-d');
        $this->priority = $item->priority;
        $this->visibility = $item->visibility;
        $this->status_id = $item->status_id;
        $this->sendEmail = false;
        $this->updateItem = true;

        // Restore visibility selections from stored data
        $visibleTo = $item->visible_to ?? [];
        $this->selectedDepartments = $visibleTo['department_ids'] ?? [];
        $this->selectedUsers = $visibleTo['user_ids'] ?? [];

        $this->dispatchBrowserEvent('load-trix-content', ['content' => $item->content ?? '']);
    }

    public function update()
    {
        $this->validate();

        // Extra validation for targeted visibility
        if ($this->visibility === 'department' && empty($this->selectedDepartments)) {
            $this->addError('selectedDepartments', 'Please select at least one department.');
            return;
        }
        if ($this->visibility === 'specific' && empty($this->selectedUsers)) {
            $this->addError('selectedUsers', 'Please select at least one employee.');
            return;
        }

        try {
            $announcement = Announcement::findOrFail($this->announcement_id);
            $announcement->update([
                'title' => $this->title,
                'type' => $this->type,
                'content' => $this->content,
                'publish_date' => $this->publish_date,
                'expiry_date' => $this->expiry_date,
                'priority' => $this->priority,
                'visibility' => $this->visibility,
                'visible_to' => $this->buildVisibleTo(),
                'status_id' => $this->status_id,
            ]);

            $this->saveAttachments($announcement);
            $this->sendAnnouncementEmails($announcement);

            $emailMsg = $this->sendEmail ? ' Email notifications queued.' : '';
            session()->flash('success', 'Announcement updated successfully!' . $emailMsg);
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating announcement: ' . $e->getMessage());
        }
    }

    public function archive($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update(['is_archived' => true]);
        session()->flash('success', 'Announcement archived.');
    }

    public function unarchive($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update(['is_archived' => false]);
        session()->flash('success', 'Announcement restored from archive.');
    }

    public function destroy($id)
    {
        try {
            Announcement::findOrFail($id)->delete();
            session()->flash('success', 'Announcement deleted.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting announcement.');
        }
    }

    public function removeFile($mediaId)
    {
        Media::findOrFail($mediaId)->delete();
        $this->announcement = Announcement::find($this->announcement_id);
        session()->flash('success', 'File removed.');
    }

    public function cancel()
    {
        $this->updateItem = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->title = '';
        $this->type = 'announcement';
        $this->content = '';
        $this->publish_date = '';
        $this->expiry_date = '';
        $this->priority = 'normal';
        $this->visibility = 'all';
        $this->selectedDepartments = [];
        $this->selectedUsers = [];
        $this->sendEmail = false;
        $this->status_id = '';
        $this->attachments = [];
        $this->announcement = null;
        $this->announcement_id = null;
    }

    private function saveAttachments(Announcement $announcement)
    {
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $file) {
                $announcement->addMedia($file)
                    ->toMediaCollection('announcement_attachments');
            }
        }
    }
}
