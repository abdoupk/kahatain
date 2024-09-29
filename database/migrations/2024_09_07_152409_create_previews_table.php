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
        Schema::create('previews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('report');
            $table->date('preview_date');
            $table->text('family_id');
            $table->uuid('tenant_id');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['id'], 'idx_preview_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previews');
    }
};
