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
            $table->text('television');
            $table->text('refrigerator');
            $table->text('fireplace');
            $table->text('washing_machine');
            $table->text('water_heater');
            $table->text('oven');
            $table->text('wardrobe');
            $table->text('cupboard');
            $table->text('covers');
            $table->text('mattresses');
            $table->text('other_furnishings');
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
