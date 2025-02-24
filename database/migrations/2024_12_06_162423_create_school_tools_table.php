<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_tools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('min_price')->nullable();
            $table->float('max_price')->nullable();
            $table->timestamps();
        });
    }
};
