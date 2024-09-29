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
        Schema::create('sponsor_sponsorship', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sponsor_id')->index('idx_sponsor_sponsorship_sponsor_id');
            $table->text('medical_sponsorship')->nullable();
            $table->text('literacy_lessons')->nullable();
            $table->float('direct_sponsorship')->nullable();
            $table->text('project_support')->nullable();
            $table->uuid('tenant_id')->index('idx_sponsor_sponsorship_tenant_id');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
            $table->timestamp('updated_at')->nullable();

            $table->index(['id'], 'idx_sponsor_sponsorship_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_sponsorship');
    }
};
