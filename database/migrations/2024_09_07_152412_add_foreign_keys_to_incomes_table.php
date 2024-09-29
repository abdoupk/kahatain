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
        Schema::table('incomes', function (Blueprint $table) {
            $table->foreign(['sponsor_id'], 'incomes_sponsor_id_fkey')->references(['id'])->on('sponsors')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'incomes_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropForeign('incomes_sponsor_id_fkey');
            $table->dropForeign('incomes_tenant_id_fkey');
        });
    }
};
