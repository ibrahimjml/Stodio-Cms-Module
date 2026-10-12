<?php

namespace Modules\Acl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasPermission(ACL_ADMIN_ACCESS)) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
