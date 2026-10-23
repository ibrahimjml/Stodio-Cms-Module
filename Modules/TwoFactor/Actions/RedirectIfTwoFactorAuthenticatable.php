<?php

namespace Modules\TwoFactor\Actions;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\Acl\Models\User;
use Modules\Acl\Dto\AdminLoginDto as LoginDto;
use Modules\TwoFactor\Models\TwoFactor;

class RedirectIfTwoFactorAuthenticatable
{
    public function handle(LoginDto $dto, Closure $next)
    {
        $user = User::where($dto->loginType, $dto->login)->first();

        if ($user
            && TwoFactor::userEnabled($user)
            && Auth::guard('web')->validate($dto->credentials())) {
            session()->put('login.id', $user->getKey());
            session()->put('login.remember', $dto->remember);

            return redirect()->route('twofactor.challenge.index');
        }

        return $next($dto);
    }
}