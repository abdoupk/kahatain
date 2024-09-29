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
        Schema::create('babies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('baby_milk_quantity')->nullable();
            $table->uuid('baby_milk_type')->nullable();
            $table->integer('diapers_quantity')->nullable();
            $table->uuid('diapers_type')->nullable();
            $table->uuid('orphan_id');
            $table->uuid('family_id');
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
        Schema::dropIfExists('babies');
    }
};
