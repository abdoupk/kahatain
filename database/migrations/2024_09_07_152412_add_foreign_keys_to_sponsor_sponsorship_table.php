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
        Schema::table('sponsor_sponsorship', function (Blueprint $table) {
            $table->foreign(['sponsor_id'], 'sponsor_sponsorship_sponsor_id_fkey')->references(['id'])->on('sponsors')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'sponsor_sponsorship_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsor_sponsorship', function (Blueprint $table) {
            $table->dropForeign('sponsor_sponsorship_sponsor_id_fkey');
            $table->dropForeign('sponsor_sponsorship_tenant_id_fkey');
        });
    }
};
