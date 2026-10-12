<?php

namespace Modules\Member\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Modules\Member\Enums\LoginEnum;
use Modules\Member\Exceptions\LoginException;
use Modules\Member\Http\Requests\Auth\LoginRequest;
use Modules\Member\Services\Auth\LoginService;

class LoginController
{
    public function login(LoginRequest $request, LoginService $loginService): JsonResponse
    {
        try {
            $result = $loginService->handleLogin($request->toDTO());
            $require_2fa = $result === LoginEnum::TWO_FACTOR_REQUIRED;
            $user = auth('member')->user();
            $message = 'Logged in successfully.';

            session()->flash('success', $message);

            return response()->json([
                'success' => true,
                'message' => $message,
                'require_2fa' => $require_2fa,
                'redirect' => $require_2fa ? route('auth.2fa.confirmation') : route('home'),
            ]);
        } catch (LoginException $e) {
            if (! $request->expectsJson()) {
                session()->flash('error', $e->getMessage());
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function logout()
    {
        auth('member')->logoutCurrentDevice();

        session()->invalidate();
        session()->regenerateToken();
        session()->flash('success', 'Logged out successfully.');

        return to_route('auth.login.index');
    }
}
