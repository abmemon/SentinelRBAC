<?php

namespace ABMemon\SentinelRBAC\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!auth()->check() || !auth()->user()->hasPermission($permission)) {
            abort(403);
        }

        return $next($request);
    }
}
