<?php

namespace App\Http\Livewire\Admin\AnnouncementsPage;

use App\Models\Bilta\Announcement;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeAnnouncements extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = '';
    public $filterPriority = '';
    public $viewingAnnouncement = null;

    public function render()
    {
        $query = Announcement::published()
            ->notArchived()
            ->with(['creator', 'media']);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        if ($this->filterPriority) {
            $query->where('priority', $this->filterPriority);
        }

        $announcements = $query->orderByRaw("FIELD(priority, 'high', 'normal', 'low')")
            ->orderBy('publish_date', 'desc')
            ->paginate(15);

        // Get unread count for current user
        $unreadCount = Announcement::published()
            ->notArchived()
            ->whereDoesntHave('reads', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->count();

        return view('livewire.admin.announcements-page.employee-list', compact('announcements', 'unreadCount'));
    }

    public function viewAnnouncement($id)
    {
        $this->viewingAnnouncement = Announcement::with(['creator', 'media'])->findOrFail($id);

        // Mark as read
        $this->viewingAnnouncement->markAsRead(auth()->id());
    }

    public function closeView()
    {
        $this->viewingAnnouncement = null;
    }

    public function isRead($announcementId)
    {
        return \App\Models\Bilta\AnnouncementRead::where('announcement_id', $announcementId)
            ->where('user_id', auth()->id())
            ->exists();
    }
}
