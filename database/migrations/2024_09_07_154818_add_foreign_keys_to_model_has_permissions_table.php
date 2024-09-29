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
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->foreign(['permission_id'], 'model_has_permissions_permission_id_fkey')->references(['uuid'])->on('permissions')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'model_has_permissions_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropForeign('model_has_permissions_permission_id_fkey');
            $table->dropForeign('model_has_permissions_tenant_id_fkey');
        });
    }
};
