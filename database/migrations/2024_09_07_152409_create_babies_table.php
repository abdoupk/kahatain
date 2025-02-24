<?php

use App\Models\Family;
use App\Models\Inventory;
use App\Models\Orphan;
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
        Schema::create('babies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('baby_milk_quantity')->nullable();
            $table->foreignIdFor(Inventory::class, 'baby_milk_type')->nullable();
            $table->integer('diapers_quantity')->nullable();
            $table->foreignIdFor(Inventory::class, 'diapers_type')->nullable();
            $table->foreignIdFor(Orphan::class);
            $table->foreignIdFor(Family::class);
            $table->foreignIdFor(Tenant::class);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id']);
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
