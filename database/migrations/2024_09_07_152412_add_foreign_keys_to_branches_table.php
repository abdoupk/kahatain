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
        Schema::table('branches', function (Blueprint $table) {
            $table->foreign(['city_id'], 'branches_city_id_fkey')->references(['id'])->on('cities')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['created_by'], 'branches_created_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['deleted_by'], 'branches_deleted_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['president_id'], 'branches_president_id_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['tenant_id'], 'branches_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropForeign('branches_city_id_fkey');
            $table->dropForeign('branches_created_by_fkey');
            $table->dropForeign('branches_deleted_by_fkey');
            $table->dropForeign('branches_president_id_fkey');
            $table->dropForeign('branches_tenant_id_fkey');
        });
    }
};
