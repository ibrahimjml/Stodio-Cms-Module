<?php

namespace Modules\Auditlog\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('stodio:auditlogs:clear', 'Clear all activity logs')]
class ClearAllAuditlogCommand extends Command
{
    public function handle(): int
    {
        $this->components->info('Running clear ...');

        $audits = DB::table('audit_logs')->count();

        if($audits === 0){
            $this->components->info('No audits found.');
            return self::SUCCESS;
        }

        DB::statement('TRUNCATE TABLE audit_logs');
        $this->components->info(sprintf('All audits %s Deleted', $audits));

        return self::SUCCESS;
    }
}
