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
        Schema::create('incomes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('cnr');
            $table->text('cnas');
            $table->text('casnos');
            $table->text('pension');
            $table->text('account');
            $table->text('other_income');
            $table->float('total_income')->nullable();
            $table->uuid('sponsor_id');
            $table->uuid('tenant_id');

            $table->index(['id'], 'idx_incomes_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
