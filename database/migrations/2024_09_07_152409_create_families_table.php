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
        Schema::create('families', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('name')->index('idx_families_name');
            $table->uuid('zone_id')->index('idx_families_zone_id');
            $table->uuid('branch_id')->nullable();
            $table->text('address');
            $table->json('location')->nullable();
            $table->text('file_number');
            $table->date('start_date');
            $table->float('income_rate')->nullable();
            $table->float('total_income')->nullable();
            $table->uuid('tenant_id')->index('idx_families_tenant_id');
            $table->uuid('created_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id'], 'idx_families_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
