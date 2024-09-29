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
        Schema::table('furnishings', function (Blueprint $table) {
            $table->foreign(['family_id'], 'furnishings_family_id_fkey')->references(['id'])->on('families')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'furnishings_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('furnishings', function (Blueprint $table) {
            $table->dropForeign('furnishings_family_id_fkey');
            $table->dropForeign('furnishings_tenant_id_fkey');
        });
    }
};
