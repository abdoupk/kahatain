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
        Schema::create('inventories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('name');
            $table->integer('qty');
            $table->enum('unit', ['kg', 'liter', 'piece']);
            $table->text('type')->nullable();
            $table->text('note')->nullable();
            $table->integer('qty_for_family')->nullable();
            $table->uuid('tenant_id');
            $table->timestamp('created_at')->nullable();
            $table->uuid('created_by');
            $table->uuid('deleted_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
