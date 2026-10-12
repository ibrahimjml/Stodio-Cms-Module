<?php

namespace Modules\Acl\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Acl\Dto\AdminLoginDto;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ];
    }

    public function toDTO(): AdminLoginDto
    {
        return AdminLoginDto::fromRequest($this->validated());
    }
}
