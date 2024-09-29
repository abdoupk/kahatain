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
        Schema::table('event_occurrences', function (Blueprint $table) {
            $table->foreign(['event_id'], 'event_occurrences_event_id_fkey')->references(['id'])->on('events')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['lesson_id'], 'event_occurrences_lesson_id_fkey')->references(['id'])->on('lessons')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'event_occurrences_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_occurrences', function (Blueprint $table) {
            $table->dropForeign('event_occurrences_event_id_fkey');
            $table->dropForeign('event_occurrences_lesson_id_fkey');
            $table->dropForeign('event_occurrences_tenant_id_fkey');
        });
    }
};
