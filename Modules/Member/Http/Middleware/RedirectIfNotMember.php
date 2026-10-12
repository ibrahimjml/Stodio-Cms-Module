<?php

namespace Modules\Member\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotMember
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $guard = 'member')
    {
        if (! Auth::guard($guard)->check()) {
            return redirect(route('auth.login.index'));
        }

        return $next($request);
    }
}
