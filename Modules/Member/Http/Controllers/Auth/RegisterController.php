<?php

namespace Modules\Member\Http\Controllers\Auth;

use Modules\Member\Http\Requests\Auth\RegisterRequest;
use Modules\Member\Services\Auth\RegisterService;
use Modules\Member\Exceptions\RegisterException;

class RegisterController
{
    public function register(RegisterRequest $request, RegisterService $service)
    {
        abort_unless_require_registration();
        try {
            $result = $service->register($request->toDTO());

            $message = $result['message'];
            session()->flash('success', $message);

            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('auth.register.index'),
            ]);
        } catch (RegisterException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
