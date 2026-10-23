<?php

namespace Modules\TwoFactor\Services;

use Modules\TwoFactor\Contracts\Services\TwoFactorAuthContract;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Generator;

class TwoFactorService implements TwoFactorAuthContract
{
    public function __construct(protected Google2FA $pragma, protected Generator $generator) {}

    public function generateSecretKey(): string
    {
        return $this->pragma->generateSecretKey();
    }

    public function generateQrcodeUrl(string $issueName, string $issueEmail, string $secret): string
    {
        $otpauth = $this->pragma->getQRCodeUrl(
            $issueName,
            $issueEmail,
            $secret
        );

        $logo = public_path('vendor/core/twofactor/img/lion.png');

        if (! is_file($logo)) {
            $logo = base_path('Modules/TwoFactor/public/img/lion.png');
        }

        $qrcode = $this->generator->format('png')
            ->size(220)
            ->merge($logo, 0.25, true)
            ->backgroundColor(250, 128, 114)
            ->color(0, 0, 0);

        return $qrcode->generate($otpauth);
    }

    public function verify(string $secret, string $code): bool
    {
        return $this->pragma->verifyKey($secret, $code);
    }
}
