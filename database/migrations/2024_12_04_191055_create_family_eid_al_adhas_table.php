<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_eid_al_adhas', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->enum('status', ['sacrificed', 'benefit', 'dont_benefit', 'meat', 'benefactor'])->nullable();
            $table->foreignUuid('family_id')->constrained('families');
            $table->foreignUuid('updated_by')->constrained('users');
            $table->foreignUuid('tenant_id')->constrained('tenants');
            $table->text('note')->nullable();
            $table->boolean('validated')->default(false);
            $table->integer('year');
            $table->timestamps();
        });
    }
};
