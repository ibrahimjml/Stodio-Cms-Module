<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Modules\Core\Models\Setting;

class AuthRulesController
{

    public function index(): View
    {
        return view('core::platform-settings.auth-rules.index');
    }

}
