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
        Schema::create('housings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('name')->index('idx_housings_name');
            $table->text('value')->nullable();
            $table->text('housing_receipt_number')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->text('other_properties')->nullable();
            $table->foreignIdFor(Family::class);
            $table->foreignIdFor(Tenant::class);
            $table->timestamps();

            $table->index(['id'], 'idx_housings_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housings');
    }
};
