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
        Schema::create('event_occurrence_orphan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('event_occurrence_id');
            $table->uuid('lesson_id');
            $table->uuid('orphan_id');
            $table->uuid('tenant_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_occurrence_orphan');
    }
};
