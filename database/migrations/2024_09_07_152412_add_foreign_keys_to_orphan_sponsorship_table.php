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
        Schema::table('orphan_sponsorship', function (Blueprint $table) {
            $table->foreign(['orphan_id'], 'orphan_sponsorship_orphan_id_fkey')->references(['id'])->on('orphans')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'orphan_sponsorship_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orphan_sponsorship', function (Blueprint $table) {
            $table->dropForeign('orphan_sponsorship_orphan_id_fkey');
            $table->dropForeign('orphan_sponsorship_tenant_id_fkey');
        });
    }
};
