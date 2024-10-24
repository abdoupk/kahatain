<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('benefactors', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->json('location')->nullable();
            $table->uuid('created_by');
            $table->uuid('deleted_by')->nullable();
            $table->uuid('tenant_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
