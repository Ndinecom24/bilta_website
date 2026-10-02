<?php

namespace App\Http\Livewire\System;

use App\Models\Bilta\Click;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserAnalytics extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $since = now()->subDays(30);

        $users = User::with('departmentRelation', 'status')
            ->withCount([
                'clicks as page_views_30d' => function ($query) use ($since) {
                    $query->where('created_at', '>=', $since);
                },
            ])
            ->orderByDesc('page_views_30d')
            ->orderByDesc('logins')
            ->orderBy('name')
            ->paginate(25);

        $totalPageViews = Click::whereNotNull('user_id')
            ->where('created_at', '>=', $since)
            ->count();
        $activeUsers = Click::whereNotNull('user_id')
            ->where('created_at', '>=', $since)
            ->distinct('user_id')
            ->count('user_id');
        $recentLogins = User::where('last_login', '>=', $since)->count();
        $neverLoggedIn = User::whereNull('last_login')->count();
        $topPages = Click::whereNotNull('user_id')
            ->where('created_at', '>=', $since)
            ->selectRaw("COALESCE(NULLIF(page_name, ''), 'Unknown page') as page_name, COUNT(*) as views")
            ->groupBy('page_name')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        return view('livewire.system.user.analytics', compact(
            'users',
            'totalPageViews',
            'activeUsers',
            'recentLogins',
            'neverLoggedIn',
            'topPages'
        ));
    }
}
