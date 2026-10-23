<?php

namespace Modules\TwoFactor\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Modules\TwoFactor\Services\TwoFactorService;

class GenerateQrCodeAction
{
    public function __construct(protected TwoFactorService $twoFactorService) {}

    public function __invoke(Authenticatable $user, string $secret): string
    {
        return $this->twoFactorService->generateQrcodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );
    }
}
