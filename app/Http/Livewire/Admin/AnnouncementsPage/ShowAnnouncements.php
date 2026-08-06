<?php

namespace App\Http\Livewire\Admin\AnnouncementsPage;

use App\Models\Bilta\Announcement;
use App\Models\System\Status;
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
    public $status_id;
    public $attachments = [];

    // UI state
    public $updateItem = false;
    public $announcement;
    public $search = '';
    public $filterType = '';
    public $filterPriority = '';
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
    ];

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

        $announcements = $query->orderBy('publish_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $statuses = Status::get();

        return view('livewire.admin.announcements-page.index', compact('announcements', 'statuses'));
    }

    public function store()
    {
        $this->validate();

        try {
            $announcement = Announcement::create([
                'title' => $this->title,
                'type' => $this->type,
                'content' => $this->content,
                'publish_date' => $this->publish_date,
                'expiry_date' => $this->expiry_date,
                'priority' => $this->priority,
                'visibility' => $this->visibility,
                'status_id' => $this->status_id,
                'created_by' => auth()->id(),
            ]);

            $this->saveAttachments($announcement);

            session()->flash('success', 'Announcement created successfully!');
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
        $this->updateItem = true;

        $this->dispatchBrowserEvent('load-trix-content', ['content' => $item->content ?? '']);
    }

    public function update()
    {
        $this->validate();

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
                'status_id' => $this->status_id,
            ]);

            $this->saveAttachments($announcement);

            session()->flash('success', 'Announcement updated successfully!');
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
