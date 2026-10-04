<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Check if the authenticated user has the required permission (via Gate).
     *
     * Usage: ->middleware('permission:manage-news')
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $user = $request->user();
        $hasPermission = $user && collect($permissions)->contains(function ($permission) use ($user) {
            return $user->can($permission);
        });

        if (! $hasPermission) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
