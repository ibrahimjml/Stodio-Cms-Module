<?php

namespace Modules\TwoFactor\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Modules\TwoFactor\Models\TwoFactor;
use Modules\TwoFactor\Services\TwoFactorService;

class CreateTwoFactorAction
{
    public function __construct(
        protected TwoFactorService $twoFactorService,
        protected RecoveryCodeAction $recovery
    ) {}

    public function __invoke(Authenticatable $user): string
    {
        $secret = $this->twoFactorService->generateSecretKey();
        $recoveryCodes = Collection::times(8, fn () => $this->recovery->generate())->all();

        TwoFactor::query()->updateOrCreate([
            'reference_id' => $user->getKey(),
            'reference_type' => $user->getMorphClass(),
        ], [
            'secret' => $secret,
            'recovery_codes' => $recoveryCodes
        ]);

        return $secret;
    }
}
