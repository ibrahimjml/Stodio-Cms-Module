<?php

namespace Modules\Acl\Traits;

trait RoleHasSlug
{
    public static function createSlug(?string $name)
    {
        $slug = strtolower(str_replace(' ', '-', $name));
        $originalSlug = $slug;
        $count = 1;

        do {
            $exists = self::query()->where('slug', $slug)->exists();
            if ($exists) {
                $slug = $originalSlug.'-'.$count;
                $count++;
            }
        } while ($exists);

        return $slug;
    }
}
