<?php

namespace Modules\Acl\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Acl\Exceptions\LoginException;
use Modules\Acl\Http\Requests\Auth\LoginRequest;
use Modules\Acl\Services\Auth\LoginAdminService;

class LoginController
{
    public function login(): View
    {
        return view('acl::admin.auth.login');
    }

    public function authenticate(LoginRequest $request, LoginAdminService $loginService): JsonResponse
    {
        try {
            $loginService->handleLogin($request->toDTO());

            $message = 'Logged in successfully.';

            session()->flash('success', $message);

            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('admin.dashboard'),
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

    public function logout(LoginAdminService $loginService): RedirectResponse
    {
        $loginService->logout();

        session()->flash('success', 'Logged out successfully.');

        return to_route('admin.login');
    }
}
