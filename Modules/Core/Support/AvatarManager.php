<?php

namespace Modules\Core\Support;

use Illuminate\Support\Facades\Storage;
use Modules\Core\Enums\UserImage;

final class AvatarManager
{
    public static function isDefault(?string $avatar): bool
    {
        return $avatar === null || $avatar === '' || $avatar === UserImage::AVATAR->value;
    }

    public static function delete(?string $avatar, string $disk = 'public'): void
    {
        if (self::isDefault($avatar)) {
            return;
        }

        $candidates = str_contains($avatar, '/') ? [$avatar] : ['avatars/'.$avatar];

        foreach ($candidates as $path) {
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        }
    }
}
