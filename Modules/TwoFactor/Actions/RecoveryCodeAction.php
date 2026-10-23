<?php

namespace Modules\TwoFactor\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use Modules\TwoFactor\Models\TwoFactor;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RecoveryCodeAction
{
    public function generate(): string
    {
        return Str::random(10).'-'.Str::random(10);
    }

    public function download(Authenticatable $user): StreamedResponse
    {
        $twoFactor = TwoFactor::query()
            ->where('reference_id', $user->getKey())
            ->where('reference_type', $user->getMorphClass())
            ->first();

        abort_if(! $twoFactor, 404, __('Two-factor authentication is not enabled.'));

        abort_if($twoFactor->recovery_codes_downloaded_at !== null, 410, __('Recovery codes have already been downloaded.'));

        $codes = $twoFactor->recoveryCodes();

        abort_if(! is_array($codes) || $codes === [], 410, __('Recovery codes are unavailable.'));

        $claimed = TwoFactor::query()
            ->whereKey($twoFactor->getKey())
            ->whereNull('recovery_downloaded_at')
            ->update(['recovery_downloaded_at' => now()]);

        abort_if(! $claimed, 410, __('Recovery codes have already been downloaded.'));

        return response()->streamDownload(function () use ($codes) {
            echo implode(PHP_EOL, $codes).PHP_EOL;
        }, 'recovery.txt', [
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ]);
    }
}
