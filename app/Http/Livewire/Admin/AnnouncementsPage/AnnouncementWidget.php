<?php

namespace App\Http\Livewire\Admin\AnnouncementsPage;

use App\Models\Bilta\Announcement;
use Livewire\Component;

class AnnouncementWidget extends Component
{
    public $limit = 5;

    public function render()
    {
        $latestAnnouncements = Announcement::published()
            ->notArchived()
            ->with('creator')
            ->orderByRaw("FIELD(priority, 'high', 'normal', 'low')")
            ->orderBy('publish_date', 'desc')
            ->limit($this->limit)
            ->get();

        $unreadCount = Announcement::published()
            ->notArchived()
            ->whereDoesntHave('reads', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->count();

        return view('livewire.admin.announcements-page.widget', compact('latestAnnouncements', 'unreadCount'));
    }
}
