<?php

namespace Modules\Acl\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Modules\Acl\Http\Requests\Admin\StorePermissionRequest;
use Modules\Acl\Http\Requests\Admin\UpdatePermissionRequest;
use Modules\Acl\Models\Permission;

class PermissionController implements HasMiddleware
{
    /**
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:acl.permissions.view', only: ['index', 'show']),
            new Middleware('permission:acl.permissions.create', only: ['create', 'store']),
            new Middleware('permission:acl.permissions.edit', only: ['edit', 'update']),
            new Middleware('permission:acl.permissions.delete', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $permissions = Permission::query()->withCount('roles')->latest()->paginate(15)->withQueryString();

        return view('acl::admin.permissions.index', compact('permissions'));
    }

    public function create(): View
    {
        return view('acl::admin.permissions.create');
    }

    public function store(StorePermissionRequest $request): RedirectResponse
    {
        Permission::query()->create($request->validated());

        return redirect()->route('admin.acl.permissions.index')->with('success', __('Permission has been created.'));
    }

    public function show(Permission $permission): View
    {
        $permission->load('roles');

        return view('acl::admin.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission): View
    {
        return view('acl::admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $permission->update($request->validated());

        return redirect()->route('admin.acl.permissions.index')->with('success', __('Permission has been updated.'));
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        $user = request()->user();

        if ($user !== null && method_exists($user, 'hasPermission') && ! $user->isSuperUser() && ! $user->hasPermission('acl.permissions.delete')) {
            abort(403);
        }

        $permission->delete();

        return redirect()->route('admin.acl.permissions.index')->with('success', __('Permission has been deleted.'));
    }
}
