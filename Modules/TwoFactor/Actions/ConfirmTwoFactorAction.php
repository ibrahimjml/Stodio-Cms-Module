<?php

namespace Modules\TwoFactor\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;
use Modules\TwoFactor\Models\TwoFactor;
use Modules\TwoFactor\Services\TwoFactorService;

class ConfirmTwoFactorAction
{
    public function __construct(protected TwoFactorService $twoFactorService) {}

    public function __invoke(Authenticatable $user, string $code): void
    {
        $twoFactor = TwoFactor::query()
            ->where('reference_id', $user->getKey())
            ->where('reference_type', $user->getMorphClass())
            ->first();

        if (! $twoFactor || ! $twoFactor->secret) {
            throw ValidationException::withMessages([
                'code' => __('The provided two factor authentication code was invalid.'),
            ]);
        }

        if ($recoveryCode = $this->validRecoveryCode($twoFactor, $code)) {
            $twoFactor->replaceRecoveryCode($recoveryCode);
        } elseif (! $this->twoFactorService->verify($twoFactor->secret, $code)) {
            throw ValidationException::withMessages([
                'code' => __('The provided two factor authentication code was invalid.'),
            ]);
        }
    }

    protected function validRecoveryCode(TwoFactor $twoFactor, string $recoveryCode): ?string
    {
        return collect($twoFactor->recoveryCodes())
            ->first(fn ($code) => hash_equals($code, $recoveryCode));
    }
}
