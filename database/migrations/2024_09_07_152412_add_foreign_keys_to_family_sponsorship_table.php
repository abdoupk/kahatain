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
        Schema::table('family_sponsorship', function (Blueprint $table) {
            $table->foreign(['family_id'], 'family_sponsorship_family_id_fkey')->references(['id'])->on('families')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'family_sponsorship_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_sponsorship', function (Blueprint $table) {
            $table->dropForeign('family_sponsorship_family_id_fkey');
            $table->dropForeign('family_sponsorship_tenant_id_fkey');
        });
    }
};
