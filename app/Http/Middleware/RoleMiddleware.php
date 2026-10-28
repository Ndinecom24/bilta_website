<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next, $role, $permission = null)
    {
        $user = $request->user();

        if (!$user) {
            abort(404);
        }

        // Allow comma-separated or pipe-separated roles: e.g. 'admin,super-admin' or 'admin|system-admin'
        $roles = preg_split('/[,|]/', $role);
        $hasAnyRole = collect($roles)->contains(function ($r) use ($user) {
            return $user->hasRole(trim($r));
        });

        if (!$hasAnyRole) {
            abort(404);
        }

        if ($permission !== null && !$user->can($permission)) {
            abort(404);
        }

        return $next($request);
    }
}
