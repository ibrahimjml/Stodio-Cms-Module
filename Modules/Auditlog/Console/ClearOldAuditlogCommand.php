<?php

namespace Modules\Auditlog\Console;

use Illuminate\Console\Command;
use Modules\Auditlog\Models\AuditLog;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('stodio:activitylogs:clear:old', 'Clean logs over 30 days')]
class ClearOldAuditlogCommand extends Command
{
    public function handle(): int
    {
        $this->components->info('Running ...');

        $this->call('model:prune', ['--model' => AuditLog::class]);

        $this->components->info('All old logs cleared!');

        return self::SUCCESS;
    }
}
