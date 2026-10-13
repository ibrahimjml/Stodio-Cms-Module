<?php

namespace Modules\Acl\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Modules\Acl\Database\Factories\UserFactory;
use Modules\Acl\Traits\HasPermission;
use Modules\Auditlog\Traits\AuditableLog;
use Modules\Core\Enums\UserImage;

#[Table('users')]
#[Fillable(['first_name', 'last_name', 'username', 'avatar', 'email', 'password', 'super_user', 'manage_supers', 'last_login'])]
#[Hidden(['password', 'remember_token'])]
#[UseFactory(UserFactory::class)]
class User extends Authenticatable
{
    use HasFactory, HasPermission, AuditableLog, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'super_user' => 'boolean',
            'manage_supers' => 'boolean',
            'last_login' => 'datetime',
        ];
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst((string) $value),
            set: fn ($value) => ucfirst((string) $value),
        );
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst((string) $value),
            set: fn ($value) => ucfirst((string) $value),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->first_name.' '.$this->last_name,
        );
    }

    public function isSuperUser(): bool
    {
        return $this->super_user;
    }

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: fn (): string => $this->avatar !== UserImage::AVATAR->value
              ? Storage::disk('public')->url('avatars/'.$this->avatar)
              : asset('vendor/core/img/'.UserImage::AVATAR->value),
        );
    }
}
