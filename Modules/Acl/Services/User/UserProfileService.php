<?php

namespace Modules\Acl\Services\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Image;
use Modules\Acl\Models\User;
use Modules\Acl\Policies\UserPolicy;
use Modules\Core\Enums\UserImage;
use Modules\Core\Support\AvatarManager;

class UserProfileService
{
    public function update(User $actor, User $target, array $validated): User
    {
        $section = $validated['section'] ?? 'profile';

        return match ($section) {
            'profile' => $this->updateProfile($target, $validated),
            'password' => $this->updatePassword($target, $validated),
            'roles' => $this->updateRoles($actor, $target, $validated),
            'avatar' => $this->updateAvatar($target, $validated),
            default => $this->updateProfile($target, $validated),
        };
    }

    protected function updateProfile(User $target, array $data): User
    {
        $target->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
        ]);

        return $target->refresh();
    }

    protected function updatePassword(User $target, array $data): User
    {
        $target->update([
            'password' => $data['password'],
        ]);

        return $target->refresh();
    }

    protected function updateRoles(User $actor, User $target, array $data): User
    {
        if (UserPolicy::canManageSupers($actor) && $target->getKey() !== $actor->getKey()) {
            $target->update([
                'super_user' => (bool) ($data['super_user'] ?? false),
            ]);
        }

        $target->syncRoles($data['roles'] ?? []);

        return $target->refresh();
    }

    protected function updateAvatar(User $target, array $data): User
    {
        /** @var UploadedFile|null $file */
        $file = $data['avatar'] ?? null;

        if (! $file instanceof UploadedFile) {
            return $target;
        }

        $filename = uniqid().'-'.str()->slug($target->username).'.webp';
        $path = Image::fromUpload($file)
            ->cover(512, 512)
            ->toWebp()
            ->quality(85)
            ->storeAs('users/avatars', $filename, 'public');

        if ($path === false) {
            return $target;
        }

        $this->deleteOldAvatar($target->getRawOriginal('avatar'));

        $target->update(['avatar' => $path]);

        return $target->refresh();
    }

    public function removeAvatar(User $target): User
    {
        $current = $target->getRawOriginal('avatar');

        AvatarManager::delete($current);

        if (! AvatarManager::isDefault($current)) {
            $target->update(['avatar' => UserImage::AVATAR->value]);
        }

        return $target->refresh();
    }

    protected function deleteOldAvatar(?string $avatar): void
    {
        AvatarManager::delete($avatar);
    }
}
