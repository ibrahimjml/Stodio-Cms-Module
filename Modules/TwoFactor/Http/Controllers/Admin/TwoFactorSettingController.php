<?php

namespace Modules\TwoFactor\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;
use Modules\Core\Models\Setting;

class TwoFactorSettingController
{

    #[Middleware('permission:twofactor.settings.update')]
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'twofactor_enabled' => ['sometimes', 'boolean'],
        ]);

        $on = $request->boolean('twofactor_enabled');

        Setting::set('twofactor.enabled', $on ? 1 : 0);

        $message = $on
             ? __('Two Factor Turned On.')
             : __('Two Factor Turned Off.');

        return Redirect::back()->with('success', $message);
    }

}
