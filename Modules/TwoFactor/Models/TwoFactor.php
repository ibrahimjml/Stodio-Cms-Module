<?php

namespace Modules\TwoFactor\Models;

use Illuminate\Console\Attributes\Hidden;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\TwoFactor\Actions\RecoveryCodeAction;

#[Table('two_factor_authentications')]
#[Fillable('reference_id', 'reference_type', 'secret', 'recovery_codes')]
#[Hidden('secret', 'recovery_codes')]
class TwoFactor extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'secret' => 'encrypted',
            'recovery_codes' => 'encrypted:array',
            'confirmed_at' => 'datetime',
            'recovery_downloaded_at' => 'datetime',
        ];
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): MorphTo
    {
        return $this->reference();
    }

    public function recoveryCodes(): array
    {
        $codes = $this->recovery_codes;

        if (is_string($codes)) {
            $codes = json_decode($codes, true) ?: [];
        }

        return is_array($codes) ? $codes : [];
    }

    public static function userEnabled(Authenticatable $user): bool
    {
        return self::query()
            ->where('reference_id', $user->getAuthIdentifier())
            ->where('reference_type', $user->getMorphClass())
            ->whereNotNull('confirmed_at')
            ->exists();
    }

    public static function hasDownloadedRecovery(Authenticatable $user): bool
    {
        return self::query()
            ->where('reference_id', $user->getAuthIdentifier())
            ->where('reference_type', $user->getMorphClass())
            ->whereNotNull('recovery_downloaded_at')
            ->exists();
    }

    public function replaceRecoveryCode(string $code): void
    {
        $codes = $this->recoveryCodes();
        $index = array_search($code, $codes, true);

        if ($index === false) {
            return;
        }

        $codes[$index] = app(RecoveryCodeAction::class)->generate();

        $this->forceFill(['recovery_codes' => $codes])->save();
    }
}
