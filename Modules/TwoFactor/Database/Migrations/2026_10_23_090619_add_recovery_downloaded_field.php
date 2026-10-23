<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('two_factor_authentications', function (Blueprint $table): void {
            if (! Schema::hasColumn('two_factor_authentications', 'recovery_downloaded_at')) {
                $table->timestamp('recovery_downloaded_at')->nullable()->after('recovery_codes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('two_factor_authentications', function (Blueprint $table): void {
            if (Schema::hasColumn('two_factor_authentications', 'recovery_downloaded_at')) {
                $table->dropColumn('recovery_downloaded_at');
            }
        });
    }
};
