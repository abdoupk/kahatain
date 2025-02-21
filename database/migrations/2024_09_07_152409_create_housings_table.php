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
            $table->string('name')->index('idx_housings_name');
            $table->string('value')->nullable();
            $table->string('housing_receipt_number')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->text('other_properties')->nullable();
            $table->foreignIdFor(Family::class);
            $table->foreignIdFor(Tenant::class);
            $table->timestamps();

            $table->index(['id'], 'idx_housings_id');

            $table->index(['tenant_id']);
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
