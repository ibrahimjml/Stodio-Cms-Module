<?php

namespace Modules\TwoFactor\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;
use Modules\TwoFactor\Models\TwoFactor;

class DisableTwoFactorAction
{
    public function __construct(protected ConfirmTwoFactorAction $confirm) {}

    public function __invoke(Authenticatable $user, string $code): void
    {
        $twoFactor = TwoFactor::query()
            ->where('reference_id', $user->getKey())
            ->where('reference_type', $user->getMorphClass())
            ->first();

        if (! $twoFactor) {
            throw ValidationException::withMessages([
                'code' => __('Two-factor authentication is not enabled.'),
            ]);
        }

        ($this->confirm)($user, $code);

        $twoFactor->delete();
    }
}
