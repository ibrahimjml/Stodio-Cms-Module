<?php

namespace Modules\TwoFactor\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\TwoFactor\Actions\DisableTwoFactorAction;
use Modules\TwoFactor\Actions\EnableTwoFactorAction;
use Modules\TwoFactor\Http\Requests\ConfirmTwoFactorRequest;

class TwoFactorController
{
    public function enable(
        ConfirmTwoFactorRequest $request,
        EnableTwoFactorAction $enable
    ): JsonResponse {
        $enable($request->user(), $request->code());

        return response()->json([
            'enabled' => true,
            'message' => __('Two Factor Enables Successfully'),
        ]);
    }

    public function disable(
        ConfirmTwoFactorRequest $request,
        DisableTwoFactorAction $disable
    ): JsonResponse {
        $disable($request->user(), $request->code());

        return response()->json([
            'disabled' => true,
            'message' => __('Two Factor Disabled Successfully'),
        ]);
    }
}
