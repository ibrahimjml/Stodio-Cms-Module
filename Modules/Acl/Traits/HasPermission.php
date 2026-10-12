<?php

namespace Modules\Acl\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Modules\Acl\Models\Permission;
use Modules\Acl\Models\Role;

trait HasPermission
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')->withTimestamps();
    }

    public function hasRole(string|Role|array $role): bool
    {
        if ($this->isSuperUser()) {
            return true;
        }

        $roles = is_array($role) ? $role : [$role];

        $assigned = $this->roles()->pluck('slug')->all()
            ?: $this->roles()->pluck('name')->all();

        // get from loaded relation
        if ($this->relationLoaded('roles')) {
            $assigned = $this->roles->flatMap(fn (Role $r) => [$r->slug, $r->name])->all();
        }

        foreach ($roles as $item) {
            $needle = $item instanceof Role ? ($item->slug ?? $item->name) : $item;
            if (in_array($needle, $assigned, true)) {
                return true;
            }
        }

        return false;
    }

    public function hasAnyRole(string|Role|array ...$roles): bool
    {
        $flat = count($roles) === 1 && is_array($roles[0]) ? $roles[0] : $roles;

        foreach ($flat as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission(string|Permission $permission): bool
    {
        if ($this->isSuperUser()) {
            return true;
        }

        $needle = $permission instanceof Permission
            ? ($permission->name ?: $permission->slug)
            : $permission;

        return $this->getAllPermissions()->contains(fn (Permission $p) => $p->name === $needle || $p->slug === $needle);
    }

    public function hasAnyPermission(string|Permission|array ...$permissions): bool
    {
        $flat = count($permissions) === 1 && is_array($permissions[0]) ? $permissions[0] : $permissions;

        foreach ($flat as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function getAllPermissions(): Collection
    {
        if ($this->relationLoaded('roles')) {
            $this->loadMissing('roles.permissions');
        } else {
            $this->loadMissing('roles.permissions');
        }

        /** @var Collection<int, Permission> $permissions */
        $permissions = $this->roles->flatMap(fn (Role $role) => $role->permissions)->unique('id')->values();

        return $permissions;
    }

    public function assignRole(string|Role|array $roles): static
    {
        $roles = is_array($roles) ? $roles : [$roles];

        $ids = collect($roles)->map(function (string|Role $role) {
            if ($role instanceof Role) {
                return $role->getKey();
            }

            return Role::query()->where('slug', $role)->orWhere('name', $role)->value('id');
        })->filter()->all();

        $this->roles()->syncWithoutDetaching($ids);

        $this->unsetRelation('roles');

        return $this;
    }

    public function removeRole(string|Role $role): static
    {
        $id = $role instanceof Role
            ? $role->getKey()
            : Role::query()->where('slug', $role)->orWhere('name', $role)->value('id');

        if ($id !== null) {
            $this->roles()->detach($id);
            $this->unsetRelation('roles');
        }

        return $this;
    }

    public function syncRoles(array $roles): static
    {
        $ids = collect($roles)->map(function (string|int|Role $role) {
            if ($role instanceof Role) {
                return $role->getKey();
            }

            if (is_numeric($role)) {
                return (int) $role;
            }

            return Role::query()->where('slug', $role)->orWhere('name', $role)->value('id');
        })->filter()->all();

        $this->roles()->sync($ids);
        $this->unsetRelation('roles');

        return $this;
    }
}
