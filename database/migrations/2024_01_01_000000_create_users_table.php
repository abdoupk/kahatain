<?php

use App\Models\AcademicLevel;
use App\Models\Branch;
use App\Models\Tenant;
use App\Models\Zone;
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
        Schema::create('users', static function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->json('location')->nullable();
            $table->string('workplace')->nullable();
            $table->string('function')->nullable();
            $table->foreignIdFor(Zone::class)->nullable();
            $table->foreignIdFor(Branch::class)->nullable();
            $table->text('email')->nullable(false);
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->text('qualification')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(false);
            $table->string('remember_token')->nullable();
            $table->foreignIdFor(Tenant::class)->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignIdFor(AcademicLevel::class)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'deleted_by')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'created_by')->nullable();
            $table->softDeletes();

            $table->index(['tenant_id']);
        });

        Schema::create('password_reset_tokens', static function (Blueprint $table) {
            $table->text('email')->primary();
            $table->text('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', static function (Blueprint $table) {
            $table->text('id')->primary();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->index();
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
