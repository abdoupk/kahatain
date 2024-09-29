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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('title');
            $table->uuid('lesson_id');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->text('frequency')->nullable();
            $table->integer('interval')->nullable();
            $table->date('until')->nullable();
            $table->text('color')->nullable();
            $table->uuid('tenant_id');
            $table->softDeletes();
            $table->timestamps();
            $table->uuid('created_by');
            $table->uuid('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
