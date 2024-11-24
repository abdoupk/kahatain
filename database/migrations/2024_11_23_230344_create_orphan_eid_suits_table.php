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
            $table->string('note');
            $table->string('clothes_shop_name');
            $table->string('clothes_shop_phone_number');
            $table->string('shoes_shop_name');
            $table->string('shoes_shop_phone_number');
            $table->foreignIdFor(\App\Models\User::class);
            $table->json('location')->nullable();
            $table->timestamps();
        });
    }
};
