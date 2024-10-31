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
        Schema::create('second_sponsors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('degree_of_kinship')->nullable();
            $table->text('phone_number')->nullable()->index('idx_second_sponsors_phone_number');
            $table->text('address')->nullable()->index('idx_second_sponsors_address');
            $table->float('income')->nullable()->index('idx_second_sponsors_income');
            $table->uuid('family_id')->nullable()->index('idx_second_sponsors_family_id');
            $table->uuid('tenant_id')->index('idx_second_sponsors_tenant_id');
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
