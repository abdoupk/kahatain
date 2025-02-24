<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('en_name')->index();
            $table->string('ar_name')->index();
            $table->string('fr_name')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
