<?php

namespace Modules\Acl\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Models\User;

class ShowUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        $actor = $this->user();
        $user = $this->route('user');

        if (! $actor instanceof User || ! $user instanceof User) {
            return false;
        }

        if ($this->query('tab') === '2fa' && ! $this->canShowTwoFactorTab()) {
            abort(404);
        }

        return true;
    }

    public function canShowTwoFactorTab(): bool
    {
        $actor = $this->user();
        $user = $this->route('user');

        return $actor instanceof User
            && $user instanceof User
            && (int) $actor->getKey() === (int) $user->getKey()
            && module_enabled('TwoFactor')
            && (bool) setting('twofactor.enabled');
    }
}
