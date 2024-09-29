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
        Schema::create('family_sponsorship', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('family_id')->index('idx_family_sponsorship_family_id');
            $table->text('monthly_allowance')->nullable();
            $table->text('ramadan_basket')->nullable();
            $table->text('zakat')->nullable();
            $table->text('housing_assistance')->nullable();
            $table->text('eid_al_adha')->nullable();
            $table->uuid('tenant_id')->index('idx_family_sponsorship_tenant_id');
            $table->timestamp('created_at')->nullable();
            $table->softDeletes();
            $table->timestamp('updated_at')->nullable();

            $table->index(['id'], 'idx_family_sponsorship_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_sponsorship');
    }
};
