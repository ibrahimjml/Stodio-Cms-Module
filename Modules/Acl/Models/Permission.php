<?php

namespace Modules\Acl\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Modules\Acl\Database\Factories\PermissionFactory;
use Modules\Auditlog\Traits\AuditableLog;

#[Table('permissions')]
#[Fillable(['slug', 'name', 'module', 'description'])]
#[UseFactory(PermissionFactory::class)]
class Permission extends Model
{
    use HasFactory, AuditableLog;

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::deleted(function (self $model) {
            $model->roles()->detach();
        });
    }

    /**
     * @return BelongsToMany<Role, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id')->withTimestamps();
    }

    public function delete(): ?bool
    {
        if ($this->exists) {
            $this->roles()->detach();
        }

        return parent::delete();
    }
}
