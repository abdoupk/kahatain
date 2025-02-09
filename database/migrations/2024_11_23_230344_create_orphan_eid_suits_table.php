<?php

use App\Models\Orphan;
use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orphan_eid_suits', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignIdFor(Tenant::class);
            $table->foreignIdFor(Orphan::class);
            $table->string('note')->nullable();
            $table->string('clothes_shop_name')->nullable();
            $table->string('clothes_shop_phone_number')->nullable();
            $table->string('shoes_shop_name')->nullable();
            $table->string('shoes_shop_phone_number')->nullable();
            $table->foreignIdFor(\App\Models\User::class)->nullable();
            $table->string('shoes_shop_address')->nullable();
            $table->json('shoes_shop_location')->nullable();
            $table->string('clothes_shop_address')->nullable();
            $table->json('clothes_shop_location')->nullable();
            $table->boolean('clothes_completed')->nullable();
            $table->boolean('shoes_completed')->nullable();
            $table->boolean('pants_completed')->nullable();
            $table->timestamps();
        });
    }
};
