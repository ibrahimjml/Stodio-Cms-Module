<?php

namespace Modules\TwoFactor\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;
use Modules\TwoFactor\Models\TwoFactor;
use Modules\TwoFactor\Services\TwoFactorService;

class EnableTwoFactorAction
{
    public function __construct(protected TwoFactorService $twoFactorService) {}

    public function __invoke(Authenticatable $user, string $code): void
    {
        $twoFactor = TwoFactor::query()
            ->where('reference_id', $user->getAuthIdentifier())
            ->where('reference_type', $user->getMorphClass())
            ->first();

        if (! $twoFactor || ! $twoFactor->secret) {
            throw ValidationException::withMessages([
                'code' => __('Start the two-factor authentication setup again.'),
            ]);
        }

        if (! $this->twoFactorService->verify($twoFactor->secret, $code)) {
            throw ValidationException::withMessages([
                'code' => __('The provided two-factor authentication code is invalid.'),
            ]);
        }

        $twoFactor->forceFill(['confirmed_at' => now()])->save();
    }
}
