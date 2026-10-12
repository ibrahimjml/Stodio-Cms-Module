<?php

namespace Modules\Acl\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Modules\Acl\Http\Requests\Admin\StoreUserRequest;
use Modules\Acl\Http\Requests\Admin\UpdateUserRequest;
use Modules\Acl\Models\Role;
use Modules\Acl\Models\User;
use Modules\Acl\Policies\UserPolicy;

class UserController
{
  
    #[Middleware('permission:acl.users.view')]
    public function index(): View
    {
        $users = User::query()->with('roles')->latest()->paginate(10)->withQueryString();

        return view('acl::admin.users.index', compact('users'));
    }

    #[Middleware('permission:acl.users.create')]
    public function create(): View
    {
        $roles = Role::query()->orderBy('name')->get();

        return view('acl::admin.users.create', compact('roles'));
    }

    #[Middleware('permission:acl.users.create')]
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::query()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'super_user' => $this->canManageSupers($request->user()) ? (bool) ($validated['super_user'] ?? false) : false,
        ]);

        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->route('admin.acl.users.index')->with('success', __('User has been created.'));
    }

    #[Middleware('permission:acl.users.edit')]
    public function edit(User $user): View
    {
        Gate::authorize('update', $user);

        $user->load('roles');
        $roles = Role::query()->orderBy('name')->get();

        return view('acl::admin.users.edit', compact('user', 'roles'));
    }

    #[Middleware('permission:acl.users.edit')]
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);

        $validated = $request->validated();

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        if ($this->canManageSupers($request->user()) && $user->getKey() !== $request->user()->getKey()) {
            $data['super_user'] = (bool) ($validated['super_user'] ?? false);
        }

        $user->update($data);
        $user->syncRoles($validated['roles'] ?? []);

        return redirect()->route('admin.acl.users.index')->with('success', __('User has been updated.'));
    }

    #[Middleware('permission:acl.users.delete')]
    public function destroy(User $user): RedirectResponse
    {
        if (request()->user()?->getKey() === $user->getKey()) {
            return redirect()->route('admin.acl.users.index')->with('error', __('You cannot delete your own account.'));
        }

        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.acl.users.index')->with('success', __('User has been deleted.'));
    }

    #[Middleware('permission:acl.users.edit')]
    public function toggleSuper(User $user): RedirectResponse
    {
        $actor = request()->user();

        if ($actor?->getKey() === $user->getKey()) {
            return redirect()->route('admin.acl.users.index')->with('error', __('You cannot change your own super status.'));
        }

        Gate::authorize('toggleSuper', $user);

        $user->update(['super_user' => ! $user->super_user]);

        return redirect()->route('admin.acl.users.index')->with('success', $user->super_user
            ? __('User is now a super user.')
            : __('Super status has been removed.'));
    }

    private function canManageSupers(mixed $actor): bool
    {
        return $actor instanceof User && UserPolicy::canManageSupers($actor);
    }
}
