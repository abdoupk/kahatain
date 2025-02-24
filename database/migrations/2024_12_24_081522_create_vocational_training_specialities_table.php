<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vocational_training_specialities', function (Blueprint $table) {
            $table->id();
            $table->string('speciality');
            $table->string('division');
        });
    }
};
