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
        Schema::table('lessons', function (Blueprint $table) {
            $table->foreign(['private_school_id'], 'lessons_private_school_id_fkey')->references(['id'])->on('private_schools')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'lessons_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropForeign('lessons_private_school_id_fkey');
            $table->dropForeign('lessons_tenant_id_fkey');
        });
    }
};
