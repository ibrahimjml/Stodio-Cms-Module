<?php

namespace Modules\Acl\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Acl\Models\User;
use Modules\Acl\Policies\UserPolicy;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        $actor = $this->user();

        if (! $actor instanceof User) {
            return false;
        }

        if (! $actor->can('create', User::class)) {
            return false;
        }

        if (UserPolicy::wantsSuperPrivileges((array) $this->input('roles', []), $this->boolean('super_user'))) {
            return $actor->can('grantSuperPrivileges', User::class);
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
        return [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:60', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'max:60'],
            'super_user' => ['sometimes', 'boolean'],
            'roles' => ['sometimes', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ];
    }
}
