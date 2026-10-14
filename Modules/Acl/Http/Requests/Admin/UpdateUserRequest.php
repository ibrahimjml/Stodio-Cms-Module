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

        $section = $this->input('section', 'profile');

        if ($section === 'roles') {
            if (! UserPolicy::canManageSupers($actor)) {
                return false;
            }

            if (UserPolicy::wantsSuperPrivileges((array) $this->input('roles', []), $this->boolean('super_user'))) {
                return $actor->can('grantSuperPrivileges', User::class);
            }
        }

        return true;
    }
     protected function prepareForValidation(): void
          {
             if ($this->has('email')) {
                  $this->merge([
                      'email' => strip_tags(strtolower((string) $this->input('email'))),
                  ]);
               }   
          }
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $routeUser = $this->route('user');

        $userId = is_object($routeUser) ? $routeUser->getKey() : $routeUser;
        $section = $this->input('section', 'profile');

        $rules = [
            'section' => ['sometimes', 'in:profile,password,roles,avatar'],
        ];

        return match ($section) {
            'password' => $rules + [
                'current_password' => ['required', 'string', 'current_password:web'],
                'password' => ['required', 'string', 'min:8', 'max:60', 'confirmed'],
            ],
            'roles' => $rules + [
                'super_user' => ['sometimes', 'boolean'],
                'roles' => ['sometimes', 'array'],
                'roles.*' => ['integer', 'exists:roles,id'],
            ],
            'avatar' => $rules + [
                'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:min_width=128,min_height=128'],
            ],
            default => $rules + [
                'first_name' => ['required', 'string', 'max:120'],
                'last_name' => ['required', 'string', 'max:120'],
                'username' => ['required', 'string', 'max:60', Rule::unique('users', 'username')->ignore($userId)],
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            ],
        };
    }
}
