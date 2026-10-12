<?php

namespace Modules\Acl\Console;

use Illuminate\Console\Command;
use Modules\Acl\Services\PermissionSyncService;

class SyncPermissionsCommand extends Command
{
    protected $signature = 'stodio:acl:sync';

    protected $description = 'Sync permissions declared in Modules/*/Config/permission.php into the database';

    public function handle(PermissionSyncService $syncService): int
    {
        $result = $syncService->sync();

        $this->info("Permissions synced. Total: {$result['total']}, created: {$result['created']}, updated: {$result['updated']}.");

        return self::SUCCESS;
    }
}
