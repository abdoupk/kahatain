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
        Schema::create('spouses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('first_name');
            $table->text('last_name');
            $table->date('birth_date')->index('idx_spouses_birth_date');
            $table->date('death_date')->index('idx_spouses_death_date');
            $table->text('function')->index('idx_spouses_function');
            $table->float('income')->nullable()->index('idx_spouses_income');
            $table->uuid('family_id')->index('idx_spouses_family_id');
            $table->uuid('tenant_id')->index('idx_spouses_tenant_id');
            $table->timestamps();

            $table->index(['id'], 'idx_spouses_id');
            $table->index(['first_name', 'last_name'], 'idx_spouses_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spouses');
    }
};
