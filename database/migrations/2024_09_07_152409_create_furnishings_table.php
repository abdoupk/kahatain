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
        Schema::create('furnishings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('television')->nullable();
            $table->text('refrigerator')->nullable();
            $table->text('fireplace')->nullable();
            $table->text('washing_machine')->nullable();
            $table->text('water_heater')->nullable();
            $table->text('oven')->nullable();
            $table->text('wardrobe')->nullable();
            $table->text('cupboard')->nullable();
            $table->text('covers')->nullable();
            $table->text('mattresses')->nullable();
            $table->text('other_furnishings')->nullable();
            $table->uuid('family_id');
            $table->uuid('tenant_id');
            $table->timestamps();

            $table->index(['id'], 'idx_furnishings_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('furnishings');
    }
};
