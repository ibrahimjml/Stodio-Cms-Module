<?php

namespace Modules\Auditlog\Services;

use Illuminate\Http\Request;
use Modules\Auditlog\Events\AuditLogCreatedEvent;

class AuditLogService
{
    public function __construct(
        protected Request $request
    ) {}

    /**
     * Log an audit event manually
     */
    public function log(
        string $module,
        string $action,
        ?int $userId = null,
        ?int $referenceUser = null,
        ?int $referenceId = null,
        ?string $referenceName = null,
        ?string $type = null,
        ?array $request = null,
    ): void {
        event(new AuditLogCreatedEvent(
            module: $module,
            action: $action,
            userId: $userId,
            referenceUser: $referenceUser,
            referenceId: $referenceId,
            referenceName: $referenceName,
            type: $type,
            request: $request,
            userAgent: $this->request->userAgent(),
            ipAddress: $this->request->ip(),
        ));
    }

    /**
     * Auto Log for model action (create/update/delete)
     */
    public function logModelAction(
        string $module,
        string $action,
        $model,
        ?string $type = null,
        array $new = []
    ): void {
         $verb = match (strtolower($action)) {
            'created' => 'Created',
            'warning' => 'Updated',
            'danger' => 'Deleted',
            default => ucfirst($action),
        };

        $this->log(
            module: $module,
            action: "{$verb} {$module} \"{$this->resolveReferenceLabel($model)}\"",
            userId: $this->request->user() ? $this->request->user()->getKey() : 0,
            referenceUser: $this->resolveReferenceUser($model),
            referenceId: $model->getKey(),
            referenceName: $this->resolveReferenceLabel($model, $module),
            type: $type ?? strtolower($action),
            request: [ 'new' => $new ]
        );
    }
     protected function resolveReferenceLabel($model, ?string $module = null): string
    {
        $module ??= class_basename($model);

        foreach (['name', 'title', 'slug'] as $attribute) {
            $value = $model->{$attribute} ?? null;

            if (is_string($value) && $value !== '') {
                return $value;
            }
        }

        return "{$module} #{$model->getKey()}";
    }

    protected function resolveReferenceUser($model): ?int
    {
        if ($model instanceof User) {
            return $model->getKey();
        }

        return $model->user_id ?? null;
    }
}
