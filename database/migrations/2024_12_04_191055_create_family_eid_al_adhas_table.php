<?php

use App\Enums\EidAlAdhaStatus;
use App\Models\Family;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_eid_al_adhas', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->enum('status', array_map(fn ($type) => $type->value, EidAlAdhaStatus::cases()))->nullable();
            $table->foreignIdFor(Family::class)->constrained('families');
            $table->foreignIdFor(\App\Models\User::class, 'updated_by')->constrained('users');
            $table->foreignIdFor(Tenant::class)->constrained('tenants');
            $table->text('note')->nullable();
            $table->integer('year');
            $table->timestamps();
        });
    }
};
