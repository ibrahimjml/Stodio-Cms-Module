<?php

namespace Modules\TwoFactor\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\TwoFactor\Actions\RecoveryCodeAction;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class DownloadRecoveyController
{
    public function __invoke(
        Request $request,
        RecoveryCodeAction $recovery
    ): StreamedResponse|RedirectResponse {
        try {
            return $recovery->download($request->user());
        } catch (HttpExceptionInterface $exception) {
            return back()->with('error', $exception->getMessage() ?: __('Unable to download recovery codes.'));
        }
    }
}
