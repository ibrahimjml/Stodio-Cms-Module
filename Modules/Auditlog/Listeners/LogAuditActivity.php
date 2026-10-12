<?php

namespace Modules\Auditlog\Listeners;

use Modules\Auditlog\Events\AuditLogCreatedEvent;
use Modules\Auditlog\Models\AuditLog;


class LogAuditActivity
{
     public function handle(AuditLogCreatedEvent $event): void
    {
         AuditLog::create([
                 'user_agent' => $event->userAgent ?? request()->userAgent(),
                 'ip_address' => $event->ipAddress ?? request()->ip(),
                 'module' => $event->module,
                 'action' => $event->action,
                 'user_id' => $event->userId ?? auth()->id(),
                 'reference_user' => $event->referenceUser,
                 'reference_id' => $event->referenceId,
                 'reference_name' => $event->referenceName,
                 'type' => $event->type,
                 'request' => $event->request,
             ]);
    }
}
