<?php

namespace Modules\Acl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Usage: Route::middleware('role:admin,editor')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user === null) {
            abort(403);
        }

        if (method_exists($user, 'isSuperUser') && $user->isSuperUser()) {
            return $next($request);
        }

        if (! method_exists($user, 'hasAnyRole') || ! $user->hasAnyRole($roles)) {
            abort(403, __('You do not have the required role.'));
        }

        return $next($request);
    }
}
