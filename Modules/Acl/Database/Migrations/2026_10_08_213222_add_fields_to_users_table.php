<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Enums\UserImage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
        });

        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name', 120)->nullable();
            }
            if (! Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name', 120)->nullable();
            }
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username', 60)->unique()->nullable();
            }
            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->default(UserImage::AVATAR->value);
            }
            if (! Schema::hasColumn('users', 'super_user')) {
                $table->boolean('super_user')->default(0);
            }
            if (! Schema::hasColumn('users', 'manage_supers')) {
                $table->boolean('manage_supers')->default(0);
            }
            if (! Schema::hasColumn('users', 'last_login')) {
                $table->timestamp('last_login')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            foreach (['first_name', 'last_name', 'username', 'avatar', 'super_user', 'manage_supers', 'last_login'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('users', function (Blueprint $table): void {
            if (! Schema::hasColumn('users', 'name')) {
                $table->string('name');
            }
        });
    }
};
