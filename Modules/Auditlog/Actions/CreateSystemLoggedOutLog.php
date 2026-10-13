<?php

namespace Modules\Auditlog\Actions;

use Modules\Acl\Models\User;
use Modules\Auditlog\Services\AuditLogService;

class CreateSystemLoggedOutLog
{
    public function __construct(
        protected AuditLogService $auditLogService
    ) {}

    public function log(User $user): void
    {
        $this->auditLogService->log(
            module: 'System',
            action: "Logged out",
            userId: $user->getKey(),
            referenceUser: $user->getKey(),
            referenceId: $user->getKey(),
            referenceName: $user->name,
            type: 'info',
        );
    }
}