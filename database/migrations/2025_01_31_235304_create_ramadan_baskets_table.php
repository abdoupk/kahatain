<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ramadan_baskets', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->integer('qty_for_family');
            $table->boolean('status');
            $table->foreignUuid('inventory_id')->constrained('inventories');
            $table->foreignUuid('tenant_id')->constrained('tenants');
            $table->timestamps();

            $table->unique(['inventory_id']);
        });
    }
};
