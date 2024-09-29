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
        Schema::create('needs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('demand');
            $table->text('subject');
            $table->text('status');
            $table->text('needable_type');
            $table->uuid('needable_id');
            $table->uuid('tenant_id');
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->uuid('created_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->index(['needable_type', 'needable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('needs');
    }
};
