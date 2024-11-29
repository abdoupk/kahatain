<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('name');
            $table->string('type');
            $table->string('zone')->nullable();
        });
    }
};
