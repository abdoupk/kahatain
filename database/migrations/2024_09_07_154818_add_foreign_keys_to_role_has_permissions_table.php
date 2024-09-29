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
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->foreign(['permission_id'], 'role_has_permissions_permission_id_fkey')->references(['uuid'])->on('permissions')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['role_id'], 'role_has_permissions_role_id_fkey')->references(['uuid'])->on('roles')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->dropForeign('role_has_permissions_permission_id_fkey');
            $table->dropForeign('role_has_permissions_role_id_fkey');
        });
    }
};
