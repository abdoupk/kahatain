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
        Schema::create('zones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('name');
            $table->text('description');
            $table->geometry('geom')->nullable();
            $table->uuid('tenant_id');
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by');
            $table->uuid('deleted_by')->nullable();

            $table->index(['id'], 'zones_name_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
