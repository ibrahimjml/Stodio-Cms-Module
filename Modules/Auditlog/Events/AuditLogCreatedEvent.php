<?php

namespace Modules\Auditlog\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuditLogCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public function __construct(
             public readonly string $module,
             public readonly string $action,
             public readonly ?int $userId = null,
             public readonly ?int $referenceUser = null,
             public readonly ?int $referenceId = null,
             public readonly ?string $referenceName = null,
             public readonly ?string $type = null,
             public readonly ?string $request = null,
             public readonly ?string $userAgent = null,
             public readonly ?string $ipAddress = null,
         ) {}
}
