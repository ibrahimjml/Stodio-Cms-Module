<?php

namespace Modules\Acl\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;
use Modules\Acl\Http\Requests\Admin\StoreRoleRequest;
use Modules\Acl\Http\Requests\Admin\UpdateRoleRequest;
use Modules\Acl\Models\Permission;
use Modules\Acl\Models\Role;

class RoleController
{
    #[Middleware('permission:acl.roles.view')]
    public function index(): View
    {
        $roles = Role::query()->with(['author'])->withCount(['users', 'permissions'])->latest()->paginate(10)->withQueryString();

        return view('acl::admin.roles.index', compact('roles'));
    }

    #[Middleware('permission:acl.roles.create')]
    public function create(): View
    {
        $permissions = Permission::query()->orderBy('module')->orderBy('name')->get()->groupBy('module');

        return view('acl::admin.roles.create', compact('permissions'));
    }

    #[Middleware('permission:acl.roles.create')]
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $role = Role::query()->create([
            'name' => $validated['name'],
            'is_default' => $validated['is_default'] ?? false,
            'created_by' => $request->user()->getKey(),
            'updated_by' => $request->user()->getKey(),
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.acl.roles.index')->with('success', __('Role has been created.'));
    }

    #[Middleware('permission:acl.roles.view')]
    public function show(Role $role): View
    {
        $role->load(['permissions', 'users']);

        return view('acl::admin.roles.show', compact('role'));
    }

    #[Middleware('permission:acl.roles.edit')]
    public function edit(Role $role): View
    {
        $role->load('permissions');
        $permissions = Permission::query()->orderBy('module')->orderBy('name')->get()->groupBy('module');

        return view('acl::admin.roles.edit', compact('role', 'permissions'));
    }

    #[Middleware('permission:acl.roles.edit')]
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $validated = $request->validated();

        $role->update([
            'name' => $validated['name'],
            'is_default' => $validated['is_default'] ?? false,
            'updated_by' => $request->user()->getKey(),
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.acl.roles.index')->with('success', __('Role has been updated.'));
    }

    #[Middleware('permission:acl.roles.delete')]
    public function destroy(Role $role): RedirectResponse
    {
        $user = request()->user();

        if ($user !== null && method_exists($user, 'hasPermission') && ! $user->isSuperUser() && ! $user->hasPermission('acl.roles.delete')) {
            abort(403);
        }

        $role->delete();

        return redirect()->route('admin.acl.roles.index')->with('success', __('Role has been deleted.'));
    }
}
