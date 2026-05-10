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
    public function handle(Request $request, Closure $next, $permission)
    {
        if (! $request->user() || ! $request->user()->can($permission)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
