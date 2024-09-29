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
        Schema::table('event_occurrence_orphan', function (Blueprint $table) {
            $table->foreign(['event_occurrence_id'], 'event_occurrence_orphan_event_occurrence_id_fkey')->references(['id'])->on('event_occurrences')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['lesson_id'], 'event_occurrence_orphan_lesson_id_fkey')->references(['id'])->on('lessons')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['orphan_id'], 'event_occurrence_orphan_orphan_id_fkey')->references(['id'])->on('orphans')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tenant_id'], 'event_occurrence_orphan_tenant_id_fkey')->references(['id'])->on('tenants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_occurrence_orphan', function (Blueprint $table) {
            $table->dropForeign('event_occurrence_orphan_event_occurrence_id_fkey');
            $table->dropForeign('event_occurrence_orphan_lesson_id_fkey');
            $table->dropForeign('event_occurrence_orphan_orphan_id_fkey');
            $table->dropForeign('event_occurrence_orphan_tenant_id_fkey');
        });
    }
};
