<?php

use App\Models\Family;
use App\Models\Tenant;
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
            $table->jsonb('television')->nullable();
            $table->jsonb('refrigerator')->nullable();
            $table->jsonb('fireplace')->nullable();
            $table->jsonb('washing_machine')->nullable();
            $table->jsonb('water_heater')->nullable();
            $table->jsonb('oven')->nullable();
            $table->jsonb('wardrobe')->nullable();
            $table->jsonb('cupboard')->nullable();
            $table->jsonb('covers')->nullable();
            $table->jsonb('mattresses')->nullable();
            $table->text('other_furnishings')->nullable();
            $table->foreignIdFor(Family::class);
            $table->foreignIdFor(Tenant::class);
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
