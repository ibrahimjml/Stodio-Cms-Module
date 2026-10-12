<?php

namespace Modules\Member\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Member\Dto\Auth\LoginDto;
use Modules\Member\Rules\UsernameOrEmail;

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
            'login' => ['required', 'string', new UsernameOrEmail()],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ];
    }
    public function toDTO(): LoginDto
    {
        return LoginDto::fromRequest($this->validated());
    }
}
