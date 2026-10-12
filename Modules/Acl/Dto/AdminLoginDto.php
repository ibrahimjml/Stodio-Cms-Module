<?php

namespace Modules\Acl\Dto;

class AdminLoginDto
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
        public readonly string $loginType,
        public readonly ?bool $remember,
    ) {}

    public static function fromRequest(array $validated): self
    {
        $login = $validated['login'];

        return new self(
            login: $login,
            password: $validated['password'],
            loginType: filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username',
            remember: (bool) ($validated['remember'] ?? false),
        );
    }

    public function credentials(): array
    {
        return [
            $this->loginType => $this->login,
            'password' => $this->password,
        ];
    }
}
