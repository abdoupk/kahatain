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
        Schema::create('finances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('amount');
            $table->text('description')->nullable();
            $table->timestamp('date');
            $table->uuid('tenant_id');
            $table->enum('specification', DONATION_SPECIFICATION);
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by');
            $table->uuid('received_by');
            $table->uuid('deleted_by')->nullable();

            $table->index(['id'], 'idx_finances_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
