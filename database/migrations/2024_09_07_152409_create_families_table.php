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
        Schema::create('families', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('name')->index('idx_families_name');
            $table->uuid('zone_id')->index('idx_families_zone_id');
            $table->uuid('branch_id')->nullable();
            $table->text('address');
            $table->json('location')->nullable();
            $table->text('file_number')->nullable();
            $table->date('start_date')->nullable();
            $table->float('income_rate')->nullable();
            $table->float('total_income')->nullable();
            $table->float('difference_before_monthly_sponsorship')->nullable();
            $table->float('difference_after_monthly_sponsorship')->nullable();
            $table->float('monthly_sponsorship_rate')->nullable();
            $table->float('amount_from_association')->nullable();
            $table->float('difference_before_ramadan_sponsorship')->nullable();
            $table->float('ramadan_sponsorship_difference')->nullable();
            $table->string('ramadan_basket_category')->nullable();
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
