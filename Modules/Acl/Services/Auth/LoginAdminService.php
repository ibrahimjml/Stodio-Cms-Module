<?php

namespace Modules\Acl\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Dto\AdminLoginDto as LoginDto;
use Modules\Acl\Exceptions\LoginException;
use Modules\Acl\Models\User;
use Modules\Auditlog\Actions\CreateSystemAccessLog;
use Modules\Auditlog\Actions\CreateSystemLoggedOutLog;

class LoginAdminService
{
    public function __construct(
        protected CreateSystemAccessLog $auditLog,
        protected CreateSystemLoggedOutLog $auditlogout
    ) {}

    public function handleLogin(LoginDto $dto): User
    {
        if (! Auth::guard('web')->validate($dto->credentials())) {
            throw LoginException::invalidCredentials();
        }

        $user = $this->findUser($dto);

        $this->validateUser($user);

        Auth::guard('web')->login($user, $dto->remember);

        session()->regenerate();

        if (module_enabled('Auditlog')) {
            $this->auditLog->logAccess($user);
        }

        $user->forceFill(['last_login' => now()])->save();

        return $user;
    }

    public function logout(): void
    {
         $user = Auth::guard('web')->user();
         Auth::guard('web')->logout();
         
        if (module_enabled('Auditlog')) {
            $this->auditlogout->log($user);
        }

        session()->invalidate();
        session()->regenerateToken();
    }

    private function findUser(LoginDto $dto): User
    {
        return User::query()
            ->where($dto->loginType, $dto->login)
            ->first();
    }

    private function validateUser(User $user): void
    {
        if (! ($user->isSuperUser() || $user->hasPermission(ACL_ADMIN_ACCESS))) {
            throw LoginException::notAuthorized();
        }

    }
}
