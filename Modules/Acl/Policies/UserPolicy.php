<?php

namespace Modules\Acl\Policies;

use Modules\Acl\Models\Role;
use Modules\Acl\Models\User;

class UserPolicy
{
    /**
     * Role slugs granting super-level access.
     *
     * @var array<int, string>
     */
    public const SUPER_ROLE_SLUGS = ['super'];

    public function viewAny(User $actor): bool
    {
        return $actor->hasPermission('acl.users.view');
    }

    public function view(User $actor, User $target): bool
    {
        return $actor->hasPermission('acl.users.view');
    }

    public function create(User $actor): bool
    {
        return $actor->hasPermission('acl.users.create');
    }

    public function update(User $actor, User $target): bool
    {
        if ($actor->is($target)) {
            return true;
        }

        if (! $actor->hasPermission('acl.users.edit')) {
            return false;
        }

        if (self::isProtectedTarget($target) && ! self::canManageSupers($actor)) {
            return false;
        }

        return true;
    }

    public function delete(User $actor, User $target): bool
    {
        if ($actor->is($target)) {
            return false;
        }

        if (! $actor->hasPermission('acl.users.delete')) {
            return false;
        }

        if (self::isProtectedTarget($target) && ! self::canManageSupers($actor)) {
            return false;
        }

        return true;
    }

    public function toggleSuper(User $actor, User $target): bool
    {
        if ($actor->is($target)) {
            return false;
        }

        return self::canManageSupers($actor);
    }

    public function grantSuperPrivileges(User $actor): bool
    {
        return self::canManageSupers($actor);
    }

    public static function isProtectedTarget(User $target): bool
    {
        return (bool) ($target->super_user || $target->manage_supers);
    }

    public static function canManageSupers(User $actor): bool
    {
        return (bool) $actor->manage_supers;
    }

    /**
     *  the requests wants super-level privileges.
     *
     * @param  array<int, int|string>  $roleIds
     */
    public static function wantsSuperPrivileges(array $roleIds, bool $superFlag): bool
    {
        if ($superFlag) {
            return true;
        }

        if ($roleIds === []) {
            return false;
        }

        return Role::query()->whereIn('slug', self::SUPER_ROLE_SLUGS)->whereIn('id', $roleIds)->exists();
    }
}
