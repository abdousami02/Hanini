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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
			$table->string('phone', 50)->unique()->nullable();
			$table->string('email', 50)->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
			$table->string('password', 255);
			$table->enum('user_type', array('super_admin', 'staff', 'seller'))->default('staff');
			$table->tinyInteger('status')->default('1');
			$table->tinyInteger('is_active')->default('0');
            $table->rememberToken();
			$table->datetime('last_login')->nullable();
			$table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
