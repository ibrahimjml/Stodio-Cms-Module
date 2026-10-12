<?php

namespace Modules\Acl\Actions\User;

use Illuminate\Support\Facades\Hash;
use Modules\Acl\Models\User;

class CreateSuperUserAction
{
    public function handle(array $getUserData): User
    {
        $data = $getUserData;

        $data['password'] = Hash::make($data['password']);

        /** @var User $user */
        $user = User::query()->forceCreate([
            ...$data,
            'super_user' => true,
            'manage_supers' => true,
        ]);

        return $user;
    }
}
