<?php

namespace Modules\Acl\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Acl\Models\User;
use Modules\Acl\Policies\UserPolicy;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        $actor = $this->user();

        if (! $actor instanceof User) {
            return false;
        }

        $target = $this->route('user');

        if (! $target instanceof User) {
            return false;
        }

        if (! $actor->can('update', $target)) {
            return false;
        }

        if (UserPolicy::wantsSuperPrivileges((array) $this->input('roles', []), $this->boolean('super_user'))) {
            return $actor->can('grantSuperPrivileges', User::class);
        }

        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $routeUser = $this->route('user');

        $userId = is_object($routeUser) ? $routeUser->getKey() : $routeUser;

        return [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:60', Rule::unique('users', 'username')->ignore($userId)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8', 'max:60'],
            'super_user' => ['sometimes', 'boolean'],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ];
    }
}
