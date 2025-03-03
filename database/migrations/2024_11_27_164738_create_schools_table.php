<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('name');
            $table->foreignIdFor(City::class);
            $table->enum('phase_key', ['primary_education', 'middle_education', 'secondary_education']);
            $table->string('e_id');
            $table->timestamps();
        });
    }
};
