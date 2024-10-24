<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('committee_user', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('committee_id')->references('id')->on('committees')->onDelete('cascade');
            $table->foreignUuid('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }
};
