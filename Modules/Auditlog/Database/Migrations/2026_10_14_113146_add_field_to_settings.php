<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Auditlog\Enums\AuditPeriod;

return new class extends Migration
{
 
    public function up(): void
    {
        rescue(function (): void {
            $value = AuditPeriod::NEVER;
            if(module_enabled('Auditlog')){
                $value = AuditPeriod::ONE_MONTH;
            }

            DB::table('settings')->insertOrIgnore([
                'key' => 'audit_log_clear_period',
                'value' => $value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        });
    }

};
