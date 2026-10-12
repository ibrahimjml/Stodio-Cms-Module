<?php

namespace Modules\Auditlog\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;
use Modules\Auditlog\Models\AuditLog;

class AuditLogController
{
    #[Middleware('permission:auditlog.view')]
    public function index(): View
    {
        $auditLogs = AuditLog::query()->with('user')->latest()->paginate(3);

        return view('auditlog::admin.index', compact('auditLogs'));
    }

    #[Middleware('permission:auditlog.delete')]
    public function destroy(AuditLog $auditLog): RedirectResponse
    {
        $auditLog->delete();

        return redirect()->route('auditlog.index');
    }

    #[Middleware('permission:auditlog.delete')]
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:audit_logs,id'],
        ]);

        AuditLog::query()->whereKey($validated['ids'])->delete();

        return redirect()->route('auditlog.index')->with('success', __('Selected audit logs have been deleted.'));
    }
}
