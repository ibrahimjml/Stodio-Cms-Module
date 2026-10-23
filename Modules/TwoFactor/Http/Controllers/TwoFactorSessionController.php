<?php

namespace Modules\TwoFactor\Http\Controllers;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\Acl\Models\User;
use Modules\TwoFactor\Actions\ConfirmTwoFactorAction;
use Modules\TwoFactor\Http\Requests\ConfirmTwoFactorRequest;

class TwoFactorSessionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next) {
            if (! session()->has('login.id')) {
                return redirect()->route('admin.login');
            }

            return $next($request);
        });
    }

    public function challengePage(): View
    {
        return view('twofactor::admin.auth.challenge');
    }

    public function check(
        ConfirmTwoFactorRequest $request,
        ConfirmTwoFactorAction $confirm
    ): JsonResponse {
        $user = User::query()->findOrFail($request->session()->get('login.id'));
        $confirm($user, $request->code() ?: $request->recovery());

        Auth::login($user, $request->session()->get('login.remember', false));

        $user->update(['last_login' => Carbon::now()]);

        session()->regenerate();
        session()->forget(['login.id', 'login.remember']);

        do_action(LOG_AUTH_ACTION_AFTER_LOGIN_SYSTEM, $user);

        return response()->json([
            'success' => true,
            'message' => __('Logged in successfully'),
            'redirect' => route('admin.dashboard'),
        ]);
    }
}
