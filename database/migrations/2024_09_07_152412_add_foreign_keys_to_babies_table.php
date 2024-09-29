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
        Schema::table('babies', function (Blueprint $table) {
            $table->foreign(['family_id'], 'babies_family_id_fkey')->references(['id'])->on('families')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['orphan_id'], 'babies_orphan_id_fkey')->references(['id'])->on('orphans')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'babies_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->dropForeign('babies_family_id_fkey');
            $table->dropForeign('babies_orphan_id_fkey');
            $table->dropForeign('babies_tenant_id_fkey');
        });
    }
};
