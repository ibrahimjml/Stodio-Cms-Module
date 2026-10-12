<?php

namespace Modules\Auditlog\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Auditlog\Events\AuditLogCreatedEvent;
use Modules\Auditlog\Listeners\LogAuditActivity;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        AuditLogCreatedEvent::class => [
            LogAuditActivity::class,
        ],
    ];
}
