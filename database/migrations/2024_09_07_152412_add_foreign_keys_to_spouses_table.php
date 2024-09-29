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
        Schema::table('spouses', function (Blueprint $table) {
            $table->foreign(['family_id'], 'spouses_family_id_fkey')->references(['id'])->on('families')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'spouses_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spouses', function (Blueprint $table) {
            $table->dropForeign('spouses_family_id_fkey');
            $table->dropForeign('spouses_tenant_id_fkey');
        });
    }
};
