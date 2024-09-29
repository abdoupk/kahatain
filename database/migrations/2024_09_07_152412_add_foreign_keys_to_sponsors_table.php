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
        Schema::table('sponsors', function (Blueprint $table) {
            $table->foreign(['created_by'], 'sponsors_created_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['deleted_by'], 'sponsors_deleted_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['family_id'], 'sponsors_family_id_fkey')->references(['id'])->on('families')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'sponsors_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropForeign('sponsors_created_by_fkey');
            $table->dropForeign('sponsors_deleted_by_fkey');
            $table->dropForeign('sponsors_family_id_fkey');
            $table->dropForeign('sponsors_tenant_id_fkey');
        });
    }
};
