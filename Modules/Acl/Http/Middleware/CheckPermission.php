<?php

namespace Modules\Acl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * Usage: Route::middleware('permission:acl.roles.view,acl.roles.edit')
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        if ($user === null) {
            abort(403);
        }

        if (! method_exists($user, 'hasAnyPermission') || ! $user->hasAnyPermission($permissions)) {
            abort(403, __('You do not have the required permission.'));
        }

        return $next($request);
    }
}
