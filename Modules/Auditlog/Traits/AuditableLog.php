<?php

namespace Modules\Auditlog\Traits;

use Modules\Auditlog\Services\AuditLogService;

trait AuditableLog
{
        /**
     * Boot the auditable log trait
     */
    public static function bootAuditableLog(): void
    {
        static::created(function ($model) {
            self::logModelEvent($model, 'created');
        });

        static::updated(function ($model) {
            self::logModelEvent($model, 'updated');
        });

        static::deleted(function ($model) {
            self::logModelEvent($model, 'deleted');
        });
    }

    /**
     * Log the model event
     */
    protected static function logModelEvent($model, string $action): void
    {
        $module = class_basename($model);
        
        app(AuditLogService::class)->logModelAction(
            module: $module,
            action: $action,
            model: $model,
            type: $action,
        );
    }

    /**
     * Get the module name for audit logging
     */
    protected function getAuditModule(): string
    {
        return class_basename(static::class);
    }
}
