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
        Schema::table('events', function (Blueprint $table) {
            $table->foreign(['created_by'], 'events_created_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['deleted_by'], 'events_deleted_by_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['lesson_id'], 'events_lesson_id_fkey')->references(['id'])->on('lessons')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'events_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_created_by_fkey');
            $table->dropForeign('events_deleted_by_fkey');
            $table->dropForeign('events_lesson_id_fkey');
            $table->dropForeign('events_tenant_id_fkey');
        });
    }
};
