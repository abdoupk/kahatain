<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vocational_training_centers', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('arabic_name');
            $table->string('latin_name');
            $table->string('code');
            $table->string('wilaya_code');
            $table->string('e_id');
            $table->timestamps();
        });
    }
};
