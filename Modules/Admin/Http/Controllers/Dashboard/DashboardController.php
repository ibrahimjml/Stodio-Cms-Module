<?php

namespace Modules\Admin\Http\Controllers\Dashboard;

use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Modules\Auditlog\Models\AuditLog;
use Modules\Core\Models\Setting;

class DashboardController
{
    #[Middleware('permission:admin.dashboard.view')]
    public function index(): View
    {
        $auditLogs = AuditLog::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        $users = DB::table('users')->count();
        $members = DB::table('members')->where('is_blocked', false)->count();
        $modules = count(Setting::get('activated_modules') ?? []);
        $roles = DB::table('roles')->count();
        $permissions = DB::table('permissions')->count();

        return view('admin::pages.dashboard.index', compact('auditLogs', 'users', 'members', 'modules', 'roles', 'permissions'));
    }

    #[Middleware('permission:admin.posts.view')]
    public function posts(): View
    {
        return view('admin::pages.cms.posts');
    }
}
