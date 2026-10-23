<?php

namespace Modules\Acl\Services\Auth;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use Modules\Acl\Dto\AdminLoginDto as LoginDto;
use Modules\Acl\Exceptions\LoginException;
use Modules\Acl\Models\User;

class LoginAdminService
{
    public function handleLogin(LoginDto $dto): User|RedirectResponse
    {
        return app(Pipeline::class)
            ->send($dto)
            ->through(apply_filter(ACL_LOGIN_PIPELINE, [
                function (LoginDto $dto, Closure $next) {
                    $this->validateCredentials($dto);

                    $user = $this->findUser($dto);

                    $this->validateUser($user);

                    Auth::guard('web')->login($user, $dto->remember);

                    return $next($dto);
                },
            ], $dto))
            ->then(function (LoginDto $dto) {
                $user = Auth::guard('web')->user();

                session()->regenerate();

                $user->forceFill(['last_login' => now()])->save();

                do_action(LOG_AUTH_ACTION_AFTER_LOGIN_SYSTEM, $user);

                return $user;
            });
    }

    public function logout(): void
    {
         $user = Auth::guard('web')->user();
         Auth::guard('web')->logout();
         
        session()->invalidate();
        session()->regenerateToken();

        do_action(LOG_AUTH_ACTION_AFTER_LOGOUT_SYSTEM, $user);
    }
    
    private function validateCredentials(mixed $dto): void
    {
        if (! Auth::guard('web')->validate($dto->credentials())) {
            throw LoginException::invalidCredentials();
        }
    }
    private function findUser(LoginDto $dto): User
    {
        return User::query()
            ->where($dto->loginType, $dto->login)
            ->first()
            ?? throw LoginException::invalidCredentials();
    }

    private function validateUser(User $user): void
    {
        if (! ($user->isSuperUser() || $user->hasPermission(ACL_ADMIN_ACCESS))) {
            throw LoginException::notAuthorized();
        }

    }
}
