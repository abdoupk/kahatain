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
        Schema::create('second_sponsors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('degree_of_kinship')->nullable();
            $table->string('phone_number')->nullable()->index('idx_second_sponsors_phone_number');
            $table->string('address')->nullable()->index('idx_second_sponsors_address');
            $table->float('income')->nullable()->index('idx_second_sponsors_income');
            $table->foreignIdFor(Family::class)->nullable()->index('idx_second_sponsors_family_id');
            $table->foreignIdFor(Tenant::class)->index('idx_second_sponsors_tenant_id');
            $table->boolean('with_family')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['id'], 'idx_second_sponsors_id');
            $table->index(['first_name', 'last_name'], 'idx_second_sponsors_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('second_sponsors');
    }
};
