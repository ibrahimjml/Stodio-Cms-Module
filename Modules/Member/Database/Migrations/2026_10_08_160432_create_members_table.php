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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 120);
            $table->string('last_name', 120);
            $table->string('username')->unique()->index();
            $table->timestamp('username_changed_at')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar')->default(UserImage::AVATAR->value);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('member_password_resets', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_password_resets');
    }
};
