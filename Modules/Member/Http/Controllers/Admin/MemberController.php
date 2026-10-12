<?php

namespace Modules\Member\Http\Controllers\Admin;

use Illuminate\View\View;
use Modules\Member\Models\Member;

class MemberController
{
    public function index(): View
    {
        $members = Member::latest()
            ->paginate(6)
            ->withQueryString();

        return view('member::admin.index', compact('members'));
    }
}
