<?php

namespace Modules\Member\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Member\Models\Profile;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Enums\UserImage;
use Modules\Member\Database\Factories\MemberFactory;

#[Table('members')]
#[Fillable(['first_name', 'last_name', 'username', 'email', 'password', 'phone', 'avatar', 'is_blocked', 'username_changed_at'])]
#[Hidden(['password', 'remember_token'])]
#[UseFactory(MemberFactory::class)]
class Member extends Authenticatable
{
    use HasFactory, Notifiable;
    /** 
     *  table refrence morph twofactor
     * **/
    public const TABLE = "member";

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'username_changed_at' => 'datetime',
            'is_blocked' => 'boolean',
        ];
    }

    /**
     * @return HasOne<Profile, $this>
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'member_id');
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

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: fn (): string => $this->avatar !== UserImage::AVATAR->value
              ? Storage::disk('public')->url('avatars/'.$this->avatar)
              : asset('vendor/core/img/'.UserImage::AVATAR->value),
        );
    }
}
