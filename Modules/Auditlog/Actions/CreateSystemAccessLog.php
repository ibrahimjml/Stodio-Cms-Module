<?php

namespace Modules\Auditlog\Actions;

use Modules\Acl\Models\User;
use Modules\Auditlog\Services\AuditLogService;


class CreateSystemAccessLog
{
    public function __construct(
        protected AuditLogService $auditLogService
    ) {}

    public function logAccess(User $user): void
    {
        $this->auditLogService->log(
            module: 'System',
            action: "Logged in",
            userId: $user->getKey(),
            referenceUser: $user->getKey(),
            referenceId: $user->getKey(),
            referenceName: $user->name,
            type: 'info',
        );
    }
}
