<?php

namespace Modules\Auditlog\Traits;

use Modules\Auditlog\Services\AuditLogService;

trait AuditableLog
{
     /**
     * Attributes hidden during log.
     *
     * @var array<int, string>
     */
    protected static array $auditHidden = [
        'username',
        'password',
        'current_password',
        'password_confirmation',
        'remember_token',
        '_token',
        'token',
        'refresh_token',
        'remember_token'
    ];

     /**
     * @var array<int, string>
     */
    protected static array $auditNoise = [
        'updated_at',
        'last_login',
        'remember_token',
        'password',
    ];

   /**
     * Boot the auditable log trait
     */
    public static function bootAuditableLog(): void
    {
        static::created(function ($model) {
            self::logModelEvent($model, 'created', self::filterAuditAttributes($model->getAttributes()));
        });

        static::updated(function ($model) {
            $changes = array_diff_key($model->getChanges(), array_flip(self::$auditNoise));

            if (empty($changes)) {
                return;
            }

            $original = $model->getOriginal();

            self::logModelEvent(
                $model,
                'warning',
                self::filterAuditAttributes(array_intersect_key($original, $changes)),
            );
        });

        static::deleted(function ($model) {
            self::logModelEvent($model, 'danger', self::filterAuditAttributes($model->getAttributes()));
        });
    }

    /**
     * Log the model event
     */
    protected static function logModelEvent($model, string $action, array $new = []): void
    {
        if ($model instanceof AuditLog) {
            return;
        }

        $module = class_basename($model);
        
       app(AuditLogService::class)->logModelAction(
            module: $module,
            action: $action,
            model: $model,
            type: $action,
            new: $new
        );
    }
     /**
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    protected static function filterAuditAttributes(array $attributes): array
    {
        foreach (array_merge(static::$auditHidden, ['created_at', 'updated_at']) as $hidden) {
            unset($attributes[$hidden]);
        }

        return $attributes;
    }

    /**
     * Get the module name for audit logging
     */
    protected function getAuditModule(): string
    {
        return class_basename(static::class);
    }
}
