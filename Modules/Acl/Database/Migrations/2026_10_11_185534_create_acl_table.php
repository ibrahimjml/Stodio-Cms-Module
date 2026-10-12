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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 120)->unique();
            $table->string('name')->unique();
            $table->tinyInteger('is_default')->unsigned()->default(0);
            $table->foreignId('created_by')->index();
            $table->foreignId('updated_by')->index();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('name')->unique();
            $table->string('module');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id');
            $table->foreignId('user_id');
            $table->primary(['role_id', 'user_id']);
            $table->nullableTimestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('permission_id');
            $table->foreignId('role_id');
            $table->primary(['permission_id', 'role_id']);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
