<?php

namespace Modules\TwoFactor\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\TwoFactor\Actions\CreateTwoFactorAction;
use Modules\TwoFactor\Actions\GenerateQrCodeAction;

class TwoFactorQrCodeController
{
    public function qrCode(
        Request $request,
        GenerateQrCodeAction $generateQrCode,
        CreateTwoFactorAction $createTwoFactor
    ): JsonResponse {
        $secret = $createTwoFactor($request->user());
        $qrcode = $generateQrCode($request->user(), $secret);

        return response()->json([
            'secret' => $secret,
            'qrcode' => 'data:image/png;base64,'.base64_encode((string) $qrcode),
        ]);
    }
}
