<div>
    <div class="d-flex flex-wrap align-items-start justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">User Usage Analytics</h1>
            <p class="text-muted mb-0">Login activity and authenticated page usage over the last 30 days.</p>
        </div>
        <a href="{{ route('system.users') }}" class="btn btn-outline-secondary btn-sm mt-3 mt-sm-0">
            <i class="fas fa-arrow-left mr-1"></i> Back to users
        </a>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Active users (30 days)</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($activeUsers) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Authenticated page views</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPageViews) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Users logged in (30 days)</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($recentLogins) }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Never logged in</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($neverLoggedIn) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-light border small text-muted mb-4" role="note">
        Usage counts are based on authenticated, non-AJAX page requests captured by the existing click tracker. Login totals and last-login dates are recorded on successful sign-in; older page-usage history is only available if it was already captured.
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Most active users</h5>
                    <span class="badge badge-light">{{ $users->total() }} accounts</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>User</th>
                                    <th>Department</th>
                                    <th class="text-right">Logins total</th>
                                    <th class="text-right">Page views</th>
                                    <th>Last login</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </td>
                                        <td>{{ $user->departmentRelation->name ?? ($user->department ?? '—') }}</td>
                                        <td class="text-right">{{ number_format((int) $user->logins) }}</td>
                                        <td class="text-right font-weight-bold">{{ number_format((int) $user->page_views_30d) }}</td>
                                        <td>{{ $user->last_login ? \Illuminate\Support\Carbon::parse($user->last_login)->format('M j, Y H:i') : 'Never' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">No user accounts found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer bg-white d-flex justify-content-center">{{ $users->links() }}</div>
                @endif
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Most visited pages</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="thead-light">
                            <tr><th>Page</th><th class="text-right">Views</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($topPages as $page)
                                <tr>
                                    <td>{{ \Illuminate\Support\Str::limit($page->page_name, 45) }}</td>
                                    <td class="text-right">{{ number_format($page->views) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted py-4">No tracked authenticated page views yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
