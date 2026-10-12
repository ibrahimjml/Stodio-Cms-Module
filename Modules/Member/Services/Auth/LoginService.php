<?php

namespace Modules\Member\Services\Auth;

use Modules\Member\Dto\Auth\LoginDto;
use Modules\Member\Enums\LoginEnum;
use Modules\Member\Exceptions\LoginException;
use Modules\Member\Models\Member;

class LoginService
{

    public function handleLogin(LoginDto $dto): LoginEnum
    {
        if (! auth('member')->validate($dto->credentials())) {
            throw LoginException::invalidCredentials();
        }

        $user = $this->findUser($dto);

        $this->validateUser($user);

        auth('member')->login($user, $dto->remember);
        session()->regenerate();

        return LoginEnum::SUCCESS;
    }

    private function findUser(LoginDto $dto): Member
    {
        return Member::query()
            ->where($dto->loginType, $dto->login)
            ->first();
    }

    private function validateUser(Member $user): void
    {
        if ($user->is_blocked) {
            throw LoginException::blocked();
        }
    }
}

