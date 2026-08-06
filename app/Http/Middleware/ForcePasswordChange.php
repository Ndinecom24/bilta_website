<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    /**
     * Redirect authenticated users who must change their password.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->password_change == 1) {
            // Allow access to the force-change route itself, logout, and Livewire routes
            $allowed = [
                'force.password.change',
                'logout',
            ];

            if (
                !in_array($request->route()->getName(), $allowed)
                && !$request->is('livewire/*')
            ) {
                return redirect()->route('force.password.change');
            }
        }

        return $next($request);
    }
}
