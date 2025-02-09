<?php

use App\Enums\DonationSpecification;
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
        Schema::create('finances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('amount');
            $table->text('description')->nullable();
            $table->timestamp('date');
            $table->foreignIdFor(Tenant::class);
            $table->enum('specification', array_map(fn ($type) => $type->value, DonationSpecification::cases()));
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(\App\Models\User::class, 'created_by');
            $table->foreignIdFor(\App\Models\User::class, 'received_by')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'deleted_by')->nullable();

            $table->index(['id'], 'idx_finances_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
