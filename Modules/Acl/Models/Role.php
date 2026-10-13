<?php

namespace Modules\Acl\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Acl\Database\Factories\RoleFactory;
use Modules\Acl\Traits\RoleHasSlug;
use Modules\Auditlog\Traits\AuditableLog;

#[Table('roles')]
#[Fillable(['slug', 'name', 'is_default', 'created_by', 'updated_by'])]
#[UseFactory(RoleFactory::class)]
class Role extends Model
{
    use AuditableLog, HasFactory, RoleHasSlug;

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = self::createSlug($model->name);
            }
        });

        static::deleted(function (self $model) {
            $model->users()->detach();
            $model->permissions()->detach();
        });
    }

    public function delete(): ?bool
    {
        if ($this->exists) {
            $this->users()->detach();
            $this->permissions()->detach();
        }

        return parent::delete();
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id')->withTimestamps();
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    /**
     * @return BelongsToMany<Permission, $this>
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id')->withTimestamps();
    }

    public function hasPermission(string|Permission $permission): bool
    {
        $needle = $permission instanceof Permission ? $permission->name : $permission;

        if ($this->relationLoaded('permissions')) {
            return $this->permissions->contains(fn (Permission $p) => $p->name === $needle || $p->slug === $needle);
        }

        return $this->permissions()->where('name', $needle)->orWhere('slug', $needle)->exists();
    }

    public function givePermissionTo(string|Permission|array $permissions): static
    {
        $permissions = is_array($permissions) ? $permissions : [$permissions];

        $ids = collect($permissions)->map(function (string|Permission $permission) {
            if ($permission instanceof Permission) {
                return $permission->getKey();
            }

            return Permission::query()->where('name', $permission)->orWhere('slug', $permission)->value('id');
        })->filter()->all();

        $this->permissions()->syncWithoutDetaching($ids);

        $this->unsetRelation('permissions');

        return $this;
    }

    public function syncPermissions(array $permissions): static
    {
        $ids = collect($permissions)->map(function (string|int|Permission $permission) {
            if ($permission instanceof Permission) {
                return $permission->getKey();
            }

            if (is_numeric($permission)) {
                return (int) $permission;
            }

            return Permission::query()->where('name', $permission)->orWhere('slug', $permission)->value('id');
        })->filter()->all();

        $this->permissions()->sync($ids);
        $this->unsetRelation('permissions');

        return $this;
    }
}
