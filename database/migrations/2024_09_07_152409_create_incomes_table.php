<?php

use App\Models\Sponsor;
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
        Schema::create('incomes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('cnr')->nullable();
            $table->boolean('cnas')->nullable();
            $table->boolean('casnos')->nullable();
            $table->boolean('pension')->nullable();
            $table->json('account');
            $table->float('other_income')->nullable();
            $table->float('total_income')->nullable();
            $table->foreignIdFor(Sponsor::class);
            $table->foreignIdFor(Tenant::class);

            $table->index(['id'], 'idx_incomes_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
