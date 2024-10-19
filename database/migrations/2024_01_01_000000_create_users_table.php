<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->text('first_name')->nullable(false);
            $table->text('last_name')->nullable(false);
            $table->text('phone')->nullable();
            $table->text('address')->nullable();
            $table->uuid('zone_id')->nullable();
            $table->uuid('branch_id')->nullable();
            $table->text('email')->nullable(false);
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->text('qualification')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('password')->nullable(false);
            $table->text('remember_token')->nullable();
            $table->uuid('tenant_id')->nullable(false);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->uuid('deleted_by')->nullable();
            $table->uuid('created_by')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', static function (Blueprint $table) {
            $table->text('email')->primary();
            $table->text('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', static function (Blueprint $table) {
            $table->text('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->text('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
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
