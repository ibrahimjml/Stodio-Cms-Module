<?php

namespace Modules\TwoFactor\Contracts\Services;

interface TwoFactorAuthContract
{
    public function generateSecretKey(): string;

    public function generateQrcodeUrl(string $issueName, string $issueEmail, string $secret): string;

    public function verify(string $secret, string $code): bool;
}