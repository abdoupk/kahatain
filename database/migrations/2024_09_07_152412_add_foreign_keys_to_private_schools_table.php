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
        Schema::table('private_schools', function (Blueprint $table) {
            $table->foreign(['created_by'], 'private_schools_created_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['deleted_by'], 'private_schools_deleted_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['tenant_id'], 'private_schools_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('private_schools', function (Blueprint $table) {
            $table->dropForeign('private_schools_created_by_fkey');
            $table->dropForeign('private_schools_deleted_by_fkey');
            $table->dropForeign('private_schools_tenant_id_fkey');
        });
    }
};
