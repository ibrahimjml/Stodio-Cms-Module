<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table('settings')]
#[Fillable('key', 'value')]
class Setting extends Model
{
    use HasFactory;

    public static function get(string $key, $default = null): mixed
    {
        $value = static::query()
            ->where('key', $key)
            ->value('value');

        if ($value === null) {
            return $default;
        }

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }

    public static function set(string $key, mixed $value = null): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : (is_scalar($value) ? (string) $value : null)],
        );
    }

    public static function where(string $key, string $value): bool
    {
        return static::query()
            ->where('key', $key)
            ->where('value', $value)
            ->exists();
    }
}
