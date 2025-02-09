<?php

use App\Enums\EidAlAdhaStatus;
use App\Models\Branch;
use App\Models\Tenant;
use App\Models\Zone;
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
        Schema::create('families', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->index('idx_families_name');
            $table->foreignIdFor(Zone::class)->index('idx_families_zone_id')->nullable();
            $table->foreignIdFor(Branch::class)->nullable();
            $table->string('address');
            $table->json('location')->nullable();
            $table->string('file_number')->nullable();
            $table->date('start_date')->nullable();
            $table->float('income_rate')->nullable();
            $table->float('total_income')->nullable();
            $table->float('difference_before_monthly_sponsorship')->nullable();
            $table->float('difference_after_monthly_sponsorship')->nullable();
            $table->float('monthly_sponsorship_rate')->nullable();
            $table->float('amount_from_association')->nullable();
            $table->float('ramadan_sponsorship_difference')->nullable();
            $table->string('ramadan_basket_category')->nullable();
            $table->foreignIdFor(Tenant::class)->index('idx_families_tenant_id');
            $table->float('aggregate_zakat_benefit')->default(0);
            $table->mediumInteger('aggregate_white_meat_benefit')->default(0);
            $table->mediumInteger('aggregate_red_meat_benefit')->default(0);
            $table->enum('eid_al_adha_status', array_map(fn ($type) => $type->value, EidAlAdhaStatus::cases()))->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'created_by')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'deleted_by')->nullable();
            $table->timestamps();
            $table->text('deletion_reason')->nullable();
            $table->softDeletes();

            $table->index(['id'], 'idx_families_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
