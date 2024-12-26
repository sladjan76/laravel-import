<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Checking if logged user has correct permission.
     *
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!auth()->check() || !auth()->user()->hasPermissionTo($permission)) {
            return redirect()->route('auth.logout');
        }

        return $next($request);
    }
}
