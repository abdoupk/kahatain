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
        Schema::table('academic_achievements', function (Blueprint $table) {
            $table->foreign(['orphan_id'], 'academic_achievements_orphan_id_fkey')->references(['id'])->on('orphans')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'academic_achievements_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_achievements', function (Blueprint $table) {
            $table->dropForeign('academic_achievements_orphan_id_fkey');
            $table->dropForeign('academic_achievements_tenant_id_fkey');
        });
    }
};
