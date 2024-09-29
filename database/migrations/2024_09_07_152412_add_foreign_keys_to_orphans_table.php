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
        Schema::table('orphans', function (Blueprint $table) {
            $table->foreign(['created_by'], 'orphans_created_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['deleted_by'], 'orphans_deleted_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['family_id'], 'orphans_family_id_fkey')->references(['id'])->on('families')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['sponsor_id'], 'orphans_sponsor_id_fkey')->references(['id'])->on('sponsors')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'orphans_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orphans', function (Blueprint $table) {
            $table->dropForeign('orphans_created_by_fkey');
            $table->dropForeign('orphans_deleted_by_fkey');
            $table->dropForeign('orphans_family_id_fkey');
            $table->dropForeign('orphans_sponsor_id_fkey');
            $table->dropForeign('orphans_tenant_id_fkey');
        });
    }
};
